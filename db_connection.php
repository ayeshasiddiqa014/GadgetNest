<?php
$servername = "localhost";  // Change if necessary
$username = "admin";          // Replace with your database username (default for XAMPP)
$password = "admin";              // Replace with your database password (default is empty)
$dbname = "web_app";        // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
