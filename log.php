<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            if ($user['is_verified'] == 1) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: pic.php");
                exit();
            } else {
                $error = "Email not verified. Please verify your email.";
            }
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found. Please register first.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NML</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .logo img {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            font-size: 14px;
        }
        p a {
            color: #007BFF;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="logo">
            <img src="logini.png" alt="NML Logo">
        </div>
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your Email" required>
            <input type="password" name="password" placeholder="Enter your Password" required>
            <button type="submit">Login</button>
            <p><a href="forgot_password.php">Forgot Password?</a></p>
            <p>Don't have an account? <a href="registre.php">Register</a></p>
        </form>
    </div>
</body>
</html>
