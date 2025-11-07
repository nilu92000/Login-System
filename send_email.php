<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure Composer is installed or include PHPMailer files manually

function sendOTPEmail($toEmail, $otp) {
    $mail = new PHPMailer(true);
    try {
        // Email server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail's SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'niluverma378@gmail.com'; // Your Gmail address
        $mail->Password = 'atxl ilrk vwyh whqe'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('niluverma378@gmail.com', 'Your Project Name'); // Sender's email and name
        $mail->addAddress($toEmail); // Recipient's email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is <b>$otp</b>. It will expire in 10 minutes.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
