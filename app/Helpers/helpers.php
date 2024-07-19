<?php

/** SEND EMAIL FUNCTION USING PHPMAILER LIBRARY */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!function_exists('sendEmail')) {
    function sendEmail($mailConfig) {
        // Load PHPMailer classes
        info("PHPMailer");
        require ('PHPMailer-master/src/Exception.php');
        require ('PHPMailer-master/src/PHPMailer.php');
        require ('PHPMailer-master/src/SMTP.php');

        // Create a new PHPMailer instance
//        $mail = new PHPMailer(true);
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Port = env('MAIL_PORT');
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');

        try {
            // Enable verbose debug output
            $mail->SMTPDebug = 2;

            // Set from address and name
            $mail->setFrom($mailConfig['mail_from_email'], $mailConfig['mail_from_name']);

            // Add recipient address and name
            $mail->addAddress($mailConfig['mail_recipient_email'], $mailConfig['mail_recipient_name']);

            // Set email format to HTML
            $mail->isHTML();

            // Email subject
            $mail->Subject = $mailConfig['mail_subject'];

            // Email body content
            $mail->Body = $mailConfig['mail_body'];

            // Send email and check for success
            if ($mail->send()) {
                //info('Mail sent successfully to ' . $mailConfig['mail_recipient_email']);
                return true;
            } else {
                // Log error message
               // error_log('Mailer Error: ' . $mail->ErrorInfo);
                return false;
            }
        } catch (\Exception $e) {
            // Log exception message
            error_log('Exception caught: ' . $e->getMessage());
            return false;
        }
    }
}
