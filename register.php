<?php
require_once 'send_email.php';
require_once 'config.php';
session_start(); // Ensure session starts at the top of the file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = trim($_POST['employee_id']);
    $user_id = trim($_POST['user_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $security_question = trim($_POST['security_question']);
    $security_answer = password_hash(trim($_POST['security_answer']), PASSWORD_DEFAULT);
    $otp = mt_rand(100000, 999999);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $error = "Email is already registered. Please log in.";
    } else {
        // Insert user data
        $insertStmt = $conn->prepare("INSERT INTO user (employee_id, user_id, name, email, phone_number, address, password, security_question, security_answer, otp, is_verified, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 'active')");
        if ($insertStmt->execute([$employee_id, $user_id, $name, $email, $phone_number, $address, $password, $security_question, $security_answer, $otp])) {
            $_SESSION['email'] = $email;

            // Send OTP Email
            if (sendOTPEmail($email, $otp)) {
                header("Location: otp_verify.php");
                exit();
            } else {
                $error = "Error sending OTP email. Please try again.";
            }
        } else {
            $error = "Error registering user. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSIR Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('rback.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 420px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        .logo img {
            display: block;
            margin: 0 auto 20px;
            width: 90px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        p {
            text-align: center;
            font-size: 14px;
        }
        p a {
            color: #007BFF;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="form-container">
    <div class="logo">
        <img src="rlogo.jpg" alt="Logo">
    </div>
    <form method="POST" action="">
        <h2>Registration</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- <input type="text" name="employee_id" placeholder="Enter Employee ID" required> -->
        <input type="text" name="user_id" placeholder="Enter User ID" required>
        <input type="text" name="name" placeholder="Enter Full Name" required>
        <input type="email" name="email" placeholder="Enter Email Address" required>
        <input type="text" name="phone_number" placeholder="Enter Phone Number" required pattern="[0-9]{10}" title="Enter 10-digit number">
        <input type="text" name="address" placeholder="Enter Address" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        
        <!-- <select name="security_question" required>
            <option value="">Select Security Question</option>
            <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
            <option value="What was the name of your first pet?">What was the name of your first pet?</option>
            <option value="What is your favorite book?">What is your favorite book?</option> -->
        <!-- </select>
        
        <input type="text" name="security_answer" placeholder="Answer to Security Question" required> -->
        <button type="submit">Register</button>
        <p>Already have an account? <a href="log.php">Login</a></p>
    </form>
</div>
</body>
</html>
