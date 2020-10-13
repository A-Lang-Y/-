<?php

add_action( 'cloudfw_primary_navigation', 'cloudfw_primary_navigation' );
function cloudfw_primary_navigation() {
	require( trailingslashit(dirname(__FILE__)) . 'class.primary-navigation.php' );
?>

		<div id="header-navigation-toggle" class="<?php echo cloudfw_visible('phone') ?>">
			<a href="javascript:;"><?php echo cloudfw_translate('mobile_navigation'); ?> <i class="fontawesome-align-justify ui--caret"></i></a>
		</div>

	<?php

	wp_nav_menu( array( 
			'fallback_cb'           => '__return_false', 
			'theme_location'        => 'primary',
			'container'             => false,
			'menu_class'            => 'sf-menu clearfix unstyled-all', 
			'menu_id'               => 'header-navigation',
			'before'                => '',
			'after'                 => '',
			'link_before'           => '',
			'link_after'            => '',
			'caret'                 => '<i class="ui--caret fontawesome-angle-down px18"></i>',
			'sub_level_caret_right' => '<i class="ui--caret fontawesome-angle-right px18"></i>',
			'sub_level_caret_left'  => '<i class="ui--caret fontawesome-angle-left px18"></i>',
			'walker'                => new CloudFw_Walker_Primary_Menu(),
		) 
	);

}