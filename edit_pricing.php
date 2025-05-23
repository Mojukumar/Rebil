<?php
include 'config.php'; // your DB connection file
session_start(); // Make sure the session is started

header("Content-Type: application/json");

// ✅ Check if the user is logged in and is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(["error" => "Unauthorized access. Admins only."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'], $data['price'], $data['features'])) {
    $id = $conn->real_escape_string($data['id']);
    $price = $conn->real_escape_string($data['price']);
    $features = $conn->real_escape_string($data['features']);

    $sql = "UPDATE pricing_plans SET price = '$price', features = '$features' WHERE id = '$id'";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Pricing plan updated successfully."]);
    } else {
        echo json_encode(["error" => "Failed to update plan: " . $conn->error]);
    }
} else {
    echo json_encode(["error" => "Invalid input data."]);
}

$conn->close();
?>
