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
						<!--<div class='item_img' style='background-image: url(img/category/pic18.gif)'>
							<img height='100%' src='img/category/pic18.gif' alt=''>
						</div>-->
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
					$image = explode(',', $node['image'], 2);
					@$divs .= 
					"<div class='item'>
						<a href='?item={$node['id']}' class='categoryChose'>
							<div class='item_img' style='background-image: url(\"img/items/{$image[0]}\")'>
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
			<div class="input-field">
          <textarea id="textarea-in-form2" class="materialize-textarea textarea-in-form" name="question" value=""></textarea>
          <label class="textarea_label" for="textarea-in-form2">Расскажите, что Вам нужно</label>
       </div>
			<button> 
				<p>Отправить заявку</p>
			</button>
			<p class="response"></p>
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
		global $types;
		global $modes;

		$item = $items[$iid];
		if(!$item['price']){
			$item['price'] = "<button class='button price_button modal-trigger' data-target='know-price'><i class='fa fa-rub' aria-hidden='true'></i> Цена</button>";
		}else{
			$item['price'] = "<h2><i class='fa fa-rub' aria-hidden='true'></i> ".$item['price']."</h2>";
		}
		if(!$item['attrs']){
			$item['modes'] = "<button id='addToCart' data-item-id='".$iid."' class='button button_buy'><i class='fa fa-cart-plus' aria-hidden='true'></i>
 В корзину</button>";
			$item['modes_block'] = "";
		}else{
			$attrs = getItemAttrs($item['attrs']);
			//$item['attrs_arr'] = $attrs;
			$table_ths = '';
			$modes_cols = '';
			foreach ($attrs as $attr) {
				$table_ths .= '<th data-type-id="'.$attr[0].'" data-type-seq="'.$attr[2].'">'.$types[$attr[0]]['name'].'</th>';
				$modes_cols .= '<td><div class="modes_col" data-type-id="'.$attr[0].'"><form>';
				foreach ($attr[1] as $mode) {
					$modes_cols .= '<div class="mode_block"><input name="'.$types[$attr[0]]['name'].'" value="'.$mode.'_'.$attr[2].'"class="choose_mode" data-type-id="'.$attr[0].'" data-type-seq="'.$attr[2].'" data-mode-id="'.$mode.'" type="radio"/><label>'.$modes[$mode]['name'].'</label></div>';
				}
				$modes_cols .= '</form></div></td>';
			}
			//$item['attrs'] = 
			$item['attrs'] = '<div class="choose_modification" style="display:none;"><table class="table table-striped"><thead>
		<tr>'.$table_ths.'</tr></thead><tbody><tr>'.$modes_cols.'</tr></tbody></table><button id="addToCart" data-item-id="'.$iid.'" class="button button_buy buy_mode"><i class="fa fa-cart-plus" aria-hidden="true"></i> В корзину</button></div>';
;

			$item['modes'] = "<button class='button button_buy button_modes'><i class='fa fa-list-ul' aria-hidden='true'></i> Выбрать модификацию</button>";
			$item['modes_block'] = "";
		}


		$docs_text = explode('||', $item['docs_text']);
		$docs_file = explode(',', $item['docs_filename']);

		$img_arr = explode(',', $item['image']);
		array_pop($img_arr);
		//print_arr($img_arr);

		// $photos = '';
		// $thumbs = '';	
		// foreach ($img_arr as $key => $value) {
		// 	$flag = $key+1;
		// 	$photos .= '<li id="photo-'.$flag.'"><a href="#p'.$flag.'"><img width="100%" src="img/items/'.$value.'" alt="'.$value.'"/></a></li>';
		// 	$thumbs .= '<li id="thumb-'.$flag.'"><a href="#t'.$flag.'"><img height="50px" src="img/items/'.$value.'" alt="'.$value.'"/></a></li>';
		// }
		// $photos = '<ul id="photos">'.$photos.'</ul>';
		// $thumbs = '<ul id="thumbs">'.$thumbs.'</ul>';


		$photos = '';
    foreach ($img_arr as $key => $value) {
      $photos .= '<li data-thumb="img/items/'.$value.'"><div class="thumb-image"><img src="img/items/'.$value.'" data-imagezoom="true" class="img-responsive" alt="'.$value.'"/></div></li>';
    }
    $photos = '<div class="zoom-grid"><div class="flexslider"><ul class="slides">'.$photos.'</ul></div></div>';





		//print_arr($docs_text);
		foreach ($docs_text as $key => $value) {
			@$docs .= '<a href="'.$docs_file[$key].'">'.$value.'</a><br>';
		}
		$full_item_info['$item'] = $item;
		$full_item_info['$photos'] = $photos;
		//$full_item_info['$thumbs'] = $thumbs;
		$full_item_info['$docs'] = $docs;
		$full_item_info['$iid'] = $iid;
		//print_arr($full_item_info);
		@$divs = chunk($full_item_info,'item_template.php');
		return $divs;
	}
    
    //код отображения корзины
	function show_cart($items, $login_status)
	{
		global $types;
		global $modes;
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
				$mode_arr = mode_to_arr($value[0]);
				$mode_name = '';
				if (isset($mode_arr[1])) {
					foreach ($mode_arr[1] as $id => $attr) {
						$mode_name .= $types[$attr[0]]['name'] .': ' . $modes[$attr[1]]['name'] . ', ';
					}
					$mode_name = substr($mode_name, 0, -2);	
				}
				//$mode_name = getModeName($layout, );
				$image = explode(',', $items[$mode_arr[0]]['image']);
				$cart_code .= "	
				<tr class='cart_item' id='cart_item{$value[0]}'>
					<td><a href='catalog.php?item={$mode_arr[0]}'><div class='cart_item_img' style='background-image: url(\"img/items/{$image[0]}\");' alt='{$image[0]}'></div></a></td>
					<td><a href='catalog.php?item={$mode_arr[0]}'>{$items[$mode_arr[0]]['name']}</a><p>{$mode_name}</p></td>
					<td><textarea class='comment' style='resize:none;'>{$value[2]}</textarea></td>
					<td><input class='cart_item_input cart_item_qty' type='number' size='3' value='{$value[1]}' min='1' max='999' maxlength='3'></td>
					<td>
						<button class='delete_button' data-item-id='".$value[0]."'><i class='fa fa-trash-o' aria-hidden='true'></i></button>

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
	}else
		$cart_code .= "<p>Список пуст</p></div>";
	$cart_code .= '</div></div>';
	return $cart_code;
}

function cart_to_arr($cart){
	$empty = array();
	if (empty($cart)) return $empty;
	$cart_arr = explode ("`||`", $cart);
	foreach ($cart_arr as $key => $value) {
		$arr_cart[$key] = explode("-", $cart_arr[$key], 3);
		//$arr_cart[$key][0] = mode_to_arr($arr_cart[$key][0]);
		if (count($arr_cart[$key]) == 2) $arr_cart[$key][2] = "";
	}
	return $arr_cart;
}

function cart_to_str($cart){
	$str = "";
	foreach ($cart as $key => $value){
		//$value[0] = mode_to_str($value[0]);
		$str .= $value[0] . '-' . $value[1] . '-' . $value[2] . '`||`';
	}
	if (!empty($str))
		$str = substr($str, 0, -4);
	return $str;
}

function mode_to_arr($str){
	$mode_arr = explode(':', $str);
	//echo $mode_arr;
	// здесь проверять есть ли модификации или нет
	if (isset($mode_arr[1])) {
		$mode_arr[1] = explode(',', $mode_arr[1]);	
		foreach ($mode_arr[1] as $key => $value) {
			$mode_arr[1][$key] = explode('|', $mode_arr[1][$key]);
		}
	}
	return $mode_arr;
}

function mode_to_str($arr){
	$str = "";
	return $arr;
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
	//изменение корзины пользователя в БД
	function setUserCart($user_id, $str)
	{
		global $connection;
		$query = "UPDATE users SET cart = '{$str}' WHERE id = {$user_id}";
		$res = mysqli_query($connection, $query);
	}

	//Добавление товара в корзину
	function addIntoCart($id){
		

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

	//функции для работы с модификациями товаров
	//получить из строки attrs массив атрибутов и их значений
function getItemAttrs($attrs){
	$attrs_arr = explode(';', $attrs);
	if (end($attrs_arr)=='') {
		array_pop($attrs_arr);
	}	
	$temp = [];
	foreach ($attrs_arr as $key => $value) {
		$attrs_arr[$key] = explode('|', $value, 2);
		$attrs_arr[$key][1] = trim($attrs_arr[$key][1]);
		if (in_array($attrs_arr[$key][0], array_column($temp, 0))) {
			$temp[$attrs_arr[$key][0]][1] += 1;
		}else{
			$temp[$attrs_arr[$key][0]] = [$attrs_arr[$key][0], 1];
		}

		$attrs_arr[$key][2] = $temp[$attrs_arr[$key][0]][1];

		if (!isset($attrs_arr[$key][1])) {
			# code...
		}elseif (end($attrs_arr[$key])=='') {
			array_pop($attrs_arr[$key]);
			$attrs_arr[$key][] = [];
		}	else{
			$attrs_arr[$key][1] = explode(' ', $attrs_arr[$key][1]);
		}
	}
	//print_arr($attrs_arr); 
	//print_arr($attrs_arr);
	return $attrs_arr;
}
function attrs_to_str($arr){
	$str = '';
	foreach ($arr as $key => $value) {
		$temp = [$value[0], implode(' ', $value[1])];
		$str .= implode('|', $temp).';';
	}
	return $str;
}
//получение массива типов модификаций
function getTypes(){
	global $connection;
	$query = "SELECT * FROM chooses_types";
	$res = mysqli_query($connection, $query);
	$arr_items = array();
	while($row = mysqli_fetch_assoc($res))
		$arr_items[$row['id']] = $row;
	return $arr_items;
}

//получение массива модификаций
function getModes(){
	global $connection;
	$query = "SELECT * FROM chooses";
	$res = mysqli_query($connection, $query);
	$arr_items = array();
	while($row = mysqli_fetch_assoc($res))
		$arr_items[$row['id']] = $row;
	return $arr_items;
}




