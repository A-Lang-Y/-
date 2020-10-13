<?php

/**
 *	Get Main Slider Form
 *
 *	@since 1.0
 */
function cloudfw_main_slider_forms( 
	$this_page = NULL,
	$lastID = NULL,
	$slider_data = array(),
	$id = NULL ){
		
	# Load Render Functions
	include_once(TMP_PATH.'/cloudfw/core/engine.slider/source.slider.php');
	require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');

	$slider_type = cloudfw_get_slider_type($id);
				
	if ($id) 
		$slider_type = cloudfw_get_slider_type($id);
		
	if (!$slider_type):
		echo cloudfw_error_message( __('Slider Cannot Found','cloudfw') );
		return false; 
	endif;


	if (file_exists(TMP_PATH.'/cloudfw/core/engine.slider/core.slider.get_form.php'))
		require(TMP_PATH.'/cloudfw/core/engine.slider/core.slider.get_form.php');
	else
		exit ('File Cannot Found:'. TMP_PATH.'/cloudfw/core/engine.slider/core.slider.get_form.php');
}


/**
 *	Get The Forms of A Slider Item
 *
 *	@since 1.0
 */
function cloudfw_sub_slider_forms(
	$this_page     = NULL,
	$raw_this_page = NULL, 
	$lastID        = NULL,
	$slider_data   = array(),
	$id            = NULL,
	$mid           = NULL
){

	# Load Render Functions
	include_once(TMP_PATH.'/cloudfw/core/engine.slider/source.slider.php');
	require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');

	global $main_slider_id, $main_slider_data;
	$main_slider_id = $mid;

	$slider_type = cloudfw_get_slider_type( $main_slider_id );

	if (file_exists(TMP_PATH.'/cloudfw/core/engine.slider/core.slider.get_form.items.php')) {
		require(TMP_PATH.'/cloudfw/core/engine.slider/core.slider.get_form.items.php');
	} else {
		exit ('File Cannot Found:'. TMP_PATH.'/cloudfw/core/engine.slider/core.slider.get_form.items.php');
	}

} 

/**
 *	Loop All Slider Items
 *
 *	@since 1.0
 */
function cloudfw_loop_slider_items( $data, $case = NULL, $main_slider_id = NULL ) {

	$echo_form = isset($_REQUEST['no_form']) ? $_REQUEST['no_form'] : NULL;
	if ( ! $echo_form ) {
		echo '<div id="slider_items"><form id="sorting_form" method="post" class="ctrl_s_form" action="', isset($this_page) ? $this_page : NULL ,'">';
	}
	
	echo '<input type="hidden" id="comeback" name="comeback" value="', isset($this_page) ? $this_page : NULL ,'" />
		  <input type="hidden" id="main_slider_id" name="main_slider_id" value="', isset($main_slider_id) ? $main_slider_id : NULL ,'" />
		  <input type="hidden" id="form_selector" name="form_selector" value="'.PFIX.'_slider_sorting" />';
		  wp_nonce_field('cloudfw','_wp_nonce');

		require(TMP_PATH.'/cloudfw/core/engine.slider/core.slider.loop_items.php');	
	
	if ( ! $echo_form ) {
		echo '</form></div>';
	}

}

/**
 *	Loop Main Sliders
 *
 *	@since 1.0
 */
function cloudfw_loop_all_sliders($data, $case=NULL, $this_page = NULL) {
	require (TMP_PATH.'/cloudfw/core/engine.slider/core.slider.loop_main.php');				
}