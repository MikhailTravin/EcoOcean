<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->IsHTML(false);

$mail->setFrom('elogica@inbox.ru', 'EcoOcean');
$mail->addAddress('elogica@inbox.ru');

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'elogica@inbox.ru';
$mail->Password = 'pogv nnfc uvru xrll';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->Subject = 'New subscription on the site';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';

$body = "New subscription!\n\n";
$body .= "Email: " . $email . "\n";
$body .= "Date: " . date('d.m.Y H:i:s') . "\n";

$mail->Body = $body;

if (!$mail->send()) {
    $message = 'Error';
} else {
    $message = 'Subscribed successfully!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
