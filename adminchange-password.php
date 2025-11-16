<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php'; // Adjust the path based on your project structure
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
session_start();

// Database connection details
include 'db_connection.php';
/*$host = "localhost";
$username = "root";
$password = "";
$database = "vaccine";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/
$errors = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
$check_email_query = "SELECT * FROM admin_users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $check_email_query);
        $user = mysqli_fetch_assoc($result);

 if ($user) {
    $otp = mt_rand(100000, 999999); // Generate a random OTP

    // Send OTP to user's email (you need to implement this part)
    

$mail = new PHPMailer(true);
   $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'kirankiki590@gmail.com'; // SMTP username
        $mail->Password = 'nvhfcobiqzagremy'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        //Recipients
        $mail->setFrom('kirankiki590@gmail.com', 'Government');
        $mail->addAddress('kirangowda0212@gmail.com'); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body = "Your OTP is: $otp";

    if ($mail->Send()) {
        // Store the OTP and email in the session
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        header("Location: reset_password.php");
        exit();
    } else {
        echo "Email sending failed.";
    }

}else{
echo '<script>';

   echo 'alert("Email does not exist");';
    echo 'window.location.href = "admin-dashboard.php";'; // Redirect to login page
    echo '</script>';
}
}else{
array_push($errors, "Something went wrong");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

h2 {
    text-align: center;
    padding: 20px 0;
}

form {
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 10px;
}

input[type="email"],
button {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #555;
}

</style>
</head>

<body>
    <h2>Enter your email to receive OTP</h2>
    <form method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Send OTP</button>
    </form>
</body>

</html>

