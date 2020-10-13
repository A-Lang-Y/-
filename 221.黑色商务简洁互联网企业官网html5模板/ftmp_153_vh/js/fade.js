jQuery(document).ready(function () {
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