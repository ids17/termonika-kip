$(document).ready(function(){
  $('a:not(.nav_li a)').click(function(){
    $('.wrapper').loader('show','<i class="fa fa-4x fa-spinner fa-spin"></i>');
    $('body').css({overflow: 'hidden'});
    $('.loader').animate('background-color','rgba(255,255,255,0.5)');
  })
  

	$('.accordeon').dcAccordion();

	//чекбоксы
  
	$('input.filter_item, input.choose_mode').each(function(){
		var self = $(this),
		label = self.next(),
		label_text = label.text();

		label.remove();
		self.iCheck({
			checkboxClass: 'icheckbox_line-blue',
			radioClass: 'iradio_line-blue',
			insert: '<div class="icheck_line-icon"></div>' + label_text
		});
	});
  

  if(window.location.pathname.indexOf("/about.php") >= 0 || window.location.pathname.indexOf("/automation.php") >= 0){
    $("#content").onepage_scroll({
   sectionContainer: "section",     // sectionContainer accepts any kind of selector in case you don't want to use section
   easing: "ease",                  // Easing options accepts the CSS3 easing animation such "ease", "linear", "ease-in",
                                    // "ease-out", "ease-in-out", or even cubic bezier value such as "cubic-bezier(0.175, 0.885, 0.420, 1.310)"
   animationTime: 1000,             // AnimationTime let you define how long each section takes to animate
   pagination: true,                // You can either show or hide the pagination. Toggle true for show, false for hide.
   updateURL: false,                // Toggle this true if you want the URL to be updated automatically when the user scroll to each page.
   beforeMove: function(index) {},  // This option accepts a callback function. The function will be called before the page moves.
   afterMove: function(index) {},   // This option accepts a callback function. The function will be called after the page moves.
   loop: false,                     // You can have the page loop back to the top/bottom when the user navigates at up/down on the first/last page.
   keyboard: true,                  // You can activate the keyboard controls
   responsiveFallback: false,        // You can fallback to normal page scroll by defining the width of the browser in which
                                    // you want the responsive fallback to be triggered. For example, set this to 600 and whenever
                                    // the browser's width is less than 600, the fallback will kick in.
   direction: "vertical"            // You can now define the direction of the One Page Scroll animation. Options available are "vertical" and "horizontal". The default value is "vertical".  
 });
  }


var setOpacity = function(curr, last, el_curr, el_last, elements) {
  if (last !== null) {
    $('li', '#thumbs').animate({opacity: .6});
  }
  $($('li', '#thumbs')[curr]).animate({opacity: 1});
}

var bindThumbnails = function() {
  $('a', '#thumbs').each(function() {
    $(this).unbind();
    $(this).click(function() {
      var i = $($(this).parents('li').get(0)).attr('id').substring(6);
      $('#photos').xfadeTo($('#photo-' + i));
      return false;
    });
  });
}
//слайдер фото товара
$('#photos').xfade({timeout: 10000, height: '100%', onBefore: setOpacity});
bindThumbnails();

//$('.history_img').parallax({imageSrc: 'img/ofis.png'});

//$('#info_menu').tabify();

});

$(window).load(function(){
  $('body').css({overflowY: 'visible'});
 // setTimeout(function() {
  
  $('.wrapper').loader('hide');
  //}, 1000);  
});

