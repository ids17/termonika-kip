<?php
	require_once 'template.php';
	require_once 'config.php';

	$id = substr($_POST['id'], 9);
	$value = $_POST['value'];


	changeItemAmount($id, $value);
?>