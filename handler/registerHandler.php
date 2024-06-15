<?php
require_once(__DIR__ . "/../config/dbconfig.php");
require_once(__DIR__ . "/../classes/user.php");
require_once(__DIR__ . "/../classes/admin.php");

class RegisterHandler
{
    private $user;
    public function register($username, $email, $password, $confirm)
    {
        $user = new User();
        $DB = new DBConnect();
        $checkUsername = $user->checkUsername($username);
        $checkEmail = $user->checkExistEmail($email);
        if ($password == $confirm) {
            if ($checkUsername) {
                $_SESSION['status'] = 'This username has already existed';
                $_SESSION['status_code'] = 'error';
            } else if ($checkEmail) {
                $_SESSION['status'] = 'This email has already been used';
                $_SESSION['status_code'] = 'error';
            } else {
                $user->registerUser($username, $email, $password);
            }
        } else {
            $_SESSION['status'] = 'The Confirmation Password is Wrong';
            $_SESSION['status_code'] = 'error';
        }
    }
    public function registerAdmin($username, $password, $confirm)
    {
        $user = new Admin();
        $DB = new DBConnect();
        $checkUsername = $user->checkUsername($username);
        if ($password == $confirm) {
            if ($checkUsername) {
                $_SESSION['status'] = 'This username has already existed';
                $_SESSION['status_code'] = 'error';
            } else {
                $user->registerAdmin($username, $password);
            }
        } else {
            $_SESSION['status'] = 'The Confirmation Password is Wrong';
            $_SESSION['status_code'] = 'error';
        }
    }
}