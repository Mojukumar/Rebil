<?php
session_start(); // Start the session

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "user_management";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check user in database
    $stmt = $conn->prepare("SELECT id, user_type, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Verify password
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_type"] = $row["user_type"];
            $_SESSION["loggedin"] = true;
            $_SESSION["user_email"] = $email;

            header("Location: home.html"); // Redirect to home page
            exit();
        } else {
            echo "<script>alert('Invalid credentials'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials'); window.location.href='login.php';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
