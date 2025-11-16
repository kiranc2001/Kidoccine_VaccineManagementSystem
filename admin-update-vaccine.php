<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

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

// Get the vaccine ID from the query parameters
$vaccine_id = $_GET['vaccine_id'];
$sql1 = "SELECT * FROM added_vaccines WHERE id = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $vaccine_id);
$stmt1->execute();
$result1 = $stmt1->get_result();

if ($result1->num_rows> 0) {
    $vaccine = $result1->fetch_assoc(); // Fetch the vaccine data
} else {
    die("Vaccine not found.");
}

// Process update vaccine request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
 $vaccine_name = $_POST['vaccine_name'];

    $stock = $_POST['stock'];
    $vaccination_date = $_POST['vaccination_date'];
    $price = ($_POST['payment'] == 'paid') ? $_POST['price'] : 0; // Set price to 0 if free
    $sql = "UPDATE added_vaccines SET stock = ?, price = ?, vaccination_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $stock, $price, $vaccination_date, $vaccine_id);
    if ($stmt->execute()) {

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
            $mail->Subject = 'Action Taken';
            $mail->Body = "Some updates were taken for vaccine ($vaccine_name). Please visit the website for more details.";

            // Send the email
            $mail->send();

            // Clear all addresses for the next iteration
            $mail->clearAddresses();
        } 


           } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


        echo "<script>alert('Vaccine details updated successfully.'); window.location.href = 'adminvaccine-list.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Update Vaccine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
h2 {
    text-align: center;
    margin-top: 20px;
}



        form {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="checkbox"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        .price-field {
            display: block;
        }

    </style>
</head>

<body>
    <div class="container">
        <h2>Update Vaccine Details</h2>
        <form method="post">
            <label for="vaccine_name">Vaccine Name:</label>
            <input type="text" id="vaccine_name" name="vaccine_name" value="<?php echo htmlspecialchars($vaccine['vaccine_name']); ?>" readonly>
            <label for="hospital_name">Hospital Name:</label>
            <input type="text" id="hospital_name" name="hospital_name" value="<?php echo htmlspecialchars($vaccine['hospital_name']); ?>" readonly>
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($vaccine['stock']); ?>">
            <label for="vaccination_date">Vaccination Date:</label>
            <input type="date" id="vaccination_date" name="vaccination_date" value="<?php echo htmlspecialchars($vaccine['vaccination_date']); ?>">

            <label>
                <input type="radio" name="payment" value="free" <?php if ($vaccine['price'] <= 0) echo "checked"; ?>>
                Free
            </label>
            <label>
                <input type="radio" name="payment" value="paid" <?php if ($vaccine['price'] > 0) echo "checked"; ?>>
                Paid
            </label>
            <div class="price-field">
                Price: <input type="text" name="price" value="<?php echo $vaccine['price']; ?>">
            </div>

            <input type="submit" name="update" value="Update">
<input type="button" value="Back" onclick="window.location.href='adminvaccine-list.php';" style="display: block; margin: 5px auto; padding: 10px 20px; background-color: #333; color: #fff; border: none; border-radius: 5px; cursor: pointer;" />

        </form>

    </div>
</body>

</html>


