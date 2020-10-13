<?php
/**
 * The Footer for the theme
 *
 * The source codes: "includes/theme/theme.page_generator.php" : footer 
 *
 * @author Orkun GURSEL (support@cloudfw.net)
 *
 * @package WordPress
 * @subpackage CloudFw
 */
$footer_widgets = cloudfw_check_onoff('footer', 'widgetized_enable');  
$footer_widgets_row1_enable = cloudfw_check_onoff('footer', 'row1_enable');  
$footer_widgets_row2_enable = cloudfw_check_onoff('footer', 'row2_enable');  

$footer_bottom = cloudfw_check_onoff('footer_bottom', 'enable');  

?>

	<?php cloudfw( 'footer' ); ?>

    <?php $disable_footer = cloudfw( 'get', 'disable_footer' ); ?>
    <?php if ( ! isset( $disable_footer ) || $disable_footer !== true ): ?>

	<footer class="ui-dark">
			
		<?php if( $footer_widgets ) { ?>
		<div id="footer-widgets">
			<div class="container">
			
			<?php if( $footer_widgets_row1_enable ) { 
			
				$footer_widgets_row1 = cloudfw_get_option('footer', 'row1');
				$footer_widgets_row1 = explode('/', $footer_widgets_row1);

			?>
				<div id="footer-widgets-row1">
					<div class="ui-row row">
						<?php if ( is_array($footer_widgets_row1) ) {
							foreach ($footer_widgets_row1 as $number => $column_class) { 
								$column = ++$number; 
								$sidebar_slug = cloudfw_get_option('footer', 'widget_column_row1_' . $column); 
						?>

						<?php if ( is_active_sidebar( $sidebar_slug ) ) : ?>
							<aside class="widget-area <?php echo $column_class; ?>">
								<?php dynamic_sidebar( $sidebar_slug );?>
							</aside>
				        <?php endif;?>

						<?php } } ?>
					</div>
				</div>

			<?php } ?>


			<?php if( $footer_widgets_row2_enable ) { 
			
				$footer_widgets_row2 = cloudfw_get_option('footer', 'row2');
				$footer_widgets_row2 = explode('/', $footer_widgets_row2);

			?>
				<?php if( $footer_widgets_row1_enable ){ ?>
					<div class="footer-widgets-row-separator ui--footer-seperator-color"></div>
				<?php } ?>

				<div id="footer-widgets-row2">
					<div class="ui-row row">
						<?php if ( is_array($footer_widgets_row2) ) {
							foreach ($footer_widgets_row2 as $number => $column_class) { 
								$column = ++$number; 
								$sidebar_slug = cloudfw_get_option('footer', 'widget_column_row2_' . $column); 
						?>

						<?php if ( is_active_sidebar( $sidebar_slug ) ) : ?>
							<aside class="widget-area <?php echo $column_class; ?>">
								<?php dynamic_sidebar( $sidebar_slug );?>
							</aside>
				        <?php endif;?>

						<?php } } ?>
					</div>
				</div>

			<?php } ?>

			</div>
		</div>
		<?php } ?>
		<?php if( $footer_bottom ) { ?>
		<?php

			/** Get options for the footer bottom bar */
			switch (cloudfw_get_option( 'footer_bottom', 'layout' )) {
				default:
				case 'text/menu':
					$footer_bottom_classes = array(
						'text'       => 'pull-left',
						'navigation' => 'pull-right',
						'main'		 => '',
					); 
					break;
				
				case 'menu/text':
					$footer_bottom_classes = array(
						'text'       => 'pull-right',
						'navigation' => 'pull-left',
						'main'		 => '',
					); 
					break;

				case 'vertical':
					$footer_bottom_classes = array(
						'text'       => '',
						'navigation' => '',
						'main'		 => 'layout--centered',
					); 
					# code...
					break;
			}

			$footer_bottom_text = do_shortcode( cloudfw_translate('text', 'footer_bottom') );

		?>
			<div id="footer-bottom" class="<?php echo $footer_bottom_classes['main']; ?>">
				<div class="container">
					<?php if( !empty($footer_bottom_text) ) { ?>
						<div id="footer-texts" class="<?php echo $footer_bottom_classes['text']; ?>"><?php echo $footer_bottom_text; ?></div>
					<?php } ?>

					<?php     
						wp_nav_menu( array( 
								'fallback_cb'     => '__return_false', 
								'theme_location'  => 'footer',
								'container'       => 'div',
								'container_id' 	  => 'footer-navigation',
								'container_class' => $footer_bottom_classes['navigation'],
								'menu_class'      => 'clearfix unstyled-all', 
								'menu_id'         => '',
								'before'          => '',
								'after'      	  => '</li><li class="ui--separator"> / ',
								'link_before'     => '',
								'link_after'      => '',
								'depth'           => 1,
						    ) 
						);
					 ?>
				</div>
			</div>
		<?php } ?>

	</footer>

	<?php endif; ?>

	<?php do_action( 'cloudfw_append_main_container' ); ?>
	</div><!-- /#page-wrap -->

</div><!-- /#main-container -->

<?php 
	ob_start(); do_action('cloudfw_side_panel'); 
	$side_panel_content = ob_get_contents(); ob_end_clean();

	if ( ! empty( $side_panel_content ) ) { 
?>
	<div id="side-panel" class="ui-row">
	    <?php echo do_shortcode( $side_panel_content ); ?>
	    <?php if ( cloudfw_check_onoff( 'side_panel', 'close_button' ) ) {

			echo cloudfw_create_button(array(
				'id'	=> 'ui--side-panel-close-button',
				'link'	=> 'javascript:;',
				'color' => cloudfw_get_option( 'side_panel_1', 'close_button_style', 'btn-primary' ),
				'block' => false,
				'attributes' => array(
					'data-target' => 'ui--side-content-widget-1',
				)  
			), '<i class="ui--icon fontawesome-remove" style="font-size: 16px;  width: 18px;  height: 18px;"></i>');

	    } ?>
	</div>
<?php } ?>

</div><!-- /#side-panel-pusher -->

<?php wp_footer(); ?>
</body>
<?php do_action( 'cloudfw_after_body' ); ?>
</html>

<?php

global $cloudfw_start, $cloudfw_memory;
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$finish = $time;
$totaltime = ($finish - $cloudfw_start);
$totaltime = round($totaltime,5);

printf ("<!-- /This page took %f seconds to load. -->", $totaltime);

echo "<!-- Memory use: " . number_format(memory_get_usage() - $cloudfw_memory) . " bytes -->";