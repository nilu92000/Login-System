<?php
require_once 'config.php';

session_start();

$isVerified = false; // Flag to check if OTP was verified

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = $_POST['otp'];
    $email = $_SESSION['reset_email'];

    // Validate OTP
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND otp = ?");
    $stmt->execute([$email, $otp]);
    $user = $stmt->fetch();

    if ($user && new DateTime() <= new DateTime($user['token_expiry'])) {
        // OTP is valid; clear OTP and set verified flag
        $updateStmt = $conn->prepare("UPDATE user SET otp = NULL WHERE email = ?");
        $updateStmt->execute([$email]);
        $isVerified = true;
    } else {
        $error = "Invalid or expired OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('images.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Form Container */
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            text-align: center;
        }

        /* Form Header */
        h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        /* Input Field */
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #dddddd;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Button */
        button {
            background-color: #007BFF;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Error Message */
        .error {
            color: #FF0000;
            font-size: 14px;
            margin: 10px 0;
        }

        /* Success Animation Container */
        .success-container {
            text-align: center;
        }

        /* Animated Image */
        .success-animation img {
            width: 100px;
            height: 100px;
            animation: bounce 1s infinite;
        }

        /* Bounce Animation */
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .success-message {
            margin-top: 15px;
            font-size: 18px;
            color: green;
        }
    </style>
</head>
<body>
    <?php if ($isVerified): ?>
        <!-- Success Animation -->
        <div class="success-container">
            <div class="success-animation">
                <img src="verification.jpg" alt="Verification Success">
            </div>
            <p class="success-message">OTP Verified Successfully! Redirecting...</p>
        </div>
        <script>
            setTimeout(() => {
                window.location.href = "reset_password.php"; // Redirect to reset password page
            }, 3000); // 3-second delay
        </script>
    <?php else: ?>
        <!-- OTP Verification Form -->
        <div class="form-container">
            <form method="POST" action="">
                <h2>Verify OTP</h2>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
                <input type="text" name="otp" placeholder="Enter OTP" required>
                <button type="submit">Verify</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
