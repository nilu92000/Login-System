<?php
require_once 'send_email.php'; // Script for sending emails
require_once 'config.php';     // Database configuration
session_start();               // Start session for storing OTP and email

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = trim($_POST['employee_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $security_question = trim($_POST['security_question']);
    $security_answer = password_hash(trim($_POST['security_answer']), PASSWORD_DEFAULT);
    $otp = mt_rand(100000, 999999); // Generate a random 6-digit OTP

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $error = "Email is already registered. Please log in.";
    } else {
        try {
            // Insert user data into the database
            $insertStmt = $conn->prepare("
                INSERT INTO user (employee_id, name, email, password, security_question, security_answer, otp, is_verified) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 0)
            ");
            $isInserted = $insertStmt->execute([$employee_id, $name, $email, $password, $security_question, $security_answer, $otp]);

            if ($isInserted) {
                $_SESSION['email'] = $email; // Store email in session
                $_SESSION['otp'] = $otp;     // Store OTP in session for later verification

                // Send OTP email
                if (sendOTPEmail($email, $otp)) {
                    header("Location: otp_verify.php"); // Redirect to OTP verification page
                    exit();
                } else {
                    $error = "Error sending OTP email. Please try again.";
                }
            } else {
                $error = "Error registering user. Please try again.";
            }
        } catch (Exception $e) {
            $error = "Database error: " . $e->getMessage();
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
    <style>
        /* CSS for styling the registration form */
        body {
            font-family: 'Roboto', sans-serif;
            background: url('nml1.jpg') no-repeat center center fixed;
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
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
        <form method="POST" action="">
            <h2>CSIR Registration</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <input type="text" name="employee_id" placeholder="Enter Employee ID" required>
            <input type="text" name="name" placeholder="Enter Name" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <select name="security_question" required>
                <option value="">Select a Security Question</option>
                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                <option value="What is your favorite book?">What is your favorite book?</option>
            </select>
            <input type="text" name="security_answer" placeholder="Answer to Security Question" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
