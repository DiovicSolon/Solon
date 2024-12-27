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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Student Dashboard</title>
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
            height: 200vh;
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
            width: 230px;
            position: relative;
            overflow-y: ; /* Add the overflow-y property for vertical scrollbar */
            max-height: 500vh; /* Set a maximum height for the sidebar */
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
    #lab-rules {
        background-color: #f8f9fa;
    }

    #lab-rules h2, #lab-rules h3, #lab-rules h4 {
        color: #007bff;
    }

    #lab-rules ol li {
        color: #495057;
    }

    #lab-rules ol li span.font-weight-bold {
        color: #343a40;
    }

    #lab-rules ol ul li {
        color: #6c757d;
    }

    #lab-rules ol ul li:before {
        content: "\2022"; /* Bullet point */
        color: #6c757d;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
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
    <div class="m-5">   <?php
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
        <div id="content">
    <h1 style="font-size: 28px; color: #00000; margin-bottom: 20px;">Welcome, <?php echo $_SESSION['firstname'];?> </h1>
    
    <div class="container">
        <div id="lab-rules" class="mt-4 p-4 border rounded">
            <h2 class="text-center mb-4 text-uppercase font-weight-bold text-primary">University of Cebu</h2>
            <h3 class="text-center mb-3 font-weight-bold">CICS</h3>
            <h4 class="text-center mb-4">COLLEGE OF INFORMATION & COMPUTER STUDIES</h4>
            <h3 class="text-center mb-4 font-weight-bold">LABORATORY RULES AND REGULATIONS</h3>
            <div class="row">
                <div class="col-md-6">
                    <ol class="list-unstyled">
                        <li class="mb-3">Maintain silence, proper decorum, and discipline inside the laboratory. Mobile phones, walkmans, and other personal pieces of equipment must be switched off.</li>
                        <li class="mb-3">Games are not allowed inside the lab. This includes computer-related games, card games, and other games that may disturb the operation of the lab.</li>
                        <li class="mb-3">Surfing the Internet is allowed only with the permission of the instructor. Downloading and installing of software are strictly prohibited.</li>
                        <li class="mb-3">Getting access to other websites not related to the course (especially pornographic and illicit sites) is strictly prohibited.</li>
                        <li class="mb-3">Deleting computer files and changing the set-up of the computer is a major offense.</li>
                        <li class="mb-3">Observe computer time usage carefully. A fifteen-minute allowance is given for each use. Otherwise, the unit will be given to those who wish to "sit-in".</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <ol class="list-unstyled">
                        <li class="mb-3">
                            <span class="font-weight-bold">Observe proper decorum while inside the laboratory.</span>
                            <ul class="list-unstyled ml-3">
                                <li class="mb-1">Do not get inside the lab unless the instructor is present.</li>
                                <li class="mb-1">All bags, knapsacks, and the likes must be deposited at the counter.</li>
                                <li class="mb-1">Follow the seating arrangement of your instructor.</li>
                                <li class="mb-1">At the end of class, all software programs must be closed.</li>
                                <li class="mb-1">Return all chairs to their proper places after using.</li>
                            </ul>
                        </li>
                        <li class="mb-3">Chewing gum, eating, drinking, smoking, and other forms of vandalism are prohibited inside the lab.</li>
                        <li class="mb-3">Anyone causing a continual disturbance will be asked to leave the lab. Acts or gestures offensive to the members of the community, including public display of physical intimacy, are not tolerated.</li>
                        <li class="mb-3">Persons exhibiting hostile or threatening behavior such as yelling, swearing, or disregarding requests made by lab personnel will be asked to leave the lab.</li>
                        <li class="mb-3">For serious offenses, the lab personnel may call the Civil Security Office (CSU) for assistance.</li>
                        <li class="mb-3">Any technical problem or difficulty must be addressed to the laboratory supervisor, student assistant, or instructor immediately.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Your custom scripts -->
    <script>
        function changeButtonColor(button) {
            // Example function to change button color on click
            button.style.backgroundColor = "#87CEEB";
        }
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