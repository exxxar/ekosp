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

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Load Composer's autoloader
require '../vendor/autoload.php';

$filename_1 = 'KP_AGRO_' . (Carbon::now()) . '.pdf';
$filename_2 = 'SUMMARY_TABLE_AGRO_' . (Carbon::now()) . '.pdf';

$mpdf = new Mpdf(['tempDir' => __DIR__ . '/']);

$_POST = json_decode(file_get_contents('php://input'), true);

$type = $_POST['type'] ?? 0;

$name = $_POST['name'] ?? 'Имя не указано';
$email = $_POST['email'] ?? 'exxxar@gmail.com';
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

$planned_yield = $_POST['planned_yield'] ?? 0;
$yield_cost = $_POST['yield_cost'] ?? 0;


$crop_area = $_POST['crop_area'] ?? 0;

$first_volume = $_POST['first_volume'] ?? 0;
$first_volume_price = $_POST['first_volume_price'] ?? 0;
$second_volume = $_POST['second_volume'] ?? 0;
$second_volume_price = $_POST['second_volume_price'] ?? 0;
$third_volume = $_POST['third_volume'] ?? 0;
$third_volume_price = $_POST['third_volume_price'] ?? 0;

$farm_investments_volume = $_POST['farm_investments_volume'] ?? 0;
$farm_investments_price = $_POST['farm_investments_price'] ?? 0;

$increase_in_yield_1 = $_POST['increase_in_yield_1'] ?? 0;
$increase_in_yield_2 = $_POST['increase_in_yield_2'] ?? 0;

$increase_in_money = $_POST['increase_in_money'] ?? 0;
$net_profit = $_POST['net_profit'] ?? 0;
$profitability = $_POST['profitability'] ?? 0;

$dom1 = new Dom;
$dom1->loadFromFile('../mail_template_head.html');
$html_head = $dom1->outerHtml;
$dom2 = new Dom;
$dom2->loadFromFile('../mail_template_footer.html');
$html_footer = $dom2->outerHtml;


$now = Carbon::now();

$volume = round($volume);

$numberToWords = new NumberToWords();

// build a new currency transformer using the RFC 3066 language identifier
$numberTransformer = $numberToWords->getNumberTransformer('ru');

$volume_to_text = $numberTransformer->toWords(round(intval($volume))) ?? '';

$full_price = round($full_price);
$base_price_with_discount = round($base_price_with_discount);
$discount_in_money = round($discount_in_money);

if ($type === 0) {
    $mpdf->WriteHTML($html_head);

    $month = [
        "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"
    ];
    $mpdf->WriteHTML("<p>" . $now->day . " " . $month[$now->month - 1] . " " . $now->year . "</p>");

    $mpdf->WriteHTML(
        "<h4 style='text-align: center; line-height: 100%'>КОММЕРЧЕСКОЕ ПРЕДЛОЖЕНИЕ<br>
ПО ПОКУПКЕ И ПОСТАВКЕ УДОБРЕНИЯ<br>
НА ОСНОВЕ ГУМУСОВЫХ ВЕЩЕСТВ «ЭКО-СП»</h4>");

    $mpdf->WriteHTML("<p style='text-align: right;'>$company</p>");
} else
    $mpdf->WriteHTML("<h4>ОБЪЕМ И СТОИМОСТЬ УДОБРЕНИЯ НА ОСНОВЕ ГУМУСОВЫХ ВЕЩЕСТВ «ЭКО-СП»</h4>");

$mpdf->WriteHTML("
<style>

    table {
        font-family: \"Lucida Sans Unicode\", \"Lucida Grande\", Sans-Serif;
        font-size: 14px;
        border-collapse: collapse;


    }
    th, td:first-child {
        padding: 10px 20px;
    }
    th, td {
      border-style: solid;
    border-width: 1px 1px 1px 1px;
    border-color: black;
    }


    th:first-child, td:first-child {
        text-align: left;
    }
</style>

<table style='width: 100%;  border-collapse: collapse;'>
    <tr>
        <td>Наименование Товара:</td>
        <td>Агрохимикат ЭКО-СП </td>
    </tr>

    <tr>
        <td >Количество:</td>
        <td >$volume ($volume_to_text) литров.</td>
    </tr>

    <tr>
        <td>Стоимость ЭКО-СП:</td>
        <td>$base_price руб./литр. (EXW, со склада производства (Московская обл.), торговый склад - г. Батайск  (Ростовская область)</td>
    </tr>

    <tr>
        <td>Площадь обработки, га</td>
        <td>$crop_area</td>
    </tr>

    <tr>
        <td>Скидка от базовой цены в зависимости от объема</td>
        <td>$volume_discount %</td>
    </tr>


    <tr>
        <td>Скидка за покупку в сезон скидок</td>
        <td>$season_discount %</td>
    </tr>

    <tr>
        <td>Скидка для членов АККОР</td>
        <td>$akkor_member_discount %</td>
    </tr>


    <tr>
        <td>Скидка от модели оплаты:</td>
        <td>$pay_method_discount %  ($pay_method)</td>
    </tr>

    <tr style='background-color: #00a8e6;'>
        <td></td>
        <td></td>
    </tr>

    <tr>
        <td><strong>Общая Скидка</strong></td>
        <td>$summary_discount %</td>
    </tr>

    <tr>
        <td><strong>Скидка в рублях</strong></td>
        <td>$discount_in_money руб./литр.</td>
    </tr>

    <tr>
        <td><strong>Итоговая цена со скидкой</strong></td>
        <td>$base_price_with_discount руб./литр, в том числе НДС.</td>
    </tr>

    <tr>
        <td><strong>Стоимость за партию</strong></td>
        <td>$full_price рублей, в том числе НДС.</td>
    </tr>

    <tr>
        <td><strong>Условия оплаты</strong></td>
        <td>$pay_method</td>
    </tr>

     <tr style='background-color: #00a8e6;'>
        <td></td>
        <td></td>
    </tr>


     <tr>
        <td>Поставка</td>
        <td>10-литровые канистры</td>
    </tr>


     <tr>
        <td colspan='2'>  Стоимость доставки оплачивается Покупателем дополнительно, возможна комплексная
  поставка за счет Производителя со склада в г. Нахабино, со склада г. Батайск.</td>

    </tr>

    <tr>
        <td>Срок поставки</td>
        <td>согласно договора</td>
    </tr>
</table>
");

$mpdf->WriteHTML("
<h3 style='width:100%;text-align: center;'>Прогнозируемая экономическая эффективность ЭКО-СП</h3>
<table>
<tr>
    <td><strong>Планируемая урожайность, ц/га</strong></td>
    <td colspan='2'>$planned_yield</td>
</tr>
<tr>
    <td><strong>Планируемая стоимость, руб./т.</strong></td>
    <td colspan='2'>$yield_cost</td>
</tr>
<tr>
    <td><strong>Предпосевная обработка семян:</strong></td>
    <td colspan='2'>
$base_price руб./литр. (EXW, со склада производства (Московская обл.), торговый склад - г. Батайск  (Ростовская область)</td>
</tr>
<tr>
    <td><strong>Первая обработка по вегетации:</strong></td>
    <td>$first_volume литр</td>
    <td>$first_volume_price руб.</td>
</tr>
<tr>
    <td><strong>Вторая обработка по вегетации:</strong></td>
    <td>$second_volume литр</td>
    <td>$second_volume_price руб.</td>
</tr>
<tr>
    <td><strong>Если надо 3-я обработка</strong></td>
    <td>$third_volume литр</td>
    <td>$third_volume_price руб.</td>
</tr>

<tr style='background-color: #00a8e6;'>
    <td></td>
    <td></td>
</tr>

<tr>
    <td><strong>Инвестиции хозяйства в покупку ЭКО-СП:</strong></td>
    <td>$farm_investments_volume</td>
    <td>$farm_investments_price</td>
</tr>
<tr>
    <td><strong>Прирост урожайности:</strong></td>
    <td>$increase_in_yield_1 %</td>
    <td>$increase_in_yield_2 ц\га</td>
</tr>

<tr>
    <td colspan='2'>
        <strong>Прибавка в деньгах*</strong>
        <em>
        Дополнительная выручка от продажи дополнительного объема урожая полученного от увеличения урожайности.
</em>

</td>
    <td>$increase_in_money руб.</td>

</tr>

<tr>
    <td colspan='2'>
    <strong>Чистая прибыль *:</strong>
    <em>    Расчетная «чистая прибыль» от использования ЭКО-СП: дополнительная выручка минус расходы на покупку и использование «ЭКО-СП» совместно с СЗР.</em>
</td>
    <td>
    $net_profit руб.
</td>

</tr>

<tr>
    <td colspan='2'>
    <strong>Рентабельность гектара *:</strong>
    <em>Прогнозируемая экономическая эффективность использования ЭКО-СП на 1 га</em>
</td>
    <td>$profitability руб.</td>
</tr>
<tr style='background-color: #00a8e6;'>
    <td></td>
    <td></td>
</tr>
</table>
");

if ($type === 0)
    $mpdf->WriteHTML($html_footer);


$mpdf->Output($type === 0 ? $filename_1 : $filename_2, Destination::FILE);

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
    //$mail->addAddress('exxxar@gmail.com', "Тестировщик");               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    $mail->addAttachment($type === 0 ? $filename_1 : $filename_2);         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);
    $sub = $type === 0 ? 'КОММЕРЧЕСКОЕ ПРЕДЛОЖЕНИЕ ПО ПОКУПКЕ И ПОСТАВКЕ УДОБРЕНИЯ НА ОСНОВЕ ГУМУСОВЫХ ВЕЩЕСТВ «ЭКО-СП»' :
        'СВОДНАЯ ТАБЛИЦА ';
    $mail->Subject = "=?UTF-8?b?" . base64_encode($sub) . "?=";
    $mail->Body = "Добрый день, $name!<br>Номер телефона:$phone<br>Почта:$email<br>Пригласивший: $invite<br>";
    $mail->AltBody = 'Данный тип не поддерживается';

    $mail->send();
    echo json_encode([
        "filename" => "/calc/m/".($type === 0 ? $filename_1 : $filename_2)
    ]);

} catch (Exception $e) {
    echo "Ошибочка: {$mail->ErrorInfo}";
}
