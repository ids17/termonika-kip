<?php

	require_once 'php/config.php';
	require_once 'php/template.php';

	$items = get_items();
	$types = getTypes();
	$modes = getModes();
	$all_categories = get_categories();
	//формирование sidebar
	$category_tree = map_tree($all_categories);
	$category_menu = category_to_string($category_tree);
	$brands = get_brands();

	//$arr = [1,2];
	//print_arr($arr);
	//unset($_SESSION['brands']);
	if (isset($_SESSION['brands'])) {
		$brands_ses = $_SESSION['brands'];
	}else{
		$brands_ses = array();
	}

	if(isset($_GET['cat'])/*или просто catalog.php*/) {
		$cid = (int) $_GET['cat'];
		if ($cid != 0) {
			$page_title = $all_categories[$cid]['daughter'];
		}else{
			$page_title = 'Каталог';
		}
		$breadcrumbs = breadcrumbs_str($all_categories, 0, $cid);
		$divs = getNavigationDivs($all_categories, $items, $cid, $brands_ses);
	}elseif (isset($_GET['item'])) {
		$iid = (int) $_GET['item'];
		$page_title = $items[$iid]['name'];
		$divs = getItemDescription($iid);
		$breadcrumbs = breadcrumbs_str($all_categories, $items[$iid]['name'], $items[$iid]['parent_id']);
	}else{
		$page_title = 'Каталог';
		$cid = 0;
		$breadcrumbs = breadcrumbs_str($all_categories, 0, $cid);
		$divs = getNavigationDivs($all_categories, $items, $cid, $brands_ses);
	}


	if(empty($_COOKIE['login']) and empty($_COOKIE['password'])){
		$login_status = chunk('','login_template.php');
	}
	else{
		$login_status = chunk('','user_template.php');
	}

	

	$filters = [$brands,$category_menu];
	//print_arr($filters);

	$design_sidebar = '<div id="design_sidebar">'.chunk($filters,'php/sidebar_template.php').'</div>';

	//$login_status = chunk(1,'php/user_template.php');
	//$login_status = '1234';

?>

