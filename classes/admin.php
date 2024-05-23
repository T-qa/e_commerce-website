<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Admin
{
    public function addAdmin($name, $password, $conf)
    {
        if ($password == $conf) {
            $DB = new DBConnect();
            $sql = "INSERT INTO admin(username, password) VALUES ('$name','$password')";
            $result = mysqli_query($DB->connect(), $sql);
            if ($result) {
                $_SESSION['status_code'] = 'success';
                $_SESSION['status'] = 'Add Successfully';
                header("refresh:1.5;url=admin-view.php");
            } else {
                die(mysqli_error($DB->connect()));
            }
        } else {
            $_SESSION['status_code'] = 'error';
            $_SESSION['status'] = 'Confirmed Password is incorrect';
        }
    }

    public function checkLogin($username, $password)
    {
        $DB = new DBConnect();
        $sql = "SELECT * FROM admin WHERE username ='$username' AND password ='$password'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function updateAdmin($id, $name, $password)
    {
        $DB = new DBConnect();
        $sql = "UPDATE admin SET username='$name', password ='$password' WHERE admin_id ='$id'";
        $query = mysqli_query($DB->connect(), $sql);
        if ($query) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
            header("refresh:1.5;url=admin-view.php");
        } else {
            die(mysqli_error($DB->connect()));
        }
    }

    public function removeAdmin($id)
    {
        $DB = new DBConnect();
        $sql = "delete from admin where admin_id=$id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            header("refresh:0.5;url=admin-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }
    public function fetchByUsername($username)
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT * FROM admin WHERE username='$username'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function fetch()
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT * FROM admin";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}