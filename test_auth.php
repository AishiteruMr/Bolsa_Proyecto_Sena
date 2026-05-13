<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = 'bolsadeproyectossena@gmail.com';
$mail->Password = 'wfpgjunpqmacpqwv';
$mail->setFrom('bolsadeproyectossena@gmail.com', 'Test');
$mail->addAddress('bolsadeproyectossena@gmail.com', 'Test');
$mail->Subject = 'Test SMTP';
$mail->Body = 'Si ves esto, SMTP funciona';

try {
    $mail->send();
    echo "\nCORREO ENVIADO OK\n";
} catch (Exception $e) {
    echo "\nFALLO: " . $mail->ErrorInfo . "\n";
}
