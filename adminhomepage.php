


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        
        #searchForm {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        #searchForm label {
            display: block;
            margin-bottom: 10px;
        }

        #searchForm input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #cccccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        #searchForm button {
            background-color: #4caf50;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #searchForm button:hover {
            background-color: #45a049;
        }

       

        #sitInRecordsTable button:hover {
            background-color: #45a049;
        }

        #searchForm input[type="text"] {
            width: 80%;
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
                    
                   <!-- Include Font Awesome CSS -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                <button id="search" onclick="toggleSearchForm()">
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

                    <a href="bookingapproval.php" style="text-decoration: none;">
                  <button id="sitin">
                  <i class="fa-solid fa-thumbs-up"></i>
                    Booking Approval
                 </button>
                   </a>


                </ul>
                <button id="logout" onclick="logout()">
    <i class="fas fa-sign-out-alt" style="vertical-align: middle;"></i> Log Out
</button>
            </nav>
        </div>

        <div id="content">
       <div>
      
        </div>
       
    

      
        <div id="content">
            <div id="searchForm" style="display: none;">
                <form id="searchFormId" method="post" action="" onsubmit="performSearch(); return false;">
                    <label for="searchInput">Search:</label>
                    <input type="text" id="searchInput" name="searchInput" required>
                    <button type="submit">Submit</button>
                </form>

            </div>
        </div>
       

      
        <script>

        var searchForm = document.getElementById('searchForm');

                function toggleSearchForm() {
            var searchForm = document.getElementById("searchForm");
            var welcomeMessage = document.getElementById("content").querySelector("div");

            if (searchForm.style.display === "none") {
                searchForm.style.display = "block";
                welcomeMessage.style.display = "none"; // Hide the welcomeMessage div
            } 
        }

                function performSearch() {
    var searchInputValue = document.getElementById('searchInput').value;
    var searchForm = document.getElementById('searchForm');

    // Use AJAX to send the search input to the server
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server (e.g., display the result)
            var contentDiv = document.getElementById('content');
            contentDiv.innerHTML = xhr.responseText;
            // Hide the search form after submission
            searchForm.style.display = "none";
        }
    };

    
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('searchInput=' + encodeURIComponent(searchInputValue));

    // Prevent default form submission behavior
    event.preventDefault();
}


            


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
date_default_timezone_set('Asia/Manila'); // Set the timezone to Asia/Manila

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchInput"])) {
    $searchInput = $_POST["searchInput"];
    $searchQuery = "SELECT * FROM registration WHERE student_id = '$searchInput'";
    $result = $conn->query($searchQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();  // Fetch the first (and only) row

        $output = "<div style='text-align: center;'>";
        $output .= "<h1 style='color: white;'>Student Information</h1>";
        $output .= "<form style='background-color: #757575; padding: 20px; width: 95%; margin: 0 auto; border-radius: 20px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);' method='post'><br><br>";

        $output .= "<table style='margin: 0 auto;'>";
        $output .= "<tr style='background-color: #343434; color: white;'>";
        // ID Number
        $output .= "<th style='padding: 15px;'>ID Number</th>";
        // Full Name
        $output .= "<th style='padding: 15px;'>Full Name</th>";
        // Purpose
        $output .= "<th style='padding: 15px;'>Purpose</th>";
        // Laboratory
        $output .= "<th style='padding: 15px;'>Laboratory</th>";
        // Remaining Session
        $output .= "<th style='padding: 15px;'>Remaining Session</th>";
        $output .= "</tr>";

        $output .= "<tr>";
        // ID Number input
        $output .= "<td><input type='text' id='student_id' style='width: 200px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;' name='student_id' value='{$row['student_id']}' readonly></td>";
        // Full Name input
        $output .= "<td><input type='text' id='full_name' style='width: 200px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;' name='full_name' value='{$row['firstname']} {$row['lastname']}' readonly></td>";
        // Purpose select
        $output .= "<td>";
        $output .= "<select id='purpose' name='purpose' style='width: 200px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;'>";
        $output .= "<option value='python'>Python</option>";
        $output .= "<option value='c#'>C#</option>";
        $output .= "<option value='html'>Html</option>";
        $output .= "<option value='java'>Java</option>";
        $output .= "</select>";
        $output .= "</td>";
        // Laboratory input
        $output .= "<td><select id='lab' name='lab' style='width: 200px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;' required>";
        $output .= "<option value='524'>524</option>";
        $output .= "<option value='528'>528</option>";
        $output .= "<option value='526'>526</option>";
        $output .= "<option value='530'>530</option>";
        $output .= "</select></td>";
        
        // Remaining Session input (read-only)
        $output .= "<td><input type='text' id='remainingSession' name='remainingSession' style='width: 200px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;' value='{$row['remainingSession']}' readonly></td>";
        $output .= "</tr>";

        // Hidden time_in field
        $output .= "<input type='hidden' id='time_in' name='time_in' value=''>";

        $output .= "</table>";

        $output .= "<div style='text-align: center; margin-top: 20px;'>";
        $output .= "<button type='submit' name='sitin' style='background-color: #4CAF50; color: white; padding: 15px 30px; border: none; cursor: pointer; border-radius: 6px; font-size: 18px; transition: background-color 0.3s;'>Sit-in</button><br><br>";
        $output .= "</div>";

        $output .= "</form>";
        $output .= "</div>";

        echo $output;
    } else {
        $output = "<h1>Student Not Found</h1>";
        echo $output;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sitin"])) { // Check if the Sit-in button is clicked
    $student_id = $_POST["student_id"];
    $purpose = $_POST["purpose"];
    $lab = $_POST["lab"];
    $remainingSession = $_POST["remainingSession"];
    $time_in = date('Y-m-d h:i:s A'); // Format with 12-hour time
    $date_r = date('Y-m-d'); // Format with only date portion

    // Check if the record already exists in the search table
    $checkQuery = "SELECT * FROM search WHERE student_id = '$student_id'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        // If the record exists, update it
        $updateQuery = "INSERT INTO search (student_id, purpose, laboratory, time_in, date_r) VALUES ('$student_id', '$purpose', '$lab', '$time_in', '$date_r')";
        if ($conn->query($updateQuery) === TRUE) {
            echo "<h1>Sit-in updated successfully!</h1>";
        } else {
            echo "<h1>Error updating record: " . $conn->error . "</h1>";
        }
    } else {
        // If the record doesn't exist, insert a new one
        $insertQuery = "INSERT INTO search (student_id, purpose, laboratory, time_in, date_r) VALUES ('$student_id', '$purpose', '$lab', '$time_in', '$date_r')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "<h1>Sit-in successful!</h1>";
        } else {
            echo "<h1>Error: " . $conn->error . "</h1>";
        }
    }
}

$conn->close(); // Close the database connection
?>
