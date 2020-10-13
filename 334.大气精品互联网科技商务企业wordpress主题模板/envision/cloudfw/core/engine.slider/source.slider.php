<?php


function cloudfw_admin_get_main_sliders(){
	global $_opt;
	$this_page = cloudfw_admin_this_page();
	
	echo '
	    <input type="hidden" id="slider_form_option_thispage" value="', isset($this_page) ? $this_page : NULL ,'" />
	    <input type="hidden" id="slider_form_option_lastid" value="', isset($lastID) ? $lastID : NULL ,'" />
	    <input type="hidden" id="slider_form_action" value="loop" />
	    <input type="hidden" id="slider_form_type" value="main_sliders" />	    
	';

	echo '<div id="sliderforms">';

	$msid = isset($_REQUEST['msid']) ? $_REQUEST['msid'] : NULL;

	if ( !empty( $msid ) ) {

		/** Get all datas */
		$all_datas = isset($_opt[PFIX."_slider_ids"]) ? $_opt[PFIX."_slider_ids"] : NULL;

		/** Get slider datap */
		$data = isset($all_datas[ $msid ]) ? $all_datas[ $msid ] : NULL;

		cloudfw_main_slider_forms( 
			isset($this_page) ? $this_page : NULL, 
			isset($lastID) ? $lastID : NULL, 
			isset($data) ? $data : NULL, 
			isset($msid) ? $msid : NULL 
		);

	} else {
		cloudfw_loop_all_sliders( $_opt[PFIX."_slider_ids"], NULL, $this_page );
	} 

	echo '</div>';

}

function cloudfw_admin_get_slider_items(){
	global $_opt, $this_page;
	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	$tab = isset($_GET['tab']) ? $_GET['tab'] : NULL;
	
	$this_page = CLOUDFW_PAGE;
	if (isset($tab) && $tab) {
		$this_page .= '&tab='.$tab;
	}

	$raw_this_page = $this_page;
	$this_page = $this_page.'&amp;id='.$id;

    $cloudfw_sliders = cloudfw_sliders();
    $type = cloudfw_get_slider_type($id);

	echo '
		<input type="hidden" id="slider_form_option_thispage" value="', isset($this_page) ? $this_page : NULL ,'" />
		<input type="hidden" id="slider_form_option_raw_thispage" value="', isset($raw_this_page) ? $raw_this_page : NULL ,'" />
		<input type="hidden" id="slider_form_option_lastid" value="', isset($lastID) ? $lastID : NULL ,'" />
		<input type="hidden" id="slider_form_option_main_slider_id" value="', isset($id) ? $id : NULL ,'" />
		<input type="hidden" id="slider_form_option_case" value="', isset($type) ? $type : NULL ,'" />
	';

	echo '<div id="sliderforms"> <div id="slider_items">';
    	cloudfw_loop_slider_items(cloudfw_get_slider($id), $type, $id);
 	echo '</div><div class="clear cf"></div></div>';

}

function cloudfw_admin_background_repeat_array() {

	$bg_repeat[] =  array(
		"item_title"	=> __('No-Repeat','cloudfw'),
		"item_value"	=> 'no-repeat'
	);
	
	$bg_repeat[] =  array(
		"item_title"	=> __('Repeat','cloudfw'),
		"item_value"	=> 'repeat'
	);
	
	$bg_repeat[] =  array(
		"item_title"	=> __('Repeated Only Along The X Axis','cloudfw'),
		"item_value"	=> 'repeat-x'
	);

	$bg_repeat[] =  array(
		"item_title"	=> __('Repeated Only Along The Y Axis','cloudfw'),
		"item_value"	=> 'repeat-y'
	);
	
	return $bg_repeat;
}


function cloudfw_admin_nivo_effects_array() {

	$slide_eff = array();
	$slide_eff[] = array('item_title' => 'Random', 'item_value' => 'random');
	$slide_eff[] = array('item_title' => 'Fade', 'item_value' => 'fade');
	$slide_eff[] = array('item_title' => 'sliceDown', 'item_value' => 'sliceDown');
	$slide_eff[] = array('item_title' => 'sliceUp', 'item_value' => 'sliceUp');
	$slide_eff[] = array('item_title' => 'sliceUpLeft', 'item_value' => 'sliceUpLeft');
	$slide_eff[] = array('item_title' => 'sliceUpDown', 'item_value' => 'sliceUpDown');
	$slide_eff[] = array('item_title' => 'sliceUpDownLeft', 'item_value' => 'sliceUpDownLeft');
	$slide_eff[] = array('item_title' => 'Fold', 'item_value' => 'fold');
	$slide_eff[] = array('item_title' => 'slideInRight', 'item_value' => 'slideInRight');
	$slide_eff[] = array('item_title' => 'slideInLeft', 'item_value' => 'slideInLeft');
	$slide_eff[] = array('item_title' => 'boxRandom', 'item_value' => 'boxRandom');
	$slide_eff[] = array('item_title' => 'boxRain', 'item_value' => 'boxRain');
	$slide_eff[] = array('item_title' => 'boxRainReverse', 'item_value' => 'boxRainReverse');
	$slide_eff[] = array('item_title' => 'boxRainGrow', 'item_value' => 'boxRainGrow');
	$slide_eff[] = array('item_title' => 'boxRainGrowReverse', 'item_value' => 'boxRainGrowReverse');
	return $slide_eff;
}

function cloudfw_admin_url_targets_array() {

	$url_targets = array();
	$url_targets[] = array('item_title' => 'Self', 'item_value' => '_self');
	$url_targets[] = array('item_title' => 'Blank', 'item_value' => '_blank');
	$url_targets[] = array('item_title' => 'Parent', 'item_value' => '_parent');
	$url_targets[] = array('item_title' => 'Top', 'item_value' => '_top');
	return $url_targets;
}