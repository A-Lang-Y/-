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
		items : 2,
		itemsDesktop : [1199,4],
		itemsDesktopSmall : [980,3],
		itemsTablet: [768,3],
		itemsTabletSmall: [330,1],
		itemsMobile : [320,1],
		singleItem : false,
		itemsScaleUp : false,
		slideSpeed : 250,
		paginationSpeed : 250,
		rewindSpeed : 250,
		pagination:false,
		autoPlay : false,
		autoHeight: true,
	});
	
	var owlQuoteControls = $(".customer-slider");
	owlQuoteControls.owlCarousel({
		//Basic Stuff
		items : 5,
		itemsDesktopSmall : [980,6],
		itemsTablet: [768,4],
		itemsTabletSmall: [330,4],
		itemsMobile : [320,4],
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
	
	
  var time = 7; // time in seconds
 
  var $progressBar,
      $bar, 
      $elem, 
      isPause, 
      tick,
      percentTime;
	  
 
    //Init the carousel
    $(".homepage-slider").owlCarousel({
      slideSpeed : 500,
      paginationSpeed : 500,
      singleItem : true,
	  pagination:false,
      afterInit : progressBar,
      afterMove : moved,
      startDragging : pauseOnDragging
    });
 
    //Init progressBar where elem is $("#owl-demo")
    function progressBar(elem){
      $elem = elem;
      //build progress bar elements
      buildProgressBar();
      //start counting
      start();
    }
 
    //create div#progressBar and div#bar then prepend to $("#owl-demo")
    function buildProgressBar(){
      $progressBar = $("<div>",{
        id:"progressBar"
      });
      $bar = $("<div>",{
        id:"bar"
      });
      $progressBar.append($bar).prependTo($elem);
    }
 
    function start() {
      //reset timer
      percentTime = 0;
      isPause = false;
      //run interval every 0.01 second
      tick = setInterval(interval, 10);
    };
 
    function interval() {
      if(isPause === false){
        percentTime += 1 / time;
        $bar.css({
           width: percentTime+"%"
         });
        //if percentTime is equal or greater than 100
        if(percentTime >= 100){
          //slide to next item 
          $elem.trigger('owl.next')
        }
      }
    }
 
    //pause while dragging 
    function pauseOnDragging(){
      isPause = true;
    }
 
    //moved callback
    function moved(){
      //clear interval
      clearTimeout(tick);
      //start again
      start();
    }


	// Custom Navigation Events
	$(".next-home").click(function(){
	  $(".homepage-slider").trigger('owl.next');
	  return false;
	});
	$(".prev-home").click(function(){
	  $(".homepage-slider").trigger('owl.prev');
	  return false;
	});	


});
