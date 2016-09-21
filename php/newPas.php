<?php

include 'config.php';


$token = $_POST['token'];


if (goodtoken($token)==1) {
	//setcookie('flag', "1", time()+3600*24);
	$password = $_POST['pas'];
	$mdPassword = md5($password);
	//$password2 = $_POST['pas2'];
	//$mdPassword = md5($password2);

	$user_id = $_SESSION['user_id'];
	//echo $user_id;

	$query = "UPDATE users SET password='$mdPassword' WHERE id='$user_id'";

	if (mysqli_query($connection,$query) or die(mysqli_error($connection))) {
		echo "Пароль успешно обновлен! Теперь можете войти.";
	}
	//echo $_SESSION['user_id'];
	unset($_SESSION['user_id']);
	//echo $_SESSION['user_id'];
}else{
	echo 0;
}
		//проверяем совпадение токена
		//проверяем дату
		//удаляем токен
		//отображаем форму для ввода пароля
		//проверяем пароль
		//заносим пароль


	//проверка токена
function goodtoken($token){
	global $connection;
	$query = "SELECT * FROM recoveryemails WHERE token='$token'";
	$key = mysqli_query($connection, $query);
	$key = mysqli_fetch_array($key);
	if ($key['id']) {
		//echo($key['user_id']);
		$user_id = $_SESSION['user_id']=$key['user_id'];
		//echo($_SESSION['user_id']) ;
		$query = "DELETE FROM recoveryemails WHERE user_id='$user_id'";
		mysqli_query($connection,$query) or die(mysqli_error($connection));
		return 1;
	}else {
		return 0;
	}
}