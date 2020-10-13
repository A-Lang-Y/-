function connect_menu() {
	if ($('body').width() < 748){
		$("ul.blockeasing").hide();
		$("ul.blockeasing li ul").show();
		$('.blockeasing-wrapp').css('background-position', '255px 10px');
		$('.blockeasing-wrapp').click(function(){
	 		if ($("ul.blockeasing").is(":visible")) {
				$("ul.blockeasing").hide();
				$(this).css('background-position', '255px 10px');
			}
			else {
				$("ul.blockeasing").show();
				$(this).css('background-position', '255px -25px');
			}
		});
	}
	else {
		$("ul.blockeasing").show();	
		$("ul.blockeasing li ul").hide();
		$("ul.blockeasing li").hover(function() {
	          $(this).find('.menu_hover:first').stop(true, true).fadeIn(1000);
			  $(this).find('ul:first').stop(true, true).slideToggle(200);},
	       function() {
	          $(this).find('.menu_hover:first').stop(true, true).fadeOut(1000);
			  $(this).find('ul:first').stop(true, true).slideToggle(200);		
		});
	}
}

 $(window).load(function() {
    //menu itembackground color animation	
	$("ul.blockeasing li").prepend('<span class="menu_hover"></span>');
	$("ul.blockeasing li .menu_hover").hide();	
	
	connect_menu();
	
	$(window).resize(function(){
		$('.blockeasing-wrapp').unbind('click');
		$("ul.blockeasing li").unbind('mouseenter');
		$("ul.blockeasing li").unbind('mouseleave');
		connect_menu();
		
		$container = $('.acc-content'),
		$trigger   = $('.acc-trigger');

		var fullWidth = $container.parent().parent().width();
		$trigger.css('width', fullWidth-75);
		$container.css('width', fullWidth-75);
	})
	
	
	
	// tabs
	$(".tabs .tabs-nav a").click(function(e){
		e.preventDefault();
		if(!$(this).hasClass('active')) {
			$(this).parent().parent().find('a').removeClass("active");
			$(this).addClass('active');
			
			var $containter = $(this).parent().parent().parent().find('.tabs-container'),
				tabId = $(this).attr('href');
				
			$containter.children('.tab-content').stop(true, true).hide();
			$containter.find(tabId).fadeIn();
		}
	});
	$(".tabs a:first").trigger("click");
	
	// accordion
	
	var $container = $('.acc-content'),
		$trigger   = $('.acc-trigger');

	$container.hide();
	$trigger.first().addClass('active').next().show();

	var fullWidth = $container.outerWidth(true);
	$trigger.css('width', fullWidth-75);
	$container.css('width', fullWidth-75);
	
	$trigger.click(function(e) {
		if( $(this).next().is(':hidden') ) {
			$(this).parent().find('.acc-trigger').removeClass('active').next().slideUp(300);
			$(this).toggleClass('active').next().slideDown(300);
		}
		e.preventDefault();
	});
	
	
	// animation for menu type widgets
	$(".page_item a, .cat_item a").hover(function(){
		$(this).stop(true, true).animate({borderLeftWidth: "15px"},"fast");
	}, function(){
		$(this).stop(true, true).animate({borderLeftWidth: "5px"},"medium");
	})
		
});