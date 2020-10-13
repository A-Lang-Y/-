<?php

if( !is_admin() ) {

	require_once( dirname(__FILE__) . '/class.breadcrumb.php' );

	/*if ( function_exists('cloudfw_breadcrumb') )
		add_filter( 'the_content', 'cloudfw_register_breadcrumb', 9 );

	function cloudfw_register_breadcrumb(){
		cloudfw_breadcrumb(array(
			'echo' => true
		));
	}*/

}