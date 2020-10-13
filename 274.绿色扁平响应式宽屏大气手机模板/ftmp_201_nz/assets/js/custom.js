
jQuery.noConflict()(function($){
		$(window).load(function() {
			$('.flexslider').flexslider({
				animation: "fade",             //String: Select your animation type, "fade" or "slide"
				slideDirection: "horizontal",   //String: Select the sliding direction, "horizontal" or "vertical"
				slideshow: true,                //Boolean: Animate slider automatically
				slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
				animationDuration: 600,         //Integer: Set the speed of animations, in milliseconds
				directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
				controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
				keyboardNav: true,              //Boolean: Allow slider navigating via keyboard left/right keys
				mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
				prevText: "<img src='assets/img/prev.png' alt='Prev' />",           //String: Set the text for the "previous" directionNav item
				nextText: "<img src='assets/img/next.png' alt='Next' />",               //String: Set the text for the "next" directionNav item
				pausePlay: true,               //Boolean: Create pause/play dynamic element
				pauseText: '<img src="assets/img/next.png" alt="Next" />',             //String: Set the text for the "pause" pausePlay item
				playText: 'Play',               //String: Set the text for the "play" pausePlay item
				randomize: false,               //Boolean: Randomize slide order
				slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
				animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
				pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
				pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
				controlsContainer: "",          //Selector: Declare which container the navigation elements should be appended too. Default container is the flexSlider element. Example use would be ".flexslider-container", "#container", etc. If the given element is not found, the default action will be taken.
				manualControls: "",             //Selector: Declare custom control navigation. Example would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
				start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
				before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
				after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
				end: function(){}
			});
		});
		});
	
jQuery.noConflict()(function($){
	$(window).load(function() {
			$('.blogslider').flexslider({
			animation: "slide",              //String: Select your animation type, "fade" or "slide"
			slideDirection: "horizontal",   //String: Select the sliding direction, "horizontal" or "vertical"
			slideshow: false,                //Boolean: Animate slider automatically
			slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
			animationDuration: 600,         //Integer: Set the speed of animations, in milliseconds
			directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
			controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
			keyboardNav: true,              //Boolean: Allow slider navigating via keyboard left/right keys
			mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
			prevText: "<img src='assets/img/prev.png' alt='Prev' />",           //String: Set the text for the "previous" directionNav item
			nextText: "<img src='assets/img/next.png' alt='Next' />",               //String: Set the text for the "next" directionNav item
			pausePlay: false,               //Boolean: Create pause/play dynamic element
			pauseText: 'Pause',             //String: Set the text for the "pause" pausePlay item
			playText: 'Play',               //String: Set the text for the "play" pausePlay item
			randomize: false,               //Boolean: Randomize slide order
			slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
			animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
			pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
			pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
			controlsContainer: "",          //Selector: Declare which container the navigation elements should be appended too. Default container is the flexSlider element. Example use would be ".flexslider-container", "#container", etc. If the given element is not found, the default action will be taken.
			manualControls: "",             //Selector: Declare custom control navigation. Example would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
			start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
			before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
			after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
			end: function(){}               //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
			  });
			});
		});
	
jQuery.noConflict()(function($){
	$(window).load(function() {
			$('.testimonialslider').flexslider({
			animation: "slide",              //String: Select your animation type, "fade" or "slide"
			slideDirection: "horizontal",   //String: Select the sliding direction, "horizontal" or "vertical"
			slideshow: true,                //Boolean: Animate slider automatically
			slideshowSpeed: 3000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
			animationDuration: 600,         //Integer: Set the speed of animations, in milliseconds
			directionNav: false,             //Boolean: Create navigation for previous/next navigation? (true/false)
			controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
			keyboardNav: false,              //Boolean: Allow slider navigating via keyboard left/right keys
			mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
			prevText: "<img src='assets/img/prev.png' alt='Prev' />",           //String: Set the text for the "previous" directionNav item
			nextText: "<img src='assets/img/next.png' alt='Next' />",               //String: Set the text for the "next" directionNav item
			pausePlay: false,               //Boolean: Create pause/play dynamic element
			pauseText: 'Pause',             //String: Set the text for the "pause" pausePlay item
			playText: 'Play',               //String: Set the text for the "play" pausePlay item
			randomize: false,               //Boolean: Randomize slide order
			slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
			animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
			pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
			pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
			controlsContainer: "",          //Selector: Declare which container the navigation elements should be appended too. Default container is the flexSlider element. Example use would be ".flexslider-container", "#container", etc. If the given element is not found, the default action will be taken.
			manualControls: "",             //Selector: Declare custom control navigation. Example would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
			start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
			before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
			after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
			end: function(){}               //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
			  });
			});
		});
	

		
jQuery.noConflict()(function($){		
$(document).ready(function(){
$(".flip").click(function(){
	
$(".panel").slideToggle("normal");

		var $map = $('#map');
		google.maps.event.addDomListener(window, 'resize', function() {
			map.setCenter(homeLatlng);
		});
		if( $map.length ) {

			$map.gMap({
				address: '9930 124th Avenue Northeast Kirkland, Washington',
				zoom: 14,
				markers: [
					{ 'address' : '9930 124th Avenue Northeast  Kirkland, Washington',}
				]
			});

		}


});
});
});
	

jQuery.noConflict()(function($){
var $map = $('#map-contact');
		google.maps.event.addDomListener(window, 'resize', function() {
			map.setCenter(homeLatlng);
		});
		if( $map.length ) {

			$map.gMap({
				address: '9930 124th Avenue Northeast Kirkland, Washington',
				zoom: 14,
				markers: [
					{ 'address' : '9930 124th Avenue Northeast  Kirkland, Washington',}
				]
			});

		}
});

jQuery.noConflict()(function($){
$(document).ready(function() {  

$("a[rel^='prettyPhoto']").prettyPhoto({opacity:0.80,default_width:200,default_height:344,theme:'facebook',hideflash:false,modal:false});

});
});

/***************************************************
			SuperFish Menu
***************************************************/	
// initialise plugins
	jQuery.noConflict()(function(){
		jQuery('ul#menu').superfish();
	});
	
	
	
jQuery.noConflict()(function($) {
  if ($.browser.msie && $.browser.version.substr(0,1)<8)
  {
	$('li').has('ul').mouseover(function(){
		$(this).children('ul').css('visibility','visible');
		}).mouseout(function(){
		$(this).children('ul').css('visibility','hidden');
		})
  }
});


jQuery.noConflict()(function($){
	jQuery(document).ready(function () {
		// start jqtweet!
		JQTWEET.loadTweets();
	});
})





	 // DOM ready
jQuery.noConflict()(function($){
	   
      // Create the dropdown base
      $("<select />").appendTo("nav");
      
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Please choose page"
      }).appendTo("nav select");
      
      // Populate dropdown with menu items
      $("nav a").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("nav select");
      });
      
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      $("nav select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	 
	 });

// PORTFOLIO FILTERING - ISOTOPE
	//**********************************
jQuery.noConflict()(function($){
var $container = $('#portfolio');
		
		if($container.length) {
			$container.waitForImages(function() {
				
				// initialize isotope
				$container.isotope({
				  itemSelector : '.block',
				  layoutMode : 'fitRows'
				});
				
				// filter items when filter link is clicked
				$('#filters button').click(function(){
				  var selector = $(this).attr('data-filter');
				  $container.isotope({ filter: selector });
				  $(this).parent().addClass('current').siblings().removeClass('current');
				  return false;
				});
				
			},null,true);
		}});