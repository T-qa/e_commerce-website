<?php
require_once(__DIR__ . "/../config/dbconfig.php");
require_once(__DIR__ . "/../classes/user.php");

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
}