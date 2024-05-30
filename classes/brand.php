<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Brand
{
    private $name;
    private $description;

    public function addBrand($name, $desc)
    {
        $DB = new DBConnect();
        $sql = "INSERT INTO brand(name, description) VALUES ('$name','$desc')";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Add Successfully';
            header("refresh:1.5;url=brand-view.php");
        } else {
            die(mysqli_error($DB->connect()));
        }
    }

    public function updateBrand($id, $name, $desc)
    {
        $DB = new DBConnect();
        $sql = "UPDATE brand SET name='$name', description ='$desc' WHERE id ='$id'";
        $query = mysqli_query($DB->connect(), $sql);
        if ($query) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
            header("refresh:1.5;url=brand-view.php");
        }
    }

    public function removeBrand($id)
    {
        $DB = new DBConnect();
        $sql = "delete from brand where id=$id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            header("refresh:0.5;url=brand-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }
    public function fetch()
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT * FROM brand";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}