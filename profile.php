<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "Error: User not logged in.";
    exit();
}

// If the user is logged in, fetch the user details from the database
$conn = new mysqli("localhost", "root", "", "user_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use the session username to fetch the user profile details
$username = $_SESSION['username'];

$sql = "SELECT username, email, user_type FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    ?>
    <div class="profile-page">
        <h3>Profile Information</h3>
        <div class="profile-card">
            <div class="profile-icon">
                <i class="fa fa-user-circle fa-4x"></i>
            </div>
            <h4>Name: <?php echo htmlspecialchars($user['username']); ?></h4>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>User Type: <?php echo htmlspecialchars($user['user_type']); ?></p>
        </div>
    </div>
    <?php
} else {
    echo "Error: User details not found.";
}

$conn->close();
?>
