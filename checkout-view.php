<?php
require "./classes/cart.php";
require "./classes/user.php";
require "./classes/checkoutHandler.php";
require_once('./config/url.php');
$url = new URL();
$user = new User();
$cart = new Cart();
$checkout = new CheckoutHandler();

if (isset($_POST['checkout-btn'])) {
    $checkout->checkOutCart($_SESSION['username'], $_POST['district'], $_POST['ward'], $_POST['address'], $_POST['city'], $_POST['firstname'], $_POST['lastname'], $_POST['payment']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href=<?php echo $url->getUrl() ?>>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Adamina&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata&amp;display=swap" />
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<script src="/static/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<body style="font-family: Alata, sans-serif">
    <form class="container col-8 my-5 br-2 rounded" method="POST">
        <div class="row g-3">
            <div class="col-4 order-md-last">
                <h4 class="d-flex justify-content-between align-item-center">
                    <span class="text-muted">Your Cart</span>
                    <span class="badge bg-secondary rounded-pill">
                        <?php $rows = $cart->CountUserCart($_SESSION['username']);
                        if (!empty($rows)) {
                            foreach ($rows as $row) {
                                echo $row['items'];
                            }
                        }

                        ?>
                    </span>
                </h4>
                <ul class="list-group">
                    <?php
                    $rows = $cart->fetchCartByUser($_SESSION['username']);
                    if (!empty($rows)) {
                        foreach ($rows as $row) {
                            echo '<li class="list-group-item d-flex justify-content-between">
                                    <div>
                                    <h6>' . $row['name'] . '</h6>
                                <span class="text-muted">Total: $' . $row['subTotal'] . '</span>
                            </div>
                            <span class="text-muted">x' . $row['quantity'] . '</span>
                            </li>';
                        }
                        echo '<hr>';
                        $rows = $cart->calculateTotal($_SESSION['username']);
                        if (!empty($rows)) {
                            foreach ($rows as $row) {
                                $total  = $row['Total'];
                                echo "<h5>Total: $$total</h5>";
                            }
                        }
                    }

                    ?>

                </ul>
            </div>
            <?php
            $rows = $user->fetchByUsername($_SESSION['username']);
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    echo '<div class="col-8">
                <h4>Billing Address</h4>
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="firstname">First Name</label>
                        <input type="text" name="firstname" class="form-control" value=' . $row['firstName'] . ' required>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="lastname">Last name</label>
                        <input type="text" name="lastname" class="form-control" value=' . $row['lastName'] . ' required>
                    </div>
                    <div class="col-12">
                        <label class="from-label" for="username">Username</label>
                        <div class="input-group">
                            <span class="input-group-text">@</span>
                            <input type="text" class="form-control" id="usrname"  value ="' . $_SESSION['username'] . '" readonly>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="col-5">
                        <label class="form-label" for="city">City</label>
                        <select class="form-select" name="city" id="city">
                            <!-- api-fetch.js -->
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="district">District</label>
                        <select class="form-select" name="district" id="district">

                        </select>
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="ward">Ward</label>
                        <select class="form-select" name="ward" id="ward">
                        </select>
                    </div>
                </div>
                <hr>
                <h4>Payment</h4>
                <div class="form-check">
                    <input type="radio" name="payment" class="form-check-input" value="Visa" required>
                    <label class="form-check-label"><span><img style="width: 50px; height:35px" src="https://image.similarpng.com/very-thumbnail/2020/06/Logo-visa-icon-PNG.png" alt=""></span> Visa</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="payment" class="form-check-input" value="MasterCard">
                    <label class="form-check-label"><span><img style="width: 50px; height:35px" src="https://w7.pngwing.com/pngs/116/678/png-transparent-mastercard-mastercard-logo-cdr-text-orange.png" alt=""></span> MasterCard</label>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="cardname">Name on Card </label>
                        <input type="text" id="cardname" class="form-control" required>
                        <small class="text-muted">Full name as displayed on card</small>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="creditcard">Credit Card Number </label>
                        <input type="text" id="creditcard" class="form-control" required>
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="expiration">Expiration </label>
                        <input type="text" id="expiration" class="form-control" required>
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="cvv">CVV </label>
                        <input type="text" id="cvv" class="form-control" required>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary btn-block mb-4" name="checkout-btn">Continue To Checkout</button>
            </div>';
                }
            }
            ?>

        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="./assets/js/api-fetch.js"></script>
</body>

</html>

<?php
include './config/script.php';
?>