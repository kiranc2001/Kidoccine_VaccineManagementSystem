<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
session_start();
include 'db_connection.php';

// Database connection details
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
$message = '';

// Check if phone number is set in the URL
if (isset($_GET['phone'])) {
    $phone = $_GET['phone'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $check_phone_query = "SELECT * FROM parent WHERE phone='$phone'";
        $result = mysqli_query($conn, $check_phone_query);
        $user = mysqli_fetch_assoc($result);

        if ($user && $user['email'] == $email) {
            $otp = mt_rand(100000, 999999); // Generate a random OTP

            // Send OTP to user's email (you need to implement this part)
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'kirangowda0212@gmail.com'; // SMTP username
            $mail->Password = 'llhrxpyvxrxzlssr'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('kirangowda0212@gmail.com', 'Kidoccine');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body = "Your OTP is: $otp";

            if ($mail->Send()) {
                // Store the OTP in the session
//$message='OTP sent successfully';
                $_SESSION['otp'] = $otp;

                echo '<script>';

   echo 'alert("OTP Sent Successfully");';
     echo 'window.location.href = "parentemailnewpassword.php?phone=' . urlencode($phone) . '";';
echo '</script>';
            
                exit();
            } else {
               echo '<script>';

   echo 'alert("OTP Not Sent");';
    echo 'window.location.href = "parentemailrecovery.php?phone=' . urlencode($phone) . '";'; // Redirect to login page
    echo '</script>';
            }
        } else {
            echo '<script>';
            echo 'if (confirm("Incorrect email. Try again?")) {';
            echo 'window.location.href = "parentemailrecovery.php?phone=' . urlencode($phone) . '";';
            // Redirect to email recovery page
            echo '} else {';
            echo 'window.location.href = "parentlogin.php";'; // Redirect to login page
            echo '}';
            echo '</script>';
        }
    }
} else {
    // Handle the case when phone is not set
    echo "Phone number not found in URL.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Forgot Password</title>
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

        .message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }

    </style>
</head>

<body>
    <h2>Enter your email to receive OTP</h2>
    <?php if (!empty($message)) : ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Send OTP</button>
<a href="parentlogin.php" style="display: inline-block; margin-top: 10px;margin-left:100px; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px;">Go back</a>
   </form>
</body>

</html>

