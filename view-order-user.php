<?php
require_once('./classes/orders.php');
$order = new Order();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/sidebar.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Adamina&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata&amp;display=swap" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <title>Profile</title>
</head>

<body>
    <header>
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="index-logged.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-building fa-fw me-3"></i><span>Homepage</span></a>
                    <a href="profile-view.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-chart-bar fa-fw me-3"></i><span>Profile</span></a>
                    <a href="view-order-view.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-globe fa-fw me-3"></i><span>Orders</span></a>
                    <a href="login.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-building fa-fw me-3"></i><span>Logout</span></a>
                </div>
            </div>
        </nav>
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#">
                    <h1>Profile</h1>
                </a>
            </div>
        </nav>
    </header>

    <main style="margin-top: 100px;margin-right:3rem">
        <div class="container">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active btn btn-outline-primary" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-ordered" type="button" role="tab" aria-controls="pills-ordered" aria-selected="true">Ordered</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn btn-dark" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Confirmed</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn btn-dark" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Shipping</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn btn-dark" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-delivered" type="button" role="tab" aria-controls="pills-delivered" aria-selected="false">Delivered</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-ordered" role="tabpanel" aria-labelledby="pills-home-tab">
                    <form method="POST">
                        <table class="table table-white table-striped" style="width: 110%; margin-bottom: 20px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rows = $order->fetchOrderByStatus($_SESSION['username'], 'Waiting for confirmation');
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        echo '<tr>
                        <td>' . $row['order_id'] . '</td>
                        <td>' . $row['product_name'] . '</td>
                        <td>' .  $row['quantity'] . '</td>
                        <td>' . $row['subTotal'] . '</td>
                        <td>' . $row['location'] . '</td>
                        <td>' . $row['status'] . '</td>
                    </tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="tab-pane fade show active" id="pills-ordered" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form method="POST">
                            <table class="table table-white table-striped" style="width: 110%; margin-bottom: 20px;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rows = $order->fetchOrderByStatus($_SESSION['username'], 'Confirmed');
                                    if (!empty($rows)) {
                                        foreach ($rows as $row) {
                                            echo '<tr>
                        <td>' . $row['order_id'] . '</td>
                        <td>' . $row['product_name'] . '</td>
                        <td>' .  $row['quantity'] . '</td>
                        <td>' . $row['subTotal'] . '</td>
                        <td>' . $row['location'] . '</td>
                        <td>' . $row['status'] . '</td>
                    </tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <form method="POST">
                        <table class="table table-white table-striped" style="width: 110%; margin-bottom: 20px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rows = $order->fetchOrderByStatus($_SESSION['username'], 'Shipping');
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        echo '<tr>
                        <td>' . $row['order_id'] . '</td>
                        <td>' . $row['product_name'] . '</td>
                        <td>' .  $row['quantity'] . '</td>
                        <td>' . $row['subTotal'] . '</td>
                        <td>' . $row['location'] . '</td>
                        <td>' . $row['status'] . '</td>
                    </tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="tab-pane fade" id="pills-delivered" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <form method="POST">
                        <table class="table table-white table-striped" style="width: 110%; margin-bottom: 20px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rows = $order->fetchOrderByStatus($_SESSION['username'], 'Delivered');
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        echo '<tr>
                        <td>' . $row['order_id'] . '</td>
                        <td>' . $row['product_name'] . '</td>
                        <td>' .  $row['quantity'] . '</td>
                        <td>' . $row['subTotal'] . '</td>
                        <td>' . $row['location'] . '</td>
                        <td>' . $row['status'] . '</td>
                    </tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</html>
<?php
include "./config/script.php";
?>