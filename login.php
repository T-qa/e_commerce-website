<!DOCTYPE html>
<html lang="en">
<?php
require "./classes/loginHandler.php";
$_SESSION['username'] = '';
$login = new LoginHandler();
if (isset($_POST['submit'])) {
  $login->checkLogin($_POST['username'], md5($_POST['pwd']), 'user');
}
?>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <title>Login</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/fonts/ionicons.min.css" />
  <link rel="stylesheet" href="assets/css/Login-Form-Clean.css" />
  <link rel="stylesheet" href="assets/css/styles.css" />
  <style>
    .disclaimer {
      display: none;
    }
  </style>
</head>

<body style="background: rgb(177, 213, 224)">
  <section class="login" style="background: rgb(177, 213, 224)">
    <form method="post" style="
          border-radius: 13px;
          border-color: var(--bs-gray);
          background: rgb(205, 213, 221);
        ">
      <h2 class="visually-hidden">Login Form</h2>
      <div class="illustration">
        <i>
          <img src="./assets/image/basket-cart-icon-27.png" class="rounded mx-auto d-block" alt="...">
        </i>
      </div>
      <div class="mb-3">
        <input class="form-control" type="text" id="email-field" name="username" placeholder="Username" style="border-radius: 4px" required />
      </div>
      <div class="mb-3">
        <input class="form-control" type="password" id="password-field" name="pwd" placeholder="Password" style="border-radius: 4px" required />
      </div>
      <div class="mb-3">
        <button class="btn btn-primary d-block w-100" name="submit">
          Log In
        </button>
      </div>
      <a class="forgot" href="register.php">Don't have an account?</a>
      <a class="forgot" href="login-admin.php" style="font-weight: bold;margin-top: 10px;">
        Admin Login
      </a>
    </form>
  </section>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
<?php
include './config/script.php'
?>