<?php
include 'db_connection.php';
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

// Initialize variables
$deleteMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $hospitalId = $_POST['id'];

    // Delete the hospital credentials
    $deleteCredentialsSql = "DELETE FROM hospital_credentials WHERE id = '$hospitalId'";
    if ($conn->query($deleteCredentialsSql) === TRUE) {
        $deleteMessage = "Hospital credentials deleted successfully.";
    } else {
        $deleteMessage = "Error deleting hospital credentials: " . $conn->error;
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
    <title>Delete Hospital</title>
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

        .confirmation-modal {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            padding: 20px;
            text-align: center;
        }

        .confirmation-modal p {
            margin: 10px 0;
        }

        button {
            background-color: #3498db;
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
            background-color: #217dbb;
        }
    </style>
</head>

<body>
    <div class="confirmation-modal">
        <?php
        if (!empty($deleteMessage)) {
            echo "<p>$deleteMessage</p>";
        }
        ?>
        <button onclick="redirectToHospitalList()">OK</button>
    </div>

    <script>
        function redirectToHospitalList() {
            window.location.href = 'hospital_list.php'; // Replace with your actual hospital list page
        }
    </script>
</body>

</html>
