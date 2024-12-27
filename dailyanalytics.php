<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "solon"; // Change this to your database name

// Create connection
$mysqli = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Initialize date variable
$date = date("Y-m-d");

// Check if date is provided in POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date'])) {
    $date = $_POST['date'];
}

// Fetch data from the database for laboratory
$sql_lab = "SELECT laboratory, COUNT(*) AS count FROM search WHERE date_r = ? GROUP BY laboratory";
$stmt_lab = $mysqli->prepare($sql_lab);
$stmt_lab->bind_param("s", $date);
$stmt_lab->execute();
$result_lab = $stmt_lab->get_result();

$dataPoints_lab = array();

if ($result_lab->num_rows > 0) {
    // Output data of each row
    while($row = $result_lab->fetch_assoc()) {
        $dataPoints_lab[] = array("label" => $row["laboratory"], "y" => $row["count"]);
    }
} else {
    echo "0 results";
}

// Fetch data from the database for purpose
$sql_purpose = "SELECT purpose, COUNT(*) AS count FROM search WHERE date_r = ? GROUP BY purpose";
$stmt_purpose = $mysqli->prepare($sql_purpose);
$stmt_purpose->bind_param("s", $date);
$stmt_purpose->execute();
$result_purpose = $stmt_purpose->get_result();

$dataPoints_purpose = array();

if ($result_purpose->num_rows > 0) {
    // Output data of each row
    while($row = $result_purpose->fetch_assoc()) {
        $dataPoints_purpose[] = array("label" => $row["purpose"], "y" => $row["count"]);
    }
} else {
    echo "0 results";
}

$mysqli->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvasjs@latest/dist/canvasjs.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #charts-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chart-container {
            width: 45%;
            height: 600px;
            margin-top: 50px;
            margin-left: 20px;
            margin-right: 20px;
            background-color: #C8C8C8; /* Set the background color here */
            color: #ffffff; /* Set the text color */
        }
        button {
            margin-top: 600px;
            text-align: center;
        }
        body {
            background-image: linear-gradient(to right, #6C757D, #343A40);
            /* Change the gradient colors as needed */
        }
    </style>
</head>
<body>
    
 
<div id="charts-container">
    <div class="chart-container" id="chartContainer_lab"></div>
    <div class="chart-container" id="chartContainer_purpose"></div>


    <form class="row g-3" method="post">
 <div class="col-auto">
 <div class="col-auto" style="margin-left: 100px; margin-bottom: 100px;">
    <button type="submit" class="btn btn-primary">Filter</button>
    <label for="date" class="col-form-label"><strong>Select Date:</strong>
    <input type="date" id="date" name="date" class="form-control" value="<?php echo $date; ?>">
    <a href="generatereport.php" class="btn btn-secondary">Go back</a>
</div>
    </form>    
    </div>

    <script>
        window.onload = function () {
            var chart_lab = new CanvasJS.Chart("chartContainer_lab", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Lab Utilization"
                },
                data: [{
                    type: "pie",
                    startAngle: 240,
                    yValueFormatString: "##0",
                    indexLabel: "{label} - #percent%",
                    dataPoints: <?php echo json_encode($dataPoints_lab, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart_lab.render();

            var chart_purpose = new CanvasJS.Chart("chartContainer_purpose", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Purpose Distribution"
                },
                data: [{
                    type: "pie",
                    startAngle: 240,
                    yValueFormatString: "##0",
                    indexLabel: "{label} - #percent%",
                    dataPoints: <?php echo json_encode($dataPoints_purpose, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart_purpose.render();
        }
    </script>
</body>
</html>
