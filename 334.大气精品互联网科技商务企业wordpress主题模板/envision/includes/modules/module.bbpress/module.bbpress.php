<?php

/*
 * Plugin Name: BBPRess
 * Plugin URI: http://cloudfw.net
 * Description:  
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */

if ( cloudfw_bbpress() ) {
	if ( file_exists(dirname(__FILE__) . '/bbpress.php') )
	   require_once( dirname(__FILE__) . '/bbpress.php' );
}