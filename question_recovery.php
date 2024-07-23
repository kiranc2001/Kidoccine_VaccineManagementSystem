<?php

session_start();
include 'db_connection.php';
// Check if the user is registered
//if (!isset($_SESSION['registered']) || !$_SESSION['registered']) {
   // header("Location: parentnewregister.php");
    //exit;
//}
// Database connection details
/*$host = "localhost";
$username = "root";
$db_password = "";
$database = "vaccine";

// Create connection
$conn = new mysqli($host, $username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

$phone = isset($_GET['phone']) ? $_GET['phone'] : null;

if ($phone === null) {
    // Phone number not found in the URL, handle this case appropriately
    // For example, you could redirect the user back to the previous page
    // header("Location: previous_page.php");
    // exit;
    echo "<script>alert('Phone number not found.'); window.location.href = 'parentlogin.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['dob'])) {
        $dob = $_POST['dob'];
//$phone = $_SESSION['phone'];

        
        // Add DOB as recovery question to parent table
        $updateQuery = "UPDATE parent SET recovery_question = '$dob' WHERE phone = '$phone'";
        if ($conn->query($updateQuery) === TRUE) {
            // Recovery question updated successfully
 echo "<script>alert('Registration Successful'); window.location.href = 'parentlogin.php';</script>";
            
            exit;

        } else {
            echo "<script>alert('Error setting recovery question.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Question Recovery</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa; /* Light gray background */
        background-image: url('photos/3.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    h2 {
        color: #333;
        text-align: center;
    }

    form {
        text-align: center;
    }

    input {
        margin-bottom: 10px;
    }

    button {
        padding: 8px 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .errors {
        color: red;
        margin-bottom: 10px;
    }
</style>
<script>
        sessionStorage.setItem('recoveryCompleted', 'true');
    </script></head>
<body>

<div class="container">
    <h2>Enter Date of Birth for Recovery</h2>
    <form action="" method="POST">
        <input type="date" name="dob" required>
        <button type="submit">Set Recovery Question</button>
    </form>
</div>

</body>
</html>
