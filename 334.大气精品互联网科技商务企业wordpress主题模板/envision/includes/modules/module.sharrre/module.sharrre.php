<?php

/**
 *	Register Sharrre scripts.
 */
add_action( 'init', 'cloudfw_sharrre_scripts' );
function cloudfw_sharrre_scripts() {
	wp_register_script ('theme-sharrre', cloudfw_relative_path( dirname(__FILE__) ).'/js/jquery.sharrre.js', NULL, NULL, TRUE);
}

/**
 *	Returns Service List of Sharrre.
 */
function cloudfw_sharrre_services( $filter = NULL ) {
	$services = array();
	$services['twitter']    = __('Twitter','cloudfw');
	$services['facebook']   = __('Facebook','cloudfw');
	$services['googleplus'] = __('Google Plus','cloudfw');
	$services['linkedin']   = __('Linkedin','cloudfw');
	$services['pinterest']  = __('Pinterest','cloudfw');

	if ( $filter == 'raw' ) {
		$loop = $services;
		$services = array(); 	
		foreach ($loop as $key => $value)
			$services[] = $key;
	}

	return $services;
}

/**
 *	Returns Service Options of Sharrre.
 */
function cloudfw_sharrre_service_options( $service ) {
	$options = array();
	$options['twitter']    = array( 'title' => __('Tweet','cloudfw'), 'icon' =>  'fontawesome-twitter' );
	$options['facebook']   = array( 'title' => __('Like','cloudfw'), 'icon' =>  'fontawesome-facebook' );
	$options['googleplus'] = array( 'title' => __('+1','cloudfw'), 'icon' =>  'fontawesome-google-plus-sign' );
	$options['linkedin']   = array( 'title' => __('Linkedin','cloudfw'), 'icon' =>  'fontawesome-linkedin' );
	$options['pinterest']  = array( 'title' => __('Pinterest','cloudfw'), 'icon' =>  'fontawesome-pinterest' );

	return isset($options[ $service ]) ? $options[ $service ] : array();
}

/**
 *	Sharrre Function
 */
function cloudfw_sharrre( $services = array(), $options = array(), $title = NULL, $url = NULL ) {
	$options = shortcode_atts(array(
		'id'            => '',
		'class'         => '',
		'align'         => 'center',
		'type'          => 'block',
		'counter'       => true,
		'margin_top'    => '',
		'margin_bottom' => '',

	), _check_onoff_false($options));
	extract( $options );

	if ( empty( $title ) ) {
		$title = esc_attr(get_the_title());
	}

	if ( empty( $url ) ) {
		$url = get_permalink();
	}

	//$url = 'http://sharrre.com/'; 

	wp_enqueue_script('theme-sharrre');

	$out = '';
	if ( is_array($services) ) {

		foreach ($services as $service) {
			$service_options = cloudfw_sharrre_service_options( $service );

			$out .= '<div class="ui--sharrre-'. $service .'" data-url="'. $url .'" data-text="'. $title .'"';
			$out .= ' data-title="';

				if ( !empty($service_options['icon']) )
					$out .= '<i class=\''. $service_options['icon'] .'\'></i> ';

				$out .= '<span class=\'ui--sharrre-link-title\'>';
					$out .= $service_options['title'];
				$out .= '</span>';
			$out .= '"></div>';
		}

	}

	if ( !empty($out) ) {
		$classes = array();
		$classes[] = 'ui--sharrre';
		if ( !empty($align) ) {
			$classes[] = 'text-' . $align;
		}
		$classes[] = 'clearfix';

		if (! $counter ) $classes[] = 'ui--sharrre-counter-hidden';
		if ( $type ) 	 $classes[] = "ui--sharrre-$type";
		if ( $class ) 	 $classes[] = $class;
		
		$out = '<div'. 
			cloudfw_make_id( $id ) . 
			cloudfw_make_class( $classes, true ) .
			cloudfw_make_style_attribute( array(
				'margin-top'    => $margin_top,  
				'margin-bottom' => $margin_bottom,  
			), false ) .
		'>'. $out .'</div>';
	}
		

	return $out;
}

if ( file_exists( trailingslashit(dirname(__FILE__)) . 'module.shortcode.php' ) ) {
	require_once( trailingslashit(dirname(__FILE__)) . 'module.shortcode.php' );
}

/** Register Ajax Functions */
if( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	if ( file_exists(dirname(__FILE__) . '/module.ajax.php') ) {
		require_once( dirname(__FILE__) . '/module.ajax.php' );
	}
}