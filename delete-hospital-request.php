<?php
// Database connection details
include 'db_connection.php';
/*$host = "localhost";
$username = "root";
$password = "";
$database = "vaccine";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the request ID to be deleted
    $requestId = $_POST['request_id'];

    // Delete the hospital request from the database
    $deleteSql = "DELETE FROM hospital_requests WHERE id = '$requestId'";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Request deleted successfully";
    } else {
        echo "Error deleting request: " . $conn->error;
    }

    // Redirect back to the adminhospital-req.php page
    header("Location: adminhospital-req.php");
    exit();
}

// Close the database connection
$conn->close();
?>
