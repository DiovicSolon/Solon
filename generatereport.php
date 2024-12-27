<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // JavaScript code for processing data and drawing Google Chart
        // Insert the JavaScript code provided earlier here
    </script>
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
            overflow-y: auto;
            max-height: 500vh;
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
            transition: background-color 0.3s;
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
            background-color: #87CEEB;
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
            background-color: #e74c3c;
        }

        #logout:hover {
            background-color: #c0392b;
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
        <div id="content" style="text-align: left; background-color: #EDEADE; padding: 20px;">
            <h2 style="margin-bottom: 20px; font-family: Arial, sans-serif; color: #333;">Generate Reports</h2>
           <!-- Add an input field for student ID -->
<form method="post" style="display: inline-block;">
    
</form>


            <form method="post" style="display: inline-block;">
         
                <label for="report-date" style="margin-right: 10px; font-family: Arial, sans-serif; color: #555;">Select Date:</label>
                <input type="date" id="report-date" name="report_date" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc; font-family: Arial, sans-serif; color: #555;">
               
           

                <!-- New button and dropdown for selecting purpose -->
                <label for="purpose" style="margin-left: 20px; margin-right: 10px; font-family: Arial, sans-serif; color: #555;">Select Purpose:</label>
                <select id="purpose" name="purpose" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc; font-family: Arial, sans-serif; color: #555;">
                    <option value="all">All</option>
                    <option value="Python">Python</option>
                    <option value="C#">C#</option>
                    <option value="HTML">HTML</option>
                    <option value="Java">Java</option>
                </select>

                <label for="lab" style="margin-left: 20px; margin-right: 10px; font-family: Arial, sans-serif; color: #555;">Select Laboratory:</label>
                <select id="lab" name="lab" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc; font-family: Arial, sans-serif; color: #555;">
                    <option value="all">All</option>
                    <option value="524">524</option>
                    <option value="526">526</option>
                    <option value="528">528</option>
                    <option value="530">530</option>
                </select>
                <button type="submit" name="generate_report" style="padding: 8px 16px; border: none; background-color: #4CAF50; color: #fff; border-radius: 4px; cursor: pointer; font-family: Arial, sans-serif;">Generate Report</button>
               
               <a button type="submit"   href="dailyanalytics.php" name="daily_analytics" style="padding: 8px 16px; border: none; background-color: #2196F3; color: #fff; border-radius: 4px; cursor: pointer; font-family: Arial, sans-serif; margin-left: 10px;">Daily Analytics</button>
             </a>
            </form>
            

            <?php
// Establishing a connection to the database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "solon"; // Change this to your database name

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$report_date = ""; // Initialize $report_date variable




    // Query to fetch data for the provided student ID
  

// Proceed with your SQL query
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) {
    $lab = $_POST['lab'];
    $purpose = $_POST['purpose'];

   

    // Check if date is selected
    if(isset($_POST['report_date']) && !empty($_POST['report_date'])){
        $report_date = $_POST['report_date'];

        // Query to fetch student IDs, purpose, and lab who were sitting in on the selected date and lab
        if ($purpose === 'all' && $lab === 'all') {
            $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE DATE(time_in) = '$report_date' AND time_out IS NOT NULL";
        
        
        } elseif ($purpose === 'all') {
            $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE DATE(time_in) = '$report_date' AND laboratory = '$lab' AND time_out IS NOT NULL";
        
        } elseif ($lab === 'all') {
            $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE DATE(time_in) = '$report_date' AND purpose = '$purpose' AND time_out IS NOT NULL";
        } else {
            $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE DATE(time_in) = '$report_date' AND purpose = '$purpose' AND laboratory = '$lab' AND time_out IS NOT NULL";
        }


        
     } elseif ($purpose === 'Python' && $lab === '524') {
        // If purpose is 'Python' and laboratory is 524, fetch all records for laboratory 524 with purpose Python
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Python' AND laboratory = '524' AND time_out IS NOT NULL";   
    } elseif ($purpose === 'Python' && $lab === '526') {
        // If purpose is 'Python' and laboratory is 524, fetch all records for laboratory 524 with purpose Python
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Python' AND laboratory = '526' AND time_out IS NOT NULL";
    } elseif ($purpose === 'Python' && $lab === '526') {
        // If purpose is 'Python' and laboratory is 524, fetch all records for laboratory 524 with purpose Python
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Python' AND laboratory = '526' AND time_out IS NOT NULL";
    } elseif ($purpose === 'Python' && $lab === '528') {
        // If purpose is 'Python' and laboratory is 524, fetch all records for laboratory 524 with purpose Python
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Python' AND laboratory = '528' AND time_out IS NOT NULL";
    } elseif ($purpose === 'Python' && $lab === '530') {
        // If purpose is 'Python' and laboratory is 524, fetch all records for laboratory 524 with purpose Python
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Python' AND laboratory = '530' AND time_out IS NOT NULL";
 
    } elseif ($purpose === 'C#' && $lab === '524') {
        // If purpose is 'C#' and laboratory is 524, fetch all records for laboratory 524 with purpose C#
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'C#' AND laboratory = '524' AND time_out IS NOT NULL";
    } elseif ($purpose === 'C#' && $lab === '526') {
        // If purpose is 'C#' and laboratory is 524, fetch all records for laboratory 524 with purpose C#
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'C#' AND laboratory = '526' AND time_out IS NOT NULL";
    } elseif ($purpose === 'C#' && $lab === '528') {
        // If purpose is 'C#' and laboratory is 524, fetch all records for laboratory 524 with purpose C#
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'C#' AND laboratory = '528' AND time_out IS NOT NULL";
    } elseif ($purpose === 'C#' && $lab === '530') {
        // If purpose is 'C#' and laboratory is 524, fetch all records for laboratory 524 with purpose C#
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'C#' AND laboratory = '530' AND time_out IS NOT NULL";
 
    } elseif ($purpose === 'HTML' && $lab === '524') {
        // If purpose is 'HTML' and laboratory is 524, fetch all records for laboratory 524 with purpose HTML
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'HTML' AND laboratory = '524' AND time_out IS NOT NULL";
    } elseif ($purpose === 'HTML' && $lab === '526') {
        // If purpose is 'HTML' and laboratory is 524, fetch all records for laboratory 524 with purpose HTML
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'HTML' AND laboratory = '526' AND time_out IS NOT NULL";
    } elseif ($purpose === 'HTML' && $lab === '528') {
        // If purpose is 'HTML' and laboratory is 524, fetch all records for laboratory 524 with purpose HTML
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'HTML' AND laboratory = '528' AND time_out IS NOT NULL";
    } elseif ($purpose === 'HTML' && $lab === '530') {
        // If purpose is 'HTML' and laboratory is 524, fetch all records for laboratory 524 with purpose HTML
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'HTML' AND laboratory = '530' AND time_out IS NOT NULL";

    } elseif ($purpose === 'Java' && $lab === '524') {
        // If purpose is 'HTML' and laboratory is 524, fetch all records for laboratory 524 with purpose HTML
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Java' AND laboratory = '524' AND time_out IS NOT NULL";
    } elseif ($purpose === 'Java' && $lab === '526') {
        // If purpose is 'HTML' and laboratory is 524, fetch all records for laboratory 524 with purpose HTML
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Java' AND laboratory = '526' AND time_out IS NOT NULL";
    } elseif ($purpose === 'Java' && $lab === '528') {
        // If purpose is 'HTML' and laboratory is 524, fetch all records for laboratory 524 with purpose HTML
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Java' AND laboratory = '528' AND time_out IS NOT NULL";
    } elseif ($purpose === 'Java' && $lab === '530') {
        // If purpose is 'HTML' and laboratory is 524, fetch all records for laboratory 524 with purpose HTML
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Java' AND laboratory = '530' AND time_out IS NOT NULL";


    } elseif ($purpose === 'Python') {
        // If only purpose Python is selected without a specific date or laboratory, fetch all records for purpose Python
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Python' AND time_out IS NOT NULL";
    } elseif ($purpose === 'C#') {
        // If only purpose Python is selected without a specific date or laboratory, fetch all records for purpose Python
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'C#' AND time_out IS NOT NULL";
    } elseif ($purpose === 'HTML') {
        // If only purpose Python is selected without a specific date or laboratory, fetch all records for purpose Python
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'HTML' AND time_out IS NOT NULL";
    } elseif ($purpose === 'Java') {
        // If only purpose Python is selected without a specific date or laboratory, fetch all records for purpose Python
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE purpose = 'Java' AND time_out IS NOT NULL";


    } elseif ($lab === '524') {
        // If only laboratory 524 is selected without a specific date or purpose, fetch all records for laboratory 524
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE laboratory = '524' AND time_out IS NOT NULL";
    } elseif ($lab === '526') {
        // If only laboratory 524 is selected without a specific date or purpose, fetch all records for laboratory 524
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE laboratory = '526' AND time_out IS NOT NULL";
    } elseif ($lab === '528') {
        // If only laboratory 524 is selected without a specific date or purpose, fetch all records for laboratory 524
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE laboratory = '528' AND time_out IS NOT NULL";
    } elseif ($lab === '530') {
        // If only laboratory 524 is selected without a specific date or purpose, fetch all records for laboratory 524
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE laboratory = '530' AND time_out IS NOT NULL";
    } else {
        // If date is not selected and lab is not 524, fetch all records
        $sql = "SELECT student_id, purpose, laboratory, time_in, time_out FROM search WHERE time_out IS NOT NULL";
    }
     // Rest of the PHP code remains the same

     $result = $conn->query($sql);

     if ($result->num_rows > 0) {
         echo "<div style='margin-bottom: 20px;'>";
         echo "<h3 style='color: #333; font-size: 24px; margin-bottom: 10px;'>Student Report for $report_date lab $lab, $purpose</h3>";
         echo "<div style='overflow-x: auto;'>";
         echo "<table style='border-collapse: collapse; width: 100%;'>";
         echo "<tr style='background-color: #4CAF50; color: #fff;'>";
         echo "<th style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>Student ID</th>";
         echo "<th style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>First Name</th>";
         echo "<th style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>Last Name</th>";
         echo "<th style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>Purpose</th>";
         echo "<th style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>Lab</th>";
         echo "<th style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>Time In</th>";
         echo "<th style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>Time Out</th>";
         echo "</tr>";

         while ($row = $result->fetch_assoc()) {
             // Fetching firstname and lastname from registration table
             $student_id = $row['student_id'];
             $registrationQuery = "SELECT firstname, lastname FROM registration WHERE student_id = '$student_id'";
             $registrationResult = $conn->query($registrationQuery);
             $registrationRow = $registrationResult->fetch_assoc();

             echo "<tr style='background-color: #f2f2f2;'>";
             echo "<td style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>" . $row['student_id'] . "</td>";
             echo "<td style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>" . $registrationRow['firstname'] . "</td>";
             echo "<td style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>" . $registrationRow['lastname'] . "</td>";
             echo "<td style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>" . $row['purpose'] . "</td>";
             echo "<td style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>" . $row['laboratory'] . "</td>";
             echo "<td style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>" . $row['time_in'] . "</td>";
             echo "<td style='border: 1px solid #dddddd; padding: 12px; text-align: left;'>" . $row['time_out'] . "</td>";
             echo "</tr>";
         }
         echo "</table>";
         echo "</div>";
         echo "</div>";
     } else {
         echo "<p>No students were sitting in on $report_date on $lab, $purpose.</p>";
     }
    }


            
            // Close the connection
            $conn->close();
            ?>

            <!-- Print button -->
            <button id="printButton" style="padding: 8px 16px; border: none; background-color: #4CAF50; color: #fff; border-radius: 4px; cursor: pointer; font-family: Arial, sans-serif; margin-top: 20px;" onclick="printReport()">Print Report</button>

            <script>
                function logout() {
                    var confirmLogout = confirm("Are you sure you want to log out?");
                    if (confirmLogout) {
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

        </div>
    </div>

</body>

</html>