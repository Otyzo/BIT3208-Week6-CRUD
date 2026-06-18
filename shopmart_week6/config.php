<?php
// config.php
// This file connects ShopMart to the MySQL database.
// I include it at the top of any PHP file that needs to read or write to the database.

$conn = mysqli_connect("localhost", "root", "", "shopmart");
// localhost  = the database is running on my own computer (XAMPP)
// root       = the default MySQL username in XAMPP
// ""         = no password needed in XAMPP by default
// shopmart   = the name of the database I created in phpMyAdmin

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
// If the connection fails, the script stops and shows the error message.
// This helps me debug connection problems quickly.
?>
