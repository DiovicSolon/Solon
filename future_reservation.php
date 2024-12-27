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

$student_id = $_SESSION['student_id']; // Assuming you have student_id stored in session
$sql = "SELECT lastname FROM registration WHERE student_id = '$student_id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastname = $row['lastname'];
} else {
    // Handle the case where the last name is not available
    $lastname = 'Last Name Not Available';
}

// Define the default profile image path
$defaultProfileImage = "uploads/default.jpg";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_SESSION['student_id'];
    $firstname = $_SESSION['firstname'];
    $lastname = $lastname;
    $purpose = $_POST['purpose'];
    $laboratory = $_POST['laboratory'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $pc_number = $_POST['pc_number'];

    $sql = "INSERT INTO futurereservation (student_id, firstname, lastname, purpose, laboratory, reservation_date, reservation_time, pc_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssi", $student_id, $firstname, $lastname, $purpose, $laboratory, $reservation_date, $reservation_time, $pc_number);

    if ($stmt->execute()) {
        echo "<script>alert('Reservation submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
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

        #reservation-form {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        #reservation-form h2 {
            margin-bottom: 20px;
            color: #333;
        }

        #reservation-form label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        #reservation-form input,
        #reservation-form textarea,
        #reservation-form select {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }

        #reservation-form button {
            width: 100%;
            padding: 10px;
            background-color: #1A1A4A;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        #reservation-form button:hover {
            background-color: #333;
        }

        #content {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
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

                <a href="future_reservation.php" style="text-decoration: none;">
                    <button id="view" onclick="changeButtonColor(this)">
                        <i class="fa-solid fa-desktop" style="vertical-align: middle;"></i> Future Reservation
                    </button>
                </a>

                <a href="labrules.php" style="text-decoration: none;">
                    <button id="view" onclick="changeButtonColor(this)">
                        <i  class="fa-regular fa-newspaper" style="vertical-align: middle;"></i> Lab Rules
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
        <form id="reservation-form" method="POST" >
            <h2>Future Reservation</h2>
            <label for="student_id">Student ID:</label>
            <textarea id="student_id" name="student_id" readonly required><?php echo $_SESSION['student_id'];?></textarea>

            <label for="firstname">First Name:</label>
            <textarea id="firstname" name="firstname" readonly required><?php echo $_SESSION['firstname'];?></textarea>

            <label for="lastname">Last Name:</label>
            <textarea id="lastname" name="lastname" readonly required><?php echo $lastname;?></textarea>

            <label for="purpose">Purpose:</label>
            <select id="purpose" name="purpose" required>
                <option value="">Select Purpose</option>
                <option value="Python">Python</option>
                <option value="C#">C#</option>
                <option value="HTML">HTML</option>
                <option value="Java">Java</option>
            </select>

            <label for="laboratory">Laboratory:</label>
            <select id="laboratory" name="laboratory" required>
                <option value="">Select Laboratory</option>
                <option value="524">Lab 524</option>
                <option value="526">Lab 526</option>
                <option value="528">Lab 528</option>
                <option value="530">Lab 530</option>
            </select>

            <label for="reservation_date">Reservation Date:</label>
            <input type="date" id="reservation_date" name="reservation_date" required>

            <label for="reservation_time">Reservation Time:</label>
            <input type="time" id="reservation_time" name="reservation_time" required>

            <label for="pc_number">PC Number:</label>
            <select id="pc_number" name="pc_number" required>
                <option value="">Select PC Number</option>
                <?php
                for ($i = 1; $i <= 24; $i++) {
                    echo "<option value='$i'>PC $i</option>";
                }
                ?>
            </select>

            <button type="submit">Submit Reservation</button>
        </form>
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
