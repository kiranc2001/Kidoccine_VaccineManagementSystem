<?php
session_start();
error_reporting(E_ALL); 
ini_set('display_errors', 1);
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
//include 'db_connection.php';

// Process delete vaccine request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $vaccine_id = $_POST['delete'];
    $sql = "DELETE FROM added_vaccines WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vaccine_id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Vaccine deleted successfully.'); window.location.href = 'adminvaccine-list.php';</script>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Process update here
    // Redirect to update page with vaccine_id as parameter
    header("Location: admin-update-vaccine.php?vaccine_id=" . $_POST['update']);
    exit();
}

$sql = "SELECT * FROM added_vaccines";
$result = $conn->query($sql);

$vaccines = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vaccines[] = $row;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine List</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

h2 {
    text-align: center;
    padding: 10px 20px;
    font-size: 16px;
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #333;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

td form {
    display: inline-block;
    text-align: center; /* Center the form */
    margin-top: 20px; /* Add space at the top */
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    height: 100vh;
}

form {
    margin-top: 20px;
    display: flex;
    align-items: center;
}

input[type="text"] {
    width: 300px;
    padding: 10px;
    font-size: 16px;
    margin-right: 5px;
    margin-top: -15px;
    background-color:white;
}

button[type="submit"] {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    margin-top:-10px;
}
td form button {
    margin-right: 5px;
}





td form button:hover {
    background-color: #d32f2f;
}


    </style>
</head>

<body>
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2 style="margin-right: 30px;">Vaccine List</h2>
    <div>
        <form method="get" style="display: inline-block;">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
        <a href="admin-dashboard.php" style="display: inline-block; margin-left: 10px; color: #333; text-decoration: none; padding: 10px; border: 1px solid #333; border-radius: 5px;">Go to Dashboard</a>
        <a href="admin-signout.php" style="display: inline-block; margin-left: 10px; color: #333; text-decoration: none; padding: 10px; border: 1px solid #333; border-radius: 5px;">Sign Out</a>
    </div>
</div>



    <table>
        <tr>
            <th>Vaccine Name</th>
            <th>Hospital Name</th>
            <th>Hospital Address</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Added/Updated Date</th>
            <th>Action</th>
        </tr>
        <?php
        // Database connection details
       /* $host = "localhost";
        $username = "root";
        $password = "";
        $database = "vaccine";

        // Create connection
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }*/

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $sql = "SELECT * FROM added_vaccines WHERE vaccine_name LIKE '%$search%' OR hospital_name LIKE '%$search%' OR hospital_address LIKE '%$search%'";
        } else {
            $sql = "SELECT * FROM added_vaccines";
        }

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['vaccine_name'] . "</td>";
                echo "<td>" . $row['hospital_name'] . "</td>";
                echo "<td>" . $row['hospital_address'] . "</td>";
                echo "<td>" . $row['stock'] . "</td>";
                echo "<td>" . ($row['price'] > 0 ? 'Rs. ' . $row['price'] : 'Free') . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='delete' value='" . $row['id'] . "'>";
                echo "<button type='submit'>Delete</button>";
                echo "</form>";
                echo "<form method='post'>";
            echo "<input type='hidden' name='update' value='" . $row['id'] . "'>";
            echo "<button type='submit'>Update</button>";
            echo"</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No results found</td></tr>";
        }

        // Close connection
        $conn->close();
        ?>
    </table>
    

    
</body>

</html>
