<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Category
{


    public function addCategory($name, $desc)
    {
        $DB = new DBConnect();
        $sql = "INSERT INTO category(name, description) VALUES ('$name','$desc')";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Add Successfully';
            header("refresh:0.5;url=category-view.php");
        } else {
            die(mysqli_error($DB->connect()));
        }
    }

    public function updateCategory($id, $name, $desc)
    {
        $DB = new DBConnect();
        $sql = "UPDATE category SET name='$name', description ='$desc' WHERE id = $id";
        $query = mysqli_query($DB->connect(), $sql);
        if ($query) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
            header("refresh:1.5;url=category-view.php");
        }
    }

    public function removeCategory($id)
    {
        $DB = new DBConnect();
        $sql = "delete from category where id=$id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            header("refresh:0.5;url=category-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }
    public function fetch()
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT * FROM category";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function fetchByID($id)
    {
        $id = str_replace("'", "", str_replace("/", "", $id));
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT * FROM category WHERE id = $id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}