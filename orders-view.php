<?php
require_once('./classes/orders.php');
$order = new Order();
if (isset($_POST['submit_update'])) {
    $order->changeOrderStatus($_POST['status-update'], $_POST['edit_id']);
}
if (isset($_GET['delete_id_order'])) {
    $order->removeOrder($_GET['delete_id_order']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>View Orders</title>
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
    <form method="POST">
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Order Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="form-group">
                            <label for="">Order Status: </label>
                            <select class="form-select" aria-label="Default select example" id='brand-id-2' name="status-update">
                                <option value="Waiting for confirmation" default>Waiting for confirmation</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Shipping">Shipping</option>
                                <option value="Delivered">Delivered</option>
                            </select>
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
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Location</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rows = $order->fetch();
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        echo '<tr>
                        <td>' . $row['order_id'] . '</td>
                        <td>' . $row['user_name'] . '</td>
                        <td>' . $row['product_name'] . '</td>
                        <td>' . $row['quantity'] . '</td>
                        <td>$' . $row['subTotal'] . '</td>
                        <td>' . $row['paymentType'] . '</td>
                        <td>' . $row['location'] . '</td>
                        <td>' . $row['status'] . '</td>
                        <td scope="row">
        <button class="btn btn-primary edit_btn">Edit Status</button>
        <button class="btn btn-danger"><a class="text-light text-decoration-none" href="orders-view.php?delete_id_order=' . $row['order_id'] . '">Delete</a></button>
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
            });
        });
    </script>
</body>

</html>
<?php
include "./config/script.php";
?>