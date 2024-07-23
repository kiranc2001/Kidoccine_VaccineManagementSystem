<?php
session_start();

// Store the parent phone number in a variable
$phone = $_SESSION['phone'];

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
    <style>
        body {
            background-color: #f3f3f3;
            padding: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .message {
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin: 20px auto;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div class="message">You have been logged out. Redirecting to login page...</div>
    <script>
        setTimeout(function() {
            window.location.href = "parentlogin.php"; // Redirect to login page after 3 seconds
        }, 3000);
    </script>
</body>
</html>
