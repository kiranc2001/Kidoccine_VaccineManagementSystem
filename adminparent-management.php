<!-- hospital-management.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
            padding: 20px;
        }

        h2, h3 {
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
            margin-bottom: 10px;
            width: 100%;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #217dbb;
        }
    </style>
</head>

<body>
    <div class="management-container">
        <h2>Parent Management</h2>

        <h3></h3>
        <button onclick="showHospitalAddRequests()">Parent List</button>
        <button onclick="showTotalHospitalList()">Parent Ordered List</button>
 <button onclick="showDashboard()">Go to Dashboard</button>
        
    </div>

    <script>
        function showHospitalAddRequests() {
            // Implement the logic to show hospital add requests
            
window.location.href = 'adminparentlist.php';
        }

        function showTotalHospitalList() {
            // Implement the logic to show total hospital list
            window.location.href = 'adminparentorderedlist.php';
        }
function showDashboard() {
            // Implement the logic to show total hospital list
            window.location.href = 'admin-dashboard.php';
        }


       
    </script>
</body>

</html>
