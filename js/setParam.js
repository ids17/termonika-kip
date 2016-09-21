$(document).ready(function(){

	if(window.location.pathname.indexOf("/catalog.php") >= 0){

		var tbH = $('#top_bar').innerHeight();
		var ftbH = $('#fixed_top_bar').innerHeight();
		var bcH = $('#breadcrumbs').innerHeight();
		$('.logo2').height(ftbH);
		//var height = $('#divs').innerHeight() + ftbH;
		//$('#footer').css({top: height});
		/*var width = $('body').width() * 0.25;
		$('#sidebar').css({width: width});*/

		setParam();

		$(window).scroll(function() {
			setParam();
		});

		$(window).resize(function(){
			/*var width = $('body').width() * 0.25;
			$('#sidebar').css({width: width});*/
			setParam();
		});
	}

	function setParam(){
		var width = $('body').width() * 0.25;
		$('#sidebar').css({width: width});
		$('#divs').css({marginLeft: width});
		$('.hide_scrollbar').css({left: $('#sidebar').width() - $('.hide_scrollbar').width()});
		//var top = window.pageYOffset;
		var top = $(window).scrollTop();

		var comfortPad = 20;

		if (top < tbH) {
			$("#fixed_top_bar").css({position: 'relative'});
			$("#logo2").css({top: tbH - top});

			var sbTop = tbH + ftbH - top;

			$("#divs").css({paddingTop: bcH + comfortPad});
			//$("#logo2").animate({left: '-98px'},'slow');
			//$("#logo2").css({left: '-98px'});
			if (top === 0) {	
				$("#logo2").fadeOut('slow');
			}
		}
		else{
			//позиция #fixed_top_bar
			$("#fixed_top_bar").css({top: '0', position: 'fixed'});
			$("#logo2").css({top: '0'});

			var sbTop = ftbH;
			//$("#sidebar").css({top: sbTop});
			//$("#breadcrumbs").css({top: sbTop});

			//bottom у #sidebar
			var bottom = $(window).height() + top;
			var height = $(document).height() - $('#footer').height();

			if(bottom > height){
				$('#sidebar').css({bottom: bottom-height}); 
			}
			else {
				$('#sidebar').css({bottom: '0px'});
			}
			$("#divs").css({paddingTop: ftbH + bcH + comfortPad});

			//$('#logo2').animate({left: '0'},'slow');
			//$("#logo2").css({left: '0px'});
			$("#logo2").fadeIn('slow');
		}

		$('#divs').css({minHeight: $(window).height()-sbTop-$('#footer').innerHeight()});
		if (top<tbH) {
			var height = $('#divs').innerHeight() + tbH + ftbH;
		}else{
			var height = $('#divs').innerHeight() + tbH;
		}
		//alert(height);
		//var height = $('#divs').innerHeight() + tbH;
		$('#footer').css({top: height});

		$("#sidebar").css({top: sbTop});
		$('.hide_scrollbar').css({top: sbTop});
		$("#breadcrumbs").css({top: sbTop});
		/*function setBreadcrumbs(){
			if (true) {}
		}*/
	}

});


