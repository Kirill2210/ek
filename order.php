<?php
// настройки
// посылать ли ГЕО? 1 - да, 0- нет
$geo=1;
// полылать ли IP юзера? 1- да, 0 - нет.
$ip_i=1;
// 1 - посылать только на почту, 2- только в телегу, 3 - и туда и туда.
$rej=1;

// для телеграммы.
$token = "ccccc:dddd-ffff"; // вписать свой токен!
$chat_id = "-xxxxxx"; // свой чат ид!



$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR'];
$result  = array();
$txt=''; 
if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
else $ip = $remote;
if ($geo) {
$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
if($ip_data && $ip_data->geoplugin_countryName != null)
{
	$geo='';
    $result['Код страны: '] = $ip_data->geoplugin_countryCode;
    $result['Город: '] = $ip_data->geoplugin_city;
    $result['Регион: '] = $ip_data->geoplugin_region;
    $result['Широта: '] = $ip_data->geoplugin_latitude;
	$result['Долгота: '] = $ip_data->geoplugin_longitude;
	$result['Страна: '] = $ip_data->geoplugin_countryName;
 }
foreach ($result as $a=>$b){
	$geo.=$a.$b.'<br>'."\n";
	}
} else $geo='';

			@$server = $_SERVER['HTTP_HOST'];
			@$theme = $_POST['tov_id'];
			@$name = $_POST['name'];
			
			if (isset($_POST['phone'])) {$phone = $_POST['phone'];}
			if (empty($phone))
			{
				echo "I can not send!";
				exit;
			}
			
			$success_url = './upsell/send.html?name='.$_POST['name'].'&phone='.$_POST['phone'].'';
			
			$mail_header = "MIME-Version: 1.0\r\n";
			$mail_header.= "Content-type: text/html; charset=UTF-8\r\n";
			$mail_header.= "From: Info <informer@$server>\r\n";
			$mail_header.= "Reply-to: Reply to Name <reply@$server>\r\n";
			
			$to = "kirill.konovalov.s3@gmail.com";
			$subject = "Заказ Pulse 3 с сайта: $server";
			
			$message = "<strong>Имя:</strong> $name<br><strong>Телефон:</strong> $phone <br>$theme".'<br>'."\n";
			if ($ip_i){
			$message.= 'IP: '.$ip.'<br>'."\n";
				}
			
			$message.='<br>'."\n".$geo;
			
			if (($rej==1) || ($rej==3)){
			mail($to,$subject,$message,$mail_header);

			}
			
			header('Location: '.$success_url);
			//else echo 'failed';
			
			if ($rej==3)
			{
				$txt=str_ireplace('<br>',"%0A",$message);
				$txt=strip_tags($txt);

$sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
if ($sendToTelegram) {
}
	}
