<?php
require_once 'config.php';
require_once 'template.php';

if(empty($_COOKIE['login']) and empty($_COOKIE['password'])){
	
}
else{
	$id = $_COOKIE['id'];
	$cart = getUserCart($id);
	$expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+3, date("Y"));
	$date = date("Y-m-d H:i:s",$expFormat);
	$status = 0;
	$comments = "";
	//$comments = getComments();
	//addNewOrder($id, $cart, $date, $status);

	$query = "INSERT INTO `orders`(`user_id`, `cart`, `comments`, `date`, `status`) VALUES ('{$id}', '{$cart}', '{$comments}', '{$date}', '{$status}')";
	echo $query;
	mysqli_query($connection,$query) or die(mysqli_error($connection));

	setUserCart($id,"");
}
