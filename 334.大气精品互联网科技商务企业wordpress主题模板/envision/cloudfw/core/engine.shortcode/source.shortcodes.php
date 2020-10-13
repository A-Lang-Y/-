<?php

/**
 *	Prepare Slider Selector
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_sliders(){
	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) )
		return cloudfw_vc_get( __FUNCTION__, 'cache' );

	$sliders = get_option(PFIX.'_slider_ids');
	$theme_sliders = cloudfw_sliders();
	$option = array();

	$option["NULL"] = '- '.__('Please select a slider','cloudfw'). ' -'; 
	if (is_array($sliders)): foreach ((array) $sliders as $slider_id_ => $slider){

		if ( !isset( $theme_sliders[ $slider["type"] ]["name"] ) || !$slider_id_ )
			continue;

		$items = get_option( $slider_id_ );
		$option[ $theme_sliders[ $slider["type"] ]["name"] ][ $slider_id_ ] = esc_attr($slider["title"]) . ' | '.sprintf(__('%s item(s)','cloudfw'),  _if ( is_array( $items ), count( $items ), 0 ) ).'';
	} endif;
	
	return cloudfw_vc_set( __FUNCTION__, 'cache', $option );
}

/**
 *	Prepare Revolution Slider Selector
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_rev_sliders(){
	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) )
		return cloudfw_vc_get( __FUNCTION__, 'cache' );

	$out = array();
	$out['NULL'] = __('No Slider','cloudfw');

	if(class_exists('RevSlider')){
	    $slider = new RevSlider();
		$sliders = $slider->getArrSliders();
		foreach($sliders as $revSlider) 
			$out[$revSlider->getAlias()] = $revSlider->getTitle();
	}

	return cloudfw_vc_set( __FUNCTION__, 'cache', $out );
}

/**
 *	Prepare Contact Form Posts
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_contact_forms(){
	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) )
		return cloudfw_vc_get( __FUNCTION__, 'cache' );
	
	$out = array();

	if ( post_type_exists('wpcf7_contact_form') ) {
		global $post;
		$tmp_post = $post;
		
		$args = array(
			'numberposts' => -1,
			'orderby'     => 'ID',
			'order'       => 'ASC',
			'post_type'   => 'wpcf7_contact_form'
		);

	    $posts = new WP_Query( $args );
	    if( $posts->have_posts()) : while( $posts->have_posts() ) : $posts->the_post();
			$out[ get_the_ID() ] = esc_attr(__t( get_the_title() ));
	    endwhile; endif;

		$post = $tmp_post;
		wp_reset_query();
	}
	
    if ( !$out )
		$out['NULL'] = '';

	return cloudfw_vc_set( __FUNCTION__, 'cache', $out );
}

/**
 *	Prepare Titlebar Styles
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_titlebar_styles( $default_text = NULL ){
	$out = array();
	$out["NULL"] = isset($default_text) ? $default_text : __('Default','cloudfw');
	
	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) ) {
		$out = array_merge($out, cloudfw_vc_get( __FUNCTION__, 'cache' ));

	} else {
	    $styles = cloudfw_walk_options( array( 
			'id'               => 'indicator',
			'name'             => 'name',
	    ), cloudfw_get_option('titlebar_styles') );

		$out_live = array();
	    if ( isset($styles) && is_array($styles) )
	    	$i = 0; 
	    	foreach( $styles as $style ) {
	    		$out_live[ $style['id'] ] = !empty($style['name']) ? $style['name'] : sprintf(__('Unnamed Title Bar Style %s','cloudfw'), ++$i);
	    	}    

		cloudfw_vc_set( __FUNCTION__, 'cache', $out_live );
		$out = array_merge($out, $out_live );
		unset($out_live);
	}

	return $out;
}

/**
 *	Prepare Section Styles
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_section_styles( $default_text = NULL ){
	$out = array();
	$out["NULL"] = isset($default_text) ? $default_text : __('Default','cloudfw');
	
	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) ) {
		$out = array_merge($out, cloudfw_vc_get( __FUNCTION__, 'cache' ));

	} else {
	    $styles = cloudfw_walk_options( array( 
			'id'               => 'indicator',
			'name'             => 'name',
	    ), cloudfw_get_option('section_styles') );

		$out_live = array();
	    if ( isset($styles) && is_array($styles) )
	    	$i = 0; 
	    	foreach( $styles as $style ) {
	    		$out_live[ $style['id'] ] = !empty($style['name']) ? $style['name'] : sprintf(__('Unnamed Section Style %s','cloudfw'), ++$i);
	    	}    

		cloudfw_vc_set( __FUNCTION__, 'cache', $out_live );
		$out = array_merge($out, $out_live );
		unset($out_live);
	}

	return $out;
}


/**
 *	Get Term List by Slug
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_terms( $slug, $default_text = NULL, $option_title = '' ){
	$out = array();
	$terms = get_terms($slug, 'orderby=name&hide_empty=0');
	
	if ( empty( $option_title ) ) {
		$option_title = __('%1$s (%2$s)','cloudfw'); 
	}

	$out['NULL'] = $default_text;

	foreach ((array) $terms as $term)
		$out[ $term->term_id ] = sprintf( $option_title,  $term->name,  $term->count );

	return $out;
}

/**
 *	Get Term List by Slug
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_terms_for_slug( $slug, $default_text = NULL, $option_title = '' ){
	$out = array();
	$terms = get_terms($slug, 'orderby=name&hide_empty=0');

	if ( empty( $option_title ) ) {
		$option_title = __('%1$s (%2$s)','cloudfw'); 
	}

	$out['NULL'] = $default_text;

	foreach ((array) $terms as $term)
		$out[ $term->slug ] = sprintf( $option_title,  $term->name,  $term->count );

	return $out;
}

/**
 *	Get Posts by Slug
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_posts( $slug, $default_text = NULL ){
	global $post;
	$tmp_post = $post;

	$out = array();
	
	if ( isset($default_text) )
		$out['NULL'] = $default_text;

    $args = array(
	    'post_type'	 		=>	$slug,
	    'post_status'		=>	'publish',
	    'posts_per_page'	=> -1,
	    'orderby'    		=> 'menu_order ID',
	    'order'      		=> 'DESC',
    );

    $posts = new WP_Query( $args );
    if( $posts->have_posts()) : while( $posts->have_posts() ) : $posts->the_post();
		$out[ get_the_ID() ] = esc_attr(__t( get_the_title() ));
    endwhile; endif;

	$post = $tmp_post;
	wp_reset_query();
	
	return $out;
}
