<?php error_reporting(0); ?>
<?php
require_once('./classes/product.php');
require_once('./classes/brand.php');
require_once('./classes/category.php');
$product = new Product();
$brand = new Brand();
$category = new Category();
if (isset($_POST['submit_product'])) {
    $target = "product-images/" . basename($_FILES['image']['name']);
    $image = $_FILES['image']['name'];
    $product->addProduct($_POST['product_name'], $_POST['product_desc'], (int)$_POST['brand-id'], (int)$_POST['category-id'], (float)$_POST['price'], $image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
}

if (isset($_POST['submit_update'])) {
    $target = "product-images/" . basename($_FILES['image-update']['name']);
    $image = $_FILES['image-update']['name'];
    $product->updateProduct($_POST['edit_id'], $_POST['product_name_update'], $_POST['product_desc_update'], (int)$_POST['brand-id-update'], (int)$_POST['category-id-update'], (float) $_POST['price_update'], $image);
    move_uploaded_file($_FILES['image-update']['tmp_name'], $target);
}
if (isset($_GET['delete_id_product'])) {
    $product->removeProduct($_GET['delete_id_product']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Adamina&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata&amp;display=swap" />
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>

<script src="/static/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<body style="font-family: Alata, sans-serif;">
    <?php
    include 'nav-bar.php';
    ?>
    <!-- Model for inserting product -->
    <form method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nameInput2">Product Name</label>
                            <input type="text" class="form-control" id="nameInput1" placeholder="Enter Name" autocomplete="off" name="product_name" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Product Description</label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter Description" autocomplete="off" name="product_desc" required />
                        </div>
                        <div class="form-group">
                            <label for="">Brand</label>
                            <select class="form-select" aria-label="Default select example" id='category-id' name="brand-id">
                                <option selected disabled hidden>- Select Brand -</option>
                                <?php
                                $rows = $brand->fetch();
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        echo '<option value=" ' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category-id">Category</label>
                            <select class="form-select" aria-label="Default select example" id='category-id' name='category-id'>
                                <option selected disabled hidden>- Select Category -</option>
                                <?php
                                $rows = $category->fetch();
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        echo '<option value=" ' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="text" class="form-control" id="price" placeholder="Enter Price" autocomplete="off" name="price" required />
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="hidden" name="size" value="100000">
                            <input type="file" class="form-control" autocomplete="off" name="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_product">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="col text-center" style="margin-top: 10px;margin-bottom: 16px;">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
            Add Product
        </button>
    </div>
    <!-- Model for updating product -->
    <form method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="form-group">
                            <label for="nameInput1">Product Name</label>
                            <input type="text" class="form-control" id="nameInput2" placeholder="Enter Name" autocomplete="off" name="product_name_update" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput1">Product Description</label>
                            <input type="text" class="form-control" id="descInput2" placeholder="Enter Description" autocomplete="off" name="product_desc_update" required />
                        </div>
                        <div class="form-group">
                            <label for="">Brand</label>
                            <select class="form-select" aria-label="Default select example" id='brand-id-2' name="brand-id-update">
                                <option selected value=''>- Select Brand -</option>
                                <?php
                                $rows = $brand->fetch();
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        echo '<option value=" ' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category-id">Category</label>
                            <select class="form-select" aria-label="Default select example" id='category-id-2' name='category-id-update'>
                                <option selected value=''>- Select Category -</option>
                                <?php
                                $rows = $category->fetch();
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        echo '<option value=" ' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="text" class="form-control" id="price2" placeholder="Enter Price" autocomplete="off" name="price_update" required />
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="hidden" name="size" value="100000">
                            <input type="file" class="form-control" autocomplete="off" name="image-update" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_update">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Table -->
    <div class="container" style="overflow: auto;">
        <table class="table" style="width:80rem">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rows = $product->fetch();
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        echo '<tr>
          <td scope="row">' . $row['id'] . '</td>
          <td scope="row">' . $row['name'] . '</td>
          <td scope="row">' . $row['description'] . '</td>
          <td scope="row">' . $row['brand_name'] . '</td>
          <td scope="row">' . $row['category_name'] . '</td>
          <td scope="row">' . $row['price'] . '</td>
          <td scope="row"><img src="product-images/' . $row['img'] . '" alt="" style ="width:5rem; height:5rem;"></td>
          <td scope="row">
          <button class = "btn btn-primary edit_btn">Edit</button>
          <button class = "btn btn-danger"><a class ="text-light text-decoration-none" href="product-view.php?delete_id_product=' . $row['id'] . '">Delete</a></button>
          </td>
        </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit_btn').click(function() {

                $('#exampleModal2').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
                console.log(data);
                $('#edit_id').val(data[0]);
                $('#nameInput2').val(data[1]);
                $('#descInput2').val(data[2]);
                $("#brand-id-2 option[value='2']").prop('selected', true);
                $('#price2').val(data[5]);
                $('#img2').val(data[6]);

            });
        });
    </script>
</body>

</html>
<?php
include './config/script.php'
?>