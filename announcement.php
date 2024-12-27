<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #1B1212;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        #container {
            display: flex;
            height: 250vh;
            background-image: url('uploads/bg2.jpg'); /* Replace 'path/to/your/image.jpg' with the actual path to your background image */
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
            max-height: 250vh; /* Set a maximum height for the sidebar */
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

        #search,
        #dashboard,
        #profile,
        #delete,
        #inquire,
        #sitin,
        #reports {
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

        #search:hover,
        #dashboard:hover,
        #profile:hover,
        #delete:hover,
        #inquire:hover,
        #sitin:hover,
        #reports:hover {
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

        #searchForm {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        #searchForm label {
            display: block;
            margin-bottom: 10px;
        }

        #searchForm input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #cccccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        #searchForm button {
            background-color: #4caf50;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #searchForm button:hover {
            background-color: #45a049;
        }

        #sitInRecordsTable button:hover {
            background-color: #45a049;
        }

        #searchForm input[type="text"] {
            width: 80%;
        }

        .view-btn {
            background-color: #4caf50;
            color: #ffffff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-btn:hover {
            background-color: #45a049;
        }

        #postAnnouncementForm {
            margin: 0 auto;
            width: 50%;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        #postAnnouncementForm input[type="text"] {
            width: 100%;
            margin-bottom: 15px;
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
            <nav>
                <ul>
                    <!-- Include Font Awesome CSS -->
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                    <div class="profile-container">
                        <img src="uploads/admin.jpg" alt="Admin Image">
                        <div style="text-align: center;">
                            <span style="color: white; font-size: 20px; font-weight: bold;">Diovic Solon</span>
                        </div>

                           
                        <button id="dashboard" onclick="window.location.href='adminhomepage.php'">
                    <i class="fas fa-home"></i> <!-- Font Awesome home icon -->
                  
                    Home
                </button>

                <!-- Search button with Font Awesome icon -->
                <button id="search" onclick="window.location.href='adminhomepage.php'">
                        <i class="fas fa-search"></i> <!-- Font Awesome search icon -->
                        Search
                    </button>


                <a href="delete.php" style="text-decoration: none;">
                <button id="search">
                    <i class="fas fa-trash-alt"></i> <!-- Font Awesome trash icon -->
                    Update time out / Delete
                </button>
            </a>
                <button id="inquire" onclick="changeButtonColor(this)">Inquire Remaining Sessions</button>
                <a href="viewsitin.php" style="text-decoration: none;">
                <button id="sitin">
                    <i class="fas fa-user-friends"></i> <!-- Font Awesome users icon -->
                    View Sit-in Records
                </button>
            </a>

                        <a href="announcement.php" style="text-decoration: none;">
                <button id="sitin">
                    <i class="fas fa-bullhorn"></i> <!-- Font Awesome announcement icon -->
                    Post Announcement
                </button>
            </a>


          
                        <a href="viewsitin.php" style="text-decoration: none;">
                <button id="sitin">
                    <i class="fas fa-calendar-check"></i> <!-- Font Awesome booking icon -->
                    Booking Request and Approval
                </button>
            </a>

                        <a href="admin_view_feedback.php" style="text-decoration: none;">
                <button id="sitin">
                    <i class="fas fa-comment"></i> <!-- Font Awesome feedback icon -->
                    View Feedbacks Reports
                </button>
            </a>
                        <a href="generatereport.php" style="text-decoration: none;">
                <button id="sitin">
                    <i class="fas fa-chart-bar"></i> <!-- Font Awesome chart-bar icon -->
                    Generate Reports
                </button>
            </a>


                    <a href="resetpassword.php" style="text-decoration: none;">
            <button id="sitin">
                <i class="fas fa-key"></i> <!-- Font Awesome key icon -->
                Reset Password
            </button>
        </a>


                <a href="resetsession.php" style="text-decoration: none;">
            <button id="sitin">
                <i class="fas fa-laptop-code"></i> <!-- Font Awesome laptop code icon -->
                Reset Session
            </button>
        </a>
                </ul>
                <button id="logout" onclick="logout()">Log Out</button>
            </nav>
        </div>
        <div id="content">
    <form id="postAnnouncementForm" method="POST">
    <div style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <div class="form-group">
        <label for="announcementTitle">Title:</label>
        <input type="text" class="form-control" id="announcementTitle" name="announcementTitle" placeholder="Enter the title of the announcement..." required>
    </div>

    <div class="form-group">
        <label for="announcementText">Message:</label>
        <textarea class="form-control" id="announcementText" name="announcementText" rows="5" placeholder="Enter your announcement..." required></textarea>
    </div>

    <div class="form-group">
        <label for="dateCreated">Date Created:</label>
        <input type="text" class="form-control" id="dateCreated" name="dateCreated" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
        <!-- This input field is readonly and automatically populated with the current date and time -->
    </div>

    <button type="submit" class="btn btn-primary" onclick="postAnnouncement()">Post</button>
<button type="button" class="btn btn-secondary" onclick="cancelPost()">Cancel</button>

</div>



    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function logout() {
            var confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                window.location.href = 'login.php';
            }
        }

        function postAnnouncement() {
            var announcementText = document.getElementById('announcementText').value;
            // Here you can send the announcementText to the server or handle it as you need
            alert("Announcement Posted: " + announcementText);
            document.getElementById('announcementText').value = ''; // Clear the text box
        }

        function cancelPost() {
            document.getElementById('announcementText').value = ''; // Clear the text box
        }
        function postAnnouncement() {
        // Here you can submit the form via AJAX or handle it as needed
        alert("Announcement inserted successfully");
    }

    function cancelPost() {
        // Here you can handle canceling the post if needed
        document.getElementById("announcementTitle").value = "";
        document.getElementById("announcementText").value = "";
    }
    </script>
</body>

</html>


<?php
// Your database connection code
$hostname = "localhost"; // replace with your actual database hostname
$username = "root";
$password = "";
$database = "solon";

$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if announcement title and text are set and not empty
    if (isset($_POST["announcementTitle"]) && !empty($_POST["announcementTitle"]) && isset($_POST["announcementText"]) && !empty($_POST["announcementText"])) {
        // Get the announcement title and text from the POST request
        $announcementTitle = $_POST["announcementTitle"];
        $announcementText = $_POST["announcementText"];

        // Prepare SQL statement with placeholders
        $sql = "INSERT INTO announcement (title, message, created_at) VALUES (?, ?, NOW())";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $announcementTitle, $announcementText);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Announcement title or text is empty";
    }
}

// Close prepared statement and database connection

?>

