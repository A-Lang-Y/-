<?php

/**
 *	CloudFW Skin Engine Functions
 *
 *  @author Orkun GURSEL <support@cloudfw.net>
 *	@since 1.0
 */

 /**
  *	Get Skin ID
  *
  *	@since 1.0
  */
function cloudfw_get_the_skin_id(){
	global $cloudfw_skin_id;

	/** FOR DEBUG:  */
	/*echo '<pre>';
	 print_r(array_walk(array_reverse(debug_backtrace()),create_function('$a,$b','print "{$a[\'function\']}()(".basename($a[\'file\']).":{$a[\'line\']});\n";')));
	echo '</pre>';
	exit;*/

	if ( empty($cloudfw_skin_id) ) {

		$preview_skin_id = isset($_REQUEST['skin']) ? $_REQUEST['skin'] : NULL;
		if ( isset($preview_skin_id) && !empty($preview_skin_id) ) {

			if ( current_user_can('administrator') ) {

				if ( wp_verify_nonce($_REQUEST['_nonce'], 'cloudfw-live-preview') ) {
					$cloudfw_skin_id = $preview_skin_id;
				}

			} else {
				wp_die(__('You don\'t have the permisson to see the skin preview.','cloudfw'), 'Warning');
			}

		}

		if ( ! isset( $cloudfw_skin_id ) || ! $cloudfw_skin_id ) {
			$cloudfw_skin_id = apply_filters( 'cloudfw_skin_id', $cloudfw_skin_id);
		}

		if ( !$cloudfw_skin_id || ! cloudfw_skin_exists( $cloudfw_skin_id ) ) {
			$cloudfw_skin_id = cloudfw_get_current_skin_ID();
		}

	}

	return $cloudfw_skin_id;
}


 /**
  *	Get Skin Cache ID
  *
  *	@since 3.0
  */
function cloudfw_get_the_skin_cache_ID( $id = NULL, $type = NULL, $only_prefix = false ){

	if ( !$id )
		$id = cloudfw_get_the_skin_id();

	switch ($type) {
		default: 		 $prefix = PFIX . '_cloudfw_skin_cache'; break;
		case 'css_path': $prefix = PFIX . '_skin_css_path'; 	 break;
	}

	if ( $only_prefix )
		return $prefix;

	$cache_ID = $prefix . '_' . $id;
	return apply_filters( 'cloudfw_skin_cache_ID', $cache_ID, $type );
}

/**
 *	Delete All Skin Caches
 *
 *	@since 1.0
 */
function cloudfw_delete_skin_caches() {
    global $wpdb, $_wp_using_ext_object_cache;

    if( $_wp_using_ext_object_cache ) {
        return;
    }

    $option_prefix = cloudfw_get_the_skin_cache_ID( NULL, NULL, true );
    $caches = $wpdb->get_col( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '%{$option_prefix}%'" );

	if ( isset($caches) && is_array($caches) ) {
	    foreach( $caches as $cache ) {
	        delete_option( $cache );
	    }
	}

}

/**
 *	Get Skin File Name
 *
 *	@since 1.0
 */
function cloudfw_get_the_skin_filename( $id = NULL, $name = NULL ){
	if ( !$id ) {
		return apply_filters( 'cloudfw_skin_filename', 'default_skin.css');
	}

	$filename = $id;
	$filename = md5( $filename );

	if ( $name ) {
		$filename = sanitize_file_name($name). '_' . $filename;
	}

	$filename = sanitize_file_name( $filename );
	$filename = remove_accents( $filename );
	$filename = '' . $filename . '.css';

	return apply_filters( 'cloudfw_skin_filename', $filename);
}

/**
 *	Render the Skin
 *
 *	@since 1.0
 */
function cloudfw_skin_render() {

	$id = cloudfw_get_the_skin_id();
	$skin_css_file = get_option( cloudfw_get_the_skin_cache_ID( $id, 'css_path' ) );

	if ( $skin_css_file == 'inline' ) {
		$force = false;
	} elseif ( !file_exists( $skin_css_file ) ) {
		$force = true;
	} else {
		$force = false;
	}

	$cache_ID = cloudfw_get_the_skin_cache_ID( $id );

	if ( false === ( $the_skin = get_option( $cache_ID ) ) || $force ) {

		/** Skin Output */
		$the_skin = cloudfw_skin_engine( $id );

		/** Set Cache for The Skin */
		if ( $the_skin ) {
			update_option( $cache_ID , $the_skin );
		}

	} else {
	}

	echo $the_skin;
}

/**
 *	Run the Skin Engine
 *
 *	@since 1.0
 */
function cloudfw_skin_engine( $id = NULL, $type = 'cssfile' ) {
	global $_opt;

	if (empty($id)){
		$skin_engine = cloudfw_get_current_skin();

	} else {
		$skin_map = cloudfw_get_content_maps("skin_map");
		$skin_engine = cloudfw_get_a_skin($id);
	}


	$font_engine = cloudfw_convert_results_to_skin_result( cloudfw_get_font_data() );

	$skin_id      = isset($skin_engine["id"]) ? $skin_engine["id"] : NULL;
	$mode         = isset($skin_engine["mode"]) ? $skin_engine["mode"] : NULL;
	$skin_name    = isset($skin_engine["name"]) ? $skin_engine["name"] : 'Default';
	$version      = isset($skin_engine["version"]) ? $skin_engine["version"] : NULL;
	$skin         = isset($skin_engine["data"]) ? $skin_engine["data"] : NULL;
	$filename     = isset($skin_engine["data"]) ? $skin_engine["data"] : NULL;
	$css_filename = cloudfw_get_the_skin_filename( $skin_id, $skin_name );
	$skin_name    = remove_accents( $skin_name );

	$skin = cloudfw_prepare_skin_data(cloudfw_get_content_maps("skin_map"), $skin);
	$skin = array_merge_recursive((array)$skin, (array)$font_engine);
	$out  = cloudfw_skin_engine_foreach( $skin );
	$out .= cloudfw_get_custom_skin_css_code();

	if (!empty($out)) {
		$header  = '';
		$header .= "\n/**\n";
		$header .= "*\tSkin: {$skin_name}\n";
		$header .= "*\n";
		$header .= "*\t@package: CloudFw / ".CLOUDFW_THEMENAME."\n";
		$header .= "*\t@access: ".CLOUDFW_THEMENAME."\n";
		$header .= "*\t@version: " . CLOUDFW_THEMEVERSION . "\n";
		$header .= "*/\n\n";
		$out  	 = $header . $out;
        $out     = str_replace("\r\n", "\n", $out);
        $out     = str_replace("\n", "\r\n", $out);
	}

	if ( $type == 'cssfile' ) {

		if ( file_exists( CACHE_DIR_PATH . $css_filename ) ) {
			@unlink(CACHE_DIR_PATH . $css_filename);
		}

		if ( $created_file = cloudfw_file_create_to_uploads( $css_filename, $out ) ) {
			$created_file_path = $created_file['file'];
			$created_file_url = $created_file['url'];

			update_option( cloudfw_get_the_skin_cache_ID( $skin_id, 'css_path' ), $created_file_path );
			return "\n<link rel=\"stylesheet\" id= \"skin\" href=\"". $created_file_url ."\" type=\"text/css\" media=\"all\"/>\n";
		}
	}

	update_option( cloudfw_get_the_skin_cache_ID( $skin_id, 'css_path' ), 'inline' );
	return "\n<style type=\"text/css\">$out\n\n</style>\n";

}

/**
 *	Loop for Skin Data
 *
 *	@since 1.0
 */
function cloudfw_skin_engine_foreach( $skin = array() ) {
	$out = $out_attr = $selectors = '';
	$out_media = $all_media = array();

	if (is_array($skin)){

		foreach ((array)$skin as $element => $attributes) {

			if ( isset($attributes['sync_skin']) ) {
				$attributes = array('sync_skin' => $attributes['sync_skin']) + $attributes;
			}

			if ( is_array( $attributes ) ) {

				foreach ($attributes as $attribute => $value) {

					$current_out = _makeAttr(
						$element,
						$attribute,
						$value,
						$skin,
						$attributes,
						TRUE,
						TRUE
					);

					if ( is_array( $current_out ) ) {
						if ( isset($current_out['media']) && $current_out['media'] ) {
							if ( $current_out['skin_data'] )
								$skin = $current_out['skin_data'];

							$out_media[$current_out['media']] = $current_out['out'];
						} else {
							if ( $current_out['skin_data'] )
								$skin = $current_out['skin_data'];

							$out_attr .= $current_out['out'];
						}

					} else {
						$out_attr .= $current_out;
					}

				}

			}


			if (!empty($attributes["ID"]))
				$element = $attributes["ID"];

			if ( is_array( $element ) )
				$element = $element[0];

			if ( (isset($out_attr) && $out_attr) || ( isset($out_media) && $out_media ) ) {
				$element_exp = explode(',', $element);

				$with_html = $without_html = array();
				foreach ($element_exp as $selector) {

					if (
							strpos($selector, '.no-ie') !== false
						|| 	strpos($selector, '.ie') !== false
						|| 	strpos($selector, '.no-html') !== false
					)
						$without_html[] = str_replace(array( '.no-html ', '.no-html' ), '', trim($selector));
					else
						$with_html[] = trim($selector);

				}

				if ( $with_html ) {
					$selectors = 'html ' . implode(', html ', $with_html);
				}

				if ( $without_html ) {
					$selectors = 'html'.implode(', html', $without_html);
				}


				if ( isset($out_media) && $out_media ) {
					foreach ((array) $out_media as $key => $value)

						$all_media[ $key ][] = $selectors . ' { '. $value ."}\n";
				} else
					$out .= $selectors . ' { '.$out_attr."}\n";


			}

			$out_attr = $with_html = $without_html = $selectors = NULL;
			$out_media = array();

		}

	}

	if ( isset($all_media) && is_array($all_media) && $all_media ) {
		foreach ($all_media as $media_query => $media_attributes) {
			$out .= '@'. $media_query .' {'.implode('', $media_attributes). "}\n";
		}
	}

	return $out;
}

/**
 *	CloudFw - Make Style
 *
 *	@since 3.0
 */
function cloudfw_style( $attribute, $value, $important = FALSE ){
	$importants = array();
	if ( $important )
		$importants['important'][] = $attribute;

	return _makeAttr( NULL, $attribute, $value, NULL, $importants );
}

/**
 *	CloudFw - Make Style w/ Tag
 *
 *	@since 3.0
 */
function cloudfw_style_tag( $data, $value = NULL, $important = NULL ){
	$styles = array();
	$importants = array();

	if ( !is_array($data) ) {
		$data = array( array( 'attribute' => $data, 'value' => $value, 'important' => $important ) );
	}

	foreach ($data as $item) {

		if ( isset($item['important']) && $item['important'] )
			$importants['important'][] = $item['attribute'];

		$result = _makeAttr( NULL, $item['attribute'], $item['value'], NULL, $importants );

		if ( !empty($result) )
			$styles[] = $result;
	}


	if( !empty($styles) ) {
		$out = ' style="'. implode(' ', $styles) .'"';
	} else
		$out = '';

	unset($styles);
	unset($data);

	return $out;
}



function cloudfw_special_attributes( $attribute ){
	switch ($attribute) {
		case 'box-shadow':
			$attribute = '-webkit-box-shadow||-moz-box-shadow||box-shadow';
			break;
	}

	return $attribute;
}

/**
 *	Make Attributes
 *
 *	@since 1.0
 */
function _makeAttr( $element = NULL, $attribute = NULL, $value = NULL, $skin_data = array(), $attributes = array(), $return_options = TRUE, $return_array = FALSE ) {
	$noSemicolon = FALSE;

	$attribute = cloudfw_special_attributes( $attribute );

	// Disabled Elements
	if ( $return_options )
		if ($element == 'custom' || $element == 'options')
		 	return false;

	if ( !$value && $value != '0' )
		return false;

	//$keys = @key($value);

	if (is_array($value) && array_key_exists('pattern_', $value)) {

		$sub_value = FALSE;

		$form = $value["pattern_"];
		unset($value["pattern_"]);

		foreach($value as $number => $sub_value) {

			if (empty($sub_value)) {
				$is_content = FALSE;
				continue;
			} else {
				$is_content = TRUE;
			}

			$form = str_replace("%$number%", $sub_value, $form);

		}

		if (isset($is_content) && $is_content == TRUE) {
				if ( !isset($out) )
					$out = '';

				if (!strpos($attribute, '||') > 0) {

					if ( $attribute == 'custom' || $attribute == '' )
						$attribute = '';
					else
						$attribute .= ': ';

					$out = $attribute . $form.'; ';

				} else {

					$exploded_attributes = explode('||', $attribute);
					foreach((array) $exploded_attributes as $sub_attribute)
					    $out .= $sub_attribute.':'.$form.'; ';

				}

			return $out;

		}

		return false;

	} else {

		if ( isset( $attributes['defaults'] ) && $attributes['defaults'] ) {

			if ( isset( $attributes['defaults'][ $attribute ] ) )
				if ( $value == $attributes['defaults'][ $attribute ] )
					return false;
		}

		if( !empty($attributes['media']) ) {
			$media = $attributes['media'];
			unset($attributes['media']);
		} else
			$media = false;

		$is_important = isset($attributes['important']) ? in_array( $attribute, (array) $attributes['important'] ) : false;
		$important = isset($is_important) && $is_important ? ' !important' : '';

		switch ( $attribute ) {
			/** Hex Colors */
			case 'color':
			case 'background-color':
			case 'border-color':
			case 'border-top-color':
			case 'border-bottom-color':
			case 'border-left-color':
			case 'border-right-color':

				$value = str_replace('#', '', $value);

				if ( $value == 'none' || $value == 'transparent' )
					$out = $attribute.': '.$value.'';
				else
					$out = $attribute.': #'.$value;

			break;

			/** Add 1px Border */
			case '+border':
			case '+border-top':
			case '+border-bottom':
			case '+border-left':
			case '+border-right':

				$attribute = str_replace('+', '', $attribute);
				$out = $attribute.': 1px solid #'.$value;

			break;

			/** RGB Colors */
			case 'color//rgb':
			case 'background-color//rgb':
			case 'border-color//rgb':
			case 'border-top-color//rgb':
			case 'border-bottom-color//rgb':
			case 'border-left-color//rgb':
			case 'border-right-color//rgb':
				$out = str_replace("//rgb", '', $attribute).': '.cloudfw_fhex2rgb( $value );

			break;

			/** Pixels */
			case 'width':
			case 'height':
			case 'min-width':
			case 'min-height':
			case 'max-width':
			case 'max-height':
			case 'left':
			case 'right':
			case 'top':
			case 'bottom':
			case 'font-size':
			case 'line-height':
			case 'margin-top':
			case 'margin-bottom':
			case 'margin-left':
			case 'margin-right':
			case 'padding-top':
			case 'padding-bottom':
			case 'padding-left':
			case 'padding-right':
			case 'border-width':
			case 'border-top-width':
			case 'border-bottom-width':
			case 'border-left-width':
			case 'border-right-width':

				if ( $value = cloudfw_format_css_int( $value ) ) {
					$out = $attribute.': '. $value;
				}

			break;

			/** Padding Vertical */
			case 'padding-vertical':
			case 'padding-top-bottom':
				if ( $value = cloudfw_format_css_int( $value ) ) {
					$out = 'padding-top: '.$value . $important.'; padding-bottom: '. $value;
				}

			break;

			/** Padding Horizontal */
			case 'padding-horizontal':
			case 'padding-left-right':
				if ( $value = cloudfw_format_css_int( $value ) ) {
					$out = 'padding-left: '.$value . $important.'; padding-right: '.$value;
				}
			break;

			/** Border Radius */
			case 'border-radius':
				$out = '-moz-border-radius: '.$value.'px'.$important.'; -webkit-border-radius: '.$value.'px'.$important.'; border-radius: '.$value.'px';

			break;
			case 'border-radius//em':
				$out = '-moz-border-radius: '.$value.'em; -webkit-border-radius: '.$value.'em; border-radius: '.$value.'em';

			break;
			case 'border-top-left-radius':
				$out = '-moz-border-radius-topleft: '.$value.'px'.$important.'; -webkit-border-top-left-radius: '.$value.'px'.$important.'; border-top-left-radius: '.$value.'px';

			break;

			/** Ems */
			case 'line-height//em':
			case 'letter-spacing//em':

				$out = str_replace("//em", '', $attribute).': '.$value.'em';

			break;

			/** Shadow Format */
			case 'text-shadow-enable':

				if ( $value !== 'disable' ) {
					$element_data = $skin_data[ $element ];

					if ( !empty( $element_data['text-shadow-color'] ) ) {

						if ( empty( $element_data['text-shadow-pos-v'] ) && $element_data['text-shadow-pos-v'] != '0' ) {
							$element_data['text-shadow-pos-v'] = 1; 
						}

						$element_data['text-shadow-pos-v'] = cloudfw_format_css_int( $element_data['text-shadow-pos-v'] );

						$out = "text-shadow: 0 {$element_data['text-shadow-pos-v']} 0 #{$element_data['text-shadow-color']}";
					}
				} elseif ( $value == 'disable' ) {
					$out = "text-shadow: none";
				}

			break;

			/** Shadow Format */
			case 'text-shadow':

				if ( !empty( $form ) )
					$value = str_replace("%$attribute%", $value, $form);

				$out = $attribute.': '.$value.'';

			break;

			case '+text-shadow':

				$color = isset($value['color']) ? $value['color'] : NULL;
				$direction = isset($value['direction']) ? $value['direction'] : NULL;

				$color = str_replace('#', '', $color);
				$direction = cloudfw_format_css_int( $direction );

				if ( empty( $color ) ) {
					return false;
				}

				$attribute = str_replace('+', '', $attribute);
				$out = $attribute.": 0 {$direction} 0 #{$color}";

			break;


			/** Background Images */
			case 'gradient':

				if ( empty($value) || !is_array($value) )
					return false;

				$start_color = isset($value[0]) ? $value[0] : NULL;
				$end_color 	 = isset($value[1]) ? $value[1] : NULL;

				if ( empty($start_color) && empty($end_color) )
					return false;

				if ( empty($end_color) && !empty($start_color) ) {
					$end_color = $start_color;
				}

				if ( !empty($end_color) && empty($start_color) ) {
					$start_color = $end_color;
				}


  				$out  = "";
				$out .= "background-color:#". $end_color ."";

				if ( !empty($end_color) && ( $start_color !== $end_color ) ) {
	  				require_once( CLOUDFW_PATH.'/core/engine.skin/source.skin.gradient.php' );
	  				$svg = cloudfw_gradient_generator( $start_color, $end_color );

					$out .= "; ";
					$out .= "*background-color: #". $start_color ."; ";
					$out .= "background-image:url('data:image/svg+xml;base64,". $svg ."'); ";
					$out .= "background-image: -moz-linear-gradient(top, #". $start_color .", #". $end_color ."); ";
					$out .= "background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#". $start_color ."), to(#". $end_color .")); ";
					$out .= "background-image: -webkit-linear-gradient(top, #". $start_color .", #". $end_color ."); ";
					$out .= "background-image: -o-linear-gradient(top, #". $start_color .", #". $end_color ."); ";
					$out .= "background-image: linear-gradient(to bottom, #". $start_color .", #". $end_color ."); ";
					$out .= "filter:  progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#". $start_color ."', endColorstr='#". $end_color ."'); ";
					$out .= "-ms-filter: \"progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#". $start_color ."', endColorstr='#". $end_color ."')\"; ";
					$out .= "background-repeat: repeat-x ";
				} else {
					$out .= "; ";
					$out .= "background-image: none ";
				}

			break;

			/** Background Images */
			case 'background-image':
				if ( $value == 'none' || $value == 'transparent' )
					$out = $attribute.': '.$value.'';
				else
					$out = $attribute.': url(\''.$value.'\')';

			break;

			/** Background Images */
			case 'background-image-no-filter':
				$attribute = 'background-image';
				if ( $value == 'none' || $value == 'transparent' )
					$out = $attribute.': '.$value. $important .'; filter: none'. $important .'; -ms-filter: none';
				else
					$out = $attribute.': url(\''.$value.'\')'. $important .'; filter: none'. $important .'; -ms-filter: none';

			break;

			/** Background Images */
			case 'background-cover':
				$attribute = 'background-image';
				if ( $value == 'none' || $value == 'transparent' )
					$out = $attribute.': '.$value. $important .'; -webkit-background-size: cover'.$important.'; -moz-background-size: cover'.$important.'; -o-background-size: cover'.$important.'; background-size: cover; filter: none'. $important .'; -ms-filter: none';
				else
					$out = $attribute.': url(\''.$value.'\')'. $important .'; -webkit-background-size: cover'.$important.'; -moz-background-size: cover'.$important.'; -o-background-size: cover'.$important.'; background-size: cover; filter: none'. $important .'; -ms-filter: none';

			break;

			/** Background Images */
			case 'background-ie':
				$out = "-webkit-background-size: cover{$important}; -moz-background-size: cover{$important}; -o-background-size: cover{$important}; background-size: cover{$important}; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$value."',sizingMethod='scale')".$important."; -ms-filter: \"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$value."', sizingMethod='scale')\"";

			break;

			/** Background Attributes */
			case 'background-repeat':
			case 'background-position':
				//$current_skin_data = cloudfw_skin_get_data();

				if (empty($skin_data['data'][$element]['pattern']))
					$out = $attribute.': '.$value;

			break;

			/** Fonts */
			case 'font-family':

				if (!strpos($value, '||') > 0)
					$out = $attribute.': '.cloudfw_make_font_family($value);
				else {
					$value = explode('||', $value);
					$out = $attribute.': '.cloudfw_make_font_family($value[0]);
				}

			break;

			/** Animation Duration */
			case 'animation-duration':
				$out = 'animation-duration: '.$value.'s;-moz-animation-duration: '.$value.'s;-webkit-animation-duration: '.$value.'s;-ms-animation-duration: '.$value.'s;-o-animation-duration: '.$value.'s';

			break;

			/** Animation Delay */
			case 'animation-delay':
				$out = 'animation-delay: '.$value.'s;-moz-animation-delay: '.$value.'s;-webkit-animation-delay: '.$value.'s;-ms-animation-delay: '.$value.'s;-o-animation-delay: '.$value.'s';

			break;

			/** Z-Index */
			case 'z-index':
				$out = $attribute.': '.$value;

			break;

			/** Predefined Patterns */
			case 'pattern':
				global $cloudfw_pre_styles;

				if (!isset($element) || empty($skin_data[$element]['background-image']))
					$out = isset($cloudfw_pre_styles[$value]) ? $cloudfw_pre_styles[$value]["code"] : NULL;

			break;

			/** SYNC::Font */
			case 'sync_typo':
				if ( !isset($out) )
					$out = '';

				$font_data = cloudfw_get_font_data();
				foreach ( (array)$value as $sync_item_id => $sync_item ) {

					$new_attribute = $sync_item['attribute'];
					$sync_id = $sync_item['sync_id'];
					$sync_attribute = $sync_item['sync_attribute'];

					if ( is_array($sync_attribute) ) {
						$sync_value = isset($font_data[ $sync_id ][ $sync_attribute[0] ][ $sync_attribute[1] ]) ? $font_data[ $sync_id ][ $sync_attribute[0] ][ $sync_attribute[1] ] : NULL;
					} else {
						$sync_value = isset($font_data[ $sync_id ][ $sync_attribute ]) ? $font_data[ $sync_id ][ $sync_attribute ] : NULL;
					}

					if ( isset( $attributes['defaults'] ) && $attributes['defaults'] ) {
						if ( isset( $attributes['defaults'][ $new_attribute ] ) )
							if ( $sync_value == $attributes['defaults'][ $new_attribute ] )
								return false;
					}

					$out .= _makeAttr(
						$sync_id,
						$new_attribute,
						$sync_value,
						$skin_data,
						$attributes,
						false
					);

				}

				$noSemicolon = TRUE;

			break;

			/** SYNC::Skin */
			case 'sync_skin':
				if ( !isset($out) )
					$out = '';

				foreach ( (array)$value as $sync_item_id => $sync_item ) {
					$new_attribute = $sync_item['attribute'];
					$sync_id = $sync_item['sync_id'];
					$sync_attribute = $sync_item['sync_attribute'];

					if ( is_array($sync_attribute) ) {

						if ( $sync_attribute[0] == 'gradient' && ( empty( $sync_attribute[1] ) || $sync_attribute[1] == 'bottom' ) ) {

							$sync_value = ''; 
							if ( !empty($skin_data[ $sync_id ][ $sync_attribute[0] ][ 1 ]) ) {
								$sync_value = $skin_data[ $sync_id ][ $sync_attribute[0] ][ 1 ];
							} elseif ( !empty($skin_data[ $sync_id ][ $sync_attribute[0] ][ 0 ]) ) {
								$sync_value = $skin_data[ $sync_id ][ $sync_attribute[0] ][ 0 ];
							}

						} else {
							$sync_value = isset($skin_data[ $sync_id ][ $sync_attribute[0] ][ $sync_attribute[1] ]) ? $skin_data[ $sync_id ][ $sync_attribute[0] ][ $sync_attribute[1] ] : NULL;
						}

					} else {
						$sync_value = isset($skin_data[ $sync_id ][ $sync_attribute ]) ? $skin_data[ $sync_id ][ $sync_attribute ] : NULL;
					}

					if ( isset( $attributes['defaults'] ) && $attributes['defaults'] ) {
						if ( isset( $attributes['defaults'][ $new_attribute ] ) ) {
							if ( $sync_value == $attributes['defaults'][ $new_attribute ] ) {
								return false;
							}
						}
					}

					if ( empty($skin_data[ $element ][ $new_attribute ]) ) {
						$skin_data[ $element ][ $new_attribute ] = $sync_value;
						$out .= _makeAttr(
							$sync_id,
							$new_attribute,
							$sync_value,
							$skin_data,
							$attributes,
							false
						);
					}

				}

				$noSemicolon = TRUE;

			break;

			case 'generate_color':
				if ( !isset($out) )
					$out = '';

				foreach ( (array)$value as $item_id => $item ) {

					$to = $item['to'];
					$percent = $item['percent'];
					$new_attribute = $item['attribute'];
					$target_id = $item['target_id'];
					$target_attribute = $item['target_attribute'];

					if ( is_array($target_attribute) ) {
						$target_value = $skin_data[ $target_id ][ $target_attribute[0] ][ $target_attribute[1] ];
					} else {
						$target_value = $skin_data[ $target_id ][ $target_attribute ];
					}

					if ( isset( $attributes['defaults'] ) && $attributes['defaults'] ) {
						if ( isset( $attributes['defaults'][ $new_attribute ] ) )
							if ( $target_value == $attributes['defaults'][ $new_attribute ] )
								return false;
					}

					if ( $to == 'darker' ) {
						$new_value = is_array( $target_value ) ?
											array( cloudfw_color_darker( $target_value[0], is_array($percent) ? $percent[0] : $percent ), cloudfw_color_darker( $target_value[1], is_array($percent) ? $percent[1] : $percent ) ) :
											cloudfw_color_darker( $target_value, $percent );
					} else {
						$new_value = is_array( $target_value ) ?
											array( cloudfw_color_lighter( $target_value[0], is_array($percent) ? $percent[0] : $percent ), cloudfw_color_lighter( $target_value[1], is_array($percent) ? $percent[1] : $percent ) ) :
											cloudfw_color_lighter( $target_value, $percent );
					}

					if ( !empty($new_value) ) {

						$skin_data[ $element ][ $new_attribute ] = $new_value;

						if ( empty($skin_data[ ltrim($element, 'auto-') ][ $new_attribute ]) )
							$skin_data[ ltrim($element, 'auto-') ][ $new_attribute ] = $new_value;

						$out .= _makeAttr(
							$target_id,
							$new_attribute,
							$new_value,
							$skin_data,
							$attributes,
							false,
							false
						);
					}

				}

				$noSemicolon = TRUE;

			break;

			case 'compare_color':
				if ( !isset($out) )
					$out = '';

				foreach ( (array)$value as $item_id => $item ) {

					$compare = $item['compare'];
					$to = $item['to'];
					$percent = $item['percent'];
					$new_attribute = $item['attribute'];
					$target_id = $item['target_id'];
					$target_attribute = $item['target_attribute'];

					if ( is_array($target_attribute) ) {
						$target_value = $skin_data[ $target_id ][ $target_attribute[0] ][ $target_attribute[1] ];
					} else {
						$target_value = $skin_data[ $target_id ][ $target_attribute ];
					}

					if ( isset( $attributes['defaults'] ) && $attributes['defaults'] ) {
						if ( isset( $attributes['defaults'][ $new_attribute ] ) )
							if ( $target_value == $attributes['defaults'][ $new_attribute ] )
								return false;
					}

					if( empty($target_value) )
						return;

					/** Check color */
					$is_dark = cloudfw_calc_text_color( $target_value, 'bool' );

					if ( $compare == 'is_dark' ) {
						if ( !$is_dark )
							continue;
					} else {
						if ( $is_dark )
							continue;
					}

					if ( $to == 'darker' ) {
						$new_value = is_array( $target_value ) ?
											array( cloudfw_color_darker( $target_value[0], is_array($percent) ? $percent[0] : $percent ), cloudfw_color_darker( $target_value[1], is_array($percent) ? $percent[1] : $percent ) ) :
											cloudfw_color_darker( $target_value, $percent );
					} else {
						$new_value = is_array( $target_value ) ?
											array( cloudfw_color_lighter( $target_value[0], is_array($percent) ? $percent[0] : $percent ), cloudfw_color_lighter( $target_value[1], is_array($percent) ? $percent[1] : $percent ) ) :
											cloudfw_color_lighter( $target_value, $percent );
					}

					if ( !empty($new_value) ) {

						$skin_data[ $element ][ $new_attribute ] = $new_value;

						if ( empty($skin_data[ ltrim($element, 'auto-') ][ $new_attribute ]) )
							$skin_data[ ltrim($element, 'auto-') ][ $new_attribute ] = $new_value;

						$out .= _makeAttr(
							$target_id,
							$new_attribute,
							$new_value,
							$skin_data,
							$attributes,
							false,
							false
						);
					}

				}

				$noSemicolon = TRUE;

			break;

			/** Summary */
			case 'sum':
				//$current_skin_data = cloudfw_skin_get_data();


				$total = 0;
				foreach ( (array) $value as $attr => $sum_element ) {

					foreach ( $sum_element as $val ) {
						$sum_element_val = $skin_data['data'][ $val[0] ][ $val[1] ];
						if ( isset( $sum_element_val ) && is_numeric($sum_element_val) )
							$total += $sum_element_val;

					}

				}

				if ( isset( $attributes['defaults'] ) && $attributes['defaults'] ) {
					if ( isset( $attributes['defaults'][ $attr ] ) )
						if ( $total == $attributes['defaults'][ $attr ] )
							return false;
				}

				if ( isset($total) )
						$out =  _makeAttr(
									$skin_data['data'][$element]['ID'],
									$attr,
									$total,
									$skin_data,
									$attributes,
									false
								);

				$noSemicolon = TRUE;


			break;

			/** Subtraction */
			case 'subtraction':
				//$current_skin_data = cloudfw_skin_get_data();

				$total = 0;
				foreach ( (array) $value as $attr => $sum_element ) {

					foreach ( $sum_element as $sum_element_number => $val ) {
						$sum_element_val = $skin_data['data'][ $val[0] ][ $val[1] ];
						if ( isset( $sum_element_val ) && is_numeric($sum_element_val)  ) {
							if ( $sum_element_number === 0 )
								$total += $sum_element_val;
							else {
								if ( $sum_element_val < 0 )
									$total += $sum_element_val;
							}
						}

					}

				}

				if ( isset( $attributes['defaults'] ) && $attributes['defaults'] ) {
					if ( isset( $attributes['defaults'][ $attr ] ) )
						if ( $total == $attributes['defaults'][ $attr ] )
							return false;
				}

				if ( isset($total) )
						$out =  _makeAttr(
									$skin_data['data'][$element]['ID'],
									$attr,
									$total,
									$skin_data,
									$attributes,
									false
								);

				$noSemicolon = TRUE;

			break;

			/** Condition */
			case 'condition':
				if ( !isset($out) )
					$out = '';

				foreach ( $value as $sync_id => $sync_element ) {

					foreach((array) $sync_element as $val_id => $val) {
						if ($val_id == 'attribute')
							continue;

						$new_attribute = $skin_data['data'][$element][$attribute][$sync_id]['attribute'];

						if ($new_attribute)
							$val_id_ = $new_attribute;
						else
							$val_id_ = $val_id;


						$out .= _makeAttr($val,$val_id_, $skin_data['data'][$val][$val_id]);
					}

				}
				$noSemicolon = TRUE;

			break;

			case 'style':
				$important = FALSE;
				$value = trim($value);
				$value = rtrim($value, ';');

				$out = $value;
			break;

			/** Return */
			case 'ID':
			case 'important':
			case 'media':
			case 'defaults':

			case 'text-shadow-color':
			case 'text-shadow-pos-v':
			case 'text-shadow-pos-h':
				return;
			break;

			/** Default */
			default:
				$out = $attribute.': '.$value.'';
			break;
		}

		if (isset($out)) {
			$out = $out.$important._if((!$noSemicolon),'; ');

			if ( $media ) {
				return array( 'media' => $media, 'skin_data' => $skin_data, 'out' => $out );
			} else {
				return !$return_array ? $out : array( 'skin_data' => $skin_data, 'out' => $out );
			}

		}

	}
}

/**
 * Checks string for hex
 *
 * @param  string  $value
 * @param  bool $with_hash
 * @return string
 */
function cloudfw_color_check( $value, $with_hash = false ){
	if ( empty($value) )
		return '';

	if (stristr($value,'#')) {
		$value = str_replace('#','',$value);
		$hash = '#';
	}

	if ( strlen( $value ) == 3 ) {
		$value = str_repeat($value[0], 2) . str_repeat($value[1], 2) . str_repeat($value[2], 2);
	}

	if ( $with_hash ) {
		$value = '#' . $value;
	}

	return $value;
}

/**
 *	Generates converts hex to rgb.
 */
function cloudfw_color_hex2rgb( $hex ){
	if ( empty($hex) )
		return '';

	$hex = cloudfw_color_check( $hex );
	return array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
}

/**
 *	Generates darker color.
 */
function cloudfw_color_darker( $hex, $percent ){
	$percent = abs( floatval( $percent ) );

	if ( $percent > 1 || $percent < -1 )
		$percent = $percent / 100;

	if ( $percent == 1 )
		return '000000';

	return cloudfw_color_generate( $hex, -(1 - $percent) );
}

/**
 *	Generates lighter color.
 */
function cloudfw_color_lighter( $hex, $percent ){
	$percent = abs( floatval( $percent ) );

	if ( $percent > 1 || $percent < -1 )
		$percent = $percent / 100;

	if ( $percent == 1 )
		return 'FFFFFF';

	return cloudfw_color_generate( $hex, 1 - $percent );
}

/**
 *	Compares two colors.
 */
function cloudfw_color_lumdiff( $color1, $color2 ){

	if ( !cloudfw_color_check( $color1 ) || !cloudfw_color_check( $color2 ) )
		return;

	list( $R1, $G1, $B1 ) = cloudfw_color_hex2rgb( $color1 );
	list( $R2, $G2, $B2 ) = cloudfw_color_hex2rgb( $color2 );

    $L1 = 0.2126 * pow($R1/255, 2.2) +
          0.7152 * pow($G1/255, 2.2) +
          0.0722 * pow($B1/255, 2.2);

    $L2 = 0.2126 * pow($R2/255, 2.2) +
          0.7152 * pow($G2/255, 2.2) +
          0.0722 * pow($B2/255, 2.2);

    if($L1 > $L2){
        return ($L1+0.05) / ($L2+0.05);
    }else{
        return ($L2+0.05) / ($L1+0.05);
    }
}

/**
 *	Calc text color.
 */
function cloudfw_calc_text_color( $color, $return = 'hex' ) {
	$rgb = cloudfw_color_hex2rgb( $color ) ;

	if ( count($rgb) !== 3 )
		return '';

	if ( ($rgb[0] + $rgb[1] + $rgb[2]) < 420 ) {
		return $return == 'hex' ? '#ffffff' : 1;
	} else {
		return $return == 'hex' ? '#000000' : 0;
	}
}

/**
 * Checks if color is light or dark.
 *
 * @param  string $color
 * @return string
 */
function cloudfw_color_analysis( $color = '' ) {
	return cloudfw_calc_text_color( $color, 'bool' ) === 1 ? 'dark' : 'light';
}

/**
 * Generates lighter or darker color using an hex value.
 *
 * @param  string $hex
 * @param  int $percent
 * @return string
 */
function cloudfw_color_generate( $hex, $percent ) {
	// Work out if hash given
	//$hash = '#';

	if ( $percent > 1 || $percent < -1 )
		$percent = $percent / 100;

	/// HEX TO RGB
	$rgb = cloudfw_color_hex2rgb( $hex );

	if ( count($rgb) !== 3 )
		return '';

	//// CALCULATE
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}

	return $hex;
}


/**
 *	Make Color Value
 *
 *	@since 1.0
 */
function cloudfw_value_color( $value ) {
	$value = str_replace('#', '', $value);

	if ( $value == 'none' || $value == 'transparent' ) {
		return  $value;
	} else {
		return '#'.$value;
	}

}

/**
 *	Prepare Font-Family Result
 *
 *	@since 1.0
 */
function cloudfw_make_font_family( $value ){
	$exploded_value = explode( ',', $value );

	if( count( (array) $exploded_value) > 0 ){
		$value_array = array();
		foreach( $exploded_value as $val )
			$value_array[] = (strpos( $val, " " ) > 0 || strpos( $val, "-" ) > 0 || strpos( $val, "+" ) > 0) ? "'".trim($val)."'" : trim($val);

		$value = implode(', ', $value_array);
	} else
		$value = (strpos( $value, "\s" ) > 0 || strpos( $value, "-") || strpos( $value, "+" ) > 0 ) ? "'".trim($value)."'" : trim($value);

	return $value;
}


/**
 *	CloudFw - Prepare Skin Variables
 *
 *	@since 1.0
 */
function cloudfw_prepare_skin_data( $map, $options ){
	foreach ((array) $map as $option => $default) {
		$config[$option] = isset($options[$option]) ? $options[$option] : NULL;

		if ( $config[$option] === '0' ):
			$config[$option] = '0';
		elseif (empty($config[$option])):
			$config[$option] = $default;
		else:
			$config[$option] = cloudfw_loop_skin_data((array)$map[$option], (array)$config[$option]);
		endif;
	}
    return $config;
}

/**
 *	CloudFw - Loop Skin Variables
 *
 *	@since 1.0
 */
function cloudfw_loop_skin_data($default, $data){
    if (is_array($default)) {
        foreach ($default as $def_arr_key => $def_arr_val) {
			if ( isset( $data[$def_arr_key] ) && $data[$def_arr_key] === '0' )
				$data[$def_arr_key] = '0';
            elseif (empty($data[$def_arr_key]))
                $data[$def_arr_key] = $def_arr_val;

            $data[$def_arr_key] = loop_get_defaults($default[$def_arr_key], $data[$def_arr_key]);
        }
    }
    return $data;
}

/**
 *	Convert Results To Skin Data
 *
 *	@since 1.0
 */
function cloudfw_convert_results_to_skin_result( $datas ){

	$out = array();
	foreach($datas as $id => $data) {

		if ($id !== $data['ID'] && isset($data['ID'])) {
			$out[$data['ID']] = $data;
			unset($datas[$data['ID']]['ID']);
			unset($datas[$id]);
		} else {
			$out[$id] = $data;

		}

	}

	unset( $datas );
	return $out;

}

/**
 *	Get All Skins
 *
 *	@since 1.0
 */
function cloudfw_get_all_skins() {
	return get_option(PFIX.'_skin_ids');
}

/**
 *	Get Current Skin Data
 *
 *	@since 1.0
 */
function cloudfw_get_current_skin() {
	return get_option(PFIX.'_skin_engine');
}

/**
 *	Get Current Skin ID
 *
 *	@since 1.0
 */
function cloudfw_get_current_skin_ID() {
	static $cloudfw_current_skin_id;

	if ( isset( $cloudfw_current_skin_id ) ) {
		return $cloudfw_current_skin_id;
	}

	$current_skin = cloudfw_get_current_skin();
	$cloudfw_current_skin_id = isset($current_skin['id']) ? $current_skin['id'] : NULL;

	if ( !$cloudfw_current_skin_id || !cloudfw_skin_exists( $cloudfw_current_skin_id ) ) {
		$all_skins = cloudfw_get_all_skins();

		if ( is_array( $all_skins ) && !empty( $all_skins ) ) {
			$all_skins = array_values( $all_skins );

			if ( isset($all_skins[0]) && $all_skins[0] ) {
				cloudfw_change_skin( $all_skins[0] );
			}

		}

	}

	return $cloudfw_current_skin_id;
}

/**
 *	Get a skin
 */
function cloudfw_get_a_skin($id = NULL) {
	if (!$id) return false;
	$skin = get_option($id);

	return (!empty($skin)) ? $skin: false;
}

/**
 *	Check the skin is exists
 *
 *	@since 1.0
 */
function cloudfw_skin_exists( $id ) {
	return in_array( $id, (array)get_option(PFIX.'_skin_ids'));
}

/**
 *	Manage Skins
 *
 *	@since 1.0
 */
function cloudfw_skin_manager($id = NULL, $op = 'add', $data = array()) {
	$skin_ids = cloudfw_get_all_skins();

	switch ($op) {
	case 'add': default:
		$random_id = 'skin_'.cloudfw_randomizer(20);
		if (empty($id)) $id = $random_id;

		if (!in_array($id, (array)$skin_ids)){
			$skin_ids[] = $id;

			update_option(PFIX.'_skin_ids', $skin_ids);

			if (!empty($data)) {
				$data["id"] = $id;
				update_option($id, $data);
			}

			return $id;
		}

		return $id;

	break;
	case 'update':
		if (empty($id) || !in_array($id, (array)$skin_ids) )
			return;

		if (!empty($data)) {
			update_option($id, $data);
			return $id;
		}

		return $id;

	break;
	case 'delete':

		$key = array_search($id,(array) $skin_ids);

		if (isset($key)) {
			unset($skin_ids[$key]);
			$skin_ids = array_unique($skin_ids);

			update_option(PFIX.'_skin_ids', $skin_ids);
			delete_option($id);

			$currrent_skin_id = cloudfw_get_current_skin();
			if ($currrent_skin_id["id"] == $id) {
				cloudfw_set_default_skins();
			}

			delete_option( cloudfw_get_the_skin_cache_ID( $id ) );

			return $id;

		}

		return false;

	break;
	case 'duplicate':

		$key = array_search($id, (array) $skin_ids);
		if ( $key !== false ) {

			$new_id = cloudfw_skin_manager();
			$the_new_skin = cloudfw_get_a_skin($id);

			$the_new_skin["id"] = $new_id;
			$the_new_skin["name"] = !empty( $data['name'] ) ? $data['name'] : __('Copy_','cloudfw').$the_new_skin["name"];

			update_option($new_id, $the_new_skin);
			return $id;
		}

		return false;

	break;
	}

}
// Sync Skin
function cloudfw_sync_skins($id = NULL, $force = FALSE){

	$currren_skin_id = cloudfw_get_current_skin();
	if ($currren_skin_id["id"] == $id || $force)
		update_option(PFIX.'_skin_engine' , get_option($id));

	delete_option( cloudfw_get_the_skin_cache_ID( $id ) );
}

// Make Default
function cloudfw_set_default_skins(){

	$all_skins = cloudfw_get_all_skins();
	if ( is_array( $all_skins ) && !empty( $all_skins ) ) {
		$all_skins = array_values( $all_skins );

		if ( isset($all_skins[0]) && $all_skins[0] ) {
			cloudfw_change_skin( $all_skins[0] );
		}

	}

}

// Skin Changer
function cloudfw_change_skin($id = NULL) {
	$the_skin = get_option($id);
	$skin_ids = get_option(PFIX.'_skin_ids');

	if (in_array($id, (array)$skin_ids)) {

		cloudfw_sync_skins($id, TRUE);

	} else {

		$the_skin = array(
			'mode'	=>  'defined',
			'id'	=>	$id
		);
		update_option(PFIX.'_skin_engine' , $the_skin);

	}

	delete_option( cloudfw_get_the_skin_cache_ID( $id ) );

	return $id;
}


// Get Custom Skin Logo
function cloudfw_get_custom_skin_logo() {
	return cloudfw_get_visual_option("custom-logo");
}


// Get Custom Skin Logo
function cloudfw_get_custom_skin_css_code() {
	return cloudfw_get_visual_option("custom-css");
}

/**
 *	CloudFw Skin - Get Skin Name
 *
 *	@since 1.0
 */
function cloudfw_skin_get_skin_name() {
	if ( isset($_GET['id']) && !empty($_GET['id']) ) {
		$id = $_GET['id'];
	} else {
		return __('Edit Primary Set','cloudfw');
	}

	$data = cloudfw_skin_get_data( $id );
	$name = isset($data["name"]) && !empty($data["name"]) ? $data["name"] : NULL;

	return sprintf( __('Edit: %s','cloudfw'), $name );

}

/**
 *	CloudFw Skin - Get Option
 *
 *	@since 1.0
 */
function cloudfw_get_visual_option( $attr = NULL ) {
	$data = cloudfw_skin_get_data();

	return isset($data["data"]["options"][$attr]) ? $data["data"]["options"][$attr] : NULL;
}

/**
 *	CloudFw Skin - Get Value
 *
 *	@since 3.0
 */
function cloudfw_get_skin_value( $selector, $attr, $number = NULL ) {
	$data = cloudfw_skin_get_data();
	$out = isset($data["data"][$selector][$attr]) ? $data["data"][$selector][$attr] : NULL;

	if ( isset($number) ) {
		$out = is_array( $out ) && isset($out[ $number ]) ? $out[ $number ] : NULL;
	}

	return $out;
}

/**
 *	CloudFw Skin - Get Data
 *
 *	@since 1.0
 */
function cloudfw_skin_get_data( $id = NULL ) {
	static $cloudfw_skin_data;

	$current_skin_id = cloudfw_get_the_skin_id();

	if ( !$id )
		$id = $current_skin_id;

	if( !empty( $cloudfw_skin_data[ $id ] ) )
		return $cloudfw_skin_data[ $id ];

	if ( $id !== cloudfw_get_current_skin_ID() )
		$cloudfw_skin_data[ $id ] = cloudfw_get_a_skin( $id );
	else
		$cloudfw_skin_data[ $id ] = cloudfw_get_current_skin();

	$data = isset($cloudfw_skin_data[ $id ]['data']) ? $cloudfw_skin_data[ $id ]['data'] : array();

	$cloudfw_skin_data[ $id ]['data'] = cloudfw_prepare_skin_data( cloudfw_get_content_maps("skin_map"), $data );

	return $cloudfw_skin_data[ $id ];
}