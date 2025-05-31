<?php

// Include necessary PHPMailer classes and use statements here. 
// require './PHPMailer/src/PHPMailer.php';
// require './PHPMailer/src/SMTP.php';
// require './PHPMailer/src/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function send_email($recipientEmail, $subject, $body) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to DEBUG_SERVER for detailed debugging
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'montesarose@gmail.com'; // Your email address
        $mail->Password   = 'zodr kpmg zqth nupf'; // Your email password or app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        // $mail->SMTPSecure = 'ssl'; // Enable TLS encryption
        $mail->Port       = 587; // TCP port to connect to
    
        // Sender
        $mail->setFrom('montesarose@gmail.com', 'Laguna Parole and Probation Office Administrator');
        // $mail->setFrom($senderEmail, 'Administrator');

        // Recipient
        //$mail->addAddress('recipient@example.com', 'Recipient Name');
        // $mail->addAddress($recipientEmail);

        // Recipients
        if (is_array($recipientEmail)) {
            foreach ($recipientEmail as $recipient) {
                $mail->addAddress($recipient);
            }
        } else {
            $mail->addAddress($recipientEmail);
        }
    
        // Email subject and content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
    
        $mail->send();
        return true;
        // echo 'Email sent successfully.';
    } catch (Exception $e) {
        return false;
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}


