<?php

$hostname = "localhost"; // replace with your actual database hostname
$username = "root";
$password = "";
$database = "solon";

// Establishing a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default admin credentials
$defaultUsername = 'admin';
$defaultPassword = 'admin123';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Validate user credentials
    if ($inputUsername === $defaultUsername && $inputPassword === $defaultPassword) {
        // Redirect to homepage.php upon successful login
        header("Location: adminhomepage.php");
        exit();
    } else {
        echo '<span style="color: red; font-weight: bold;">Invalid password / Username</span>';
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('uploads/bg2.jpg') center/cover no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
            border-radius: 8px;
            width: 350px;
            text-align: center;
            animation: lightAnimation 2s infinite alternate;
        }

        @keyframes lightAnimation {
            0% {
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }
            100% {
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            }
        }
        .admin-form {
    background: linear-gradient(to bottom right, #0D47A1, #1565C0); /* Dark blue gradient */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5); /* Enhanced shadow */
    padding: 20px;
    border-radius: 8px;
    width: 500px;
    text-align: center;
    animation: lightAnimation 2s infinite alternate;
    margin-top: 20px; /* Add margin to separate from login form */
}

.admin-form h2 {
    color: #fff; /* White text color */
    margin-bottom: 20px;
}

.admin-form label {
    display: block;
    margin: 10px 0;
    color: #fff; /* White text color */
    text-align: left;
}

.admin-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    box-sizing: border-box;
    border: 1px solid #ffffff; /* White border */
    border-radius: 4px;
    background-color: #ffffff; /* White background */
    color: #2C1071; /* Updated color */
}


.admin-form input[type="submit"] {
    background-color: #fff; /* White background */
    color: #2C1071; /* Dark blue text color */
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.admin-form input[type="submit"]:hover {
    background-color: #eee; /* Lighter shade on hover */
}


        h2 {
            color: #2C1071; /* Updated color */
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0;
            color: #2C1071; /* Updated color */
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #2C1071; /* Updated color */
            border-radius: 4px;
            background-color: rgba(44, 16, 113, 0.1); /* Light shade of the color */
            color: #2C1071; /* Updated color */
        }

        input[type="submit"] {
            background-color: #2C1071; /* Updated color */
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1f0b4e; /* Darker shade for hover effect */
        }
        
    </style>
</head>
<body>
<form method="POST" action="" class="admin-form">
    <h2>Login as Admin</h2>
    <label for="admin-username">Username:</label>
    <input type="text" name="username" id="admin-username" required>

    <label for="admin-password">Password:</label>
    <input type="password" name="password" id="admin-password" required>

    <button type="submit" class="btn btn-primary">Login</button>
</form>



</body>
</html>

