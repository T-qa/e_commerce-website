<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class User
{
    public function removeUser($id)
    {
        $DB = new DBConnect();
        $sql = "delete from user where user_id=$id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            header("refresh:0.5;url=user-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }

    public function checkExistEmail($email)
    {
        $DB = new DBConnect();
        $sql =  $sql = "SELECT * FROM user WHERE email ='$email'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLogin($username, $password)
    {
        $DB = new DBConnect();
        $sql = "SELECT * FROM user WHERE username ='$username' AND password ='$password'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function checkUsername($username)
    {
        $DB = new DBConnect();
        $sql = "SELECT * FROM user WHERE username ='$username'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function registerUser($username, $email, $password)
    {
        $DB = new DBConnect();
        $sql = "INSERT INTO user(username, email, password) VALUES ('$username', '$email', '$password')";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Register Successfully';
        } else {
            $_SESSION['status'] = 'Register Unsuccessfully';
            $_SESSION['status_code'] = 'error';
        }
    }
    public function updateProfile($fname, $lname, $email, $phone, $username)
    {
        $DB = new DBConnect();
        $sql = "UPDATE user SET firstName ='$fname', lastName='$lname', email ='$email',phone = '$phone' WHERE username ='$username'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
        }
        header("refresh:1.5;url=profile-view.php");
    }
    public function changePassword($current_pass, $new_password, $conf_new_pwd, $username)
    {
        $DB = new DBConnect();
        $user = new User();
        $rows = $user->fetchByUsername($username);
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $password = $row['password'];
                if (strcmp($password, $current_pass) == 0 && strcmp($new_password, $conf_new_pwd) == 0) {
                    $sql2 = "UPDATE user SET password ='$new_password' WHERE username ='$username'";
                    $result2 = mysqli_query($DB->connect(), $sql2);
                    if ($result2) {
                        $_SESSION['status_code'] = 'success';
                        $_SESSION['status'] = 'Change Successfully';
                        header("refresh:1.5;url=profile-view.php");
                    }
                } else if ($new_password != $conf_new_pwd) {
                    $_SESSION['status_code'] = 'error';
                    $_SESSION['status'] = 'The new password doesn\'t match';
                    header("refresh:1.5;url=profile.php");
                } else {
                    $_SESSION['status_code'] = 'error';
                    $_SESSION['status'] = 'The current password is invalid';
                    header("refresh:1.5;url=profile-view.php");
                }
            }
        }
    }
    public function fetch()
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT * FROM user";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function fetchByUsername($username)
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}