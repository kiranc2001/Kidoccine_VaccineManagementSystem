


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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $hospitalName = $_POST["hospital_name"];
    $address = $_POST["address"];
    $email = $_POST["email"];

    // Handle file upload (certificate)
    $targetDir = "uploads/";
    $certificateName = basename($_FILES["certificate"]["name"]);
    $targetFilePath = $targetDir . $certificateName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if the file is a PDF
    if (strtolower($fileType) != "pdf") {
        die("Only PDF files are allowed.");
    }

    // Check file size (max 10MB)
    if ($_FILES["certificate"]["size"] > 10 * 1024 * 1024) {
        die("File size exceeds the maximum limit (10MB).");
    }

    // Upload the file
    if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $targetFilePath)) {
        // Insert data into the database
        $insertQuery = "INSERT INTO hospital_requests (hospital_name, address, certificate_path, email) 
                        VALUES ('$hospitalName', '$address', '$targetFilePath', '$email')";
        
        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Request Submitted'); window.location.href = 'index.php';</script>";

        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the file.";
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
    <title>Hospital Request Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        main {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            padding: 20px;
        }

        header {
            background-color: #333333;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 10px 10px 0 0;
        }

        form {
            padding: 0 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5em;
            color: #333333;
        }

        input {
            width: 100%;
            padding: 0.8em;
            margin-bottom: 1em;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 0.8em;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #217dbb;
        }

        .error-message {
            color: #e74c3c;
            margin-top: 1em;
            text-align: center;
        }
    </style>
</head>

<body>
    <main>
        <header>
            <h1>Hospital Request Form</h1>
        </header>

        <form method="post" action="hospital-request.php" enctype="multipart/form-data">
            <label for="hospital_name">Hospital Name:</label>
            <input type="text" id="hospital_name" name="hospital_name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="certificate">Govt Recognized Certificate (PDF, max 10MB):</label>
            <input type="file" id="certificate" name="certificate" accept=".pdf" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Submit Request</button>
        </form>
    </main>
</body>

</html>
