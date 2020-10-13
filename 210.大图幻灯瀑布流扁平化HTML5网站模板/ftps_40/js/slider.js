// Jquery with no conflict
jQuery(document).ready(function($) {
	
	//##########################################
	// LOF SLIDER
	//##########################################
	 
	 
	var buttons = { previous:$('#home-slider .button-previous') ,
						next:$('#home-slider .button-next') };	
	

	
	function initLofSlider(items, nh, nw, w){
		$('#home-slider').lofJSidernews( {
			interval 		: 4000,
			direction		: 'opacitys',	
			easing			: 'easeInOutExpo',
			duration		: 1200,
			auto		 	: false,
			maxItemDisplay  : 5,
			navPosition     : 'horizontal', // horizontal
			navigatorHeight : 73,
			navigatorWidth  : 188,
			mainWidth		:  w,
			buttons: buttons
		});
	}	
	
	
	// responsive slider function
	
	// Default values for page
	var items = 5;			// Max item display
	var nh = 73;			// Navigator Height
	var nw = 188;			// Navigator Width
	var w = 940;			// Main Width
		
	initLofSlider(items, nh, nw, w);	
	
	$(window).resize(function(){
		
		var ww = $(window).width();
		console.log(ww);
		
		// Default Layout: 992px.	
		items = 5;
		nh = 73;
		nw = 188;
		w = 940;
		
		/*
		// Tablet Layout: 768px.
		if( ww >= 768 && ww <= 991){
			items = 5;
			nh = 73;
			nw = 188;
			w = 768;
			
			console.log('TABLET');	
		}
		

		// Wide Mobile Layout: 480px
		if( ww >= 480 && ww <= 767){
			items = 5;
			nh = 73;
			nw = 188;
			w = 480;
				
		}
		
		initLofSlider(items, nh, nw, w); */	
	
	});
	

//close			
});



















