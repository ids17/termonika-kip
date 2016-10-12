$(document).ready(function(){

    // $('.wrapper').loader('show','<i class="fa fa-4x fa-spinner fa-spin"></i>');
    // $('body').css({overflow: 'hidden'});
    // $('.loader').animate('background-color','rgba(255,255,255,0.5)');
 //      $('body').css({overflowY: 'visible'});
 // // setTimeout(function() {

 //  $('.wrapper').loader('hide');
 //  //}, 1000);


 $('.accordeon').dcAccordion();

 $('.flexslider').flexslider({
  animation: "slide",
  controlNav: "thumbnails"
});

	//чекбоксы

	$('input.filter_item').each(function(){
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

  // $('input.choose_mode').each(function(){
  //   var self = $(this),
  //   label = self.next(),
  //   label_text = label.text();

  //   label.remove();
  //   self.iCheck({
  //     checkboxClass: 'icheckbox_square-blue',
  //     radioClass: 'iradio_square-blue',
  //     insert: '<div class="icheck_square-icon"></div>' + label_text
  //   });
  // });

  $('.modal-trigger').leanModal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
      starting_top: '4%', // Starting top style attribute
      ending_top: '10%', // Ending top style attribute
      //ready: function() { alert('Ready'); }, // Callback for Modal open
      //complete: function() { alert('Closed'); } // Callback for Modal close
    }
    );

  if(window.location.pathname.indexOf("/about.php") >= 0 || window.location.pathname.indexOf("/automation.php") >= 0){
    if ($('body').width() > 900) {
      $('body').css({overflow: "hidden"});

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
    }else{
      if (window.location.pathname.indexOf("/catalog.php") >= 0) {
        $('input.choose_mode').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
        });
      }
      $('body').css({overflow: 'visible'});
      $('html').css({overflow: 'visible'});
    }
    
  }

//$('.history_img').parallax({imageSrc: 'img/ofis.png'});

//$('#info_menu').tabify();

});

$('#cart_button').jrumble();

$(window).load(function(){

});

