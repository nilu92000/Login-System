

<?php
require_once 'config.php';

// Ensure session is started only if it isn't already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = trim($_POST['otp']);
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : null;

    if ($email) {
        // Fetch the user's OTP from the database
        $stmt = $conn->prepare("SELECT otp FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $entered_otp === $result['otp']) {
            // Update the user's verification status
            $updateStmt = $conn->prepare("UPDATE user SET is_verified = 1 WHERE email = ?");
            if ($updateStmt->execute([$email])) {
                // Clear the session and redirect to the login page
                session_unset(); // Clear session data
                session_destroy(); // Destroy the session
                header("Location: log.php");
                exit();
            } else {
                $error = "Failed to update verification status. Please try again.";
            }
        } else {
            $error = "Invalid OTP. Please try again.";
        }
    } else {
        $error = "No email found in session. Please restart the process.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            color: #333333;
        }
        .form-container input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>OTP Verification</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="otp" placeholder="Enter your OTP" required>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>
<!-- <?php
require_once 'config.php';

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = trim($_POST['otp']);
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : null;

    if ($email) {
        try {
            // Fetch the user's OTP from the database
            $stmt = $conn->prepare("SELECT otp FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && $entered_otp === $result['otp']) {
                // Update the user's verification status
                $updateStmt = $conn->prepare("UPDATE user SET is_verified = 1 WHERE email = ?");
                if ($updateStmt->execute([$email])) {
                    // Clear the session and redirect to login page
                    session_unset();
                    session_destroy();

                    // Avoid extra output before redirection
                    ob_start();
                    header("Location: log.php");
                    ob_end_flush();
                    exit();
                } else {
                    $error = "Failed to update verification status. Please try again.";
                }
            } else {
                $error = "Invalid OTP. Please try again.";
            }
        } catch (Exception $e) {
            $error = "An unexpected error occurred: " . $e->getMessage();
        }
    } else {
        $error = "No email found in session. Please restart the process.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        h2 {
            color: #333;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        input, button {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>OTP Verification</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html> -->
