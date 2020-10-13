<?php
/**
 * Change password form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php  wc_print_notices(); ?>

<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h3' ), 
		'<strong>'. __( 'Change Password', 'woocommerce' ) .'</strong>' )); 
?>

<form action="<?php echo esc_url( get_permalink(woocommerce_get_page_id('change_password')) ); ?>" method="post" class="login change_password form-horizontal ui-row ui--box">

    <div class="form-elements">

        <div class="ui-row row">
            <div class="span6">
                <div class="control-group">
                <label class="control-label" for="password_1"><?php _e( 'New password', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <div class="controls"><input type="password" class="input-text" name="password_1" id="password_1" /></div>
                </div>
            </div>

            <div class="span6">
                <div class="control-group">
                <label class="control-label" for="password_2"><?php _e( 'Re-enter new password', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <div class="controls"><input type="password" class="input-text" name="password_2" id="password_2" /></div>
                </div>
            </div>

        </div>

    </div>

    <div class="form-actions clearfix ui--gradient ui--gradient-grey">
        <?php wp_nonce_field( 'woocommerce-change_password' ); ?>
 		<input type="hidden" name="action" value="change_password" />
       <div class="pull-right"><button type="submit" class="btn btn-primary" name="change_password" value="<?php _e( 'Save', 'woocommerce' ); ?>" ><?php _e( 'Save', 'woocommerce' ); ?></button></div>
    </div>
</form>