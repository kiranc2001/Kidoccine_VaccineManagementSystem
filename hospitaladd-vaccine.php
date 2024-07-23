<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';
$errors = array();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['hospital_email'];
    $hospital_name = $_SESSION['hospital_name'];
    $hospital_address = $_SESSION['hospital_address'];
    $vaccine_name = $_POST['vaccine_name'];
    $stock = $_POST['stock'];
    $vaccination_date = $_POST['vaccination_date'];
    $price_type = $_POST['price_type'];
    $price = ($_POST['price_type'] == 'paid' && !empty($_POST['price'])) ? $_POST['price'] : '0';
    // Database connection details
   /* $host = "localhost";
    $username = "root";
    $db_password = "";
    $database = "vaccine";

    // Create connection
    $conn = new mysqli($host, $username, $db_password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }*/
    

    // Insert data into hospital_vaccines table
    $sql = "INSERT INTO hospital_vaccines (hospital_name, hospital_email, hospital_address, vaccine_name, stock, vaccination_date, price_type, price)
            VALUES ('$hospital_name', '$email', '$hospital_address', '$vaccine_name', '$stock', '$vaccination_date', '$price_type', '$price')";

    if ($conn->query($sql) === TRUE) {
        // Record inserted successfully
        $message = "Vaccine submitted successfully";
    } else {
        $errors[] = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Check if a message is provided
    if (!empty($_POST['message'])) {
        $message = $_POST['message'];
        // Insert message into hospital_messages table
        $sql_message = "INSERT INTO hospital_messages (hospital_name, hospital_email, message)
                        VALUES ('$hospital_name', '$email', '$message')";
        if ($conn->query($sql_message) !== TRUE) {
            $errors[] = "Error: " . $sql_message . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Vaccine</title>
<style>
  body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-image: url('.jpg'); /* Consider a simpler background image */
  background-size: cover;
  background-position: center;
  color: #333; /* Dark Grey */
}

header {
  background-color: #4682b4; /* Steel Blue */
  color: white;
  padding: 0.5em; /* Reduced padding */
  text-align: center;
}

main {
  padding: 10px; /* Reduced padding */
  text-align: center;
}

form {
  display: inline-block;
  text-align: left;
  background-color: rgba(255, 255, 255, 0.8); /* Light Blue with transparency */
  padding: 15px; /* Reduced padding */
  border-radius: 10px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Reduced shadow size */
}

.container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Responsive columns */
  grid-gap: 5px; /* Reduced gap */
}

.readonly-side {
  background-color: #f5f5f5; /* Lighter grey */
  padding: 3px; /* Reduced padding */
  border-radius: 5px;
  border: 1px solid #ddd; /* Thinner border */
}

.form-side {
  padding: 3px; /* Reduced padding */
  border-radius: 5px;
  border: 1px solid #ddd; /* Thinner border */
}

label {
  display: block;
  margin-bottom: 5px; /* Reduced margin */
  font-size: 0.8em; /* Smaller font size */
  color: #333; /* Dark Grey */
}

input,
select {
  padding: 5px; /* Reduced padding */
  width: 100%;
  margin-bottom: 5px; /* Reduced margin */
  box-sizing: border-box;
  border: 1px solid #ccc; /* Light Grey */
  border-radius: 5px;
  font-size: 0.8em; /* Smaller font size */
}

textarea {
  width: 100%;
  padding: 5px; /* Reduced padding */
  margin-bottom: 5px; /* Reduced margin */
  box-sizing: border-box;
  border: 1px solid #ccc; /* Light Grey */
  border-radius: 5px;
  font-size: 0.8em; /* Smaller font size */
  resize: vertical;
}

button {
  padding: 5px 10px; /* Reduced padding */
  margin-top: 5px; /* Reduced margin */
  border: none;
  border-radius: 5px;
  cursor: pointer;
  background-color: #f08080; /* Light coral */
  color: white;
  font-size: 0.8em; /* Smaller font size */
}

button:hover {
  background-color: #c0392b; /* Darker red */
}

/* Added styles for #goToDashboard button */
#goToDashboard {
  background-color: #428bca; /* Blue */
  color: white;
  padding: 2px 5px; /* Very small padding */
  position: fixed; /* Fix to the bottom of the page */
  bottom: 10px; /* Adjust the distance from the bottom */
  right: 10px; /* Adjust the distance from the right */
}

#goToDashboard:hover {
  background-color: #357fec; /* Darker blue */
}

.popup {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 20px;
  

  border-radius: 5px;
  box-shadow: 0 2px 5
px rgba(0, 0, 0, 0.2);
  z-index: 9999;
}

.overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9998;
}

.popup h2 {
  margin-top: 0;
}

.popup button {
  margin-top: 10px;
}


</style>
</head>
<body>
<header>
    <h1>Add Vaccine</h1>
</header>
<main>
    <form id="addVaccineForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" id="hospital_name" name="hospital_name" value="<?php echo $_SESSION['hospital_name']; ?>">
        <input type="hidden" id="hospital_address" name="hospital_address" value="<?php echo $_SESSION['hospital_address']; ?>">
        <div class="container">
        <div class="readonly">
            <label for="hospital_name">Hospital Name:</label>
            <input type="text" id="hospital_name" name="hospital_name" value="<?php echo $_SESSION['hospital_name']; ?>" readonly>
            
            <label for="hospital_address">Hospital Address:</label>
            <input type="text" id="hospital_address" name="hospital_address" value="<?php echo $_SESSION['hospital_address']; ?>" readonly>
        </div>

        <div class="form-side">
            <label for="vaccine_name">Vaccine Name (Only In Block Letters):</label><br>
            <input type="text" id="vaccine_name" name="vaccine_name" required><br><br>

            <label for="stock">Stock:</label><br>
            <input type="number" id="stock" name="stock" required><br><br>

            <label for="vaccination_date">Vaccination Starting Date:</label><br>
            <input type="date" id="vaccination_date" name="vaccination_date" required><br><br>

            <label for="price">Price:</label><br>
            <input type="radio" id="free" name="price_type" value="free" onclick="hidePrice()"> Free<br>
            <input type="radio" id="paid" name="price_type" value="paid" onclick="showPrice()"> Paid<br>
            <input type="number" id="price" name="price" style="display:none;"><br><br>

            <label for="message">Message (optional):</label><br>
            <textarea id="message" name="message" rows="4" cols="50"></textarea><br><br>
        </div>
    </div>

    <input type="submit" value="Add Vaccine">
</form>

<button id="goToDashboard" onclick="window.location.href='hospital_dashboard.php'">Go to Dashboard</button>

<div class="popup" id="popup">
    <h2>Vaccine Submitted</h2>
    <button onclick="window.location.href='hospital_dashboard.php';">OK</button>
</div>
<div class="overlay" id="overlay"></div>
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
                    event.preventDefault(); // Prevent form submission if validation fails
                }
            });
        </script>
        <script>
    function showPrice() {
        document.getElementById("price").style.display = "block";
    }

    function hidePrice() {
        document.getElementById("price").style.display = "none";
    }

    <?php if ($message) { ?>
    document.getElementById("popup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
    <?php } ?>
</script>
</main>
</body>
</html>


