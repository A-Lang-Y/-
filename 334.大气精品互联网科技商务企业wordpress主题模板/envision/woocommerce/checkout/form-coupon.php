<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( ! $woocommerce->cart->coupons_enabled() )
	return;

$info_message = apply_filters('woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ));
?>

<p class="woocommerce-info ui--box"><?php echo $info_message; ?> <a href="#" class="showcoupon"><?php _e( 'Click here to enter your code', 'woocommerce' ); ?></a></p>

<form method="post" class="checkout_coupon form-horizontal ui-row ui--box" style="display:none; margin: -30px 0 30px;">

	<div class="form-elements">
		<div class="ui-row row">
			<div class="span12">
				<div class="control-group">
					<div class="controls">
						<input type="text" name="coupon_code" class="input-text" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-actions clearfix ui--gradient ui--gradient-grey">
		<?php wp_nonce_field( 'woocommerce-login' ); ?>
		<div class="pull-right"><button type="submit" class="btn btn-primary" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" ><?php _e( 'Apply Coupon', 'woocommerce' ); ?></button></div>
	</div>
</form>