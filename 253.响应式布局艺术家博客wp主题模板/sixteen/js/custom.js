jQuery(document).ready(function() {
	
	jQuery("time.entry-date").timeago();
	
	jQuery(document).ready(function() {
		jQuery('.main-navigation .menu ul').superfish({
			delay:       1000,                            // 1 second avoids dropdown from suddenly disappearing
			animation:   {opacity:'show',height:'hide'},  // fade-in and slide-down animation
			speed:       'fast',                          // faster animation speed
			autoArrows:  false                           // disable generation of arrow mark-up
		});
	});
		
	jQuery(window).bind('scroll', function(e) {
		hefct();
	});		

});
    	
function hefct() {
	var scrollPosition = jQuery(window).scrollTop();
	jQuery('#header-image').css('top', (0 - (scrollPosition * .2)) + 'px');
}	
jQuery(window).load(function(){
	jQuery('#slider').nivoSlider({effect:'boxRandom', pauseTime: 4500,});
});