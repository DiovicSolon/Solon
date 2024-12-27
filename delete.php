<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

     <script>
        function logout() {
            var confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                window.location.href = 'login.php';
            }
        }

    </script>


    </body>

    </html>
    <?php
    $hostname = "localhost"; // replace with your actual database hostname
    $username = "root";
    $password = "";
    $database = "solon";

    $conn = new mysqli($hostname, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            // Handle update action
        } elseif (isset($_POST['confirm_delete'])) {
            // Handle delete action
            $delete_id = $_POST['confirm_delete'];
            // Perform delete action based on v_id
            $delete_sql = "DELETE FROM search WHERE v_id = '$delete_id'";
            if ($conn->query($delete_sql) === TRUE) {
                echo "<script>alert('Record deleted successfully');</script>";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    }

    $sql = "SELECT v_id, student_id, purpose, laboratory, time_in FROM search"; // Select v_id along with other columns
    $result = $conn->query($sql);

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
            padding: 20px;
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
            background-color: #4CAF50;
            color: white;
            margin-right: 5px;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
    </style>";

 echo "<div class='container'>";
    echo "<h2>Solon Records</h2>";

    if ($result->num_rows > 0) {
        echo "<form method='post'>";
        echo "<table>";
        echo "<tr>
                <th>#</th> <!-- Add column header for v_id -->
                <th>Student ID</th>
                <th>Purpose</th>
                <th>Laboratory</th>
                <th>Time In</th>
                <th>Action</th>
              </tr>";
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                // Change the size and font of v_id
                echo "<td style='font-size: 12px; font-family: Arial, sans-serif;'>" . $row["v_id"] . "</td>"; 
                echo "<td><input type='text' value='" . $row["student_id"] . "' readonly></td>";
                echo "<td><input type='text' value='" . $row["purpose"] . "' readonly></td>";
                echo "<td><input type='text' value='" . $row["laboratory"] . "' readonly></td>";
                echo "<td><input type='text' value='" . $row["time_in"] . "' readonly></td>";
                echo "<td>
                <button class='btn-delete' type='submit' name='confirm_delete' value='" . $row["v_id"] . "' onclick='return confirmDelete()'>Delete</button>
              </td>";
        
                echo "</tr>";
            }
            
        
        echo "</table>";
        echo "</form>";
    } else {
        echo "No results";
    }

    echo "</div>";
   


    $conn->close();
    ?>
    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>
</body>
</html>