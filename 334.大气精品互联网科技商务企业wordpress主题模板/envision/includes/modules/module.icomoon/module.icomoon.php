<?php

add_filter( 'cloudfw_font_icons', 'cloudfw_icomoon_classes' );
function cloudfw_icomoon_classes( $icon_list = array() ){

	$pattern = '/\.(icomoon-?[_a-zA-Z]+[_a-zA-Z0-9-]*)(?![^\{]*\})/';
	$css_file = untrailingslashit( dirname(__FILE__) ) . '/source/css/icomoon.css';

	if ( file_exists( $css_file ) ) {
		$subject = cloudfw_get_file_contents( $css_file );
	} else {
		return array();
	}

	preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

	$icons = array();
	foreach( $matches as $match ){
		$class = $match[1];
		$title = str_replace('icomoon-', '', $class);
		$title = str_replace('icomoon-', '', $class);
		$title = str_replace('-', ' ', $title);
		$title = ucwords( $title );
	    $icons[ 'Icomoon/' . $class ] = $title;
	}
	asort( $icons );
	$icons = stripslashes_deep( $icons );

	$icon_list = $icon_list + $icons;
	return $icon_list;
}

/**
 * Checks if Icomoon is used in the pages, and loads the css file.
 * 
 * @param  (string) $icon_family Called font family
 * @param  (string) $icon_class  Called icons' class
 * @return null
 */
function cloudfw_module_css_load_icomoon( $icon_family, $icon_class = '' ){
	if ( $icon_family == 'Icomoon' ) {
		cloudfw_vc_set ( 'load_css', 'theme-icomoon', cloudfw_relative_path( dirname(__FILE__) ).'/source/css/icomoon.css' );
	}
}

/**
 * Adds the iconmoon css file into the css enqueue.
 * 
 * @return null
 */
function cloudfw_module_enqueue_icomoon(){
	wp_register_style('theme-icomoon',  cloudfw_relative_path( dirname(__FILE__) ).'/source/css/icomoon.css', 'theme-bootstrap', cloudfw_get_combined_version());
	wp_enqueue_style ('theme-icomoon');
}

add_action  ('cloudfw_make_icon', 'cloudfw_module_css_load_icomoon', 10, 2);
add_action  ('admin_print_scripts', 'cloudfw_module_enqueue_icomoon', 2);
//add_action  ('wp_print_styles', 'cloudfw_module_register_icomoon', 2);