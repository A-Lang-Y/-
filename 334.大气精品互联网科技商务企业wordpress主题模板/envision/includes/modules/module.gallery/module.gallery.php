<?php

function cloudfw_UI_gallery(){
	if ( !class_exists('CloudFw_Gallery') ) {
		require_once( trailingslashit(dirname(__FILE__)) . 'class.gallery.php' );
	}

	return new CloudFw_Gallery();
}