<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "balaji";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);
    $stock = $conn->real_escape_string($_POST['stock']);
    $place = $conn->real_escape_string($_POST['place']);
    $details = $conn->real_escape_string($_POST['details']);

    // Insert data into shipping table
    $sql = "INSERT INTO shipping (name, price, stock, place, details) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdiss", $name, $price, $stock, $place, $details);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page to show new data
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch all shipping records
$sql = "SELECT name, price, stock, place, details FROM shipping";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #1E1E1E;
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            margin: 20px auto;
        }
        input, textarea {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
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
        }
        .btn:hover {
            background: #45a049;
        }
        table {
            margin-top: 20px;
            width: 90%;
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
        }
        th, td {
            border: 1px solid white;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #1E1E1E;
        }
        tr:nth-child(even) {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Shipping Details</h2>
        <form action="" method="post">
            <input type="text" name="name" placeholder="Enter Name" required><br>
            <input type="number" step="0.01" name="price" placeholder="Enter Price" required><br>
            <input type="number" name="stock" placeholder="Enter Stock" required><br>
            <input type="text" name="place" placeholder="Enter Place" required><br>
            <textarea name="details" placeholder="Enter Details" required></textarea><br>
            <input type="submit" class="btn" value="Submit">
        </form>
    </div>

    <h2>Live Shipping Data</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Place</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['stock']); ?></td>
                    <td><?php echo htmlspecialchars($row['place']); ?></td>
                    <td><?php echo htmlspecialchars($row['details']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php $conn->close(); ?>