<?php
$servername = "localhost";
$username = "root";      // Default user for XAMPP
$password = "";          // Default password is blank
$database = "fitness_tracker";  // Your database name
$port = 3307;
// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection Successful!";
?>
