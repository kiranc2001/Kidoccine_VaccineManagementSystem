<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if the user is registered
/*if (!isset($_SESSION['registered']) || !$_SESSION['registered']) {
    header("Location: parentnewregister.php");
    exit;
}*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php'; // Adjust the path based on your project structure
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

// Database connection details
include 'db_connection.php';

$phone = isset($_GET['phone']) ? $_GET['phone'] : null;

if ($phone === null) {
    // Phone number not found in the URL, handle this case appropriately
    // For example, you could redirect the user back to the previous page
    // header("Location: previous_page.php");
    // exit;
    echo "<script>alert('Not able to add recovery method'); window.location.href = 'parentlogin.php';</script>";
    exit;
}

function generateOTP() {
    return rand(100000, 999999);
}

// Send OTP to email using PHPMailer
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
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
        $mail->Subject = 'Your OTP for Password Recovery';
        $mail->Body = "Your OTP is: $otp";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $_SESSION['email'] = $email;

        // Generate and store OTP in session
        $otp = generateOTP();
        $_SESSION['otp'] = $otp;

        // Send OTP to the user's email
        if (sendOTP($email, $otp)) {
            // Redirect to enter OTP
            header("Location: gmail_recovery.php?phone=" . urlencode($phone));
            exit;
        } else {
            echo "<script>alert('Failed to send OTP. Please try again.');</script>";
        }
    }

    if (isset($_POST['otp'])) {
        $otp = $_POST['otp'];
        if ($otp == $_SESSION['otp']) {
            // OTP is correct
            // Add email to parent table and set recovery question to null

            $email = $_SESSION['email'];
            $updateQuery = "UPDATE parent SET email = '$email' WHERE phone = '$phone'";
            if ($conn->query($updateQuery) === TRUE) {
                echo "<script>alert('Registration Successful'); window.location.href = 'parentlogin.php';</script>";
                exit;
            } else {
                echo "<script>alert('Error adding email to database.');</script>";
            }
        } else {
            // OTP is incorrect
            echo "<script>alert('Invalid OTP. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gmail Recovery</title>
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
            <h2>Enter Email to Receive OTP</h2>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Enter Email" required>
            <button type="submit">Send OTP</button>
        </form>
     
        <h2>Enter OTP</h2>
        <form action="" method="POST">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify OTP</button>
        </form>
    
</div>

</body>
</html>

