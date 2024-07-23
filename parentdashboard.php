<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['phone'])) {
    header("Location: parentlogin.php");
    exit;
}

// Check if the session has expired
$session_timeout = 300; // 5 minutes in seconds
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > $session_timeout) {
    // Session has expired, destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: parentlogin.php");
    exit;
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();

// Assuming you have a database connection established already
/*$host = "localhost";
$username = "root";
$db_password = "";
$database = "vaccine";
$conn = new mysqli($host, $username, $db_password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/
include 'db_connection.php';

$phone = $_SESSION['phone'];
$sql = "SELECT name FROM parent WHERE phone = '$phone'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $parent_name = $row['name'];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }

    .dashboard-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .welcome-message {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .dashboard-options {
        display: flex;
        justify-content: center;
    }

    button {
        padding: 10px 20px;
        margin: 0 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-profile {
        background-color: #28a745;
        color: #fff;
    }

    .btn-vaccines {
        background-color: #ffc107;
        color: #333;
    }

    .btn-signout {
        background-color: #dc3545;
        color: #fff;
    }
</style>
</head>
<body>

<div class="dashboard-container">
    <h1>Dashboard</h1>
    <div class="welcome-message">
        <h2>Welcome, <?php echo $parent_name; ?>!</h2>
    </div>

    <div class="dashboard-options">
        <button class="btn-profile" onclick="location.href='parentvieworders.php';">View Orders</button>
        <button class="btn-vaccines" onclick="location.href='more-vaccines.php';">Book Vaccines</button>
        <button class="btn-signout" onclick="location.href='parent-signout.php';">Sign Out</button>
    </div>
</div>

</body>
</html>
