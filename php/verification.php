<?php

//echo "1";
//echo registration_response();

//function registration_response(){

	//global $connection;

include 'config.php';

	$login = $_POST['email'];
	$password = $_POST['password'];
	$mdPassword = md5($password);
	//$password2 = $_POST['password2'];
	$email = $_POST['email'];
	$rdate = date("d-m-Y в H:i");
	$name = $_POST['name'];
	$lastname = '';  
	$rating = 1;


	$query2 = ("SELECT id FROM users WHERE email='$email'");
	$sql = mysqli_query($connection,$query2) or die(mysqli_error($connection));
	if (mysqli_num_rows($sql) > 0){
		echo 1;
	}
	else{
		$query = "INSERT INTO users (login, password, email, reg_date, name, lastname, rating)
		VALUES ('$login', '$mdPassword', '$email', '$rdate', '$name', '$lastname', '$rating')";
		$result = mysqli_query($connection,$query) or die(mysqli_error($connection));

		echo 2;
	}
//}
?>