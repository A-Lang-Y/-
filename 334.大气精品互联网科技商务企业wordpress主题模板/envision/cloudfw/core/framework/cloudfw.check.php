<?php
/**
 *	Check PHP version is compatible with the theme or not
 *
 *	@since 1.0
 */
if ( version_compare(PHP_VERSION, CLOUDFW_MINPHPVERSION, '<') ) {
	$error_message = '<strong>'.__('Warning','cloudfw').':</strong>';
	$error_message.= '<br/>';
	$error_message.= sprintf( __('Sorry, this template will only run on PHP version %1$s or greater! Current version: %2$s','cloudfw'), CLOUDFW_MINPHPVERSION, PHP_VERSION );

	if ( defined('WP_DEFAULT_THEME') )
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	wp_die( $error_message, __('CloudFw Error','cloudfw') ); 
	exit;
}

/**
 *	Check WP version is compatible with the theme or not
 *
 *	@since 1.0
 */
if ( version_compare( CLOUDFW_WPVERSION , CLOUDFW_MINWPVERSION, '<') ) {
	$error_message = '<strong>'.__('Warning','cloudfw').':</strong>';
	$error_message.= '<br/>';
	$error_message.= sprintf( __('Sorry, this template will only run on WordPress %1$s or greater! (Current version: %2$s)','cloudfw'), CLOUDFW_MINWPVERSION, get_bloginfo('version') );

	if ( defined('WP_DEFAULT_THEME') )
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	wp_die( $error_message, __('CloudFw Error','cloudfw') ); 
	exit;
}

/**
 *	Check is the theme in the correct folder
 *
 *	@since 2.3
 */

if ( basename( dirname( CLOUDFW_TMP_PATH ) ) !== 'themes' ) {
	$theme_folder  = basename( CLOUDFW_TMP_PATH );
	$true_folder   = str_replace( '/', '\\', ABSPATH . basename(content_url('themes')) ) .'\\';
	$wrong_folder  = dirname( CLOUDFW_TMP_PATH ).'\\';

	$error_message = '<strong>'.__('Warning','cloudfw').':</strong>';
	$error_message.= '<br/>';
	$error_message.= __('It seems that you uploaded all folders in the theme package that downloaded by you from ThemeForest, to the themes folder of WordPress.','cloudfw');
	$error_message.= '<br/><br/>';
	$error_message.= sprintf( __('The theme folder (%3$s/) in the theme package has to be in <em>%1$s</em> folder, not in <em>%2$s</em> folder.' ,'cloudfw'),
		$true_folder,	
		$wrong_folder,
		$theme_folder
	);
	$error_message.= '<br/><br/>';
	$error_message.= '<strong>'.__('Solution','cloudfw').':</strong>';
	$error_message.= '<br/>';
	$error_message.= sprintf( __('You should move or copy the "%3$s/" folder into <em>%1$s</em> folder. Then delete <em>%2$s</em> folder and re-activate the theme.' ,'cloudfw'),
		$true_folder,	
		$wrong_folder,
		$theme_folder
	);

	if ( defined('WP_DEFAULT_THEME') )
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	wp_die( $error_message, __('CloudFw Error','cloudfw') );
}

/**
 *	Check Upload Folders
 *
 *	@since 1.0
 */	
function cloudfw_check_upload_folders(){
	/*if ( ! cloudfw_is_writable( CLOUDFW_UPLOADDIR ) === true ) {
		add_action( 'network_admin_notices', 'cloudfw_check_upload_folder_message', 4 );
		add_action( 'admin_notices', 'cloudfw_check_upload_folder_message', 1 );
	}*/

	if ( ! cloudfw_is_writable( CACHE_DIR_BASE ) === true  ) {
		add_action( 'network_admin_notices', 'cloudfw_check_cache_folder_message', 4 );
		add_action( 'admin_notices', 'cloudfw_check_cache_folder_message', 1 );
	}

}

function cloudfw_check_upload_folder_message() {
  
      printf ("<div class='cloudfw-update-messages error'>%s</div>",
      sprintf ("<div style='padding:15px;'>%s</div>", 
		sprintf ( __('Error: %s folder is not writable. Please adjust the chmod permissions to allow it to be written to.','cloudfw') , '<strong>'. CLOUDFW_UPLOADDIR . '</strong>' )       
      )
    
    );
}

function cloudfw_check_cache_folder_message() {
  
      printf ("<div class='cloudfw-update-messages error'>%s</div>",
      sprintf ("<div style='padding:15px;'>%s</div>", 
		sprintf ( __('Error: %s folder is not writable. Please adjust the chmod permissions to allow it to be written to.','cloudfw') , '<strong>' . CACHE_DIR_BASE . '</strong>')       
      )
    
    );
}

if ( ! get_option('embed_autourls') )
	update_option('embed_autourls',1);