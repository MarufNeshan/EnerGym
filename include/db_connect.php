<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness_tracker";
$port = 3307; // If you changed the MySQL port in XAMPP

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
