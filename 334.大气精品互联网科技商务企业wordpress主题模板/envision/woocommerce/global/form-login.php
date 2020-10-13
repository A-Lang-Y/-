<?php
/**
 * Login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if (is_user_logged_in()) return;
?>

<form method="post" class="login form-horizontal ui-row ui--box" style=" <?php if ( $hidden ) echo 'display:none;'; ?>margin: -30px 0 30px;">

	<div class="form-elements">
	
		<?php if ( $message ) echo wpautop( wptexturize( $message ) ); ?>

		<div class="ui-row row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="username"><?php _e( 'Username or email', 'woocommerce' ); ?></label>
					<div class="controls"><input type="text" class="input-text" name="username" id="username" /></div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="password"><?php _e( 'Password', 'woocommerce' ); ?></label>
					<div class="controls"><input class="input-text" type="password" name="password" id="password" /></div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-actions clearfix ui--gradient ui--gradient-grey">
		<?php wp_nonce_field( 'woocommerce-login' ); ?>
		<div class="pull-right"><button type="submit" class="btn btn-primary" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" ><?php _e( 'Login', 'woocommerce' ); ?></button></div>
		<div class="pull-left">
			<a class="lost_password btn btn-grey" href="<?php

			$lost_password_page_id = woocommerce_get_page_id( 'lost_password' );

			if ( $lost_password_page_id )
				echo esc_url( get_permalink( $lost_password_page_id ) );
			else
				echo esc_url( wp_lostpassword_url( home_url() ) );

			?>"><?php _e( 'Lost Password?', 'woocommerce' ); ?></a>
		</div>
	</div>
</form>