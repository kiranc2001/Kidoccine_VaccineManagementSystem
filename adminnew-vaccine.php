<?php
// Resume the session
session_start();

// Check if the admin is not logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin-login.php");
    exit();
}
include 'db_connection.php';
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

// Fetch hospital added vaccines with hospital details
$sql = "SELECT * FROM hospital_vaccines ORDER BY created_at DESC";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Added Vaccines</title>
    <style>
        /* Your CSS styles here */

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
        <h1>Hospital Added Vaccines</h1>
 <a href="adminvaccine-management.php" style="color:white;">Go Back</a>

    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Hospital Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Vaccine Name</th>
                    <th>Stock</th>
                    <th>Vaccination Date</th>
                    <th>Price Type</th>
                    <th>Price</th>
                    <th>Date Added</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['hospital_name']; ?></td>
                            <td><?php echo $row['hospital_email']; ?></td>
                            <td><?php echo $row['hospital_address']; ?></td>
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
                            <td colspan="9">No hospital added vaccines yet.</td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>


    </main>
</body>

</html>
