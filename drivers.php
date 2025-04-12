<?php
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "balaji";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    // Insert data into database
    $sql = "INSERT INTO driver (name, phone, address) VALUES ('$name', '$phone', '$address')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "<div class='success'>✅ New record added successfully!</div>";
    } else {
        $message = "<div class='error'>❌ Error: " . $conn->error . "</div>";
    }
}

// Fetch records from the database
$sql = "SELECT * FROM driver";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1E1E1E;
            padding: 15px;
            color: white;
        }

        .container {
            background-color: #1E1E1E;
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            margin-top: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        input, textarea {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: none;
            background: #333;
            color: white;
        }

        .btn {
            background: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #45a049;
        }

        .success {
            color: #4CAF50;
            margin-top: 10px;
            font-weight: bold;
        }

        .error {
            color: #FF0000;
            margin-top: 10px;
            font-weight: bold;
        }

        table {
            margin-top: 20px;
            width: 80%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid white;
            padding: 10px;
            text-align: center;
        }

        .bottom-nav {
            display: flex;
            justify-content: space-around;
            background-color: #1E1E1E;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .bottom-nav a {
            color: white;
            text-decoration: none;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h2>Drivers</h2>
        <a href="driver.php" class="btn">+</a>
    </div>

    <div class="container">
        <h2>Enter Driver Details</h2>
        <?php echo $message; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Enter Name" required><br>
            <input type="text" name="phone" placeholder="Enter Phone" required><br>
            <input type="text" name="address" placeholder="Enter Address" required><br>
            <input type="submit" class="btn" value="Submit">
        </form>
    </div>

    <h2>Driver Records</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["address"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        ?>
    </table>

    <div class="bottom-nav">
        <a href="Drivers.phpy">Drivers</a>
        <a href="Shipments.html">Shipments</a>
        <a href="Notifications.html">Notifications</a>
        <a href="Users.html">Users</a>
    </div>

</body>
</html>

<?php
$conn->close();
?>
