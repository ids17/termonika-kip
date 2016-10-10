<?php
require_once 'template.php';
require_once 'config.php';


$id = $_POST['id'];

if (isset($_POST['choosen_mode']) && $_POST['choosen_mode'] != '') {
	$ch_mode = $_POST['choosen_mode'];
	$id = $id . ':' . $ch_mode;
}
//echo $id;
addIntoCart($id);
