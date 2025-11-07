<?php
session_start();
require 'config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT id, password, is_verified FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['is_verified'] == 1) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $email;
            header("Location: welcome.php"); // Redirect to welcome page
            exit();
        } else {
            $error = "Your email is not verified. Please check your inbox.";
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
    <!-- Your existing CSS styles -->
</head>
<body>
    <div class="container">
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
    </div>
</body>
</html>
