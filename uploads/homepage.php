<?php
session_start(); // Start the session at the beginning


$hostname = "localhost"; 
$username = "root";
$password = "";
$database = "solon";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['student_id'])) {
    // User is not logged in
    header("Location: login.php"); // Redirect to login
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        #container {
            display: flex;
            height: 100vh;
        }

        #sidebar {
            background-color: #1A1A4A;
            color: #ecf0f1;
            padding: 20px;
            text-align: center;
            width: 200px;
            position: relative;
            overflow-y: ; /* Add the overflow-y property for vertical scrollbar */
            max-height: 100vh; /* Set a maximum height for the sidebar */
        }

        #sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
            cursor: pointer;
        }

        #content {
            flex: 1;
            padding: 20px;
        }

        #content h1 {
            color: #333;
        }

        #dashboard,
        #profile,
        #activity,
        #view {
            background-color: #fff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            border: none;
            display: block;
            width: 70%;
            text-align: left;
            margin-bottom: 5px;
            transition: background-color 0.3s; /* Add a smooth transition effect */
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        #dashboard:hover,
        #profile:hover,
        #activity:hover,
        #view:hover {
            background-color: #87CEEB; /* Sky blue color on hover */
        }

       

        #file-input {
            display: none;
        }

        ul {
           text-align: center;
            padding: 0;
            list-style: none;
        }

        ul button {
            width: 80%;
            margin: 5px auto;
        }
        #logout {
            background-color: #e74c3c; /* Red color for logout button */
        }
        #logout:hover {
            background-color: #c0392b; /* Darker red color on hover */
        }
    </style>
    <title>Student Dashboard</title>
</head>

<body>

    <header>
        <h1>University of Lahug</h1>
    </header>

    <div id="container">
    <div id="sidebar">
    <div class="m-5"> <?php
        $sql = "SELECT profile_image FROM registration WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['student_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row !== null && isset($row['profile_image'])) {
            $imageData = base64_encode($row['profile_image']);
            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Profile Picture" class="rounded-circle border border-3">';
        } else {
            echo '<img src="default_profile_image.jpg" alt="Profile Picture" class="rounded-circle border border-3">';
        }
    ?>
    </div>

    <nav>
                <ul>
                    <button id="dashboard" onclick="changeButtonColor(this)">Home</button>
                    <button id="profile" onclick="changeButtonColor(this)"><a href="editprofile.php" style="text-decoration: none; color: inherit;">Edit Profile</a></button>
                    <button id="activity" onclick="changeButtonColor(this)">Sit-in</button>
                    <button id="view" onclick="changeButtonColor(this)">View Remaining Session</button>
                </ul>
                <button id="logout" onclick="logout()">Log Out</button>
            </nav>
        </div>
        <div id="content">
    <h1 style="font-size: 28px; color: #3498db; margin-bottom: 20px;">Welcome, <?php echo $_SESSION['firstname'];?> </h1>
    
    <div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <p style="font-size: 18px; color: #333; line-height: 1.6;">
            Thank you for using our platform. We're delighted to have you here. If you have any questions or need assistance, feel free to contact our support team.
        </p>
        <p style="font-size: 18px; color: #333; line-height: 1.6;">
            Explore the features in the sidebar to make the most out of your experience.
        </p>
    </div>

    
</div>

    <script>
    function logout() {
        var confirmLogout = confirm("Are you sure you want to log out?");
        if (confirmLogout) {
            // Redirect to login.php
            window.location.href = 'login.php';
        }
    }
</script>




</body>

</html>