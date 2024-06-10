<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Wishlist
{
    public function checkAdded($id, $username)
    {
        $id = str_replace("'", "", str_replace("/", "", $id));
        $DB = new DBConnect();
        $sql = "SELECT * FROM wishlist WHERE username='$username' AND product_id =$id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function remove($id, $username)
    {
        $DB = new DBConnect();
        $sql = "DELETE FROM wishlist WHERE username='$username' AND product_id ='$id'";
        $result = mysqli_query($DB->connect(), $sql);
    }

    public function add($id, $username)
    {
        $DB = new DBConnect();
        $wishlist = new Wishlist();
        $checker = new Wishlist;
        if ($checker->checkAdded($id, $username) == false && $_SESSION['username'] != '') {
            $sql = "INSERT INTO wishlist(username, product_id) VALUES ('$username','$id')";
            $result = mysqli_query($DB->connect(), $sql);
            if ($result) {
            } else {
                die(mysqli_error($DB->connect()));
            }
        } else if ($checker->checkAdded($id, $username) == true) {
            $wishlist->remove($id, $username);
        } else if ($_SESSION['username'] == '') {
            header("Location: ../login.php");
        }
    }

    public function fetch($username)
    {
        $DB = new DBConnect();
        $sql = "SELECT username, wishlist.product_id, product.name AS 'product_name', product.price, product.img  FROM wishlist INNER JOIN product ON product.id = wishlist.product_id WHERE username ='$username'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        } else {
            return 0;
        }
    }


    public function wishlistItemsCount($username)
    {
        $DB = new DBConnect();
        $sql = "SELECT COUNT(*) as items FROM wishlist WHERE username= '$username'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
