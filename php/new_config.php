<?php
	define ("DBHOST", "localhost");
	define ("DBUSER", "termonikar_kip");
	define ("DBPASS", "nthvjybrfrbg2016");
	define ("DB", "termonikar_kip");

	$connection = @mysqli_connect(DBHOST, DBUSER, DBPASS, DB) or die("Нет соединения");
	mysqli_set_charset($connection, "utf8") or die("Не установлена кодировка");
	session_start();
?>