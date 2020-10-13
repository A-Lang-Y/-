<?php

add_filter('woocommerce_show_page_title', '__return_false');


add_filter('woocommerce_add_to_cart_message', 'cloudfw_woocommerce_clear_chars');
add_filter('woocommerce_cart_item_name', 'cloudfw_woocommerce_clear_chars');
add_filter('woocommerce_widget_cart_product_title', 'cloudfw_woocommerce_clear_chars');
add_filter('woocommerce_checkout_product_title', 'cloudfw_woocommerce_clear_chars');
add_filter(' woocommerce_order_item_name', 'cloudfw_woocommerce_clear_chars');
function cloudfw_woocommerce_clear_chars( $data ) {
	$data = str_replace('&rarr;', '<i class="fontawesome-angle-right"></i>', $data);
	return $data;

}

/** Skin map */
add_filter( 'cloudfw_skin_map_object', 'cloudfw_woocommerce_skin_map' );
function cloudfw_woocommerce_skin_map( $map ){
	/** Price Range */
	$map  -> push    ( 'accent' , '.woocommerce .ui-slider .ui-slider-range' );

	$map  -> id      ( 'woocommerce_message_before' )
		  -> selector( '.woocommerce-message:before' )
		  -> sync    ( 'gradient', 'accent', 'gradient' );

	$map  -> id      ( 'woocommerce_message' )
		  -> selector( '.woocommerce-message' )
		  -> sync    ( 'border-top-color', 'accent', array( 'gradient', 0 ) );

	return $map;
}



/** Typo map */
add_filter( 'cloudfw_typo_map_object', 'cloudfw_woocommerce_typo_map' );
function cloudfw_woocommerce_typo_map( $map ){
	cloudfw_add_typo_setting( $map, 'portfolio_product_titles', '.woocommerce .ui--content-box-title-text', array( 'font-weight' => 400 ));

	return $map;
}


/** Typo Scheme */
add_filter( 'cloudfw_typo_scheme', 'cloudfw_woocommerce_typo_scheme', 10, 3 );
function cloudfw_woocommerce_typo_scheme( $scheme, $data, $number ){

	$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
		'type'          =>  'container',
		'width'         =>  940,
		'footer'        =>  false,
		'title'         =>  __('WooCommerce','cloudfw'),
		'data'          =>  array(

			array(
				'type'      =>  'typo-set',
				'title'     =>  __('WooCommerce - Products List Titles','cloudfw'),
				'id'        =>  cloudfw_sanitize('portfolio_product_titles'),
				'value'     =>  $data['portfolio_product_titles'],
				'data'      =>  array()

			),

		)

	);

	return $scheme;

}



/**
 *  Activate Shortcode Admin UI for Products
 *
 *  @package CloudFw
 *  @since   1.0
 */
//add_filter('cloudfw_composer_default_types',          'cloudfw_module_activate_shortcodes_on_products');
add_filter('cloudfw_post_types_for_composer',         'cloudfw_module_activate_shortcodes_on_products');
add_filter('cloudfw_post_types_for_core_metaboxes',   'cloudfw_module_activate_shortcodes_on_products');
function cloudfw_module_activate_shortcodes_on_products( $post_types ) {
	$post_types[] = 'product';
	return $post_types;
}

add_filter('single_product_large_thumbnail_size', 'cloudfw_wc_single_product_large_thumbnail_size');
function cloudfw_wc_single_product_large_thumbnail_size( $post_types ) {
	return 'large';
}


/** Breadcrumb for WooCommerce */
add_filter('cloudfw_breadcrumbs_is_post_type_archive_product', '__return_false');
add_filter('cloudfw_breadcrumbs_is_singular_product', '__return_false');
add_filter('cloudfw_breadcrumbs_singular_product_before', 'cloudfw_breadcrumbs_singular_product_before');
add_filter('cloudfw_breadcrumbs_archive_product_before', 'cloudfw_breadcrumbs_singular_product_before');
add_filter('cloudfw_breadcrumbs_archive_product_cat_before', 'cloudfw_breadcrumbs_singular_product_before');
function cloudfw_breadcrumbs_singular_product_before( $trial ) {

	$shop_page_id = woocommerce_get_page_id( 'shop' );
	if ( !empty($shop_page_id) && is_numeric($shop_page_id) ) {
		$page_data = get_page( $shop_page_id );
		if ( !empty($page_data->post_title) ) {
			$trial[] = '<a href="'. get_page_link( $shop_page_id ) .'">'. $page_data->post_title .'</a>';
		}
	}

	if ( is_singular('product') ){
		global $post;

		if ( $terms = wp_get_post_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {

			$main_term = $terms[0];

			$ancestors = get_ancestors( $main_term->term_id, 'product_cat' );

			$ancestors = array_reverse( $ancestors );

			foreach ( $ancestors as $ancestor ) {
				$ancestor = get_term( $ancestor, 'product_cat' );
				$trial[] = '<a href="' . get_term_link( $ancestor->slug, 'product_cat' ) . '">' . $ancestor->name . '</a>';
			}

			 $trial[] = '<a href="' . get_term_link( $main_term->slug, 'product_cat' ) . '">' . $main_term->name . '</a>';

		}
	}

	return $trial;

}

/**
 * Disables to generate auto breadcrumb item via the url for WooCommerce product pages.
 */
add_filter('cloudfw_breadcrumbs_is_get_parent_id_' . woocommerce_get_page_id( 'shop' ), '__return_false');
add_filter('cloudfw_breadcrumbs_is_get_parent', 'cloudfw_wc_breadcrumbs_is_get_parent');
function cloudfw_wc_breadcrumbs_is_get_parent() {
	return ! is_woocommerce();
}

/**
 *	Navigation Menu Cart
 */
add_action( 'cloudfw_primary_navigation', 'cloudfw_woocommerce_navigation_cart', 9 );
function cloudfw_woocommerce_navigation_cart() {
	if ( ! cloudfw_woocommerce() || cloudfw_check_onoff( 'woocommerce', 'catalog_mode' ) ){
		return;
	}

	if ( ! cloudfw_check_onoff( 'woocommerce', 'cart_in_navigation' ) ) {
		return;
	}

	global $woocommerce;

	$cart_total = $woocommerce->cart->get_cart_subtotal();
	$cart_url = $woocommerce->cart->get_cart_url();
?>

	<div id="woocommerce-nav-cart" class="pull-right <?php echo cloudfw_visible('widescreen') ?>">
		<a href="<?php echo $cart_url ?>" class="ui--side-panel" data-target="ui--side-cart-widget"><?php echo cloudfw_make_icon( 'Icomoon/icomoon-cart||size:18' ); ?> <span class="cart-money"><?php echo $cart_total ?></span></a>
	</div>

<?php
}


/**
 *  Side Menu Cart
 */
add_action('cloudfw_side_panel', 'cloudfw_woocommerce_side_panel_cart');
function cloudfw_woocommerce_side_panel_cart(){
?>
	<div id="ui--side-cart-widget">
		<h3><strong><?php _e('Cart','woocommerce'); ?></strong></h3>
		<div id="ui--side-cart" class="woocommerce">
			<?php echo woocommerce_mini_cart(); ?>
		</div>
	</div>
<?php
}


/**
 *    Register Ajax Function :: Get Posts for Selector
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_woocommerce_mini_cart', 'cloudfw_woocommerce_ajax_mini_cart' );
add_action( 'wp_ajax_nopriv_cloudfw_woocommerce_mini_cart', 'cloudfw_woocommerce_ajax_mini_cart' );
function cloudfw_woocommerce_ajax_mini_cart() {
	woocommerce_mini_cart();
	die(1);
}


if ( ! is_admin() && cloudfw_check_onoff( 'troubleshooting',  'refresh_carts' ) ) {

	/**
	 *  Side Menu Cart
	 */
	add_action('wp_head', 'cloudfw_ts_woocommerce_cart_refresh');
	function cloudfw_ts_woocommerce_cart_refresh(){
	?>
<script type="text/javascript">
(function(){
	"use strict";

	jQuery(document).ready(function(){

		var vars = {
			action: "woocommerce_get_refreshed_fragments",
		};

		jQuery.ajax({
			url: CloudFwOp.ajaxUrl,
			cache: false,
			type: "POST",
			data: vars,
			success: function(response) {
				try {
					var fragments = response.fragments;
					var cart_hash = response.cart_hash;
					jQuery('body').trigger( 'added_to_cart', [ fragments, cart_hash ] );				
				} catch (e) {}

			}
		});

	});

})(jQuery);
</script>
	<?php
	}

}