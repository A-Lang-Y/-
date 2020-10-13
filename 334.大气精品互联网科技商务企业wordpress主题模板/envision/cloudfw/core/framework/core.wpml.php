<?php

/**
 *	Fix WPML Ajax
 *
 *	@since 1.0
 */
if( defined( 'DOING_AJAX' ) && DOING_AJAX )
	add_action( 'admin_init', 'cloudfw_wpml_comp', 0);

function cloudfw_wpml_comp() {
	add_filter('icl_set_current_language', 'cloudfw_return_current_lang', 10);
	add_filter('icl_current_language', 'cloudfw_return_current_lang', 10);
}

function cloudfw_return_current_lang( $default_lang ){
	if ( isset( $_GET['lang'] ) )
		return $_GET['lang'];
	else
		return $default_lang;
}