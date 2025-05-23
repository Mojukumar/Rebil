<?php
session_start();
$stage = "email"; // default
$error = "";
$resetEmail = "";

// Handle form logic
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Stage 1: User submitted email
    if (isset($_POST["email"])) {
        $email = $_POST["email"];

        // Connect to DB
        $conn = new mysqli("localhost", "root", "", "user_management");
        if ($conn->connect_error) {
            die("DB Connection Failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $resetEmail = $email;
            $stage = "reset";
        } else {
            $error = "Email not found in our records!";
        }

        $stmt->close();
        $conn->close();

    } elseif (
        isset($_POST["new_password"]) &&
        isset($_POST["confirm_password"]) &&
        isset($_POST["reset_email"])
    ) {
        $newPassword = $_POST["new_password"];
        $confirmPassword = $_POST["confirm_password"];
        $resetEmail = $_POST["reset_email"];

        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $conn = new mysqli("localhost", "root", "", "user_management");
            if ($conn->connect_error) {
                die("DB Connection Failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashedPassword, $resetEmail);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: signIn.html");
                exit;
            } else {
                $error = "Failed to update password.";
            }

            $stmt->close();
            $conn->close();
        } else {
            $error = "Passwords do not match!";
            $stage = "reset";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | REBIL Recruit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Style -->
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            max-width: 450px;
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            margin-top: 6%;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1.2s ease-out;
        }

        h3 {
            text-align: center;
            margin-bottom: 1rem;
            font-weight: bold;
            color: #ffffff;
        }

        .btn-primary, .btn-success {
            width: 100%;
            font-weight: bold;
            border: none;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success:hover {
            background-color: #198754;
        }

        input[type="email"], input[type="password"] {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid #ccc;
            color: #fff;
        }

        input::placeholder {
            color: #ccc;
        }

        @keyframes fadeIn {
            from {
                transform: translateY(40px);
                opacity: 0;
            }
            to {
                transform: translateY(0px);
                opacity: 1;
            }
        }


        body {
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #007bff, #00c6ff);
    margin: 0;
    padding: 0;
}

.container {
    max-width: 450px;
    width: 100%;
    background: white;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.container h3 {
    color: #007bff;
    font-size: 24px;
    font-weight: 600;
    text-align: center;
    margin-bottom: 10px;
}

.container p {
    color: #555;
    font-size: 14px;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 12px;
    font-size: 14px;
    transition: border 0.3s;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
}

.btn {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 8px;
    transition: background 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-success:hover {
    background-color: #218838;
}

.alert {
    font-size: 14px;
    border-radius: 8px;
}

    </style>
</head>
<body>

<div class="container">
    <?php if ($stage === "email"): ?>
        <h3><i class="fas fa-lock-open"></i> Forgot Password?</h3>
        <p class="text-center mb-3">Enter your registered email</p>
        <form method="POST">
            <input type="email" name="email" class="form-control my-2" placeholder="Enter your email" required>
            <button type="submit" class="btn btn-primary mt-3">Continue</button>
        </form>

    <?php elseif ($stage === "reset"): ?>
        <h3><i class="fas fa-key"></i> Reset Password</h3>
        <p class="text-center mb-3">For: <strong><?= htmlspecialchars($resetEmail) ?></strong></p>
        <form method="POST">
            <input type="hidden" name="reset_email" value="<?= htmlspecialchars($resetEmail) ?>">
            <input type="password" name="new_password" class="form-control my-2" placeholder="New Password" required>
            <input type="password" name="confirm_password" class="form-control my-2" placeholder="Confirm Password" required>
            <button type="submit" class="btn btn-success mt-3">Reset Password</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-3 text-center"><?= $error ?></div>
    <?php endif; ?>
</div>

</body>
</html>
