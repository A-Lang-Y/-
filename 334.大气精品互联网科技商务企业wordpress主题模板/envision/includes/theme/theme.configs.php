<?php
/**
 *	Theme Configs
 */
$the_theme = wp_get_theme(); 
$template = $the_theme->get('Template');
$version = is_child_theme() && !empty($template) ? wp_get_theme( $template )->get('Version') : $the_theme->get('Version'); 
define( 'CLOUDFW_THEMEVERSION', $version );
define( 'CLOUDFW_THEMENAME', 	$the_theme->get('Name') );
define( 'CLOUDFW_THEMEKEY', 	'envision' ); // DO NOT change the theme key
define( 'PFIX', 				 apply_filters('cloudfw_pfix','env') );
define( 'CLOUDFW_THEMEID', 		'envision' );
define( 'CLOUDFW_MINPHPVERSION','5.2' );
define( 'CLOUDFW_MINWPVERSION', '3.4.2' );
define( 'CLOUDFW_ITEMPAGE', 	'http://themes.cloudfw.net/envision/go/' );
define( 'CLOUDFW_ITEMDOC', 		'http://themes.cloudfw.net/envision/documentation/' );

/** Define global content width */
global $content_width;
	   $content_width = 960;