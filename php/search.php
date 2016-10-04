<?php
include 'config.php';
include 'template.php';

$category = get_categories();

header("Content-type: text/html; charset=utf-8");
$string = $_POST['query'];
$string = trim($string);   
$string = mysqli_real_escape_string($connection, $string);
$string = htmlspecialchars($string);

if($string == ''){
	echo "Начните набирать интересующую Вас категорию или название товара...";
}
else{
    
    $search_arr = explode(' ',$string);
    
    $where = '';
    $where2 = '';
    foreach ($search_arr as $key => $query) {
    	$where .= " (daughter LIKE '".$query."%' || daughter LIKE '% ".$query."%') &&";
      $where2 .= " (name LIKE '".$query."%' || name LIKE '% ".$query."%') &&";
    }
    $where = substr($where, 0, -3);
    $where2 = substr($where2, 0, -3);   
    
	//сортировка по rating по убыванию
	function cmp($a, $b){
		return ($b['rating']-$a['rating']);
	}

	//$q1 = "SELECT daughter, image, id, rating FROM category WHERE daughter LIKE '".$query."%' OR daughter LIKE '% ".$query."%'";
	$q1 = "SELECT daughter, image, id, rating FROM category WHERE".$where;
	$res1 = mysqli_query($connection,$q1);
	if(mysqli_num_rows($res1) > 0){
		//$sql = mysqli_fetch_array($res);
		while($sql = mysqli_fetch_array($res1)){
			$category_search[$sql['id']] = $sql;
		}
		usort($category_search, "cmp");
	}
	
	//$q2 = "SELECT name, image, id, rating FROM owen WHERE name LIKE '".$query."%' OR name LIKE '% ".$query."%'";
	$q2 = "SELECT name, image, id, rating FROM owen WHERE".$where2;
	$res2 = mysqli_query($connection,$q2);
	if(mysqli_num_rows($res2) > 0){
		$sql = mysqli_fetch_array($res2);
		//do{echo "<option value='".$sql['name']."' label='".$sql['name']."'></option>";}
		do{
			$items_search[$sql['id']] = $sql;
			//print_arr($items_search[$sql['id']]);
		}
		while($sql = mysqli_fetch_array($res2));
		usort($items_search, "cmp");
	}

	$ToF=mysqli_num_rows($res1)+mysqli_num_rows($res2)<=5;
	
	if (mysqli_num_rows($res1)+mysqli_num_rows($res2)==0) {
		echo '<h3 class="empty_search">Результаты поиска отсутствуют.</h3><hr class="empty_search"><h3 class="empty_search">Не нашли нужный товар?</h3>
		<p class="empty_search">Оставьте заявку, и мы постараемся найти то, что Вам нужно, или подберем достойный аналог.</p>
		<form class="form">
			<input type="hidden" name="project_name" value="Термоника">
			<input type="hidden" name="admin_email" value="eguzman@yandex.ru">
			<input type="hidden" name="form_subject" value="Запрос товара">
			<div class="material-textfield blue">
					<input type="text" name="name" required autocomplete="off"/>
					<label data-content="Представьтесь, пожалуйста">Представьтесь, пожалуйста</label>
				</div>
				<div class="material-textfield blue">
					<input type="text" name="email" required autocomplete="off"/>
					<label data-content="Ваш e-mail">Ваш e-mail</label>
				</div>
			<textarea name="question" rows="5" cols="45" wrap="soft" placeholder="Расскажите, что Вам нужно" required="true"></textarea>
			<button> 
				<p>Отправить заявку</p>
			</button>
			<p id="response"></p>
		</form>';
	}else{
		echo "<h3>Категории</h3>";
		if (!@$category_search[0]) {
			echo "Подходящих категорий нет";
		}else{
			$i=0;
			while($i<5 && @$category_search[$i]){
				// if ($ToF) {
				// 	echo "<img src='img/category/".$category_search[$i]['image']."' alt='".$category_search[$i]['image']."'>";
				// }
				//$string = ;
				echo "<a href='catalog.php?cat=".$category_search[$i]['id']."'>".$category_search[$i]['daughter']."</a><br>";
				$i++;
			}
		}

		echo "<h3>Товары</h3>";
		if (!@$items_search[0]) {
			echo "Подходящих товаров нет";
		}else{
			$i=0;
			while ($i<10 && @$items_search[$i]) {
				if ($ToF) {
					$image = explode(',', $items_search[$i]['image'], 2);
					echo "<img height='100px' src='img/items/".$image[0]."' alt='".$image[0]."'>";
				}
				echo "<a href='catalog.php?item=".$items_search[$i]['id']."'>".$items_search[$i]['name']."</a></br>";
				$i++;
			}
		}
	}
}


?>

