<?php
// Database connection details
include 'db_connection.php';
/*$host = "localhost";
$username = "root";
$password = "";
$database = "vaccine";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

// Fetch hospital requests
$sql = "SELECT * FROM hospital_requests
ORDER BY request_date DESC;
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Requests - Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .admin-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #3498db;
        }

        .request-container {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        p {
            margin: 0;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            margin-top: 10px;
        }

        label {
            margin-right: 10px;
        }

        input {
            margin-right: 5px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #217dbb;
        }

        .status-accepted {
            color: #2ecc71;
        }

        .status-rejected {
            color: #e74c3c;
        }
  .delete-button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <h2>Hospital Requests</h2>
<a href="adminhospital-management.php" style="margin-left:10px;margin-top:-5px;color:red; "> Go Back</a>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $hospitalName = $row['hospital_name'];
                $address = $row['address'];
                $certificatePath = $row['certificate_path'];
                $email = $row['email'];
                $status = $row['status'];
                $requestDate = $row['request_date'];

                echo "<div class='request-container'>";
                echo "<p><strong>Hospital Name:</strong> $hospitalName</p>";
                echo "<p><strong>Address:</strong> $address</p>";
                echo "<p><strong>Email:</strong> $email</p>";
                echo "<p><strong>Certificate:</strong> <a href='$certificatePath' target='_blank'>View Certificate</a></p>";
                echo "<p><strong>Request Date:</strong> $requestDate</p>";

                // Display status based on the database value
                if ($status == 'accept') {
                    echo "<p class='status-accepted'><strong>Status:</strong> Accepted</p>";
                } elseif ($status == 'reject') {
                    echo "<p class='status-rejected'><strong>Status:</strong> Rejected</p>";
                } else {
                    // If status is neither accepted nor rejected, display the form
                    echo "<form method='post' action='process-hospital-request.php'>";
                    echo "<input type='hidden' name='request_id' value='$id'>";
                    echo "<label for='accept'>Accept</label>";
                    echo "<input type='radio' name='status' value='accept' required>";
                    echo "<label for='reject'>Reject</label>";
                    echo "<input type='radio' name='status' value='reject' required>";
                    echo "<button type='submit'>Submit</button>";
                    echo "</form>";

                    // Delete Request button
                    echo "<form method='post' action='delete-hospital-request.php'>";
                    echo "<input type='hidden' name='request_id' value='$id'>";
                    echo "<button type='submit' class='delete-button'>Delete Request</button>";
                    echo "</form>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No pending hospital requests.</p>";
        }
        ?>

          </div>
</body>

</html>
``
