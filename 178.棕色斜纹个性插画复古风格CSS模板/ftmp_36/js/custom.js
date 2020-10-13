// Jquery with no conflict
jQuery(document).ready(function($) {
	

	//##########################################
	// Slider
	//##########################################
	
	$('#slider').nivoSlider({
		effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
		animSpeed: 500, // Slide transition speed
        pauseTime: 3000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        controlNav: true // 1,2,3... navigation
	});
	
	//##########################################
	// Superfish
	//##########################################
	
	$(".sf-menu").superfish({ 
        animation: {height:'show'},   // slide-down effect without fade-in 
        delay:     800 ,              // 1.2 second delay on mouseout 
        autoArrows:  false,
        speed: 100
    });
    
     //##########################################
	// Accordion box
	//##########################################

	$('.accordion-container').hide(); 
	$('.accordion-trigger:first').addClass('active').next().show();
	$('.accordion-trigger').click(function(){
		if( $(this).next().is(':hidden') ) { 
			$('.accordion-trigger').removeClass('active').next().slideUp();
			$(this).toggleClass('active').next().slideDown();
		}
		return false;
	});
	
	//##########################################
	// Toggle box
	//##########################################
	
	$('.toggle-trigger').click(function() {
		$(this).next().toggle('slow');
		$(this).toggleClass("active");
		return false;
	}).next().hide();
	
	 //##########################################
	// Tabs
	//##########################################

    $(".tabs").tabs("div.panes > div", {
    	// remove effect to prvent issues on ie
    });
    
    //##########################################
	// Work - Isotope 
	//##########################################

	
	var $container = $('#filter-container');
	
	$container.imagesLoaded( function(){
		$container.isotope({
			itemSelector : 'li',
			resizable: false,
			animationEngine: 'jquery'			  
		});
	});
	
    
    //##########################################
	// declare a function to reverse the objects as they were an array
	//##########################################
	
    jQuery.fn.reverse = function() {
	    return this.pushStack(this.get().reverse(), arguments);
	};


    //##########################################
	// Create Combo Navi
	//##########################################
	
	// add the combo-holder
	
	$("<div id='combo-holder'></div>").prependTo("#main");	
		
	// Create the dropdown base
	$("<select id='comboNav' />").appendTo("#combo-holder");
	
	// Create default option "Go to..."
	$("<option />", {
		"selected": "selected",
		"value"   : "",
		"text"    : "Navigation"
	}).appendTo("#combo-holder select");
	
	// Populate dropdown with left menu items
	$("#left-nav a").reverse().each(function() {
		var el = $(this);		
		var label = $(this).parent().parent().attr('id');
		var sub = (label == 'left-nav') ? '' : '- ';
		
		$("<option />", {
		 "value"   : el.attr("href"),
		 "text"    :  sub + el.text()
		}).appendTo("#combo-holder select");
	});
	
	// Populate dropdown with right menu items
	$("#right-nav a").each(function() {
		var el = $(this);		
		var label = $(this).parent().parent().attr('id');
		var sub = (label == 'right-nav') ? '' : '- ';
		
		$("<option />", {
		 "value"   : el.attr("href"),
		 "text"    :  sub + el.text()
		}).appendTo("#combo-holder select");
	});

	
	//##########################################
	// Combo Navigation action
	//##########################################
	
	$("#comboNav").change(function() {
	  location = this.options[this.selectedIndex].value;
	});
	
	//##########################################
	// CENTER ELEMENTS (used to center the logo)
	//##########################################


	jQuery.fn.center = function(parent) {
	    if (parent) {
	        parent = this.parent();
	    } else {
	        parent = window;
	    }
	    this.css({
	        "position": "absolute",
	        "top": ((($(parent).height() - this.outerHeight()) / 2) + $(parent).scrollTop() + "px"),
	        "left": ((($(parent).width() - this.outerWidth()) / 2) + $(parent).scrollLeft() + "px")
	    });
	return this;
	}
	
	//$("#logo").center(true);
	


	//##########################################
	// Resize event
	//##########################################
	
	$(window).resize(function() {
		
		var w = $(window).width();

		$container.isotope('reLayout');
		
		// center logo again
		//$("#logo").center(true);
		
	}).trigger("resize");
	
});
