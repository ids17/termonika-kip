<?php
require_once 'template.php';
require_once 'config.php';

$id = $_POST['id'];
echo $id;
deleteFromCart($id);

