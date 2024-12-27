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

// Fetch sit-in history
$history_sql = "SELECT v_id,student_id, purpose, laboratory, time_in, time_out FROM search WHERE student_id = ? and time_out is NOT NULL";
$history_stmt = $conn->prepare($history_sql);
$history_stmt->bind_param("i", $_SESSION['student_id']);
$history_stmt->execute();
$history_result = $history_stmt->get_result();



// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback'])) {
    // Get the feedback from the form
    $feedback = $_POST['feedback'];
    
    // Prepare and execute the SQL query to insert feedback into the database
    $insert_feedback_sql = "UPDATE search SET feedback = ? WHERE v_id = ?";
    $insert_feedback_stmt = $conn->prepare($insert_feedback_sql);
    $insert_feedback_stmt->bind_param("si", $feedback, $_POST['v_id']);
    
    // Check if the query was executed successfully
    if ($insert_feedback_stmt->execute()) {
        // Feedback inserted successfully
        echo "<script>alert('Feedback inserted successfully');</script>";
    } else {
        // Error occurred while inserting feedback
        echo "<script>alert('Error inserting feedback');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
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
            height: 500vh;
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
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
    background-color: #fefefe;
    margin: auto; /* Center horizontally and vertically */
    padding: 20px;
    margin-top: 200px; /* Center horizontally and vertically */
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
    max-width: 500px; /* Limiting the maximum width for better readability */
}


        /* Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        @media print {
            #sidebar {
                display: none;
            }

            #content {
                width: 100%;
                padding: 0;
            }

            header {
                display: none;
            }

            #printButton {
                display: none;
            }
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
        <div class="m-5">
            <?php
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
        <div id="content" style="padding: 20px;">
        <h1 style="font-size: 24px; color: #333; margin-bottom: 20px;">History of Sit-in</h1>
        <table id="history-table" style="width: 100%; border-collapse: collapse; margin-top: 20px; background-color: #ffffff;">
            <tr style="background-color: #28a745; color: #ffffff;">
                <th style="padding: 12px 15px; text-align: left; font-weight: bold; background-color: #28a745; border: 1px solid rgba(0, 0, 0, 0.2);">V_ID</th>
                <th style="padding: 12px 15px; text-align: left; font-weight: bold; background-color: #28a745; border: 1px solid rgba(0, 0, 0, 0.2);">Student ID</th>
                <th style="padding: 12px 15px; text-align: left; font-weight: bold; background-color: #28a745; border: 1px solid rgba(0, 0, 0, 0.2);">Purpose</th>
                <th style="padding: 12px 15px; text-align: left; font-weight: bold; background-color: #28a745; border: 1px solid rgba(0, 0, 0, 0.2);">Laboratory</th>
                <th style="padding: 12px 15px; text-align: left; font-weight: bold; background-color: #28a745; border: 1px solid rgba(0, 0, 0, 0.2);">Time In</th>
                <th style="padding: 12px 15px; text-align: left; font-weight: bold; background-color: #28a745; border: 1px solid rgba(0, 0, 0, 0.2);">Time Out</th>
                <th style="padding: 12px 15px; text-align: left; font-weight: bold; background-color: #28a745; border: 1px solid rgba(0, 0, 0, 0.2);">Feedback</th>
            </tr>
            <?php while ($row = $history_result->fetch_assoc()): ?>
                <tr>
                    <td style="padding: 12px 15px; text-align: left; border: 1px solid rgba(0, 0, 0, 0.2); color: #000;"><?php echo $row['v_id']; ?></td>
                    <td style="padding: 12px 15px; text-align: left; border: 1px solid rgba(0, 0, 0, 0.2); color: #000;"><?php echo $row['student_id']; ?></td>
                    <td style="padding: 12px 15px; text-align: left; border: 1px solid rgba(0, 0, 0, 0.2); color: #000;"><?php echo $row['purpose']; ?></td>
                    <td style="padding: 12px 15px; text-align: left; border: 1px solid rgba(0, 0, 0, 0.2); color: #000;"><?php echo $row['laboratory']; ?></td>
                    <td style="padding: 12px 15px; text-align: left; border: 1px solid rgba(0, 0, 0, 0.2); color: #000;"><?php echo $row['time_in']; ?></td>
                    <td style="padding: 12px 15px; text-align: left; border: 1px solid rgba(0, 0, 0, 0.2); color: #000;"><?php echo $row['time_out']; ?></td>
                    <td style="padding: 12px 15px; text-align: left; border: 1px solid rgba(0, 0, 0, 0.2); color: #000;">
                        <!-- Add Feedback Button -->
                        <button type="button" class="btn btn-primary" onclick="openFeedbackModal(<?php echo $row['v_id']; ?>)">Insert Feedback</button>

                      
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <button id="printButton" style="padding: 8px 16px; border: none; background-color: #4CAF50; color: #fff; border-radius: 4px; cursor: pointer; font-family: Arial, sans-serif; margin-top: 20px;" onclick="printReport()">Print Report</button>
        
        <!-- Feedback Modal -->
        <div id="feedbackModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeFeedbackModal()">&times;</span>
                <h2>Insert Feedback</h2>
                <!-- Feedback Form -->
              <!-- Feedback Form -->
                <form id="feedbackForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <!-- Pass v_id to PHP script -->
                    <input type="hidden" id="v_id" name="v_id">
                    <label for="feedback">Feedback:</label><br>
                    <textarea id="feedback" name="feedback" rows="4" cols="50"></textarea><br>
                    <button type="submit">Submit</button>
                    <button type="button" onclick="closeFeedbackModal()">Cancel</button>
                </form>

            </div>
        </div>
    </div>

<script>
       // Function to open feedback modal and pass v_id to form
function openFeedbackModal(v_id) {
    var modal = document.getElementById("feedbackModal");
    // Set the v_id value in the hidden input field
    document.getElementById('v_id').value = v_id;
    modal.style.display = "block";
}

// Function to close feedback modal
function closeFeedbackModal() {
    var modal = document.getElementById("feedbackModal");
    modal.style.display = "none";
}


        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            var modal = document.getElementById("feedbackModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>





    </div>
 <!-- Print button -->

 <script>
        function logout() {
            var confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                // Redirect to login.php
                window.location.href = 'login.php';
            }
        }

        function printReport() {
            // Hide the print button before printing
            document.getElementById('printButton').style.display = 'none';
            // Trigger the print functionality
            window.print();
            // Show the print button after printing
            document.getElementById('printButton').style.display = 'block';
        }
    </script>

</body>

</html>