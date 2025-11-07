<?php
require 'config.php';
session_start();

// Ensure the session email is set
if (!isset($_SESSION['reset_email'])) {
    echo "Session expired. Please restart the password reset process.";
    exit();
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['reset_email'];
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the new password securely

    // Update the user's password in the database
    $stmt = $conn->prepare("UPDATE user SET password = ?, otp = NULL, token_expiry = NULL WHERE email = ?");
    if ($stmt->execute([$newPassword, $email])) {
        // Clear the session after successful password reset
        unset($_SESSION['reset_email']);
        $successMessage = "Password reset successful! You can now <a href='log.php'>log in</a>.";
    } else {
        $errorMessage = "An error occurred while resetting your password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #007BFF, #FFA500);
            color: #333;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        p {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Reset Password</h2>
        <p>Please enter your new password below:</p>
        
        <!-- Display success or error messages -->
        <?php 
        if (isset($successMessage)) {
            echo "<p class='message success'>$successMessage</p>";
        } elseif (isset($errorMessage)) {
            echo "<p class='message error'>$errorMessage</p>";
        }
        ?>

        <form method="POST" action="">
            <input type="password" name="password" placeholder="New Password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
