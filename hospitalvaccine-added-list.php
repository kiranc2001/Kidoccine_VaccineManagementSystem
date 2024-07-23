<?php
session_start();

// Check if the hospital is not logged in
if (!isset($_SESSION['hospital_email'])) {
    header("Location: hospital-login.php");
    exit();
}

// Database connection details
/*$host = "localhost";
$username = "root";
$password = "";
$database = "vaccine";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/
include 'db_connection.php';

// Fetch vaccines added by the hospital
$email = $_SESSION['hospital_email'];
$sql = "SELECT * FROM hospital_vaccines WHERE hospital_email = '$email' ORDER BY created_at DESC";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccines Added</title>
    <style>
        /* Your styles here */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff; /* Light Blue */
            color: #333; /* Dark Grey */
        }

        header {
            background-color: #4682b4; /* Steel Blue */
            color: white;
            padding: 1em;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2; /* Light Grey */
        }
    </style>
</head>
<body>
    <header>
        <h1>Vaccines Added</h1>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Vaccine Name</th>
                    <th>Stock</th>
                    <th>Vaccination Date</th>
                    <th>Price Type</th>
                    <th>Price</th>
                    <th>Added Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['vaccine_name']; ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td><?php echo $row['vaccination_date']; ?></td>
                            <td><?php echo $row['price_type']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6">No vaccines added yet.</td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="hospital_dashboard.php">Back to Dashboard</a>
    </main>
</body>
</html>
