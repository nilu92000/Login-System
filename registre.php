
<!-- <?php
// require_once 'send_email.php';
// require_once 'config.php';
// session_start(); // Ensure session starts at the top of the file

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $employee_id = trim($_POST['employee_id']);
//     $name = trim($_POST['name']);
//     $email = trim($_POST['email']);
//     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//     $security_question = trim($_POST['security_question']);
//     $security_answer = password_hash(trim($_POST['security_answer']), PASSWORD_DEFAULT); // Hashing answer for security
//     $otp = mt_rand(100000, 999999); // Generate a random OTP

//     // Check if the email is already registered
//     $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
//     $stmt->execute([$email]);
//     if ($stmt->rowCount() > 0) {
//         $error = "Email is already registered. Please log in.";
//     } else {
//         // Insert user data
//         $insertStmt = $conn->prepare("INSERT INTO user (employee_id, name, email, password, security_question, security_answer, otp, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
//         if ($insertStmt->execute([$employee_id, $name, $email, $password, $security_question, $security_answer, $otp])) {
//             $_SESSION['email'] = $email; // Store email in session

//             // Send OTP email
//             if (sendOTPEmail($email, $otp)) {
//                 header("Location: otp_verify.php");
//                 exit();
//             } else {
//                 $error = "Error sending OTP email. Please try again.";
//             }
//         } else {
//             $error = "Error registering user. Please try again.";
//         }
//     }
// }
?> -->
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSIR Registration</title>
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
        }
        .logo img {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        input, select, button {
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
            text-align: center;
            margin-top: 10px;
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
    <div class="form-container"> -->
        <!-- CSIR Logo -->
        <!-- <div class="logo">
            <img src="CSIR-LOGO.png" alt="CSIR Logo">
        </div>
        <form method="POST" action="">
            <h2>CSIR Registration</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <input type="text" name="employee_id" placeholder="Enter your Employee ID" required>
            <input type="text" name="name" placeholder="Enter your Name" required>
            <input type="email" name="email" placeholder="Enter your Email" required>
            <input type="password" name="password" placeholder="Enter your Password" required>
            <select name="security_question" required>
                <option value="">Select a Security Question</option>
                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                <option value="What is your favorite book?">What is your favorite book?</option>
            </select>
            <input type="text" name="security_answer" placeholder="Answer to Security Question" required>
            <button type="submit">Register</button>
            <p>Already a user? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
 -->
 <?php
require_once 'send_email.php';
require_once 'config.php';
session_start(); // Ensure session starts at the top of the file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = trim($_POST['employee_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $security_question = trim($_POST['security_question']);
    $security_answer = password_hash(trim($_POST['security_answer']), PASSWORD_DEFAULT); // Hashing answer for security
    $otp = mt_rand(100000, 999999); // Generate a random OTP

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $error = "Email is already registered. Please log in.";
    } else {
        // Insert user data
        $insertStmt = $conn->prepare("INSERT INTO user (employee_id, name, email, password, security_question, security_answer, otp, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
        if ($insertStmt->execute([$employee_id, $name, $email, $password, $security_question, $security_answer, $otp])) {
            $_SESSION['email'] = $email; // Store email in session

            // Send OTP email
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
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .logo img {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        input, select, button {
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
            text-align: center;
            margin-top: 10px;
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
        <!-- CSIR Logo -->
        <div class="logo">
            <img src="CSIR-LOGO.png" alt="CSIR Logo">
        </div>
        <form method="POST" action="">
            <h2>CSIR Registration</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <input type="text" name="employee_id" placeholder="Enter your Employee ID" required>
            <input type="text" name="name" placeholder="Enter your Name" required>
            <input type="email" name="email" placeholder="Enter your Email" required>
            <input type="password" name="password" placeholder="Enter your Password" required>
            <select name="security_question" required>
                <option value="">Select a Security Question</option>
                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                <option value="What is your favorite book?">What is your favorite book?</option>
            </select>
            <input type="text" name="security_answer" placeholder="Answer to Security Question" required>
            <button type="submit">Register</button>
            <p>Already a user? <a href="log.php">Login</a></p>
        </form>
    </div>
</body>
</html>
