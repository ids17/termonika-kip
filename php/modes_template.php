<div id="full_modes">
	<div id="modes">
		<div class="modes">
			<?php
			foreach ($message as $key => $value) {
				echo '<div>';
				echo '<h4>'.$value['mode'].'</h4>';
				echo '<h4>'.$value['price'].'</h4>';
				echo '<button class="choose_mode '.$key.'">Выбрать</button>';
				echo '</div>';
			}
			?>
		</div>
		<div class="prompt">
			123
		</div>
	</div>
</div>