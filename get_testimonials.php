<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "user_management";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

header("Content-Type: application/json");

$sql = "SELECT name, email, profile_image, rating, review, created_at FROM testimonials ORDER BY created_at DESC";
$result = $conn->query($sql);

$testimonials = [];
while ($row = $result->fetch_assoc()) {
    $testimonials[] = $row;
}

echo json_encode($testimonials);

$conn->close();
?>
