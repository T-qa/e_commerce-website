<?php
require_once "./classes/user.php";
$user = new User();
if (isset($_GET['delete_id_customer'])) {
    $user->removeUser($_GET['delete_id_customer']);
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
    <?php
    include 'nav-bar.php';
    ?>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rows = $user->fetch();
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        echo '
        <tr>
          <td scope="row">' . $row['user_id'] . '</td>
          <td>' . $row['username'] . '</td>
          <td>' . $row['firstName'] . '</td>
          <td>' . $row['lastName'] . '</td>
          <td>' . $row['phone'] . '</td>
          <td>' . $row['email'] . '</td>
          <td>
          <button class = "btn btn-danger"><a class ="text-light text-decoration-none" href="user-view.php?delete_id_customer=' . $row['user_id'] . '">Delete</a></button>
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
</body>

</html>
<?php
include './config/script.php'
?>