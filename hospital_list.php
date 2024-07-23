<?php
// Database connection details
/*$host = "localhost";
$username = "root";
$password = "";
$database = "vaccine";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/
include 'db_connection.php';

// Fetch approved hospitals
$sql = "SELECT id, hospital_name, address, email FROM hospital_credentials"; // Include id in the SELECT statement
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Hospitals</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .hospital-list-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 400px;
            padding: 20px;
            margin-top: 20px;
        }

        .hospital-container {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        button {
            background-color: #e74c3c;
            color: white;
            padding: 8px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #c0392b;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="hospital-list-container">
        <h2>Approved Hospitals</h2>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hospitalID = $row['id']; // Fetch the hospital ID
                $hospitalName = $row['hospital_name'];
                $address = $row['address'];
                $email = $row['email'];

                echo "<div class='hospital-container'>";
                echo "<p><strong>Hospital Name:</strong> $hospitalName</p>";
                echo "<p><strong>Address:</strong> $address</p>";
                echo "<p><strong>Email:</strong> $email</p>";
                echo "<form method='post' action='adminremove-hospital.php'>";
                echo "<input type='hidden' name='id' value='$hospitalID'>"; // Use single quotes to avoid interference with double quotes

                echo "<button type='submit'>Remove from Approved List</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No approved hospitals available.</p>";
        }
        ?>

        <a href="admin-dashboard.php">Back to Dashboard</a>
    </div>
</body>

</html>
