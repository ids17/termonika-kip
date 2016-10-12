$(document).ready(function(){
	// $('.container-fluid').loader('show','<i class="fa fa-4x fa-spinner fa-spin"></i>');
	// $('body').css({overflow: 'hidden'});
	// $('.loader').animate('background-color','rgba(255,255,255,0.5)');

	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,

		fixedContentPos: false
	});
});

$(window).load(function(){
	// setTimeout(function() {
	// 	$('body').css({overflowY: 'visible'});
	// 	$('.container-fluid').loader('hide');
	// }, 500);	
});