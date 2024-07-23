<?php
include 'db_connection.php';
// Database connection details
/*$host = "localhost";
$username = "root";
$password = "";
$database = "vaccine";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

// Query to get total number of hospitals
$sql_hospitals = "SELECT COUNT(*) as total_hospitals FROM hospital_credentials";
$result_hospitals = $conn->query($sql_hospitals);
$total_hospitals = $result_hospitals->fetch_assoc()['total_hospitals'];

// Query to get total number of registered parents
$sql_parents = "SELECT COUNT(*) as total_parents FROM parent";
$result_parents = $conn->query($sql_parents);
$total_parents = $result_parents->fetch_assoc()['total_parents'];

// Query to get total number of vaccines added
$sql_vaccines = "SELECT COUNT(*) as total_vaccines FROM added_vaccines";
$result_vaccines = $conn->query($sql_vaccines);
$total_vaccines = $result_vaccines->fetch_assoc()['total_vaccines'];

// Query to get total number of orders
$sql_orders = "SELECT COUNT(*) as total_orders FROM booked_vaccines";
$result_orders = $conn->query($sql_orders);
$total_orders = $result_orders->fetch_assoc()['total_orders'];

// Query to get total number of completed vaccines
$sql_completed_vaccines = "SELECT COUNT(*) as total_completed_vaccines FROM booked_vaccines WHERE vaccination_status = 'completed'";
$result_completed_vaccines = $conn->query($sql_completed_vaccines);
$total_completed_vaccines = $result_completed_vaccines->fetch_assoc()['total_completed_vaccines'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
        }

        .container h2 {
            margin-bottom: 20px;
        }

        .metric {
            display: inline-block;
            margin: 10px;
            padding: 20px;
            background-color: grey;
            border-radius: 5px;
        }
.metric1{
            display: inline-block;
            margin: 10px;
            padding: 20px;
            background-color: purple;
            border-radius: 5px;
        }
.metric2 {
            display: inline-block;
            margin: 10px;
            padding: 20px;
            background-color: green;
            border-radius: 5px;
        }
.metric4 {
            display: inline-block;
            margin: 10px;
            padding: 20px;
            background-color:yellow ;
            border-radius: 5px;
        }

        .metric h3 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Admin Management Dashboard</h2>
        <div class="metric">
            <h3>Total Hospitals</h3>
            <p><?php echo $total_hospitals; ?></p>
        </div>
        <div class="metric1">
            <h3>Total Registered Parents</h3>
            <p><?php echo $total_parents; ?></p>
        </div>
        <div class="metric2">
            <h3>Total Vaccines Added</h3>
            <p><?php echo $total_vaccines; ?></p>
        </div>
        <div class="metric">
            <h3>Total Orders</h3>
            <p><?php echo $total_orders; ?></p>
        </div>
        <div class="metric4">
            <h3>Total Vaccines Completed</h3>
            <p><?php echo $total_completed_vaccines; ?></p>
        </div>
    </div>
<a href="admin-dashboard.php" style="margin-top: 20px; display: block; text-align: center; color: #333; text-decoration: none; padding: 10px ; border: -5px solid #333; border-radius: 1px;">Go to Dashboard</a><br>
<a href="admin-signout.php" style="margin-top: -25px; display: block; text-align: center; color: #333; text-decoration: none; padding: 10px; border: -5px solid #333; border-radius: 5px;">Sign Out</a>

</body>


</html>
