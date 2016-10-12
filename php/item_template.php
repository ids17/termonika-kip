<div>
	<h1 class='items_name'>
		<?=$message['$item']['name'];?>
	</h1>
	<hr>
</div>
<div class='flex_row'>
	<div class='main_info'>
		<div class="buttons_div">
			<div class='flex_row'>
				<?=$message['$item']['price'];?>
				<?=$message['$item']['modes'];?>
			</div>

			<div class=''>
				<button class='button question_button modal-trigger' data-target='ask-question'><i class="fa fa-question" aria-hidden="true"></i>Задать вопрос</button>
				<!-- <?php print_arr($message['$item']['attrs_arr']);?> -->
				<?=$message['$item']['attrs'];?>
			</div>
		</div>
		
		<div class='short_info'>
			<?=$message['$item']['descr'];?>
			<!--<img src='img/oven.png' alt=''><img src='img/proma.png' alt=''>-->
		</div>
	</div>
	<div class='img_info'>
		<div id='img_set'>
			<?=$message['$photos'];?>
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
						<?=$message['$item']['description'];?>
					</div>
				</div>
				<div id='specifications' class='tab-pane'>
					<div class='user-content'>
						<?=$message['$item']['specifications'];?>
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

<!-- Modal Structure -->
<div id="know-price" class="modal bottom-sheet">
	<div class="modal-content">
		<h4>Укажите необходимую модификацию, и мы пришлем Вам цену и сроки поставки.</h4>
		<hr>
		<form class="form">
			<input type="hidden" name="project_name" value="Термоника">
			<input type="hidden" name="admin_email" value="eguzman@yandex.ru">
			<input type="hidden" name="form_subject" value="Узнать цену">
			<div class="material-textfield blue">
				<input type="text" name="name" required autocomplete="off"/>
				<label data-content="Представьтесь, пожалуйста">Представьтесь, пожалуйста</label>
			</div>
			<div class="material-textfield blue">
				<input type="text" name="email" required autocomplete="off"/>
				<label data-content="Ваш e-mail">Ваш e-mail</label>
			</div>
			<button> 
				<p>Отправить заявку</p>
			</button>
			<p id="response"></p>
		</form>
	</div>

</div>

<div id="ask-question" class="modal bottom-sheet">
	<div class="modal-content">
		<h4>Задайте любой вопрос касаемо данного товара, будь то вопрос технического характера или запрос наличия или сроков поставки.</h4>
		<hr>
		<form class="form">
			<input type="hidden" name="project_name" value="Термоника">
			<input type="hidden" name="admin_email" value="eguzman@yandex.ru">
			<input type="hidden" name="form_subject" value="Вопрос по товару">
			<div class="material-textfield blue">
				<input type="text" name="name" required autocomplete="off"/>
				<label data-content="Представьтесь, пожалуйста">Представьтесь, пожалуйста</label>
			</div>
			<div class="material-textfield blue">
				<input type="text" name="email" required autocomplete="off"/>
				<label data-content="Ваш e-mail">Ваш e-mail</label>
			</div>
			<textarea name="question" rows="5" cols="45" wrap="soft" placeholder="Ваш вопрос" required="true"></textarea>
			<button> 
				<p>Отправить заявку</p>
			</button>
			<p id="response"></p>
		</form>
	</div>
</div>