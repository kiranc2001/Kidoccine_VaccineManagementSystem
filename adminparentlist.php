<?php
session_start();

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $parent_id = $_POST['delete'];
    $sql = "DELETE FROM parent WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Parent deleted successfully.'); window.location.href = 'adminparentlist.php';</script>";
}

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql = "SELECT * FROM parent WHERE name LIKE '%$search_query%' OR email LIKE '%$search_query%' OR phone LIKE '%$search_query%'";
} else {
    $sql = "SELECT * FROM parent";
}

$result = $conn->query($sql);

$parents = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $parents[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        input[type="text"] {
            padding: 8px;
            font-size: 16px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            padding: 8px 15px;
            font-size: 16px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .delete-button {
            background-color: #d32f2f;
            color: white;
        }

        .delete-button:hover {
            background-color: #b71c1c;
        }
    </style>
</head>

<body>
    <h2>Parent List</h2>
    <div class="search-container">
    <form method="get">
        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit">Search</button>
    </form>
   <a href="adminparent-management.php" style="display: inline-block; margin-left: 5px;margin-top:10px; color: #333; text-decoration: none; padding: 10px; border: 1px solid #333; border-radius: 50px;">Go Back</a>

</div>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($parents as $parent) {
            echo "<tr>";
            echo "<td>" . $parent['name'] . "</td>";
            echo "<td>" . $parent['email'] . "</td>";
            echo "<td>" . $parent['phone'] . "</td>";
            echo "<td class='action-buttons'>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='delete' value='" . $parent['id'] . "'>";
            echo "<button type='submit' class='delete-button'>Delete</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>
