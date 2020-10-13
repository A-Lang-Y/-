<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Inkness
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function inkness_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'inkness_jetpack_setup' );
