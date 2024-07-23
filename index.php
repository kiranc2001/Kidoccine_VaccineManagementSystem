<?php
session_start();
include 'db_connection.php';
// Database connection details
/*$host = "localhost";
$username = "root";
$db_password = "";
$database = "vaccine";

// Create connection
$conn = new mysqli($host, $username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

$sql = "SELECT DISTINCT vaccine_name FROM added_vaccines LIMIT 4"; // Assuming 'added_vaccines' table has columns 'vaccine_name', 'stock'
$result = $conn->query($sql);

$vaccines = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vaccine_name = $row['vaccine_name'];
        $sql = "SELECT * FROM added_vaccines WHERE vaccine_name = '$vaccine_name' AND stock > 0"; // Check stock in all hospitals for this vaccine
        $result_stock = $conn->query($sql);
        if ($result_stock && $result_stock->num_rows > 0) {
            $vaccine = $result_stock->fetch_assoc();
            $vaccines[] = $vaccine;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIDOCCINE</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('photos/5.jpg'); /* Update path to your image */
            background-size: cover;
            background-position: center;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2em;
        }

        #logo {
    width: 120px; /* Set the width of the logo */
    height: auto; /* Maintain aspect ratio */
    margin-top: 20px; /* Add space above the logo */
    margin-bottom: 20px; /* Add space below the logo */
    margin-left: auto; /* Auto margin left and right to center horizontally */
    margin-right: auto;
    display: block; /* Make it a block element to center */
}


        #loginOptions {
            display: flex;
            justify-content: center;
            margin-bottom: 20px; /* Add space below the login options */
        }

        #loginOptions select {
            padding: 0.5em;
            margin: 0 10px;
        }

        #vaccinePhotos {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 1em;
            margin-top: 2em;
        }

        .vaccine-photo {
            width: 250px;
            height: 350px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: none;
        }

        .vaccine-photo img {
            width: 100%;
            height: 70%;
            object-fit: cover;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .vaccine-info {
            padding: 1em;
            background-color: silver;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center;
            transition: none;
        }

        .book-vaccine-btn {
            background-color: #3498db;
            color: white;
            padding: 1em;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            margin-top: 0.5em;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .book-vaccine-btn:hover {
            background-color: #217dbb;
        }

        #moreVaccinesBtn {
            background-color: red;
            color: white;
            padding: 1em;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            margin-top: 2em;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        #moreVaccinesBtn:hover {
            background-color: red;
        }
    </style>
</head>

<body>
    <img id="logo" src="photos/logo.jpg" alt="KiddoCine Logo">
    <main>
        <div id="loginOptions">
        
        <select onchange="redirectToPage(this.value)">
            <option value="" selected disabled>Login Options</option>
                <option value="hospital-login.php">Hospital Login</option>
                <option value="parentlogin.php">Parent Login</option>
                <option value="hospital-request.php">Hospital Add Request</option>
<option value="admin-login.php">Admin Login</option>

            </select>
        </div>
        <h2 style="color:black;">KIDOCCINE</h2>
        <div id="vaccinePhotos">
            <?php foreach ($vaccines as $vaccine): ?>
                <div class="vaccine-photo">
                    <div class="vaccine-info">
                        <h3><?php echo $vaccine['vaccine_name']; ?></h3>
                        <p>Stock: <?php echo $vaccine['stock'] > 0 ? '<span style="color: green;">Available</span>' : '<span style="color: red;">Out of Stock</span>'; ?></p>
                        <p><?php echo $vaccine['price'] > 0 ? '<span style="color: red;">Paid - Rs.' . $vaccine['price'] . '</span>' : 'Free'; ?></p>

                        <button class="book-vaccine-btn" onclick="redirectToBookVaccine('<?php echo $vaccine['vaccine_name']; ?>')">Book Vaccine</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button id="moreVaccinesBtn" onclick="redirectToMoreVaccines()">More Vaccines</button>
    </main>

    <script>
        function redirectToBookVaccine(name) {
            window.location.href = `book-vaccine.php?name=${encodeURIComponent(name)}`;
        }

        function redirectToMoreVaccines() {
            window.location.href = 'more-vaccines.php';
        }
        function redirectToPage(url) {
            if (url) {
                window.location.href = url;
            }
        }
    </script>
</body>

</html>
