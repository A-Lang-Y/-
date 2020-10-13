<?php
/*
 * Plugin Name: Portfolio Pages
 * Plugin URI: http://cloudfw.net
 * Description:  
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */

cloudfw_register_module( 'portfolio', array(
	'_can_disabled'  =>	FALSE,
	//'module_folder'  =>	$dir,
	'title'          => __('Portfolio','cloudfw'),
	'desc'           => __('Portfolio with jQuery.Isotope','cloudfw'),
) );