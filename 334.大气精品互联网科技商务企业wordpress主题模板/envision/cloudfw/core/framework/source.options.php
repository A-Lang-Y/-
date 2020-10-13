<?php


function cloudfw_font_icons_list(){
	$icons = array();
	return apply_filters( 'cloudfw_font_icons', $icons );
}

/**
 *	Get All Posts
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_all_pages(){
	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) ) {
		
		return cloudfw_vc_get( __FUNCTION__, 'cache' );

	} else {

		$defaults = array(
			'depth'                 => 0,
			'child_of'              => 0,
			'name'                  => 'page_id',
			'id'                    => '',
		);

		extract( $defaults, EXTR_SKIP );
		$pages = get_pages( $defaults );

		$out = array();            
		$out_loop = array();            
		$out['NULL'] = '- '. __('Default','cloudfw') .' -';

		if ( ! empty($pages) ) {
			$out_loop = cloudfw_walk_page_dropdown_tree( $pages, $depth, $defaults );
		}

		$out = $out + (array) $out_loop;
		return cloudfw_vc_set( __FUNCTION__, 'cache', $out );
	
	}

}


/**
 * Retrieve HTML dropdown (select) content for page list.
 *
 * @uses Walker_PageDropdown to create HTML dropdown content.
 * @since 2.1.0
 * @see Walker_PageDropdown::walk() for parameters and return description.
 */
function cloudfw_walk_page_dropdown_tree() {
	$args = func_get_args();
	$walker = new CloudFw_Walker_PageDropdown;
	return call_user_func_array(array($walker, 'walk'), $args);
}

/**
 * Create HTML dropdown list of pages.
 *
 * @package WordPress
 * @since 2.1.0
 * @uses Walker
 */
class CloudFw_Walker_PageDropdown extends Walker {
	/**
	 * @see Walker::$tree_type
	 * @since 2.1.0
	 * @var string
	 */
	var $tree_type = 'page';

	/**
	 * @see Walker::$db_fields
	 * @since 2.1.0
	 * @todo Decouple this
	 * @var array
	 */
	var $db_fields = array ('parent' => 'post_parent', 'id' => 'ID');

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $depth Depth of page in reference to parent pages. Used for padding.
	 * @param array $args Uses 'selected' argument for selected page to set selected HTML attribute for option element.
	 * @param int $id
	 */
	function start_el( &$output, $page, $depth = 0, $args = array(), $id = 0 ) {
		$pad = str_repeat('&nbsp;', $depth * 3);
		$output[ $page->ID ] = $pad . esc_attr( $page->post_title );
	}
}


/**
 *	Prepare Custom Sidebars Array
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_custom_sidebars( $placeholder = true, $placeholder_value = '', $placeholder_title = '' ){
	$out = array(); 

	if ( $placeholder ) {
		$placeholder_value = !empty($placeholder_value) ? $placeholder_value : 'NULL';
		$placeholder_title = !empty($placeholder_title) ? $placeholder_title : __('Default','cloudfw');
		
		$out[ $placeholder_value ] = $placeholder_title; 
	}

	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) ) {
		$out = array_merge($out, (array)cloudfw_vc_get( __FUNCTION__, 'cache' ));

	} else {
		if ( is_array( $GLOBALS['wp_registered_sidebars'] ) ) {
			$default_sidebars = array();
			foreach( $GLOBALS['wp_registered_sidebars'] as $sidebar_id => $sidebar_data )
				if ( cloudfw_custom_sidebar_exists( $sidebar_id ) )
					$sidebars[__('Custom Sidebars','cloudfw')][ $sidebar_data['id'] ] = $sidebar_data['name'];
				else
					$sidebars[__('Theme Sidebars','cloudfw')][ $sidebar_data['id'] ] = $sidebar_data['name'];		

			$out = array_merge($out, (array)cloudfw_vc_set( __FUNCTION__, 'cache', $sidebars ));
		} 
	}

	return $out;	
}

/**
 *	Prepare Custom Sidebars Array
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_page_templates(){
	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) )
		return cloudfw_vc_get( __FUNCTION__, 'cache' );
		
	$out = array();
	$out['NULL'] = '-';
	$out['default'] = __('Default','cloudfw');

	/** Get All Templates  */
	$templates = get_page_templates();

	foreach ( $templates as $template => $template_id ) {
		$out[$template_id] = $template;
	}

	return cloudfw_vc_set( __FUNCTION__, 'cache', $out );
}

/**
 *	Prepare Topbar Widget List
 *
 *	@since 1.0
 */
function cloudfw_admin_get_topbar_widget_list(){
	$out = array();
	$out['NULL'] = '';

	$class = new CloudFw_TopBar_Widgets;
	$out = array_merge( $out, (array) $class->widget_list() );

	return $out;
}


/**
 *	Prepare Socialbar Services
 *
 *	@since 1.0
 */
function cloudfw_admin_get_socialbar_services(){
	$out = array();
	if ( function_exists('cloudfw_socialbar_services') )
		foreach ( (array) cloudfw_socialbar_services() as $service_id => $service )
			$out[ $service_id ] = $service['title'];

	return $out;
}


/**
 *	Prepare List of All Menus
 *
 *	@since 1.0
 */
function cloudfw_admin_get_all_menus(){
	$out = array();
	$out['NULL'] = '';

	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	foreach ( (array) $menus as $menu )
		$out[ $menu->term_id ] = $menu->name;

	return $out;
}


/**
 *	Prepare List of All Menus
 *
 *	@since 1.0
 */
function cloudfw_admin_get_visibility_options(){
	$out = array();
	$out['NULL'] = __('All Devices','cloudfw');

	$out['desktop']        = __('Only Widescreen Devices','cloudfw');
	$out['desktop-tablet'] = __('Widescreen Devices & Tablets','cloudfw');
	$out['tablet']         = __('Only Tablets','cloudfw');
	$out['tablet-phones']  = __('Tablets & Phones','cloudfw');
	$out['phone']          = __('Only Phones','cloudfw');

	return $out;
}

/**
 *	Text Decoration Options Array
 *
 *	@since 1.0
 */
function cloudfw_admin_array_text_decorations(){
	$out['NULL']         = __('Default','cloudfw');
	$out['none']         = __('None','cloudfw');
	$out['underline']    = __('Underline','cloudfw');
	$out['overline']     = __('Overline','cloudfw');
	$out['line-through'] = __('Line-through','cloudfw');
	return $out;	
}

/**
 *	Background Styles
 *
 *	@since 1.0
 */
function cloudfw_admin_array_bg_styles(){
	$out['NULL']     =	__('Auto','cloudfw');
	$out['cover']    =	__('Cover','cloudfw');
	$out['repeat']   =	__('Repeat','cloudfw');
	$out['repeat-x'] =	__('Repeat Horizontal','cloudfw');
	$out['repeat-y'] =	__('Repeat Vertical','cloudfw');
	$out['no-repeat'] =	__('No Repeat','cloudfw');

	return $out;	
}

/**
 *	Columns
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_columns() { 
	$out = array();
	$out['NULL']   = __('Default','cloudfw');
	$out['1']      = __('1 Column','cloudfw');
	$out['2']      = sprintf(__('%d Columns','cloudfw'), 2);
	$out['3']      = sprintf(__('%d Columns','cloudfw'), 3);
	$out['4']      = sprintf(__('%d Columns','cloudfw'), 4);
	$out['6']      = sprintf(__('%d Columns','cloudfw'), 6);
	return apply_filters('cloudfw_options_columns', $out);
}


/**
 *	Aspect Ratio
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_aspect_ratio() { 
	$out = array();
	$out['NULL']   = __('Default','cloudfw');
	$out['21:9']   = '21:9';
	$out['16:9']   = '16:9';
	$out['4:3']    = '4:3';
	$out['1:1']    = '1:1 (Square)';
	$out['3:4']    = '3:4';
	$out['9:16']   = '9:16';
	$out['9:21']   = '9:21';
	$out['original']   = __('Original','cloudfw');

	return $out;
}

/**
 *	Link Targets
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_link_targets() { 
	$out = array();
	$out['NULL']   = __('Default','cloudfw');
	$out['_blank'] = __('Open on new page','cloudfw');

	return $out;
}

/**
 *	Text Aligns
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_text_aligns() { 
	$out = array();
	$out['NULL']   = __('Default','cloudfw');
	$out['left']   = __('Left','cloudfw');
	$out['center'] = __('Center','cloudfw');
	$out['right']  = __('Right','cloudfw');

	return $out;
}

/**
 *	Background Positions
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_background_positions() { 
	$out = array();
	$out['NULL']          = __('Default','cloudfw');
	$out['50% 50%']       = __('Center, Center','cloudfw');
	$out['0 50%']         = __('Center, Left','cloudfw');
	$out['100% 50%']      = __('Center, Right','cloudfw');
	$out['0 0']           = __('Top, Left','cloudfw');
	$out['100% 0']        = __('Top, Right','cloudfw');
	$out['50% 0']         = __('Top, Center','cloudfw');
	$out['0 100%']        = __('Bottom, Left','cloudfw');
	$out['100% 100%']     = __('Bottom, Right','cloudfw');
	$out['50% 100%']      = __('Bottom, Center','cloudfw');

	return $out;
}

/**
 *	Background Attachments
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_background_attachments() { 
	$out = array();
	$out['NULL']          = __('Default','cloudfw');
	$out['scroll']        = __('Scroll','cloudfw');
	$out['fixed']         = __('Fixed','cloudfw');

	return $out;
}

/**
 *	Background Sizes
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_background_sizes() { 
	$out = array();
	$out['NULL']          = __('Auto','cloudfw');
	$out['cover']         = __('Cover','cloudfw');
	$out['contain']        = __('Contain','cloudfw');

	return $out;
}

/**
 *	Orderby Values
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_order_by() { 
	$out               = array();
	$out['NULL']       = __('Default','cloudfw');
	$out['menu_order'] = __('Menu Order','cloudfw');
	$out['title']      = __('Title','cloudfw');
	$out['date']       = __('Date','cloudfw');
	$out['modified']   = __('Last Modified Date','cloudfw');
	$out['ID']         = __('Post ID','cloudfw');
	$out['parent']     = __('Parent Post/Page ID','cloudfw');
	$out['rand']       = __('Random','cloudfw');

	return $out;
}

/**
 * Order Values
 * 
 * @return array
 */
function cloudfw_admin_loop_order() { 
	$out               = array();
	$out['NULL']       = __('Default','cloudfw');
	$out['ASC']        = __('ASC - Ascending order from lowest to highest values','cloudfw');
	$out['DESC']       = __('DESC - descending order from highest to lowest values','cloudfw');

	return $out;
}

/**
 *	Content Layouts
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_content_layouts() { 
	$out = array();
	$out['NULL']     = __('Normal','cloudfw');
	$out['carousel'] = __('Carousel Layout','cloudfw');
	$out['masonry']  = __('Masonry Layout','cloudfw');

	return $out;
}

/**
 *	CSS Overflow Options
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_overflow() { 
	$out = array();
	$out['NULL']    = __('Default','cloudfw');
	$out['visible'] = __('Visible','cloudfw');
	$out['hidden']  = __('Hidden','cloudfw');

	return $out;
}
