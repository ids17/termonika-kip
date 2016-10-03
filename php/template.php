<?php

	//Шаблон вывода категорий
function chunk($message,$template){
	ob_start();
	include $template;
	return ob_get_clean();
}

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
				@$brands .= '<input name="'.$node['name'].'" value='.$node['id'].' class="filter_item" type="checkbox" checked><label>'.$node['name'].'</label>' ;
			else
				@$brands .= '<input name="'.$node['name'].'" value='.$node['id'].' class="filter_item" type="checkbox"><label>'.$node['name'].'</label>' ;

			return $brands;
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
				$breadcrumbs = "<a href='catalog.php?cat=0'>Каталог</a> / ";
				foreach ($breadcrumbs_array as $id => $daughter)
					$breadcrumbs .= "<a href='catalog.php?cat={$id}'>{$daughter}</a> / ";
				$breadcrumbs = rtrim($breadcrumbs, " / ");
			}else {
				$breadcrumbs = "Каталог";	
			}
			if($item_name)
				$breadcrumbs .= " / {$item_name}";
			else
				@$breadcrumbs = preg_replace("#(.+)?<a.+>(.+)</a>$#", "$1$2", $breadcrumbs);
			return $breadcrumbs;
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

	//Возвращает массив подкатегорий категории $category_id
	function choose_divs($dataset, $category_id){
		$res = array();
		foreach ($dataset as $key=>$node)
			if ($node['parent_id']==$category_id)
				$res[$key]=$node;
			return $res;
		}
/*
	//Возвращает массив подкатегорий категории $category_id
	function choose_divs($dataset, $items, $category_id, $brands){
		$res = array();
		
		if (empty($brands))
				{
					foreach ($dataset as $key=>$node)
						if ($node['parent_id']==$category_id){
							$res[$key] = $node;
							//continue;
						}
				}else{
					$dataset = get_cat_items($dataset, $items, $category_id, $brands);
						foreach ($dataset as $key=>$node)
						if ($node['parent_id']==$category_id){
							$res[$key] = $node;
							//continue;
						}
				}

			return $res;
		}
*/
		//получение всех конечных категорий заданной категории
	function get_end_cats($cats, $cid_arr, $end_cats){
		$arr_cat = array();
		global $end_cats2;
		//$i = 0;
		//print_arr($cats);
		//print_arr($cid_arr);
		//print_arr($end_cats);
		foreach ($cid_arr as $key => $value) {

			foreach ($cats as $id => $node) {
			if ($node['parent_id'] == $value){
				array_push($arr_cat, $node['id']); 
				//$i++;
			}
		}
		
		if (count($arr_cat)==0) {
			//print_arr($arr_cat);
			//echo $value;
			array_push($end_cats, $value);
		}else{
			$end_cats2 = get_end_cats($cats, $arr_cat, $end_cats);
			print_arr($end_cats);
			print_arr($end_cats2);
			echo '__________';
			//$end_cats = $end_cats2;
			//$end_cats = array_merge($end_cats, $end_cats2);
		}
		//print_arr($end_cats);
		
		}
		return $end_cats;
	}
	//получение всех товаров заданной категории
	function get_cat_items($cats, $items, $cid, $brands){
		$cid_arr[0] = $cid;
		$end_cats = array();
		$end_cats = get_end_cats($cats, $cid_arr, $end_cats);
		foreach ($end_cats as $key => $value) {
			foreach ($items as $id => $node) {
				if ($node['parent_id'] == $value) {
					foreach ($brands as $to => $brand) {
						if ($node['brand_id'] == $brand) {
							unset($end_cats[$key]);
						}
					}
				}
			}
		}

		foreach ($cats as $key => $value) {
			foreach ($end_cats as $id => $node) {
				if ($node == $value['id']) {
					unset($cats[$key]);
				}
			}
		}

		$arr = array();
		foreach ($cats as $key => $value) {
			foreach ($cats as $id => $node) {
				if ($node['parent_id']==$value['id']) {
					$arr[$key] = $cats[$key];
				}elseif ($node['end_flag']==1) {
					$arr[$id] = $cats[$id];
				}
			}
		}
		return $arr;
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

//получение отфильтрованных блоков категорий и товаров
	function getNavigationDivs($categories, $items, $cid, $brands)
	{
		@$divs = '';
		$category_divs = choose_divs($categories, $cid);
		if (count($category_divs))
			foreach ($category_divs as $key => $node){

				@$divs .= 
				"<div class='category_items'>
					<a href='catalog.php?cat={$node['id']}' class='categoryChose'>
						<div class='item_img' style='background-image: url(img/category/pic18.gif)'>
							<!--<img height='100%' src='img/category/pic18.gif' alt=''>-->
						</div>
						<div class='cat_name'>
							<p>{$node['daughter']}</p>
						</div>
					</a>
				</div> ";
			}
		else {
			$items_divs = choose_items($items, $cid, $brands);
			if($items_divs){
				foreach ($items_divs as $key => $node){
					$image = explode(',', $node['image']);
					@$divs .= 
					"<div class='item'>
						<a href='?item={$node['id']}' class='categoryChose'>
							<div class='item_img' style='background-image: url(img/items/{$image[0]})'>
								<!--<img src='img/items/{$image[0]}' alt=''>-->
							</div>
							<div class='item_title'>
								<h4>{$node['name']}</h4>
								{$node['prev_info']}	
							</div>
						</a>
					</div>";
				}
			}else{
				@$divs .= '<h3>Подходящие товары в данный момент отсутствуют. Вы можете воспользоваться поиском или заполнить форму ниже.</h3><form class="form">
			<input type="hidden" name="project_name" value="Термоника">
			<input type="hidden" name="admin_email" value="eguzman@yandex.ru">
			<input type="hidden" name="form_subject" value="Запрос товара">
			<input type="text" name="name" placeholder="Представьтесь, пожалуйста" required="true">
			<input type="text" name="email" placeholder="Ваш e-mail" required="true">
			<textarea name="question" rows="5" cols="45" wrap="soft" placeholder="Расскажите, что Вам нужно" required="true"></textarea>
			<button> 
				<p>Отправить заявку</p>
			</button>
			<p id="response"></p>
		</form>';
				//форма запроса товара
			}
		}	
		$divs .= '<div style="clear:both;"></div>'; 
		//$divs = '<div class="cat_div">'.$divs.'</div>';
		return $divs;
	}


//получение описания товара
	function getItemDescription($iid)
	{
		global $items;
		if(!$items[$iid]['price']){
			$items[$iid]['price'] = "<button class='button price_button'>Уточнить цену</button>";
		}else{
			$items[$iid]['price'] = "<h2>".$items[$iid]['price']."</h2>";
		}
		if(!$items[$iid]['attrs']){
			$items[$iid]['modes'] = "<button id='addToCart' class='button button_buy'>В список покупок</button>";
		}else{
			$items[$iid]['modes'] = "<button class='button button_buy button_modes'>Выбрать модификацию</button>";
		}


		$docs_text = explode('||', $items[$iid]['docs_text']);
		$docs_file = explode(',', $items[$iid]['docs_filename']);

		$img_arr = explode(',', $items[$iid]['image']);
		array_pop($img_arr);
		//print_arr($img_arr);

		$photos = '';
		$thumbs = '';	
		foreach ($img_arr as $key => $value) {
			$flag = $key+1;
			$photos .= '<li id="photo-'.$flag.'"><a href="#p'.$flag.'"><img width="100%" src="img/items/'.$value.'" alt="'.$value.'"/></a></li>';
			$thumbs .= '<li id="thumb-'.$flag.'"><a href="#t'.$flag.'"><img height="50px" src="img/items/'.$value.'" alt="'.$value.'"/></a></li>';
		}
		$photos = '<ul id="photos">'.$photos.'</ul>';
		$thumbs = '<ul id="thumbs">'.$thumbs.'</ul>';

		//print_arr($docs_text);
		foreach ($docs_text as $key => $value) {
			@$docs .= '<a href="'.$docs_file[$key].'">'.$value.'</a><br>';
		}
		$full_item_info['$items'] = $items;
		$full_item_info['$photos'] = $photos;
		$full_item_info['$thumbs'] = $thumbs;
		$full_item_info['$docs'] = $docs;
		$full_item_info['$iid'] = $iid;
		//print_arr($full_item_info);
		@$divs = chunk($full_item_info,'item_template.php');
		return $divs;
	}
    
    //код отображения корзины
	function show_cart($items, $login_status)
	{
		global $connection;
		if (!empty($_COOKIE['login']))
		{
			$query = "SELECT cart FROM users WHERE id = {$_COOKIE['id']}";
			$res = mysqli_query($connection, $query);
			$cart = mysqli_fetch_assoc($res);
			$arr_cart = cart_to_arr($cart['cart']);
		}
		else
			$arr_cart = cart_to_arr(@$_SESSION['cart']);
		
		$cart_code = '<div id="prev_cart">
			<div id="left_part">'.$login_status.'</div>
			<div id="cart_info"><button id="close_button"><i class="close_button fa fa-times" aria-hidden="true"></i></button><div class="help_out_next"><h1>Список покупок</h1><hr>
				<div class="out_next">';	
		
		if(isset($arr_cart[0][0])){
			$cart_code .= "<table id='cart_table' class='cart_table'>";
			foreach ($arr_cart as $key => $value) {
				$image = explode(',', $items[$value[0]]['image']);
				$cart_code .= "	
				<tr class='cart_item' id='cart_item{$value[0]}'>
					<td><a href='catalog.php?item={$value[0]}'><div class='cart_item_img' style='background-image: url(\"img/items/{$image[0]}\");' alt='{$image[0]}'></div></a></td>
					<td><a href='catalog.php?item={$value[0]}'>{$items[$value[0]]['name']}</a></td>
					<td><textarea class='comment'>{$value[2]}</textarea></td>
					<td><input class='cart_item_input cart_item_qty' type='number' size='3' value='{$value[1]}' min='1' max='999' maxlength='3'></td>
					<td>
						<button class='delete_button'><i class='fa fa-trash-o' aria-hidden='true'></i></button>

					</td>
					<td></td>
				</tr>
				";
			}
			$cart_code .= "</table></div></div>
				<div id='next_step1'>
				<i></i>
				<h4>Продолжить</h4>
				</div>";
	}
	else
		$cart_code .= "<p>Список пуст</p></div>";
	$cart_code .= '</div></div>';
	return $cart_code;
}

function cart_to_arr($cart){
	$empty = array();
	if (empty($cart)) return $empty;
	$cart_arr = explode ("`||`", $cart);
	foreach ($cart_arr as $key => $value) {
		$arr_cart[$key] = explode(" ", $cart_arr[$key], 3);
		if (count($arr_cart[$key]) == 2) $arr_cart[$key][2] = "";
	}
	return $arr_cart;
}

function cart_to_str($cart){
	$str = "";
	foreach ($cart as $key => $value)
		$str .= $value[0] . ' ' . $value[1] . ' ' . $value[2] . '`||`';
	if (!empty($str))
		$str = substr($str, 0, -4);
	return $str;
}

		//получение корзины пользователя в виде строки из БД
	function getUserCart($user_id)
	{
		global $connection;
		$query = "SELECT cart FROM users WHERE id = {$user_id}";
		$res = mysqli_query($connection, $query);
		$cart = mysqli_fetch_assoc($res);
		return $cart['cart'];
	}

	//Добавление товара в корзину
	function addIntoCart($id)
	{
		if (isset($_COOKIE['login'])) {
			$arr_cart = cart_to_arr(getUserCart($_COOKIE['id']));
		}
		elseif (isset($_SESSION['cart'])){
			$arr_cart = cart_to_arr($_SESSION['cart']);
		}
		else{
			$arr_cart = cart_to_arr("");
		} 
		$is_in_cart = false;

		
		foreach ($arr_cart as $key => $node)
			if ($node[0] == $id) {
				$arr_cart[$key][1]++;
				$is_in_cart = true;
				break;
			}
		
		if (!$is_in_cart) {
			$arr_cart[][0] = $id;
			$arr_cart[count($arr_cart)-1][1] = 1;
			$arr_cart[count($arr_cart)-1][2] = "";
		}
		$str = cart_to_str($arr_cart);
		if (isset($_COOKIE['login'])) setUserCart($_COOKIE['id'], $str);
		else $_SESSION['cart'] = $str;
	}

	//изменение корзины пользователя в БД
	function setUserCart($user_id, $str)
	{
		global $connection;
		$query = "UPDATE users SET cart = '{$str}' WHERE id = {$user_id}";
		$res = mysqli_query($connection, $query);
	}

	//удаление товара из корзины
	function deleteFromCart($item_id)
	{
		global $connection;
		if (isset($_COOKIE['login'])) $arr_cart = cart_to_arr(getUserCart($_COOKIE['id']));
		else $arr_cart = cart_to_arr($_SESSION['cart']);
		foreach($arr_cart as $key => $node)
			if ($node[0] == $item_id)
				unset($arr_cart[$key]);
		$str = cart_to_str($arr_cart);
		if (isset($_COOKIE['login'])) setUserCart($_COOKIE['id'], $str);
		else $_SESSION['cart'] = $str;
	}

	//изменение количества товара в корзине
	function changeItemAmount($item_id, $value)
	{
		global $connection;
		if (isset($_COOKIE['login'])) $arr_cart = cart_to_arr(getUserCart($_COOKIE['id']));
		else $arr_cart = cart_to_arr($_SESSION['cart']);
		foreach($arr_cart as $key => $node)
			if ($node[0] == $item_id) $arr_cart[$key][1] = $value;
		$str = cart_to_str($arr_cart);
		if (isset($_COOKIE['login'])) setUserCart($_COOKIE['id'], $str);
		else $_SESSION['cart'] = $str;
	}

	//изменение комментария к товару в корзине
	function changeCartComment($item_id, $comment)
	{
		global $connection;
		if (isset($_COOKIE['login'])) $arr_cart = cart_to_arr(getUserCart($_COOKIE['id']));
		else $arr_cart = cart_to_arr($_SESSION['cart']);




		foreach($arr_cart as $key => $node)
			if ($node[0] == $item_id) $arr_cart[$key][2] = $comment;
		$str = cart_to_str($arr_cart);
		if (isset($_COOKIE['login'])) setUserCart($_COOKIE['id'], $str);
		else $_SESSION['cart'] = $str;
	}

	//Получение целой таблицы БД
	function get_all($table, $col){
		global $connection;
		$query = "SELECT * FROM " . $table;
		$res = mysqli_query($connection, $query);
		$arr_cat = array();
		while($row = mysqli_fetch_assoc($res))
			$arr_cat[$row[$col]] = $row;
		return $arr_cat;
	}
