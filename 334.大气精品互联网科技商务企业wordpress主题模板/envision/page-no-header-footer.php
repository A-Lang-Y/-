<?php
/**
 *	Template Name: No Header and Footer
 *
 *	@since 1.0
 */

cloudfw( 'set', 'layout', basename(__FILE__) );
cloudfw( 'set', 'sidebar', false );
cloudfw( 'set', 'sidebar-position', '' );
cloudfw( 'set', 'disable_header', true );
cloudfw( 'set', 'disable_footer', true );
cloudfw( 'check', 'type' );
cloudfw( 'check', 'is_blog' );
get_header(); ?>

	<?php cloudfw( 'page' ); ?>

<?php get_footer(); ?>