jQuery(document).ready(function(){
	
	//Add Class Js to html
	jQuery('html').addClass('js');	
								
    //=================================== MENU ===================================//
	jQuery("ul.sf-menu").supersubs({ 
	minWidth		: 12,		// requires em unit.
	maxWidth		: 12,		// requires em unit.
	extraWidth		: 3	// extra width can ensure lines don't sometimes turn over due to slight browser differences in how they round-off values
						   // due to slight rounding differences and font-family 
	}).superfish();  // call supersubs first, then superfish, so that subs are 
					 // not display:none when measuring. Call before initialising 
					 // containing tabs for same reason. 
	
	
	//=================================== TABS AND TOGGLE ===================================//
	//jQuery tab
	jQuery(".tab-content").hide(); //Hide all content
	jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
	jQuery(".tab-content:first").show(); //Show first tab content
	//On Click Event
	jQuery("ul.tabs li").click(function() {
		jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab
		jQuery(".tab-content").hide(); //Hide all tab content
		var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		jQuery(activeTab).fadeIn(200); //Fade in the active content
		return false;
	});
	
	//jQuery toggle
	jQuery(".toggle_container").hide();
	jQuery("h2.trigger").click(function(){
		jQuery(this).toggleClass("active").next().slideToggle("slow");
	});
	
	//=================================== FADE EFFECT ===================================//
	if (jQuery.browser.msie && jQuery.browser.version < 7) return; // Don't execute code if it's IE6 or below cause it doesn't support it.
	
	jQuery('.ts-display-pf-img').hover(
		function() {
			jQuery(this).find('.rollover').stop().fadeTo(500, 0.60);
		},
		function() {
			jQuery(this).find('.rollover').stop().fadeTo(500, 0);
		}
	)
	
	
});

