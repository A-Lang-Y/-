<?php 

if ( ! cloudfw_woocommerce() || cloudfw_check_onoff( 'woocommerce', 'catalog_mode' ) )
	return;


global $woocommerce;

$cart_total = $woocommerce->cart->get_cart_subtotal();
$cart_url = $woocommerce->cart->get_cart_url();


 ?><ul id="widget--shop-cart" class="ui--widget ui--custom-menu opt--on-hover unstyled-all <?php echo cloudfw_visible( $device ); ?>">
    <li>
    	<?php if ( cloudfw_check_onoff('topbar_widget_shoping_cart', 'show_side_panel') ): ?>
        	<a href="<?php echo $cart_url ?>" class="ui--gradient ui--accent-gradient ui--accent-color on--hover ui--side-panel" data-target="ui--side-cart-widget"><?php _e('Cart','woocommerce'); ?>: <span class="cart-money"><?php echo $cart_total ?></span> <span class="helper--extract-icon"><i class="fontawesome-angle-right px14"></i></span></a>
        <?php else: ?>
        	<a href="<?php echo $cart_url ?>" class="ui--gradient ui--accent-gradient ui--accent-color on--hover"><?php _e('Cart','woocommerce'); ?>: <span class="cart-money"><?php echo $cart_total ?></span> <span class="helper--extract-icon"><i class="fontawesome-angle-right px14"></i></span></a>
        <?php endif; ?>
    </li>
</ul>