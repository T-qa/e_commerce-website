<?php error_reporting(0); ?>
<?php
if (!$_SESSION['username']) {
    $_SESSION['username'] = '';
}
require_once('./classes/product.php');
require_once('./classes/cart.php');
require_once('./classes/category.php');
require_once('./classes/wishlist.php');
require_once('./classes/brand.php');
require_once('./config/url.php');
$url = new URL();


$brand = new Brand();
$product = new Product();
$cart = new Cart();
$wishlist = new Wishlist();
if (isset($_POST['action'])) {
    if ($_POST["action"] == "insert") {
        $wishlist->add($_POST['id'], $_SESSION['username']);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Project Ecommerce</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/best-carousel-slide.css" />
    <link rel="stylesheet" href="./assets/css/Responsive.css" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <link rel="stylesheet" href="./assets/css/user-dropdown.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .disclaimer {
            display: none;
        }
    </style>
</head>

<body>
    <?php include 'nav-bar-logged.php' ?>
    <?php include 'banner.php' ?>

    <section id="top-products">
        <div class="container top-products">
            <div class="top-products__header">
                <h1>Featured Smartphone</h1>
            </div>
            <div class="top-products__body">
                <div class="row top-products__list">
                    <?php

                    $rows = $product->fetchByCategory('5');
                    if (!empty($rows)) {
                        foreach ($rows as $row) {
                            $heart_status = 'fa fa-heart-o';
                            if ($wishlist->checkAdded($row['productID'], $_SESSION['username']) == true) {
                                $heart_status = 'fa fa-heart';
                            }
                            echo '<div class="col-12 col-md-6 top-products__item col-lg-3">
              <div class="top-products__item__img">
              <form method="POST">
                <input type="text" value ="' . $row['productID'] . '" name="product_id" hidden></input>
                <img src="product-images/' . $row['img'] . '" href="product-detail.php?product_id=' . $row['productID'] . '" style="width: 100%"/>
              </div>
              <a class="item-name"  href="product/' . $row['productID'] . '">' . $row['name'] . '</a>
              <div class="item-rating">
                <p>
                  <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
                </p>
              </div>
              <strong>$' . $row['price'] . '</strong>
              <div class="wishlist" data-bs-toggle="tooltip" data-bs-placement="auto" title="Add to wishlist">
              <a class="heart ' . $heart_status . '" aria-hidden="true" style="color:red;background-color:white;" onclick="addToWishlist(' . $row['productID'] . ')"></a>
            </div>
            </form>
            </div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="container top-products">
            <div class="top-products__header">
                <h1>Featured Laptop</h1>
            </div>
            <div class="top-products__body">
                <div class="row top-products__list">
                    <?php
                    $rows = $product->fetchByCategory('3');
                    if (!empty($rows)) {
                        foreach ($rows as $row) {
                            $heart_status = 'fa fa-heart-o';
                            if ($wishlist->checkAdded($row['productID'], $_SESSION['username']) == true) {
                                $heart_status = 'fa fa-heart';
                            }
                            echo '<div class="col-12 col-md-6 top-products__item col-lg-3">
              <div class="top-products__item__img">
              <form method="POST">
                <input type="text" value ="' . $row['productID'] . '" name="product_id" hidden></input>
                <img src="product-images/' . $row['img'] . '"  style="width: 100%"/>
              </div>
              <a class="item-name"  href="product/' . $row['productID'] . '">' . $row['name'] . '</a>
              <div class="item-rating">
                <p>
                  <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
                </p>
              </div>
              <strong>$' . $row['price'] . '</strong>
              <div class="wishlist" data-bs-toggle="tooltip" data-bs-placement="auto" title="Add to wishlist">
              <a class="heart ' . $heart_status . '" aria-hidden="true" style="color:red;background-color:white;" onclick="addToWishlist(' . $row['productID'] . ')"></a>
            </div>
            </form>
            </div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="container all-brands">
            <div>
                <div class="all-brands-header mb-5">
                    <h1 class="text-left text-center">Brands</h1>
                    <div class="search-session d-flex justify-content-center">
                        <div class="search-bar">
                            <select id="brands">
                                <option value="*">All</option>
                                <?php
                                $rows = $brand->fetch();
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        echo '<option value=".' . $row['name'] . '">' . $row['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <div class="search-field">
                                <input type="text" class="search-input" placeholder="I'm looking for..." style="width: 200px" />
                                <button class="search-btn" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid">
                    <?php
                    $rows = $product->fetch();
                    if (!empty($rows)) {
                        foreach ($rows as $row) {
                            $heart_status = 'fa fa-heart-o';
                            if ($wishlist->checkAdded($row['id'], $_SESSION['username']) == true) {
                                $heart_status = 'fa fa-heart';
                            }
                            echo '<div class="grid-item ' . $row['brand_name'] . '">
                        <div class="top-products__item">
                            <div class="top-products__item__img">
                                <img src="./product-images/' . $row['img'] . '" style="width: 100%" />
                            </div>
                            <a class="item-name"  href="product/' . $row['id'] . '">' . $row['name'] . '<a>
                            <div class="item-rating">
                                <p>
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
                                </p>
                            </div>
                            <strong class="item-price" data-price="' . $row['price'] . '">$' . $row['price'] . '</strong>
                            <div class="wishlist" data-bs-toggle="tooltip" data-bs-placement="auto" title="Add to wishlist">
                <a class="heart ' . $heart_status . '" aria-hidden="true" style="color:red;background-color:white;" onclick="addToWishlist(' . $row['id'] . ')"></a>
              </div>
                        </div>
                    </div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php include './footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./assets/js/index.js"></script>
    <script src="./assets/js/isotope.js"></script>
    <script src="./assets/js/main-page.js"></script>
    <script>
        function addToWishlist(id) {
            $(document).ready(function() {
                $.ajax({
                    url: 'index-logged.php',
                    type: 'POST',
                    data: {
                        id: id,
                        action: "insert"
                    },
                    success: function(response) {
                        if (response == 1) {
                            alert("Added to wishlist");
                        } else if (response == 0) {
                            alert("Please login before adding items to wishlist.");
                        }
                    }
                });
            });
        }
    </script>
</body>

</html>