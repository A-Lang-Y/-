<?php
/**
 * @package Sixteen
 * Setup the WordPress core custom header feature.
 *
 * @uses sixteen_header_style()
 * @uses sixteen_admin_header_style()
 * @uses sixteen_admin_header_image()

 */
function sixteen_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'sixteen_custom_header_args', array(
		'default-image'          => get_template_directory_uri().'/images/tigerturtle.jpg',
		'default-text-color'     => 'fff',
		'width'                  => 1600,
		'height'                 => 400,
		'wp-head-callback'       => 'sixteen_header_style',
		'admin-head-callback'    => 'sixteen_admin_header_style',
		'admin-preview-callback' => 'sixteen_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'sixteen_custom_header_setup' );

if ( ! function_exists( 'sixteen_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see sixteen_custom_header_setup().
 */
function sixteen_header_style() {
	$header_text_color = get_header_textcolor();
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo $header_text_color; ?>;
		}
	<?php endif; 
		//Check if user has defined any header image.
		if ( get_header_image() ) :
	?>
		#header-image {
			background: url(<?php echo get_header_image(); ?>) no-repeat #111;
			background-position: center top;
		}
	<?php endif; ?>	
	</style>
	<?php
}
endif; // sixteen_header_style

if ( ! function_exists( 'sixteen_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see sixteen_custom_header_setup().
 */
function sixteen_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
			</style>
<?php
}
endif; // sixteen_admin_header_style

if ( ! function_exists( 'sixteen_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see sixteen_custom_header_setup().
 */
function sixteen_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
?>
	<div id="headimg">
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // sixteen_admin_header_image
