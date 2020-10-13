<?php
/*
 * Plugin Name: Blog Pages
 * Plugin URI: http://cloudfw.net
 * Description:  
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */

cloudfw_register_module( 'blog', array( 
	'title'          => __('Blog','cloudfw'),
	'desc'           => __('Theme Blog Pages','cloudfw'),
	'_can_disabled'  => FALSE,
) );