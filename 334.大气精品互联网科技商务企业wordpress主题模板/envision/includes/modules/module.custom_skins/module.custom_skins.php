<?php
/*
 * Plugin Name: Custom Skins on Pages
 * Plugin URI: http://cloudfw.net
 * Description:  
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */

cloudfw_register_module( 'custom_skins', array( 
	'title'          => __('Custom Skins on Pages','cloudfw'),
	'desc'           => __('Selectable color skins per pages.','cloudfw'),
	'_can_disabled'  => false
) );