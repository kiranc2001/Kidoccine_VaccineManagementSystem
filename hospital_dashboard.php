<?php
session_start();

// Check if the hospital is not logged in
if (!isset($_SESSION['hospital_email'])) {
    header("Location: hospital-login.php");
    exit();
}

// Check if the session has expired
$session_timeout = 300; // 5 minutes in seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Session has expired, destroy the session and redirect to login page
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: hospital-login.php");
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hospital Dashboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-image: url('background.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
    }

    .dashboard-container {
        text-align: center;
        background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent black background */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
        margin-bottom: 20px;
    }

    .welcome-message {
        margin-bottom: 20px;
    }

    .dashboard-options button {
        padding: 10px 20px;
        margin: 0 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
    }

    .dashboard-options button:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

<div class="dashboard-container">
    <h1>Hospital Dashboard</h1>
    <div class="welcome-message">
        <h2>Welcome, <?php echo $_SESSION['hospital_email']; ?>!</h2>
    </div>

    <div class="dashboard-options">
        <button onclick="location.href='hospitalmanage_vaccine.php';">Manage Vaccines</button>
        <button onclick="location.href='hospitalget_parent_details.php';">Get Parent Details</button>
        <button onclick="location.href='hospital-logout.php';">Sign Out</button>
    </div>
</div>

</body>
</html>
