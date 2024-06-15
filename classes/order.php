<?php
require_once(__DIR__ . "/../config/dbconfig.php");

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new DBConnect();
    }

    public function createOrder($username, $product_id, $subTotal, $quantity, $location, $firstName, $lastName, $payment)
    {
        $status = 'waiting for confirmation';
        $sql = "INSERT INTO orders (user_name, product_id, subTotal, quantity, location, firstName, lastName, paymentType, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("siidissss", $username, $product_id, $subTotal, $quantity, $location, $firstName, $lastName, $payment, $status);
        
        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Order Created';
            header("refresh:1.5;url=product-view.php");
        } else {
            die("Error: " . $stmt->error);
        }
    }

    public function removeOrder($id)
    {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header("refresh:0.5;url=orders-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }

    public function changeOrderStatus($status, $order_id)
    {
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("si", $status, $order_id);
        
        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
            header("refresh:1.5;url=orders-view.php");
        } else {
            die("Error: " . $stmt->error);
        }
    }

    public function fetch()
    {
        $data = [];
        $sql = "SELECT o.order_id, o.user_name, p.name as product_name, o.quantity, o.subTotal, o.paymentType, o.location, o.status 
                FROM orders o 
                INNER JOIN product p ON p.id = o.product_id";
        $result = $this->db->connect()->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function fetchByID($username)
    {
        $data = [];
        $sql = "SELECT o.order_id, o.user_name, p.name as product_name, o.quantity, o.subTotal, o.paymentType, o.location, o.status 
                FROM orders o 
                INNER JOIN product p ON p.id = o.product_id 
                WHERE o.user_name = ?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function fetchOrderByStatus($username, $status)
    {
        $data = [];
        $sql = "SELECT o.order_id, o.user_name, p.name as product_name, o.quantity, o.subTotal, o.paymentType, o.location, o.status 
                FROM orders o 
                INNER JOIN product p ON p.id = o.product_id 
                WHERE o.user_name = ? AND o.status = ?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("ss", $username, $status);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
?>
