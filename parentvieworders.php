<?php
session_start();
include 'db_connection.php';
// Check if user is logged in
if (!isset($_SESSION['phone'])) {
    header("Location: parentlogin.php");
    exit();
}

// Connect to the database
/*$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vaccine";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

// Get parent phone number from session
$parent_phone = $_SESSION['phone'];

// Fetch orders for the parent
$orders = "SELECT *, certificate_pdf FROM booked_vaccines WHERE parent_phone_number = '$parent_phone' ORDER BY created_at DESC";
$result = $conn->query($orders);

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 5px;
            margin-top: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action {
            text-align: center;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Orders</h2>
        <table>
            <tr>
                <th>Vaccine Name</th>
                <th>Child Name</th>
                <th>Father's Name</th>
                <th>Vaccination Date</th>
                <th>Hospital</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['vaccine_name']."</td>";
                    echo "<td>".$row['child_name']."</td>";
                    echo "<td>".$row['parent_name']."</td>";
                    echo "<td>".$row['vaccination_date']."</td>";
                    echo "<td>".$row['hospital']."</td>";
                    echo "<td>".$row['vaccination_status']."</td>";
                    echo "<td class='action'>";
                    if ($row['vaccination_status'] == 'completed') {
                        echo '<a href="download_certificate.php?id='.$row['id'].'">Download Certificate</a>';
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No orders found</td></tr>";
            }
            ?>
        </table>
        <br>
        <a href="parentdashboard.php">Go to Dashboard</a><br>
        <a href="parent-signout.php">Sign Out</a>
    </div>
</body>
</html>

