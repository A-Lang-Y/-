<?php

add_filter( 'cloudfw_font_icons', 'cloudfw_fontawesome_classes' );
function cloudfw_fontawesome_classes( $icon_list = array() ){
	$pattern = '/\.(fontawesome-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
	$css_file = untrailingslashit( dirname(__FILE__) ) . '/source/css/font-awesome.css';

	if ( file_exists( $css_file ) ) {
		$subject = cloudfw_get_file_contents( $css_file );
	} else {
		return array();
	}

	preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

	$icons = array();
	foreach( $matches as $match ){
		$class = $match[1];
		$title = str_replace('fontawesome-', '', $class);
		$title = str_replace('fontawesome-', '', $class);
		$title = str_replace('-', ' ', $title);
		$title = ucwords( $title );
	    $icons[ 'FontAwesome/' . $class ] = $title;
	}
	asort( $icons );
	$icons = stripslashes_deep( $icons );

	$icon_list = $icon_list + $icons;
	return $icon_list;
}

function cloudfw_module_register_fontawesome(){
    global $wp_styles;

    /** Register FontAwesome */
	wp_register_style('theme-fontawesome',  cloudfw_relative_path( dirname(__FILE__) ).'/source/css/font-awesome.min.css', 'theme-bootstrap', cloudfw_get_combined_version());
	wp_enqueue_style ('theme-fontawesome');

    /** Register FontAwesome for IE */
	wp_register_style('theme-fontawesome-ie7',  cloudfw_relative_path( dirname(__FILE__) ).'/source/css/font-awesome-ie7.min.css', 'theme-bootstrap', cloudfw_get_combined_version());
    $wp_styles->add_data('theme-fontawesome-ie7', 'conditional', 'IE 7');
	wp_enqueue_style ('theme-fontawesome-ie7');
}

add_action  ('wp_print_styles', 'cloudfw_module_register_fontawesome', 2);
add_action  ('admin_print_scripts', 'cloudfw_module_register_fontawesome', 2);