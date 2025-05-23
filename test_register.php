<!-- test_register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Registration</title>
</head>
<body>

<h2>Test Registration Form</h2>

<form action="register.php" method="post">
    <input type="hidden" name="username" value="TestUser">
    <input type="hidden" name="email" value="test@example.com">
    <input type="hidden" name="password" value="123456">
    <input type="hidden" name="user_type" value="user">
    <button type="submit">Test Submission</button>
</form>

</body>
</html>
