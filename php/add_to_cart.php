<?php
require_once 'template.php';
require_once 'config.php';

$id = substr($_POST['id'],6);
//echo $id;
addIntoCart($id);
