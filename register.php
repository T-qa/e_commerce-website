<?php
require "./classes/registerHandler.php";
if (isset($_POST['submit'])) {
    $register = new RegisterHandler();
    $register->register($_POST['username'], $_POST['email'], md5($_POST['password']), md5($_POST['pass_conf']));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Register.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .disclaimer {
            display: none;
        }
    </style>
</head>

<body style="background: rgb(177,213,224);">
    <section class="login-clean" style="background: rgb(177,213,224);">
        <form method="post" style="border-radius: 13px;border-color: var(--bs-gray);background: rgb(205,213,221);">
            <h2 class="visually-hidden">Sign Up</h2>
            <div class="illustration">
                <i>
                    <img src="./assets/image/logo.png" class="rounded mx-auto d-block" alt="..." width=200px height=200px;>
                </i>
            </div>
            <div class="mb-3"><input class="form-control" type="text" id="user-field" name="username" placeholder="Username" style="border-radius: 4px;" required></div>
            <div class="mb-3"><input class="form-control" type="email" id="email-field" name="email" placeholder="Email" style="border-radius: 4px;" required></div>
            <div class="mb-3"><input class="form-control" type="password" id="password-field" name="password" placeholder="Password" style="border-radius: 4px;" required></div>
            <div class="mb-3"><input class=" form-control" type="password" id="conf_pass" name="pass_conf" placeholder="Confirmed Password" style="border-radius: 4px;" required></div>
            <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" name="submit">Sign Up</button></div>
            <a class="forgot" href="login.php">Already have an account?</a>
        </form>

    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

<?php
include './config/script.php'
?>