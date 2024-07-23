<?php
session_start();
include 'db_connection.php';
// Check if parent is logged in
if (!isset($_SESSION['phone'])) {
    header("Location: parentlogin.php");
    exit();
}


// Database connection details
/*$host = "localhost";
$username = "root";
$db_password = "";
$database = "vaccine";

// Create connection
$conn = new mysqli($host, $username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

// Get parent phone from session
$parent_phone = $_SESSION['phone'];

// Get fixed vaccine name from URL parameter
if (!isset($_GET['name'])) {
    die("Vaccine name not provided.");
}
$vaccine_name = $_GET['name'];

// Retrieve vaccine details
$sql = "SELECT * FROM added_vaccines WHERE vaccine_name = '$vaccine_name'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $vaccine = $result->fetch_assoc();
} else {
    die("Vaccine not found.");
}

// Retrieve hospitals for this vaccine
$sql = "SELECT* FROM added_vaccines WHERE vaccine_name = '$vaccine_name'";
$result = $conn->query($sql);

$hospitals = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hospitals[] = $row;
    }
} else {
    die("No hospitals found for this vaccine.");
}
$sql = "SELECT* FROM added_vaccines WHERE vaccine_name = '$vaccine_name'";
$result = $conn->query($sql);

$vaccines = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vaccines[] = $row;
    }
} else {
    die("No hospitals found for this vaccine.");
}

// Check if the vaccine is already booked for this parent
$sql = "SELECT * FROM booked_vaccines WHERE parent_phone_number = '$parent_phone' AND vaccine_name = '$vaccine_name' AND vaccination_status='pending' ";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<script>';

   echo 'alert("Vaccine is already booked for this phone number.");';
    echo 'window.location.href = "parentdashboard.php";'; // Redirect to login page
    echo '</script>';


}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Vaccine</title>
    <style>
      .container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: grid;
    grid-gap: 15px;
}

.box {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 15px;
}

.left, .right {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.right {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
}

input[type="text"],
input[type="date"],
input[type="email"],
select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="text"][readonly], input[type="date"][readonly], input[type="email"][readonly], select[readonly] {
    background-color: #f1f1f1;
}

input[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
</head>

<body>
<div class="container">
    <h1>Book Vaccine</h1>
    <form action="process-booking.php" method="POST">
 <div class="box">
            <div class="left">
        <label for="parent_phone">Parent Phone Number:</label>
<input type="text" id="parent_phone" name="parent_phone" value="<?php echo $parent_phone; ?>" readonly>

<label for="vaccine_name">Vaccine Name:</label>
<input type="text" id="vaccine_name" name="vaccine_name" value="<?php echo $vaccine_name; ?>" readonly> 
<p style="color:green;">* If the vaccine is paid, the fees are to be paid on the day of Vaccination.</p>
</div>
 <div class="right">
        <label for="hospital">Select Hospital:</label>
        <select name="hospital" id="hospital" value="Select Hospital" onchange="updatePrice()">
<option value="" selected disabled>Select Hospital</option>
            <?php foreach ($hospitals as $hospital): ?>
            <option value="<?php echo $hospital['hospital_name']; ?>" <?php echo ($hospital['stock'] > 0 ? '' : 'disabled'); ?>>
                <?php echo $hospital['hospital_name'] . ' - ' . $hospital['hospital_address'] . ($hospital['stock'] > 0 ? '' : ' - Out of Stock'); ?>
            </option>
        <?php endforeach; ?>
            
        </select>
<label for="vaccine_price">Vaccine Price :</label>
<input type="text" id="vaccine_price" name="vaccine_price" readonly>
        <label for="child_name">Child's Name (as per birth certificate or Aadhar card):</label>
        <input type="text" id="child_name" name="child_name" required>
<label for="father_name">Father's Name:</label>
        <input type="text" id="father_name" name="father_name" required>
        <label for="child_dob">Child's Date of Birth (as per birth certificate or Aadhar card):</label>
        <input type="date" id="child_dob" name="child_dob" max="<?php echo date('Y-m-d'); ?>" required>
        <label for="email">Email (optional):</label>
        <input type="email" id="email" name="email">
        <label for="vaccination_date">Vaccination Date:</label>
        <input type="date" id="vaccination_date" name="vaccination_date" min="<?php echo date('Y-m-d'); ?>" required>
        <input type="submit" value="Book Now">

<div>
    </form>
 
</div>
<script>
function updatePrice() {
    var hospitalSelect = document.getElementById('hospital');
    var selectedHospital = hospitalSelect.options[hospitalSelect.selectedIndex].value;
    var priceInput = document.getElementById('vaccine_price');

    // Assuming $vaccines contains the vaccine data with price
    var selectedVaccine = <?php echo json_encode($vaccines); ?>.find(vaccine => vaccine.hospital_name === selectedHospital);
    if (selectedVaccine) {
        priceInput.value = selectedVaccine.price > 0 ? 'Rs. ' + selectedVaccine.price : 'Free';
    } else {
        priceInput.value = '';
    }
}
</script>


</body>

</html>

