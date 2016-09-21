<div>
	<h1 class='items_name'>
		<?=$message['$items'][$message['$iid']]['name'];?>
	</h1>
	<hr>
</div>
<div class='flex_row'>
	<div class='main_info'>
		<div class="buttons_div">
			<div class='flex_row'>
				<?=$message['$items'][$message['$iid']]['price'];?>
				<?=$message['$items'][$message['$iid']]['modes'];?>
			</div>

			<div class=''>
				<button class='button question_button'><i class="fa fa-question" aria-hidden="true"></i>
Задать вопрос</button>
			</div>
		</div>
		
		<div class='short_info'>
			<?=$message['$items'][$message['$iid']]['descr'];?>
			<!--<img src='img/oven.png' alt=''><img src='img/proma.png' alt=''>-->
		</div>
	</div>
	<div class='img_info'>
		<div id='img_set'>
			<?=$message['$photos'];?>
			<?=$message['$thumbs'];?>
		</div>
	</div>
</div>
<div class='row one_row'>
	<div class='col-md-11' id='full_info'>
		<div class='row one_row'>
			<ul id='tab-product' class='nav nav-tabs responsive properties hidden-xs hidden-sm'>
				<li class='nav_li'><a href='#description'>Описание</a></li>
				<li class='nav_li'><a href='#specifications'>Технические характеристики</a></li>
				<li class='nav_li'><a href='#application'>Применение</a></li>
				<li class='nav_li'><a href='#documentation'>Документация</a></li>
			</ul>
		</div>
		<div class='row item_info_column one_row'>
			<div class='tab-content responsive hidden-xs hidden-sm'>
				<div id='description' class='tab-pane'>
					<div class='user-content'>
						<?=$message['$items'][$message['$iid']]['description'];?>
					</div>
				</div>
				<div id='specifications' class='tab-pane'>
					<div class='user-content'>
						<?=$message['$items'][$message['$iid']]['specifications'];?>
					</div>
				</div>
				<div id='application' class='tab-pane'>
					<div class='user-content'>
						<p>789</p>
					</div>
				</div>
				<div id='documentation' class='tab-pane'>
					<div class='user-content'>
						<?=$message['$docs'];?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
