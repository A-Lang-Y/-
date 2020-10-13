<?php
/**
 *	Blog Modes
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_blog_metas(){

	$out['read-more'] 	= __('Read More Link','cloudfw');
	$out['date'] 		= __('Post Date','cloudfw');
	$out['category'] 	= __('Post Categories','cloudfw');
	
	return $out;
}

/**
 *	Blog Modes
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_blog_modes(){

	$blog_modes[] =  array(
		"item_title"	=> 'Full Text Mode',
		"item_value"	=> 'full'
	);
	
	$blog_modes[] =  array(
		"item_title"	=> 'Excerpt Mode',
		"item_value"	=> 'excerpt'
	);
	
	return $blog_modes;
}