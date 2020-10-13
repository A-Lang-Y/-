<?php
/**
 *	Default Page Layout
 *
 *	@since 1.0
 */
$default_page_layout = cloudfw_get_option( 'global', 'default_page_layout', 'page-fullwidth.php', 'default' );
$path = trailingslashit(dirname(__FILE__));

if ( file_exists( $path . $default_page_layout ) ) {
	include( $path . $default_page_layout );
} else {
	include( $path . 'page-fullwidth.php' );
}