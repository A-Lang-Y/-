<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $wp_query;

if ( 1 == $wp_query->found_posts || ! woocommerce_products_will_display() )
	return;
?>
<form class="woocommerce-ordering clearfix" method="get">

	<select name="show_products" class="show_products" style="max-width: 120px;">
		<?php
			$show_products = isset($_GET['show_products']) ? $_GET['show_products'] : '';
			$catalog_show_products = apply_filters( 'woocommerce_catalog_show_products', array(
				''   => !empty($show_products) ? '' : __( 'Display', 'woocommerce' ),
				'12' => 	'12' . ' ' . __('products','cloudfw'),
				'24' => 	'24' . ' ' . __('products','cloudfw'),
				'32' => 	'32' . ' ' . __('products','cloudfw'),
				'48' => '48' . ' ' . __('products','cloudfw'),
			) );


			foreach ( $catalog_show_products as $id => $name )
				echo '<option value="' . esc_attr( $id ) . '" ' . selected( $show_products, $id, false ) . '>' . esc_attr( $name ) . '</option>';
		?>
	</select>

	<select name="orderby" class="orderby">
		<?php
			$catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', array(
				'menu_order' => __( 'Default sorting', 'woocommerce' ),
				'popularity' => __( 'Sort by popularity', 'woocommerce' ),
				'rating'     => __( 'Sort by average rating', 'woocommerce' ),
				'date'       => __( 'Sort by newness', 'woocommerce' ),
				'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => __( 'Sort by price: high to low', 'woocommerce' )
			) );

			if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
				unset( $catalog_orderby['rating'] );

			foreach ( $catalog_orderby as $id => $name )
				echo '<option value="' . esc_attr( $id ) . '" ' . selected( $orderby, $id, false ) . '>' . esc_attr( $name ) . '</option>';
		?>
	</select>
	<?php
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'orderby' == $key || 'show_products' == $key )
				continue;
			
			if (is_array($val)) {
				foreach($val as $innerVal) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	?>
</form>
<div class="clear"></div>