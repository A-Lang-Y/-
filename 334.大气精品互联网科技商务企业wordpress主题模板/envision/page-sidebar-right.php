<?php
/**
 *	Template Name: Sidebar - Right
 *
 *	@since 1.0
 */

cloudfw( 'set', 'layout', basename(__FILE__) );
cloudfw( 'set', 'sidebar', true );
cloudfw( 'set', 'sidebar-position', 'right' );
cloudfw( 'check', 'type' );
cloudfw( 'check', 'is_blog' );

get_header(); ?>

	<?php cloudfw( 'page', 'sidebar' ); ?>

<?php get_footer(); ?>