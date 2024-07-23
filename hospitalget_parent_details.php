<?php
// Database connection
session_start();
include 'db_connection.php';
$hospital = $_SESSION['hospital_name'];

// Create connection
/*$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

// SQL query to fetch parent details
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM booked_vaccines WHERE hospital='$hospital' AND (parent_phone_number LIKE '%$search%' OR hospital='$hospital' AND vaccine_name LIKE '%$search%' OR hospital='$hospital' AND child_name LIKE '%$search%' OR hospital='$hospital' AND parent_name LIKE '%$search%' OR hospital='$hospital' AND email_id LIKE '%$search%' OR hospital='$hospital' AND vaccination_status LIKE '%$search%') ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM booked_vaccines WHERE hospital='$hospital' ORDER BY created_at DESC";
}
$result = $conn->query($sql);

$parent_details = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $parent_details[] = $row;
    }
} else {
    //echo "No results found";
}

$conn->close(); // Close the database connection
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        form {
            display: inline-block;
            margin-bottom: 20px;
        }

        .status {
            font-weight: bold;
            color: green;
        }

        .search-input {
            padding: 5px;
            margin-right: 5px;
        }

        .search-button {
            padding: 5px 10px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
.dashboard-button {
    display: inline-block;
    padding: 5px 10px;
    background-color: #333;
    color: white;
    text-decoration: none;
    margin-left: 10px;
    border-radius: 5px;
}
.dashboard-button:hover {
    background-color: #555;
}

    </style>
</head>

<body>
    <h1>Parent Details</h1>
    <form method="get">
        <input class="search-input" type="text" name="search" placeholder="Search...">
        <button class="search-button" type="submit">Search</button>
    </form>
<a href="hospital_dashboard.php" class="dashboard-button">Go to Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>Parent Phone</th>
                <th>Hospital Name</th>
                <th>Vaccine Name</th>
                <th>Child Name</th>
                <th>Parent Name</th>
                <th>Price</th>
                <th>Child DOB</th>
                <th>Vaccination Date</th>
                <th>Ordered Date</th>
                <th>Parent Gmail</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
    if (empty($parent_details)) {
        echo "<tr><td colspan='11'>No results found</td></tr>";
    } else {
        foreach ($parent_details as $detail) :
    ?>
                <tr>
                    <td><?php echo $detail['parent_phone_number']; ?></td>
                    <td><?php echo $detail['hospital']; ?></td>
                    <td><?php echo $detail['vaccine_name']; ?></td>
                    <td><?php echo $detail['child_name']; ?></td>
                    <td><?php echo $detail['parent_name']; ?></td>
                    <td><?php echo $detail['vaccine_price']; ?></td>
                    <td><?php echo $detail['child_dob']; ?></td>
                    <td><?php echo $detail['vaccination_date']; ?></td>
                    <td><?php echo $detail['created_at']; ?></td>
                    <td><?php echo $detail['email_id']; ?></td>
                    <td>
                        <?php if ($detail['vaccination_status'] == 'pending') : ?>
                            <form action="update-status.php" method="post">
                                <input type="hidden" name="hospital_name" value="<?php echo $detail['hospital']; ?>">
                                <input type="hidden" name="vaccine_name" value="<?php echo $detail['vaccine_name']; ?>">
                                <input type="hidden" name="parent_phone" value="<?php echo $detail['parent_phone_number']; ?>">
                                <input type="hidden" name="child_name" value="<?php echo $detail['child_name']; ?>">
                                <input type="hidden" name="child_dob" value="<?php echo $detail['child_dob']; ?>">
                                <input type="hidden" name="parent_name" value="<?php echo $detail['parent_name']; ?>">
                                <input type="hidden" name="vaccination_date" value="<?php echo $detail['vaccination_date']; ?>">
                                <input type="hidden" name="email" value="<?php echo $detail['email_id']; ?>">
                                <select name="status">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Vaccinated</option>
                                    <option value="not_vaccinated">Not Vaccinated</option>
                                </select>
                                <button type="submit">Update Status</button>
                            </form>
                        <?php else : ?>
                            <span class="status"><?php echo ucfirst($detail['vaccination_status']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach;
            } ?>
        </tbody>
    </table>
</body>

</html>
