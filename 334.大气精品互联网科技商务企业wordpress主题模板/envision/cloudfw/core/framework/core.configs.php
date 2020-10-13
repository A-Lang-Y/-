<?php
/*************************
 *	DO NOT EDIT THIS PAGE   
 *************************/

/**
 *	CloudFw Variables
 */
$cloudfw_setting_slug = 'CloudFW';
$cloudfw_slider_slug = 'CloudFW_Slider';
$page = isset($_GET["page"]) ? $_GET["page"] : 'CloudFW';
$upload_dir = wp_upload_dir();

if ( $is_multisite = (defined('MULTISITE')) && (MULTISITE == true) ) {
	global $blog_id;
	$suffix = $blog_id . '/';
} else {
	$suffix = '';
}

define( 'CLOUDFW_VERSION', '4.0b' );
define( 'CLOUDFW_PAGE', 'admin.php?page='. $page );
define( 'CLOUDFW_WPVERSION', get_bloginfo('version') );

require( TMP_PATH.'includes/theme/theme.configs.php' );

define( 'TMP_ADMIN',  TMP_URL. '/cloudfw' );
define( 'TMP_ADMIN_PATH', TMP_PATH.'cloudfw' );
define( 'TMP_ADMIN_GUI', TMP_URL. '/cloudfw/gui' );

define( 'TMP_LIB',  TMP_URL. '/lib/' );
define( 'TMP_LIB_PATH',  TMP_PATH. 'lib/' );
define( 'TMP_CSS',  TMP_LIB. 'css/' );
define( 'TMP_CSS_PATH',  TMP_LIB_PATH. 'css/' );
define( 'TMP_JS',   TMP_LIB. 'js/' );
define( 'TMP_JS_PATH',  TMP_LIB_PATH. 'js/' );

define( 'TMP_INCLUDES', TMP_PATH.'includes' );
define( 'TMP_LOADERS', TMP_INCLUDES.'/theme' );
define( 'TMP_SLIDERS', TMP_INCLUDES.'/sliders' );
define( 'TMP_SHORTCODES', TMP_INCLUDES.'/shortcodes' );
define( 'TMP_WIDGETS', TMP_INCLUDES.'/widgets' );
define( 'TMP_MODULES', TMP_INCLUDES.'/modules' );
define( 'TMP_DEFAULTS', TMP_INCLUDES.'/defaults' );

define( 'TMP_OPTIONS', TMP_LOADERS.'/options' );
define( 'TMP_VISUAL_OPTIONS', TMP_LOADERS.'/visual' );
define( 'TMP_TYPO_OPTIONS', TMP_LOADERS.'/typo' );

define( 'CLOUDFW_UPLOADDIR',  $upload_dir["basedir"].'/' );
define( 'CLOUDFW_UPLOADDIR_FULL',  $upload_dir["path"].'/' );

define( 'CACHE_DIR',  $upload_dir["url"] . '/' /*. $suffix*/ );
define( 'CACHE_DIR_BASE',  $upload_dir["path"] . '/' );
define( 'CACHE_DIR_PATH',  CACHE_DIR_BASE /*. $suffix*/ );

define( 'SLIDERS_DIR',  TMP_URL.'/includes/sliders/' );
define( 'SLIDERS_DIR_PATH',  TMP_PATH.'includes/sliders/' );

define( 'SLIDER_RESOURCES',  $upload_dir["baseurl"] . '/sliders/' );
define( 'SLIDER_RESOURCES_PATH',  $upload_dir["basedir"] . '/sliders/' );

define( 'SKINS_DIR',  $upload_dir["baseurl"] . '/skins/' );
define( 'SKINS_DIR_PATH',  $upload_dir["basedir"] . '/skins/' );

define( 'FONTS_DIR',  TMP_URL.'/resources/fontface/' );
define( 'FONTS_DIR_PATH',  TMP_PATH.'resources/fontface/' );

define( 'CUFON_DIR',  TMP_URL.'/resources/cufon/' );
define( 'CUFON_DIR_PATH',  TMP_PATH.'resources/cufon/' );

define( 'ICONS_DIR',  TMP_URL.'/resources/icons/' );
define( 'ICONS_DIR_PATH',  TMP_PATH.'resources/icons/' );

define( 'DUMMY_DIR',  TMP_URL.'/resources/dummy/' );
define( 'DUMMY_DIR_PATH',  TMP_PATH.'resources/dummy/' );

define( 'PREPAGES_DIR',  TMP_URL.'/resources/prepages/' );
define( 'PREPAGES_DIR_PATH',  TMP_PATH.'resources/prepages/' );

if ( ! defined('FS_CHMOD_DIR') ) {
	define('FS_CHMOD_DIR', 0755 );
}

if ( ! defined('FS_CHMOD_FILE') ) {
	define('FS_CHMOD_FILE', 0644 );
}

/**
 *	CloudFw Admin Messages
 *
 *	@since 1.0
 *	@version 3.0
 */
function cloudfw_admin_messages( $message_id ) {
	$out = array(); 

	global $cloudfw_extra_query;
		   $cloudfw_extra_query = array_merge( (array)$_REQUEST, (array)$cloudfw_extra_query );

	switch ($message_id) {

		/**
		 *	General Messages
		 */
		case 999:
			$out = array(
				'msg' 	=> __('The Theme Activated','cloudfw'),
				'key' 	=> 'update'
			); break;
		case 1000: 
			$out = array(
				'title' => __('Options Updated','cloudfw'),
				'msg'   => __('All options saved successfuly.','cloudfw'),
				'key'   => 'update'
			); break;
		case 2000: 
			$out = array(
				'title' => __('Option Deleted','cloudfw'), 
				'msg' 	=> __('Options deleted successfuly.','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 2010: 
			$out = array(
				'title' => __('Sidebar Settings Saved','cloudfw'), 
				'msg' 	=> __('Sidebar settings saved successfuly.','cloudfw'), 
				'key' 	=> 'add'
			); break;

		/**
		 *	Errors Messages
		 */
		case 1003: 
			$out = array(
				'title' => __('Sorry','cloudfw'), 
				'msg' 	=> __('There was an error when saving options.','cloudfw'), 
				'key' 	=> 'error'
			); break;
		case 1004: 
			$out = array(
				'title' => __('Action Aborted','cloudfw'), 
				'msg' 	=> __('Failed nonce check and the action aborted.','cloudfw'), 
				'key' 	=> 'error'
			); break;
		case 1005: 
			$out = array(
				'title' => __('Action Aborted','cloudfw'), 
				'msg' 	=> __('You don\'t have the permission to do that.','cloudfw'), 
				'key' 	=> 'error'
			); break;
		case 1006: 
			$out = array(
				'title' => __('You are logged out!','cloudfw'), 
				'msg' 	=> __('Could not save the data.','cloudfw') . ' <strong><a href="'.wp_login_url().'" target="_blank">' . __('Please log in again.','cloudfw') . '</a></strong>', 
				'key' 	=> 'error'
			); break;
		case 1024: 
			$out = array(
				'title' => __('Oopss!','cloudfw'), 
				'msg' 	=> __('An error occurred when uploading.','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 2001: 
			$out = array(
				'title' => __('Sorry','cloudfw'), 
				'msg' 	=> __('An error has occurred.','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 2010: 
			$out = array(
				'title' => __('Sorry','cloudfw'), 
				'msg' 	=> __('Your refferer cannot Verified.','cloudfw'), 
				'key' 	=> 'cancel'
			); break;

		/**
		 *	Slider Messages
		 */
		case 6001: 
			$out = array(
				'title' => __('Item Created','cloudfw'), 
				'msg' 	=> __('Slider item created successfuly.','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 6002: 
			$out = array(
				'title' => __('Slider Updated','cloudfw'), 
				'msg' 	=> __('Slider item(s) updated successfuly.','cloudfw'), 
				'key' 	=> 'update'
			); break;
		case 6004: 
			$out = array(
				'title' => __('Slider Created','cloudfw'), 
				'msg' 	=> __('New slider created successfuly.','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 6005: 
			$out = array(
				'title' => __('Slider Options Saved','cloudfw'), 
				'msg' 	=> '<a href=\"'.$cloudfw_extra_query['this_page'].'&amp;id='. $cloudfw_extra_query['msid'] .'\">'. __('Add a new slider item','cloudfw') .'</a>', 
				'key' 	=> 'update'
			); break;
		case 6006: 
			$out = array(
				'msg' 	=> __('Slider Duplicated','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 6007: 
			$out = array(
				'msg' 	=> __('Slider Imported','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 6008: 
			$out = array(
				'title' => __('Sliders Sorted','cloudfw'), 
				'msg' 	=> __('Sliders sorted and saved successfuly.','cloudfw'), 
				'key' 	=> 'update'
			); break;

		case 9022: 
			$out = array(
				'msg' 	=> __('Could not be found any .slider file in the zip file','cloudfw'), 
				'key' 	=> 'error'
			); break;
		
		/**
		 *	Skin Messages
		 */
		case 7001: 
			$out = array(
				'msg' 	=> __('New Visual Set Created','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 7002: 
			$out = array(
				'msg' 	=> __('Visual Settings Updated','cloudfw'), 
				'key' 	=> 'update'
			); break;
		case 7003: 
			$out = array(
				'msg' 	=> __('Visual Set Deleted','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 7004: 
			$out = array(
				'msg' 	=> __('Default Visual Set Changed','cloudfw'), 
				'key' 	=> 'update'
			); break;
		case 7005: 
			$out = array(
				'msg' 	=> __('Visual Settings Updated and Applied as Default','cloudfw'), 
				'key' 	=> 'update'
			); break;
		case 7006: 
			$out = array(
				'title' => __('Visual Set Duplicated','cloudfw'), 
				'msg' 	=> __('All settings duplicated successfuly.','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 7011: 
			$out = array(
				'title' => __('Visual Set Imported','cloudfw'), 
				'msg' 	=> __('All settings imported successfuly.','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 7012: 
			$out = array(
				'title' => __('Visual Sets Sorted','cloudfw'), 
				'msg' 	=> __('Visual sets sorted successfuly.','cloudfw'), 
				'key' 	=> 'update'
			); break;
		case 9017: 
			$out = array(
				'title' => __('Error','cloudfw'),
				'msg' 	=> __('Could not be found any .skin file in the zip file','cloudfw'), 
				'key' 	=> 'error'
			); break;
		case 9018: 
			$out = array(
				'title' => __('Error','cloudfw'),
				'msg' 	=> __(SKINS_DIR_PATH.' folder cannot opened to scan a visual settings file','cloudfw'), 
				'key' 	=> 'error'
			); break;
		case 9019: 
			$out = array(
				'title' => __('Error','cloudfw'),
				'msg' 	=> __('Fatal Error: Php ZipArchive extension is not found. You can not import a zip file','cloudfw'), 
				'key' 	=> 'error'
			); break;
		case 9020: 
			$out = array(
				'title' => __('Error','cloudfw'),
				'msg' 	=> __('The import was cancelled. <strong>'.SKINS_DIR_PATH.'</strong> folder is not writable','cloudfw'), 
				'key' 	=> 'error'
			); break;
		
		/**
		 *	Other Messages
		 */
		case 8001: 
			$out = array(
				'msg' 	=> __('Blog Page Created And Defined Successfully','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 8002: 
			$out = array(
				'msg' 	=> __('Portfolio Page Created And Defined Successfully','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 8003: 
			$out = array(
				'msg' 	=> __('Homepage Created successfuly','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 8004: 
			$out = array(
				'msg' 	=> __('Slider Samples Created successfuly','cloudfw'), 
				'key' 	=> 'add'
			); break;

		/**
		 *	Font Messages
		 */
		case 8010: 
			$out = array(
				'msg' 	=> __('Fonts Updated','cloudfw'), 
				'key' 	=> 'update'
			); break;
		case 8011: 
			$out = array(
				'msg' 	=> __('Font Settings Saved','cloudfw'), 
				'key' 	=> 'update'
			); break;
		case 8012: 
			$out = array(
				'msg' 	=> __('Web Fonts Saved','cloudfw'), 
				'key' 	=> 'update'
			); break;
		case 8013: 
			$out = array(
				'msg' 	=> __('Custom Service Fonts Saved','cloudfw'), 
				'key' 	=> 'update'
			); break;

		/**
		 *	Composer Messages
		 */
		case 3101: 
			$out = array(
				'title' => __('Saved','cloudfw'), 
				'msg' 	=> __('Composer template saved successfuly.','cloudfw'), 
				'key' 	=> 'update'
			); break;
		case 3102: 
			$out = array(
				'title' => __('Hoops!','cloudfw'), 
				'msg' 	=> __('Post ID not found','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 3103: 
			$out = array(
				'title' => __('Hoops!','cloudfw'), 
				'msg' 	=> __('Please insert a name for composer template','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 3104: 
			$out = array(
				'title' => __('Hoops!','cloudfw'), 
				'msg' 	=> __('Please add some composer element to save it','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 3105: 
			$out = array(
				'title' => __('Error','cloudfw'), 
				'msg' 	=> __('The template data cannot found.','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 3106: 
			$out = array(
				'title' => __('Template Deleted','cloudfw'), 
				'msg'	=> __('The template deleted successfuly.','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 3107: 
			$out = array(
				'msg' 	=> __('Export Data Generated','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 3108: 
			$out = array(
				'title' => __('Error','cloudfw'), 
				'msg' 	=> __('Please select a composer widget to export.','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 3109: 
			$out = array(
				'msg' 	=> __('The data imported successfuly.','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 3110: 
			$out = array(
				'msg' 	=> __('Imported data type doesn\'t compatible with this theme.','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 3111: 
			$out = array(
				'msg' 	=> __('Any content cannot imported with the data that imported.','cloudfw'), 
				'key' 	=> 'cancel'
			); break;

		/**
		 *	System Messages
		 */
		case 9000: 
			$out = array(
				'msg' 	=> __('All Theme Settings Restored','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 9001: 
			$out = array(
				'msg' 	=> __('All Cache Files Removed','cloudfw'), 
				'key' 	=> 'ok'
			); break;
		case 9002: 
			$out = array(
				'msg' 	=> __('Option File Uploaded & Changes Saved','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 9003: 
			$out = array(
				'msg' 	=> __('Please Upload A File','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 9004: 
			$out = array(
				'msg' 	=> __('The uploaded file not compatible with the theme!','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 9005: 
			$out = array(
				'msg' 	=> __('There was an error uploading the file, please try again!','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 9006: 
			$out = array(
				'msg' 	=> __('Type of the uploaded file not compatible with the theme','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 9007: 
			$out = array(
				'msg' 	=> __('File size too large','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 9008: 
			$out = array(
				'msg' 	=> __('Could not save uploaded file. The upload was cancelled, or server error encountered','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 9009: 
			$out = array(
				'msg' 	=> __('The upload was cancelled because of upload directory isn\'t writable','cloudfw'), 
				'key' 	=> 'cancel'
			); break;

		case 9012: 
			$out = array(
				'msg' 	=> __('Icon Set Imported','cloudfw'), 
				'key' 	=> 'add'
			); break;
		case 9013: 
			$out = array(
				'msg' 	=> __('The action has been canceled. Please select some skin to backup','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 9014: 
			$out = array(
				'msg' 	=> __('Error: The Zip File Cannot Opened','cloudfw'), 
				'key' 	=> 'cancel'
			); break;
		case 9015: 
			$out = array(
				'msg' 	=> __('Please Upload A Zip File','cloudfw'), 
				'key' 	=> 'cancel'
			); break;

		case 9021: 
			$out = array(
				'msg' 	=> __('The type of uploaded file is not valid','cloudfw'), 
				'key' 	=> 'error'
			); break;
		case 9022: 
			$out = array(
				'msg' 	=> __('The action cannot complated.','cloudfw'), 
				'key' 	=> 'error'
			); break;

	}
		
	return apply_filters('cloudfw_admin_messages', $out, $message_id);
}