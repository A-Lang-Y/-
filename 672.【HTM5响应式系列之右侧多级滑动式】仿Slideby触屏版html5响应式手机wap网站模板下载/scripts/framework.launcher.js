// JavaScript Document

$(window).load(function() { // makes sure the whole site is loaded
	$("#status").fadeOut(); // will first fade out the loading animation
	$("#preloader").delay(350).fadeOut("slow"); // will fade out the white DIV that covers the website.
})

$(document).ready(function(){
	
	//Detect if iOS WebApp Engaged and permit navigation without deploying Safari
	(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")
	
	var owl = $(".slider-controls");
	owl.owlCarousel({
		//Basic Stuff
		singleItem:true,
		slideSpeed : 250,
		paginationSpeed : 250,
		rewindSpeed : 250,
		pagination:false,
		
		autoPlay : true,
	});
	
	// Custom Navigation Events
	$(".next-slider").click(function(){
	  owl.trigger('owl.next');
	  return false;
	});
	$(".prev-slider").click(function(){
	  owl.trigger('owl.prev');
	  return false;
	});
	
	
	
	var owlQuoteControls = $(".quote-slider");
	owlQuoteControls.owlCarousel({
		//Basic Stuff
		items : 4,
		itemsDesktop : [1199,4],
		itemsDesktopSmall : [980,3],
		itemsTablet: [768,3],
		itemsTabletSmall: [330,2],
		itemsMobile : [320,2],
		singleItem : false,
		itemsScaleUp : false,
		slideSpeed : 250,
		paginationSpeed : 250,
		rewindSpeed : 250,
		pagination:false,
		autoPlay : false,
		autoHeight: true,
	});
	
	var owlQuoteNoControls = $(".quote-slider-no-controls");
	owlQuoteNoControls.owlCarousel({
		//Basic Stuff
		singleItem:true,
		slideSpeed : 250,
		paginationSpeed : 250,
		rewindSpeed : 250,
		pagination:false,
		autoPlay : true,
		autoHeight: true,
	});
	
	// Custom Navigation Events
	$(".next-quote").click(function(){
	  owlQuoteControls.trigger('owl.next');
	  return false;
	});
	$(".prev-quote").click(function(){
	  owlQuoteControls.trigger('owl.prev');
	  return false;
	});
	

	
	$('.slider-two-thumbs').owlCarousel({
		singleItem:true,	
	});
		
	$(".slider-no-controls").owlCarousel({
		//Basic Stuff
		singleItem:true,
		slideSpeed : 250,
		paginationSpeed : 250,
		rewindSpeed : 250,
		pagination:false,
		autoHeight:true,
	
		//Autoplay
		autoPlay : true,
		stopOnHover : true,
	
		//Mouse Events
		dragBeforeAnimFinish : true,
		mouseDrag : true,
		touchDrag : true,
	
		//Transitions
		transitionStyle : false,
	});
	
	/////////////////
	//Image Gallery//
	/////////////////
	$(".swipebox").swipebox({
		useCSS : true, // false will force the use of jQuery for animations
		hideBarsDelay : 3000 // 0 to always show caption and action bar
	});
	
	$(".swipebox-wide").swipebox({
		useCSS : true, // false will force the use of jQuery for animations
		hideBarsDelay : 3000 // 0 to always show caption and action bar
	});
	
	$(".portfolio-item-full-width a").colorbox({
	 	transition:"fade",
		scalePhotos:"true",
		maxWidth:"100%",
		maxHeight:"100%"
	});
	
	$(".portfolio-item-thumb a").colorbox({
	 	transition:"fade",
		scalePhotos:"true",
		maxWidth:"100%",
		maxHeight:"100%"
	});

});
