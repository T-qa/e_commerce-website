<?php
require_once('./classes/user.php');
require_once('./config/url.php');
$url = new URL();
$user = new User();
if (isset($_POST['save-changes'])) {
    $user->updateProfile($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phone'], $_SESSION['username']);
}

if (isset($_POST['change_password'])) {
    $username = $_SESSION['username'];
    $current_pass = md5($_POST['current_pass']);
    $new_password = md5($_POST['new_pass']);
    $conf_new_pwd = md5($_POST['conf_new_pass']);
    $user->changePassword($current_pass, $new_password, $conf_new_pwd, $username);
}

?>
<!DOCTYPE html>
<html lang="en">``

<head>
    <base href=<?php echo $url->getUrl() ?>>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/sidebar.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Adamina&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata&amp;display=swap" />
    <title>Profile</title>
</head>

<body>
    <header>
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="homepage" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-building fa-fw me-3"></i><span>Homepage</span></a>
                    <a href="profile-view.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-chart-bar fa-fw me-3"></i><span>Profile</span></a>
                    <a href="view-order-user.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-globe fa-fw me-3"></i><span>Orders</span></a>
                    <a href="login.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-building fa-fw me-3"></i><span>Logout</span></a>

                </div>
            </div>
        </nav>
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#">
                    <h1>Profile</h1>
                </a>
                <!-- <form class="d-none d-md-flex input-group w-auto my-auto">
                    <input autocomplete="off" type="search" class="form-control rounded" placeholder='Search (ctrl + "/" to focus)' style="min-width: 225px;" />
                    <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
                </form> -->
            </div>
        </nav>
    </header>
    <!--change password modal-->
    <form method="POST">
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="edit_id" id="edit_id">
                            <label for="descInput1">Current Password</label>
                            <input type="password" class="form-control" id="descInput1" placeholder="Enter Current Password" name="current_pass" required />
                            <label for="descInput1">New Password</label>
                            <input type="password" class="form-control" id="descInput1" placeholder="Enter New Password" name="new_pass" required />
                            <label for="descInput1">Confirmed New Password</label>
                            <input type="password" class="form-control" id="descInput1" placeholder="Confirmed New Password" name="conf_new_pass" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="change_password">Change</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--Main layout-->
    <main style="margin-top: 58px;margin-left:50px">
        <div class="container pt-4"></div>
        <form method="POST">
            <form class="container col-8 my-5 br-2 rounded">
                <div class="row g-3">
                    <div class="col-8">
                        <h4>Profile Settings</h4>
                        <?php
                        $rows = $user->fetchByUsername($_SESSION['username']);
                        if (!empty($rows)) {
                            foreach ($rows as $row) {
                                echo '<div class="row">
                            <div class="col-4">
                                <label class="form-label" for="lastname">Username</label>
                                <input type="text" name="user_name" value="' . $_SESSION['username'] . '" class="form-control" readonly>
                            </div>
                            <div class="col-4">
                                <label class="form-label" for="firstname">First Name</label>
                                <input type="text" name="firstname" value="' . $row['firstName'] . '" class="form-control" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label" for="lastname">Last name</label>
                                <input type="text" name="lastname" value ="' . $row['lastName'] . '" class="form-control" required>
                            </div>
                            <div class="col-5">
                                <label class="form-label" for="city">Password</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" aria-describedby="basic-addon2"  readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">Change</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label" for="district">Email</label>
                                <input type="email" name="email" value="' . $row['email'] . '" class="form-control">
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="ward">Phone</label>
                                <input type="text" name="phone" value ="' . $row['phone'] . '" class="form-control" required>
                            </div>
                        </div>';
                            }
                        }
                        ?>
                        <hr>
                        <button type="submit" class="btn btn-primary btn-block mb-4" name="save-changes">Save Changes</button>
                    </div>
                </div>
            </form>
        </form>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</html>
<?php
include "./config/script.php";
?>