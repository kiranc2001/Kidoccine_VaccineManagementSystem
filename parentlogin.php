<?php
session_start();
include 'db_connection.php';
// Set session timeout to 5 minutes
$session_timeout = 300; // 5 minutes in seconds

// Check if the user is already logged in
if (isset($_SESSION['phone'])) {
    // Check if the session has expired
    if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > $session_timeout) {
        // Session has expired, destroy the session and redirect to login page
        session_unset();
        session_destroy();
        header("Location: parentlogin.php");
        exit;
    }

    // Update last activity timestamp
    $_SESSION['last_activity'] = time();

    // Redirect to dashboard or home page
    header("Location: parentdashboard.php");
    exit;
}

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Check if phone number exists in the database
    $sql = "SELECT * FROM parent WHERE phone = '$phone'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION['phone'] = $phone;
            $_SESSION['last_activity'] = time();
            header("Location: parentdashboard.php");
            exit;
        } else {
            $errors[] = "Incorrect password. Please try again.";
        }
    } else {
        $errors[] = "Phone number not found. Please register first.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Login</title>
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

    <div class="form-container">
        <h2>Login</h2>
        <?php if (!empty($errors)) { ?>
            <div class="errors">
                <?php foreach ($errors as $error) {
                    echo $error . "<br>";
                } ?>
            </div>
        <?php } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="text" name="phone" placeholder="Phone Number" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <div>
            <p>Not registered yet? <a href="parentnewregister.php">Register</a></p>
            <p><a href="parentforgotpassword.php">Forgot Password?</a></p>
 <p><a href="index.php">Go To Home Page</a></p>
        </div>
    </div>

</body>

</html>
