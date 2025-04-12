<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "balaji";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for driver registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $driving_license = $conn->real_escape_string($_POST['driving_license']);
    $aadhar_card = $conn->real_escape_string($_POST['aadhar_card']);
    $address = $conn->real_escape_string($_POST['address']);

    // Insert data into driver table
    $sql = "INSERT INTO driver (name, phone, password, driving_license, aadhar_card, address, status) 
            VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $phone, $password, $driving_license, $aadhar_card, $address);

    if ($stmt->execute()) {
        echo "Registration successful! Please wait for admin verification.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Registration</title>
</head>
<body>
    <h2>Driver Registration</h2>
    <form action="" method="post">
        <input type="text" name="name" placeholder="Enter Name" required><br>
        <input type="text" name="phone" placeholder="Enter Phone Number" required><br>
        <input type="password" name="password" placeholder="Enter Password" required><br>
        <input type="text" name="driving_license" placeholder="Enter Driving License Number" required><br>
        <input type="text" name="aadhar_card" placeholder="Enter Aadhar Card Number" required><br>
        <textarea name="address" placeholder="Enter Address" required></textarea><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
