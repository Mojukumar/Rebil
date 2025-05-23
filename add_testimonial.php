<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "user_management";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $rating = $_POST["rating"];
    $review = $_POST["review"];
    $created_at = date("Y-m-d H:i:s");

    // Handle Profile Image Upload
    $profile_image = NULL;
    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $profile_image = $file_name;
        }
    }

    // Validate input
    if (!$name || !$email || !$rating || !$review) {
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO testimonials (name, email, profile_image, rating, review, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $name, $email, $profile_image, $rating, $review, $created_at);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Testimonial added successfully"]);
    } else {
        echo json_encode(["error" => "Failed to add testimonial"]);
    }

    $stmt->close();
}

$conn->close();
?>
