<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce; ?>

<?php  wc_print_notices(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<?php $tabs = array(); ?>

	<?php $title = __('Login','woocommerce'); ?>
	<?php ob_start(); ?>
	<?php 

		$login_message = do_shortcode( cloudfw_translate('login_message', 'woocommerce') );
		if ( !empty( $login_message ) ) {
			$login_classes = array( 'span6', 'span6' );
		} else {
			$login_classes = array( 'span12', '' );
		}

	?>
	<?php //echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h3' ), '<strong>'. $title .'</strong>' )); ?>

	<div class="ui-row <?php echo cloudfw('row_class'); ?>">

		<div class="<?php echo $login_classes[0]; ?>">
		
			<form method="post" class="login form-horizontal ui-row ui--box">

				<div class="form-header clearfix ui--gradient ui--gradient-grey">
					<h4 class="form-header-title"><strong><?php _e( 'Login', 'woocommerce' ); ?></strong></h4>
				</div>

				<div class="form-elements">
					<div class="ui-row row">
						<div class="">
							<div class="control-group">
								<label class="control-label" for="username"><?php _e( 'Username or email', 'woocommerce' ); ?></label>
								<div class="controls"><input type="text" class="input-text" name="username" id="username" /></div>
							</div>
						</div>
						<div class="">
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

						/*$lost_password_page_id = woocommerce_get_page_id( 'lost_password' );

						if ( $lost_password_page_id )
							echo esc_url( get_permalink( $lost_password_page_id ) );
						else
							echo esc_url( wp_lostpassword_url( home_url() ) );*/

						?>#lost_password"><?php _e( 'Lost Password?', 'woocommerce' ); ?></a>
					</div>
				</div>
			</form>
		
		</div>

		<?php if ( !empty( $login_message ) ): ?>
		<div class="<?php echo $login_classes[1]; ?>">
			<?php echo $login_message; ?>
		</div>
		<?php endif; ?>
	
	</div>

	<?php
		$content = ob_get_contents();
		ob_end_clean();

		$tabs['login'] = array(
			'title'		=>	$title,
			'content'	=>	$content,
		);
	?>


<?php if ( get_option('woocommerce_enable_myaccount_registration') == 'yes' ) : ?>

	<?php $title = __('Register','woocommerce'); ?>
	<?php ob_start(); ?>
	<?php 

		$register_message = do_shortcode( cloudfw_translate('register_message', 'woocommerce') );
		if ( !empty( $register_message ) ) {
			$register_classes = array( 'span6', 'span6' );
		} else {
			$register_classes = array( 'span12', '' );
		}

	?>

	<div class="ui-row <?php echo cloudfw('row_class'); ?>">

		<div class="<?php echo $register_classes[0]; ?>">

			<form method="post" class="register ui-row form-horizontal ui--box">
				
				<div class="form-header clearfix ui--gradient ui--gradient-grey">
					<h4 class="form-header-title"><strong><?php _e( 'Register', 'woocommerce' ); ?></strong></h4>
				</div>

				<div class="form-elements">
					<div class="ui-row row">

					<?php if ( get_option( 'woocommerce_registration_generate_username' ) === 'no' ) : ?>

						<div class="form-item">
							<div class="control-group">
								<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
								<div class="controls"><input type="text" class="input-text" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" /></div>
							</div>
						</div>

						<div class="form-item">

					<?php else : ?>

					</div>
					<div class="ui-row row">
						<div class="span12">

					<?php endif; ?>
							<div class="control-group">
								<label for="reg_email"><?php _e( 'Email', 'woocommerce' ); ?> <span class="required">*</span></label>
								<div class="controls"><input type="email" class="input-text" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" /></div>
							</div>
						</div>
					</div>

					<div class="ui-row row">

						<div class="form-item">
							<div class="control-group">
								<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
								<div class="controls"><input type="password" class="input-text" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" /></div>
							</div>
						</div>
						<div class="form-item">
							<div class="control-group">
								<label for="reg_password2"><?php _e( 'Re-enter password', 'woocommerce' ); ?> <span class="required">*</span></label>
								<div class="controls"><input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" /></div>
							</div>
						</div>

					</div>

					<!-- Spam Trap -->
					<div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

					<?php do_action( 'register_form' ); ?>


				</div>

				<div class="form-actions clearfix ui--gradient ui--gradient-grey">
					<?php wp_nonce_field( 'woocommerce-register' ); ?>
					<div class="pull-right">
						<button type="submit" class="btn btn-primary" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" ><?php _e( 'Register', 'woocommerce' ); ?></button>
					</div>
				</div>

			</form>

		</div>

		<?php if ( !empty( $register_message ) ): ?>
		<div class="<?php echo $register_classes[1]; ?>">
			<?php echo $register_message; ?>
		</div>
		<?php endif; ?>
	
	</div>

	<?php
		$register_form = ob_get_contents();
		ob_end_clean();

		$tabs['register'] = array(
			'title'		=>	$title,
			'content'	=>	$register_form,
		);
	?>
	
	<?php 

		ob_start();
			WC_Shortcode_My_Account::lost_password();
			$lost_password_form = ob_get_contents();
		ob_end_clean();

		$tabs['lost_password'] = array(
			'title'		=>	__( 'Lost Password?', 'woocommerce' ),
			'content'	=>	$lost_password_form,
		);
	?>

<?php endif; ?>

<?php if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs">
		<?php 

			$tab_contents = ''; 
			foreach ( $tabs as $key => $tab ) {
				$tab_contents .= cloudfw_transfer_shortcode_attributes( 'tab', array( 'title' => $tab['title'], 'hash' => $key ), $tab['content'] );
			}

			echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'tabs', array( 'align' => 'right', 'margin_top' => 12, ), $tab_contents ));

		 ?>

	</div>

<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>