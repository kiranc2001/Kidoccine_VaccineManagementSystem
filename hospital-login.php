<?php
session_start();
include 'db_connection.php';
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
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
   

    // Check if the hospital email exists in the database
    $sql = "SELECT * FROM hospital_credentials WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if ($password === $row['password']) {
            // Password is correct, store data in session
            $_SESSION['hospital_email'] = $email;
            $_SESSION['hospital_name'] = $row['hospital_name']; // Assuming the column name is 'hospital_name'
            $_SESSION['hospital_address'] = $row['address'];

            // Redirect to hospital dashboard
            header("Location: hospital_dashboard.php");
            exit();
        } else {
            // Password is incorrect
            $errors[] = "Incorrect password";
        }
    } else {
        // Hospital does not exist
        $errors[] = "Hospital does not exist";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hospital Login</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-image: url('background.jpg');
        background-size: cover;
        background-position: center;
    }
    .login-container {
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
        padding: 10px;
        margin-top: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
        width: 100%;
    }
    button:hover {
        background-color: #0056b3;
    }
    .errors {
        color: red;
        margin-bottom: 10px;
    }
</style>
</head>
<body>

<div class="login-container">
    <h2>Hospital Login</h2>
    <?php if (!empty($errors)) { ?>
        <div class="errors">
            <?php foreach ($errors as $error) {
                echo $error . "<br>";
            } ?>
        </div>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
<form action="index.php">
        <button type="submit">Move to Home Page</button>
    </form>
</div>

</body>
</html>
