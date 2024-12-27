


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
 
    <!-- Optional Bootstrap theme -->
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
            width: 200px;
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
            padding: 70px;
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
        .report-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* Center the report text boxes horizontally */
}

.report-text {
    flex: 0 0 80%; /* Set the width of each report text box */
    max-width: 800px; /* Set a maximum width for the report text boxes */
    margin: 0 auto 20px; /* Center the report text boxes vertically and add space between them */
    font-size: 18px; /* Increase the font size */
    line-height: 1.6;
    color: #555; /* Dark gray text color */
    line-height: 1.8;
    padding: 20px; /* Increase padding for more space */
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Clear float for the next report text */
.report-text:nth-child(3n+1) {
    clear: both;
}
.report-box {
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #e6eff5; /* Soft and soothing blue-gray background */

    transition: transform 0.3s;
}


.report-box:hover {
    transform: translateY(-5px);
}
.report-box.large {
            /* Additional styles to make the box larger */
            transform: scale(1.1); /* Increase size by 10% */
            z-index: 999; /* Ensure it's on top of other elements */
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
        <?php
    // Your PHP code for database connection and querying
    $hostname = "localhost"; // replace with your actual database hostname
    $username = "root";
    $password = "";
    $database = "solon";

    $conn = new mysqli($hostname, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch report data from the database including id, report_text, and submitted_at, ordered by submitted_at in descending order
    $sql = "SELECT id, report_text, submitted_at FROM report ORDER BY submitted_at DESC";
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Output data of each row
        echo '<div class="report-container">';
        while ($row = $result->fetch_assoc()) {
            // Echo the report data with a wrapping div and specific classes for styling
            echo '<div class="report-box">';
            echo '<p class="submitted-at">Posted on: ' . $row["submitted_at"] . '</p>'; // Output submitted_at
          
            echo '<p class="report-text">' . $row["report_text"] . '</p>'; // Output report_text
            echo '</div>'; // close report-box
        }
        echo '</div>'; // close report-container
    } else {
        echo "0 results";
    }

    $conn->close();
?>



        <script>
 function toggleReportSize(event) {
            // Toggle the 'large' class on the clicked report box
            event.target.classList.toggle('large');

            // Remove the 'large' class from other report boxes
            const reportBoxes = document.querySelectorAll('.report-box');
            reportBoxes.forEach(box => {
                if (box !== event.target) {
                    box.classList.remove('large');
                }
            });
        }

        // Add event listeners to all report boxes
        const reportBoxes = document.querySelectorAll('.report-box');
        reportBoxes.forEach(box => {
            box.addEventListener('click', toggleReportSize);
        });
   

        function logout() {
            var confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                window.location.href = 'login.php';
            }
        }

    </script>



    

</body>

</html>