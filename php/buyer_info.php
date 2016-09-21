<?php
	//require_once '../catalog_vars.php';
	require_once 'template.php';
	require_once 'config.php';

echo '<div id="buyer_info"><div class="back_prev">
	<i class="fa fa-undo" aria-hidden="true"></i>
	<h4>Назад</h4>
</div>';

	if(empty($_COOKIE['login']) and empty($_COOKIE['password'])){
		echo chunk('','please_login.php');
	}
	else{
		$user = getUserInfo($_COOKIE['id']);
		echo chunk($user,'buyer_info_template.php');
	}
echo '</div>';

echo '<div id="confirm_order"><div class="back_prev">
	<i class="fa fa-undo" aria-hidden="true"></i>
	<h4>Назад</h4>
</div><div class="confirm_div"><h2>Подтвердите свой заказ</h2><button>Подтверждаю</button></div></div>';

function getUserInfo($id){
	global $connection;
	$query = "SELECT * FROM users WHERE id = {$id}";
	$res = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($res);
	return $row;
}