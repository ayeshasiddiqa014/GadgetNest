<?php
require 'db_connection.php';
session_start(); // Start a session to store user data (e.g., login status)

// Check if the user is already logged in, redirect to a dashboard if necessary
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

// Check if the login form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Replace these values with your actual database credentials
    $db_server = "localhost";
    $db_username = "new_admin"; // Your MySQL username
    $db_password = "admin123";     // Your MySQL password (if any)
    $db_name = "web_app";  // Your database name

    // Create a database connection
    $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get input from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to check if the provided username and password match a record in the database
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION['username'] = $username; // Store the username in the session
        header("Location: dashboard.php"); // Redirect to the dashboard page
        exit;
    } else {
        // Login failed
        $error_message = "Invalid username or password. Please try again.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #000; /* Black background */
            color: #00FF00; /* Neon green text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .container {
            background-color: #1a1a1a; /* Dark gray container background */
            border: 2px solid #00FF00; /* Neon green border */
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.8); /* Neon green glow */
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #FF00FF; /* Neon pink color for heading */
            margin-bottom: 20px;
            text-shadow: 0 0 15px #FF00FF; /* Glowing effect */
        }

        label {
            display: block;
            margin: 15px 0 5px;
            color: #00FF00; /* Neon green label color */
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #00FF00; /* Neon green border */
            border-radius: 5px;
            background-color: #000; /* Black input background */
            color: #FFFFFF; /* White text in input */
            outline: none;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #FF00FF; /* Neon pink border on focus */
        }

        input[type="submit"] {
            background-color: #00FF00; /* Neon green button */
            color: black; /* Black text on button */
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s, transform 0.2s;
        }

        input[type="submit"]:hover {
            background-color: #FF00FF; /* Neon pink on hover */
            transform: scale(1.05); /* Slightly enlarge button on hover */
        }

        .error {
            color: red; /* Error message color */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to GadgetNest</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <?php if (isset($error_message)): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
