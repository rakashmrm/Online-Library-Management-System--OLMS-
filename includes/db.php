<?php
// includes/db.php

$host = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password 
$database = "olms";

// Create the connection
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection failed
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
// If it connects, do nothing.
?>