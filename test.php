<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "✅ Form submitted!<br>";

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['user_type'])) {
        echo "Username: " . htmlspecialchars($_POST['username']) . "<br>";
        echo "Email: " . htmlspecialchars($_POST['email']) . "<br>";
        echo "User Type: " . htmlspecialchars($_POST['user_type']) . "<br>";
    } else {
        echo "❌ Missing form fields!";
    }
} else {
    echo "❌ No form submission detected.";
}
?>

<!-- Test Form -->
<form action="test.php" method="post">
    <input type="hidden" name="username" value="TestUser">
    <input type="hidden" name="email" value="test@example.com">
    <input type="hidden" name="password" value="123456">
    <input type="hidden" name="user_type" value="user">
    <button type="submit">Test Submission</button>
</form>
