<?php
$hostname = "localhost"; 
$username = "root";
$password = "";
$database = "solon";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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


    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $profileImageTmp = $_FILES['profile_image']['tmp_name'];
        $profileImageName = $_FILES['profile_image']['name']; // Added to get the name of the file
        $profileImageExt = pathinfo($profileImageName, PATHINFO_EXTENSION); // Added to get the file extension
        $profileImageNewName = uniqid('', true) . '.' . $profileImageExt; // Generate a unique name for the file
        $profileImageDestination = 'uploads/' . $profileImageNewName; // Destination path where the file will be moved

        $uploadsDirectory = 'uploads/';
        if (!file_exists($uploadsDirectory)) {
            mkdir($uploadsDirectory, 0777, true); // Create the directory if it doesn't exist
        }

        
        if(move_uploaded_file($profileImageTmp, $profileImageDestination)) {
            $profileImageData = file_get_contents($profileImageDestination);
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        $profileImageData = null;
    }


    // Retrieve the ID (assuming it's sent through a hidden field or session)  
    $studentid = $_POST["student_id"]; // Or $id_number = $_SESSION['idNumber'];

    $sql = "UPDATE registration SET firstName = ?, middleName = ?, lastName = ?, age = ?, gender = ?, year_level = ?, email = ?, contact = ?, address = ?, profile_image = ? WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissssssi", $firstName, $middleName, $lastName, $age, $gender, $year_level, $email, $contact, $address, $profileImageData, $studentid);
    

    if ($stmt->execute()) {
        $_SESSION['firstname'] = $firstName;
        echo '<script type="text/javascript"> window.confirm("Profile updated successfully!"); window.location.href = "homepage.php"; </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if(isset($_GET['id'])){
    $student_id = $_GET['id'];
} else if(isset($_SESSION['student_id'])) {
    $student_id= $_SESSION['student_id'];
} else {
    // Handle the case where the ID is not available
    echo "Error: User ID not found.";
    exit();
}


// 
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

        /* Add a style for the image preview */
        #image-preview {
            max-width: 25%;
            height: auto;
            margin-top: 10px;
        }
    </style>
</head>
<body>


<div class="registration-container">
    <h2><b>Edit Profile</b></h2>
    <form action="editprofile.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
    
        <label for="profile_image">Profile Image:</label>
        <input type="file" id="profile_image" name="profile_image" onchange="previewImage(this)">
        <!-- Add an image preview element -->
        <img id="image-preview" src="#" alt="Image Preview">

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

        <button type="Save">Save Changes</button>
        <button type="button" class="cancel" onclick="confirmCancel(); location.href='homepage.php';">Cancel</button>
    </form>

    <script>
        function previewImage(input) {
            var preview = document.getElementById('image-preview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '#'; // Reset the preview if no file is selected
            }
        }
    </script>
</div>

<script>
    function confirmCancel() {
        var confirmCancel = confirm("Are you sure to cancel");
        if (confirmCancel) {
            window.location.href = 'homepage.php';
        }
    }
</script>

</body>
</html>
