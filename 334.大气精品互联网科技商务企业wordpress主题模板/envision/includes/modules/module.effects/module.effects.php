<?php

/**
 * Makes CSS Animation
 *
 * @param  array  $atts
 * @param  string $content
 *
 * @return string $content
 */
function cloudfw_make_css_animation( $atts = array(), $content =  NULL ) {
	extract(shortcode_atts(array(
		'effect'      => '',
		'delay'       => NULL,
		'start_delay' => NULL,
	), $atts));

	wp_enqueue_script( 'theme-viewport' );

	$classes = array();
	$classes[] = 'ui--animation-in'; 
	$classes[] = 'make--' . $effect; 
	$classes[] = 'ui--pass'; 
	$classes[] = 'clearfix'; 

	if ( ! (int) $delay > 0 ) {
		$delay = 0;
	}

	return "<div ". 
		cloudfw_make_class($classes, true) .
		cloudfw_make_data_attribute( array(
			'fx'          => $effect,
			'delay'       => $delay,
			'start-delay' => $start_delay,
		), FALSE ) .
	">{$content}</div>";
}

/**
 * Gets CSS Animation Effect List 
 * 
 * @return (array)
 */
function cloudfw_css_effect_list( $no_default = false ){

	$effects = array(
		__('Attention Seekers','cloudfw') => array(
			'fx--appear'			=> __('Appear','cloudfw'),
			'fx--swing'				=> __('Swing','cloudfw'),
			'fx--wobble'			=> __('Wobble','cloudfw'),
			'fx--bounce'			=> __('Bounce','cloudfw'),
		),

		__('Fading Entrances','cloudfw') => array(
			'fx--fadein-ltr'		=> __('Fade In Left to Right','cloudfw'),
			'fx--fadein-rtl'		=> __('Fade In Right to Left','cloudfw'),
			'fx--fadein-ttb'		=> __('Fade In Top to Bottom','cloudfw'),
			'fx--fadein-btt'		=> __('Fade In Bottom to Top','cloudfw'),
			'fx--caption-top'		=> __('Caption Top','cloudfw'),
			'fx--caption-bottom'	=> __('Caption Bottom','cloudfw'),
			'fx--caption-left'		=> __('Caption Left','cloudfw'),
			'fx--caption-right'		=> __('Caption Right','cloudfw'),
		),

		__('Rotating Entrances','cloudfw') => array(
			'fx--rotatein'			=> __('Rotate In','cloudfw'),
			'fx--rotatein-downleft'	=> __('Rotate In Down Left','cloudfw'),
			'fx--rotatein-downright'=> __('Rotate In Down Right','cloudfw'),
		),

		__('3D Effects','cloudfw') => array(
			'fx--flipIn-X'			=> __('Flip In X','cloudfw'),
			'fx--flipIn-Y'			=> __('Flip In Y','cloudfw'),
//			'fx--fly'				=> __('Fly Effect (Beta)','cloudfw'),
		),

	);

	 
	if ( ! $no_default ) {
		
 		$effects = array_merge( array( 'NULL' => __('- Use the parent option -','cloudfw') ), $effects );
 		$effects = array_merge( $effects, array( 'fx--no-effect' =>	__('No Transition Effect','cloudfw') ) );

	}

	return $effects;

}

$shortcode_path = trailingslashit(dirname(__FILE__)) . 'module.shortcode.php'; 
if ( file_exists( $shortcode_path ) ) {
	require_once( $shortcode_path );
}