<?php
/**
 * Lost password form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post;

?>

<?php  wc_print_notices(); ?>


<form action="<?php echo esc_url( get_permalink($post->ID) ); ?>#lost_password" method="post" class="login lost_reset_password form-horizontal ui-row ui--box">
    <div class="form-header clearfix ui--gradient ui--gradient-grey">
        <h4 class="form-header-title"><strong><?php _e( 'Reset Password', 'woocommerce' ); ?></strong></h4>
    </div>

    <div class="form-elements">
   
        <?php   if( 'lost_password' == $args['form'] ) : ?>

            <div class="ui-row row">
                <p><?php echo apply_filters( 'woocommerce_lost_password_message', __( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p>
            </div>
            <div class="ui-row row">
                <div class="">
                    <div class="control-group">
                        <label class="control-label" for="user_login"><?php _e( 'Username or email', 'woocommerce' ); ?></label>
                        <div class="controls"><input type="text" class="input-text" name="user_login" id="user_login" /></div>
                    </div>
                </div>
            </div>

        <?php else : ?>

            <div class="ui-row row">
                <p><?php echo apply_filters( 'woocommerce_reset_password_message', __( 'Enter a new password below.', 'woocommerce') ); ?></p>
            </div>

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
            <input type="hidden" name="reset_key" value="<?php echo isset( $args['key'] ) ? $args['key'] : ''; ?>" />
            <input type="hidden" name="reset_login" value="<?php echo isset( $args['login'] ) ? $args['login'] : ''; ?>" />

        <?php endif; ?>

    </div>

    <div class="form-actions clearfix ui--gradient ui--gradient-grey">
        <?php wp_nonce_field( $args['form'] ); ?>
        <div class="pull-right"><button type="submit" class="btn btn-primary" name="wc_reset_password" value="<?php echo 'lost_password' == $args['form'] ? __( 'Reset Password', 'woocommerce' ) : __( 'Save', 'woocommerce' ); ?>" ><?php echo 'lost_password' == $args['form'] ? __( 'Reset Password', 'woocommerce' ) : __( 'Save', 'woocommerce' ); ?></button></div>
    </div>
</form>