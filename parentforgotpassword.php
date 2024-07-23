<?php
session_start();
include 'db_connection.php';
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];

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
    if ($row['email'] != NULL) {
        // Redirect to email recovery page

        header("Location: parentemailrecovery.php?phone=" . urlencode($phone));


        exit;
    } elseif ($row['recovery_question'] != NULL) {
        // Redirect to question recovery page

        header("Location: parentquestionrecovery.php?phone=" . urlencode($phone));
        exit;
    } else {
        $errors[] = "No recovery method found. Please contact the admin.";
    }
} else {
    $errors[] = "Account not found. Please register first.";                                                                                                       
}


    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-image: url('photos/1.jpg');
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
    .remembered-button {
        margin-top: 10px;
        text-align: center;
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
    <h2>Forgot Password</h2>
    <?php if (!empty($errors)) { ?>
        <div class="errors">
            <?php foreach ($errors as $error) {
                echo $error . "<br>";
            } ?>
        </div>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="text" name="phone" placeholder="Enter Phone Number" required><br>
        <button type="submit">Recover Password</button>
    </form>
    <div class="remembered-button">
        <p>Remembered your password? <a href="parentlogin.php">Login</a></p>
    </div>
</div>

</body>
</html>
