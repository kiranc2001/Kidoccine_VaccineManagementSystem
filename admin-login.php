<?php
// Resume the session
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_email'])) {
    header("Location: admin-dashboard.php");
    exit();
}
include 'db_connection.php';
// Database connection details
/*$host = "localhost";
$username = "root";
$password = "";
$database = "vaccine";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate input (you may want to add more validation)
    if (empty($email) || empty($password)) {
        $error_message = "Please enter both email and password.";
    } else {
        // Check credentials against the database
        $query = "SELECT * FROM admin_users WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            // Start or resume the session
            session_start();

            // Set session variables
            $_SESSION['admin_email'] = $email;
            $_SESSION['login_time'] = time();

            // Redirect to the admin dashboard on successful login
            header("Location: admin-dashboard.php");
            exit();
        } else {
            $error_message = "Invalid email or password. Please try again.";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #f44336;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        .password-change-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
        }

        .password-change-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <?php
        // Display error message if any
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>

        <a class="password-change-link" href="adminforget-password.php">Forgot Password</a>
 <a class="password-change-link" href="index.php">Home Page</a>

    </div>
</body>

</html>
