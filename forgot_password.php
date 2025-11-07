<?php
session_start();
require 'config.php';
require 'email_otp.php'; // Ensure the sendOTPEmail function is included.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        // Step 1: User submits email for OTP
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

        // Check if email exists in the database
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate OTP and expiry time (15 minutes from now)
            $otp = rand(100000, 999999);
            $expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));

            // Update OTP and expiry in the database
            $updateStmt = $conn->prepare("UPDATE user SET otp = ?, token_expiry = ? WHERE email = ?");
            $updateStmt->execute([$otp, $expiry, $email]);

            // Send OTP email using the sendOTPEmail function
            if (sendOTPEmail($email, $otp)) {
                $_SESSION['reset_email'] = $email;
                $_SESSION['otp_sent_time'] = time(); // Log OTP send time for later validation
                $successMessage = "OTP has been sent to your email.";
            } else {
                $errorMessage = "Failed to send OTP. Please try again.";
            }
        } else {
            $errorMessage = "Email not found. Please register first.";
        }
    } elseif (isset($_POST['otp'])) {
        // Step 2: User submits OTP
        if (!isset($_SESSION['reset_email'])) {
            $errorMessage = "Session expired. Please restart the process.";
        } else {
            $email = $_SESSION['reset_email'];
            $otp = htmlspecialchars($_POST['otp'], ENT_QUOTES, 'UTF-8');

            // Validate OTP and expiry
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND otp = ?");
            $stmt->execute([$email, $otp]);
            $user = $stmt->fetch();

            if ($user && new DateTime() <= new DateTime($user['token_expiry'])) {
                // OTP is valid; clear it and redirect to reset password page
                $updateStmt = $conn->prepare("UPDATE user SET otp = NULL, token_expiry = NULL WHERE email = ?");
                $updateStmt->execute([$email]);
                header("Location: reset_password.php");
                exit();
            } else {
                $errorMessage = "Invalid or expired OTP. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('forgot.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.95); /* Slightly transparent white */
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
        .error {
            color: #ff0000;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Forgot Password</h2>
        <p>If you've forgotten your password, enter your email to receive an OTP.</p>
        
        <!-- Display success or error messages -->
        <?php 
        if (isset($successMessage)) {
            echo "<p class='success'>$successMessage</p>";
        } elseif (isset($errorMessage)) {
            echo "<p class='error'>$errorMessage</p>";
        }
        ?>

        <form method="POST" action="">
            <?php if (!isset($_SESSION['reset_email'])): ?>
                <!-- Step 1: Collect Email -->
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Send OTP</button>
            <?php else: ?>
                <!-- Step 2: Verify OTP -->
                <input type="text" name="otp" placeholder="Enter OTP" required>
                <button type="submit">Verify OTP</button>
            <?php endif; ?>
        </form>

        <!-- Add Reset Password Button -->
        <?php if (isset($_SESSION['reset_email'])): ?>
            <form action="reset_password.php" method="GET" style="margin-top: 20px;">
                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
