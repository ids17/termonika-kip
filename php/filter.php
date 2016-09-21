<?php
require_once '../catalog_vars.php';

//echo $cid;
$id = $_POST['id'];
$value = $_POST['param'];
$param = explode('=', $_POST['cid']);
if ($param[0]=='?cat') {
	$cid = substr($_POST['cid'], 5);
}elseif($param[0]=='?item'){
	foreach ($items as $key => $node) {
		if ($param[1]==$node['id']) {
			$cid = $node['parent_id'];
		}
	}
}
//$cid_arr[0] = $cid;
//$end_cats = [];
//$end_cats = get_end_cats($all_categories, $cid_arr, $end_cats);
//print_arr($end_cats);
//get_cat_items($all_categories, $items, $cid, $_SESSION['brands']);
//echo $id;
//echo $value;
/*
$query = "SELECT * FROM ".$value;
$res = mysqli_query($connection, $query);
$arr = array();
while($row = mysqli_fetch_assoc($res))
	$arr[$row['id']] = $row;
*/

//$_SESSION[$value] = [];
$_SESSION[$value][0] = 0;
unset($_SESSION[$value][0]);

$flag = false;
foreach ($_SESSION[$value] as $key=>$node) {
	//echo $node;
	//echo $id;
	if ($node == $id) {
		unset($_SESSION[$value][$key]);
		$flag = true;
		break;
	}
}

if ($flag == true) {
	//echo 'delete' . $_SESSION[$value][$id];
	//unset($_SESSION[$value][$id]);
}else{
	array_push($_SESSION[$value], $id);
}


//print_arr($all_categories);
//print_arr(get_end_cats($all_categories,$cid));
//$cid = (int) $_GET['cat'];

//echo $cid;
echo getNavigationDivs($all_categories, $items, $cid, $_SESSION['brands']);


/*
foreach ($arr_brand as $key => $node)
	if (!empty($_SESSION['brands']) && in_array($node['id'], $_SESSION['brands']))
		@$brands .= '<input name="'.$node['name'].'" value='.$node['id'].' class="filter_item" type="checkbox" checked><label>'.$node['name'].'</label>' ;
	else
		@$brands .= '<input name="'.$node['name'].'" value='.$node['id'].' class="filter_item" type="checkbox"><label>'.$node['name'].'</label>' ;
*/