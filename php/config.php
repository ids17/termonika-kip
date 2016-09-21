<?php
	define ("DBHOST", "localhost");
	define ("DBUSER", "evgeny");
	define ("DBPASS", "qwerty");
	define ("DB", "termonika");

	$connection = @mysqli_connect(DBHOST, DBUSER, DBPASS, DB) or die("Нет соединения");
	mysqli_set_charset($connection, "utf8") or die("Не установлена кодировка");
	session_start();
?>