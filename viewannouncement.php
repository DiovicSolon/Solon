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

// Fetch announcements from the database
$announcementQuery = "SELECT id, title, message, created_at FROM announcement ORDER BY created_at DESC";
$announcementResult = $conn->query($announcementQuery);

// Check if there are announcements
$announcements = [];
if ($announcementResult->num_rows > 0) {
    // Fetch announcements and store them in an array
    while ($row = $announcementResult->fetch_assoc()) {
        $announcements[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            height: 250vh;
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
            width: 255px;
            position: relative;
            overflow-y: auto; /* Add the overflow-y property for vertical scrollbar */
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
            padding: 70px;
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
    .announcement-container {
    max-width: 800px;
    margin: 0 auto;
}

.announcement-table {
    width: 100%;
    border-collapse: collapse;
}

.announcement-table th,
.announcement-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.announcement-table th {
    background-color: #1B1212;
    color: #fff;
    text-align: left;
}

.announcement-table tr:hover {
    background-color: #f2f2f2;
}

.announcement-title {
    color: #1B1212;
    font-size: 18px;
    font-weight: bold;
}

.announcement-date {
    color: #555;
    font-size: 14px;
}

.announcement-message {
    color: #555; /* Dark gray text color */
    line-height: 1.8;
    padding: 20px; /* Increase padding for more space */
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.announcement:hover {
    transform: translateY(-5px);
}
.announcement.large {
            /* Additional styles to make the box larger */
            transform: scale(1.1); /* Increase size by 10% */
            z-index: 999; /* Ensure it's on top of other elements */
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
        echo '<img src="'.'data:image/jpeg;base64,' . $imageData . '" alt="Profile Picture" class="rounded-circle border border-3">';
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
    </ul>
</nav>
</div>
<div id="content" >
<h2 class="text-center mb-4" style="color: #1B1212; font-size: 30px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
    <span style="border-bottom: 2px solid #1B1212;">Admin Announcements</span>
</h2>
<div>
            <table class="announcement-table" style="background-color: white;">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date Posted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($announcements as $announcement) : ?>
                        <tr>
                            <td class="announcement-title"><?php echo $announcement['title']; ?></td>
                            <td class="announcement-date"><?php echo date('M d, Y', strtotime($announcement['created_at'])); ?></td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#announcementModal<?php echo $announcement['id']; ?>">
                                    View
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="announcementModal<?php echo $announcement['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel<?php echo $announcement['id']; ?>" aria-hidden="true">

                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="announcementModalLabel<?php echo $announcement['id']; ?>"><?php echo $announcement['title']; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo htmlspecialchars($announcement['message']); ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<script>
    // JavaScript function for logout
    function logout() {
        var confirmLogout = confirm("Are you sure you want to log out?");
        if (confirmLogout) {
            window.location.href = 'login.php';
        }
    }

    
</script>
<!-- Your existing HTML content -->

<!-- Bootstrap JavaScript and jQuery libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

</body>

</html>

