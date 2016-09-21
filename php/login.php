<?php
include 'config.php';
	//include 'xajax_functions.php';
include 'template.php';

if (isset($_POST['email'])){
	$login = $_POST['email']; 
	$password = $_POST['password']; 
	if ($login == '') {
		unset($login);
		echo "Введите, пожалуйста, адрес электронной почты!";
	}elseif ($password == '') {
		unset($password);
		echo "Введите пароль";
	}
	else{
		@$login = stripslashes($login);
		$login = htmlspecialchars($login);
		@$password = stripslashes($password);
		$password = htmlspecialchars($password);
		$login = trim($login);
		$password = trim($password);
		$password = md5($password);

		$query = "SELECT id, name, cart FROM users WHERE login='$login' AND password='$password'";
		$user = mysqli_query($connection, $query);
		$id_user = mysqli_fetch_array($user);
		if (empty($id_user['id']))
			echo "Извините, введённый вами e-mail или пароль неверный.";

		else {

			//сохранение пользовательских данных в cookie
			setcookie('login', $login, time()+3600*24*365);
			setcookie('password', $password, time()+3600*24*365);
			setcookie('id', $id_user['id'], time()+3600*24*365);
			setcookie('name', $id_user['name'], time()+3600*24*365);


			//объединение сессионной корзины и корзины из БД
			if (isset($_SESSION['cart'])) {
				$db_cart = cart_to_arr(getUserCart($id_user['id']));
				$s_cart = cart_to_arr($_SESSION['cart']);
				
				foreach ($db_cart as $key => $node)
				{
					$in = false;
					foreach ($s_cart as $k => $n)
						if ($n[0] == $node[0])
							$in = true;
					if (!$in)
					{
						$s_cart[][0] = $node[0];
						$s_cart[count($s_cart)-1][1] = $node[1];
						$s_cart[count($s_cart)-1][2] = $node[2];
					}
				}
				$cart = cart_to_str($s_cart);
				setUserCart($id_user['id'], $cart);
				$_SESSION['cart'] = "";	
			}
				
		}
	}
}




	?>