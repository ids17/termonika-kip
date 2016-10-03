<?php

include 'config.php';

//define(PW_SALT,'(+3%_');

$project_name = "Термоника";
$admin_email  = "eguzman@yandex";
$form_subject = "Восстановление пароля";

$expFormat = mktime(date("H")+1, date("i"), date("s"), date("m")  , date("d")+3, date("Y"));
$expDate = date("Y-m-d H:i:s",$expFormat);
$email = $_POST['forgetPas_email'];
$query = "SELECT id FROM users WHERE login='$email'";
$user = mysqli_query($connection, $query);
$id_user = mysqli_fetch_array($user);
$user_id = $id_user['id'];

$query = "SELECT * FROM recoveryemails WHERE user_id='$user_id'";
$recovery_user = mysqli_query($connection, $query);
$recovery_user = mysqli_fetch_array($recovery_user);

if ($id_user['id']) {
	$id = $id_user['id'];
	$flag = 0;
    $key = md5($email . rand(0,10000) .$expDate);
	if ($recovery_user['user_id']==$user_id) {
        $query = "UPDATE `recoveryemails` SET `token`='$key', `expDate`='$expDate' WHERE `user_id`=$user_id";
        //echo $query;
	}else{
		$query = "INSERT INTO recoveryemails (user_id, token, expDate) VALUES ('$id','$key','$expDate')";
        //echo $query;
	}
    if(mysqli_query($connection,$query) or die(mysqli_error($connection))){
        $flag = 1;
    }
	
	if ($flag==1) {
		//$message = "<a href='http://localhost/trm.ru/catalog.php?a=$key'>Перейти по ссылке</a>";
		//$message = "<tr><td>$message</td></tr>";
		//$message = "<table style='width: 100%;'>$message</table>";	

		$message = '<h1 style="font-weight: 200;text-align: center;margin: 0 !important;">Восстановление пароля</h1>
        <p style="font-weight: 200;margin-top: 30px;text-align: center;">Здравствуйте! Для смены пароля, пожалуйста, перейдите по ссылке <a href="http://localhost/termonika-kip/catalog.php?token='.$key.'"> http://localhost/termonika-kip/catalog.php?token='.$key.'</a></p>';

    $message = mail_to_string($message,'mail_template.php');

		//echo $message;

		//echo $_SERVER['HTTP_REFERER'];

		$headers = "MIME-Version: 1.0" . PHP_EOL .
		"Content-Type: text/html; charset=utf-8" . PHP_EOL .
		'From: '.adopt($project_name).' <'.$admin_email.'>' . PHP_EOL .
		'Reply-To: '.$admin_email."". PHP_EOL;
        
        //echo $message;
		mail($email, adopt($form_subject), $message, $headers);

		echo "На ваш e-mail в течение 15 минут придет письмо для восстановления пароля";
	}else{
		echo "---";
	}
}else{
	echo "Такой e-mail не зарегистрирован";
}

function adopt($text) {
	return '=?UTF-8?B?'.base64_encode($text).'?=';
}

	
function mail_to_string($message,$template){
		$string = mail_to_template($message, $template);
		return $string;
}

	//Шаблон вывода категорий
function mail_to_template($message,$template){
		ob_start();
		include $template;
		return ob_get_clean();
	}
