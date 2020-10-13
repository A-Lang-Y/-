(function(){

	jQuery(document).ready(function(){

		var video_bg_page_height = function(){
			var win_height = win_height_alias = jQuery(window).height();
			var header = jQuery('#page-header');
			var titlebar = jQuery('#titlebar');
			var adminbar = jQuery('#wpadminbar');

			if( header.length ) {
				var header_height = header.height();
				win_height = win_height - header_height; 
			}

			if( titlebar.length ) {
				var titlebar_height = titlebar.height();
				win_height = win_height - titlebar_height; 
			}

			if( adminbar.length ) {
				var adminbar_height = adminbar.height();
				win_height = win_height - adminbar_height; 
			}

			jQuery('.ui--video-background-v-center').css({
				'height': win_height > 0 ? win_height : win_height_alias 
			});

		}

		if ( jQuery('.ui--video-background-v-center').length ) {
			video_bg_page_height();
			jQuery(window).load( video_bg_page_height );
			jQuery(window).smartresize( video_bg_page_height, 20 );
		}

		jQuery('.ui--video-background-video video').fillParent();
	});

})(jQuery);