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

// Fetch reservation details including reservation_time
$sql = "SELECT purpose, laboratory, reservation_date, reservation_time, pc_number, status FROM futurereservation WHERE student_id = ? AND status = 'Approved'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['student_id']);
$stmt->execute();
$result = $stmt->get_result();
$reservation = $result->fetch_assoc();

// Check if the reservation has been approved or rejected for the current user
$sql_status = "SELECT status FROM futurereservation WHERE student_id = ?";
$stmt_status = $conn->prepare($sql_status);
$stmt_status->bind_param("i", $_SESSION['student_id']);
$stmt_status->execute();
$result_status = $stmt_status->get_result();

$approved = false;
$rejected = false;

while ($status_row = $result_status->fetch_assoc()) {
    if ($status_row['status'] == 'Approved') {
        $approved = true;
    }
    if ($status_row['status'] == 'Rejected') {
        $rejected = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Add the link to the FontAwesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
            height: 200vh;
            background-image: url('uploads/bg1.jpg');
            background-size: cover;
            background-position: center;
        }

        #sidebar {
            background-color: #1A1A4A;
            color: #ecf0f1;
            padding: 20px;
            text-align: center;
            width: 200px;
            position: relative;
            max-height: 500vh;
            overflow-y: auto;
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
        #history,
        #logout {
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
            transition: background-color 0.3s;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        #dashboard:hover,
        #profile:hover,
        #activity:hover,
        #view:hover,
        #history:hover,
        #logout:hover {
            background-color: #87CEEB;
        }

        #logout {
            background-color: #e74c3c;
            color: black;
        }

        #logout:hover {
            background-color: #c0392b;
        }

        .notification-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            position: fixed;
            top: 20px;
            right: 20px;
            width: 350px;
        }

        .notification {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-bottom: 15px;
            transform: translateX(100%);
            transition: transform 0.5s ease-out, opacity 0.5s ease-out;
            display: flex;
            align-items: center;
            opacity: 0;
        }

        .notification.hidden {
            opacity: 0;
            transform: translateX(100%);
        }

        .notification:not(.hidden) {
            opacity: 1;
            transform: translateX(0);
        }

        .innernoti {
            padding: 10px;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            width: 100%;
            border-radius: 7px;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            margin-right: 15px;
        }

        .text-content {
            flex-grow: 1;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .notification-title {
            font-weight: bold;
        }

        .close-btn {
            cursor: pointer;
            border: none;
            background-color: transparent;
            font-size: 1.2rem;
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
                    $imageData = base64_encode($row['profile_image']);
                    echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Profile Picture" class="rounded-circle border border-3">';
                } else {
                    echo '<img src="' . $defaultProfileImage . '" alt="Profile Picture" class="rounded-circle border border-3">';
                }
                ?>
            </div>
            <?php echo $_SESSION['firstname']; ?>
            <nav>
                <ul>
                 
                    <button id="dashboard">
                        <i class="fas fa-home" style="vertical-align: middle;"></i> Home
                    </button>

                    <button id="profile">
                        <a href="editprofile.php" style="text-decoration: none; color: inherit;">
                            <i class="fas fa-edit" style="vertical-align: middle;"></i> Edit Profile
                        </a>
                    </button>

                    <button id="activity">
                        <i class="fas fa-chart-line" style="vertical-align: middle;"></i> Activity
                    </button>

                    <a href="remainingsession.php" style="text-decoration: none;">
                        <button id="view">
                            <i class="fas fa-laptop" style="vertical-align: middle;"></i> View Remaining Session
                        </button>
                    </a>

                    <a href="historysitin.php" style="text-decoration: none;">
                        <button id="view">
                            <i class="fas fa-history" style="vertical-align: middle;"></i> History of Sitin
                        </button>
                    </a>

                    <a href="viewannouncement.php" style="text-decoration: none;">
                        <button id="view">
                            <i class="fas fa-bullhorn" style="vertical-align: middle;"></i> View Announcement
                        </button>
                    </a>

                    <a href="feedback.php" style="text-decoration: none;">
                        <button id="view">
                            <i class="fas fa-flag" style="vertical-align: middle;"></i> Feedback/Report
                        </button>
                    </a>

                    <a href="future_reservation.php" style="text-decoration: none;">
                        <button id="view">
                            <i class="fa-solid fa-desktop" style="vertical-align: middle;"></i> Future Reservation
                        </button>
                    </a>

                    <a href="labrules.php" style="text-decoration: none;">
                        <button id="view">
                            <i class="fa-regular fa-newspaper" style="vertical-align: middle;"></i> Lab Rules
                        </button>
                    </a>

                    <br>
                    <button id="logout" onclick="logout()">
                        <i class="fas fa-sign-out-alt" style="vertical-align: middle;"></i> Log Out
                    </button>
                </ul>
            </nav>
        </div>

        <div id="content">
            <h1 style="font-size: 28px; color: #00000; margin-bottom: 20px;">Welcome, <?php echo $_SESSION['firstname']; ?> </h1>

            <?php if ($approved): ?>
                <div class="message" style="background-color: #28a745; color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <p style="font-size: 18px; line-height: 1.6;">
                         Your reservation for <?php echo $reservation['purpose']; ?> in laboratory <?php echo $reservation['laboratory']; ?> on <?php echo $reservation['reservation_date']; ?> has been approved.
                    </p>
                    <p style="font-size: 18px; line-height: 1.6;">
                        Wait for: <?php echo $reservation['reservation_time']; ?>
                    </p>
                    <p style="font-size: 18px; line-height: 1.6;">
                        PC number: <?php echo isset($reservation['pc_number']) ? $reservation['pc_number'] : 'Not assigned'; ?>
                    </p>
                    <p style="font-size: 18px; line-height: 1.6;">
                        Status: <?php echo $reservation['status']; ?>
                    </p>
                    <button style="background-color: transparent; border: none; color: #fff; cursor: pointer;" onclick="closeMessage()">Close</button>
                </div>

                <div class="notification-container">
                    <!-- Notifications will be injected here -->
                </div>

            <?php elseif ($rejected): ?>
                <div class="message" style="background-color: #dc3545; color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <p style="font-size: 18px; line-height: 1.6;">
                        Sorry, your reservation has been rejected because the time you selected is fully booked.
                    </p>
                    <button style="background-color: transparent; border: none; color: #fff; cursor: pointer;" onclick="closeMessage()">Close</button>
                </div>
            <?php else: ?>
                <!-- No reservation message -->
            <?php endif; ?>

            <br>
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
            function closeMessage() {
                document.querySelector('.message').style.display = 'none';
            }

            function logout() {
                var confirmLogout = confirm("Are you sure you want to log out?");
                if (confirmLogout) {
                    window.location.href = 'login.php';
                }
            }
        </script>
    </div>
</body>

</html>
