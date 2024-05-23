<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "e_commerce";
$conn = mysqli_connect($server, $user, $pass, $database);
session_start();
if (!$conn) {
    echo "<script>alert('Connection Failed')</script>";

}