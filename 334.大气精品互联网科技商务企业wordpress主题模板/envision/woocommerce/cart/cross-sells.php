<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $woocommerce, $product;

$columns = cloudfw_get_option( 'woocommerce', 'cross_sells_column' );
if ( empty($columns) )
	$columns = 3; 

$posts_per_page = cloudfw_get_option( 'woocommerce', 'cross_sells_limit' );
if ( empty($posts_per_page) )
	$posts_per_page = $columns;

$crosssells = $woocommerce->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = $woocommerce->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', $posts_per_page ),
	'no_found_rows'       => 1,
	'orderby'             => 'rand',
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= apply_filters( 'woocommerce_cross_sells_columns', $columns );

global $woocommerce_loop_layout;
	   $woocommerce_loop_layout = cloudfw_get_option('woocommerce', 'cross_sells_layout');

if ( $products->have_posts() ) : ?>

	<div class="cross-sells clearfix">

		<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h3' ), '<strong>'. __( 'You may be interested in&hellip;', 'woocommerce' ) .'</strong>' )); ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>
	<div class="clear"></div>

<?php endif;

wp_reset_query();