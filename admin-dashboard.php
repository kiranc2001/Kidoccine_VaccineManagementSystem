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

// Fetch the notification count from hospital_messages
$sql = "SELECT COUNT(*) AS notification_count FROM hospital_messages";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$notificationCount = $row['notification_count'];

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Your CSS styles here */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background.jpg');
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .dashboard-container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            text-align: center;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #f39c12;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease-in-out;
            position: relative;
        }

        button:hover {
            background-color: #2980b9;
        }

        .dashboard-links {
            text-align: left;
            margin-top: 20px;
        }

        h3 {
            color: #f39c12;
            margin-bottom: 10px;
        }

        .dashboard-links button {
            width: 100%;
            margin-top: 5px;
            text-align: left;
        }

        .sign-out {
            background-color: #e74c3c;
            margin-top: 30px;
        }

        .sign-out:hover {
            background-color: #c0392b;
        }

        .change-password {
            background-color: #2ecc71;
        }

        .change-password:hover {
            background-color: #27ae60;
        }

        .badge {
            background-color: #f00;
            color: #fff;
            font-size: 12px;
            padding: 3px 6px;
            border-radius: 50%;
            position: absolute;
            top: -5px;
            right: -5px;
            display: none;
        }
    </style>
</head>

<body>
   

      <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['admin_email']; ?>!</h2>

        <div class="dashboard-links">
            <h3>Dashboard Options</h3>
            <button onclick="location.href='admin-management.php';">Admin Management</button>
            <button onclick="location.href='adminhospital-management.php';">Hospital Management</button>
<button onclick="location.href='adminparent-management.php';">Parent Management</button>

            <button onclick="location.href='adminvaccine-management.php';">Vaccine Management</button>
            <button onclick="location.href='admin-notifications.php';" class="notifications">
                Notifications
                <span id="notification-badge" class="badge"><?php echo $notificationCount; ?></span>
            </button>
            <button onclick="location.href='adminchange-password.php';" class="change-password">Change Password</button>
        </div>

        <form method="post" action="admin-signout.php">
            <button type="submit" name="logout" class="sign-out">Sign Out</button>
        </form>
    </div>

    <script>
        // Example notification count (replace with actual count)
        

        // Update the notification badge
        function updateNotificationBadge(count) {
            var badge = document.getElementById("notification-badge");
            badge.textContent = count;
            badge.style.display = count > 0 ? "block" : "none";
        }

        // Update the badge count when the page loads
        window.addEventListener("load", function () {
            updateNotificationBadge(notificationCount);
        });
    </script>
</body>

</html>
