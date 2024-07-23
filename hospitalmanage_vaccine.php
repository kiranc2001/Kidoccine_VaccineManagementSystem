<?php
session_start();

// Check if the hospital is not logged in
if (!isset($_SESSION['hospital_email'])) {
    header("Location: hospital-login.php");
    exit();
}

// Check if the session has timed out (5 minutes)
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 300)) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: hospital-login.php");
    exit();
}

// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: hospital-logout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vaccine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 1em;
            text-align: center;
        }

        main {
            padding: 20px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <header>
        <h1>Manage Vaccine</h1>
    </header>

    <main>
        <h2>Welcome, <?php echo $_SESSION['hospital_email']; ?>!</h2>

        <button onclick="location.href='hospitaladd-vaccine.php';">Add Vaccine</button>
        <button onclick="location.href='hospitalvaccine-added-list.php';">Vaccine Added List</button>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button type="submit" name="logout">Logout</button>
        </form>
    </main>
</body>

</html>
