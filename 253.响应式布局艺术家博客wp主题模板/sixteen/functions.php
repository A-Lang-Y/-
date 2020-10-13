<?php
/**
 * Sixteen functions and definitions
 *
 * @package Sixteen
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'sixteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function sixteen_setup() {


	load_theme_textdomain( 'sixteen', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_image_size('homepage-thumb',240,145,true);
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'sixteen' ),
	) );

	add_theme_support( 'custom-background', apply_filters( 'sixteen_custom_background_args', array(
		'default-color' => 'E6E1C4',
		'default-image' => '',
	) ) );
	add_editor_style( 'editor-style.css' );
}
endif; // sixteen_setup
add_action( 'after_setup_theme', 'sixteen_setup' );

function sixteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'sixteen' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Left', 'sixteen' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Center', 'sixteen' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Right', 'sixteen' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
}
add_action( 'widgets_init', 'sixteen_widgets_init' );

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework.php';
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

function sixteen_scripts() {
	wp_enqueue_style( 'sixteen-fonts', '//fonts.googleapis.com/css?family=Roboto:400,300,700');
	wp_enqueue_style( 'sixteen-basic-style', get_stylesheet_uri() );
	if ( (function_exists( 'of_get_option' )) && (of_get_option('sidebar-layout', true) != 1) ) {
		if (of_get_option('sidebar-layout', true) ==  'right') {
			wp_enqueue_style( 'sixteen-layout', get_template_directory_uri()."/css/layouts/content-sidebar.css" );
		}
		else {
			wp_enqueue_style( 'sixteen-layout', get_template_directory_uri()."/css/layouts/sidebar-content.css" );
		}	
	}
	else {
		wp_enqueue_style( 'sixteen-layout', get_stylesheet_directory_uri()."/css/layouts/content-sidebar.css" );
	}	
	
	wp_enqueue_style( 'sixteen-main-style', get_template_directory_uri()."/css/main.css", array('sixteen-fonts','sixteen-layout') );
	
	wp_enqueue_script( 'sixteen-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'sixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	wp_enqueue_style( 'sixteen-nivo-slider-default-theme', get_template_directory_uri()."/css/nivo/themes/default/default.css" );
	
	wp_enqueue_style( 'sixteen-nivo-slider-style', get_template_directory_uri()."/css/nivo/nivo.css" );
	
	wp_enqueue_script('sixteen-timeago', get_template_directory_uri() . '/js/jquery.timeago.js', array('jquery') );
	
	wp_enqueue_script( 'sixteen-nivo-slider', get_template_directory_uri() . '/js/nivo.slider.js', array('jquery') );
	
	wp_enqueue_script( 'sixteen-superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery') );

	
	wp_enqueue_script( 'sixteen-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery','sixteen-nivo-slider','sixteen-timeago','sixteen-superfish') );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'sixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'sixteen_scripts' );

function sixteen_custom_head_codes() {
 if ( (function_exists( 'of_get_option' )) && (of_get_option('headcode1', true) != 1) ) {
	echo of_get_option('headcode1', true);
 }
 if ( (function_exists( 'of_get_option' )) && (of_get_option('style2', true) != 1) ) {
	echo "<style>".of_get_option('style2', true)."</style>";
 }
 //Modify CSS a little if Slider is disabled. 
if ( ( of_get_option('slider_enabled') == 0 ) || ( (is_home() == false) ) )  {
			echo "<style>.main-navigation {	margin-bottom: -5px;}</style>";
			}
			
 if ( ( of_get_option('slider_enabled') == 0 ) || ( (is_front_page() == true) ) )  {
			echo "<style>.main-navigation {	margin-bottom: 15px;}</style>";
			}	
}	
add_action('wp_head', 'sixteen_custom_head_codes');


function sixteen_pagination() {
	global $wp_query;
	$big = 12345678;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="pagination"><div><ul>';
	            echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
	            foreach ( $page_format as $page ) {
	                    echo "<li>$page</li>";
	            }
	           echo '</ul></div></div>';
	           }
}
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
