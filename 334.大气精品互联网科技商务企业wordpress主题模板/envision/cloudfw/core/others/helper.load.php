<?php  
/** Include WP Loader */

/** Set vars */
$trying = 0;
$wp_include = "../wp-load.php";

while ( !file_exists( $wp_include ) && $trying++ < 10 )
	$wp_include = "../$wp_include";

if ( file_exists($wp_include) )
	require( $wp_include );
else
	exit( '<strong>Fatal Error</strong>: wp-load.php cannot load.' );
