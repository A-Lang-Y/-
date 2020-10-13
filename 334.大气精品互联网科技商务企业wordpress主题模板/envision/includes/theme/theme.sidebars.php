<?php
/**
 *	Register Theme Sidebars
 *
 *	by cloudfw_register_sidebars() on widgets_init hook
 *	@since 1.0
 */
add_action( 'init', 'cloudfw_register_sidebars' );
function cloudfw_register_sidebars() {
	global $_opt, $widget_bars;
	
	register_sidebar( array(
		'name' 			=> __('Default Page Sidebar','cloudfw'),
		'id' 			=> 'default-widget-area',
		'description' 	=> __('Default Page Sidebar','cloudfw'),
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="sidebar-widget-title ui--widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	) );

	/*register_sidebar( array(
		'name' 			=> __('Header Sidebar 1','cloudfw'),
		'id' 			=> 'header-widget-area',
		'before_widget' => '<div id="%1$s" class="widget-header %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="header-widget-title hidden">',
		'after_title' 	=> '</h4>',
	) );

	register_sidebar( array(
		'name' 			=> __('Header Sidebar 2','cloudfw'),
		'id' 			=> 'header-widget-area-2',
		'before_widget' => '<div id="%1$s" class="widget-header %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="header-widget-title">',
		'after_title' 	=> '</h4>',
	) );*/

	register_sidebar( array(
		'name' 			=> __('Blog Sidebar','cloudfw'),
		'id' 			=> 'blog-widget-area',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="sidebar-widget-title ui--widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	) );

	register_sidebar( array(
		'name' 			=> __('Search Page Sidebar','cloudfw'),
		'id' 			=> 'searchpage-widget-area',
		'description' 	=> __('Search Page Sidebar','cloudfw'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="sidebar-widget-title ui--widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	) );

	register_sidebar( array(
		'name' 			=> __('Archive Pages Sidebar','cloudfw'),
		'id' 			=> 'archive-widget-area',
		'description' 	=> __('Archive Pages Sidebar','cloudfw'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="sidebar-widget-title ui--widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	) );
	
	register_sidebar( array(
		'name' 			=> __('404 Error Page Sidebar','cloudfw'),
		'id' 			=> '404-widget-area',
		'description' 	=> __('404 Error Page Sidebar','cloudfw'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="sidebar-widget-title ui--widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	) );


	$footer_widget_number = 8;
	if ( !$footer_widget_number > 0 )
		$footer_widget_number = 1;

	for ($footer_widget_i =1; $footer_widget_i  <= $footer_widget_number; $footer_widget_i ++) { 
		register_sidebar( array(
			'name' 			=> sprintf(__('Footer Sidebar - %s','cloudfw'), $footer_widget_i),
			'id' 			=> 'footer-widget-area-' . $footer_widget_i,
			'description' 	=> '',
			'before_widget' => '<div id="%1$s" class="widget widget-footer %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="footer-widget-title ui--widget-title">',
			'after_title' 	=> '</h4>',
		) );
	}


	if ($custom_sidebars = cloudfw_get_custom_sidebars()):
		foreach ($custom_sidebars as $custom_sidebar_id => $custom_sidebar ){
			register_sidebar( array(
				'name' 			=> $custom_sidebar["name"],
				'id' 			=> $custom_sidebar["id"],
				'description' 	=> $custom_sidebar["desc"],
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h4 class="sidebar-widget-title ui--widget-title"><span>',
				'after_title'	=> '</span></h4>',
			) );
		}
	endif;

}