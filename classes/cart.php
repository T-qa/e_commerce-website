<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Cart
{
    public function fetchCartByUser($username)
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT cart.product_id ,product.name, product.img,product.price, cart.quantity, cart.subTotal, brand.name as brand_name FROM cart INNER JOIN product ON cart.product_id = product.id INNER JOIN brand ON product.brand_id = brand.id WHERE cart.user_name='$username'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function updateQuantity($product_id, $username, $quantity, $price)
    {
        $DB = new DBConnect();
        $sql_3 = "UPDATE cart SET quantity = quantity + $quantity, subTotal = quantity * $price WHERE product_id = '$product_id' AND user_name ='$username'";
        $update_quantity = mysqli_query($DB->connect(), $sql_3);
    }
    public function addToCart($id, $username, $quantity)
    {
        $DB = new DBConnect();
        $cart = new Cart();
        $cart_item_id = $id;
        $cart_user_name = $username;
        // get price of the item
        $sql_price = "SELECT price FROM product WHERE id ='$cart_item_id'";
        $product_price = mysqli_query($DB->connect(), $sql_price);
        if ($_SESSION['username'] == '') {
            header("Location: ../login.php");
        }
        if ($product_price && $_SESSION['username'] != '') {
            while ($row = mysqli_fetch_assoc($product_price)) {
                $price = $row['price'];
                $sql_2 = "SELECT * FROM cart where product_id = '$cart_item_id' AND user_name ='$cart_user_name'";
                $search = mysqli_query($DB->connect(), $sql_2);
                if ($search->num_rows > 0) {
                    $cart->updateQuantity($cart_item_id, $cart_user_name, $quantity, $price);
                    header("refresh:0.5;url = $cart_item_id");
                } else {
                    $sql = "INSERT INTO cart(user_name, product_id, quantity,subTotal) VALUES ('$cart_user_name','$cart_item_id',$quantity,$price*$quantity)";
                    $query = mysqli_query($DB->connect(), $sql);
                    header("refresh:0.5;url = $cart_item_id");
                }
            }
        }
    }
    public function clearCart($username)
    {
        $DB = new DBConnect();
        $sql = "delete from cart where user_name = '$username'";
        $result = mysqli_query($DB->connect(), $sql);
    }
    public function removeFromCart($id)
    {
        $DB = new DBConnect();
        $sql = "delete from cart where product_id=$id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            header("refresh:0.5;url=cart-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }
    public function calculateTotal($username)
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT ROUND(SUM(subTotal), 2)as Total FROM cart WHERE user_name ='$username'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function CountUserCart($username)
    {
        $DB = new DBConnect();
        $sql = "SELECT SUM(quantity) as items FROM cart WHERE user_name= '$username'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function edit_quantity($id, $username, $quantity)
    {
        $DB = new DBConnect();
        $sql = "UPDATE cart SET quantity= $quantity WHERE product_id ='$id' AND user_name = '$username'";
        $query = mysqli_query($DB->connect(), $sql);
        if ($query) {
            $sql_price = "SELECT price FROM product WHERE id ='$id'";
            $query_2 = mysqli_query($DB->connect(), $sql_price);
            while ($row = mysqli_fetch_assoc($query_2)) {
                $price = $row['price'];
                $sql_3 = "UPDATE cart SET subTotal = quantity * $price WHERE product_id = '$id' AND user_name ='$username'";
                $update_quantity = mysqli_query($DB->connect(), $sql_3);
                header("refresh:0;url=cart-view.php");
            }
        }
    }
}