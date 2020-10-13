<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( cloudfw_check_onoff( 'woocommerce', 'catalog_mode' ) )
	return;
	
?>
<?php do_action('woocommerce_before_add_to_cart_button'); ?>

<p class="cart"><a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button btn btn-small btn-grey"><?php echo apply_filters('single_add_to_cart_text', $button_text, 'external'); ?></a></p>

<?php do_action('woocommerce_after_add_to_cart_button'); ?>