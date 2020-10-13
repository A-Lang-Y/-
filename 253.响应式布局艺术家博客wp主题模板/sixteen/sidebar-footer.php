<?php
/**
 * The Footer Sidebar of the Theme
 *
 * @package Sixteen
 */
?>
	<div id="footer-sidebar" class="widget-area clear" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php 
		if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
		<div class="footer-column"> <?php
			dynamic_sidebar( 'sidebar-2'); 
		?> </div> <?php	
		}
			
		if ( is_active_sidebar( 'sidebar-3' ) ) { ?>
		<div class="footer-column"> <?php
			dynamic_sidebar( 'sidebar-3'); 
		?> </div> <?php	
		}

		if ( is_active_sidebar( 'sidebar-4' ) ) { ?>
		<div class="footer-column"> <?php
			dynamic_sidebar( 'sidebar-4'); 
		?> </div> <?php	
		}
		?>	 		


	</div><!-- #secondary -->
