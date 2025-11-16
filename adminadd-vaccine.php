<?php
// Process form submission
include 'db_connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Database connection details
    /*$host = "localhost";
    $username = "root";
    $password = "";
    $database = "vaccine";

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }*/

    // Get form data
    $vaccine_name = $_POST['vaccine_name'];
    $hospital_name = $_POST['hospital_name'];
    $stock = $_POST['stock'];
    $price_type = $_POST['price_type'];
    $price = ($price_type == 'paid') ? $_POST['price'] : 0; // Set price to 0 if free
    $vaccination_date = $_POST['vaccination_date'];
   
    // Fetch hospital address based on the selected hospital name
    $sql = "SELECT address FROM hospital_credentials WHERE hospital_name = ?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("s", $hospital_name);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $row = $result->fetch_assoc();
    $hospital_address = $row['address'];

    // Check if the same vaccine with the same hospital already exists
    $check_sql = "SELECT COUNT(*) AS count FROM added_vaccines WHERE vaccine_name = ? AND hospital_name = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $vaccine_name, $hospital_name);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();
    if ($check_row['count'] > 0) {
        echo "<script>alert('Vaccine already exists for this hospital.'); window.location.href = 'adminadd-vaccine.php';</script>";
        exit(); // Stop further execution
    }

    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO added_vaccines (vaccine_name, hospital_name, hospital_address, stock, price, vaccination_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiis", $vaccine_name, $hospital_name, $hospital_address, $stock, $price, $vaccination_date);

    // Execute the statement
    $stmt->execute();

    // Send email notification to parents
    
 $mail = new PHPMailer(true);

    try {
        // Specify the SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'kirangowda0212@gmail.com'; // SMTP username
        $mail->Password = 'llhrxpyvxrxzlssr'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        // Set the sender
        $mail->setFrom('kirangowda0212@gmail.com', 'Kidoccine');

        // Get all unique parent emails from booked_vaccines table
        $unique_emails_sql = "SELECT DISTINCT email_id FROM booked_vaccines";
        $unique_emails_result = $conn->query($unique_emails_sql);

        while ($row = $unique_emails_result->fetch_assoc()) {
            // Add recipient email
            $mail->addAddress($row['email_id']);

            // Set email subject and body
            $mail->Subject = 'Vaccine Added Notification';
            $mail->Body = "Vaccine ($vaccine_name) has been added in the website. Please visit the website for more details.";

            // Send the email
            $mail->send();

            // Clear all addresses for the next iteration
            $mail->clearAddresses();
        }

           } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    // Close statements and connection
    $stmt->close();
    $stmt2->close();
    $conn->close();

    // Redirect to admin dashboard after successful submission
    echo "<script>alert('Vaccine added successfully. Notifications sent to parents.'); window.location.href = 'admin-dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vaccine</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff; /* Light Blue */
            color: #333; /* Dark Grey */
        }

        header {
            background-color: #4682b4; /* Steel Blue */
            color: white;
            padding: 1em;
            text-align: center;
        }

        main {
            padding: 20px;
            text-align: center;
        }

        form {
            display: inline-block;
            text-align: left;
            background-color: #f0f8ff; /* Light Blue */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333; /* Dark Grey */
        }

        input,
        select {
            padding: 5px;
            width: 100%;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc; /* Light Grey */
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #32cd32; /* Lime Green */
            color: white;
        }

        button:hover {
            background-color: #228b22; /* Forest Green */
        }
    </style>
</head>

<body>
    <header>
        <h1>Add Vaccine</h1>
    </header>

    <main>
        <form id="addVaccineForm" action="" method="post">
            <label for="vaccine_name">Vaccine Name:</label>
            <input type="text" id="vaccine_name" name="vaccine_name" required>

            <label for="hospital_name">Hospital Name:</label>
            <select id="hospital_name" name="hospital_name" required>
               <?php
// Database connection details
/*$host = "localhost";
$username = "root";
$password = "";
$database = "vaccine";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

// Fetch hospital names and addresses from hospital_credentials table
$sql = "SELECT hospital_name, address FROM hospital_credentials";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    echo "Number of rows: " . $result->num_rows; // Debug statement
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['hospital_name'] . "' data-address='" . $row['address'] . "'>" . $row['hospital_name'] . " - " . $row['address'] . "</option>";
        }
    } else {
        echo "<option value=''>No hospitals found</option>";
    }
}
$conn->close();
?>

            </select>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <label for="price">Price:</label>
            <input type="radio" id="free" name="price_type" value="free" required onchange="showPriceInput()"> Free
<input type="radio" id="paid" name="price_type" value="paid" required onchange="showPriceInput()"> Paid

<input type="number" id="price" name="price" style="display:none;" required>

            <label for="vaccination_date">Vaccination Date:</label>
            <input type="date" id="vaccination_date" name="vaccination_date" required>

            <div id="hospital_address"></div>

           <button type="submit" name="submit" value="submit">Add Vaccine</button>
           <button class="dashboard-btn" onclick="window.location.href='admin-dashboard.php'">Go to Dashboard</button>
        </form>
       

<script>
            // Function to validate the vaccine name
            function validateVaccineName() {
                var vaccineNameInput = document.getElementById("vaccine_name");
                var vaccineName = vaccineNameInput.value;

                // Regular expression to match only capital letters, digits, and special characters
                var regex = /^[A-Z0-9!@#\$%\^\&*\)\(+=._-]+$/;
                if (!regex.test(vaccineName)) {
                    alert("Vaccine name can only contain capital letters, digits, and special characters.");
                    vaccineNameInput.focus();
                    return false;
                }

                return true;
            }

            // Attach the validation function to the form's submit event
            document.getElementById("addVaccineForm").addEventListener("submit", function (event) {
    if (!validateVaccineName()) {
        console.log("Validation failed. Form not submitted."); // Debugging message
        event.preventDefault(); // Prevent form submission if validation fails
    } else {
        console.log("Validation passed. Form submitted."); // Debugging message
    }
});
        </script>
        <script>
            // Update the hospital address display when the hospital is changed
            document.getElementById("hospital_name").addEventListener("change", function () {
                var selectedOption = this.options[this.selectedIndex];
                var hospitalAddress = selectedOption.getAttribute("data-address");
                document.getElementById("hospital_address").textContent = hospitalAddress;
            });

            function showPriceInput() {
    var priceInput = document.getElementById("price");
    var paidRadio = document.getElementById("paid");
    if (paidRadio.checked) {
        priceInput.style.display = "inline-block";
        priceInput.setAttribute("required", "true"); // Make price input required when "Paid" is selected
    } else {
        priceInput.style.display = "none";
        priceInput.removeAttribute("required"); // Remove required attribute when "Free" is selected
    }
}

        </script>
    </main>
</body>

</html>

