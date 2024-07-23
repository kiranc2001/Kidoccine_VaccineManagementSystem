<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parent Registration</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-image: url('photos/3.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .form-container {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        width: 300px;
    }
    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }
    button {
        padding: 10px 20px;
        margin-top: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
    }
    button:hover {
        background-color: #0056b3;
    }
    .errors {
        color: red;
        margin-bottom: 10px;
    }
    .instructions {
        margin-bottom: 10px;
    }
    a {
        color: #007bff;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<?php


session_set_cookie_params(300); // 5 minutes in seconds
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Database connection details
    /*$host = "localhost";
    $username = "root";
    $db_password = "";
    $database = "vaccine";

    // Create connection
    $conn = new mysqli($host, $username, $db_password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }*/

    // Check if phone number is already registered
    $sql = "SELECT COUNT(*) as count FROM parent WHERE phone = '$phone'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $isPhoneRegistered = ($row['count'] > 0);
    } else {
        $errors[] = "Error checking phone number. Please try again";
    }

    // Validate password
    if (!preg_match("/^(?=.*\d)(?=.*[A-Z])(?=.*[!@#$%^&*()-_=+])[0-9A-Za-z!@#$%^&*()-_=+]{8,10}$/", $password)) {
        $errors[] = "Password must be between 8 to 10 characters and contain at least one numeric digit, one uppercase letter, and one special character.";
    }
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // If phone number is already registered, show message and stop further execution
    if ($isPhoneRegistered) {
        $errors[] = "Phone number is already registered. Please login.";
    }

    // Insert user details into the database if no errors
    if (empty($errors)) {
        $insertQuery = "INSERT INTO parent (name, phone, password) VALUES ('$name', '$phone', '$hashed_password')";
       if ($conn->query($insertQuery) === TRUE) {
$_SESSION['registered'] = true;
 $encoded_phone = urlencode($phone);;
           echo "<script>alert('Almost There Complete the Following Process'); window.location.href = 'password_recovery_options.php?phone=$encoded_phone';</script>";

                      exit;
        } else {
            $errors[] = "Error registering user. Please try again.";
        }
    }

    //$conn->close();
}

// Check if the session has timed out
if (isset($_SESSION["timeout"]) && $_SESSION["timeout"] < time()) {
    // Session has timed out, delete the registration from the database
    $deleteQuery = "DELETE FROM parent WHERE phone = '$phone'";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('Session timed out. Registration deleted.');</script>";
    } else {
        echo "<script>alert('Error deleting registration.');</script>";
    }

    // Destroy the session
    session_destroy();

    // Redirect to registration page
    header("Location: parentregister.php");
    exit;
}
 $conn->close();
?>

<div class="form-container">
    <h2>Register</h2>
    <div class="instructions">
        <p>Password must be between 8 to 10 characters and contain at least one numeric digit, one uppercase letter, and one special character.</p>
    </div>
    <?php if (!empty($errors)) { ?>
        <div class="errors">
            <?php foreach ($errors as $error) {
                echo $error . "<br>";
            } ?>
        </div>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="text" name="name" placeholder="Name" required><br>
       <input type="text" name="phone" placeholder="Phone Number" required>

        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
    <div>
        <p>Already registered? <a href="parentlogin.php">Login</a></p>
<p><a href="index.php">Go To Home Page</a></p>

    </div>
</div>


</body>
</html>
