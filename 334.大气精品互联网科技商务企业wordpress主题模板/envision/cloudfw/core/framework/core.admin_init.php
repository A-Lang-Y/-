<?php

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
	die("Sorry, but you can't access this page directly.");
}

add_action('admin_init', 'cloudfw_upgrader_admin_init');

function cloudfw_upgrader_admin_init() {

	if(isset($_GET['action']) && $_GET['action'] == 'CloudFw_Theme_Update') {
		require_once(TMP_PATH.'/cloudfw/core/classes/class.upgrader.php');    
		$upgrader = new upgradeHelper();
		$upgrader->check();
	}

}

/**
 *	Adds Filter for WP Data Importing
 */
add_filter( 'wp_import_post_meta', 'wp_import_post_meta_cb', 11, 3 );
function wp_import_post_meta_cb( $data, $post_id, $post ){

	foreach ($data as $key => $value) {

		if ( $value['key'] == PFIX . '_composer' ) {		
			$data[ $key ]['value'] = cloudfw_unserialize( $value['value'] );
		}

	}

	return $data;

}

/**
 *	Disable theme updates
 */
function cloudfw_return_null(){
	return null;
}
remove_action( 'load-update-core.php', 'wp_update_themes' );
add_filter( 'pre_site_transient_update_themes', 'cloudfw_return_null' );
add_filter( 'auto_update_theme', '__return_true' );
add_filter( 'auto_update_plugin', '__return_true' );

/**
 *  Register CloudFw Menus For WP Admin
 *
 *  @since 1.0
**/
function cloudfw_setup_menu(){
	global $cloudfw_setting_slug, $cloudfw_slider_slug, $theme_doc_slug, $_opt;
	$last_version = cloudfw_need_update();

	$who_can_see =  cloudfw_get_option('framework', 'who_can_see');
	$menu_title =  cloudfw_get_option('framework', 'title');

	if ( cloudfw_user_can_see( (int) cloudfw_get_option('framework', 'who_can_see'), 'administrator', 'theme_control_panel' ) ) {
		add_menu_page($menu_title . ' - ' . __('Settings', 'cloudfw') . ' - CloudFW', $menu_title . _if($last_version, '<span class="update-plugins cloudfw-notify"><span class="plugin-count">'.$last_version.'</span></span>'), 'manage_options', $cloudfw_setting_slug, 'cloudfw_setup_setting', '', 701);


		extract( cloudfw_detect_admin_tabs( cloudfw_get_admin_tab_slug() ) );
	 
		if ($cloudfw_nav_pages) {
			ksort( $cloudfw_nav_pages );
			foreach ($cloudfw_nav_pages as $nav_page ) {

				add_submenu_page(
					$cloudfw_setting_slug,
					$nav_page["page_title"], 
					$nav_page["page_title"], 
					'manage_options', 
					$cloudfw_setting_slug.'&tab=' . $nav_page["page_slug"], 
					'__return_false'
				);
				
			};
		}


	}

	if ( cloudfw_user_can_see( 'slider_manager', 'administrator', 'theme_slider_manager' ) )
		add_menu_page($menu_title . ' - Slider Manager - CloudFW', __("Slider Manager", "cloudfw"), 'manage_options', $cloudfw_slider_slug, 'cloudfw_setup_slider', '', 702);        

}
	

add_action('admin_menu', 'cloudfw_setup_menu');


/**
 *    Load Other Framework Pages
 */
function cloudfw_wp_load(){
	$do = isset($_GET['do']) ? $_GET['do'] : NULL;

	switch ($do) {
		case 'CloudFw_Export':
			require( CLOUDFW_PATH . '/get/cloudfw.transfer.php' );
			break;
		default:
			break;
	}

}
add_action('load-admin.php', 'cloudfw_wp_load');


/**
 *   Get Tab Slug 
 *
 *    @since 3.0
 */
function cloudfw_get_admin_tab_slug(){
	return isset($_GET['tab']) ? $_GET['tab'] : NULL;
}

/**
 *    Detect Tab Pages
 *
 *    @since 1.0
 */
function cloudfw_detect_admin_tabs( $tab = NULL, $map = array() ){
	global $cloudfw_nav_pages, $cloudfw_current_page_number;

	if ( !$cloudfw_nav_pages ){
		
		if ( !$map )
			$map = cloudfw_get_schemes('theme');

		foreach ($map as $page_number => $page):
			if ($page['type'] == 'page'){
				if (!$page['page'])
					$page['page'] = 'dashboard';

				if ( isset( $page['condition'] ) ) {
					if ( !$page['condition'] )
						continue;
				}
					
				$cloudfw_nav_pages[$page_number] = $page[$page['page']];

				if ( $tab == $cloudfw_nav_pages[$page_number]['page_slug'] )
					$cloudfw_current_page_number = $page_number;
			}
		endforeach;

	}

	return array( 'cloudfw_nav_pages' => $cloudfw_nav_pages, 'cloudfw_current_page_number' => $cloudfw_current_page_number );
}

/**
 *    Detect Tab Pages
 *
 *    @since 1.0
 */
function cloudfw_detect_spec_tabs( $tabs_name = NULL, $tab = NULL, $map = array() ){
	global $cloudfw_cache_tabs, $cloudfw_current_page_number;

	if ( isset( $cloudfw_cache_tabs[ $tabs_name ] ) )
		return $cloudfw_cache_tabs[ $tabs_name ];
	else
	{
		
		if ( !$map )
			$map = cloudfw_get_schemes('theme');

		foreach ($map as $page_number => $page):
			if ($page['type'] == 'page'){
				if ( isset( $page['condition'] ) ) {
					if ( !$page['condition'] )
						continue;
				}

				$pages[$page_number] = $page[$page['page']];
				if ( isset( $page['is_current'] ) ) {
					if ( $page['is_current'] )
						$cloudfw_current_page_number = $page_number;
				} else {

					if ( $tab == $pages[$page_number]['page_slug'] )
						$cloudfw_current_page_number = $page_number;
				}
			}
		endforeach;

		if ( !$cloudfw_current_page_number ) {
			reset($map);
			$cloudfw_current_page_number = key($map);
		}

		return $cloudfw_cache_tabs[ $tabs_name ] = array( 'cloudfw_nav_pages' => $pages, 'cloudfw_current_page_number' => $cloudfw_current_page_number );
	}

}

/**
 *  Set CloudFW Panel Scheme
 *
 *  @since 1.0
 */
function cloudfw_setup_setting(){
	global $_opt, $cloudfw_setting_slug, $cloudfw_nav_pages, $cloudfw_current_page_number;
	
	$tab    = cloudfw_get_admin_tab_slug();
	$lastID = '';
	$map    = cloudfw_get_schemes('theme');

	extract( cloudfw_detect_admin_tabs( $tab, $map ) );
	
	$current_page = $map[$cloudfw_current_page_number];

	$current_page_data = $current_page[$current_page['page']];
	$the_data = $current_page['data'];
	
	require(TMP_PATH.'/cloudfw/core/framework/cloudfw.render.php');
}

/**
 *  Set CloudFW Panel Scheme
 *
 *  @since 1.0
 */
function cloudfw_setup_slider(){
	global $_opt, $cloudfw_setting_slug, $cloudfw_nav_pages, $cloudfw_current_page_number;
	
	$tab    = cloudfw_get_admin_tab_slug();
	$map    = cloudfw_get_schemes('slider_management');
	$id     = isset($_GET['id']) ? $_GET['id'] : NULL;


	unset($cloudfw_nav_pages);
	extract( cloudfw_detect_spec_tabs( 'slider_tabs', $tab, $map ) );
	
	$current_page = $map[$cloudfw_current_page_number];

	$current_page_data = isset($current_page[$current_page['page']]) ? $current_page[$current_page['page']] : NULL;
	$the_data = isset($current_page['data']) ? $current_page['data'] : NULL;
	
	require(TMP_PATH.'/cloudfw/core/framework/cloudfw.render.php');
}

/**
 *    Call the Notifier
 */
include_once(TMP_PATH.'/cloudfw/core/classes/class.notifier.php');


/**
 *  CloudFw Installing Actions
 *
 *  @since 1.0
**/
function cloudfw_installer() {
	global $cloudfw_setting_slug;
	update_option( PFIX . '_version', CLOUDFW_THEMEVERSION );

	if (file_exists(TMP_PATH.'/cloudfw/core/others/core.installation.php')){
			require(TMP_PATH.'/cloudfw/core/others/core.installation.php');
	} else {
		wp_die('File Cannot Found:'. TMP_PATH.'/cloudfw/core/others/core.installation.php');
	}

	do_action( 'cloudfw_install' );
}

/**
 *  Run CloudFw Installing Actions
 *
 *  @since 1.0
**/
if ( defined('CLOUDFW_INSTALLING') && CLOUDFW_INSTALLING ) {
	if ( is_admin() )
		cloudfw_installer();
}

/**
 *  CloudFw Uninstalling Actions
 *
 *  @since 1.0
 */
add_action('switch_theme', 'cloudfw_uninstaller');
function cloudfw_uninstaller(){
	wp_clear_scheduled_hook('remove_cache_files');

	do_action( 'cloudfw_uninstall' );
}

/**
 *  Load CSS Files For Admin Panel
 *
 *  @since 1.0
 */
add_action('admin_print_styles', 'cloudfw_admin_styles');
function cloudfw_admin_styles(){  
	wp_enqueue_style('thickbox');
	
	wp_enqueue_style('cloudfw-main-style', TMP_ADMIN . '/css/style.admin.css', false, cloudfw_get_combined_version(), 'screen');
	wp_enqueue_style('cloudfw-composer-style', TMP_ADMIN . '/css/style.composer.css', false, cloudfw_get_combined_version(), 'screen');

	if (is_theme_setting_page() || is_theme_setting_page("menu")) {
		wp_enqueue_style('cloudfw-animated', TMP_ADMIN . '/css/animated.css', false, cloudfw_get_combined_version(), 'screen');
	}
	
	wp_enqueue_style('cloudfw-colorpicker-style', TMP_ADMIN . '/js/colorpicker/css/colorpicker.css', false, cloudfw_get_combined_version(), 'screen');
	wp_enqueue_style('cloudfw-fg', TMP_ADMIN . '/js/ddmenu/menu.css', false, cloudfw_get_combined_version(), 'screen');
	wp_enqueue_style('cloudfw-text-editor', TMP_ADMIN . '/js/markitup/markitup.css', false, cloudfw_get_combined_version(), 'screen');

}

add_action('admin_print_scripts', 'cloudfw_admmin_scripts');
function cloudfw_admmin_scripts(){
	global $pagenow, $cloudfw_setting_slug, $cloudfw_slider_slug; 

	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery-ui-core");
	wp_enqueue_script("jquery-ui-tabs");
	wp_enqueue_script("jquery-ui-sortable");
	wp_enqueue_script("jquery-ui-draggable");
	wp_enqueue_script("jquery-ui-droppable");
	wp_enqueue_script("jquery-ui-selectable");
	//wp_enqueue_script("jquery-ui-dialog");
	wp_enqueue_script("jquery-ui-slider");
	wp_enqueue_script('cloudfw-pack', TMP_ADMIN . '/js/pack.js', array(), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-ddmenu', TMP_ADMIN . '/js/ddmenu/menu.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-functions', TMP_ADMIN . '/js/functions.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-ui', TMP_ADMIN . '/js/cloudfw-ui.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-notifications', TMP_ADMIN . '/js/notifications.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-shortcode-generator', TMP_ADMIN . '/js/shortcode-generator.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-composer', TMP_ADMIN . '/js/composer.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-script', TMP_ADMIN . '/js/script.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-nav-menu', TMP_ADMIN . '/js/nav_menu.js', array('jquery'), cloudfw_get_combined_version());
	
	if ( is_theme_setting_page('slider') ) {
		wp_enqueue_script('cloudfw-slider-management', TMP_ADMIN . '/js/slider-management.js', array('jquery'), cloudfw_get_combined_version());
	}

	wp_enqueue_script('cloudfw-picker', TMP_ADMIN . '/js/colorpicker/js/colorpicker.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-picker-eye', TMP_ADMIN . '/js/colorpicker/js/eye.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-picker-utils', TMP_ADMIN . '/js/colorpicker/js/utils.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-fileinput', TMP_ADMIN . '/js/fileinput.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-fileuploader', TMP_ADMIN . '/js/fileuploader.js', array('jquery'), cloudfw_get_combined_version());
	wp_enqueue_script('cloudfw-zclip', TMP_ADMIN . '/js/zclip/jquery.zclip.min.js', array('jquery'), cloudfw_get_combined_version(), true);
	wp_enqueue_script('cloudfw-text-editor', TMP_ADMIN . '/js/markitup/jquery.markitup.js', array('jquery'), cloudfw_get_combined_version());

	if ( $pagenow != 'tools.php' ) {
		wp_enqueue_media();
	}


}

/**
 *    Admin Init
 *
 *    @since 3.0
 */
add_action('admin_print_scripts', 'cloudfw_admin_scripts_options', 0);
function cloudfw_admin_scripts_options(){
	global $blog_id, $current_site;

	cloudfw_set_js('_wpnonce', wp_create_nonce() );
	cloudfw_set_js('cloudfw_nonce', wp_create_nonce('cloudfw') );
	cloudfw_set_js('pfix', PFIX );
	cloudfw_set_js('url', TMP_URL );
	cloudfw_set_js('tmpurl', TMP_ADMIN );
	cloudfw_set_js('ajaxUrl', cloudfw_ajax_url() );
	cloudfw_set_js('themeName', CLOUDFW_THEMENAME );
	cloudfw_set_js('themeVersion', CLOUDFW_THEMEVERSION );

	cloudfw_set_js('zclipSwf', TMP_ADMIN . '/js/zclip/ZeroClipboard.swf' );
	cloudfw_set_js('textSending', __('Saving...', 'cloudfw') );
	cloudfw_set_js('textSaved', __('Saved', 'cloudfw') );
	cloudfw_set_js('textError', __('Error!', 'cloudfw') );
	cloudfw_set_js('textUpdate', __('Update', 'cloudfw') );
	cloudfw_set_js('textSendTheEditor', __('Insert Into The Input', 'cloudfw') );
	cloudfw_set_js('textDuplicateSkin', __('Duplicate Skin', 'cloudfw') );
	cloudfw_set_js('textDuplicatingSkin', __('Duplicating...', 'cloudfw') );
	cloudfw_set_js('textDelete', __('Delete', 'cloudfw') );
	cloudfw_set_js('textDeleting', __('Deleting...', 'cloudfw') );
	cloudfw_set_js('textCancel', __('Cancel', 'cloudfw') );
	cloudfw_set_js('textUpload', __('Upload', 'cloudfw') );
	cloudfw_set_js('textSelecFromLibrary', __('Media Library', 'cloudfw') );
	cloudfw_set_js('textRemove', __('Remove', 'cloudfw') );
	cloudfw_set_js('textDropFiles', __('Drop files here to upload', 'cloudfw') );
	
	cloudfw_set_js('textCompSwitchtoClassic', __('Switch to Classic Editor', 'cloudfw') );
	cloudfw_set_js('textCompSwitchtoComp', __('Switch to Content Composer', 'cloudfw') );
	cloudfw_set_js('textCompDoneEditing', __('Done Editing', 'cloudfw') );

	$image_path = $_SERVER['DOCUMENT_ROOT'];
	if (isset($image_path_exploded[1])) {
		$image_path .= $image_path_exploded[1];
	}
	
	cloudfw_set_js('cloudfw_multisite', cloudfw_is_multisite() );
	cloudfw_set_js('cloudfw_image_path', $image_path );
	cloudfw_set_js('blogId', $blog_id );
}

/**
 *    Render CloudFw Javascript Options on Admin Area
 *
 *    @since 1.0
 */
add_action  ('admin_print_scripts', 'cloudfw_render_js_options', 1);

/**
 *    CloudFw Fonts - Run Init Admin
 *
 *    @since 3.0
 */
add_action  ('admin_head', 'cloudfw_fontface_init_admin');
add_action  ('admin_head', 'cloudfw_cufon_init_admin');

if ( is_theme_setting_page('widget') )
	add_action  ('admin_head', 'cloudfw_widget_page_scripts', 1);

function cloudfw_widget_page_scripts(){ ?>

	<script type="text/javascript">
	// <![CDATA[
	
		jQuery(document).ready(function(){
			"use strict";

			jQuery('div.widgets-sortables').on( "sortdeactivate", function(event, ui) {
				cloudfw_main();
			});

			jQuery('div.widgets-sortables').on( "sortbeforestop", function(event, ui) {
				var that    = jQuery(this),
					item    = ui.item,
					json    = item.find('#json-widget_options'),
					error   = false;

				item.addClass('ITEM');

				if ( json.length ) {
					var options_raw =json.html();
					if ( options_raw != '' ) {

						try { var option = jQuery.parseJSON( options_raw ); } catch(e){}

						if ( typeof option == 'object' ) {
							var parent = item.parents('.widgets-sortables').first();

							/**
							 *    IN
							 */
							if ( !error && option.in ) {
								if( typeof option.in !== 'object' ) {
									option.in = [ option.in ];
								}

								error = true;
								jQuery.each( option.in, function( k,v ){
									if ( !error )
										return true;

									if ( parent.attr('id') == v )
										error = false;

								});

								if ( error ) {
									cloudfw_dialog("Action Cancelled!", "You cannot add the widget into this sidebar area.", "cancel");
								}

							}

							/**
							 *    NOT IN
							 */
							if ( !error && option.not_in ) {
								if( typeof option.not_in !== 'object' ) {
									option.not_in = [ option.not_in ];
								}
								
								jQuery.each( option.not_in, function( k,v ){
									if ( error )
										return true;

									if ( parent.attr('id') == v )
										error = true;

								});
								
								if ( error ) {
									cloudfw_dialog("Action Cancelled!", "You cannot add the widget into this sidebar area.", "cancel");
								}

							}




						}
					}
				}

				if ( error ) {
					//that.sortable('cancel');
					console.log('ERROR');
					item.remove();

				} else {
					cloudfw_main();
				}

			});

			jQuery('#widget-list').find('[id*="cloudfw"]').each(function(){
				jQuery(this).addClass('cloudfw-widget');
			});

		});
 
	// ]]>
	</script>

<?php }


/**
 *  Add CloudFw Menu into The Admin Bar
 *
 *  @since 1.0
**/
add_action( 'admin_bar_menu', 'cloudfw_admin_bar', 99 );
function cloudfw_admin_bar() {
	
	if ( !is_super_admin() || !is_admin_bar_showing() )
		return;
	
	global $wp_admin_bar, $cloudfw_setting_slug, $cloudfw_slider_slug;
 
	if ( cloudfw_user_can_see( (int) cloudfw_get_option('framework', 'who_can_see'), 'administrator', 'theme_control_panel' ) ) {
		$menu_title =  cloudfw_get_option('framework', 'title');
		$wp_admin_bar   ->  add_menu( array(
			'id'            => 'cloudfw',
			'title'         => $menu_title,
			'href'          => admin_url('admin.php?page='.$cloudfw_setting_slug)
		) );
		
	}


	if ( cloudfw_user_can_see( 'slider_manager', 'administrator', 'theme_slider_manager' ) ) {
 
		$wp_admin_bar   ->  add_menu( array(
			'id'            => 'cloudfw_sliders',
			'title'         => __('Slider Manager','cloudfw'),
			'href'          => admin_url('admin.php?page='.$cloudfw_slider_slug)
		) );
		
	} 

	extract( cloudfw_detect_admin_tabs( cloudfw_get_admin_tab_slug() ) );
 
	if ($cloudfw_nav_pages) {
		ksort( $cloudfw_nav_pages );
		foreach ($cloudfw_nav_pages as $nav_page ) {
			
			$wp_admin_bar   ->  add_menu( array(
					'id'          => 'cloudfw-'.$nav_page["page_slug"],
					'parent'      => 'cloudfw',
					'title'       => ucwords($nav_page["page_title"]),
					'href'        => admin_url("admin.php?page=".$cloudfw_setting_slug."&amp;tab=".$nav_page["page_slug"]."")
			 ) );
			
		};
	}
 
}

/**
 *  Menu Icons On Admin Panel
 *
 *  @since 1.0
 */
add_action('admin_head', 'cloudfw_admin_icons');
function cloudfw_admin_icons(){
?>
<style type="text/css" media="screen">
	#toplevel_page_CloudFW .wp-menu-image a img,
	#toplevel_page_CloudFW_Slider .wp-menu-image a img{
		display:none !important;
	}

	#toplevel_page_CloudFW .wp-menu-image {
		background: url('<?php echo TMP_ADMIN_GUI; ?>/icons/cloudfw.png') no-repeat -2px -2px !important;
	}
	#toplevel_page_CloudFW:hover .wp-menu-image {
		background-position:-2px -34px !important;
	}
	#toplevel_page_CloudFW.current .wp-menu-image {
		background-position:-2px -66px !important;
	}

	.branch-3-8 #toplevel_page_CloudFW .wp-menu-image {
		background-position: 50% 1px !important;
	}
	.branch-3-8 #toplevel_page_CloudFW:hover .wp-menu-image {
		background-position: 50% -31px !important;
	}
	.branch-3-8 #toplevel_page_CloudFW.current .wp-menu-image {
		background-position: 50% -63px !important;
	}

	#menu-posts-slider .wp-menu-image,
	#toplevel_page_CloudFW_Slider .wp-menu-image {
		background: url('<?php echo TMP_ADMIN_GUI; ?>/icons/monitor_.png') no-repeat -2px -2px !important;
	}
	#menu-posts-slider:hover .wp-menu-image, #menu-posts-slider.wp-menu-open .wp-menu-image,
	#toplevel_page_CloudFW_Slider.current .wp-menu-image,
	#toplevel_page_CloudFW_Slider:hover .wp-menu-image, #toplevel_page_CloudFW_Slider.wp-menu-open .wp-menu-image {
		background-position:-2px -34px !important;
	}
	#menu-posts-portfolio .wp-menu-image {
		background: url('<?php echo TMP_ADMIN_GUI; ?>/icons/portfolio_.png') no-repeat -2px -2px !important;
	}
	#menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-menu-open .wp-menu-image,
	#toplevel_page_CloudFW_Slider:hover .wp-menu-image, #toplevel_page_CloudFW_Slider.wp-menu-open .wp-menu-image {
		background-position:-2px -34px !important;
	}

	.branch-3-8 #menu-posts-slider .wp-menu-image,
	.branch-3-8 #toplevel_page_CloudFW_Slider .wp-menu-image,
	.branch-3-8 #menu-posts-portfolio .wp-menu-image {
		background-image: none !important;
	}

	.branch-3-8 #toplevel_page_CloudFW .wp-menu-image:before,
	#toplevel_page_CloudFW .wp-menu-image img,
	#toplevel_page_CloudFW_Slider .wp-menu-image img,
	#menu-posts-portfolio .wp-menu-image img { 
		display: none !important;
	}

	#favorite-actions {
		min-width: 200px !important;
	}
</style>
<?php
}

/**
 *  CloudFw Quick Tags
 *
 *  @since 1.0
 */
function cloudfw_include_quicktags(){
	require(TMP_PATH.'/cloudfw/core/others/core.quicktags.php');
}
if ( is_theme_setting_page('editor') ) {
	add_action('admin_footer-post-new.php', 'cloudfw_include_quicktags');
	add_action('admin_footer-post.php', 'cloudfw_include_quicktags');
}