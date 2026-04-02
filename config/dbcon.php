<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "setechwebpos_php");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
