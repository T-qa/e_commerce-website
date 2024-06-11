<?php
require_once(__DIR__ . "/../config/dbconfig.php");
require_once("orders.php");
require_once("cart.php");
class CheckoutHandler
{
    private $order;
    private $cart;
    public function checkOutCart($username, $district, $ward, $address, $city, $firstName, $lastName, $payment)
    {
        $order = new Order();
        $cart = new Cart();
        $DB = new DBConnect();
        $rows = $cart->fetchCartByUser($username);
        if (!empty($rows)) {
            $location = $address . ' ' . $ward . ' ' . $district . ' ' . $city;
            foreach ($rows as $row) {
                $product_id = (int)$row['product_id'];
                $subTotal = (int)$row['subTotal'];
                $quantity = (int)$row['quantity'];
                $order->createOrder($username, $product_id, $subTotal, $quantity, $location, $firstName, $lastName, $payment);
            }
            $cart->clearCart($username);
            $_SESSION['status'] = 'Order Successfully';
            $_SESSION['status_code'] = 'success';
            header("refresh:1.3;url=homepage");
        }
    }
}
