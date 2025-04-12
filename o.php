<?php
// Start session
session_start();

// Check if driver is logged in
if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit();
}

// Get driver details
$driver_name = $_SESSION['driver_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #121212;
            color: white;
            padding: 20px;
        }
        .container {
            background-color: #1E1E1E;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            margin: auto;
        }
        .btn {
            background: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 200px;
            border-radius: 5px;
            margin: 10px;
        }
        .btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($driver_name); ?>!</h2>
        <h3>Driver Dashboard</h3>
        <a href="shipments.html" class="btn">Shipments</a>
        <a href="users.html" class="btn">Users</a>
        <a href="notifications.html" class="btn">Notifications</a>
        <br><br>
        <a href="logout.php" class="btn" style="background:red;">Logout</a>
    </div>
</body>
</html>
