<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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
            height: 500vh;
        }

        #sidebar {
            background-color: #1A1A4A;
            color: #ecf0f1;
            padding: 20px;
            text-align: center;
            width: 200px;
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
    </style>
    <title>Admin Dashboard</title>
</head>

<body>
    <header>
        <h1>University of Lahug</h1>
    </header>

   <div id="container">
        <div id="sidebar">
            <nav>
                <ul>
                    <img src="uploads/admin.jpg" alt="Admin Image">
                    <!-- Search button with Font Awesome icon -->
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
        <?php
$hostname = "localhost"; // Your database hostname
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "solon"; // Your database name

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


date_default_timezone_set('Asia/Manila'); // Set the timezone to Asia/Manila
;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['timeout'])) {
        $timeout_v_id = $_POST['timeout']; // Changed to timeout_v_id
        // Get the current timestamp for timeout
        $current_time = date('Y-m-d h:i:s A'); // Format with 12-hour time

        // Update the timeout column with the current timestamp based on v_id
        $update_timeout_sql = "UPDATE search SET time_out = '$current_time' WHERE v_id = '$timeout_v_id'"; // Changed to use v_id
        if ($conn->query($update_timeout_sql) === TRUE) {
            // Decrement remainingSession by 1
            $decrement_session_sql = "UPDATE registration SET remainingSession = remainingSession - 1 WHERE student_id = (SELECT student_id FROM search WHERE v_id = '$timeout_v_id')";
            if ($conn->query($decrement_session_sql) === TRUE) {
                echo "<script>alert('The user is logout');</script>";
            } else {
                echo "Error updating remainingSession: " . $conn->error;
            }
        } else {
            echo "Error updating timeout: " . $conn->error;
        }
    }
}

// Fetch sit-in records from the database
$sql = "SELECT s.v_id, s.student_id, r.firstname, r.lastname, s.purpose, s.laboratory, s.time_in, s.time_out, s.feedback
        FROM search s 
        INNER JOIN registration r ON s.student_id = r.student_id
        ORDER BY s.v_id"; // Order by v_id
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo "<style>
    body {
        background-color: #f0f0f0;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 50px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
        text-align: left;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    td input[type='text'] {
        width: 100%;
        border: none;
        background-color: transparent;
    }
    button {
        padding: 8px 12px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }
    .btn-update {
        background-color: #ff0000;
        color: white;
        margin-right: 5px;
    }
    .btn-delete {
        background-color: #f44336;
        color: white;
    }
</style>";


    echo "<div class='container mt-5'>";
    echo "<h2 class='mb-3'>Sit-in Records</h2>";
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr class='text-center'>";
    echo "<th>#</th>"; // Add this column header for v_id
    echo "<th>Student ID</th>";
    echo "<th>Firstname</th>";
    echo "<th>Lastname</th>";
    echo "<th>Purpose</th>";
    echo "<th>Laboratory</th>";
    echo "<th>Time In</th>";
    echo "<th>Time Out</th>";
    echo "<th>Actions</th>";
    echo "<th>Feedback</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["v_id"] . "</td>";
        echo "<td>" . $row["student_id"] . "</td>";
        echo "<td>" . $row["firstname"] . "</td>";
        echo "<td>" . $row["lastname"] . "</td>";
        echo "<td>" . $row["purpose"] . "</td>";
        echo "<td>" . $row["laboratory"] . "</td>";
        echo "<td>" . $row["time_in"] . "</td>";
        // Check if time_out is not empty
        if (!empty($row["time_out"])) {
            echo "<td>Already Logged Out</td>";
            echo "<td></td>"; // Empty cell for actions when already logged out
        } else {
            echo "<td>" . $row["time_out"] . "</td>";
            // Timeout button
            echo "<td>
                  <form method='post'>
                      <button class='btn-update' type='submit' name='timeout' value='" . $row["v_id"] . "'>Logout</button>
                  </form>
              </td>";
        }
        echo "<td><button class='view-feedback-btn btn btn-primary' data-feedback='" . $row['feedback'] . "'>View Feedback</button></td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "No sit-in records found.";
}
?>

            </div>
            </div>
            <!-- Feedback Modal -->
<div class="modal" id="feedbackModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Feedback content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        // When the view feedback button is clicked
        $('.view-feedback-btn').click(function () {
            var feedback = $(this).data('feedback'); // Get the feedback from the data attribute
            $('#feedbackModal .modal-body').text(feedback); // Set the feedback content in modal body
            $('#feedbackModal').modal('show'); // Show the modal
        });
    });
</script>


</body>
</html>
