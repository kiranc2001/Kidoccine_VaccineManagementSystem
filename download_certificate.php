<?php
session_start();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $certificateId = $_GET['id'];

    // Connect to the database
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

    // Fetch certificate PDF content from the database
    $sql = "SELECT certificate_pdf FROM booked_vaccines WHERE id = '$certificateId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $certificatePdf = $row['certificate_pdf'];

        // Set headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="certificate.pdf"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($certificatePdf));

        // Output the certificate PDF content
        echo $certificatePdf;
        exit;
    } else {
        echo "Certificate not found.";
    }

    $conn->close();
} else {
    echo "Certificate ID not provided.";
}
?>
