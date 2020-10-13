<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo do_shortcode( cloudfw_translate('code_single_before_content', 'woocommerce') );

?>
<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
