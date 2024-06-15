<?php
require_once(__DIR__ . "/../config/dbconfig.php");

class Cart
{
    private $db;

    public function __construct()
    {
        $this->db = new DBConnect();
    }

    public function fetchCartByUser($username)
    {
        $data = [];
        $sql = "SELECT cart.product_id, product.name, product.img, product.price, cart.quantity, cart.subTotal, brand.name as brand_name 
                FROM cart 
                INNER JOIN product ON cart.product_id = product.id 
                INNER JOIN brand ON product.brand_id = brand.id 
                WHERE cart.user_name='$username'";
        
        $result = mysqli_query($this->db->connect(), $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    public function updateQuantity($product_id, $username, $quantity, $price)
    {
        $sql = "UPDATE cart 
                SET quantity = quantity + $quantity, subTotal = quantity * $price 
                WHERE product_id = '$product_id' AND user_name ='$username'";
        
        mysqli_query($this->db->connect(), $sql);
    }
    
    public function addToCart($id, $username, $quantity)
    {
        $sql_price = "SELECT price FROM product WHERE id ='$id'";
        $result_price = mysqli_query($this->db->connect(), $sql_price);
        
        if ($result_price && $_SESSION['username'] != '') {
            while ($row = mysqli_fetch_assoc($result_price)) {
                $price = $row['price'];
                $sql_check = "SELECT * FROM cart WHERE product_id = '$id' AND user_name ='$username'";
                $result_check = mysqli_query($this->db->connect(), $sql_check);
                
                if ($result_check && mysqli_num_rows($result_check) > 0) {
                    $this->updateQuantity($id, $username, $quantity, $price);
                    header("refresh:0.5;url=$id");
                } else {
                    $sql_insert = "INSERT INTO cart(user_name, product_id, quantity, subTotal) 
                                   VALUES ('$username', '$id', $quantity, $price * $quantity)";
                    mysqli_query($this->db->connect(), $sql_insert);
                    header("refresh:0.5;url=$id");
                }
            }
        } else {
            header("Location: ../login.php");
        }
    }
    
    public function clearCart($username)
    {
        $sql = "DELETE FROM cart WHERE user_name = '$username'";
        mysqli_query($this->db->connect(), $sql);
    }
    
    public function removeFromCart($id)
    {
        $sql = "DELETE FROM cart WHERE product_id = $id";
        mysqli_query($this->db->connect(), $sql);
        
        if (mysqli_affected_rows($this->db->connect()) > 0) {
            header("refresh:0.5;url=cart-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }
    
    public function calculateTotal($username)
    {
        $data = [];
        $sql = "SELECT ROUND(SUM(subTotal), 2) as Total FROM cart WHERE user_name ='$username'";
        $result = mysqli_query($this->db->connect(), $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    public function countUserCart($username)
    {
        $data = [];
        $sql = "SELECT SUM(quantity) as items FROM cart WHERE user_name= '$username'";
        $result = mysqli_query($this->db->connect(), $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function editQuantity($id, $username, $quantity)
    {
        $sql_update = "UPDATE cart 
                       SET quantity = $quantity 
                       WHERE product_id = '$id' AND user_name = '$username'";
        
        mysqli_query($this->db->connect(), $sql_update);
        
        $sql_price = "SELECT price FROM product WHERE id ='$id'";
        $result_price = mysqli_query($this->db->connect(), $sql_price);
        
        if ($result_price) {
            while ($row = mysqli_fetch_assoc($result_price)) {
                $price = $row['price'];
                $sql_subtotal = "UPDATE cart 
                                 SET subTotal = quantity * $price 
                                 WHERE product_id = '$id' AND user_name = '$username'";
                
                mysqli_query($this->db->connect(), $sql_subtotal);
                header("refresh:0;url=cart-view.php");
            }
        }
    }
}
?>
