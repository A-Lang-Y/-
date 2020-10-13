<?php
/*
Plugin Name: CloudFw Likes
Plugin URI: 
Description: Add "like" functionality to your posts and pages
Version: 1.0
Author: Orkun Gursel
Author URI: http://orkungursel.com
*/
function cloudfw_likes( $args = array() ){
	if( !class_exists('CloudFW_Likes') ) {
		require_once( trailingslashit(dirname(__FILE__)) . 'class/class.likes.php' );
	}

	global $cloudfw_likes;
    return $cloudfw_likes->render( $args );
}


if( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	require_once( trailingslashit(dirname(__FILE__)) . 'class/class.likes.php' );	
}