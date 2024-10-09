<?php
require 'db_connection.php';
session_start(); // Start a session to store user data

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

// Check if the login form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_server = "localhost";
    $db_username = "new_admin"; // Your MySQL username
    $db_password = "admin123";     // Your MySQL password
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

    // Query to check credentials
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
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
    <title>User Login</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-image: url(""); 
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #e5e5e5; 
        }

        .container {
            display: flex;
            background-color: rgba(0, 0, 0, 0.9); 
            border-radius: 10px;
            max-width: 800px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.7);
        }

        .welcome {
            flex: 2;
            padding: 20px;
            text-align: center;
            font-style: italic;
            color: #b19870; 
        }

        .form {
            flex: 1;
            padding: 20px;
            color: #e5e5e5; 
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #FFD700; 
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #faf9f9; 
            border-radius: 4px;
            margin-bottom: 15px;
            background-color: #ffffff; 
            color: #000000; 
        }

        input[type="submit"] {
            background-color: #FFD700; 
            width: 100%;
            color: #000000; 
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #d89a09; 
        }

        h2 {
            margin-bottom: 20px;
            color: #FFD700; 
        }

        p {
            font-size: 1.1em;
            line-height: 1.5;
            color: #e5e5e5; 
        }

        .error {
            color: red; /* Error message color */
            text-align: center; /* Center the error message */
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .container {
                flex-direction: column;
                max-width: 90%;
            }
            .welcome, .form {
                flex: none;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h2>Welcome to GadgetNest</h2>
            <p>Your ultimate destination for thoughtfully selected lifestyle products that enhance your living space.</p>
            <img src="logo.jpeg" alt="GadgetNest Image" width="200px" height="200px"/> 
        </div>
        <div class="form">
            <form action="login.php" method="post">
                <h2>Login</h2>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required />

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />

                <?php if (isset($error_message)): ?>
                    <p class="error"><?php echo $error_message; ?></p>
                <?php endif; ?>

                <input type="submit" value="Login" />
            </form>
        </div>
    </div>
</body>
</html>
