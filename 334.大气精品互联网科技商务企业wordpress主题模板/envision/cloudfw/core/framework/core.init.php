<?php

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die(__("Sorry, but you can't access this page directly.", "cloudfw"));
} 

global $pagenow;

/**
 *	CloudFw check whether the upload directories is writable or not
 *
 *	@since 1.0
**/

if (is_admin()) {
    cloudfw_check_upload_folders();
}
	
/**
 *	The Trigger of Save Settings
 *
 *	@since 1.0
**/
if (isset($_POST[PFIX . '_update'])) {
    $form_selector = $_POST['form_selector'];
    
    if (!empty($form_selector)) {
        $_opt = cloudfw_get_all_options();
        cloudfw_form_register( $form_selector );
    } 

    global $jump_tab, $cloudfw_editing_skin_id;
    $comeback = isset($_POST['comeback']) ? $_POST['comeback'] : NULL;
    
    if (empty($comeback)) {
		
        $ref = $_SERVER['HTTP_REFERER'];
		if ($ref) {
            $ref_result = cloudfw_parse_querystring( $ref );
            $msg_ = isset( $ref_result['m'] ) ? $ref_result['m'] : FALSE;
        	$comeback = str_replace("&m={$msg_}", '', $ref);
		}
		
		if (isset($jump_tab)):
            $comeback_result = cloudfw_parse_querystring( $comeback );
            $d = isset( $comeback_result['jump'] ) ? $comeback_result['jump'] : FALSE;

            if ( $d )
               $comeback = str_replace("&jump={$d}", '', $comeback);
            $comeback .= '&jump='. $jump_tab; 
		endif;
		
		if (isset($cloudfw_editing_skin_id)):
            $comeback_result = cloudfw_parse_querystring( $comeback );
            $d = isset( $comeback_result['id'] ) ? $comeback_result['id'] : FALSE;

            if ( $d )
               $comeback = str_replace("&id={$d}", '', $comeback);
            $comeback .= '&id='. $cloudfw_editing_skin_id; 
		endif;
		
    } 
    else
        $comeback = admin_url($comeback);
    

    wp_redirect($comeback . '&m=' . cloudfw_get_message());
    
    
    exit;
    
}

/**
 *	CloudFw Register Quick Actions
 *
 *	@since 1.0
**/
if (isset( $_GET['q'] )) {

$_opt = cloudfw_get_all_options();

    if ( (defined('MULTISITE')) && (MULTISITE == true) ) {
        global $blog_id, $current_site;
        $site_url = get_blogaddress_by_id(1);
        $site_url = str_replace( home_url().'/', $site_url, TMP_URL).'/';
    } else
        $site_url = TMP_URL.'/';
    
    require_once( TMP_LOADERS.'/theme.quickactions.php' );
    require_once( CLOUDFW_PATH.'/core/others/source.quickactions.php' );
}

/**
 *  The Theme Upgraded
 *
 *  @since 3.0
**/
if ( ( $checked_version = get_option( PFIX . '_version' ) ) !== CLOUDFW_THEMEVERSION ) {
    add_action( 'cloudfw_upgrading', '__cloudfw_upgrading' );
    do_action( 'cloudfw_upgrading', CLOUDFW_THEMEVERSION, $checked_version );
}

function __cloudfw_upgrading(){
    update_option( PFIX . '_version', CLOUDFW_THEMEVERSION );

    /** Clear skin caches */
    cloudfw_delete_skin_caches();
}


/**
 *    Add filter to add composer data to the content
 *
 *    @since 3.0
 */
add_filter('the_content', 'cloudfw_composer_the_content', 10);
function cloudfw_composer_the_content( $content, $id = NULL, $key = '' ){
    if( ! $id ) {
        global $post;
        $id = isset($post->ID) ? $post->ID : '';
    }

    if ( ! post_password_required() ) {
        $composer_activate = cloudfw_composer_is_activated( $id );
        if ( _check_onoff( $composer_activate ) ) {
            $composer_data = cloudfw_composer_get_data( $id );
        }

        if ( ! empty( $composer_data ) ) {
            $content .= cloudfw_composer_make_content( $composer_data, NULL, $key );
        }
    }

    if ( is_feed() ) {
       $content = wp_kses( $content,
            array(
                'p'      => array(),
                'a'      => array( 'href' => array() ),
                'strong' => array(),
                'em'     => array(),
                'img'    => array( 'src' => array(), 'width' => array(), 'height' => array() ),
            )
        );
    }

    return $content;
}

/**
 *    Add filter to mime types
 *
 *    @since 3.0
 */
//add_filter('upload_mimes', 'cloudfw_upload_mimes', 10);
function cloudfw_upload_mimes( $mimes ){
    if ( empty($mimes['css']) ) {
        $mimes['css'] = 'text/css';
    }
    return $mimes;
}

/**
 * Customizes the video oembed codes.
 *
 * @param  string   $embed
 * @param  string   $pattern
 * @param  array    $args
 *
 * @return string   returns customized embed codes. 
 */
function cloudfw_video_embed_codes( $embed, $pattern, $args = array() ) {

    if ( empty($pattern) )
        return $embed;

    $query = '';
    if ( !empty($args) && is_array($args) ) {
        $query = http_build_query( $args );
        $query = str_replace('&amp;', '&', $query);     
        $query = str_replace('&', '&amp;', $query);     
    }

    $embed = preg_replace($pattern, "$1$2?{$query}&", $embed);

    return $embed;
}

/**
 *    Render CloudFw Javascript Options
 *
 *    @since 1.0
 */
if( !is_admin() ) {
    add_action  ('cloudfw_head', 'cloudfw_set_js_options', 5);
    add_action  ('cloudfw_head', 'cloudfw_set_js_options_hook', 6);
    //add_action  ('cloudfw_head', 'cloudfw_render_js_options', 8);
    add_action  ('cloudfw_head', 'cloudfw_ua_compatible', 1);
}

/**
 *    Wp Header::Core 
 *
 *    @since 1.0
 */
add_action  ('wp_head', 'cloudfw_admin_head_init', 11);
function cloudfw_admin_head_init(){
    cloudfw_favicon();
    cloudfw_skin_render();
    cloudfw_custom_css_code();
    cloudfw_font_engine();
    cloudfw_option('custom_codes', 'header');
}

/**
 *    Hook for javascript options.
 *
 *    @since 1.0
 */
function cloudfw_set_js_options_hook(){
    do_action('cloudfw_javascript_options');
}

/**
 *    Hook for javascript options.
 *
 *    @since 1.0
 */
function cloudfw_ua_compatible(){
?>
<!--[if IE 8]> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<?php
}