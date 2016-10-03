<div id="full_login">
	<div id="forgetPas_popup">
		<button id="close_FP">Закрыть</button>
		<h2>Восстановление пароля</h2>
		<p>Введите Ваш e-mail</p>
		<form id="forgetPas_form">
			<input type="text" name="forgetPas_email" placeholder="E-mail" autocomplete="off" required autofocus>
			<button>Отправить ссылку на восстановление</button>
		</form>
	</div>
	<div id="login">
		<h3>Вход</h3>
		<form id="login_form"> 
			<label>Email</label>
			<input type="text" name="email" placeholder="" autocomplete="off">
			<label>Пароль</label>
			<input type="password" name="password" placeholder="" autocomplete="off">
			<p id="forgetPas_but">Восстановление пароля</p>
			<button type="submit" name="submit" class="login_button">Войти</button>
		</form>
	</div>
</div>

<div id="registration">
	<h3>Регистрация</h3>
	<form id="registration_form">
		<p id="reg_response"></p>
		<div class="reg_input">
			<label>Имя</label>
			<input type="text" size="20" name="name" autocomplete="off" required="true">
		</div>
		<div class="reg_input">
			<label>E-mail</label>
			<input type="text" size="20" name="email" autocomplete="off" required="true">
		</div>
		<div class="reg_input">
			<label>Пароль</label>
			<input id="pass1" type="password" size="20" maxlength="20" name="password" autocomplete="off" required="true">
		</div>
		<div> 
			<button type="submit" name="submit" class="login_button">Зарегистрироваться</button>
		</div>
	</form>
</div>
