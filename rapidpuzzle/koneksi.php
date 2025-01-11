<?php
$server = "localhost";
$username = "root";      // Use the correct username for your MySQL database
$password = "";          // Use the correct password for your MySQL database
$database = "toko_mouse"; // Make sure this is your actual database name

// Create the database connection
$conn = mysqli_connect($server, $username, $password, $database);

// Check if the connection succeeded
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
