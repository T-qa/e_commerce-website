<?php error_reporting(0); ?>
<?php
require_once('./classes/product.php');
require_once('./classes/category.php');
require_once('./classes/brand.php');
require_once('./config/url.php');
$url = new URL();
$category = new Category();
$product = new Product();
$brand = new Brand();
$site = $url->getUrl();
?>
<html lang="en">

<head>
    <base href=<?php echo $url->getUrl() ?>>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Project Ecommerce</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/Responsive.css" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <link rel="stylesheet" href="./assets/css/product-filter.css" />
    <link rel="stylesheet" href="./assets/css/filter-price.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include 'nav-bar-logged.php'; ?>

    <main class="main">
        <div class="container">
            <div class="page-header breadcrumb-wrap">
                <div class="container">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="homepage">Home</a></li>
                        <?php
                        $rows = $category->fetchByID($_GET['category_id']);
                        if (!empty($rows)) {
                            foreach ($rows as $row) {
                                echo '<li class="breadcrumb-item"><a href="#">' . $row['name'] . '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="products-filter-bar">
                <div class="container">
                    <div class="filter-bar d-flex justify-content-end align-items-center">
                        <strong class="filter-label">Filter:</strong>

                        <div class="brand-filter py-2 px-4">
                            <details class="category-select">
                                <summary class="radios">
                                    <input type="radio" name="brand" id="default" title="Brand" checked="" default />
                                </summary>
                                <ul class="list filter-brand-list">
                                    <li>
                                        <label for="All" data-sort-value="*">All</label>
                                    </li>
                                    <?php
                                    $rows = $brand->fetch();
                                    if (!empty($rows)) {
                                        foreach ($rows as $row) {
                                            echo '<li>
                                            <label for="' . $row['name'] . '" data-sort-value=".' . $row['name'] . '">' . $row['name'] . '</label>
                                        </li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </details>
                        </div>
                        <div class="sort-filter py-2 px-4">
                            <details class="category-select">
                                <summary class="radios">
                                    <input type="radio" name="sort" id="default" title="Sort" checked="" />
                                    <input type="radio" name="sort" id="high-low" title="High to Low" />
                                    <input type="radio" name="sort" id="low-high" title="Low to High" />
                                </summary>
                                <ul class="list filter-ascending-list">
                                    <li>
                                        <label for="high-low" data-sort-type="high-low" data-sort-value="price">High to Low</label>
                                    </li>
                                    <li>
                                        <label for="low-high" data-sort-type="low-high" data-sort-value="price">Low to High</label>
                                    </li>
                                </ul>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-8">
                    <div class="search-session d-flex justify-content-center">
                        <div class="search-bar">
                            <div class="search-field">
                                <input type="text" class="search-input" placeholder="I'm looking for..." />
                                <button class="search-btn" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="grid mt-4">
                        <?php
                        $rows = $product->fetchByCategory($_GET['category_id']);
                        if (!empty($rows)) {
                            foreach ($rows as $row) {
                                echo '<div class="grid-item ' . $row['brand_name'] . '">
                            <div class="top-products__item">
                            <div class="top-products__item__img">
                                <img src="./product-images/' . $row['img'] . '" style="width: 100%" />
                            </div>
                            <a class="item-name"  href="product/' . $row['productID'] . '">' . $row['name'] . '</a>
                            <div class="item-rating">
                                <p>
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
                                </p>
                            </div>
                            <strong class="item-price" data-price="' . $row['price'] . '">$' . $row['price'] . '</strong>
                            </div>
                        </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-4">
                    <div class="wrapper">
                        <header>
                            <h2 class="text-center">Price Range</h2>
                        </header>
                        <div class="price-input">
                            <div class="field">
                                <span><i class="fa-solid fa-dollar-sign"></i></span>
                                <input type="number" class="input-min" value="2500" />
                            </div>
                            <div class="separator">-</div>
                            <div class="field">
                                <span><i class="fa-solid fa-dollar-sign"></i></span>
                                <input type="number" class="input-max" value="7500" />
                            </div>
                        </div>
                        <div class="slider">
                            <div class="progress"></div>
                        </div>
                        <div class="range-input">
                            <input type="range" class="range-min" min="0" max="10000" value="2500" step="100" />
                            <input type="range" class="range-max" min="0" max="10000" value="7500" step="100" />
                        </div>
                        <div class="mt-5 d-flex justify-content-center">
                            <button class="filter-button" role="button">
                                <i class="fa-solid fa-filter"></i>Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include './footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./assets/js/index.js"></script>
    <script src="./assets/js/isotope.js"></script>
    <script src="./assets/js/product-filter.js"></script>
</body>

</html>