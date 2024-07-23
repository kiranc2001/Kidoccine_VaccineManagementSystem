<?php
// Prevent any output before session_start
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';

// Check if user is registered
session_start();
$phone = urldecode($_GET['phone']);
/*if (!isset($_SESSION['registered']) || $_SESSION['registered'] !== true) {
    // If not registered, redirect to registration page
    header("Location: parentnewregister.php");
    exit;
}*/

// Continue with your password recovery options page
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Recovery Options</title>
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

p {
    margin-bottom: 20px;
    text-align: center;
}

ul {
    list-style-type: none;
    padding: 0;
    text-align: center;
}

li {
    margin-bottom: 10px;
}

a {
    display: inline-block;
    padding: 10px 20px;
    margin: 0 10px;
    background-color: #17a2b8; /* Teal */
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

a:hover {
    background-color: #138496; /* Darker teal on hover */
}


</style>
</head>
<body>

<div class="container">
    <h2>Password Recovery Options</h2>
    <p>Please select a recovery option:</p>
    <ul>
        <li><a href="gmail_recovery.php?phone=<?php echo urlencode($phone); ?>">Gmail Recovery</a></li>

        <li><a href="question_recovery.php?phone=<?php echo urlencode($phone); ?>">Additional Security Question Recovery</a></li>
    </ul>
</div>

</body>
</html>
