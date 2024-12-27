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

// Handle approval or rejection of reservations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve'])) {
        $reservation_id = $_POST['reservation_id'];
        // Update status to "Approved" in futurereservation table
        $sql_update = "UPDATE futurereservation SET status = 'Approved' WHERE reservation_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $reservation_id);
        $stmt_update->execute();
        
        // Retrieve booking details
        $sql_select = "SELECT * FROM futurereservation WHERE reservation_id = ?";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bind_param("i", $reservation_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        $booking = $result_select->fetch_assoc();
        
        // Insert approved booking into search table
        $sql_insert = "INSERT INTO search (student_id, purpose, laboratory, time_in, date_r) VALUES (?, ?, ?, NOW(), NOW())";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iss", $booking['student_id'], $booking['purpose'], $booking['laboratory']);
        $stmt_insert->execute();
    } elseif (isset($_POST['reject'])) {
        $reservation_id = $_POST['reservation_id'];
        // Update status to "Rejected" in futurereservation table
        $sql = "UPDATE futurereservation SET status = 'Rejected' WHERE reservation_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
    }
}

// Fetch data from the futurereservation table
$sql = "SELECT * FROM futurereservation";
$result = $conn->query($sql);
?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
            height: 250vh;
            background-color:#3776A1;
            /* Replace 'path/to/your/image.jpg' with the actual path to your background image */
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

          
#content {
    padding: 20px;
}

.table {
    background-color: #fff;
    border: 1px solid #000;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.table thead {
    background-color: #000;
    color: #fff;
}

.table th, .table td {
    border: 1px solid #000;
}

.btn {
    border-radius: 4px;
}

.btn-success {
    background-color: #28a745;
    border: none;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
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


        <div id="content" class="p-4">
    <h2 class="mb-4">Booking Request and Approval</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped shadow">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Reservation ID</th>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Purpose</th>
                    <th>Laboratory</th>
                    <th>Reservation Date</th>
                    <th>Reservation Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = isset($row['reservation_id']) ? $row['reservation_id'] : '';
                        $student_id = isset($row['student_id']) ? $row['student_id'] : '';
                        $firstname = isset($row['firstname']) ? $row['firstname'] : '';
                        $lastname = isset($row['lastname']) ? $row['lastname'] : '';
                        $purpose = isset($row['purpose']) ? $row['purpose'] : '';
                        $laboratory = isset($row['laboratory']) ? $row['laboratory'] : '';
                        $reservation_date = isset($row['reservation_date']) ? $row['reservation_date'] : '';
                        $reservation_time = isset($row['reservation_time']) ? $row['reservation_time'] : '';
                        $status = isset($row['status']) ? $row['status'] : '';
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $student_id; ?></td>
                            <td><?php echo $firstname; ?></td>
                            <td><?php echo $lastname; ?></td>
                            <td><?php echo $purpose; ?></td>
                            <td><?php echo $laboratory; ?></td>
                            <td><?php echo $reservation_date; ?></td>
                            <td><?php echo $reservation_time; ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                            <form method="POST" style="display:inline-block;" onsubmit="return confirmApproval()">
                            <input type="hidden" name="reservation_id" value="<?php echo $id; ?>">
                            <button type="submit" name="approve" class="btn btn-success"><i class="fas fa-check"></i></button>
                        </form>

                                <form method="POST" style="display:inline-block; margin-left: 5px;">
                                    <input type="hidden" name="reservation_id" value="<?php echo $id; ?>">
                                    <button type="submit" name="reject" class="btn btn-danger"><i class="fas fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='10'>No reservations found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>







    </body>
    </html>

            </div>

        </div>

        <script>


function confirmApproval() {
        var confirmApprove = confirm("Are you sure you want to approve this booking?");
        if (confirmApprove) {
            alert("You are successfully approved!");
            return true; // Allow form submission
        } else {
            return false; // Prevent form submission
        }
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
