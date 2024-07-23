<?php
session_start();

// Check if OTP is set in session
if (!isset($_SESSION['otp'])) {
    header("Location: admin-login.php");
    exit();
}
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
$email=$_SESSION['email'];
$otp=$_SESSION['otp'];
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate OTP
$entered_otp = $_POST['otp'];
    
    if ($entered_otp!= $otp) {

        echo '<script>';

   echo 'alert("OTP did not match");';
    //echo 'window.location.href = "forgot-pasword.php";'; // Redirect to login page
    echo '</script>';
    
    } else {
        // Update password in database
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        if ($new_password !== $confirm_password) {
           echo '<script>';

   echo 'alert("Password did Not Matched.");';
    echo 'window.location.href = "forgot-pasword.php";'; // Redirect to login page
    echo '</script>';
    
        } else {
            // Update password in database (you need to implement this part)
            // Once password is updated, unset the OTP
 //$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password_query = "UPDATE admin_users SET password='$new_password' WHERE email='$email'";
                mysqli_query($conn, $update_password_query);
            unset($_SESSION['otp']);
            echo '<script>';

   echo 'alert("Password Changed");';
    echo 'window.location.href = "admin-login.php";'; // Redirect to login page
    echo '</script>';
    
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
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
    background-color: #333;
    color: white;
    margin: 0;
}

form {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"],
button[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button[type="submit"] {
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #555;
}

</style>
</head>

<body>
    <h2>Reset Password</h2>
    <form method="post" action="">
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($message)): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo $message; ?></div>
        <?php endif; ?>
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>

</html>
