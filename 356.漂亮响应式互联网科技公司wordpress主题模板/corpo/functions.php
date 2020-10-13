<?php
/*-----------------------------------------------------------------------------------*/
/*	Theme Setup
/*-----------------------------------------------------------------------------------*/ 

if (!isset($content_width))
{
    $content_width = 680;
}

if ( ! function_exists( 'corpo_setup' ) ) :

function corpo_setup() {
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size( 'medium', 320, '', true); // Medium Thumbnail
    add_image_size( 'small', 50, 50 , true); // Small Thumbnail
    add_image_size( 'portfolio-one-third', 288, 170, true );
    add_image_size( 'portfolio-one-fourth', 216, 128, true );
    add_image_size( 'fullwidth', 540, null, true );
    add_image_size( 'slider', 980, 380, true );

    // Add Support for Custom Backgrounds
    add_theme_support('custom-background', array(
        'default-color' => '',
        'default-image' => get_template_directory_uri() . '/images/body-bg.jpg'
    ));

    // Register Menus
    register_nav_menus( array( 
        'main-menu' => __('Main Menu', 'corpo'), // Main Navigation
        'footer-menu' => __('Footer Menu', 'corpo') // Footer Navigation
    ));
    
    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('corpo', get_template_directory() . '/languages');
    
    $locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
        
}
endif; // corpo_setup
add_action( 'after_setup_theme', 'corpo_setup' );

/*-----------------------------------------------------------------------------------*/
/*	Functions
/*-----------------------------------------------------------------------------------*/ 

// Load scripts
function corpo_enqueue_scripts()
{
    if (!is_admin()) {
    
        wp_enqueue_script('jquery');
    	
		wp_register_script('jquery_tools', get_template_directory_uri() . '/js/jquery.tools.min.js');
		wp_enqueue_script('jquery_tools');
        
        wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr.min.js', array(), '2.6.2'); 
        wp_enqueue_script('modernizr');

        wp_register_script('tinynav', get_template_directory_uri() . '/js/tinynav.min.js'); 
        wp_enqueue_script('tinynav');
        
        wp_register_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '1.0.0'); 
        wp_enqueue_script('custom-scripts');
    }
}
add_action('wp_enqueue_scripts', 'corpo_enqueue_scripts'); // Add Custom Scripts to wp_head


// Load CSS styles
function corpo_enqueue_css()
{
    
    $subsets = 'latin,latin-ext';
    $protocol = is_ssl() ? 'https' : 'http';
    $query_args = array(
        'family' => 'Open+Sans:400italic,400,600,700',
        'subset' => $subsets,
    );
    $color_scheme = of_get_option('corpo_color_scheme','red');
    
    wp_enqueue_style( 'corpo-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );

    wp_register_style('font_awsome-css', get_template_directory_uri() . '/css/font-awesome.min.css', array(),  null);
    wp_enqueue_style('font_awsome-css'); 
    
    wp_register_style('corpo-css', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('corpo-css'); 
    
    wp_register_style('color_scheme', get_template_directory_uri() . '/css/color_scheme/'.$color_scheme.'.css');
    wp_enqueue_style('color_scheme');    

}
add_action('wp_enqueue_scripts', 'corpo_enqueue_css'); // Add Theme Stylesheet


// Remove invalid rel attribute values in the categorylist
function corpo_remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}
add_filter('the_category', 'corpo_remove_category_rel_from_category_list');

// Add page slug to body class, Credit: Starkers Wordpress Theme
function corpo_add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}
add_filter('body_class', 'corpo_add_slug_to_body_class'); // Add slug to body class (Starkers build)

// Remove wp_head() injected Recent Comment styles
function corpo_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}
add_action('widgets_init', 'corpo_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()

// Add hooks for use in Corpo Toolkit Plugin
function corpo_home_slider() {
    do_action('corpo_home_slider');
}

function corpo_home_projects() {
    do_action('corpo_home_projects');
}

/*-----------------------------------------------------------------------------------*/
/* Display <title> tag
/*-----------------------------------------------------------------------------------*/

// Filter function for wp_title
function corpo_filter_wp_title( $old_title, $sep, $sep_location ){
 
    // add padding to the sep
    $ssep = ' ' . $sep . ' ';
     
    // find the type of index page this is
    if( is_category() ) $insert = $ssep . __('Category','corpo');
    elseif( is_tag() ) $insert = $ssep . __('Tag','corpo');
    elseif( is_author() ) $insert = $ssep . __('Author','corpo');
    elseif( is_year() || is_month() || is_day() ) $insert = $ssep . __('Archives','corpo');
    elseif( is_home() ) $insert = $ssep . get_bloginfo('description');
    else $insert = NULL;
     
    // get the page number we're on (index)
    if( get_query_var( 'paged' ) )
    $num = $ssep . __('Page ','corpo') . get_query_var( 'paged' );
     
    // get the page number we're on (multipage post)
    elseif( get_query_var( 'page' ) )
    $num = $ssep . __('Page ','corpo') . get_query_var( 'page' );
     
    // else
    else $num = NULL;

     
    // concoct and return new title
    return get_bloginfo( 'name' ) . $insert . $old_title . $num;
}

add_filter( 'wp_title', 'corpo_filter_wp_title', 10, 3 );

function corpo_rss_title($title) {
    /* need to fix our add a | blog name to wp_title */
    $ft = str_replace(' | ','',$title);
    return str_replace(get_bloginfo('name'),'',$ft);
}
add_filter('get_wp_title_rss', 'corpo_rss_title',10,1);

/*-----------------------------------------------------------------------------------*/
/*	Sidebar & Widgets
/*-----------------------------------------------------------------------------------*/ 
function corpo_widgets_init() {

    // Define Sidebar Widget Area
    register_sidebar(array(
        'name' => __('Main Sidebar', 'corpo'),
        'description' => __('Main widget area displayed on blog posts & archives', 'corpo'),
        'id' => 'main-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
    // Define Home Page Widget Area
    register_sidebar(array(
        'name' => __('Home Page Services', 'corpo'),
        'description' => __('This widget area is designed to display up to 4 services widgets.', 'corpo'),
        'id' => 'homepage-sidebar',
        'before_widget' => '<div id="%1$s" class=" widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    // Define Prefooter Widget Area
    register_sidebar(array(
        'name' => __('Prefooter', 'corpo'),
        'description' => __('Prefooter widget area displayed above the footer (max 4 widgets)', 'corpo'),
        'id' => 'prefooter-sidebar',
        'before_widget' => '<div id="%1$s" class=" widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
    ));
    
    //Register widgets
    register_widget( 'corpo_contact_widget' );
    register_widget( 'corpo_popular_posts_widget' );
    register_widget( 'corpo_recent_widget' );
    register_widget( 'corpo_services_widget' );

}
add_action( 'widgets_init', 'corpo_widgets_init' );

include(get_template_directory() . "/functions/widgets/recent-posts-widget.php");
include(get_template_directory() . "/functions/widgets/popular-posts-widget.php");
include(get_template_directory() . "/functions/widgets/contact-widget.php");
include(get_template_directory() . "/functions/widgets/services-widget.php");


// Get Post Views - for Popular Posts widget
function corpo_getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function corpo_setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/*-----------------------------------------------------------------------------------*/
/* Excerpt config
/*-----------------------------------------------------------------------------------*/
function corpo_excerptlength_teaser($length) {
    return 20;
}

// Custom 'Read more' link to Post
function corpo_excerpt_more($more)
{
    global $post;
    return '... <a class="more" href="' . get_permalink($post->ID) . '">' . __('Continue reading &rarr;', 'corpo') . '</a>';
}
add_filter('excerpt_more', 'corpo_excerpt_more');

// Create the Custom Excerpts callback
function corpo_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}

/*-----------------------------------------------------------------------------------*/
/* Append post meta & pagination after post content
/*-----------------------------------------------------------------------------------*/
function corpo_post_meta($content) {
    
    if ( is_single() ) {
        $categories = get_the_category_list(__( ', ', 'corpo' ));
        $tags = get_the_tag_list('', __( ', ', 'corpo' ));

        $content .= corpo_custom_wp_link_pages(); //Pagination  

        $content .= '<div class="alignright">'. get_previous_posts_link( ) .'</div>';
        $content .= '<div class="alignleft">'. get_next_posts_link( ) .'</div> ';

        $content .= '<div class="post-meta">';
        if( !empty( $categories ) ) :
            $content .= '<i>'. __( 'Posted in ', 'corpo' ) . $categories .'</i>';
        endif;
        if( !empty( $tags ) ) :
            $content .= '<i> | '. __( 'Tagged: ', 'corpo' ) . $tags .'</i>';
        endif;        
        $content .= '</div>';
    }
	return $content;
}
add_filter('the_content','corpo_post_meta', 10);

/*-----------------------------------------------------------------------------------*/
/* Comments
/*-----------------------------------------------------------------------------------*/
function corpo_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}
add_action('get_header', 'corpo_threaded_comments');

// Custom Comments Callback
function corpo_comments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
            ?>
            <li <?php comment_class(); ?>>   
                <article id="comment-<?php comment_ID(); ?>" class="the-comment">            
                <p><?php _e( 'Pingback:', 'corpo' ); ?> <?php comment_author_link(); ?></p>
                </article>
            <?php
        break;
        default :
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="the-comment">

                        <?php echo get_avatar( $comment, 60 ); ?>

                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <em><?php _e( 'Your comment is awaiting moderation.', 'corpo' ); ?></em>
                            <br />
                        <?php endif; ?>
                        <div class="comment-box">
                            <?php echo get_comment_author_link() ?>
                            <span class="comment-meta">
                                <small>
                                    <?php comment_time( 'F j, Y g:i a' ); ?></small>&nbsp;<small>
                                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                                </small>
                            </span>
                            <div class="comment-text"><p><?php comment_text(); ?></p></div>
                        </div>				

                </article>
        <?php
        break;
    endswitch;
}

/*-----------------------------------------------------------------------------------*/
/*	Actions & Filters
/*-----------------------------------------------------------------------------------*/ 

// Add Filters

add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('use_default_gallery_style', '__return_false' ); // Remove inline style of WordPress Gallery Shortcode

/*-----------------------------------------------------------------------------------*/
/*	Custom Functions
/*-----------------------------------------------------------------------------------*/ 

include get_template_directory() . '/functions/custom_functions.php';

/*-----------------------------------------------------------------------------------*/
/*	Meta-boxes setup
/*-----------------------------------------------------------------------------------*/
// Re-define meta box path and URL
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/functions/meta-box' ) );
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/functions/meta-box' ) );

// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';

// Include the meta box definition (the file where you define meta boxes, see `demo/demo.php`)
include 'functions/meta-box/metabox-def.php';

/*-----------------------------------------------------------------------------------*/
/*	Theme Plugin
/*-----------------------------------------------------------------------------------*/
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/functions/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'corpo_register_required_plugins' );

function corpo_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'Corpo Toolkit', // The plugin name
			'slug'     				=> 'corpo_toolkit', // The plugin slug (typically the folder name)
			'source'   				=> get_stylesheet_directory() . '/functions/plugins/corpo_toolkit.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)

	);


	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'corpo',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'corpo' ),
			'menu_title'                       			=> __( 'Install Plugins', 'corpo' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'corpo' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'corpo' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'corpo' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'corpo' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'corpo' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}


/*-----------------------------------------------------------------------------------*/
/*	Options framework
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/functions/admin/options-framework/' );
	require_once get_template_directory() . '/functions/admin/options-framework/options-framework.php';
}

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});

	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}

});
</script>

<?php
}

// Theme Options sidebar
add_action( 'optionsframework_after','corpo_options_display_sidebar' );

function corpo_options_display_sidebar() { ?>
	<div id="optionsframework-sidebar">
		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e('Support','corpo') ?></h3>
					<div class="inside">
                        <p><b><a href="http://webtuts.pl/documentation/corpo"><?php _e('Corpo Documentation','corpo'); ?></a></b></p>
                        <p><?php _e('The best way to contact me with <b>support questions</b> and <b>bug reports</b> is via the','corpo') ?> <a href="http://wordpress.org/support/"><?php _e('WordPress support forums','corpo') ?></a>.</p>
                        <p><?php _e('If you like this theme, I\'d appreciate any of the following:','corpo') ?></p>
                        <ul>
                            <li><a href="http://wordpress.org/extend/themes/corpo"><?php _e('Rate Corpo at WordPress.org','corpo') ?></a></li>
                            <li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8LRJAUNAPKJ9S"><?php _e('Donate a token of your appreciation','corpo') ?></a></li>
                        </ul>
					</div>
			</div>
		</div>
	</div>
<?php }