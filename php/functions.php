<?php

	//Распечатка массива
	function print_arr($array){
		echo "<pre>" . print_r($array, true) . "</pre>";
	}

	//Получение массива категорий
	function get_categories(){
		global $connection;
		$query = "SELECT * FROM category";
		$res = mysqli_query($connection, $query);
		$arr_cat = array();
		while($row = mysqli_fetch_assoc($res))
			$arr_cat[$row['id']] = $row;
		return $arr_cat;
	}

	//Возвращает дерево категорий,
	//построенное по входному массиву категорий
	function map_tree($dataset) {
		$tree = array();
		foreach ($dataset as $id => &$node)
			if (!@$node['parent_id'])
				$tree[$node['id']] = &$node;
			else
				$dataset[$node['parent_id']]['childs'][$node['id']] = &$node;     
		return $tree;
	}

	//Возращает HTML-меню, полученное из входного
	//дерева категорий
	function category_to_string($data){
		foreach ($data as $item)
			@$string .= category_to_template($item);
		return @$string;
	}

	//Шаблон вывода категорий
	function category_to_template($category){
		ob_start();
		include 'category_template.php';
		return ob_get_clean();
	}

	//Возвращает breadcrumbs-массив строк для категории $category_id
	function breadcrumbs($array, $category_id){
		if (!$category_id) return false;
		$breadcrumbs_array = array();
		$node = $array[$category_id];
		while ($node['id']) {
			$breadcrumbs_array[$node['id']] = $node['daughter'];
			@$node = $array[$node['parent_id']]; 
		}
		return array_reverse($breadcrumbs_array, true);
	}

	//Возвращает breadcrumbs-строку для категории $category_id
	//и товара с именем $item_name
	function breadcrumbs_str($categories, $item_name, $category_id){
		$breadcrumbs_array = breadcrumbs($categories, $category_id);
		if($breadcrumbs_array){
			$breadcrumbs = "<a onclick='refreshCatalog(0)'>Каталог</a> / ";
			foreach ($breadcrumbs_array as $id => $daughter)
				$breadcrumbs .= "<a onclick='refreshCatalog({$id})'>{$daughter}</a> / ";
			$breadcrumbs = rtrim($breadcrumbs, " / ");
		}else if ($category_id) {
			$breadcrumbs = "Каталог";	
		}
		if($item_name)
			$breadcrumbs .= " / {$item_name}";
		else
			@$breadcrumbs = preg_replace("#(.+)?<a.+>(.+)</a>$#", "$1$2", $breadcrumbs);
		return $breadcrumbs;
	}
	
	//Возвращает массив подкатегорий категории $category_id
	function choose_divs($dataset, $category_id){
		$res = array();
		foreach ($dataset as $key=>$node)
			if ($node['parent_id']==$category_id)
				$res[$key]=$node;
			return $res;
		}

	//Получение массива товаров
	function get_items(){
		global $connection;
		$arr_items = array();
		$query = "SELECT * FROM items";
		$res = mysqli_query($connection, $query);
		while($row = mysqli_fetch_assoc($res))
			$arr_items[$row['id']] = $row;
		
		$query = "SELECT * FROM owen";
		$res = mysqli_query($connection, $query);
		while($row = mysqli_fetch_assoc($res))
			$arr_items[$row['id']] = $row;
		return $arr_items;
	}

	//Возвращает массив подходящих товаров, принадлежащих
	//категории $category_id и производителям $brands
	function choose_items($dataset, $category_id, $brands){
		$res = array();
		foreach ($dataset as $key => $node)
			if ($node['parent_id'] == $category_id)
			{
				if (empty($brands))
				{
					$res[$key] = $node;
					continue;
				}
				foreach ($brands as $brand)
					if ($node['brand_id'] == $brand)
					{
						$res[$key] = $node;
						break;
					}
			}
		return $res;	
	}
	

	//Получение массива производителей
	function get_brands(){
		global $connection;
		$query = "SELECT * FROM brands";
		$res = mysqli_query($connection, $query);
		$arr_brand = array();
		while($row = mysqli_fetch_assoc($res))
			$arr_brand[$row['id']] = $row;
		foreach ($arr_brand as $key => $node)
			if (!empty($_SESSION['brands']) && in_array($node['id'], $_SESSION['brands']))
				@$brands .= "<li class='brand_button active_brand'><a>{$node['name']}</a></li> " ;
			else
				@$brands .= "<li class='brand_button'><a>{$node['name']}</a></li> " ;
		return $brands;
	}

	//Возвращает массив категорий, содержащих товары производителей $brands 
	//(включая предков)
	function get_filtred_categories($brands) {
		global $connection;
		$query = "SELECT * FROM category AS cat WHERE cat.id IN (SELECT parent_id FROM items WHERE ";
		foreach ($brands as $brand)
			$query .= "brand_id='$brand' OR ";
		$query = substr($query, 0, -4);
		$query .= ")";
		$res = mysqli_query($connection, $query);
		$arr_cat = array();
		while($row = mysqli_fetch_assoc($res))
			$arr_cat[$row['id']] = $row;
		$all_cat = get_categories();
		$end = false;
		while (!$end)
		{
			$end = true;
			foreach ($arr_cat as $key => $node)
				if ($node["parent_id"] && !in_array($all_cat[$node["parent_id"]], $arr_cat)) {
					$arr_cat[$node['parent_id']] = $all_cat[$node["parent_id"]];
					$end = false;
				}
		}
		ksort($arr_cat);
		return $arr_cat;
	}

	//прибваляет странице rating
	function rating_plus($id, $num){
		if ($id) {
			global $connection;
			if ($num==1) {
				$table = "category";
			}elseif ($num==2) {
				$table = "items";
			}
			$query = "UPDATE $table SET rating=rating+1 WHERE id=$id";
			//echo $query;
			$result = mysqli_query($connection,$query) or die(mysqli_error($connection));
		}
	}
	

	function doc_to_tags($str) {
	$arr = explode(',', $str);
	return $arr;
	}


	
?>