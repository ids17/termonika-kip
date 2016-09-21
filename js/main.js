$(document).ready(function(){
	$('.left .side_div').click(function(){
		document.location.href = "catalog.php";
	});
	$('.right .side_div').click(function(){
		document.location.href = "automation.php";
	});

	$('.left_center_button').click(function(){
		document.location.href = "aboutUs.php";
	});

	//Эффекты главной страницы
	$('.left>.semi_opacity>.side_div').hover(function(){
		$('.left>.semi_opacity').css('background-color','rgba(255,255,255,0.5)');
	},function(){
		$('.left>.semi_opacity').css('background-color','transparent');
	});

	$('.right>.semi_opacity>.side_div').hover(function(){
		$('.right>.semi_opacity').css('background-color','rgba(255,255,255,0.5)');
	},function(){
		$('.right>.semi_opacity').css('background-color','transparent');
	});

	$('.div_map,.center_div > a').hover(function(){
		$('.center_semi_opacity').css('display','block');
		$('.center_div > a').css('background-color','rgba(255,255,255,0.6)');
		$('.center_div > a').css('color','#00a9eb');
		$('.center_div > a').css('font-family','GloberBold');
	},function(){
		$('.center_semi_opacity').css('display','none');
		$('.center_div > a').css('background-color','transparent');
		$('.center_div > a').css('color','#777777');
		$('.center_div > a').css('font-family','GloberThin');
	});

});