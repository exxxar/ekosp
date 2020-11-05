<?php

namespace ekosp\calc;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use Carbon\Carbon;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use NumberToWords\NumberToWords;
use PHPHtmlParser\Dom;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

$filename = 'KP_AGRO'.(Carbon::now()).'.pdf';

$mpdf = new Mpdf(['tempDir' => __DIR__ . '/']);

$_POST = json_decode(file_get_contents('php://input'), true);

$name = $_POST['name'] ?? 'Имя не указано';
$email = $_POST['email'] ?? 'Почта не указана';
$base_price = $_POST['base_price'] ?? '200';
$invite = $_POST['invite'] ?? 'Не указан';
$phone = $_POST['phone'] ?? 'Не указан';
$company = $_POST['company'] ?? 'Сельскохозяйственному предприятию России';
$volume = $_POST['volume'] ?? 0;
$volume_discount = $_POST['volume_discount'] ?? 0;
$season_discount = $_POST['season_discount'] ?? 0;
$akkor_member_discount = $_POST['akkor_member_discount'] ?? 0;
$pay_method_discount = $_POST['pay_method_discount'] ?? 0;
$summary_discount = $_POST['summary_discount'] ?? 0;
$discount_in_money = $_POST['discount_in_money'] ?? 0;
$base_price_with_discount = $_POST['base_price_with_discount'] ?? 0;
$full_price = $_POST['full_price'] ?? 0;
$pay_method = $_POST['pay_method'] ?? '100% предоплата';

$dom1 = new Dom;
$dom1->loadFromFile('mail_template_head.html');
$html_head = $dom1->outerHtml;
$dom2 = new Dom;
$dom2->loadFromFile('mail_template_footer.html');
$html_footer = $dom2->outerHtml;

$mpdf->WriteHTML($html_head);

$now = Carbon::now();

$volume = round($volume);

$numberToWords = new NumberToWords();

// build a new currency transformer using the RFC 3066 language identifier
$numberTransformer = $numberToWords->getNumberTransformer('ru');

$volume_to_text = $numberTransformer->toWords(round(intval($volume))) ?? '';

$full_price = round($full_price);
$base_price_with_discount = round($base_price_with_discount);
$discount_in_money = round($discount_in_money);


$month = [
    "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"
];
$mpdf->WriteHTML("<p>". $now->day." ".$month[$now->month-1]." ".$now->year."</p>");

$mpdf->WriteHTML(
    "<h4 style='text-align: center; line-height: 100%'>КОММЕРЧЕСКОЕ ПРЕДЛОЖЕНИЕ<br>
ПО ПОКУПКЕ И ПОСТАВКЕ УДОБРЕНИЯ<br>
НА ОСНОВЕ ГУМУСОВЫХ ВЕЩЕСТВ «ЭКО-СП»</h4>");

$mpdf->WriteHTML("<p style='text-align: right;'>$company</p>");


$mpdf->WriteHTML("<p style='text-align: left; line-height: 125%; padding: 10px 10px 0px 10px;'>

Наименование Товара: Агрохимикат ЭКО-СП.  Гос. регистрация № 520-18-2066-1<br>
Количество – $volume ($volume_to_text) литров.<br>
Стоимость ЭКО-СП: $base_price руб./литр. (EXW, со склада производства (Московская обл.), торговый склад - г. Ростов-на-Дону (Ростовская область).<br>
Скидка от базовой цены в зависимости от объема – $volume_discount %)<br>
Скидка за покупку в сезон скидок– $season_discount %<br>
Скидка для членов АККОР - $akkor_member_discount %, <br>
Скидка от модели оплаты: $pay_method_discount %  ($pay_method)<br>
Общая Скидка – $summary_discount %<br>
Скидка в рублях – $discount_in_money руб./литр.<br>
Итоговая цена со скидкой – $base_price_with_discount руб./литр, в том числе НДС.<br>
Стоимость за партию – $full_price рублей, в том числе НДС.<br>
Условия оплаты – $pay_method<br>
Поставка осуществляется в 10-литровых канистрах.<br>
Стоимость доставки оплачивается Покупателем дополнительно, возможна комплексная поставка за счет Производителя со склада в г. Нахабино, со склада г. Ростов-на-Дону.<br>
Срок поставки – согласно договору.<br>
</p>");


$mpdf->WriteHTML($html_footer);

$mpdf->Output($filename, Destination::FILE);

// Instantiation and passing `true` enables exceptions
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
    $mail->setFrom('info@eko-sp.ru', 'EKO-SP');
    $mail->addAddress($email, $name);     // Add a recipient
    $mail->addAddress('info@eko-sp.ru');               // Name is optional
    $mail->addAddress('exxxa@egmail.com', "Тестировщик");               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    $mail->addAttachment($filename);         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);
    $sub ='КОММЕРЧЕСКОЕ ПРЕДЛОЖЕНИЕ ПО ПОКУПКЕ И ПОСТАВКЕ УДОБРЕНИЯ НА ОСНОВЕ ГУМУСОВЫХ ВЕЩЕСТВ «ЭКО-СП»';
    $mail->Subject  = "=?UTF-8?b?". base64_encode($sub ). "?=";
    $mail->Body = "Добрый день, $name!<br>Номер телефона:$phone<br>Почта:$email<br>Пригласивший: $invite<br>";
    $mail->AltBody = 'Данный тип не поддерживается';

    $mail->send();
    echo json_encode([
        "filename"=>$filename
    ]);

    //unlink($filename);
} catch (Exception $e) {
    echo "Ошибочка: {$mail->ErrorInfo}";
}
