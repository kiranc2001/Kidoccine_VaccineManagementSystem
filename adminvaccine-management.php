<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .management-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            text-align: center;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #3498db;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #217dbb;
        }
    </style>
</head>

<body>
    <div class="management-container">
        <h2>Vaccine Management</h2>

        <form method="post" action="adminadd-vaccine.php">
            <button type="submit">Add Vaccine</button>
        </form>

        <form method="post" action="adminvaccine-list.php">
            <button type="submit"> Vaccine List</button>
        </form>

        <form method="post" action="adminnew-vaccine.php">
            <button type="submit">Hospital Added Vaccines</button>
        </form>
 <form method="post" action="admin-dashboard.php">
            <button type="submit">Go To Dashboard</button>
        </form>
    </div>

    </div>
</body>

</html>
