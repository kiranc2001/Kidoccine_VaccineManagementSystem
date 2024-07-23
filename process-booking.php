<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php'; // Adjust the path based on your project structure
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';



// Connect to the database (replace with your database credentials)
/*$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vaccine";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/
include 'db_connection.php';

// Get form data
$parent_phone = $_POST['parent_phone'];
$vaccine_name = $_POST['vaccine_name'];
$child_name = $_POST['child_name'];
$father_name = $_POST['father_name'];
$child_dob = $_POST['child_dob'];
$vaccination_date = $_POST['vaccination_date'];
$hospital = $_POST['hospital'];
$price = $_POST['vaccine_price'];
$email = isset($_POST['email']) ? $_POST['email'] : '';

echo "Price from form: $price"; 

// Check if the vaccine is already booked for this phone number
$sql = "SELECT * FROM booked_vaccines WHERE parent_phone_number = '$parent_phone' AND vaccine_name = '$vaccine_name' AND vaccination_status='pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Vaccine is already booked, display error message or redirect
echo '<script>';

   echo 'alert("Vaccine is already booked for this phone number.");';
    echo 'window.location.href = "parentdashboard.php";'; // Redirect to login page
    echo '</script>';

} else {
$price_decimal = floatval(str_replace('Rs. ', '', $price));
    // Vaccine is not booked, insert booking details into booked_vaccines table
   $sql_insert_booking = "INSERT INTO booked_vaccines (parent_phone_number, vaccine_name, child_name, parent_name, child_dob, vaccination_date,hospital, vaccination_status, email_id, vaccine_price,certificate_pdf) VALUES ('$parent_phone', '$vaccine_name', '$child_name', '$father_name', '$child_dob', '$vaccination_date', '$hospital', 'pending', '$email', '$price_decimal','NULL')";

    if ($conn->query($sql_insert_booking) === TRUE) {
        echo '<script>';
    echo 'alert("Vaccine Booked Successfully");';
    echo 'window.location.href = "parentdashboard.php";'; // Redirect to login page
    echo '</script>';

        // Update stock for the selected vaccine
        $update_sql = "UPDATE added_vaccines SET stock = stock - 1 WHERE vaccine_name = '$vaccine_name' AND hospital_name = '$hospital'";
        if ($conn->query($update_sql) !== TRUE) {
            echo "Error updating stock: " . $conn->error;
        }

        // Send confirmation email if email is provided
        


if (!empty($email)) {
    $mail = new PHPMailer(true); // Create a new PHPMailer instance

    try {
        // SMTP settings
        $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'vaccine.govt@gmail.com'; // SMTP username
    $mail->Password = 'qnaqgmrnamvsuzis'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect t port to connect to

        // Recipients
        $mail->setFrom('vaccine.govt@gmail.com','Kidoccine');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Vaccine Booking Confirmation';
        $mail->Body = "Dear $child_name,<br><br>Your vaccine booking for $vaccine_name at $hospital has been confirmed.<br><br>Please find below the details:<br><br>Vaccine Name: $vaccine_name<br>Hospital Name: $hospital<br>Price: $price_decimal<br>vaccination-date:$vaccination_date<br>Phone Number: $parent_phone<br>Child Name: $child_name<br>Father's Name: $father_name<br>Child DOB: $child_dob<br><br>Thank you!";

        $mail->send();
        //echo "Confirmation email sent successfully.";
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
}
}
}




$conn->close();
?>
