
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?php echo $page_title; ?></title>
	<meta name="description" content="">

	<meta name="yandex-verification" content="dd14767fc3208e98" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="path/to/image.jpg">

	<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">

	<!-- Здесь подключаем css -->
	<link rel="stylesheet" href="css/design.css">
	<link rel="stylesheet" href="css/markup.css">
	<link rel="stylesheet" href="css/base.css">
	<link rel="stylesheet" href="libs/bootstrap/bootstrap.css">
	<link rel="stylesheet" href="css/fonts.css">
	<link rel="stylesheet" href="css/media.css">
	<link rel="stylesheet" href="libs/animate-plugin/animate.min.css">
	<link rel="stylesheet" href="libs/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/flexslider.css">
	
	<script src="libs/jquery/jquery.js"> </script>

	<!--<link href="http://allfont.ru/allfont.css?fonts=agavantgardecyr-book" rel="stylesheet" type="text/css">-->



</head>
<body>
	
	<!-- Здесь пишем код -->
	<!--<div class="preloader"></div>-->

	<div id="newPas">
		<h2>Введите новый пароль</h2>
		<form id="newPas_form">

			<div class="material-textfield blue">
				<input type="password" name="pas" required autocomplete='off'/>
				<label data-content="Новый пароль">Новый пароль</label>
			</div>

			<div class="material-textfield blue">
				<input type="password" name="pas2" required autocomplete='off'/>
				<label data-content="Повторите пароль">Повторите пароль</label>
			</div>

			<button>Подтвердить</button>
		</form>		
	</div>

	<div id="search_result">
		<div class="close"><i class='fa fa-times' aria-hidden='true'></i></div>
		<div class="search_result">
			<div>
				<h3>Начните набирать интересующую Вас категорию или название товара...</h3>
			</div>
			
		</div>
		<div class="close"><i class='fa fa-times' aria-hidden='true'></i></div>
	</div>
	<div id="logo2">
		<img class="logo2" src="img/logo.png" alt="img/logo.png">		
	</div>
	<div class="opacity"></div>
	<div class="wrapper">
		<div id="top_bar">
			<div id="address">
				<p>г. Санкт-Петербург<br>Выборгская наб., 55</p>
			</div>
			<div id="logo">
				<a href="index.html">
					<img src="img/logo.png" alt="logo">
					<h2>Термоника</h2>
				</a>
			</div>
			<div id="phone">
				<p><i class="fa fa-phone"></i> 8(812)677-56-53</p>
			</div>
		</div>
		<div id="fixed_top_bar">
			<div id="ftb">
				<nav id="left_nav">
					<a href="about.php">О нас</a>
					<a href="catalog.php">Продукция</a>
				</nav>

				<form id="search_form" name="form" method="post" action="">
					<input id="search_input" type="text" name="query" placeholder="Поиск" list="datalist" autocomplete="off">
					
					<button id="search_button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
					
				</form>
				<nav id="right_nav">
					<a href="automation.php">Автоматизация</a>
					<a href="contacts.php">Контакты</a>
				</nav>
			</div>

			<button id="cart_button"></button>

		</div>
		<div id="content">
			<?php echo $content; ?>
		</div>

	</div>
	<!-- <div id="footer"><h1></h1></div> -->
</div>

<div class="hidden">
	
</div>

<div class="mobile_wrap"></div>

<!-- Код заканчивается -->

	<!--[if lt IE 9]>
	<script src="libs/html5shiv/es5-shim.min.js"></script>
	<script src="libs/html5shiv/html5shiv.min.js"></script>
	<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
	<script src="libs/respond/respond.min.js"></script>
	<![endif]-->

	<script src="libs/animate-plugin/jquery.waypoints.min.js"></script>
	<script src="libs/animate-plugin/animate-css.js"></script>
	<script src="libs/bootstrap/bootstrap.js"></script>

<!-- Скрипт для активирования работы вкладок 
<script>
$(function() {
  $('#tab-product a:last').tab('show')
});
</script>
-->

	<script src="libs/accordion/jquery.accordion.js"></script>
	<script src="libs/jq.cookie/jquery.cookie.js"></script>
	<script src="libs/materialize-src/js/bin/materialize.min.js"></script>
	<script src="libs/enllax.js-master/jquery.enllax.min.js"></script>
	<!-- <script src="libs/xfade/jquery.xfade-1.0.min.js"></script> -->
	<script src="libs/Center-Loader/center-loader.min.js"></script>
	<!--<script src="libs/parallax.js-master/parallax.min.js"></script>-->
	<!-- <script src="js/imagezoom.js"></script> -->
	<script src="js/jquery.flexslider.js"></script>
	<script src="js/jquery.jrumble.1.3.min.js"></script>
	
	<script src="js/setParam.js"></script>
	<script src="js/setPlugins.js"></script>
	<!--<script src="js/historyAPI.js"></script>-->
	<script src="js/common.js"></script>

</body>
</html>