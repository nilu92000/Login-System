<?php
session_start();

// Handle OTP Verification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp'] ?? '';

    // Check if session contains OTP and email
    if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
        $error = "Session expired. Please register again.";
    } elseif ($enteredOtp == $_SESSION['otp']) {
        // OTP is valid, log the user in
        unset($_SESSION['otp']); // Clear OTP after successful verification
        $_SESSION['user_email'] = $_SESSION['email']; // Store email in session
        unset($_SESSION['email']); // Clear the email session variable
        header("Location: index.php"); // Redirect to the home page
        exit();
    } else {
        $error = "Invalid OTP. Please try again.";
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
        /* Your existing CSS styles */
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Verify OTP</h2>
        <form method="POST">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify</button>
        </form>
        <?php if (isset($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

