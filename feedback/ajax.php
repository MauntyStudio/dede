<? 
header('Content-type: text/html; charset=utf-8');
$result = array('result'=>false, 'error'=>'', 'post'=>$_POST, 'file'=>'', 'delete_result'=>false);
$error_fields = array();	
$requerd = array('email');


if(isset($_POST['af_data']) and is_array($_POST['af_data']) and count($_POST['af_data']) > 0 ){
	$fields = array();
	
	foreach($_POST['af_data'] as $send_name=>$send_values){
		$send_values = trim($send_values);
		$send_values = htmlspecialchars($send_values);
		$send_values = strip_tags($send_values);
		
		if(isset($_POST['af_titles'][$send_name])){
			$field_title = trim($_POST['af_titles'][$send_name]);
			$field_title = htmlspecialchars($field_title);
			$field_title = strip_tags($field_title);
		}else{
			$field_title = 	$send_name;	
		}

		if(in_array($send_name, $requerd)){
			if($send_values	!== ""){
				if($send_name == 'email'){
					if(!preg_match("|^[-0-9A-Za-z_\.]+@[-0-9A-Za-z^\.]+\.[a-z]{2,20}$|i",$send_values)){
						$error_fields[$send_name] = 'Email is not correct!';
					}
				}
				$fields[$field_title] = $send_values;
			}else{
				$error_fields[$send_name] = 'This field is required!';	
			}
		}else{
			if($send_values	!== ""){
				$fields[$field_title] = $send_values;
			}else{
				$fields[$field_title] = 'Empty...';	
			}
		}
		
		if($send_name == 'phone' and !empty($send_values)){
				$count = preg_match_all('/\d{1}/', $send_values, $dig_array);
				if($count > 11 or $count < 10){
					$error_fields[$send_name] = 'Phone is not correct.';
				}else{
					$phone_arr = $dig_array[0];
					if(count($phone_arr) == 10){
						$str_phone = '+7'.(implode($phone_arr));
					}elseif(count($phone_arr) == 11){
						$str_phone = '+'.(implode($phone_arr));
					}
				}
				$send_values = $str_phone;
			}
	}

	if(count($error_fields) > 0){
		$result['result'] = false;
		$result['error'] = false;
		$result['error_fields'] = $error_fields;
		echo json_encode($result);	
		exit();
	}
	
	$mail_body = "";
	$mail_body .= '<h2>Message from site DEDE</h2>';
	foreach($fields as $title=>$value){
		$mail_body .= '<p  style="font-size:13px; padding:0px 10px">
									<span style=" padding-right:10px;">'.$title.': </span>
									<span style="">'.$value.'</span></p>';
	}
	
	$mail_body .='--------------------------------';

	if(isset($_POST['ref_data']['title'])){
		$rel_title = trim($_POST['ref_data']['title']);
		$rel_title = htmlspecialchars($rel_title);
		$rel_title = strip_tags($rel_title);
	}else{
		$rel_title = '';	
	}
	
	ob_start();

	require_once($_SERVER['DOCUMENT_ROOT'].'/phpmailer/PHPMailerAutoload.php');
	$mail = new PHPMailer(); 
	$mail->CharSet = "utf-8"; 
	$mail->setLanguage('ru', $_SERVER['DOCUMENT_ROOT'].'/includes/phpmailer/language/');
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/smtp.config.php');
	
	$mail->MsgHTML(eregi_replace("[\]",'',$mail_body));
	$process = $mail->Send();

$send_log = ob_get_contents();
ob_end_clean();

	if($process){
//		$result['log'] = $send_log;
		$result['result'] = true;
		$result['send'] = true;
		$result['success'] = '<div class="message"><h2>Thanks for being awesome!</h2><p>We have received your message and would like to thank you for writing to us. If your inquiry is urgent, please call us +37129156512 to talk to one of our staff members. Otherwise, we will reply by email as soon as possible.</p></div>';

	}else{
//		$result['log'] = $send_log;
		$result['result'] = true;
		$result['send'] = false;
		$result['error'] = '<div class="message"><h2>Error sending message!</h2></div>';
	}
}

echo json_encode($result);
?>