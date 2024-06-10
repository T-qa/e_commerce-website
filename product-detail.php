<?php
require_once('./classes/product.php');
require_once('./classes/cart.php');
require_once('./classes/wishlist.php');
require_once('./config/url.php');
$url = new URL();
if (!$_SESSION['username']) {
  $_SESSION['username'] = '';
}
$wishlist = new Wishlist();
$product = new Product();
$cart = new Cart();
if (isset($_POST['add-to-cart'])) {
  $cart->addToCart($_GET['product_id'], $_SESSION['username'], $_POST['quantity']);
}

if (isset($_POST['wishlist'])) {
  $wishlist->add($_GET['product_id'], $_SESSION['username']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <base href=<?php echo $url->getUrl() ?>>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Product</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/best-carousel-slide.css" />
  <link rel="stylesheet" href="./assets/css/Responsive.css" />
  <link rel="stylesheet" href="./assets/css/styles.css" />
  <link rel="stylesheet" href="./assets/css/product-detail.css" />
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
  <?php include './nav-bar-logged.php' ?>

  <section id="product-detail">

    <div class="container my-5">
      <?php
      $status = 'Add to Wishlist';
      if ($wishlist->checkAdded($_GET['product_id'], $_SESSION['username']) == true) {
        $status = 'Remove from Wishlist';
      }
      $rows = $product->fetchByID($_GET['product_id']);
      if (!empty($rows)) {
        foreach ($rows as $row) {
          echo '<div class="row detail-page">
        <div class="col-lg-6 col-12 product-photos">
          <div class="product-img">
            <img src="./product-images/' . $row['img'] . '" alt="" />
          </div>
          <div class="product-img-list mt-4">
            <div class="product-img-item">
              <img src="#" alt="" />
            </div>
            <div class="product-img-item">
              <img src="#" alt="" />
            </div>
            <div class="product-img-item">
              <img src="#" alt="" />
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-12 product-shop">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="#">' . $row['brand_name'] . '</a></li>
            <li class="breadcrumb-item">' . $row['category_name'] . '</li>
            <li class="breadcrumb-item active" aria-current="page">
              ' . $row['name'] . '
            </li>
          </ul>
          <div class="product-detail-info">
            <div class="product-detail-info-name">
              <h1>' . $row['name'] . '</h1>
            </div>
            <div class="product-detail-info-title">
              <span>Brand: </span>
              <a href="">' . $row['brand_name'] . '</a>
            </div>
            <div class="product-detail-info-description">
              <p>
                ' . $row['description'] . '
              </p>
            </div>
            <div class="product-detail-info-price">
              <p class="product-price">$' . $row['price'] . '</p>
            </div>
            <div class="product-detail-info-quantity">
              <form method ="POST">
                <fieldset data-quantity>
                  <legend>Change quantity</legend>
                </fieldset>
                <div class="product-add-to-cart" style="margin-top:25px; margin-left:10px;">
              <button class="add-to-cart" type="submit" name="add-to-cart">
                Add to Cart <i class="fas fa-shopping-cart"></i>
              </button>
              <button class="add-to-cart" type="submit" name="wishlist">
                ' . $status . ' <i class="fa fa-heart" style ="color:white;"></i>
              </button>
            </div>
              </form>
            </div>
          </div>
        </div>
      </div>';
        }
      }
      ?>
      <div class="row my-5">
        <div class="detail-info col-12 col-lg-6">
          <div class="block-section">
            <div class="table-wrapper product-detail-content">
              <div class="attributes-list">
                <div class="attribute-title">
                  <i class="fa-solid fa-gear"></i>
                  <span>Details</span>
                </div>
                <hr />
                <?php
                $rows = $product->fetchProductDetailsByID($_GET['product_id']);
                if (!empty($rows)) {
                  foreach ($rows as $row) {
                    echo '<div class="table additional-attributes">
                      <ul>
                        <li>
                          <p>Display</p>
                          <div>
                            <span>' . $row['display'] . '</span>
                          </div>
                        </li>
                        <li>
                          <p>Resolution</p>
                          <div>
                            <span>' . $row['resolution'] . '</span>
                          </div>
                        </li>
                        <li>
                          <p>RAM</p>
                          <div>
                            <span>' . $row['RAM'] . '</span>
                          </div>
                        </li>
                        <li>
                          <p>Memory</p>
                          <div>
                            <span>' . $row['memory'] . '</span>
                          </div>
                        </li>
                        <li>
                          <p>CPU</p>
                          <div>
                            <span>' . $row['CPU'] . '</span>
                          </div>
                        </li>
                        <li>
                          <p>GPU</p>
                          <div>
                            <span>' . $row['GPU'] . '</span>
                          </div>
                        </li>
                        <li>
                          <p>Size</p>
                          <div>
                            <span>' . $row['size'] . '</span>
                          </div>
                        </li>
                        <li>
                          <p>Weight</p>
                          <div>
                            <span>' . $row['weight'] . '</span>
                          </div>
                        </li>
                      </ul>
                    </div>';
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'footer.php' ?>
  </section>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="./assets/js/index.js"></script>
  <script src="./assets/js/script.js" type="module"></script>
  <script src="./assets/js/product-detail.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>