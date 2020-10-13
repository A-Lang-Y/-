<?php

if ( ! cloudfw_woocommerce() ) {
	return;
}

if ( ! $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' ) ) {
	return;
}

add_action('cloudfw_side_panel', 'cloudfw_side_widget_login');
if ( ! function_exists('cloudfw_side_widget_login') ) {
function cloudfw_side_widget_login(){
?>
	<div id="ui--side-login-widget">
		<h3><strong><?php _e('Login','woocommerce'); ?></strong></h3>

		<?php if( cloudfw_woocommerce() ) {
			global $woocommerce;

			$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
			$myaccount_page_url = get_permalink( $myaccount_page_id );
		?>

			<form action="<?php echo $myaccount_page_url; ?>" method="post" class="ui-row">

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

				<div class="clearfix">
					<?php $woocommerce->nonce_field('login', 'login') ?>
					<div class="pull-left">
						<button type="submit" class="btn btn-primary" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" ><?php _e( 'Login', 'woocommerce' ); ?></button>
					</div>

					<?php if ( get_option('woocommerce_enable_myaccount_registration') == 'yes' ) :


					?>
						<div class="pull-right">
							<a href="<?php echo $myaccount_page_url; ?>#register" class="" style="line-height: 30px;"><?php _e( 'Register', 'woocommerce' ); ?></a>
						</div>
					<?php endif; ?>

				</div>
			</form>

		<?php } ?>

	</div>
<?php
}

?>
<ul id="widget--login-woocommerce" class="ui--widget ui--custom-menu opt--on-hover unstyled-all <?php echo cloudfw_visible( $device ); ?>">
		<?php if ( ! is_user_logged_in() ) { ?>
			<li>
				<a href="javascript:;" class="ui--side-panel ui--gradient ui--gradient-grey on--hover hover" data-target="ui--side-login-widget"><?php _e('Login','woocommerce'); ?></a>
			</li>
		<?php } else {

			if ( $myaccount_page_id ) {

				$myaccount_page_url = get_permalink( $myaccount_page_id );
				$logout_url = wp_logout_url( $myaccount_page_url );

				if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ) {
					$logout_url = str_replace( 'http:', 'https:', $logout_url );
				}

			} else {
				$logout_url = wp_logout_url();
			}


			global $current_user;
			get_currentuserinfo();


			$custom_menu_id = cloudfw_get_option('login_widget_custom_menu', 'menu_id');
			$show_sub_level = cloudfw_check_onoff('login_widget_custom_menu', 'show_sub_level');
			$show_avatar = cloudfw_check_onoff('login_widget_custom_menu', 'show_avatar');

		?>
			<li>
				<a href="<?php echo $myaccount_page_url; ?>" class="ui--gradient ui--gradient-grey on--hover hover" data-target="ui--side-login-widget">
					<?php
						if( $show_avatar ) {
							echo get_avatar( $current_user->ID, 20 );
						}
					?>
					<?php echo sprintf( cloudfw_translate( 'wc.widget.login.text' ) , $current_user->display_name); ?>
					<?php if ( $show_sub_level ): ?>
						<i class="fontawesome-angle-down px14"></i>
					<?php endif; ?>
				</a>

				<?php if ( $show_sub_level ): ?>
					<?php if ( ! $custom_menu_id ): ?>

					<ul class="sub-menu">
						<?php if ( ( $page_id = get_option( 'woocommerce_myaccount_page_id' ) ) && ( $title = get_the_title( $page_id ) ) ) { ?>
							<li><a href="<?php echo get_permalink( $page_id ); ?>"><?php echo $title; ?></a></li>
						<?php } ?>

						<?php if ( ( $page_id = get_option( 'woocommerce_view_order_page_id' ) ) && ( $title = get_the_title( $page_id ) ) ) { ?>
							<li><a href="<?php echo get_permalink( $page_id ); ?>"><?php echo $title; ?></a></li>
						<?php } ?>

						<?php if ( ( $page_id = get_option( 'woocommerce_edit_address_page_id' ) ) && ( $title = get_the_title( $page_id ) ) ) { ?>
							<li><a href="<?php echo get_permalink( $page_id ); ?>"><?php echo $title; ?></a></li>
						<?php } ?>

						<?php if ( ( $page_id = get_option( 'woocommerce_change_password_page_id' ) ) && ( $title = get_the_title( $page_id ) ) ) { ?>
							<li><a href="<?php echo get_permalink( $page_id ); ?>"><?php echo $title; ?></a></li>
						<?php } ?>
						<li><a href="<?php echo $logout_url; ?>"><?php _e('Logout','woocommerce'); ?></a></li>
					</ul>

					<?php else: ?>
					<?php


						if ( !class_exists('CloudFw_Walker_Login_Menu') ) {
							/**
							 *  CloudFw Custom Navigation Menu Walker
							 *
							 *  @since 1.0
							**/
							class CloudFw_Walker_Login_Menu extends Walker_Nav_Menu {

								function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
									$element->has_children = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

									return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
								}

								function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
								   $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
								   $class_names = $value = '';

								   $classes = empty( $item->classes ) ? array() : (array) $item->classes;
								   $classes[] = 'depth-'.$depth;

								   if ( $depth === 0 )
										$classes[] = 'ui--gradient ui--gradient-grey on--hover';

									$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
									$class_names = ' class="'. esc_attr( $class_names ) . '"';


									$output .= $indent . '<li ';
									$output .= $item->ID ? 'id="menu-item-' . $item->ID .'"' : '';
									$output .= $value . $class_names .'>';
									$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
									$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
									$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
									$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

									$item_output = $args->before;

									$item_output .= $args->link_before;
									$item_output .= '<a'. $attributes .'>';
									$item_output .= apply_filters( 'the_title', $item->title, $item->ID );

									$item_output .= '</a>';
									$item_output .= $args->link_after;

									$item_output .= $args->after;

									$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
								}

							}


							wp_nav_menu( array(
									'fallback_cb'     => '__return_false',
									'menu'            => $custom_menu_id,
									'container'       => false,
									'menu_class'      => 'sub-menu',
									'menu_id'         => 'custom-login-menu',
									'before'          => '',
									'after'           => '',
									'link_before'     => '',
									'link_after'      => '',
									'depth'           => 2,
									'walker'          => new CloudFw_Walker_Login_Menu(),
								)
							);

						}

					?>

					<?php endif; ?>
				<?php endif; ?>
			</li>
		<?php } ?>
</ul>

<?php } ?>