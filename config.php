<?php
$host = "localhost"; // XAMPP default host
$user = "root"; // Default MySQL username
$pass = ""; // Default MySQL password (empty)
$dbname = "user_management"; // Change this to your actual database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
