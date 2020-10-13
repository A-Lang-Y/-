<?php
/**
 *	Prepare Header Slider Array
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_header_slider(){

	$sliders = get_option(PFIX.'_slider_ids');
	$theme_sliders = cloudfw_sliders();
	$option = array();

	$option["NULL"] = ''; 

	if (is_array($sliders)): foreach ((array) $sliders as $slider_id_ => $slider){
		 if ($slider["type"] !== 'default_slider')
                continue;

		if ($slider["type"] == 'default_slider' || !isset( $theme_sliders[ $slider["type"] ]["name"] ) || !$slider["id"] ) continue;
		$option[ $theme_sliders[ $slider["type"] ]["name"] ][ $slider["id"] ] = esc_attr($slider["title"]) . ' ('.sprintf(_('%s items','cloudfw'), count( (array) get_option( $slider["id"] ) ) ).')';
	} endif;
	
	return $option;
	
}