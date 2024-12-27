<?php

$hostname = "localhost"; // replace with your actual database hostname
$username = "root";
$password = "";
$database = "solon";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $student_id = $_POST["student_id"];
    $password = $_POST["password"];

    // SQL query to select data from the users table
    $sql = "SELECT * FROM registration WHERE student_id=$student_id";

    $result = $conn->query($sql);

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $row['password'])) {
            session_start(); // Start a session
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastName'] = $row['lastName'];
            
            echo "User logged in. Redirecting..."; // Add this line
            header("Location: homepage.php");
            exit();
        } else {
            echo '<span style="color: red; font-weight: bold;">Invalid password.</span>';
        }
    } else {
        echo '<span style="color: red; font-weight: bold;">User not found.</span>';
    }
	
}
// Close the database connection
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            background: url('uploads/bg2.jpg') center/cover no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden; /* Ensures the video doesn't overflow */
        }

        video {
            position: absolute;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1; /* Places the video behind other content */
            object-fit: cover; /* Ensures the video covers the entire background */
        }

        #activity {
            position: absolute;
            top: 20px;
            left: 20px;
            font-weight: bold;
            color: #333;
            font-size: 20px;
            color: #fff;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 500px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
    display: block;
    margin-bottom: 8px;
    color: #FFFFFF; /* Strong white color */
    text-align: left; /* Align text to the left */
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    color: #000000; /* Black color */
    text-align: left; /* Align text to the left */
}


        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px; /* Add margin-top for space */
        }

        .button-a {
        background-color: #000000;
        display: flex;
        justify-content: center; /* Horizontal centering */
        align-items: center; /* Vertical centering */
        margin-top: 20px; /* Add margin-top for space */
    
        }

        button.admin{
            background-color: #353935;
            
        }

        button.admin:hover {
        background-color: #DAA520; /* Change color to yellow on hover */
        }


        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            flex-grow: 1;
        }

        button.register {
            background-color: #3498db;
            margin-left: 10px; /* Add margin-left for space */
        }

        button:hover {
            background-color: #45a049;
        }

        #solon {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-weight: bold;
            color: #000000;
            font-size: 20px;
        }
        .login-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            background-image: linear-gradient(to bottom right, #4CAF50, #2196F3);
            color: #ffffff;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            outline: none;
        }

        .login-container .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-container .button-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
        }

        .login-container .button-container button.login {
            background-color: #2196F3;
            color: #ffffff;
        }

        .login-container .button-container button.register {
            background-color: #4CAF50;
            color: #ffffff;
        }

        .login-container .button-a button.admin {
            background-color: #f44336;
            color: #ffffff;
        }
        .login-container {
    width: 500px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 10px;
    background-image: linear-gradient(to bottom right, #0D47A1, #1565C0); /* Dark blue gradient */
    color: #ffffff;
    text-align: center;
    transition: transform 0.3s ease; /* Add transition for smooth hover effect */
}



    .login-container:hover {
        transform: scale(1.05); /* Increase the scale on hover */
    }
    
    .button-container button,
.button-a button {
    transition: background-color 0.3s ease;
}

/* Change background color on hover */
.button-container button:hover {
    background-color: #45a049;
}

.button-a button:hover {
    background-color: #d32f2f;
}

    </style>
</head>
<body>

<div class="login-container">
    <h2><b>Login</b></h2>
    <form action="login.php" method="post">
            <label for="username"><b>Student ID:</b></label>
        <input type="text" id="student_id" name="student_id" required placeholder="Enter your student ID">

        <label for="password"><b>Password:</b></label>
        <input type="password" id="password" name="password" required placeholder="Enter your password">

        <div class="button-container">
            <button type="login" class="login">Login</button>
            <button type="button" class="register" onclick="location.href='register.php'">Register</button>
        </div>

        <div class="button-a">
            <button type="button" class="admin" onclick="location.href='admin.php'">Log in as Admin</button>
        </div>
    </form>
</div>

</body>
</html>