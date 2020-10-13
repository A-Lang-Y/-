<?php
do_action('cloudfw_theme_init');

/**
 *  Setup Function
 *
 *  @since 1.0
 */

add_theme_support( 'responsive' );
add_theme_support( 'retina' );
add_theme_support( 'woocommerce' );

add_action( 'after_setup_theme', 'cloudfw_setup_init', 0 );

if ( ! function_exists( 'cloudfw_setup_init' ) ) {  
	function cloudfw_setup_init() {

		/** Add support for feed links to be able to be created automaticaly */
		add_theme_support( 'automatic-feed-links' );

		/** Add support for a variety of post formats */
		add_theme_support( 'post-formats', array( 'image', 'video', 'gallery', 'link', 'quote' ) );


		/** Add support for post thumbnails */
		add_theme_support( 'post-thumbnails', apply_filters( 'cloudfw_post_thumbnails' , array( 'post' )) );

		//add_theme_support( 'cufon' );

		/** Register Navigation Menus */
		register_nav_menus( array(
				'primary'   => __( 'Navigation Menu', 'cloudfw' ),
				'footer'    => __( 'Footer Menu', 'cloudfw' ),
			) 
		);

		/** Set Javascript Options */
		/** Disable Admin Bar */
		//add_filter( 'show_admin_bar', '__return_false' );
	}
}

function cloudfw_set_js_options(){
	cloudfw_set_js('themeurl', TMP_URL );
	cloudfw_set_js('ajaxUrl', cloudfw_ajax_url() );
	cloudfw_set_js('device', 'widescreen' );
	cloudfw_set_js('RTL', is_rtl() );
	cloudfw_set_js('responsive', cloudfw_is_responsive() );
	cloudfw_set_js('lang', cloudfw_get_current_language() );
	cloudfw_set_js('sticky_header', cloudfw_check_onoff( 'header', 'sticky' ) );

	$sticky_offset = (int) cloudfw_get_option( 'header', 'sticky_offset' ); 
	
	if ( cloudfw_check_onoff( 'topbar', 'sticky' ) && $sticky_offset == 0 ) {
		$sticky_offset = 30;
	}

	cloudfw_set_js('sticky_header_offset', 0 - $sticky_offset );
	cloudfw_set_js('uniform_elements', cloudfw_check_onoff( 'global', 'uniform' ) );
	cloudfw_set_js('disable_prettyphoto_on_mobile', cloudfw_check_onoff( 'troubleshooting', 'disable_prettyphoto_on_mobile' ) );

	if ( class_exists('GFForms') ) {
		cloudfw_set_js('disable_gravity_uniform_select', cloudfw_check_onoff( 'troubleshooting', 'disable_gravity_uniform_select' ) );
	}
}

/**
 *    Add Skin Options
 *
 *    @since 1.0
 */
function cloudfw_add_skin_scheme( $location, $schemes, $scheme, $seq = 50){
	switch ( $location ) {
		case 'slider': $location = 80; break;
		case 'shortcode': $location = 81; break;
		case 'module': $location = 82; break;
		case 'widget': $location = 81; break;
		default: $location = 0; break;
	}

	if ( !$location ) {
		return cloudfw_error_message( 'Please set a location for the skin options.' );
	}


	$section = $schemes[$location]['data'];
	$schemes[$location]['data'][ cloudfw_id_for_sequence( $section, $seq ) ] = $scheme;
	return $schemes;
}

/**
 *    Add Module Options
 *
 *    @since 1.0
 */
function cloudfw_add_option_scheme( $location, $schemes, $scheme, $seq = 50 ){
	switch ( $location ) {
		case 'module':
			$schemes[35]['data'][ cloudfw_id_for_sequence( $schemes[35]['data'], $seq ) ] = $scheme;
			break;
		case 'translate':
			$schemes[36]['data'][ cloudfw_id_for_sequence( $schemes[36]['data'], $seq ) ] = $scheme;
			break;
	}
	return $schemes;
}

/**
 *  Cufon Defaults
 *
 *  @since 1.0
**/
add_filter( 'cloudfw_cufon_defaults', 'cloudfw_cufon_defaults' );
function cloudfw_cufon_defaults( $font ) {
	
	if ( !( current_theme_supports('cufon') && cloudfw_check_onoff('cufon', 'enable') ) ) {
		return;
	}
   
	if ( cloudfw_check_onoff('cufon', 'applytoNavigation' ) ) {
		$out[] = "Cufon.replace(\"nav ul > li > span > a\", {fontFamily : \"". _if( $fontTypeNavigation = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path(cloudfw_get_option( 'cufon', 'fontTypeNavigation' ) ) ), $fontTypeNavigation, $font ) ."\", hover: true});";     
	}

	if ( cloudfw_check_onoff('cufon', 'applytoHeadings' ) ) {
		$out[] = "Cufon.replace(\"h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .heading\", {fontFamily : \"". _if( $fontTypeHeadings = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path(cloudfw_get_option( 'cufon', 'fontTypeHeadings' ) ) ), $fontTypeHeadings, $font ) ."\", hover: true});";     
	}

	if ( cloudfw_check_onoff('cufon', 'applytoButtons' ) ) {
		$out[] = "Cufon.replace(\".btn\", {fontFamily : \"". _if( $fontTypeButtons = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path(cloudfw_get_option( 'cufon', 'fontTypeButtons' ) ) ), $fontTypeButtons, $font ) ."\", hover: true});";     
	}

	if ( cloudfw_check_onoff('cufon', 'applytoDropcaps' ) ) {
		$out[] = "Cufon.replace(\".dropcap\", {fontFamily : \"". _if( $fontTypeButtons = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path(cloudfw_get_option( 'cufon', 'fontTypeDropcaps' ) ) ), $fontTypeButtons, $font ) ."\", hover: false});";     
	}


	if( $out )
		$out = implode( "\n", $out );

	return $out;
}

/**
 *  Edit Global WP Query for Search Pages
 *
 *  @since 1.0
**/
//add_filter('pre_get_posts', 'cloudfw_filter_search');
function cloudfw_filter_search( $query ) {
	if($query->is_search)
		$query->set('post_type', array( 'post', 'page' ));
	return $query;
}

/**
 *  Exclude Selected Categories From Categories List
 *
 *  @since 1.0
**/
add_filter('pre_get_posts', 'cloudfw_exclude_blog_category');
function cloudfw_exclude_blog_category($query) {
	$page_for_posts = get_option("page_for_posts");
	
	if ( ! $page_for_posts )
		return $query;

	if ( isset($query ->queried_object_id) ):
		if ( $query ->queried_object_id == $page_for_posts ) {
			
			global $_opt;
			$exclude = isset($_opt[PFIX."_excluded_blog_categories"]) && $_opt[PFIX."_excluded_blog_categories"];
			
			$result = ''; 
			foreach ((array)$exclude as $ec) {
				$result .= ' -' . $ec;
			}
			$query->set('cat', $result);
		}
	endif;
	return $query;
}

/**
 *    CloudFw Body Classes
 *
 *    @since 1.0
 */
add_filter('body_class','cloudfw_body_classes');
function cloudfw_body_classes( $classes ) {
	$classes[] = 'run';

	if ( cloudfw_get_visual_option('layout') == 'boxed' ) {

		$classes[] = 'layout--boxed';

		$background_image = cloudfw_get_skin_value('boxed_layout', 'background-image');
		$background_pattern = cloudfw_get_skin_value('boxed_layout', 'pattern');

		if ( !empty($background_image) || !empty($background_pattern) )
			$classes[] = 'helper--no-filter';

	}

	return $classes;
}

/**
 *    CloudFw Custom Footer CSS
 *
 *    @since 1.0
 */
add_filter('wp_footer','cloudfw_custom_footer_css', 1000);
function cloudfw_custom_footer_css(){

	$custom_styles = cloudfw_vc_get( 'css' );
	if ( !empty($custom_styles) && is_array($custom_styles) ) {
		$css = implode("\r\n", $custom_styles);
		$load_css = true; 
		
		if ( $load_css ) {

			echo '
<script type="text/javascript">
// <![CDATA[
	var styleElement = document.createElement("style");
		styleElement.type = "text/css";

	var cloudfw_dynamic_css_code = '. json_encode( $css ) .';

	if (styleElement.styleSheet) {
		styleElement.styleSheet.cssText = cloudfw_dynamic_css_code;
	} else {
		styleElement.appendChild(document.createTextNode(cloudfw_dynamic_css_code));
	}

	document.getElementsByTagName("head")[0].appendChild(styleElement);

// ]]>
</script>
';
		}

	}

	cloudfw_vc_clear( 'css' );

}


/**
 *    CloudFw Custom Footer CSS
 *
 *    @since 1.0
 */
add_filter('wp_footer','cloudfw_footer_load_css_files', 1000);
function cloudfw_footer_load_css_files(){

	$css_files = cloudfw_vc_get( 'load_css' );
	if ( !empty($css_files) && is_array($css_files) ) {
			
		$out = "\r\n<script type=\"text/javascript\">\r\n// <![CDATA[\r\n";

		foreach ($css_files as $key => $fileurl) {
			$out .= "\tcloudfw_load_css_file( '{$key}', '{$fileurl}' );\r\n";
		}   

		$out .= "\r\n// ]]>\r\n</script>\r\n";

		echo $out;

	}

	cloudfw_vc_clear( 'load_css' );

}


/**
 *  CloudFw Device Viewport
 *
 *  @since 3.0
 */
function cloudfw_device_viewport( $echo = 1 ) {

	if ( cloudfw_is_responsive() ) {
		$out = '<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0">';
	} else {    
		$out = '<meta name="viewport" content="width=1200px">';
	}
	
	if( $echo )
		echo $out;
		
	return $out;
}

/**
 *  CloudFw Favicon
 *
 *  @since 1.0
 */
function cloudfw_favicon( $echo = 1 ) {
	$out = ''; 

	/** All devices */
	if ( $favicon = cloudfw_get_option('favicon', '16') )
		$out .= "<link rel=\"shortcut icon\" href=\"{$favicon}\" />" . PHP_EOL;

	/**  iPhone */
	if ( $favicon = cloudfw_get_option('favicon', '57') )
		$out .= "<link rel=\"apple-touch-icon\" href=\"{$favicon}\" />" . PHP_EOL;

	/**  iPhone Retina */
	if ( $favicon = cloudfw_get_option('favicon', '114') )
		$out .= "<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"{$favicon}\" />" . PHP_EOL;

	/**  iPad */
	if ( $favicon = cloudfw_get_option('favicon', '72') )
		$out .= "<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"{$favicon}\" />" . PHP_EOL;

	/**  iPad Retina */
	if ( $favicon = cloudfw_get_option('favicon', '144') )
		$out .= "<link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"{$favicon}\" />" . PHP_EOL;


	if( $echo )
		echo $out;
	
	return $out;
	
}

/**
 *  CloudFw Custom CSS Code
 *
 *  @since 1.0
 */
function cloudfw_custom_css_code( $echo = 1 ) {
	$css[] = cloudfw_get_option( 'custom_codes', 'css' );
	$css[] = cloudfw_get_option( 'webfonts', 'codes' );

	if ( !empty($css) ) {
		$css = implode("\n", $css);
		$out = "<style type= \"text/css\">{$css}</style>";
		
		if( $echo )
			echo $out;
		
		return $out;
	}
}

/**
 *  CloudFw Google Analytic Tracking Code Generator
 *
 *  @since 1.0
 */
function cloudfw_google_analytics_tracking($tracking_id){
	if (empty($tracking_id)) return false;
	echo '<script type="text/javascript">// <![CDATA[
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
		// ]]></script>
		<script type="text/javascript">// <![CDATA[
		try{
		var pageTracker = _gat._getTracker("'.$tracking_id.'");
		pageTracker._trackPageview();
		} catch(err) {} 
	// ]]>
	</script>';
};




/**
 *    CloudFw Cufon Init
 *
 *    @since 1.0
 */
if ( current_theme_supports('cufon') && cloudfw_check_onoff('cufon', 'enable') ) {
	add_filter('wp_footer','cloudfw_cufon_init', 100);
}


/**
 *  Remove WordPress Version Information From Header for Security
 *
 *  @since 1.0
 */
remove_action('wp_head', 'wp_generator');


/**
 *    Widget Tag Cloud Filter
 *
 *    @since 1.0
 */
add_filter('widget_tag_cloud_args', 'cloudfw_widget_tag_cloudfw_ordering_filter');
function cloudfw_widget_tag_cloudfw_ordering_filter($args) {
  $args['smallest'] = 7;
  $args['largest'] = 7;
  return $args;
}

/**
 *    Register JS Loading
 *
 *    @since 1.0
 */
add_action  ('wp_head', 'cloudfw_register_javascript_loading', 20);
function cloudfw_register_javascript_loading(){
?>

<script type="text/javascript">
    
    document.documentElement.className = document.documentElement.className.replace('no-js','js');
    document.documentElement.className = document.documentElement.className.replace('html-loaded','html-loading');

    (function(){
        "use strict";

        setTimeout(function(){
            document.documentElement.className = document.documentElement.className.replace('html-loading','html-loaded');
        }, 6000);

    })();
    
    jQuery(document).ready(function(){ 
        jQuery('html').removeClass('html-loading').addClass('html-loaded');
    });

</script>

<?php
}



/**
 *    Register Sticky Nav
 *
 *    @since 1.0
 */
if ( current_theme_supports('retina') ) {
	add_action  ('wp_head', 'cloudfw_register_cookie_retina', 11);
	function cloudfw_register_cookie_retina(){
	?>

<script type="text/javascript">
(function(){
	"use strict";

	if( document.cookie.indexOf('device_pixel_ratio') == -1
	    && 'devicePixelRatio' in window
	    && window.devicePixelRatio >= 1.5 ){

		var date = new Date();
		date.setTime( date.getTime() + 3600000 );

		document.cookie = 'device_pixel_ratio=' + window.devicePixelRatio + ';' +  ' expires=' + date.toUTCString() +'; path=/';
		
		//if cookies are not blocked, reload the page
		if(document.cookie.indexOf('device_pixel_ratio') != -1) {
		    window.location.reload();
		}
	}
})();
</script>
	<?php
	}
}

/**
 *    Register Sticky Nav
 *
 *    @since 1.0
 */
if ( cloudfw_check_onoff( 'header', 'sticky' ) ) {
	add_action  ('wp_head', 'cloudfw_register_sticky_nav', 20);
	function cloudfw_register_sticky_nav(){
		wp_enqueue_script ('theme-waypoints-sticky');

		$css = '';
		$css .= cloudfw_make_style( array( 
				".modern-browser #header-container.stuck #logo img",
			), array( 
				'height' 		=> cloudfw_get_option( 'logo-sticky', 'height', NULL, 0 ),
				'!margin-top' 	=> cloudfw_get_option( 'logo-sticky', 'margin-top' ),
				'!margin-bottom' => cloudfw_get_option( 'logo-sticky', 'margin-bottom' ),
			), FALSE, FALSE 
		);

		$css = "@media ( min-width: 979px ) { {$css} }";
		cloudfw_vc_set( 'css', 'sticky-logo', $css );
		unset( $css );
	}
}

/**
 *    Register Preloader
 *
 *    @since 1.0
 */
if ( cloudfw_check_onoff( 'global', 'preloader' ) && ! wp_is_mobile() ) {
	add_action  ('wp_head', 'cloudfw_register_preloader');
	function cloudfw_register_preloader(){
		wp_enqueue_script ('theme-queryloader2');
	}
}

/**
 *    Register Preloader
 *
 *    @since 1.0
 */
if ( cloudfw_check_onoff( 'global', 'smoothscroll' ) ) {
	add_action  ('wp_head', 'cloudfw_register_smoothscroll', 20);
	function cloudfw_register_smoothscroll(){
		global $is_IE;
		
		if (!$is_IE) {
			wp_enqueue_script ('theme-smoothscroll');
		}
	}
}

/**
 *  Adds comments and related post after the page contents.
 */
add_filter( 'the_content', 'cloudfw_add_contents_after_pages', 11 );
function cloudfw_add_contents_after_pages( $content ) {
	if ( is_singular('page') && is_main_query() && cloudfw_get_post_meta(get_the_ID(), 'comments_allow') == 'on' && ! post_password_required() ) {
		ob_start();
		comments_template( '', true );
		$content .= ob_get_contents();
		ob_end_clean();
	}

	return $content;

}