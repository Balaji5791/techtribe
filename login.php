<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "balaji";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $_POST['password'];

    // Fetch driver details
    $sql = "SELECT id, password, status FROM driver WHERE phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $status);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            if ($status == 'verified') {
                echo "Login successful! Welcome, Driver.";
                // Redirect to the driver's dashboard or home page
            } else {
                echo "Your account is $status. Please wait for admin approval.";
            }
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Phone number not registered.";
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
    <title>Driver Login</title>
</head>
<body>
    <h2>Driver Login</h2>
    <form action="" method="post">
        <input type="text" name="phone" placeholder="Enter Phone Number" required><br>
        <input type="password" name="password" placeholder="Enter Password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
