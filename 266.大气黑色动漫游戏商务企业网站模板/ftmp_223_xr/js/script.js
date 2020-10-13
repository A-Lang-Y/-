	//INITIALIZW MAIN MENU
	$(document).ready(function() { 
		$('.sf-menu').superfish({ 
			delay:       700,                            // one second delay on mouseout 
			animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
			speed:       'fast',                          // faster animation speed
			autoArrows:  false,                           // disable generation of arrow mark-up 
			dropShadows: false                            // disable drop shadows 
		}); 
	  /*hack for a bug in Chrome with the background when the dropdown is animated*/
		if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
			$('.sf-menu').superfish({ 
				delay:       700,
				animation:   {opacity:'show',height:'show'},
				speed:       0,
				autoArrows:  false,
				dropShadows: false
			}); 
		}
	});
	
	$(document).ready(function() {
		$('#work-slider').flexslider({
			animation: "slide",
			directionNav: true,
			controlNav: false, 
			controlsContainer: ".flexslider-container"
		});
	});
	
	$(document).ready(function(){	
		$('#testimonial-slider').flexslider({
			animation: "slide",
			directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
			controlNav: false, 
			controlsContainer: ".flex-container2",
			slideshowSpeed: 3000,
		});
	});
	//INITIALIZES TWITTER FEED PLUGIN
	$(document).ready(function() { 
		$(".tweet").tweet({
			username: "seaofclouds",//Change with your own twitter id
			//join_text: "auto",
			//avatar_size: 32,
			count: 3,
			//auto_join_text_default: "we said,",
			//auto_join_text_ed: "we",
			//auto_join_text_ing: "we were",
			//auto_join_text_reply: "we replied to",
			//auto_join_text_url: "we were checking out",
			loading_text: "loading tweets..."
		});
	});
	
	//INITIALIZW TESTIMONIAL QUOTES
	$(document).ready(function() {
		$('blockquote').quovolver();		
	});
	
	$(document).ready(function() {
		$(".fadeout").hover(function(){
			$(this).stop().animate({opacity: "0.2"}, 350);
		},
		function(){
			$(this).stop().animate({opacity: "1"}, 125);
		});
	});
	
	//INITIALIZES LIGHTBOX PLUGIN
	$(document).ready(function() {
		$("a[rel^='prettyPhoto']").prettyPhoto({
			opacity:0.80,
			default_width:500,
			default_height:344,
			theme:'dark_rounded',
			hideflash:false,
			modal:false,
			showTitle: false,
		});
	});
	
	//INITIALIZES BACK TO TOP
	$(document).ready(function(){
		// hide #back-top first
		$("#back-top").hide();		
		// fade in #back-top
		$(function () {
			$(window).scroll(function () {
				if ($(this).scrollTop() > 100) {
					$('#back-top').fadeIn();
				} else {
					$('#back-top').fadeOut();
				}
			});	
			// scroll body to 0px on click
			$('#back-top a').click(function () {
				$('body,html').animate({
					scrollTop: 0
				}, 800);
				return false;
			});
		});	
	});
	$(document).ready(function(){
		/* tabs
		-------------------------------*/
		$('.tabs').each(function(){
			$(this).find('.tabs-control a:first').addClass('active');
			$(this).find('.tabs-tabs .tabs-tab:first').addClass('active');
		});
		
		$('.tabs .tabs-control a').click(function(){
			var $tabs=$(this).parents('.tabs');
			if(!$tabs.length)
				return false;
				
			var tabname=$(this).attr('href').replace('#','');
			
			$tabs.find('.tabs-control a').removeClass('active');
			$(this).addClass('active');

			$tabs.find('.tabs-tabs .tabs-tab.active').hide().removeClass('active');
			$tabs.find('.tabs-tabs .tabs-tab.'+tabname).addClass('active').fadeIn(300);
			
			
			return false;
		});
		
		/* toggle
		-------------------------------*/
		$(".toggle-title").each(function(){
			if(!$(this).parent().hasClass("active")){
				$(this).next().hide();
			}
			$(this).click(function(){
					$(this).next().slideToggle(Math.min(600 , Math.max(300 , $(this).next().height())));
					$(this).parent().toggleClass("active");
					return false;
			});
		});
		
		/* accordion
		-------------------------------*/
		$(".accordion-panel-title").each(function(){
			if(!$(this).parent().hasClass("active")){
				$(this).next().hide();
			}
			
			$(this).click(function(){
				if($(this).next().is(":hidden")){
					$(this).parent().parent().find(".accordion-panel-title").next().slideUp(Math.min(600 , Math.max(300 , $(this).next().height()))).parent().removeClass("active");
					$(this).next().slideDown(Math.min(600 , Math.max(300 , $(this).next().height()))).parent().toggleClass("active");
				}
				
				return false;
			});
		});
	});
	