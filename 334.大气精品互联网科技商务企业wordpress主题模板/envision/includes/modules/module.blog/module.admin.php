<?php

/**
 *	Blog List Styles
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_blog_list_styles() { 
	$out = array(
		'date'		=>	__('Date','cloudfw'),
		'icon'		=>	__('Post Type Icon','cloudfw'),
		'author'	=>	__('Author Avatar','cloudfw'),
		'thumbnail'	=>	__('Post Thumbnail','cloudfw'),
		'none'		=>	__('None','cloudfw'),
	);

	return $out;
}