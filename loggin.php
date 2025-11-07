<!-- <?php
require 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT password, is_verified, otp_sent, otp FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['is_verified']) {
            // Account is verified, log in the user
            $_SESSION['user_email'] = $email;
            header("Location: index.php");
            exit();
        } else {
            // If not verified, start OTP verification process
            $_SESSION['email'] = $email;
            $otp = rand(100000, 999999); // Generate OTP
            $_SESSION['otp'] = $otp;

            // You should send OTP to user's email here (using mail() or a third-party service)
            // For simplicity, we're just assuming OTP is sent and valid

            // Show OTP verification page
            header("Location: otp_verify.php");
            exit();
        }
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSIR Login</title>
    <style>
        /* Your existing CSS styles */
    </style>
</head>
<body>
    <div class="container">
        <!-- CSIR Logo -->
        <div class="logo">
            <img src="csir-logo.png" alt="CSIR Logo">
        </div>
        <h2>CSIR Login</h2>
        <?php if (isset($error)) { echo '<div class="error">' . $error . '</div>'; } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="forgot-link">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </div>
</body>
</html> -->
<?php
require 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT password, is_verified, otp FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['is_verified']) {
            // Account is verified, log in the user
            $_SESSION['user_email'] = $email;
            header("Location: welcome.php"); // Redirect to welcome.php
            exit();
        } else {
            // If not verified, start OTP verification process
            $_SESSION['email'] = $email;
            $otp = rand(100000, 999999); // Generate OTP
            $_SESSION['otp'] = $otp;

            // You should send OTP to user's email here (using mail() or a third-party service)
            // For simplicity, we're just assuming OTP is sent and valid

            // Show OTP verification page
           // header("Location: otp_verify.php");
            exit();
        }
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSIR Login</title>
    <style>
        /* Your existing CSS styles */
    </style>
</head>
<body>
    <div class="container">
        <!-- CSIR Logo -->
        <div class="logo">
            <img src="csir-logo.png" alt="CSIR Logo">
        </div>
        <h2>CSIR Login</h2>
        <?php if (isset($error)) { echo '<div class="error">' . $error . '</div>'; } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="forgot-link">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </div>
</body>
</html>

