<?php
$hostname = "localhost"; // replace with your actual database hostname
$username = "root";
$password = "";
$database = "solon";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the registration form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $studentid = $_POST["student_id"];
    $firstName = $_POST["firstname"];
    $middleName = $_POST["middlename"];
    $lastName = $_POST["lastname"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $year_level = $_POST["year_level"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $password = $_POST["password"];
	$confirmPassword = $_POST["confirm_password"];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
	// SQL query to insert data into the registration table
	$sql = "INSERT INTO registration (student_id, firstname, middlename, lastname, age, gender, year_level, email, contact, address, password, confirm_password) 
            VALUES ('$studentid', '$firstName', '$middleName', '$lastName', $age, '$gender', '$year_level', '$email', '$contact', '$address', '$hashedPassword', '$confirmPassword' )";
	if ($conn->query($sql) === TRUE) {
		
		//echo "Register Successfully proceed to login Page";
		
		 echo '<script type="text/javascript">
            var confirmed = window.confirm("Registration successful. Do you want to proceed to the login page?");
            if (confirmed) {
                window.location.href = "login.php";
            } else {
                window.location.href = "Register.php";
            }
          </script>';
        
		
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
	

}




// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #666, #000);
            margin-bottom: 20px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            
           
        }

        #activity {
            position: absolute;
            top: 20px;
            left: 20px;
            font-weight: bold;
            color: #333;
            font-size: 20px;
            color: #fff;
        }

        .registration-container {
            background-color: #999999;
            border-radius: 8px;
			margin: 2in auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            width: 200%;
            max-width: 500px;
            opacity: 0; /* Initial opacity set to 0 */
            animation: fadeIn 1s ease-out forwards; /* Animation definition */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #000;
			font-weight: bold;

        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 48%;
        }

        button.cancel {
            background-color: #f44336;
            width: 48%;
            margin-left: 2%;
        }

        button:hover {
            background-color: #45a049;
        }
		
		.login-button {
		text-align: center;
		margin-top: 10px; /* Adjust as needed */
		}
    </style>
</head>
<body>




<div class="registration-container">
    <h2><b>Registration</b></h2>
    <form action="register.php" method="post">
		<label for="student_id"><b>ID Number:</b></label>
		<input type="text" id="student_id" name="student_id" required>
        <label for="firstname"><b>First Name:</b></label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="middlename"><b>Middle Name:</b></label>
        <input type="text" id="middlename" name="middlename" required>

        <label for="lastname"><b>Last Name:</b></label>
        <input type="text" id="lastname" name="lastname" required>

        <label for="age"><b>Age:</b></label>
        <input type="number" id="age" name="age" required>

        <label for="gender"><b>Gender:</b></label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
		
		  <!-- New Year Level Field as Text -->
        <label for="year_level"><b>Year Level:</b></label>
        <input type="text" id="year_level" name="year_level" required>


        <label for="email"><b>Email:</b></label>
        <input type="email" id="email" name="email" required>

        <label for="contact"><b>Contact:</b></label>
        <input type="tel" id="contact" name="contact" required>
		
		<label for="address"><b>Address:</b></label>
        <textarea id="address" name="address" rows="4" required></textarea>
		

        <!-- New Password Fields -->
        <label for="password"><b>Password:</b></label>
        <input type="password" id="password" name="password" required>

        <label for="confirmPassword"><b>Confirm Password:</b></label>
        <input type="password" id="confirm_password" name="confirm_password" required>

          <button type="submit">Submit</button>
        <button type="button" class="cancel"><a href="register.php"  onclick="confirmCancel()" style="text-decoration: none;" >Cancel</button>
		
		
    </form>
		 <div class="login-button">
        <form action="login.php" method="post">
            <a>Already have an account?</a><br	>
            <button type="button" class="login" onclick="location.href='login.php'">Login</button>
        </form>
    </div>
</div>

<script>
    function confirmCancel() {
        var confirmCancel = confirm("Are you sure to cancel this registration?");
        if (confirmCancel) {
            window.location.href = 'register.php';
        }
    }
</script>

</body>
</html>