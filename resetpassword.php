<?php
// Database connection parameters
$hostname = "localhost"; 
$username = "root";
$password = ""; // Update with your database password if set
$database = "solon"; // Update with your database name

// Create database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$message = "";
$error_message = "";
$student_info = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if ID number is provided
    if (empty($_POST['student_id'])) {
        $error_message = "Please enter a student ID number.";
    } else {
        // Retrieve ID number from the form
        $student_id = $_POST['student_id'];
        
        // Check if the student exists
        $sql = "SELECT * FROM registration WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // If student exists, retrieve student information
        if ($result->num_rows > 0) {
            $student_info = $result->fetch_assoc();
        } else {
            $error_message = "Student with ID number $student_id not found.";
        }
    }

    // Check if form is submitted for password reset
    if (isset($_POST['reset_password'])) {
        $student_id = $_POST['student_id'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Check if passwords match
        if ($new_password !== $confirm_password) {
            $error_message = "Passwords do not match!";
        } else {
            // Hash the new password before storing it in the database
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update password and confirm_password in the database
            $sql_update = "UPDATE registration SET password = ?, confirm_password = ? WHERE student_id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssi", $hashed_password, $confirm_password, $student_id);
            
            if ($stmt_update->execute()) {
                echo "<script>alert('Password reset successfully!');</script>";
            } else {
                $error_message = "Error resetting password: " . $conn->error;
                echo "<script>alert('$error_message');</script>";
            }
            
        }
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
            .form-label {
                color: #333;
                font-weight: bold;
            }

            .form-control {
                margin-bottom: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 10px;
                width: 50%;
            }

            .btn-submit {
                background-color: #1B1212;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-submit:hover {
                background-color: #333;
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
            <h2 class="text-center mb-4">Admin Reset Password</h2>
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
            <h5 class="card-title mb-4" style="color: #333; font-weight: bold;">Student Information</h5>
            <div class="mb-3" style="border-bottom: 1px solid #000000;">
                <p class="mb-0"><strong style="color: #333; color: black;">Name:</strong> <?php echo $student_info['firstname'] . ' ' . $student_info['lastname']; ?></p>
            </div>
            <div class="mb-3" style="border-bottom: 1px solid #000000;">
                <p class="mb-0"><strong style="color: #333; color: black;">Email:</strong> <?php echo $student_info['email']; ?></p>
            </div>

            <form method="POST" class="p-4 rounded shadow-sm" style="background-color: #a5b5c3; border: 2px solid  #a5b5c3; transition: all 0.3s ease;">
        <input type="hidden" name="student_id" value="<?php echo $student_info['student_id']; ?>">
        <div class="mb-4">
            <label for="new_password" class="form-label" style="color: #333; color:black;">New Password:</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required style="border-color: #aaa; color: #555; padding: 10px; transition: border-color 0.3s ease, color 0.3s ease;">
        </div>
        <div class="mb-4">
            <label for="confirm_password" class="form-label" style="color: #333; color:black;">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required style="border-color: #aaa; color: #555; padding: 10px; transition: border-color 0.3s ease, color 0.3s ease;">
        </div>
        <button type="submit" class="btn btn-primary" style="background-color: #4CAF50; border: none; padding: 10px 20px; transition: background-color 0.3s ease;" name="reset_password">Reset Password</button>
    </form>

        </div>
    </div>
    
<?php endif; ?>

        </div>
    </body>
    </html>

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
