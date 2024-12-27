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

// Fetch the profile image path from the database
$sql = "SELECT profile_image FROM registration WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['student_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Define the default profile image path
$defaultProfileImage = "uploads/default.jpg";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color:#1B1212;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        #container {
            display: flex;
            height: 150vh;
            background-image: url('uploads/bg1.jpg'); /* Replace 'path/to/your/image.jpg' with the actual path to your background image */
            background-size: cover; /* This ensures that the background image covers the entire container */
            background-position: center; /* This centers the background image within the container */
            /* You can add more background properties such as repeat, attachment, etc. as needed */
        }


        #sidebar {
            background-color: #1A1A4A;
            color: #ecf0f1;
            padding: 20px;
            text-align: center;
            width: 200px;
            position: relative;
            overflow-y: ; /* Add the overflow-y property for vertical scrollbar */
            max-height: 150vh; /* Set a maximum height for the sidebar */
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
        #view,
          #history:hover {
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
        #view:hover,
        #history:hover {
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
        color: black; /* Text color */
        border: none; /* Remove border */
        padding: 10px 20px; /* Add padding */
        border-radius: 5px; /* Add border radius */
        cursor: pointer; /* Change cursor on hover */
        transition: background-color 0.3s; /* Add smooth transition */
    }

    #logout:hover {
        background-color: #c0392b; /* Darker red color on hover */
    }

    #content {
    text-align: center; /* Center the content horizontally */
}

.remaining-session-container {
    margin-top: 50px; /* Adjust margin as needed */
}

.remaining-session {
    font-size: 36px; /* Increase the font size */
    color: #333;
}


.circle {
    display: inline-block;
    width: 500px; /* Increase width for a bigger circle */
    height: 500px; /* Increase height for a bigger circle */
    background-color: #ff5733; /* Orange color */
    color: #fff; /* Text color */
    border-radius: 50%; /* Make it a circle */
    line-height: 500px; /* Center the text vertically */
    text-align: center; /* Center the text horizontally */
    font-weight: bold;
    font-size: 100px; /* Increase font size for bigger text */
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
        if ($row !== null && isset($row['profile_image'])) {
            // If profile image is set, display it
            $imageData = base64_encode($row['profile_image']);
            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Profile Picture" class="rounded-circle border border-3">';
        } else {
            // If profile image is not set, display the default image
            echo '<img src="' . $defaultProfileImage . '" alt="Profile Picture" class="rounded-circle border border-3">';
        }
    ?>
    </div>

    <nav>
                <ul>
                <?php echo $_SESSION['firstname'];?> 

                <a href="homepage.php" style="text-decoration: none; color: inherit;">
    <button id="dashboard" onclick="changeButtonColor(this)">
        <i class="fas fa-home" style="vertical-align: middle;"></i> Home
    </button>
</a>

<button id="profile" onclick="changeButtonColor(this)">
    <a href="editprofile.php" style="text-decoration: none; color: inherit;">
        <i class="fas fa-edit" style="vertical-align: middle;"></i> Edit Profile
    </a>
</button>

<button id="activity" onclick="changeButtonColor(this)">
    <i class="fas fa-chart-line" style="vertical-align: middle;"></i> Activity
</button>

<a href="remainingsession.php" style="text-decoration: none;">
    <button id="view" onclick="changeButtonColor(this)">
        <i class="fas fa-laptop" style="vertical-align: middle;"></i> View Remaining Session
    </button>
</a>

<a href="historysitin.php" style="text-decoration: none;">
    <button id="view" onclick="changeButtonColor(this)">
        <i class="fas fa-history" style="vertical-align: middle;"></i> History of Sitin
    </button>
</a>

<a href="viewannouncement.php" style="text-decoration: none;">
    <button id="view" onclick="changeButtonColor(this)">
        <i class="fas fa-bullhorn" style="vertical-align: middle;"></i> View Announcement
    </button>
</a>

<a href="feedback.php" style="text-decoration: none;">
    <button id="view" onclick="changeButtonColor(this)">
        <i class="fas fa-flag" style="vertical-align: middle;"></i> Feedback/Report
    </button>
</a>

<br>
<button id="logout" onclick="logout()">
    <i class="fas fa-sign-out-alt" style="vertical-align: middle;"></i> Log Out
</button>

            

            </nav>
        </div>
        
        <div id="content" class="center-content">
    <h1>Remaining Session</h1>

    <?php
    // Query to fetch remaining session information from the database
    $remainingSessionQuery = "SELECT remainingSession FROM registration WHERE student_id = ?";
    $remainingSessionStmt = $conn->prepare($remainingSessionQuery);
    $remainingSessionStmt->bind_param("i", $_SESSION['student_id']);
    $remainingSessionStmt->execute();
    $remainingSessionResult = $remainingSessionStmt->get_result();
    $remainingSessionRow = $remainingSessionResult->fetch_assoc();

    // Check if remaining session data exists
    if ($remainingSessionRow && isset($remainingSessionRow['remainingSession'])) {
        $remainingSession = $remainingSessionRow['remainingSession'];

        // Display remaining session information
        echo "<div class='remaining-session-container'>";
        echo "<p class='remaining-session'> <span class='circle'>$remainingSession</span></p>";
        echo "</div>";
    } else {
        echo "<p>No remaining session information found.</p>";
    }
    ?>

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