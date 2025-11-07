<?php
require_once 'vendor/autoload.php'; // Ensure the correct path to autoload.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Avoid redeclaring the function
if (!function_exists('sendOTPEmail')) {
    function sendOTPEmail($email, $otp) {
        $mail = new PHPMailer(true);

        try {
            // SMTP server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'niluverma378@gmail.com'; // Your email address
            $mail->Password = 'atxl ilrk vwyh whqe';     // Your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption
            $mail->Port = 587;

            // Email sender and recipient details
            $mail->setFrom('niluverma378@gmail.com', 'Your Project Name'); // Sender details
            $mail->addAddress($email); // Recipient email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "
                <p>Dear User,</p>
                <p>Your One Time Password (OTP) is: <b>$otp</b></p>
                <p>This OTP is valid for 10 minutes. Please use it to complete your verification process.</p>
                <p>If you did not request this, please ignore this email.</p>
                <p>Regards,<br>Your Project Team</p>
            ";

            $mail->AltBody = "Your OTP is: $otp. This OTP is valid for 10 minutes.";

            // Send the email
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Log error for debugging (optional)
            error_log("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
?>
