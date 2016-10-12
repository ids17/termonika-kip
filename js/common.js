// $('.preloader').css('display','block');

$(window).load(function(){

	if (window.location.pathname.indexOf("/about.php") >= 0 
		|| window.location.pathname.indexOf("/contacts.php") >= 0 
		|| window.location.pathname.indexOf("/automation.php") >= 0 
		|| window.location.pathname.indexOf("/articles.php") >= 0)
	{
		$('#footer').css('display','none');
		$('#top_bar').css({top: '0', position: 'fixed',zIndex: '899',background: 'rgba(231,231,231,.9)'});
		$('#fixed_top_bar').css({top: '60px', position: 'fixed',background: 'rgba(255,255,255,.8)'});
		var tbH = $('#top_bar').innerHeight();
		var ftbH = $('#fixed_top_bar').innerHeight();
		$('.contacts').css({paddingTop: tbH + ftbH});
		$('.big_map').css({paddingTop: tbH + ftbH});
		if (window.location.pathname.indexOf("/contacts.php") >= 0 
		|| window.location.pathname.indexOf("/articles.php") >= 0){
			$('body').css({overflow: "hidden"});
		}	
	}

	if (window.location.pathname.indexOf("/catalog.php") >= 0) {
		document.getElementById('cart_button').innerHTML = 
			'<i class="fa fa-shopping-basket" aria-hidden="true"></i>';
	}

	//newPassword popup
	if (window.location.search.indexOf("token=") >= 0) {
		var token = window.location.search.slice(7);
		window.history.pushState(null, null, '/termonika-kip/catalog.php');
		$('#newPas_form').append('<input type="hidden" name="token" value="' + token + '">');
		$('#newPas').css({display: 'flex'});
		$('body').css({overflowY: 'hidden'});
		var temp = "";
		var s1, s2;
		s1 = s2 = 0;
		$('#newPas_form input').change(function(){
			switch(this.name){
				case "pas":
					if (this.value.match(/[A-Za-z0-9]{8,}/)) {
						$(this).css({border:'1px solid #82FA58'});
						temp = this.value;
						s1 = 1;
					} else {
						$(this).css({border:'1px solid tomato'});
					}
					break
				case "pas2":
					if (this.value !== "") {
						if(this.value === temp){
							$(this).css({border:'1px solid #82FA58'});
							s2 = 1;
						} else {
							$(this).css({border:'1px solid tomato'});
						}
					} else {
						$(this).css({border:'1px solid rgba(0, 0, 0, 0.2)'});
					}
					break
				default:
			}
		});

		$('#newPas_form').submit(function(){
			if (s1 + s2 === 2) {
				var th = $(this);
				$.ajax({
					type: "POST",
					url: "php/newPas.php",
					data: th.serialize()
				}).done(function(response){
					if (response !== '0') {
						document.getElementById('newPas').innerHTML = response;
					} else {
						document.getElementById('newPas').innerHTML = 
							'Ошибка. Запросите восстановление еще раз';
					}
					setTimeout(function() {
						$('#newPas').fadeOut('slow');
						$('body').css({overflowY: 'visible'});
						showCart();
						th.trigger("reset");
					}, 2500);
				});
				return false;
			} else {
				return false;
			}
		});
	}

	//прелоадер скрыть
	//$('.preloader').fadeOut('slow');

	$('.form input').focus(function(){
		$(this).data('placeholder',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	});
	$('.form input').blur(function(){
		$(this).attr('placeholder',$(this).data('placeholder'));
	});

	//.close opacity
	$('.close').hover(function(){
		$('#search_result').css({backgroundColor:'rgba(231,231,231,.9)',transition:'all 0.2s 0.05s ease-in'});
	},function(){
		$('#search_result').css({backgroundColor:'rgba(231,231,231,1)',transition:'all 0.2s 0.05s ease-in'});
	});

	//E-mail Ajax Send
	$(".form").submit(function() { //Change
		var th = $(this);
		$.ajax({
			type: "POST",
			url: "php/mail.php", //Change
			data: th.serialize()
		}).done(function() {
			document.getElementById('response').innerHTML = "Спасибо за заявку";
			$('#response').css('display','block');
			setTimeout(function() {
				// Done Functions
				th.trigger("reset");
			}, 500);
		});
		return false;
	});

	//попап поиска
	function setSearchResult() {
		if ($("div").is("#breadcrumbs")){
			$('#search_result').css({top: $('#breadcrumbs').position().top});
			var height = $('#breadcrumbs').position().top;
			$('#search_result').css({height: $(window).height() - height});
		} else {
			$('#search_result').css({height: $(window).height() - 110});	
		}
	}

	$('#search_input').click(function() {
		if($("div").is("#cart")){
			$('#cart').fadeOut('slow');
			setTimeout(function() {
				$('#cart').remove();
				$('#cart_button').removeClass('opened');
			}, 500);
		}
		setSearchResult();
		$('#search_result').fadeIn();
		$('#search_result').css({display: 'flex'});
		$('body').css('overflow','hidden');
		
	});

	$(window).resize(function(){
		setSearchResult();
	});

	//закрытие попапов
	$('.close').click(function() {
		$('#search_result').fadeOut();
		//$('.price_popup').fadeOut();
		//$('.question_popup').fadeOut();
		//$('#user i').css('cursor','pointer');
		//$('.wrapper').css('opacity',1);
		$('body').css('overflow-y','visible');
	});

	// таблица товара
	$('#tab-product li:first-child').addClass('active');
	var activeTab = $('#tab-product li:first-child').children('a').attr('href');
	$(activeTab).addClass('active');
	$('#tab-product li').click(function() {
		var hideTab = $('#tab-product li.active').children('a').attr('href');
		$(hideTab).removeClass('active');
		$('#tab-product li.active').removeClass('active');
		$(this).addClass('active');
		var activeTab = $(this).children('a').attr('href');
		$(activeTab).addClass('active');
		return false;
	});

	//ajax поиск
	$('#search_form').submit(function(){
		return false;
	});

	$("#search_input").keyup(function(I) {
		switch(I.keyCode){
			case 13: 
				return false; //enter
			case 27: 
				$('#search_result').css('display','none'); //esc
				break;
			case 38: 
				//вверх
				break;
			case 40: 
				//вниз
				break;
			default:
				//$('.search_result').css('display','block');
				var search = $("#search_input").val();
				//alert(search);
				$.ajax({
					type: "POST",
					url: "php/search.php",
					data: {"query": search},
					cache: false,                                
					success: function(response) {
						setTimeout(function() {
							$(".search_result div").html(response);
							//E-mail Ajax Send
							$(".form").submit(function() { //Change
								var th = $(this);
								$.ajax({
									type: "POST",
									url: "php/mail.php", //Change
									data: th.serialize()
								}).done(function() {
									document.getElementById('response').innerHTML 
										= "Спасибо за заявку";
									$('#response').css('display','block');
									setTimeout(function() {
										// Done Functions
										th.trigger("reset");
									}, 500);
								});
								return false;
							});
						}, 500);
					}
				});
				return false;
		};
	});

	/*$('input.filter_item').click(function(){
		alert(this.name);
		//alert(this.name);
	});*/

	$('input.filter_item').on('ifChanged', function(event) {
		//alert(event.target.value + ' callback');
		//alert($(this).parents().attr('class'));
		//alert (param);
		$.ajax({
			type: "POST",
			url: "php/filter.php", 
			data: {
	    		id: this.value,
	    		param: $(this).parents().parents().attr('class'),
	    		cid: window.location.search
	  		}
		}).done(function(response) {
			//$('#addToCart').addClass('successButton');
			document.getElementById('divs').innerHTML = response;
			//window.history.pushState(null, null, url);
		});

		//добавляем в сессию массив, в него переменную this.value
		//аяксом передаем в скрипт где возвращаем getnavigationdivs
		//вместо существующего блока категорий выводим новый
		var input_arr = [];
  		$('input.filter_item').each(function(input_arr) {
			//alert($(this).parents().attr('class'));
			/*if ($(this).parents().hasClass('hover')) {
				input_arr[0] = this.name; 
			}*/
			return input_arr;
		});
  		//alert(input_arr);
  	});


	//обработка нажатия на корзину
	$('#cart_button').click(function() {
		$('#search_result').fadeOut();
		if ($('#cart_button').hasClass('opened')) {
			$('#cart').fadeOut('slow');
			$('body').css({overflowY: 'visible'});
			setTimeout(function() {
				$('#cart').remove();
				$('#cart_button').removeClass('opened');
			}, 500);
		} else {
			showCart();
		}
	});


	//Отображение корзины
	function showCart(){
		$.ajax({
			type: "POST",
			url: "php/cart.php"
		}).done(function(response) {
			$('body').append('<div id="cart"></div>');
			$('#cart').fadeOut(0).append(response).fadeIn('slow');
			$('#cart').fadeIn('slow');
			$('#cart_button').addClass('opened');
			$('body').css({overflow: 'hidden'});
			if($("div").is("#breadcrumbs")){
				$('#cart').css({top: $('#breadcrumbs').position().top});
			}
			var stepH = 0;
			if($("div").is("#next_step1")) {
				stepH = $("#next_step1").innerHeight();
			}
			$('.help_out_next').css({minHeight: $('#cart_info').innerHeight()-stepH});
				
			//Оформление заказа
			$('#next_step1').bind('click', function() {
				// !? проверять на наличие товаров в корзине
				$.ajax({
					type: "POST",
					url: "php/buyer_info.php"
				}).done(function(response) {
					$('#cart').append(response);
					/*if($('#cart').position().left == 0 ){
						$('#cart').animate({left:'-100%'},'slow');
					}else{
						$('#cart').animate({left: $('#cart').position().left * 2},'slow');
					}*/
					//$('#cart').css({"transform" : "translate(25%, 0%)"});
					$('#cart').animate({left:'-100%'},'slow');
					$('.back_prev').click(function() {
						$('#cart').animate({left: $('#cart').position().left + $('body').width()},'slow');
					});

					$('#next_step2').click(function() {
						$('#cart').animate({left:'-200%'},'slow');
						$('.confirm_div button').click(function() {
							$.ajax({
								type: "POST",
								url: "php/confirm_order.php"
							}).done(function(response){
								alert(response);
							});
						});
					})
					//$('#cart').css({left: '-100%'});
				});
			});

			//Login Ajax
			$("#login_form").submit(function() { //Change
				var th = $(this);
				$.ajax({
					type: "POST",
					url: "php/login.php", //Change
					data: th.serialize()
				}).done(function(response) {
					//alert(response);
					if (response==='') {
						$('#cart').remove();
						showCart();
					} else {
						if ($("p").is("#login_response")){
							$('#login_response').remove();
						}
						$('#forgetPas_but').before('<p id="login_response" style="color:tomato;">' + response + '</p>');
					}
					setTimeout(function() {
						// Done Functions
						//th.trigger("reset");
					}, 500);
				});
				return false;
			});
				
			//выход
			$('.exit_button').click(function(){
				$.ajax({
					type: "POST",
					url: "php/exit.php"
				}).done(function(){
					$('#cart').remove();
					showCart();
				});
			});
	
			//добавление комментария
			$(".comment").change(function() {
				$.ajax({
					type: "POST", 
					url: "php/change_cart_comment.php", 
					data: {
						id: $(this).parents().parents().attr('id'),
						comment: this.value
					}
				}).done(function(response) {});
			});
				
			//удаление товара из корзины
			$('.delete_button').click(function(){
				$.ajax({
					type: "POST",
					url: "php/delete_from_cart.php",
					data: {
						id: $(this).data('item-id')
					}
				}).done(function(response){
		
				});
				var del_item = $(this).parent().parent();
				del_item.fadeOut('slow');
				setTimeout(function() {
					del_item.remove();
					if(!$("tr").is(".cart_item")){
						$('#next_step1').remove();
						$('.out_next').append('<p>Список пуст</p>')
					}	
				}, 400);
			});
				
			//изменение количества товара
			$('.cart_item_input').change(function() {
				$.ajax({
					type: "POST",
					url: "php/change_item_amount.php",
					data: {
						id: $(this).parents().parents().attr('id'),
						value: this.value
					}
				}).done(function() {});
			});
			
			/*
			$('.block').change({a:12, b:"abc"}, function(eventObject) {
  				var externalData = "a=" + eventObject.data.a + ", b=" + eventObject.data.b;
  				alert('Элемент с классом block был изменен. '+
        			'В обработчик этого события переданы данные: ' + externalData );
			});
			*/
			
			//закрытие корзины
			$('#close_button').click(function() {
				$('#cart').fadeOut('slow');
				$('body').css({overflowY: 'visible'});
				setTimeout(function() {
					$('#cart').remove();
					$('#cart_button').removeClass('opened');
				}, 500);
			});


			//forgetPassword
			$('#forgetPas_but').click(function() {
				$('#login').fadeOut();
				$('#forgetPas_popup').animate({left:'0px'},'slow');
			});

			$('#close_FP').click(function(){
				$('#login').fadeIn();
				$('#forgetPas_popup').animate({left:'-100%'},'slow');
			});

            
			//проверка данных на регистрацию
			$('#cart').on('keyup blur', '#registration input', function() { 
				//correct = true;
				switch(this.name) {
					case "name":
						if (this.value != ""){
                            $(this).addClass('correct');
                            $(this).removeClass('incorrect');
                        } else{
                            correct = false;
                            $(this).addClass('incorrect');
                            $(this).removeClass('correct');
                        }
						break;
					case "email":
						if (this.value.match(/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,}$/)) {
                            $(this).addClass('correct');
                            $(this).removeClass('incorrect');
                        }else{
                            $(this).addClass('incorrect');
                            $(this).removeClass('correct');
                        }
						break;
					case "password":
						if (this.value.match(/[A-Za-z0-9]{8,}/)) {
							$(this).addClass('correct');
                            $(this).removeClass('incorrect');
						} else {
                            $(this).addClass('incorrect');
                            $(this).removeClass('correct');
						}
						break;
					default:	
				}
                
//				if (correct) {
//					$(this).removeClass("incorrect");
//					$(this).addClass("correct");
//				} else {
//					return false;
//				}
			});
            //alert (correct);

			//валидация регистрационных данных и отправка запроса
			$("#registration_form").submit(function(correct) {

				var validity = true;
				$("#registration input").each(function() {
					if (!$(this).hasClass("correct")){
						validity = false;
					}
				});
				
				if (validity) {
					var th = $(this);
					$.ajax({
						type: "POST",
						url: "php/verification.php",
						data: th.serialize()  
					}).done(function(response) {
						setTimeout(function() {
                            //alert(response);
							if (parseInt(response) === 1) {
								document.getElementById('reg_response').innerHTML = 
									'Пользователь с таким e-mail уже существует. Вы можете войти на сайт или восстановить пароль.';
                                $('#reg_response').css({color: 'tomato'});
								$('#reg_response').fadeIn('fast');
								$('#reg_response').addClass('error_message');
								$('#reg_response').removeClass('success_message');
							} else if (parseInt(response) === 2) {
								document.getElementById('reg_response').innerHTML = 
									'Поздравляем с успешной регистрацией! Теперь можете войти на сайт.';
                                $('#reg_response').css({color: 'green'});
								$('#reg_response').fadeIn('fast');
								$('#reg_response').addClass('success_message');
								$('#reg_response').removeClass('error_message');
							}
							$('#registration input').css({border: "none"});
						}, 500);
					});                  
				}
                return false;
			});

			//E-mail Forget Password
			$("#forgetPas_form").submit(function() { 
				var th = $(this);
				$.ajax({
					type: "POST",
					url: "php/recoverPas.php", 
					data: th.serialize()
				}).done(function(response) {
					$('#forgetPas_popup p').html(response);
					//document.getElementById('response').innerHTML = "Спасибо за заявку";
					//$('#response').css('display','block');
					setTimeout(function() {
						// Done Functions
						th.trigger("reset");
					}, 500);
				});
                return false;
			});
		});
	}

	
	//добавление в корзину
	$('#addToCart').click(function() {

		var choosen_mode = '';

		if ($(this).hasClass('buy_mode')) {
			$(this).prev().find('.modes_col').each(function(){
				//находим выбранные моды, формируем строку type-id|mode_id,...
				choosen_mode += $(this).data('type-id') + '|';
				$(this).find('.checked').each(function(){
					choosen_mode += $(this).children('.choose_mode').data('mode-id') + ',';
					return;
				});
			});
		}
		choosen_mode = choosen_mode.slice(0,-1);
		//alert(choosen_mode);
		var id = $(this).data('item-id');

		$.ajax({
			type: "POST",
			url: "php/add_to_cart.php", 
			data: {
	        	id: id,
	        	choosen_mode: choosen_mode 
	        }
		}).done(function(response) {
			//alert(response);
			$('#addToCart').addClass('successButton');
			document.getElementById('addToCart').innerHTML = 'Добавлено';

 			$('#cart_button').trigger('startRumble');

 			setTimeout(function(){
 				 $('#cart_button').trigger('stopRumble');
 			}, 1000);

			setTimeout(function() {
				$('#addToCart').removeClass('successButton');
				document.getElementById('addToCart').innerHTML = 'В список покупок';
			}, 5000);
		});
	});


	//выбор модификаций
	$('.button_modes').click(function(){

		$('.choose_modification').fadeToggle('slow');
		// $('.table-striped').find('.modes_col').each(function(){
		// 	$(this).find('.mode_block:first-child').find('.choose_mode').iCheck('check');
		// });

		// $.ajax({
		// 	type: "POST",
		// 	url: "php/get_modes.php", 
		// 	data: {
		// 		id: window.location.search
		// 	}
		// }).done(function(response) {
		// 	$('body').prepend(response);
		// 	$('#full_modes').fadeIn('slow').css({display: 'flex'});
		// 	$('body').css({overflowY: 'hidden'});
		// 	$('#full_modes').css({top: $('#breadcrumbs').position().top});
		// 	$('#close_modes, #full_modes').click(function() {
		// 		$('#full_modes').fadeOut('slow');
		// 		$('body').css({overflowY: 'visible'});
		// 		setTimeout(function() {
		// 			$('#full_modes').remove();
		// 		}, 1000);
		// 	});
				
		// 	//добавление в корзину
		// 	$('.choose_mode').click(function() {
		// 		//TODO
		// 	});
		// });
	});


	//корректировка работы xfade в items
	var imgSW = $('#photos li').width();
	//alert($('.img_info').width());
	$('#photos').css({height: imgSW});
	//$('.img_set img').each(function(indx){
		//var imgH= $(this).height();
		//$(this).css({padding: (imgSW/2 - imgH)/2 + "px 15px"});
	//});
	//alert(tops);


	//параллакс в статьях
	$('#article').scroll(function() {
		var st = $(this).scrollTop();
		//console.log(st);
		//alert(st);
		$('#art_main_img img').css({
			"transform" : "translate(0%, " + -st/10 + "%)"
		});
	});

		//анимация секции automation в about
		$('.automation_title').hover(function(){
			$(this).css({backgroundColor: 'rgba(100, 100, 100, 0.6)'});
			$(this).prev().css({height: '100%'}).fadeIn('slow');
		},function(){
			$(this).css({backgroundColor: 'rgba(255, 255, 255, 0.6)'});
			$(this).prev().fadeOut('slow');
		});

});
