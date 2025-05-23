<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to MySQL
    $conn = new mysqli("localhost", "root", "", "user_management");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and collect data
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $subject = $conn->real_escape_string($_POST["subject"]);
    $message = $conn->real_escape_string($_POST["message"]);

    // Insert into DB
    $sql = "INSERT INTO contact_messages (name, email, subject, message)
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to contact.html with success query param
        header("Location: contact.html?success=1");
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    exit;
} else {
    // If accessed directly, redirect to form
    header("Location: contact.html");
    exit;
}
?>
