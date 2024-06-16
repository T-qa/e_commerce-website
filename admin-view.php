<?php
require_once "./classes/admin.php";
$admin = new Admin();
if (isset($_POST['submit'])) {
    $admin->addAdmin($_POST['admin_username'], md5($_POST['admin_password']), md5($_POST['admin_conf-pass']));
}

if (isset($_POST['submit_update'])) {
    $admin->updateAdmin($_POST['edit_id'], $_POST['admin_username_update'], md5($_POST['admin_password_update']));
}
if (isset($_GET['delete_id_admin'])) {
    $admin->removeAdmin($_GET['delete_id_admin']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Adamina&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata&amp;display=swap" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
</head>
<script src="/static/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<body style="font-family: Alata, sans-serif">
    <!-- Nav-bar -->
    <?php
    include 'nav-bar.php';
    ?>
    <!-- Modal for Insert -->
    <form method="POST">
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nameInput1">Username</label>
                            <input type="text" class="form-control" id="nameInput1" placeholder="Enter Name" name="admin_username" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput1">Password</label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter Password" name="admin_password" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput1">Confirmed Password</label>
                            <input type="text" class="form-control" id="" placeholder="Confirmed Password" name="admin_conf-pass" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Button trigger modal -->
    <div class="col text-center" style="margin-top: 10px;margin-bottom: 16px;"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
            Add Admin
        </button>
    </div>
    <!-- Modal for update -->
    <form method="POST">
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Update Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="edit_id" id="edit_id">
                            <label for="nameInput2">Username</label>
                            <input type="text" class="form-control" id="unameField" placeholder="Enter Name" name="admin_username_update" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Admin Password</label>
                            <input type="text" class="form-control" id="descInput2" placeholder="Enter Password" name="admin_password_update" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_update">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rows = $admin->fetch();
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        echo '
            <tr>
          <td scope="row">' . $row['admin_id'] . '</td>
          <td>' . $row['username'] . '</td>
          <td>' . $row['password'] . '</td>
          <td>
          <button class = "btn btn-primary edit_btn">Edit</button>
          <button class = "btn btn-danger"><a class ="text-light text-decoration-none" href="admin-view.php?delete_id_admin=' . $row['admin_id'] . '">Delete</a></button>
          </td>
        </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit_btn').click(function() {

                $('#exampleModal2').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
                console.log(data);
                $('#edit_id').val(data[0]);
                $('#unameField').val(data[1]);
            });
        });
    </script>
</body>

</html>

<?php
include './config/script.php'
?>