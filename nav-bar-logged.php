<?php
require_once('./classes/cart.php');
require_once('./classes/wishlist.php');
require_once('./classes/category.php');

$wishlist = new Wishlist();
$cart = new Cart();
$category = new Category();
?>

<?php ($_SESSION['username'] == '') ? './login.php' : './profile-view.php' ?>
<header>
  <nav class="navbar sticky navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="./assets/Images/ecommerce-logo.png" style="width: 40px" /></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav w-100">
          <li class="nav-item main-categori-wrap d-flex align-items-center" role="button">
            <div class="categori-button-active">
              <span class="fa-solid fa-bars"></span> Browse Categories
            </div>
            <div class="categori-dropdown-wrap categori-dropdown-active-large">
              <ul>
                <?php
                $rows = $category->fetch();
                if (!empty($rows)) {
                  foreach ($rows as $row) {
                    echo '<li class="has-children">
                    <a href="./category/' . $row['id'] . '"><i aria-hidden="true"></i>
                      <span>' . $row['name'] . '</span>
                    </a>
                  </li>';
                  }
                }
                ?>
              </ul>
            </div>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./homepage">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#footer">CONTACT</a>
          </li>
          <li class="nav-item dropdown custom-dropdown">
            <a class="nav-link dropdown-toggle" id="dropdownMenuButton" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0, 20">ACCOUNT <i class="far fa-user"></i></a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href=<?php echo '' . ($_SESSION['username'] != '' ? './profile-view.php' : './login.php'); ?>><span class=""></span>Profile</a>
              <a class="dropdown-item" href="./login.php"><span class=""></span><?php echo '' . ($_SESSION['username'] != '' ? 'Logout' : 'Login'); ?></a>
              <?php echo '' . ($_SESSION['username'] != '' ? null : '<a href="./register.php" class="dropdown-item">Register</a>'); ?>
            </div>
          </li>
        </ul>
        <div class="wishlist-checkout mt-lg-0 mt-2">
          <div class="add-to-wishlist">
            <a class="text-start" href=<?php echo '' . ($_SESSION['username'] != '' ? './wishlist-view.php' : './login.php'); ?>>
              <i class="fa fa-heart-o" aria-hidden="true"></i>

              <span class="wishlist-items" style="width: 18px"></span>
            </a>
            <p class="wishlist-title my-0">My Wish List</p>
          </div>
          <div class="checkout">
            <?php
            $rows = $cart->CountUserCart($_SESSION['username']);
            if (!empty($rows)) {
              foreach ($rows as $row) {
                echo '<a class="text-start" href=' . ($_SESSION['username'] != '' ? './cart-view.php' : './login.php') . '><i class="fas fa-shopping-cart"></i><span class="checkout-items" style="width: 18px">' . $row['items'] . '</span></a>';
              }
            }
            ?>
            <p class="cart-title my-0">My Cart</p>
          </div>
        </div>
      </div>

    </div>
  </nav>
</header>