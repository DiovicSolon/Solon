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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if feedback is set and not empty
    if (isset($_POST['feedback']) && !empty(trim($_POST['feedback']))) {
        // Prepare an SQL statement to insert feedback into the search table
        $sql = "UPDATE search SET feedback = ? WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("si", $_POST['feedback'], $_SESSION['student_id']);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Feedback inserted successfully
            echo "<script>alert('Feedback submitted successfully.');</script>";
        } else {
            // Error inserting feedback
            echo "<script>alert('Error submitting feedback. Please try again.');</script>";
        }

        // Close statement
        $stmt->close();
    } else {
        // Use JavaScript to prompt the user to provide feedback
        echo "<script>alert('Feedback is required. Please provide your feedback.');</script>";
    }
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
    <!-- Add the link to the FontAwesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Your other head elements -->
</head>
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
            max-height: 200vh; 
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
            width: 250px;
            position: relative;
            overflow-y: ; /* Add the overflow-y property for vertical scrollbar */
            max-height: 200vh; /* Set a maximum height for the sidebar */
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
            padding: 50px;
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
      <?php echo $_SESSION['firstname'];?> 
    </div>
  
    <nav>
                <ul>
               
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


<div id="content">
            <h1>Feedback/Report</h1>
            <form id="feedbackForm" method="post">
                <div class="form-group">
                <textarea class="form-control" id="feedback" name="feedback" rows="5" placeholder="Enter your feedback here" required></textarea>
                  
                </div>
                <button type="button" onclick="confirmSubmit()" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        function confirmSubmit() {
            var confirmSubmit = confirm("Are you sure you want to submit feedback?");
            if (confirmSubmit) {
                document.getElementById("feedbackForm").submit();
            }
        }
    </script>




</html>
