<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

?>

<div class="woocommerce-error ui--box cart-empty"><?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?></div>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>

<p class="return-to-shop"><a class="btn wc-backward btn-grey btn-block" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php _e( 'Return To Shop', 'woocommerce' ) ?></a></p>