<?
//Отправка по протоколу SMTP
$mail->isSMTP();

//Включение шифрования
$mail->SMTPSecure = 'ssl';

//Сервер для отправки
$mail->Host       = 'smtp.yandex.ru';

//SMTP сервер требует аутентификации
$mail->SMTPAuth   = true;

//Порт
$mail->Port       = 465;

//SMTP логин
$mail->Username   = 'sender@amohost.ru';

//SMTP пароль
$mail->Password   = 'sen-der';

//Адрес отправителя
$mail->SetFrom('sender@amohost.ru', 'dededigitalmedia'); 

//Адрес получателя
$mail->AddAddress('work@dede.digital', "");

//Тема письма
$mail->Subject = 'Message from site DEDE';
?>