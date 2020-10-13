<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !function_exists('cloudfw_woocommerce_product_tabs') ) {
	add_filter( 'woocommerce_product_tabs', 'cloudfw_woocommerce_product_tabs' );
	function cloudfw_woocommerce_product_tabs( $tabs = array() ) {

		if ( !isset($tabs['description']) ) {
			ob_start();
			the_content();
			$content = ob_get_contents();
			ob_end_clean();

			if ( !empty( $content ) ) {
				$tabs['description'] = array(
					'title'    => __( 'Description', 'woocommerce' ),
					'priority' => 10,
					'callback' => 'woocommerce_product_description_tab'
				);
			}

		}

		return $tabs;
	}
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( isset($tabs['reviews']) ) {

	if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {
		$tabs['reviews']['title'] .= cloudfw_wc_rating_icons( '<div class="ui--star-rating-wrap">', '</div>' );
	} 

}

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs">
		<?php 

			$tab_contents = ''; 
			foreach ( $tabs as $key => $tab ) {
				$title = apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key );

				ob_start();
				call_user_func( $tab['callback'], $key, $tab );
				$content = ob_get_contents();
				ob_end_clean();

				$tab_contents .= cloudfw_transfer_shortcode_attributes( 'tab', array( 'title' => $title, 'hash' => $key ), $content );
			}

			echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'tabs', array( 'align' => 'left' ), $tab_contents ));

		 ?>

	</div>

<?php endif; ?>