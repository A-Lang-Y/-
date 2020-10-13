<?php

function is_theme_setting_page( $variable = NULL ){

	global $pagenow, $cloudfw_setting_slug, $cloudfw_slider_slug;
	$pg = isset($_GET['page']) ? $_GET['page'] : '';
	
	if ($variable == 'editor') {
		if ($pagenow == 'post-new.php' || $pagenow == 'post.php')
			return true;
	} else if ($variable == 'slider') {
		if ($pg == $cloudfw_slider_slug)
			return true;
	} else if ($variable == 'menu') {
		if ($pagenow == 'nav-menus.php')
			return true;
	} else if ($variable == 'widget') {
		if ($pagenow == 'widgets.php')
			return true;
	} else if ($variable == NULL) {
		if ((($pg == $cloudfw_setting_slug || $pg == $cloudfw_slider_slug || $pg == 'CloudFw_Notifier') && ($pagenow == 'admin.php' || $pagenow == 'index.php')) || ($pagenow == 'post.php' || $pagenow == 'post-new.php' || $pagenow == 'nav-menus.php' || $pagenow == 'widgets.php'))
			return true;
		else
			return false;
	} else {
		if ($pg == $variable)
			return true;
		else
			return false;
	}

}


function cloudfw_help_dialog($id = NULL, $title = 'Help', $message = NULL, $float = 'none', $size = 's', $img = NULL, $video = NULL, $echo = true){
	$icon    = ($video) ? 'icon-question-2.png' : 'icon-question.png';
	$video   = ($video) ? '<div style="text-align:center;">' . $video . '</div>' : '';
	$content = ' <a href="#" class="help" rel="mb_' . $id . '" width="' . $size . '" style="float:' . $float . ';" title="' . $title . '" ><img src="' . TMP_ADMIN_GUI . '/' . $icon . '" /></a> <span id="mb_' . $id . '" style="display:none;height: auto;"> <div style="padding:0 20px;"> ' . $img . ' ' . $video . ' ' . $message . ' </div> <div class="clear"></div> </span>';
	if ($echo) {
		echo $content;
	}
		return $content;

}

/**
 *    CloudFw - Create Upload Button
 *
 *    @since 3.0
 */
function admin_create_upload_button_v2($args = array()) {
	extract(cloudfw_make_var(array(
		'id'                  => NULL,
		'preview'             => false,
		'brackets'            => false,
		'value'               => NULL,
		'thumb_path'          => NULL,
		'upload_button_value' => __('Upload A File','cloudfw'),
		'removable'           => false,
		'from_library'        => false,
		'store'               => false,
		'hide_input'          => false,
		'reset'               => NULL,
		'description'         => NULL,
		'wrapClass'           => NULL,
		'class'               => ''
	), $args));

	if ( $value == 'none' )
		 $value = '';

	/** Prepare ID and Name */
	extract( cloudfw_prepare_id_and_name( $id, $brackets ) );

	if ( $preview ) {
		$preview = '<div class="clear"></div>';
		$preview .= '<div id="' . $id . '_preview" class="cloudfw-ui-uploader-preview">';
		//$preview .= ($value && strstr($value, home_url())) ? '<div class="cloudfw-ui-image-preview"><div class="cloudfw-ui-image-preview-padding"><img src="' . cloudfw_thumbnail(_if(!empty($thumb_path), $thumb_path, $value)) . '"/></div></div>' : '';
		$preview .= ($value) ? '<div class="cloudfw-ui-image-preview"><div class="cloudfw-ui-image-preview-padding"><img src="' . $value . '"/></div></div>' : '';
		$preview .= '</div>  ';
	}

	if (!empty($thumb_path)) {
		$thumb_path['src'] = '';
		$thumb_path        = cloudfw_thumbnail($thumb_path);
	}
	
	echo '<div class="cloudfw-ui-uploader-container '. _if( $value, 'cloudfw-ui-uploader-has-value', 'cloudfw-ui-uploader-no-value' ) .'">';
	
		if ($wrapClass)
			echo '<div class="' . $wrapClass . '">';

		/** Set classes */
		$classes = array(); 
		$classes[] = 'cloudfw-ui-uploader-input';
		$classes[] = 'input';

		if ( $hide_input )
			$classes[] = 'hidden';

		$classes[] = $class;

		/** Set input attributes */
		$attributes = array();
		$attributes['type']         = 'text';
		$attributes['id']           = $id;
		$attributes['name']         = $name;
		$attributes['value']        = $value;
		$attributes['autocomplete'] = 'off';
		$attributes['class']        = cloudfw_make_class($classes, 0);
		$attributes['data-path']    = $thumb_path;
		
		if(isset($reset))
			$attributes['data-reset'] = $reset;

		echo '<input'. cloudfw_make_attribute( $attributes, 0 ) .' />';

		/** Set uploader div attributes */
		$uploader_attributes = array();
		$uploader_attributes['id']          = "file-uploader-{$id}";
		$uploader_attributes['class']       = "cloudfw-ui-uploader";
		$uploader_attributes['data-path']   = $thumb_path;
		$uploader_attributes['data-remove-button']  = $removable;
		$uploader_attributes['data-library-button'] = $from_library;
		$uploader_attributes['data-store'] = $store;
		
		echo '<div'. cloudfw_make_attribute( $uploader_attributes, 0 ) .'>';
			echo '<noscript>';
			echo '<p>'. __('Please enable JavaScript to use file uploader.','cloudfw') .'</p>';
			echo '</noscript>';
		echo '</div>';

		echo $description . $preview;
		
		if ($wrapClass)
			echo '</div>';

	echo '</div>';
}


function admin_create_upload_button($id, $value = NULL, $preview = FALSE, $thumb_path = NULL, $upload_button_value = 'Upload an Image', $lastID = NULL, $description = NULL, $delete_button_value = 'Delete', $class = NULL, $wrapClass = NULL) {
	if ($preview) {
		$preview = ' <div id="' . $id . '_preview">';
		$preview .= ($value && strstr($value, home_url())) ? '<div class="cloudfw-ui-image-preview"><img src="' . cloudfw_thumbnail(_if(!empty($thumb_path), $thumb_path, $value)) . '"/></div>' : '';
		$preview .= '</div> ';
	} else {
		$preview = '';
	}
	($delete_button_value) ? $delete = TRUE : $delete = FALSE;
	if (!empty($thumb_path)) {
		$thumb_path['src'] = '';
		$thumb_path        = cloudfw_thumbnail($thumb_path);
	}
	if ($wrapClass)
		echo '<div class="' . $wrapClass . '">';
	echo ' <input type="text" name="' . $id . '" id="' . $id . '" value="' . $value . '" class="input', ($class) ? ' ' . $class : NULL, '" autocomplete="off" /> <div> <a title="' . $id . '_preview" class="small-button small-grey upload_image_button', ($button_class) ? ' ' . $button_class : NULL, '" alt="' . $lastID . '" name="' . $id . '" rel="' . $thumb_path . '"><span>' . $upload_button_value . '</span></a> ', ($delete && $value) ? '<a href="#" name="' . $id . '_delete_areyousure" class="delete_button small-button small-brown"><span>' . $delete_button_value . '</span></a>' : NULL, ' </div> ' . $description . $preview . ' ';
	if ($wrapClass)
		echo '</div>';
}

/**
 *    CloudFw UI - Page Selector
 *
 *    @since 3.0
 */
function cloudfw_ui_page_selector($args = array()) {
	extract(cloudfw_make_var(array(
		'id'                  => NULL,
		'value'               => NULL,
		'brackets'            => false,
		'preview'             => true,
		'button_text'         => __('Select a Page','cloudfw'),
		'description'         => NULL,
		'class'               => '',
		'button_class'        => '',
		'filter'              => '',
		'response'            => 'URL',
		'scope'               => '',
		'hide_input'          => false,
	), $args));

	if ( !is_array($class) ) {
		if ( !empty($class) )
			$class = array( $class );
		else 
			$class = array();
	}

	$class[] = 'cloudfw-ui-page-select-input';

	/** Prepare ID and Name */
	extract( cloudfw_prepare_id_and_name( $id, $brackets ) );

	$the_title = ''; 
	$the_permalink = ''; 
	
	if ( !empty($value) ) {

		if ( is_numeric( $value ) ) {

			$the_ID = $value;
			$the_title = get_the_title( $value ); 
			$the_permalink = get_permalink( $value );

			if( empty($the_permalink) ) {
				$value = $the_ID = $the_title = $the_permalink = ''; 
			}

		} else {

			$exploded_value = explode('||', $value);
			$the_title = isset($exploded_value[0]) ? $exploded_value[0] : NULL;
			$the_permalink = isset($exploded_value[1]) ? $exploded_value[1] : NULL;
			$the_ID = isset($exploded_value[2]) ? $exploded_value[2] : NULL;

			if ( !isset($the_permalink) || empty($the_permalink) )
				$the_permalink = $the_title;

		}

	}

	/** Preview */
	if ( $preview ) {
		$preview_html  = '<div class="cloudfw-ui-page-select-preview '. _if( empty($value), 'hidden' ) .'">';
			$preview_html .= '<a class="cloudfw-ui-page-select-reset" href="javascript:;">';
				$preview_html .= '<img src="' . TMP_ADMIN_GUI . '/cancel.gif" /></a>';
			$preview_html .= '</a> ';
			$preview_html .= '<a class="cloudfw-ui-page-select-title" href="'. $the_permalink .'" target="_blank">';
				$preview_html .= $the_title;
			$preview_html .= '</a> ';
			$preview_html .= '<span class="cloudfw-ui-page-select-permalink">' . $the_permalink . '</span>';
		$preview_html .= '</div>';

		if ( !empty( $value ) )
			$class[] = 'hidden';
	}


	/** Set input attributes */
	$attributes = array();
	$attributes['type']         = ($hide_input === true || $scope == 'internal') ? 'hidden' : 'text';
	$attributes['id']           = $id;
	$attributes['name']         = $name;
	$attributes['value']        = $value;
	$attributes['autocomplete'] = 'off';
	$attributes['placeholder']  = 'http://';
	$attributes['class']        = cloudfw_make_class($class, 0);

	/** Classes for button */
	$button_classes = array();
	$button_classes[] = 'small-button small-grey';
	$button_classes[] = 'cloudfw-ui-page-select';
	if ( $button_class )
		$button_classes[] = $button_class;

	/** Set button attributes */
	$button_attributes = array();
	$button_attributes['href']  = 'javascript:;';
	$button_attributes['class'] = cloudfw_make_class($button_classes, 0);
	$button_attributes['data-response']  = $response;
	$button_attributes['data-filter']  = is_array($filter) ? implode(',', $filter) : $filter;
	$button_attributes['data-preview'] = $preview;

	echo '<div class="cloudfw-ui-page-select-container '. _if( $value, 'cloudfw-ui-has-value', 'cloudfw-ui-no-value' ) .'">';
		echo isset($preview_html) ? $preview_html : NULL;
		echo '<input'. cloudfw_make_attribute( $attributes, 0 ) .'/>';
		echo '<div class="clear"></div>';
		echo '<a'. cloudfw_make_attribute( $button_attributes, 0 ) .'><span>'. $button_text .'</span></a>';
	echo '</div>';

}


function admin_create_color_selection($id, $preview = NULL, $value = NULL, $default_value = NULL, $class = NULL, $float = "left"){
	echo '<div style="float:' . $float . ';"><input type="text" maxlength="6" size="6" id="' . $id . '" name="' . $id . '" autocomplete="off" value="', ($value) ? $value : $default_value, '"', ($preview) ? 'title="' . $id . '_ex_3"' : '', ' class="cloudfw-ui-color input', $class ? ' ' . $class : '', '" /></div>', ($preview) ? '<label for="' . $id . '" class="color-live" id="' . $id . '_ex_3"></label>' : '', '<div class="clear"></div>';
}


function admin_create_color_selection_v2($args = array()){
	extract(cloudfw_make_var(array(
		'id'       => NULL,
		'default'  => NULL,
		'value'    => NULL,
		'brackets' => false,
		'class'    => '',
		'reset'    => '',
	), $args));
	
	if (empty($value))
		$value = $default;

	/** Prepare ID and Name */
	extract( cloudfw_prepare_id_and_name( $id, $brackets ) );

	echo ' <div class="cloudfw-ui-color wrap-color' . _if(empty($value), ' empty') . '' . _if(($class), ' ' . $class) . '"> ';
			echo '<div class="cloudfw-ui-color-handler">';
			echo ' <div class="color-preview"><span class="color-panel"></span> <span class="hex-char">#</span> </div> ';
			echo ' <input type="text" id="' . $id . '" name="' . $name . '" autocomplete="off" value="' . $value . '" maxlength="6" size="6" class="cloudfw-ui-color-input"';
			if( isset($reset) )
				echo ' data-reset="'. $reset .'"';
			echo ' /> ';
			echo ' <a href="#" class="remove-color"></a> ';
		echo ' </div> ';
	echo ' </div> ';
}


function admin_create_gradient_selection($args = array()){
	extract(cloudfw_make_var(array(
		'id'       => NULL,
		'default'  => NULL,
		'value'    => NULL,
		'brackets' => false,
		'class'    => '',
		'reset'    => '',
	), $args));
	
	if (empty($value)) {
		$value = $default;
	}

	if ( !is_array($value) && !empty($value) ) {
		$value = array( 0 => $value );
	}

	$start_color = isset($value[0]) ? $value[0] : NULL;
	$end_color   = isset($value[1]) ? $value[1] : NULL;

	$trimmed = false; 
	if ( substr($id, -1) == ']' ) {
		$id = rtrim( $id, ']' );
		$trimmed = true; 
	}

	$start_color_id = $id . '_0';
	$end_color_id = $id . '_1';

	if ( $trimmed ) {
		$start_color_id .= ']';
		$end_color_id   .= ']';
	}

	/** Prepare ID and Name */


	echo ' <div class="cloudfw-ui-color wrap-color ui-gradient-selector' . _if(empty($start_color), ' empty') . '' . _if(($class), ' ' . $class) . '"> ';

		echo '<div class="cloudfw-ui-color-handler start-color">';
			extract( cloudfw_prepare_id_and_name( $start_color_id, $brackets ) );
			echo ' <div class="color-preview cloudfw-tooltip" title="Start Color"><span class="color-panel"></span> <span class="hex-char">#</span> </div> ';
			echo ' <input type="text" id="' . $id . '" name="' . $name . '" autocomplete="off" value="' . $start_color . '" maxlength="6" size="6" class="cloudfw-ui-color-input input-color-start"';
			if( isset($reset) )
				echo ' data-reset="'. $reset .'"';
			echo ' /> ';
		echo ' </div> ';

		echo '<div class="cloudfw-ui-color-handler end-color">';
			extract( cloudfw_prepare_id_and_name( $end_color_id, $brackets ) );
			echo ' <div class="color-preview color-stop cloudfw-tooltip" title="Stop Color"><span class="color-panel"></span> <span class="hex-char">#</span> </div> ';
			echo ' <input type="text" id="' . $id . '" name="' . $name . '" autocomplete="off" value="' . $end_color . '" maxlength="6" size="6" class="cloudfw-ui-color-input input-color-stop"';
			if( isset($reset) )
				echo ' data-reset="'. $reset .'"';
			echo ' /> ';
		echo ' </div> ';
		echo ' <a href="#" class="remove-color"></a> ';

	echo ' </div> ';

}


function admin_create_icon_selection($args = array()){
	extract(cloudfw_make_var(array(
		'id'           => NULL,
		'default'      => NULL,
		'value'        => NULL,
		'brackets'     => false,
		'class'        => '',
		'allow_custom' => 0,
	), $args));
	
	if (empty($value))
		$value = $default;

	/** Prepare ID and Name */
	extract( cloudfw_prepare_id_and_name( $id, $brackets ) );

	echo '<div class="wrap-icons' . _if(empty($value), ' empty')  . '' . _if(($class), ' ' . $class) . '"'.  _if($allow_custom, ' data-allow-customization="true"') .'>';
		echo '<a href="#" class="select-icon"> <input type="hidden" id="' . $id . '" name="' . $name . '" autocomplete="off" value="' . $value . '" /> ';
		   // echo _if(($value), '<img src="' . cloudfw_make_icon_url($value, true) . '" />');
			echo cloudfw_make_icon( $value );
		echo '</a>';
		echo '<a href="javascript:;" class="remove-icon cloudfw-tooltip" title="'.__('remove','cloudfw').'"></a> ';
		
		echo '<div class="cloudfw-ui-icon-select-menu">';
			echo '<div class="indicator"></div>';
			echo '<a href="javascript:;" class="custom-icon-handler">'. __('Upload custom image','cloudfw') .'</a>';
			echo '<a href="javascript:;" class="library-icon-handler">'. __('From the library','cloudfw') .'</a>';
			echo '<a href="javascript:;" class="font-icon-handler">'. __('Vector icons','cloudfw') .'</a>';
			echo '<a href="javascript:;" class="remove-icon-handler">'. __('Remove','cloudfw') .'</a>';
		echo '</div>';
	echo '</div>';
}


function cloudfw_dialog($title = NULL, $message = NULL, $case = "update", $timeout = 10000 ){
	$message ? NULL : $message = __('Options Updated','cloudfw');

	if ( empty($title) ) {
		$title = $message; 
		$message = '';
	}

	$message = str_replace('"', '\"', $message);

	switch ($case) {
		default:
		case 'update':
			return '
			<script type="text/javascript">
			// <![CDATA[
				jQuery(window).ready(function(){
					"use strict";

					cloudfw_dialog( "'.esc_attr($title).'", "'.$message.'", "'.esc_attr($case).'", "'. $timeout .'" );
				}); 
			// ]]>
			</script>';
	}
}


function admin_create_onoff($id, $value = NULL, $check = FALSE, $default_value = "true", $class = "onoff", $brackets = FALSE ){
	global $_opt;
	$value ? NULL : $value = $_opt[PFIX . $id];
	
	/** Prepare ID and Name */
	extract( cloudfw_prepare_id_and_name( $id, $brackets ) );

	echo ' <input type="hidden" value="onoff" id="is_defined_'.$id.'" name="is_defined_'.$name.'">';
	echo ' <span class="' . $class . '"><span class="cloudfw-ui-label-check', (_check_onoff($value)) ? ' c_on' : NULL, '" for="' . $id . '"><input type="checkbox" value="1" name="' . $name . '" id="' . $id . '"', (_check_onoff($value)) ? ' checked="checked"' : NULL, ' autocomplete="off"></span></span>';
}


function admin_create_slider( $options = array() ){
	extract(cloudfw_make_var(array(
		'id'        => NULL,
		'name'      => NULL,
		'value'     => 0,
		'min'       => 0,
		'max'       => 100,
		'step'      => NULL,
		'steps'     => NULL,
		'range'     => false,
		'min_range' => true,
		'brackets'  => false,
		'slide'     => NULL,
		'preview'   => NULL,
		'orientation'=> NULL,
		'class'     => 'input_200',
		'width'     => 0,
		'reset'     => NULL,
	), $options));

	/** Prepare ID and Name */
	extract( cloudfw_prepare_id_and_name( $id, $brackets ) );

	if ( isset($min) )
		if ( $value < $min )
			$value = $min;

	/** Element Attributes */
	$attributes = array();
	$attributes['type'] = 'number';
	$attributes['id'] = $id;
	$attributes['name'] = $name;
	$attributes['step'] = $step;
	$attributes['min'] = $min;
	$attributes['max'] = $max;
	$attributes['value'] = (float) $value;
	$attributes['autocomplete'] = 'off';
	$attributes['class'] = 'cloudfw-ui-slider';

	/** Slider Options */
	$attributes['data-range'] = $range;
	$attributes['data-min'] = $min;
	$attributes['data-max'] = $max;
	$attributes['data-step'] = $step;
	if ( $steps )
		$attributes['data-steps']= htmlspecialchars( json_encode( $steps ), ENT_NOQUOTES );
	$attributes['data-orientation'] = $orientation;

	$attributes['data-min-range'] = !isset( $min_range ) || $min_range ? true:false;

	if ( ! $attributes['data-min-range'] )
		$class .= ' cloudfw-ui-slider-single';

	if( isset($reset) )
		$attributes['data-reset']   = $reset;


	echo '
	<div style="float:left; margin:5px 5px 5px 0;">
		<div id="slider_' . $id . '" class="slide ' . $class . '" style="'. _if( $width, "width:{$width}px;" ) .'">
		</div>
	</div>
	<div class="slider-live-preview">
		<div class="slider-input">
			<input '.cloudfw_make_attribute( $attributes, 0 ).' />
		</div> 
		<div class="cloudfw-tooltip" title="'. __('edit','cloudfw') .'">' . $preview . '</div>
	</div>';
}


function admin_create_selectlist( $options = array() ) {

	extract(cloudfw_make_var(array(
		'id'                => '',
		'items'             => NULL,
		'default_value'     => NULL,
		'type'              => 'radio',
		'value'             => NULL,
		'main_class'        => NULL,
		'main_select_class' => NULL,
		'multiple'          => FALSE,
		'brackets'          => FALSE,
		'height'            => NULL,
		'ui'                => FALSE,
		'width'             => NULL,
		'reset'             => NULL,
	), $options));

	/** Prepare ID and Name */
	extract( cloudfw_prepare_id_and_name( $id, $brackets ) );

	$value ? NULL : $value = $default_value;
	$main_class ? NULL : $main_class = "custom_label";
	static $list_i;
	if (!isset($list_i))
		$list_i = 0;

	if ( !is_array($items[0]) && count( $items ) > 0 ) {
		$re_items = array();
		foreach( (array) $items as $re_item_id => $re_item_title )
			$re_items[] = array( 'item_title' => $re_item_title, 'item_value' => _if( $re_item_id === 'NULL', '', $re_item_id ) );
		
		$items = $re_items;
	
	}


	if ( $multiple )
		$main_class = str_replace('cloudfw-ui-select', '', $main_class);

	$main_class = trim($main_class); 

	if ( !empty($main_class) )
		echo '<span class="' . $main_class . '">';

	if ($type !== "select"):
		foreach ((array) $items as $item => $it) {
			$item_before = isset($it["item_before"]) ? $it["item_before"] : NULL; 
			$item_after = isset($it["item_after"]) ? $it["item_after"] : NULL;

			$item_value = isset($it["item_value"]) ? $it["item_value"] : NULL;
			$item_class = isset($it["item_class"]) ? $it["item_class"] : NULL;
			$item_html = isset($it["item_html"]) ? $it["item_html"] : NULL;

			$list_i++;
			if ($type == "radio") {
				echo $item_before . ' <label class="cloudfw-ui-label-radio" for="' . $id . '_' . $list_i . '"> <input type="radio" id="' . $id . '_' . $list_i . '" name="' . $name . '" class="' . $item_class . '" value="' . $item_value . '" ', ($value == $item_value) ? ' checked="checked"' : NULL, ' autocomplete="off" /> ' . $item_html . ' </label>' . $item_after;
			} else {
				echo $item_before . ' <label class="cloudfw-ui-label-check" for="' . $id . '_' . $list_i . '"> <input type="checkbox" id="' . $id . '_' . $list_i . '" name="' . $name . '[]" class="' . $item_class . '" value="' . $item_value . '" ';
				if (is_array($value)) {
					if (in_array($item_value, $value)) {
						echo ' checked';
					}
				}
				echo ' autocomplete="off"/> ' . $item_html . ' </label>' . $item_after;
			}
		}
	else:
		
		if ( $multiple )
			echo'<input type="hidden" name="is_defined_'.$id.'" value="true">';
		
		$first_item_title = '';
		$selected_title = ''; 

		echo '<select id="' . $id .'" name="' . $name . '" class="' . $main_select_class . '" autocomplete="off" style="'._if($width, 'width: '.$width.'px;')._if($height, 'height: '.$height.'px !important;').'"'._if($multiple, ' multiple="multiple"') . _if(isset($reset), ' data-reset="'. $reset .'"').'>';
		foreach ((array) $items as $item => $it) {
			$list_i++;
			
			$item_title = isset($it["item_title"]) ? $it["item_title"] : NULL;
			$item_value = isset($it["item_value"]) ? $it["item_value"] : NULL;
			$item_class = isset($it["item_class"]) ? $it["item_class"] : NULL;

			if ( is_array( $item_title ) ) {   
				echo '<optgroup label="'.$item_value.'">';
			}
			else {
				echo '<option value="' . $item_value . '" class="' . $item_class . '"';


				if ( $multiple ){
					if (in_array( $item_value, (array)$value ))
						echo ' selected="selected"';
				} else {
					if ($value == $item_value) {
						echo ' selected="selected"';      
						$selected_title = $item_title;  
					}
				}
					
				echo '>' . $item_title;

				if ( empty($first_item_title) ) {
					$first_item_title = $item_title; 
				}
			}


			if ( is_array( $item_title ) ) {
				
				foreach ((array) $item_title as $sub_item_value => $sub_item_title) {

					echo '<option value="' . $sub_item_value . '"';
					if ( $multiple ){
						if (in_array( $sub_item_value, (array)$value )) {
							echo ' selected="selected"';
						}
					} else {
						if ($value == $sub_item_value) {
							echo ' selected="selected"';      
							$selected_title = $sub_item_title;  
						}
					}

					echo '>' . $sub_item_title;
					if ( empty($first_item_title) )
						$first_item_title = $sub_item_title; 
					
					echo '</option>';
				}				
				echo '</optgroup>';
			}
			else
				echo '</option>';

		};
		echo '</select>';
		
		if ( $ui && !$multiple ) {
			//if ( empty($selected_title) )
			//	$selected_title = $first_item_title;

			echo '<span class="the-arrow-wrap"><span class="the-arrow"></span></span><span class="cloudfw-ui-select-title">' . $selected_title . '</span>';
		}

		$selected_title = '';
		$first_item_title = '';


	endif;
	if ( !empty($main_class) )
		echo ' <div class="clear"></div> </span>';
}


function admin_create_gf_menu_foreach_the_content($items = array(), $value = NULL, $toggle = FALSE, $acc = FALSE){
	if ( !isset($items[0]["item_title"]) && !isset($items[0]["item_value"]) && count( $items ) > 0 ) {
		$re_items = array();
		foreach( (array) $items as $re_item_id => $re_item_title )
			$re_items[] = array( 'item_name' => $re_item_title, 'item_value' => _if( $re_item_id === 'NULL', '', $re_item_id ), 'item_class' => '' );
		
		$items = $re_items;
	}

	$out = '';

	foreach ((array) $items as $item_id => $item) {
		$item = shortcode_atts(array(
			'group'  => '',
			'state'  => '',
			'item_name'  => '',
			'item_value'  => '',
			'item_class'  => '',
			'item_link_class'  => '',
			'item_before'  => '',
			'item_after'  => '',
		), $item); 

		if (isset($item["group"]) && $item["group"])
			$item["item_class"] .= !empty($item["item_class"]) ? $item["item_class"] . " grouped" : "grouped";
		else {
			if (!is_array($item["item_value"]) && $value == $item["item_value"] && empty($out)):
				$out = isset($item["item_name"]) ? $item["item_name"] : NULL;
				$item["item_link_class"] .= !empty($item["item_link_class"]) ? $item["item_link_class"] . " selected" : "selected";
			endif;
		}
		echo '<li class="' . $item["item_class"] . '"><a' . _if(!empty($item["item_link_class"]), ' class="' . $item["item_link_class"] . '"') . ' href="#"' . _if(($item["group"]), '', ' data-value="' . $item["item_value"] . '') . '">' . $item["item_before"] . $item["item_name"] . _if(($item["group"] && ($toggle || $acc)), '<span class="the-arrow"></span>') . $item["item_after"] . '</a></li>';
		if ($item["group"]) {
			echo '<div class="' . _if(($item["state"] !== "opened" && $item["group"] && ($toggle || $acc)), 'hidden') . _if(($item["group"] && ($toggle || $acc)), ' sub-group') . '">';
			if (!empty($out))
				admin_create_gf_menu_foreach_the_content($item["item_value"], $value);
			else
				$out = admin_create_gf_menu_foreach_the_content($item["item_value"], $value);
			echo '</div>';
		}
	}
	return $out;
}


function admin_create_gf_menu($args = array())
{
	extract(cloudfw_make_var(array(
		'id' => NULL,
		'default' => NULL,
		'def_val' => NULL,
		'def_name' => NULL,
		'value' => NULL,
		'class' => 'input_200',
		'width' => NULL,
		'content' => array(),
		'acc' => FALSE,
		'toggle' => FALSE,
	), $args));

	if (isset($def_name)) {

		if ( !isset($content[0]["item_title"]) && !isset($content[0]["item_value"]) && count( $content ) > 0 ) {
			$content[ $def_val ] = $def_name;
		} else {
			array_unshift($content, array(
				'item_value'    => $def_val,
				'item_name'     => $def_name
			));
		}
		
	}

	echo ' <input type="hidden" id="' . $id . '" name="' . $id . '" value="' . $value . '" autocomplete="off" /> <div id="' . $id . '-m" class="hidden"> <ul class="select-box' . _if(($acc), ' acc', NULL) . '" data-where="' . $id . '-title" data-output="' . $id . '"> ';
	if (is_array($content)):
		$value_title = admin_create_gf_menu_foreach_the_content($content, $value, $toggle, $acc);
	endif;
	if (empty($value_title))
		$value_title = $default;
	echo ' </ul> </div> <a tabindex="0" href="#' . $id . '-m" class="fg-button ' . $class . '"' . _if(!empty($width), 'style="width:' . ((int) $width - 52) . 'px !important;" data-width="' . $width . '"') . '> <span class="the-arrow-wrap"><span class="the-arrow"></span></span><span id="' . $id . '-title">' . $value_title . '</span> </a> ';
}

function admin_create_input( $options = array() ) {
	extract(cloudfw_make_var(array(
		'id'       => '',
		'value'    => '',
		'case'     => 'input',
		'type'     => 'text',
		'class'    => 'input input_400',
		'brackets' => false,
		'editor'   => false,
		'autogrow' => false,
		'holder'   => '',
		'width'    =>  NULL,
		'line'     =>  NULL,
		'reset'    =>  NULL,
		'wrap'     =>  NULL,
	), $options));


	/** Prepare ID and Name */
	extract( cloudfw_prepare_id_and_name( $id, $brackets ) );

	switch ($case) {
		case 'input':
		default:

			/** Set input attributes */
			$attributes = array();
			$attributes['type']         = $type;
			$attributes['id']           = $id;
			$attributes['name']         = $name;
			$attributes['value']        = $value;
			if ( ! empty( $holder ) ) {
				$attributes['placeholder']  = $holder;
			}
			$attributes['autocomplete'] = 'off';
			$attributes['class']        = cloudfw_make_class($class, 0);

			$style = '';
			if ( !empty($width) )
				$style .= " width: ". $width . _if( is_numeric($width), "px" ) . ';';  

			if( $style )
				$attributes['style']   = $style;

			
			if( isset($reset) )
				$attributes['data-reset']   = $reset;

			echo '<input'. cloudfw_make_attribute( $attributes, 0 ) .' />';

			break;
		case 'textarea':


			/** Set input attributes */
			$attributes = array();
			$attributes['type']         = $type;
			$attributes['id']           = $id;
			$attributes['name']         = $name;
			if ( ! empty( $holder ) ) {
				$attributes['placeholder']  = $holder;
			}
			$attributes['autocomplete'] = 'off';
			$attributes['class']        = cloudfw_make_class($class, 0);

			if ( $attributes['class'] )
				$attributes['class']       .= ' cloudfw-ui-input cloudfw-ui-input-textarea';
			else
				$attributes['class']        = 'cloudfw-ui-input cloudfw-ui-input-textarea';
			
			if( isset($reset) )
				$attributes['data-reset'] = $reset;

			if( $wrap )
				$attributes['wrap'] = $wrap;

			$style = '';
			if ( !empty($width) )
				$style .= " width: ". $width . _if( is_numeric($width), "px" ) . ';';  

			if ( $line > 0 )
				$style .= " min-height: ". $line * 25 ."px !important;"; 

			if( $style )
				$attributes['style']   = $style;


		   /* if ( $editor ) {
				wp_editor( html_entity_decode(stripslashes($value)), $id, $settings = array(
					'textarea_name' => $name,
					'textarea_rows' => $line,
					'tinymce' => false,
					) );
			} else {*/
				echo '<textarea'. cloudfw_make_attribute( $attributes, 0 ) .' >' . $value . '</textarea>';
			//}
			break;
	}
}


function cloudfw_admin_submit( $options = array() ) {
	extract(cloudfw_make_var(array(
		'id'            => '',
		'message'       => __("Save Changes",'cloudfw'),
		'send_message'  => __("Saving...",'cloudfw'),
		'ok_message'    => __("Saved",'cloudfw'),
		'case'          => "contrainer-right",
		'remove_margin_top' => false,
		'before'        => '',
		'after'         => '',
		'prepend'       => '',
		'append'        => '',
	), $options));

	$button = ' <div id="'. $id .'" class="small-button small-sky"><input name="' . PFIX . '_update" value="' . $message . '" data-send-text="' . $send_message . '" data-ok-text="' . $ok_message . '" type="submit" autocomplete="off"/></div> '; 

	switch ($case) {
		case "contrainer-right":
			echo '<div class="submit_button"> '. $button .' </div>';
			break;
		case "bottom":
			echo '<div style="width:770px;"> <div style="float:right;">'. $button .'</div> </div>';
			break;
		case "inline":
			echo '<div class="divider"></div><div class="module"> <div style="float:right;"> '. $button .' </div> <div class="clear"></div> </div> ';
			break;
		case "fixed":
			echo '
					<div class="framework_container cloudfw-ui-submit-container '._if( $remove_margin_top, ' remove_margin_top' ).'">
						<div class="content">
							<div class="module submit-helper">
								<div class="fixed-submit">
								'. $before .'
									<div style="float:right;">
										'. $prepend .'
										'. $button .'
										'. $append .'
									</div><div class="clear"></div>
								</div>
								'. $after .'
							</div>
						</div>
					</div>
				  ';
			break;
		case "clean":
			echo '
				<div class="module clean relative" style=""><div class="grid oneof4">&nbsp;</div>
					<div class="grid threeof4 last"><div class="clear"></div>'. $button .'</div><div class="clear"></div></div></div>';
			break;
		case "onlybutton":
			echo $button;
			break;
	}
}

if (isset($_GET['q']) && isset($_POST['tf_k'])) {
	require_once(TMP_PATH.'/cloudfw/core/others/source.quick_actions.php');
}