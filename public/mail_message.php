<?php

namespace ekosp\calc;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use Carbon\Carbon;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use PHPHtmlParser\Dom;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';


$_POST = json_decode(file_get_contents('php://input'), true);

$name = $_POST['name'] ?? 'Имя не указано';
$email = $_POST['email'] ?? 'Почта не указана';
$phone = $_POST['phone'] ?? 'Не указан';
$region = $_POST['region'] ?? 'Не указан';
$text = $_POST['text'] ?? 'Не указан';


$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = 'exxxar@gmail.com';                     // SMTP username
    $mail->Password = 'abfaymigqrkwwgow';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress($email, $name);     // Add a recipient
    $mail->addAddress('info@eko-sp.ru');               // Name is optional
    $mail->addAddress('exxxa@egmail.com',"Тестировщик");
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    $mail->isHTML(true);
    $sub ='Заявка на перезвон';
    $mail->Subject  = "=?UTF-8?b?". base64_encode($sub ). "?=";
    $mail->Body = "Добрый день, $name!<br>Номер телефона:$phone<br>Почта:$email<br>Регион:$region<br><br>$text";
    $mail->AltBody = 'Данный тип не поддерживается';

    $mail->send();
    echo 'Почта отправлена';

} catch (Exception $e) {
    echo "Ошибочка: {$mail->ErrorInfo}";
}
