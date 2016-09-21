<?php
setcookie('login');
setcookie('password');
setcookie('id');
setcookie('name');
$_SESSION['cart'] = "";
header('Location: ' . $_SERVER['HTTP_REFERER']);