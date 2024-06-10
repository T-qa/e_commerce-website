<?php
require_once('./classes/product.php');
require_once('./classes/brand.php');
require_once('./classes/category.php');
$product = new Product();
$brand = new Brand();
$category = new Category();
if (isset($_POST['submit_product_details'])) {
    $product->addProductDetails($_POST['product_name'], $_POST['display'], $_POST['resolution'], $_POST['RAM'], $_POST['Memory'], $_POST['CPU'], $_POST['GPU'], $_POST['size'], $_POST['weight']);
}
if (isset($_POST['submit_update_details'])) {

    $product->updateProductDetails($_POST['edit_id'], $_POST['display_update'], $_POST['resolution_update'], $_POST['RAM_update'], $_POST['Memory_update'], $_POST['CPU_update'], $_POST['GPU_update'], $_POST['size_update'], $_POST['weight_update']);
}

if (isset($_GET['delete_id_product_details'])) {
    $product->removeProductDetails($_GET['delete_id_product_details']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Product Details</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Adamina&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata&amp;display=swap" />
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>

<script src="/static/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<body style="font-family: Alata, sans-serif">
    <?php
    include 'nav-bar.php';
    ?>
    <!-- Model for inserting product -->
    <form method="POST">
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
                            <!-- <input type="text" class="form-control" id="nameInput1" placeholder="Enter Name" autocomplete="off" name="product_name" /> -->
                            <select class="form-select" aria-label="Default select example" name="product_name" id="">
                                <option selected disabled hidden>- Select Product -</option>
                                <?php
                                $rows = $product->fetchExcludedFromDetails();
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        echo '<option value=" ' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Display Type</label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter Display Type" autocomplete="off" name="display" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Resolution: </label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter Resolution" autocomplete="off" name="resolution" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">RAM:</label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter RAM" autocomplete="off" name="RAM" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Memory:</label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter Memory" autocomplete="off" name="Memory" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">CPU:</label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter CPU" autocomplete="off" name="CPU" required />
                        </div>
                        <div class=" form-group">
                            <label for="descInput2">GPU:</label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter GPU" autocomplete="off" name="GPU" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Size:</label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter Size" autocomplete="off" name="size" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Weight:</label>
                            <input type="text" class="form-control" id="descInput1" placeholder="Enter Weight" autocomplete="off" name="weight" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_product_details">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="col text-center" style="margin-top: 10px;margin-bottom: 16px;">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
            Add Details For A Product
        </button>
    </div>
    <!-- Model for updating product -->
    <form method="POST">
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
                            <input type="text" class="form-control" id="nameInput2" placeholder="Enter Name" autocomplete="off" name="product_name_update" required readonly />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Display Type</label>
                            <input type="text" class="form-control" id="Input1" placeholder="Enter Display Type" autocomplete="off" name="display_update" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Resolution: </label>
                            <input type="text" class="form-control" id="Input2" placeholder="Enter Resolution" autocomplete="off" name="resolution_update" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">RAM:</label>
                            <input type="text" class="form-control" id="Input3" placeholder="Enter RAM" autocomplete="off" name="RAM_update" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Memory:</label>
                            <input type="text" class="form-control" id="Input4" placeholder="Enter Memory" autocomplete="off" name="Memory_update" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">CPU:</label>
                            <input type="text" class="form-control" id="Input5" placeholder="Enter CPU" autocomplete="off" name="CPU_update" required />
                        </div>
                        <div class=" form-group">
                            <label for="descInput2">GPU:</label>
                            <input type="text" class="form-control" id="Input6" placeholder="Enter GPU" autocomplete="off" name="GPU_update" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Size:</label>
                            <input type="text" class="form-control" id="Input7" placeholder="Enter Size" autocomplete="off" name="size_update" required />
                        </div>
                        <div class="form-group">
                            <label for="descInput2">Weight:</label>
                            <input type="text" class="form-control" id="Input8" placeholder="Enter Weight" autocomplete="off" name="weight_update" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_update_details">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Table -->
    <div class="container">
        <table class="table" style="width:91rem">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Display</th>
                    <th scope="col">Resolution</th>
                    <th scope="col">RAM</th>
                    <th scope="col">Memory</th>
                    <th scope="col">CPU</th>
                    <th scope="col">GPU</th>
                    <th scope="col">Size</th>
                    <th scope="col">Weight</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rows = $product->fetchProductDetails();
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        echo '<tr>
          <td scope="row">' . $row['id'] . '</td>
          <td scope="row">' . $row['name'] . '</td>
          <td scope="row">' . $row['display'] . '</td>
          <td scope="row">' . $row['resolution'] . '</td>
          <td scope="row">' . $row['RAM'] . '</td>
          <td scope="row">' . $row['memory'] . '</td>
          <td scope="row">' . $row['CPU'] . '</td>
          <td scope="row">' . $row['GPU'] . '</td>
          <td scope="row">' . $row['size'] . '</td>
          <td scope="row">' . $row['weight'] . '</td>
          <td scope="row">
          <button class = "btn btn-primary edit_btn">Edit</button>
          <button class = "btn btn-danger"><a class ="text-light text-decoration-none" href="product-details-admin.php?delete_id_product_details=' . $row['id'] . '">Delete</a></button>
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
                $('#Input1').val(data[2]);
                $('#Input2').val(data[3]);
                $('#Input3').val(data[4]);
                $('#Input4').val(data[5]);
                $('#Input5').val(data[6]);
                $('#Input6').val(data[7]);
                $('#Input7').val(data[8]);
                $('#Input8').val(data[9]);
            });
        });
    </script>
</body>

</html>
<?php
include './config/script.php';
?>