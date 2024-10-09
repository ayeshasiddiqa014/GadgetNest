<?php
$servername = "localhost";  // Change if necessary
$username = "new_admin";     // Replace with your database username
$password = "admin123";    // Replace with your database password
$dbname = "web_app";         // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
