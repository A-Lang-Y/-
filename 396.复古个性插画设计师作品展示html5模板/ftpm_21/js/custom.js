// Jquery with no conflict
jQuery(document).ready(function($) {
	
	//##########################################
	// Tweet feed
	//##########################################
	
	$("#tweets-bar").tweet({
        count: 1,
        username: "ansimuz"
    });
    
    
    //##########################################
	// Widgets
	//##########################################

	var container = $(".widget-cols");
	var trigger = $("#widget-trigger");
	
	trigger.click(function(){		
		container.animate({
			height: 'toggle'
			}, 500
		);
		
		if( trigger.hasClass('tab-closed')){
			trigger.removeClass('tab-closed');
		}else{
			trigger.addClass('tab-closed');
		}
		
		return false;
		
	});
	
	//##########################################
	// Tool tips
	//##########################################
	
	
	$('.poshytip').poshytip({
    	className: 'tip-yellowsimple',
		showTimeout: 1,
		alignTo: 'target',
		alignX: 'center',
		offsetY: 5,
		allowTipHover: false
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
	// Create Combo Navi
	//##########################################	
		
	// Create the dropdown base
	$("<select id='comboNav' />").appendTo("#combo-holder");
	
	// Create default option "Go to..."
	$("<option />", {
		"selected": "selected",
		"value"   : "",
		"text"    : "Navigation"
	}).appendTo("#combo-holder select");
	
	// Populate dropdown with menu items
	$("#nav a").each(function() {
		var el = $(this);		
		var label = $(this).parent().parent().attr('id');
		var sub = (label == 'nav') ? '' : '- ';
		
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
  
});