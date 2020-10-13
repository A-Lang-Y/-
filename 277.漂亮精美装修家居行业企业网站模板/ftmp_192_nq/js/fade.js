jQuery(document).ready(function () {
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
	
	//=================================== PRETTYPHOTO ===================================//
	jQuery('a[data-rel]').each(function() {jQuery(this).attr('rel', jQuery(this).data('rel'));});
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'facebook',gallery_markup:'',slideshow:2000});
});