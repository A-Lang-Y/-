<?php
/**
 *	Envision Multipurpose Theme (2013) - ThemeForest
 *	functions.php which does and tells WordPress to load CloudFW and the theme.
 *
 * 				(Ya-Settar, Ya-Gaffar, Ya-Fettâh)
 * 	@author 	Orkun GURSEL
 *				<ticket:	support.cloudfw.net>
 *				<email:		support@cloudfw.net>
 *				<twitter: 	@orkungursel, @cloudfw>
 *
 *	@package 	WordPress
 *	@subpackage	CloudFw
 *	@subpackage	Envision
 */
/** Globals */

global $cloudfw_start, $cloudfw_memory;
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$cloudfw_start = $time;
$cloudfw_memory = memory_get_usage();

/** Defines */
if ( !defined('TMP_PATH') ) 		define( 'TMP_PATH', get_template_directory() . '/' );
if ( !defined('TMP_URL') ) 			define( 'TMP_URL', get_template_directory_uri() );
if ( !defined('CLOUDFW_TMP_PATH') )	define( 'CLOUDFW_TMP_PATH', dirname(__FILE__) );

/**
 *	Load & Run CloudFw
 */
require( TMP_PATH.'/cloudfw/cloudfw.loader.php' );