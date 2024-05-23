<?php
require_once(__DIR__ . "/../config/dbconfig.php");
require_once(__DIR__ . "/../classes/user.php");
require_once(__DIR__ . "/../classes/admin.php");

class LoginHandler extends DBConnect
{
    private $user;
    private $admin;
    public function checkLogin($username, $password, $table)
    {
        $DB = new DBConnect();
        $user = new User();
        $admin = new Admin();
        $username = mysqli_real_escape_string($DB->connect(), $username);

        if ($user->checkLogin($username, $password) == true && $table == 'user') {
            $_SESSION['username'] = $username;
            header('Location: homepage');
        } else if ($admin->checkLogin($username, $password) == true && $table == 'admin') {
            $_SESSION['username_admin'] = $username;
            header('Location: category-view.php');
        } else {
            $_SESSION['status_code'] = 'error';
            $_SESSION['status'] = 'The Username or Password is Wrong';
        }
    }
}