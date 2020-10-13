<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce, $woocommerce_loop;


$columns = cloudfw_get_option( 'woocommerce', 'up_sells_column' );
if ( empty($columns) )
	$columns = 3; 

$posts_per_page = cloudfw_get_option( 'woocommerce', 'up_sells_limit' );
if ( empty($posts_per_page) )
	$posts_per_page = $columns;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = $woocommerce->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= $columns;
$woocommerce_loop['image_ratio'] = cloudfw_get_option( 'woocommerce', 'related_media_ratio' );
$woocommerce_loop['shadow'] = cloudfw_get_option( 'woocommerce', 'related_shadow' );
$woocommerce_loop['effect'] = cloudfw_get_option( 'woocommerce', 'related_effect' );
$woocommerce_loop['show_hover'] = cloudfw_check_onoff( 'woocommerce', 'related_hover' );
$woocommerce_loop['hover_effect'] = cloudfw_get_option( 'woocommerce', 'related_hover_effect' );


global $woocommerce_loop_layout;
	   $woocommerce_loop_layout = cloudfw_get_option('woocommerce', 'up_sells_layout');

if ( $products->have_posts() ) : ?>

	<div class="upsells products">

		<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h3' ), '<strong>'. __('You may also like&hellip;','woocommerce') .'</strong>' )); ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
