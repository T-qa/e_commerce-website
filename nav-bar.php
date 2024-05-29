<?php
require_once "./classes/admin.php";
$admin = new Admin();

?>
<nav class="navbar navbar-light navbar-expand-md" style="background-color: gray">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Panel</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
            <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav">
                <li class="nav-item dropdown" id="manage">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="category-view.php">Category</a>
                        <a class="dropdown-item" href="brand-view.php">Brand</a>
                        <a class="dropdown-item" href="product-view.php">Product</a>
                        <a class="dropdown-item" href="product-details-admin.php">Product Details</a>
                        <a class="dropdown-item" href="orders-view.php">Orders</a>
                    </div>
                </li>
                <li class="nav-item dropdown" id="manage">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        User
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="user-view.php">Customer</a>
                        <a class="dropdown-item" href="admin-view.php">Admin</a>
                    </div>
                </li>
            </ul>
            <div class="dropdown" style="float: right;">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                    $rows = $admin->fetchByUsername($_SESSION['username_admin']);
                    if (!empty($rows)) {
                        foreach ($rows as $row) {
                            echo 'Hello, ' . $row['username'] . '';
                        }
                    }
                    ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="login-admin.php">Logout</a></li>
                </ul>
            </div>
        </div>

    </div>
</nav>