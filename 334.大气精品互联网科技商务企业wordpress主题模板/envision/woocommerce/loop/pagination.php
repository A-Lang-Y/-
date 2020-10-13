<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp_query;

if ( $wp_query->max_num_pages <= 1 )
	return;
?>


<?php 
	cloudfw( 'pagination', array( 'echo' => true, 'page' => max( 1, get_query_var('paged') ), 'pages' => $wp_query->max_num_pages) );
 ?>
