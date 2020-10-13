<?php

//$custom_sidebar = cloudfw_check_default(cloudfw( 'get_sidebar_id' ), 0);
$custom_sidebar = cloudfw( 'get_sidebar_id' );
$hide_sidebar_on_phones = cloudfw_check_onoff( 'global', 'hide_sidebar_on_phones' );
$class = '';

if ( $hide_sidebar_on_phones ) {
	$class = 'hidden-phone';
}

if ( is_active_sidebar( $custom_sidebar ) || cloudfw_custom_sidebar_exists( $custom_sidebar ) ):

?>

	<aside id="sidebars" class="widget-area <?php echo $class; ?> custom-widget-<?php echo $custom_sidebar;?>">
			<?php dynamic_sidebar( $custom_sidebar ); ?>
	<div id="sidebar-shadow"><div id="sidebar-shadow-top"></div><div id="sidebar-shadow-bottom"></div></div>
	</aside><!-- #custom(<?php echo $custom_sidebar;?>) .widget-area -->


<?php else:  
	if (is_search()) {$get_sidebar = 'searchpage-widget-area';}
	elseif (is_category()) {$get_sidebar = 'archive-widget-area';}
	elseif (is_archive()) {$get_sidebar = 'archive-widget-area';}
	elseif (is_page()) {$get_sidebar = 'default-widget-area';}
	else {$get_sidebar = 'blog-widget-area';}

?>


	<aside id="sidebars" class="widget-area <?php echo $class; ?>">
	<?php if ( ! dynamic_sidebar( $get_sidebar ) ) : ?>
			<?php cloudfw( 'default_sidebar', $get_sidebar );?>
    <?php endif;?>
	<div id="sidebar-shadow"><div id="sidebar-shadow-top"></div><div id="sidebar-shadow-bottom"></div></div>
	</aside>	

<?php endif; ?>