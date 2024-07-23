<?php
$servername = "localhost";
$username = "id22135795_vaccine";
$password = "Kiran@2802";
$database = "id22135795_vaccine";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
