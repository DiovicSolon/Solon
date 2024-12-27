<?php
// Database connection parameters
$hostname = "localhost"; 
$username = "root";
$password = "";
$database = "solon"; // Changed to "solon" database

// Create database connection
$conn = new mysqli($hostname, $username, $password, $database);

$message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $student_id = $_POST['student_id'];
    
    // Search for the student by ID
    $sql = "SELECT * FROM registration WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student_info = $result->fetch_assoc();
    } else {
        $error_message = "Student with ID $student_id not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $student_id = $_POST['student_id'];

    // Reset remaining session to default value (30)
    $sql = "UPDATE registration SET remainingSession = 30 WHERE student_id = '$student_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Remaining session reset successfully.');</script>";
    } else {
        $error_message = "Error updating record: " . $conn->error;
        echo "<script>alert('$error_message');</script>";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

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
            width: 250px;
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
        
        .reset-btn {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 15px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 12px;
            border: none;
            transition: background-color 0.3s; /* Add a smooth transition effect */
        }

        .reset-btn:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        .success-message {
            background-color: #4CAF50;
            color: #fff;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
        }
                .card {
            width: 50%; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4); /* Increased shadow darkness */
            background-color: #a5b5c3;
            margin-top: 10px; 
            margin-left: 275px;
            margin-bottom: 20px; 
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
                    <img src="uploads/admin.jpg" alt="Admin Image">
                                 
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
            <h2 class="text-center mb-4">Admin Reset Session</h2>
            <?php if (!empty($message)) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="id_number">Student ID Number:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="id_number" name="student_id" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" name="search">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <?php if (!empty($student_info)) : ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Display student information -->
                        <h5 class="card-title mb-4" style="color: #333; font-weight: bold;">Student Information</h5>
                        <div class="mb-3" style="border-bottom: 1px solid #ddd;">
                            <p class="mb-0"><strong style="color: #333; color: black;">Name:</strong> <?php echo $student_info['firstname'] . ' ' . $student_info['lastname']; ?></p>
                        </div>
                        <div class="mb-3" style="border-bottom: 1px solid #ddd;">
                            <p class="mb-0"><strong style="color: #333; color: black;">Email:</strong> <?php echo $student_info['email']; ?></p>

                     
                        </div>
                                            <!-- Form to reset remaining session -->
                    <form method="POST" style="text-align: center;">
                        <input type="hidden" name="student_id" value="<?php echo $student_info['student_id']; ?>">
                        <button type="submit" class="reset-btn" name="reset">Reset Session</button>
                    </form>

                    </div>
                </div>
                <!-- Form to reset remaining session -->
            <?php endif; ?>
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
