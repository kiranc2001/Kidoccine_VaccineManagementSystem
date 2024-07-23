<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['hospital_email'])) {
    header("Location: hospital-login.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php'; // Adjust the path based on your project structure
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
require_once('tcpdf_6_3_2/tcpdf/tcpdf.php');



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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parent_phone = $_POST['parent_phone'];
$vaccine_name = $_POST['vaccine_name'];
$child_name = $_POST['child_name'];
$father_name = $_POST['parent_name'];
$child_dob = $_POST['child_dob'];
$vaccination_date = $_POST['vaccination_date'];
$hospital = $_POST['hospital_name'];
$status = $_POST['status'];

$email = isset($_POST['email']) ? $_POST['email'] : '';


    // Update status in booked_vaccines table
    $sql = "UPDATE booked_vaccines SET vaccination_status = '$status' WHERE hospital = '$hospital' AND vaccine_name = '$vaccine_name' AND parent_phone_number='$parent_phone' AND child_name='$child_name' AND parent_name='$father_name' AND child_dob='$child_dob' AND vaccination_date='$vaccination_date'";
    if ($conn->query($sql) === TRUE) {
        /*echo "Status updated successfully";*/

        // Send email if status is 'completed' or 'not_vaccinated'
        if ($status === 'completed' || $status === 'not_vaccinated') {
            $sql = "select* from booked_vaccines WHERE hospital = '$hospital' AND vaccine_name = '$vaccine_name' AND parent_phone_number='$parent_phone' AND child_name='$child_name' AND parent_name='$father_name' AND child_dob='$child_dob' AND vaccination_date='$vaccination_date'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $parent_email = $row['email_id'];
                if (!empty($parent_email)) {
               $mail = new PHPMailer(true);
                    $mail->isSMTP();
                   $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'vaccine.govt@gmail.com'; // SMTP username
    $mail->Password = 'qnaqgmrnamvsuzis'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect t port to connect to

        // Recipients
        $mail->setFrom('vaccine.govt@gmail.com','Kidoccine');
        $mail->addAddress($parent_email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Vaccine Status Update';
                    $mail->Body = "Your vaccine status for $vaccine_name at $hospital has been updated to '$status<br> Here are your details: <br>Vaccine Name: $vaccine_name<br>Hospital Name: $hospital<br>vaccination-date:$vaccination_date<br>Phone Number: $parent_phone<br>Child Name: $child_name<br>Father's Name: $father_name<br>Child DOB: $child_dob<br> vaccination_status=$status<br>Thank you!";

                    if (!$mail->send()) {
                        echo "Email could not be sent. Mailer Error: " . $mail->ErrorInfo;
                    }
                }
            }
        }

        // Generate and send vaccine certificate if status is 'completed'

if($status==='not_vaccinated'){
 $update_sql = "UPDATE added_vaccines SET stock = stock + 1 WHERE vaccine_name = '$vaccine_name' AND hospital_name = '$hospital'";
        if ($conn->query($update_sql) !== TRUE) {
            echo "Error updating stock: " . $conn->error;
        }else{
echo "<script>alert('Status Updated'); window.location.href = 'hospitalget_parent_details.php';</script>";
}


}
        if ($status === 'completed') {
            $pdf = new TCPDF();
            $pdf->AddPage();
            
            // Set styles for the PDF
            $pdf->SetFont('helvetica', '', 12);
            $pdf->SetFillColor(255, 255, 255); // Set background color to white
            $pdf->SetDrawColor(0, 0, 0); // Set border color to black
            $pdf->SetLineWidth(0.2); // Set border width
            
            // Add logo slightly above the center
            $pdf->Image('photos/logo.jpg', 85, 30, 40, '', 'JPG');
            
            // Add details below the logo
            $pdf->Ln(50); // Move down to leave space below the logo
            $pdf->SetFont('helvetica', 'B', 16); // Bold font for child name and hospital name
            $pdf->Cell(0, 10, "Vaccine Certificate for $child_name", 0, 1, 'C'); // Centered text
            $pdf->SetFont('helvetica', '', 12); // Reset font
            $pdf->Cell(0, 10, "Vaccine Name: $vaccine_name", 0, 1, 'C'); // Centered text
            $pdf->Cell(0, 10, "Hospital Name: $hospital", 0, 1, 'C'); // Centered text
            $pdf->Cell(0, 10, "Vaccination Date: $vaccination_date", 0, 1, 'C'); // Centered text
            $pdf->Cell(0, 10, "Vaccination status: $status", 0, 1, 'C'); // Centered text
            
            // Add contact information at the end
            $pdf->SetY(-15); // Move to the bottom of the page
            $pdf->SetFont('helvetica', 'I', 8); // Italic font
            $pdf->Cell(0, 10, "For any queries, contact vaccine.govt@gmail.com", 0, 1, 'C'); // Centered text
            
            // Output the PDF as a string
            $pdf_content = $pdf->Output('certificate.pdf', 'S');
            
            // Store the PDF filename in booked_vaccines table
            $update_sql = "UPDATE booked_vaccines SET certificate_pdf = ? WHERE hospital = ? AND vaccine_name = ? AND parent_phone_number = ? AND child_name = ? AND parent_name = ? AND child_dob = ? AND vaccination_date = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssss", $pdf_content, $hospital, $vaccine_name, $parent_phone, $child_name, $father_name, $child_dob, $vaccination_date);

    // Execute the update statement
    if ($stmt->execute()) {
        /*echo "PDF stored successfully";*/
    } else {
        echo "Error storing PDF: " . $stmt->error;
    }
    $stmt->close();
            // Send the PDF as an attachment in the email
            if (!empty($parent_email)) {
               $mail = new PHPMailer(true);
                    $mail->isSMTP();
                   $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'vaccine.govt@gmail.com'; // SMTP username
    $mail->Password = 'qnaqgmrnamvsuzis'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect t port to connect to

        // Recipients
        $mail->setFrom('vaccine.govt@gmail.com','Kidoccine');
        $mail->addAddress($parent_email);
                $mail->isHTML(true);
                $mail->Subject = 'Vaccine Certificate';
                $mail->Body = "Your vaccine certificate for $vaccine_name at $hospital is attached.";
                $mail->addStringAttachment($pdf_content, 'VaccineCertificate.pdf');
 echo "<script>alert('Status Updated'); window.location.href = 'hospitalget_parent_details.php';</script>";

                if (!$mail->send()) {
                    echo "Email could not be sent. Mailer Error: " . $mail->ErrorInfo;
                }
            }
        }
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

$conn->close();
?>
