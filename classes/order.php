<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Order
{
    private $id;
    private $username;
    private $location;
    private $product_id;
    private $quantity;
    private $brand;

    public function createOrder($username, $product_id, $subTotal, $quantity, $location, $firstName, $lastName, $payment)
    {
        $DB = new DBConnect();
        $sql = "INSERT INTO orders(user_name,product_id,subTotal,quantity,location,firstName,lastName,paymentType,status) VALUES ('$username','$product_id',$subTotal,$quantity,'$location','$firstName','$lastName','$payment','waiting for confirmation')";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Order Created';
            header("refresh:1.5;url=product-view.php");
        } else {
            die(mysqli_error($DB->connect()));
        }
    }
    public function removeOrder($id)
    {
        $DB = new DBConnect();
        $sql = "delete from orders where order_id= $id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            header("refresh:0.5;url=orders-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }
    public function changeOrderStatus($status, $order_id)
    {
        $DB = new DBConnect();
        $sql = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
            header("refresh:1.5;url=orders-view.php");
        } else {
            die(mysqli_error($DB->connect()));
        }
    }
    public function fetch()
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT order_id, user_name, product.name as product_name, orders.quantity, orders.subTotal, orders.paymentType, orders.location, status FROM orders INNER JOIN product ON product.id = orders.product_id; ";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function fetchByID($username)
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT order_id, user_name, product.name as product_name, orders.quantity, orders.subTotal, orders.paymentType, orders.location, status FROM orders INNER JOIN product ON product.id = orders.product_id WHERE user_name = '$username';";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function fetchOrderByStatus($username, $status)
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT order_id, user_name, product.name as product_name, orders.quantity, orders.subTotal, orders.paymentType, orders.location, status FROM orders INNER JOIN product ON product.id = orders.product_id WHERE user_name = '$username' AND status ='$status';";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}