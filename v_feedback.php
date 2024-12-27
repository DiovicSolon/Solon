<?php
session_start(); // Start the session if not already started

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if feedback data is available in the session
if (!isset($_SESSION['feedback'])) {
    // Redirect back to viewsitin.php if feedback data is not available
    header("Location: viewsitin.php");
    exit;
}

// If the "Close" button is clicked
if (isset($_POST['close'])) {
    // Redirect back to viewsitin.php
    header("Location: viewsitin.php");
    exit;
}

// Include your database connection code here if needed

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <!-- Add your CSS link here -->
</head>
<body>
    <h2>Feedback</h2>
    <!-- Display feedback in a form -->
    <form>
        <label for="feedback">Your Feedback:</label><br>
        <textarea id="feedback" name="feedback" rows="4" cols="50" readonly><?php echo $_SESSION['feedback']; ?></textarea><br>
        <!-- Add any other feedback fields here if needed -->
        <input type="submit" name="close" value="Close">
    </form>
</body>
</html>
