/* ------------------------------------------------------------------------
Prep the Plugins on Page Load
* ------------------------------------------------------------------------- */
jQuery(document).ready(function(){
	jQuery('#gallery-nav li > a').click(function() {
    jQuery('#gallery-nav li').removeClass();
    jQuery(this).parent().addClass('active');
	});

});




/*-----------------------------------------------------------------------------------*/
/*	Gallery Sorting
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function(){
				
	jQuery('#iso-wrap').isotope({
		animationOptions: {
	     duration: 750,
	     easing: 'linear',
	     queue: false,
 		 }
	});
								
	
	jQuery('#gallery-nav a').click(function(){
 	  var selector = jQuery(this).attr('data-filter');
	  jQuery('#iso-wrap').isotope({ filter: selector });
 	  return false;
	});	
	
	
});