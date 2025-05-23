<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "user_management"; // Ensure this database exists

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

header("Content-Type: application/json");

// Ensure table exists and has data
$sql = "SELECT id, plan_name, description, price, price_duration, features, created_at FROM pricing_plans ORDER BY created_at DESC";
$result = $conn->query($sql);

if (!$result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$pricingPlans = [];
while ($row = $result->fetch_assoc()) {
    $pricingPlans[] = $row;
}

// If no data is found, return an empty array with a message
if (empty($pricingPlans)) {
    echo json_encode(["message" => "No pricing plans found"]);
} else {
    echo json_encode($pricingPlans);
}

$conn->close();
?>
