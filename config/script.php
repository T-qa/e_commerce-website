<?php
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./assets/js/jquery-3.6.0.min.js"></script>
<?php
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
?>
    <script>
        Swal.fire({
            icon: "<?php echo $_SESSION['status_code'] ?>",
            title: "<?php echo $_SESSION['status'] ?>",
            showConfirmButton: true,
        });
    </script>
<?php
    unset($_SESSION['status']);
}
if (isset($_SESSION['status_2']) && $_SESSION['status_2'] != '') {
    ?>
        <script>
            Swal.fire({
                icon: "<?php echo $_SESSION['status_code_2'] ?>",
                title: "<?php echo $_SESSION['status_2'] ?>",
                showConfirmButton: true,
            });
        </script>
    <?php
        unset($_SESSION['status_2']);
    }
?>