<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Проверка путей
$phpmailer_path = __DIR__ . '/PHPMailer/';

if (!file_exists($phpmailer_path . 'src/Exception.php')) {
	$response = ['message' => 'Ошибка: не найден Exception.php в ' . $phpmailer_path . 'src/'];
	header('Content-type: application/json');
	echo json_encode($response);
	exit;
}

if (!file_exists($phpmailer_path . 'src/PHPMailer.php')) {
	$response = ['message' => 'Ошибка: не найден PHPMailer.php в ' . $phpmailer_path . 'src/'];
	header('Content-type: application/json');
	echo json_encode($response);
	exit;
}

if (!file_exists($phpmailer_path . 'src/SMTP.php')) {
	$response = ['message' => 'Ошибка: не найден SMTP.php в ' . $phpmailer_path . 'src/'];
	header('Content-type: application/json');
	echo json_encode($response);
	exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $phpmailer_path . 'src/Exception.php';
require $phpmailer_path . 'src/PHPMailer.php';
require $phpmailer_path . 'src/SMTP.php';

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
$mail->Debugoutput = 'html';

$buttonSubject = isset($_POST['button_subject']) ? trim($_POST['button_subject']) : '';

if (!empty($buttonSubject)) {
	$mail->Subject = $buttonSubject;
} else {
	$mail->Subject = 'Новая заявка с сайта';
}

$body = '';

if (isset($_POST['form']) && is_array($_POST['form'])) {
	if (!empty($buttonSubject)) {
		$body .= $buttonSubject . "\n\n";
	}

	if (isset($_POST['form'][0]) && !empty($_POST['form'][0])) {
		$body .= 'Name: ' . $_POST['form'][0] . "\n";
	}
	if (isset($_POST['form'][1]) && !empty($_POST['form'][1])) {
		$body .= 'Email: ' . $_POST['form'][1] . "\n";
	}
	if (isset($_POST['form'][2]) && !empty($_POST['form'][2])) {
		$body .= 'Phone: ' . $_POST['form'][2] . "\n";
	}
	if (isset($_POST['form'][3]) && !empty($_POST['form'][3])) {
		$body .= 'Subject: ' . $_POST['form'][3] . "\n";
	}
}

$mail->Body = $body;

try {
	if (!$mail->send()) {
		$message = 'Ошибка: ' . $mail->ErrorInfo;
	} else {
		$message = 'Данные отправлены!';
	}
} catch (Exception $e) {
	$message = 'Ошибка: ' . $e->getMessage();
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
