<?php
/**
 *    Register Shortcode Groups
 */
if ( is_admin() )
	cloudfw_register_shortcode_groups();

function cloudfw_register_shortcode_groups(){
	global $CloudFw_Shortcodes;

	/** Register Shortcode Groups */
	$CloudFw_Shortcodes->group_register( 'columns' , 5 , array( 'title' =>  __('Columns','cloudfw') ) );
	$CloudFw_Shortcodes->group_register( 'style'   , 15, array( 'title' =>  __('Style Codes','cloudfw') ) );
	$CloudFw_Shortcodes->group_register( 'advanced', 25, array( 'title' =>  __('Advanced','cloudfw') ) );
	$CloudFw_Shortcodes->group_register( 'social',   35, array( 'title' =>  __('Social Services','cloudfw') ) );

	/** Register Composer Groups */
	$CloudFw_Shortcodes->composer_group_register( 'composer_layouts',   5,  array( 'title' =>  __('Layouts','cloudfw') ) );
	$CloudFw_Shortcodes->composer_group_register( 'composer_widgets',   10, array( 'title' =>  __('Widgets','cloudfw') ) );
	$CloudFw_Shortcodes->composer_group_register( 'composer_post_list',  15, array( 'title' =>  __('Post Lists','cloudfw') ) );
}

/**
 *  Load all environment units of the theme
 *  Hooks: wp_print_styles, wp_print_scripts, wp_head
*/
/** Css */
function cloudfw_load_css(){
	$version = cloudfw_get_combined_version();

	wp_register_style ('theme-bootstrap', TMP_CSS . 'bootstrap.css', NULL, $version);
	wp_register_style ('theme-bootstrap-responsive', TMP_CSS . 'bootstrap-responsive.css', NULL, $version);
	wp_register_style ('theme-bootstrap-responsive-1170', TMP_CSS . 'bootstrap-responsive-1170.css', NULL, $version);
	wp_register_style ('theme-frontend-responsive', TMP_CSS . 'responsive.css', NULL, $version);
	wp_register_style ('theme-frontend-style', TMP_CSS . 'style.css', NULL, $version);
	wp_register_style ('theme-frontend-style-rtl', TMP_CSS . 'rtl.css', NULL, $version);
	wp_register_style ('theme-frontend-extensions', TMP_CSS . 'extensions.css', NULL, $version);
	wp_register_style ('theme-frontend-retina', TMP_CSS . 'retina.css', NULL, $version);
	wp_register_style ('theme-frontend-colors', TMP_CSS . 'colors.css', NULL, $version);
	wp_register_style ('theme-frontend-fonts', TMP_CSS . 'fonts.css', NULL, $version);
	wp_register_style ('theme-child-frontend-style', CHILD_TMP_URL . 'style.css', NULL, $version);
	wp_register_style ('theme-child-frontend-style-rtl', CHILD_TMP_URL . 'rtl.css', NULL, $version);
	wp_register_style ('theme-woocommerce', TMP_CSS . 'woocommerce.css',   NULL, $version);
	wp_register_style ('theme-bbpress', TMP_CSS . 'bbpress.css',   NULL, $version);
	wp_register_style ('theme-custom', TMP_CSS . 'custom.css', NULL, $version);

	wp_enqueue_style('theme-bootstrap');

	if ( ! is_child_theme() ) {
		wp_enqueue_style('theme-frontend-style');
	} else {
		wp_enqueue_style('theme-child-frontend-style');
	}

	if ( file_exists( TMP_CSS_PATH.'extensions.css' ) ) {
		wp_enqueue_style ('theme-frontend-extensions');
	}

	/** Load stylesheets for responsive layout */
	if ( cloudfw_is_responsive() ) {
		if ( cloudfw_get_option('global', 'width') == '1170' ) {
			wp_enqueue_style('theme-bootstrap-responsive-1170');
		}

		wp_enqueue_style('theme-bootstrap-responsive');

		if ( file_exists( TMP_CSS_PATH.'responsive.css' ) ) {
			wp_enqueue_style ('theme-frontend-responsive');
		}
	}

	if ( file_exists( TMP_CSS_PATH.'colors.css' ) ) {
		wp_enqueue_style ('theme-frontend-colors');
	}

	if ( file_exists( TMP_CSS_PATH.'fonts.css' ) ) {
		wp_enqueue_style ('theme-frontend-fonts');
	}

	if ( cloudfw_woocommerce() && file_exists( TMP_CSS_PATH.'woocommerce.css' ) ) {
		wp_enqueue_style('theme-woocommerce');
	}

	if ( cloudfw_bbpress() && file_exists( TMP_CSS_PATH.'bbpress.css' ) ) {
		wp_enqueue_style('theme-bbpress');
	}

	if ( cloudfw_is_retina() && file_exists( TMP_CSS_PATH.'retina.css' ) ) {
		wp_enqueue_style('theme-frontend-retina');
	}


	if ( ! is_child_theme() ) {
		if ( is_rtl() ) {
			wp_enqueue_style('theme-frontend-style-rtl');
		}
	} else {
		if ( is_rtl() ) {
			wp_enqueue_style('theme-child-frontend-style-rtl');
		}
	}


	/** Check Custom CSS File */
	if ( file_exists( TMP_CSS_PATH.'custom.css' ) ) {
		wp_enqueue_style ('theme-custom');
	}

	do_action('cloudfw_css');
}

/** Javascripts */
function cloudfw_load_javascripts(){
	$version = cloudfw_get_combined_version();

	global $pagenow;
	if ( isset($pagenow) && $pagenow == 'wp-login.php' ) {
		do_action( 'cloudfw_head' );
	}

	cloudfw_render_js_options();

	/** Core Scripts */
	wp_register_script ('theme-common', TMP_JS . 'common.js', NULL, $version, false);
	wp_register_script ('theme-modernizr', TMP_JS . 'modernizr-2.6.2-respond-1.1.0.min.js', NULL, $version, false);
	wp_register_script ('theme-noconflict', TMP_JS . 'noconflict.js', array( 'jquery' ), $version, false);
	wp_register_script ('theme-cufon', TMP_JS . 'cufon.js', array( 'jquery' ), $version, true);
	wp_register_script ('theme-webfont', TMP_ADMIN.'/js/webfont.js', array( 'jquery' ), $version, false);
	wp_register_script ('theme-extensions', TMP_JS . 'extensions.js', NULL, $version, true);
	wp_register_script ('theme-retina', TMP_JS . 'retina.js', array( 'jquery' ), $version, true);

	/** Scripts */
	wp_register_script ('theme-woocommerce', TMP_JS . 'woocommerce.js', NULL, $version, true);
	wp_register_script ('theme-mousewheel', TMP_JS . 'jquery.mousewheel.min.js', NULL, $version, true);
	wp_register_script ('theme-touchSwipe', TMP_JS . 'jquery.touchSwipe.min.js', NULL, $version, true);
	wp_register_script ('theme-prettyphoto', TMP_JS . 'jquery.prettyPhoto.js', NULL, $version, true);
	wp_register_script ('theme-flexslider', TMP_JS . 'jquery.flexslider.js', NULL, $version, true);
	wp_register_script ('theme-waypoints', TMP_JS . 'waypoints.min.js', NULL, $version, true);
	wp_register_script ('theme-waypoints-sticky', TMP_JS . 'waypoints-sticky.js', array('theme-waypoints'), $version, true);
	wp_register_script ('theme-viewport', TMP_JS . 'jquery.viewport.mini.js', NULL, $version, true);
	wp_register_script ('theme-isotope', TMP_JS . 'jquery.isotope.js', NULL, $version, true);
	wp_register_script ('theme-masonry', TMP_JS . 'jquery.masonry.js', NULL, $version, true);
	wp_register_script ('theme-packery', TMP_JS . 'packery.pkgd.min.js', NULL, $version, true);
	wp_register_script ('theme-queryloader2', TMP_JS . 'queryloader2.js', NULL, $version, false);
	wp_register_script ('theme-smoothscroll', TMP_JS . 'jquery.smoothscroll.js', NULL, $version, true);
	wp_register_script ('theme-fillparent', TMP_JS . 'jquery.fillparent.js', NULL, $version, true);

	/** Load Core Scripts */
	wp_enqueue_script ('jquery');
	wp_enqueue_script ('theme-common');
	wp_enqueue_script ('theme-modernizr');
	wp_enqueue_script ('theme-noconflict');
	wp_enqueue_script ('theme-webfont');
	wp_enqueue_script ('theme-prettyphoto');

	if ( current_theme_supports('cufon') && cloudfw_check_onoff('cufon', 'enable') ) {
		wp_enqueue_script   ('theme-cufon');
		cloudfw_cufon_render_scripts();
	}

	/** Do action: Javascript */
	do_action('cloudfw_javascript');

	if ( file_exists( TMP_JS_PATH.'extensions.js' ) ) {
		wp_enqueue_script('theme-extensions');
	}

	if ( file_exists( TMP_JS_PATH.'woocommerce.js' ) && cloudfw_woocommerce() ) {
		wp_enqueue_script('theme-woocommerce');
	}

	/** Load Comment Reply Script */
	if (is_singular()) {
		wp_enqueue_script ('comment-reply');
	}

	if ( cloudfw_is_retina() ) {
		wp_enqueue_script ('theme-retina');
	}

}

/** Run the Environment Functions */
if ( !is_admin() ) {
	add_action  ('wp_print_styles',     'cloudfw_load_css', 1);
	add_action  ('wp_print_scripts',    'cloudfw_load_javascripts', 1);
}

/**
 *  CloudFw Register Fonts
 *
 *  @since 1.0
 */
 /* System Fonts */
cloudfw_register_font('default', 'Helvetica, Arial, sans-serif', 'Helvetica, Arial');
cloudfw_register_font('default', 'Tahoma, Geneva, sans-serif', 'Tahoma');
cloudfw_register_font('default', '\'Trebuchet MS\', Helvetica, Arial, sans-serif', 'Trebuchet MS');
cloudfw_register_font('default', '\'Times New Roman\', Times, serif', 'Times New Roman');
cloudfw_register_font('default', 'Georgia \'Times New Roman\', Times, serif', 'Georgia');
cloudfw_register_font('default', '\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif', 'Lucida Sans Unicode');
cloudfw_register_font('default', 'Verdana, Geneva, sans-serif', 'Verdana');
cloudfw_register_font('default', '\'Courier New\', Courier, monospace', 'Courier New, Monospace');


/**
 *  CloudFw Social Services
 *
 *  %1$s: URL
 *  %2$s: Title
 *
 *  @hook: cloudfw_social_services
 *  @since 1.0
 */
function cloudfw_social_services() {
	$social_services = array();
	$social_services["facebook"]    = array( "item_name" => "Facebook",     "item_regex" => 'http://www.facebook.com/share.php?u=%1$s&amp;t=%2$s' );
	$social_services["twitter"]     = array( "item_name" => "Twitter",      "item_regex" => 'http://twitter.com/share?url=%1$s&amp;text=%2$s' );
	$social_services["friendfeed"]  = array( "item_name" => "FriendFeed",   "item_regex" => 'http://www.friendfeed.com/share?link=%1$s&amp;title=%2$s' );
	$social_services["digg"]        = array( "item_name" => "Digg",         "item_regex" => 'http://digg.com/submit?url=%1$s&amp;title=%2$s' );
	$social_services["tumblr"]      = array( "item_name" => "Tumblr",       "item_regex" => 'http://www.tumblr.com/share?u=%1$s&amp;t=%2$s' );
	$social_services["delicious"]   = array( "item_name" => "Delicious",    "item_regex" => 'http://delicious.com/post?url=%1$s&amp;title=%2$s' );
	$social_services["myspace"]     = array( "item_name" => "Myspace",      "item_regex" => 'http://www.myspace.com/Modules/PostTo/Pages/?u=%1$s&amp;t=%2$s' );
	$social_services["linkedin"]    = array( "item_name" => "LinkedIn",     "item_regex" => 'http://www.linkedin.com/shareArticle?mini=true&amp;url=%1$s&amp;title=%2$s' );
	$social_services["mixx"]        = array( "item_name" => "Mixx",         "item_regex" => 'http://www.mixx.com/submit?page_url=%1$s&amp;title=%2$s' );
	$social_services["google"]      = array( "item_name" => "Google",       "item_regex" => 'http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=%1$s&amp;title=%2$s' );
	$social_services["netvibes"]    = array( "item_name" => "Netvibes",     "item_regex" => 'http://www.netvibes.com/share?url=%1$s&amp;title=%2$s' );
	$social_services["posterous"]   = array( "item_name" => "Posterous",    "item_regex" => 'http://posterous.com/share?linkto=%1$s&amp;title=%2$s'  );
	$social_services["reddit"]      = array( "item_name" => "Reddit",       "item_regex" => 'http://reddit.com/submit?url=%1$s&amp;title=%2$s' );
	$social_services["stumbleupon"] = array( "item_name" => "Stumbleupon",  "item_regex" => 'http://www.stumbleupon.com/submit?url=%1$s&amp;title=%2$s' );
	$social_services["technorati"]  = array( "item_name" => "Technorati",   "item_regex" => 'http://technorati.com/faves?add=%1$s' );
	$social_services["yahoo-buzz"]  = array( "item_name" => "Yahoo Buzz",   "item_regex" => 'http://buzz.yahoo.com/submit/?submitUrl=%1$s&amp;submitHeadline=%2$s' );
	return apply_filters('cloudfw_social_services', $social_services);
}

/**
 *  CloudFw Register PreDefined Patterns
 *
 *  [ID, Name, CSS Code, Group]
 *  @since 1.0
 */

cloudfw_register_skin_style(
	'wood-texture', 'Wood Texture  #1',
	'background-image: url('.TMP_URL.'/lib/patterns/wood_texture.png); background-repeat: repeat', __('Textures','cloudfw')
);

cloudfw_register_skin_style(
	'escheresque-texture', 'Dark Pattern #1',
	'background-image: url('.TMP_URL.'/lib/patterns/escheresque_ste.png); background-repeat: repeat', __('Textures','cloudfw')
);


/**
 *  Add Homepage Link Into the Navigation Menu
 *
 * @since 1. 0
 *
 */
if ( _check_onoff( cloudfw_get_option('global', 'homeitem') ) ) {
	add_filter( 'wp_nav_menu_objects', 'cloudfw_add_homepage_item_to_nav_menu', 10, 2 );
}

function cloudfw_add_homepage_item_to_nav_menu( $items, $args = array() ){

	if ( $args->theme_location == 'primary' && $args->depth == 0 ) {

		$item_home = array(
			'noconvert' => TRUE,
			'ID'        => 0,
			'db_id'     => 0,
			'filter'    => 'raw',
			'menu_item_parent'
						=> 0,
			'object'    => 'custom',
			'type'      => 'custom',
			'type_label'=> 'Custom',
			'title'     => cloudfw_translate('home'),
			'url'       => __home_url(),
		);

		$item_home['classes'][] = 'menu-item menu-item-type-custom menu-item-object-custom menu-item-home level-0 top-level-item';

		if ( is_front_page() ) {
			$item_home['classes'][] = 'current-menu-item';
		}


		if ( is_array( $items ) && !empty($items) ) {
			array_unshift($items, (object) $item_home);
		}

	}
	return $items;

}

/**
 *  Add Shortcode Support to Wdiget Texts
 *
 *  @since 1.0
**/
add_filter('the_title', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');