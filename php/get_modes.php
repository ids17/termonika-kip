<?php
require_once 'config.php';
require_once 'template.php';

$id = substr($_POST['id'],6);

$query = "SELECT id, mode, price FROM modes WHERE puid = {$id}";

$res = mysqli_query($connection, $query);
$arr = array();
while($row = mysqli_fetch_assoc($res))
	$arr[$row['id']] = $row;

//print_arr($arr);

$div = chunk($arr,'modes_template.php');
echo $div;
//$subarr = 

//echo implode(",", implode("|", $arr));