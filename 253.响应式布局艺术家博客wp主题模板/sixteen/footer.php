<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sixteen
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
    
    <div class="container">
      <?php if ( of_get_option('credit1', true) == 0 ) { ?>
		<div class="site-info">
			<?php do_action( 'sixteen_credits' ); ?>
			<?php printf( __( 'Sixteen Theme by %1$s', 'sixteen' ), '<a href="http://inkhive.com" rel="designer">InkHive</a>' ); ?>
		</div><!-- .site-info -->
      <?php } //endif ?>  
        <div id="footertext">
        	<?php
			if ( (function_exists( 'of_get_option' ) && (of_get_option('footertext2', true) != 1) ) ) {
			 	echo of_get_option('footertext2', true); } ?>
        </div>    
        
        </div><!--.container-->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php		
	if ( (function_exists( 'of_get_option' ) && (of_get_option('footercode1', true) != 1) ) ) {
			 	echo of_get_option('footercode1', true); } ?>
			 	
<?php wp_footer(); ?>
</body>
</html>