<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( $downloads = $woocommerce->customer->get_downloadable_products() ) : ?>

	<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h3' ), 
			apply_filters( 'woocommerce_my_account_my_downloads_title', __( 'Available <strong>Downloads</strong>', 'woocommerce' ) ) )); 
	?>


	<ul class="digital-downloads ui--box">
		<?php foreach ( $downloads as $download ) : ?>
			<li class="ui--gradient ui--gradient-grey">
				<?php
					do_action( 'woocommerce_available_download_start', $download );

					if ( is_numeric( $download['downloads_remaining'] ) )
						echo apply_filters( 'woocommerce_available_download_count', '<span class="count">' . sprintf( _n( '%s download remaining', '%s downloads remaining', $download['downloads_remaining'], 'woocommerce' ), $download['downloads_remaining'] ) . '</span> ', $download );

					echo apply_filters( 'woocommerce_available_download_link', '<i class="fontawesome-download-alt"></i> <a href="' . esc_url( $download['download_url'] ) . '">' . $download['download_name'] . '</a>', $download );

					do_action( 'woocommerce_available_download_end', $download );
				?>
			</li>
		<?php endforeach; ?>
	</ul>

<?php endif; ?>