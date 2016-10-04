<div id="info_out_prev">
<div id="b_info">
	
	<div id="buyer">
		<h2>Данные покупателя</h2>
		<!--<button>Являюсь получателем заказа</button><br>-->
		<?php 
			$i = 0;
			$cols = ['Название компании','ИНН','КПП','Почтовый индекс','Страна','Город','Улица','Дом','Офис','Телефон'];
			foreach ($message as $key => $value) {
				if ($i>=9 && $i<=18) {
					if ($value == 0) {
						$value = '';
					}
					echo '<div><label>'.$cols[$i-9].'</label><input type="text" value='.$value.'></div>';
				}
				$i++;
			}
		?>
	</div>
	<div id="comment_for_order">
        <p>Комментарий к заказу (желательные сроки, данные грузополучателя)</p>
	    <textarea name="" id="" cols="30" rows="10"></textarea>
	</div>
<!--
	<div id="consignee">
	
		<h3>
			Данные грузополучателя
		</h3>
		<?php 
//			$i = 0;
//			$cols = ['Название компании','ИНН','КПП','Почтовый индекс','Страна','Город','Улица','Дом','Офис','Телефон'];
//			foreach ($message as $key => $value) {
//				if ($i>=19 && $i<=28) {
//					if ($value == 0) {
//						$value = '';
//					}
//					echo '<div><label>'.$cols[$i-19].'</label><input type="text" value='.$value.'></div>';
//				}
//				$i++;
//			}
		?>

	</div>
	-->
</div>
<div id="ship_method">
	<div id="ship_items">
		<div class="ship_item">Вариант отправки</div>
		<div class="ship_item">Вариант отправки</div>
		<div class="ship_item">Вариант отправки</div>
		<div class="ship_item">Вариант отправки</div>
	</div>
</div>
<div id="next_step2">
	<i></i>
	<h4>Продолжить</h4>
</div>
</div>