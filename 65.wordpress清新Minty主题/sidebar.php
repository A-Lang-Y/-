<?php if ( get_option( 'minty_one_column' ) != 1 ) : ?>

<div id="sidebar" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">

<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
	<div id="sidebar-top">
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-bottom' ) ) : ?>
	<div id="sidebar-bottom">
		<?php dynamic_sidebar( 'sidebar-bottom' ); ?>
	</div>
<?php endif; ?>

</div>

<?php endif; ?>