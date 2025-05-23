<?php
session_start(); // Start session to store error messages

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: register.html?error=Please submit the form instead of opening this page directly.");
    exit();
}

// Validate input fields
if (!isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['user_type'])) {
    header("Location: register.html?error=Missing form fields.");
    exit();
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$user_type = trim($_POST['user_type']);

if (empty($username) || empty($email) || empty($password) || empty($user_type)) {
    header("Location: register.html?error=All fields are required.");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: register.html?error=Invalid email format.");
    exit();
}

// Hash the password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Database connection
$conn = new mysqli("localhost", "root", "", "user_management");

if ($conn->connect_error) {
    header("Location: register.html?error=Database Connection Failed.");
    exit();
}

// ✅ CHECK IF EMAIL ALREADY EXISTS
$check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check_email->bind_param("s", $email);
$check_email->execute();
$check_email->store_result();

if ($check_email->num_rows > 0) {
    header("Location: register.html?error=Email already registered. Please use a different email.");
    exit();
}
$check_email->close();

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// ✅ INSERT NEW USER
$sql = "INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header("Location: register.html?error=SQL Error: " . urlencode($conn->error));
    exit();
}

$stmt->bind_param("ssss", $username, $email, $hashed_password, $user_type);

if ($stmt->execute()) {
    header("Location: signIn.html?success=Registration successful! Please log in.");
    exit();
} else {
    header("Location: register.html?error=Error: " . urlencode($stmt->error));
    exit();
}

$stmt->close();
$conn->close();
