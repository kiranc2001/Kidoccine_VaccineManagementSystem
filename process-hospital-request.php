<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php'; // Adjust the path based on your project structure
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
include 'db_connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    /*$host = "localhost";
    $username = "root";
    $password = "";
    $database = "vaccine";

    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }*/

    $requestId = $_POST['request_id'];
    $status = $_POST['status'];

    // Fetch hospital email for sending rejection email
    $getHospitalQuery = "SELECT hospital_name, address, email FROM hospital_requests WHERE id = '$requestId'";
    $result = $conn->query($getHospitalQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hospitalEmail = $row['email'];
        $hospitalName = $row['hospital_name'];
        $address = $row['address'];

        if ($status == 'accept') {
            // Generate a random password
            $hospitalPassword = generateRandomPassword();

            // Insert hospital credentials into the database
            $insertCredentialsSql = "UPDATE hospital_requests SET status = '$status', password = '$hospitalPassword' WHERE id = '$requestId'";
$insertQuery = "INSERT INTO hospital_credentials (email,password,hospital_name, address) 
                        VALUES ('$hospitalEmail','$hospitalPassword','$hospitalName', '$address')";

	  $conn->query($insertCredentialsSql);
$conn->query($insertQuery);
            
        
            $mail = new PHPMailer(true);

            try {
                // SMTP settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'kirangowda0212@gmail.com'; // SMTP username
                $mail->Password = 'llhrxpyvxrxzlssr'; // SMTP password
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587; // TCP port to connect to

                // Recipients
                $mail->setFrom('kirangowda0212@gmail.com','Kidoccine');
                $mail->addAddress($hospitalEmail);

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Hospital Request Approved';
                $mail->Body = "Your hospital request has been approved. Here are your login credentials:\nEmail: $hospitalEmail\nPassword: $hospitalPassword";

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
        } else if ($status == 'reject') {
$updateRequestSql = "UPDATE hospital_requests SET status = '$status', password = NULL WHERE id = '$requestId'";
            $conn->query($updateRequestSql);
$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'vaccine.govt@gmail.com'; // SMTP username
    $mail->Password = 'qnaqgmrnamvsuzis'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom('vaccine.govt@gmail.com','Kidoccine');
    $mail->addAddress($hospitalEmail);

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Hospital Request Rejected';
    $mail->Body = "Your hospital request has been rejected. Please contact the admin for more information.";

    $mail->send();
    echo 'Rejection email sent successfully.';
} catch (Exception $e) {
    echo 'Error sending rejection email. Mailer Error: ', $mail->ErrorInfo;
}
}
    }

    // Update the status of the request
    $updateSql = "UPDATE hospital_requests SET status = '$status' WHERE id = '$requestId'";
    $conn->query($updateSql);

    // Close the database connection
    $conn->close();
}

// Redirect back to the admin-hospital-requests.php page
header("Location: adminhospital-req.php");
exit();

function generateRandomPassword($length = 12) {
    // Define the characters allowed in the password
    $characters = '0123456789';

    $password = '';
    $characterCount = strlen($characters);

    // Generate random password
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $characterCount - 1)];
    }

    return $password;
}
?>

