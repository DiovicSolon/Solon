<?php
// Database connection parameters
$hostname = "localhost";
$username = "root";
$password = "";
$database = "solon";
// Connect to MySQL database
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve student ID from POST data
    $studentId = $_POST["studentId"];

    // SQL query to fetch student information based on student ID
    $sql = "SELECT * FROM registration WHERE student_id = '$studentId'";

    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Student found, display student information
        $studentData = $result->fetch_assoc();
        echo "<p><strong>Student ID:</strong> " . $studentData["student_id"] . "</p>";
        echo "<p><strong>Name:</strong> " . $studentData["firstname"] . "</p>";
        echo "<p><strong>Email:</strong> " . $studentData["email"] . "</p>";
        // Add more fields as needed
    } else {
        // Student not found
        echo "Student ID: $studentId not found.";
    }
}

// Close the database connection
$conn->close();
?>
