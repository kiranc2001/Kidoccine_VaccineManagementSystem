<?php

session_start();
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

$errors = array();
$message = '';

// Check if phone number is set in the URL
if (isset($_GET['phone'])) {
    $phone = $_GET['phone'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dob = $_POST['dob'];
        $check_phone_query = "SELECT * FROM parent WHERE phone='$phone'";
        $result = mysqli_query($conn, $check_phone_query);
        $user = mysqli_fetch_assoc($result);

        if ($user && $user['recovery_question'] == $dob) {
            header("Location: parentquestionnewpassword.php?phone=" . urlencode($phone));
            exit();
        } else {
            $message = '<span style="color:red;">Incorrect date of birth. Please try again.</span>';
        }
    }
} else {
    // Handle the case when phone is not set
    echo "Phone number not found in URL.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        h2 {
            text-align: center;
            padding: 20px 0;
        }

        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        .message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }

    </style>
</head>

<body>
    <h2>Enter your date of birth to verify</h2>
    <?php if (!empty($message)) : ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" placeholder="YYYY-MM-DD" required><br><br>
        <button type="submit">Verify Date of Birth</button>
<input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
    </form>
</body>

</html>
