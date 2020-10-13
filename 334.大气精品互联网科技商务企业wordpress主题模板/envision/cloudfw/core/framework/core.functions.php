<?php

/**
 *	CloudFw - Debugger
 *
 *	@since 3.0
 */
if (function_exists('__debug')) {
	function __debug( $message ){
		global $cloudfw_debug;
		$cloudfw_debug[] = $message;
	}
}

/**
 *	Get Page
 *
 *	@since 1.0
 */
function cloudfw( $var = NULL ){
	static $cloudfw_page_generator;

	if ( ! $cloudfw_page_generator ) {

		if ( !class_exists( 'CloudFw_Page_Generator' ) ){
			echo cloudfw_error_message( sprintf( __('%s class is not exists','cloudfw'), '(Class) CloudFw_Page_Generator') );
			return false;
		}

		/** Call CloudFw Page Generator */
		$cloudfw_page_generator = new CloudFw_Page_Generator;

	}

	if ( empty($var) )
		return $cloudfw_page_generator;

	if ( !method_exists( $cloudfw_page_generator, $var) ) {
		echo cloudfw_error_message( sprintf( __('%s -> %s method is not exists','cloudfw'), '(Class) CloudFw_Page_Generator', $var ) );
		return false;
	}

	/** Get all Arguments */
	$args = array_slice( func_get_args(), 1 );

	/** Call a Function */
	return call_user_func_array( array( &$cloudfw_page_generator, $var ), $args );
}

/**
 *	CloudFw Auto Loader
 *
 *	@since 1.0
 */
function cloudfw_autoload( $folder, $filter = '*.php' ) {
	if ( !is_dir( $folder ) )
		return false;

	$is_admin = is_admin();

	$load_after = array();
	foreach( (array) glob( $folder . "/" . $filter, GLOB_NOSORT ) as $file ){
		$filename = basename( $file );

		if ( strpos($filename, '.admin.php') !== false ) {
			if ( $is_admin )
				$load_after[] = $file;
			continue;

		} elseif ( strpos($filename, '.frontend.php') !== false ) {
			if ( !$is_admin )
				$load_after[] = $file;
			continue;

		} elseif ( strpos($filename, '.scheme.php') !== false ) {
			continue;
		}

		if ( is_readable($file) )
			include_once( $file );
	}

	if ( !empty($load_after) ) {
		foreach ($load_after as $file)
			if ( is_readable($file) )
				include_once( $file );
	}

	unset($load_after);

}

/**
 *	CloudFw Auto Loader
 *
 *	@since 1.0
 */
function cloudfw_autoload_folders( $folder, $one = FALSE, $extension = '*.php' ) {
	if ( !is_dir( $folder ) )
		return false;

	foreach (array_filter((array) glob($folder.'/*'), 'is_dir') as $dir) {
		if ( $one === false ) {
			cloudfw_autoload( $dir, $extension );
		} else {
			$dirname = basename( $dir );
			$filepath = $dir . "/" . $dirname . ".php";

			if ( file_exists($filepath) ) {
				include_once( $filepath );
			}
		}
	}

}

/**
 *	Get Page
 *
 *	@since 1.0
 */
function cloudfw_module( $class, $method = NULL ){
	static $cloudfw_page_generator_module;

	if ( !isset($cloudfw_page_generator_module[ $class ]) || !$cloudfw_page_generator_module[ $class ] ) {

		if ( !class_exists( $class ) ){
			echo cloudfw_error_message( sprintf( __('%s not exists','cloudfw'), "(Class) $class") );
			return false;
		}

		/** Call CloudFw Page Generator */
		$cloudfw_page_generator_module[ $class ] = new $class;

		if ( !$method )
			return $cloudfw_page_generator_module[ $class ];

	}

	if ( $method ) {

		if ( !method_exists( $cloudfw_page_generator_module[ $class ], $method) ) {
			echo cloudfw_error_message( sprintf( __('%s->%s function not exists','cloudfw'), "(Class) $class", $method ) );
			return false;
		}

	} else {
		return $cloudfw_page_generator_module[ $class ];
	}

	/** Get all Arguments */
	$args = array_slice( func_get_args(), 2 );

	/** Call a Function */
	return call_user_func_array( array( &$cloudfw_page_generator_module[ $class ], $method ), $args );
}

/**
 *	Create form name on the fly
 *
 *	@since 1.0
 */
function cloudfw_sanitize($element = NULL, $attribute = NULL) {
	if (!$element)
		return false;

	$element = str_replace("-", "_", $element);
	$out = preg_replace("#[^A-Za-z0-9_]#", "_", $element);

	if ($attribute) {
		$attribute = str_replace("-", "_", $attribute);
		$attribute = preg_replace("#[^A-Za-z0-9_]#", "_", $attribute);
		$out .='_'.$attribute;
	}

	$out = str_replace("__", "_", $out);
	$out = str_replace("__", "_", $out);
	return $out;
}

/**
 *	Prepares Variables For Extracting
 *
 *	@since 1.0
 */
function cloudfw_make_var($pairs, $atts){
	$atts = (array)$atts;
	$out = array();
	foreach((array)$pairs as $name => $default) {
		if ( array_key_exists($name, $atts) )
			$out[$name] = $atts[$name];
		else
			$out[$name] = $default;
	}
	return $out;
}

/**
 *	Make Pixel Value
 *
 *	@since 1.0
 */
function cloudfw_format_css_int( $value = NULL ){

	$suffix = 'px';
	if ( strstr($value, 'px') ) {
		$suffix = 'px';
		$value = str_replace('px', '', $value);
	} elseif ( strstr($value, '%') ) {
		$suffix = '%';
		$value = str_replace('%', '', $value);
	}

	$value = trim($value);
	$value = str_replace(',', '.', $value);

	if( empty($value) && $value !== 0 && $value !== '0' )
		return;

	$value = (float) $value . $suffix;

	return $value;
}


/**
 *	Match Ratio
 *
 *	@since 1.0
 */
function cloudfw_match_ratio( $value = NULL, $ratio = '16:9', $input = 'x' ){
	if ( (int) $value < 0 ) {
		return false;
	}

	if ( empty($ratio) || $ratio == 'original' ) {
		return false;
	}

	$ratio = explode(':', $ratio);

	if ( $input == 'x' )
		$out = ( (int) $value * (int) $ratio[1] ) / (int) $ratio[0];
	else
		$out = ( (int) $value * (int) $ratio[0] ) / (int) $ratio[1];

	return ceil( $out );
}

/**
 *	Match Ratio in percent
 *
 *	@since 1.0
 */
function cloudfw_match_ratio_percent( $ratio = '16:9' ){
	if ( empty($ratio) || $ratio == 'original' ) {
		return false;
	}

	$cache_id = $ratio;

	if ( cloudfw_vc_isset( __FUNCTION__, $cache_id ) ) {
		return cloudfw_vc_get( __FUNCTION__, $cache_id );
	}

	$ratio = explode(':', $ratio);

	if ( empty($ratio[0]) || empty($ratio[1]) ) {
		return false;
	}

	$ratio_padding = (((int) $ratio[1] / (int) $ratio[0]) * 100);
	$ratio_padding = number_format( $ratio_padding, 2, ',', '');
	$ratio_padding = $ratio_padding . '%';

	return cloudfw_vc_set( __FUNCTION__, $cache_id, $ratio_padding );
}


/**
 *	Make Boolean
 *
 *	@since 1.0
 */
function cloudfw_bool( $value = NULL ){
	return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
}

/**
 * Creates id for widgets
 *
 * @param  string $prefix
 *
 * @return unique id
 */
function cloudfw_id( $prefix = '' ) {
	global $clodfw_ids;
	$prefix = rtrim( $prefix, '-' );

	if ( empty( $prefix ) ) {
		$prefix = 'ui--id';
	}

	if ( !isset( $clodfw_ids[ $prefix ] ) ) {
		$clodfw_ids[ $prefix ] = 0;
	}

	$clodfw_ids[ $prefix ]++;

	return (string) $prefix . '-' . $clodfw_ids[ $prefix ];
}

/**
 *	Prepare ID Attribute
 *
 *	@since 1.0
 */
function cloudfw_make_id( $id = NULL, $echo = false ){
	if ( empty( $id ) )
		return;

	$out =  " id=\"{$id}\"";
	if ( $echo )
		echo $out;

	return $out;
}

/**
 * Make class attribute
 *
 * @param  (string|array) $classes
 * @param  (boolean) $attr
 * @return (string)
 */
function cloudfw_make_class( $classes = NULL, $attr = TRUE ){
	if (!is_array( $classes )) {
		$classes = array($classes);
	}

	$classes = array_unique($classes);
	$classes = array_filter($classes);

	$classes = implode(' ', $classes);

	if (!empty($classes)) {
		return $attr ? " class=\"$classes\"": $classes;
	}

}

/**
 *	Prepare Attributes
 *
 *	@since 1.0
 */
function cloudfw_make_attribute( $attributes = NULL, $echo = TRUE ){
	if ( ! is_array( $attributes ) || ! $attributes )
		return;

	$out = array();
	foreach ($attributes as $attr => $value) {
		if ( $attr == 'class' ) {
			$value = cloudfw_make_class( $value, FALSE );
		} elseif ( in_array( $attr, array( 'width', 'height', 'data-fx', 'data-rel', 'loop' ) ) ) {
			if ( empty( $value ) ) {
				continue;
			}
		}

		$out[] = "{$attr}=\"". esc_attr($value) ."\"";
	}

	if ( !empty( $out ) ) {
		$out = implode(' ', ( array ) $out);
		$out = ' ' . $out;
		if ( $echo )
			echo $out;

		return $out;
	}
}

/**
 *	Creates Style Attribute
 *
 *	@since 1.0
 */
function cloudfw_make_style_attribute( $attributes = NULL, $echo = TRUE, $tag = TRUE ){
	if ( ! is_array( $attributes ) || ! $attributes )
		return;

	$out = array();
	foreach ($attributes as $attr => $value) {
		$importants = array();
		if ( $attr[0] == '!' ) {
			$attr = ltrim($attr, '!');
			$importants = array( 'important' => array( $attr ) );
		}

		if ( $attr == 'style' ) {
			$out[] = $value;
		} else {
			$out[] = _makeAttr( NULL, $attr, $value, array(), $importants);
		}

	}

	if ( !empty( $out ) ) {
		$out = implode(' ', array_filter( $out ));
		$out = trim($out);

		if ( $tag && !empty($out) ) {
			$out = ' style="' . $out . '"';
		}

		if ( $echo ) {
			echo $out;
		}

		return $out;
	}
}

/**
 * Makes style attribute if the datas ain't empty.
 *
 * @param  string | array $selector
 * @param  array $attributes
 * @param  boolean $echo
 *
 * @since 3.0
 * @return string
 */
function cloudfw_make_style( $selectors, $attributes, $echo = FALSE ){

	$result = cloudfw_make_style_attribute( $attributes, FALSE, FALSE );

	if ( !empty( $result ) ) {

		if ( is_array( $selectors ) ) {
			$selector = implode(', ', $selectors);
		} else {
			$selector = $selectors;
		}

		$selector = cloudfw_make_css_selector( $selector );
		if ( empty( $selector ) ) {
			return;
		}

		return "{$selector} {{$result}} ";

	}

	return;

}

/**
 *	Prepare Data Attributes
 *
 *	@since 1.0
 */
function cloudfw_make_data_attribute( $attributes = NULL, $echo = TRUE ){
	if ( ! is_array( $attributes ) || ! $attributes )
		return;

	$out = array();
	foreach ($attributes as $attr => $value) {
		$out[] = "data-{$attr}=\"". esc_attr($value) ."\"";
	}

	if ( ! empty( $out ) ) {
		$out = implode(' ', ( array ) $out);
		$out = ' ' . $out;
		if ( $echo )
			echo $out;

		return $out;
	}
}


/**
 * CSS Selector Callback
 *
 * @param  string $match
 * @return string
 */
function cloudfw_make_css_selector_callback( $match ) {
	$holder = '/****/'; 


	$all = isset($match[0]) ? $match[0] : '';
	$vars = isset($match[1]) ? $match[1] : '';

	$cleaned_match = str_replace('('. $vars .')', $holder, $all);

	$out = array(); 
	if ( !empty( $vars ) ) {
		$exploded_vars = explode( '|', $vars );

		foreach ($exploded_vars as $var) {
			$out[] = str_replace($holder, $var, $cleaned_match);
		}
	}

	if ( ! empty( $out ) ) {
		$out = implode(', ', $out);
	} else {
		$out = $all;
	}

	return $out;
}

/**
 * CSS Selector Globals
 * 
 * @param  string $selectors
 * @return string
 */
function cloudfW_css_selector_globals( $selectors = '' ){
	$globals = array(
		'h*'       => 'h1|h2|h3|h4|h5|h6',
		'inputs*'  => 'select|textarea|input[type=text]|input[type=password]|input[type=datetime]|input[type=datetime-local]|input[type=date]|input[type=month]|input[type=time]|input[type=week]|input[type=number]|input[type=email]|input[type=url]|input[type=search]|input[type=tel]|input[type=color]',
	);

	foreach ($globals as $search => $replace) {
		$selectors = str_replace($search, $replace, $selectors);
	}

	return $selectors;
}

/**
 * Makes CSS Selector
 * 
 * @param  string $selectors
 * @return string           
 */
function cloudfw_make_css_selector( $selectors = '' ){

	if ( strpos($selectors, '(') !== false ) {

		$selectors = cloudfW_css_selector_globals( $selectors ); 
		$exploded_selectors = explode( ',', $selectors );
		$out = array();
		foreach ($exploded_selectors as $selector) {

			$selector = trim( $selector ); 
			if ( strpos($selector, '(') !== false ) {
				$out[] = preg_replace_callback('#^.*\((.*)\).*?$#', 'cloudfw_make_css_selector_callback', $selector);
			} else {
				$out[] = $selector; 
			}

		}

		if ( ! empty( $out ) ) {
			$out = implode(', ', $out);
			return $out;
		}

	}

	return $selectors;
}

/**
 *	Makes mod.
 *
 *	@since 1.0
 */
function cloudfw_make_mod( $int, $mod ) {
	$int      = ceil($int);
	$x        = $int % $mod;
	$negative = $mod - $x;
	return $int + $negative;
}

/**
 * Adds inline css code to inside head tags
 *
 * @param  string $id
 * @param  string $css
 * @return bollean
 */
function cloudfw_inline_css( $id, $css ) {
	return cloudfw_vc_set( 'css', $id, $css );
}

/**
 *	Loops Data
 *
 *	@since 1.0
 */
function loop_get_defaults($default, $data, $level = 0, $current_level = 0){
	$current_level++;

	if (is_array($default)) {
		foreach ($default as $def_arr_key => $def_arr_val) {
			if (!isset($data[$def_arr_key]))
				$data[$def_arr_key] = $def_arr_val;

			if (!empty($data[$def_arr_key][0]))
				$data[$def_arr_key] = $data[$def_arr_key];
			else
				$data[$def_arr_key] = loop_get_defaults($default[$def_arr_key], $data[$def_arr_key], $level, $current_level);
		}
	}
	return $data;
}

/**
 *	Get CloudFw Options
 *
 *	@since 1.0
 */
function cloudfw_get_all_options( $section = 'theme', $additional = TRUE, $force = FALSE ) {

	if ( ! $additional ) {
		static $cloudfw_options;
	}

	if ( empty( $section ) ) {
		$section = 'theme';
	}

	if ( empty($cloudfw_options) || $force ) {

		$cloudfw_options = array();

		# Get Options Of The Modules
		$additional_options = array(
			PFIX.'_skin_ids',
			PFIX.'_slider_ids',
			PFIX.'_page_ids',
			PFIX.'_last_checked_version',
		);

		if ( $additional ) {

			if ( is_array( $additional ) ) {
				$additional_options = array_merge( $additional_options, $additional );
			} elseif ( is_string( $additional ) ) {
				$additional_options[] = $additional;
			}

			foreach( $additional_options as $additional_option ) {
				$cloudfw_options[ $additional_option ] = get_option($additional_option);
			}

		}

		# Theme Options
		$map = apply_filters("cloudfw_options_map", cloudfw_get_content_maps($section));
		$options = get_option(PFIX.'_options');

		foreach ( (array) $map as $option => $default ) {
			if ( ! isset( $options[ $option ] ) ) {
				$cloudfw_options[ $option ] = $default;
			} else {
				$cloudfw_options[ $option ] = loop_get_defaults( $map[$option], $options[$option] );
			}
		}

	}

	return $cloudfw_options;
}

/**
 *	Save All Options
 *
 *	@since 1.0
 */
function cloudfw_save_options( $section = NULL ){

	if (empty($section))
		$section = 'theme';

	$map = cloudfw_get_content_maps($section);

	$options = array();

	if ( $section !== 'setup' ):

		$_REQUEST = stripslashes_deep($_REQUEST);

		foreach ((array) $map as $main_option => $default) {

			if ( is_array( $default ) &&  !empty( $default ) ) {

				foreach ( $default as $sub_option => $sub_default ) {

					$sanitize_key = cloudfw_sanitize( $main_option, $sub_option );
					$sanitize_key_is_defined = cloudfw_sanitize( 'is_defined_'.$main_option, $sub_option );

					$var = isset($_REQUEST[ $sanitize_key ]) ? $_REQUEST[ $sanitize_key ] : NULL;
					$is_defined = isset($_REQUEST[ $sanitize_key_is_defined ]) ? $_REQUEST[ $sanitize_key_is_defined ] : NULL;

					if (!isset($var) &&  !isset($is_defined) ) {
						continue;
					}

					if ($is_defined == 'onoff' && empty($var))
						$var = 'FALSE';

					//if (!is_array($var)) $var = stripslashes($var);
					if ( $var === '0' )  $var = '0';
					elseif ( empty($var) ) $var = $sub_default;

					$out_attr[$sub_option] = $var;

				}

				if (isset($out_attr)) {
					$options[$main_option] = $out_attr;
				}

				$out_attr = NULL;

			} else {

				$sanitize_key = cloudfw_sanitize( $main_option );
				$sanitize_key_is_defined = cloudfw_sanitize( 'is_defined_'.$main_option );

				$var = isset($_REQUEST[ $sanitize_key ]) ? $_REQUEST[ $sanitize_key ] : NULL;
				$is_defined = isset($_REQUEST[ $sanitize_key_is_defined ]) ? $_REQUEST[ $sanitize_key_is_defined ] : NULL;

				if (!isset($var) && !isset($is_defined) )
					continue;

				if ($is_defined == 'onoff' && empty($var))
					$var = 'FALSE';

				//if (!is_array($var)) $var = stripslashes($var);
				if ( $var === '0' ) $var = '0';
				elseif ( empty($var) ) $var = $default;

				$options[$main_option] = $var;

			}


		} // foreach

	else:

		$options = $map;

	endif;

		$old_options = cloudfw_get_all_options($section, FALSE, TRUE);
		$options = cloudfw_array_merge($old_options, $options);

		update_option(PFIX.'_options', apply_filters( 'cloudfw_save_options', $options ));
		do_action("cloudfw_save_options");

	return $options;
}


/**
 *	Echo a Theme Option
 *
 *	@since 1.0
 */
function cloudfw_option( $option = NULL, $sub_option = NULL, $default = NULL, $check_default = NULL, $pfix = TRUE ) {
	echo cloudfw_get_option( $option, $sub_option, $default, $check_default, $pfix );
}

/**
 *	Get a Theme Option
 *
 *	@since 1.0
 */
function cloudfw_get_option( $option = NULL, $sub_option = NULL, $default = NULL, $check_default = NULL, $pfix = TRUE ) {
	global $_opt;
	if ( ! $_opt ) {
		$_opt = cloudfw_get_all_options();
	}

	$filter = "cloudfw_option_{$option}";
	$option = isset( $_opt[ $pfix ? PFIX.'_'.$option:$option ] ) ? $_opt[ $pfix ? PFIX.'_' . $option : $option ] : NULL;

	if ( $sub_option && isset( $option ) && !is_null( $option ) ) {
		if ( isset( $option[ $sub_option ] ) ) {
			$option = $option[ $sub_option ];
		}

		$filter .= ":{$sub_option}";
	}

	if ( isset( $check_default ) ) {
		$option = cloudfw_check_default( $option, $check_default );
	}

	$option = isset($option ) && ( !empty($option) || $option === '0' || $option === 0 ) ? $option : $default;

	return apply_filters( $filter, $option );

}

/**
 *	Returns raw option
 *
 *	@since 1.0
 */
function cloudfw_raw_option( $option = NULL, $sub_option = NULL, $default = NULL, $pfix = TRUE ) {
	if ( cloudfw_vc_isset( __FUNCTION__, 'map' ) ) {
		$map = cloudfw_vc_get( __FUNCTION__, 'map' );
	} else {
		unload_textdomain('cloudfw');
		$map = cloudfw_vc_set( __FUNCTION__, 'map', apply_filters("cloudfw_options_raw", cloudfw_get_content_maps('theme', 'cloudfw_options_raw')));
		cloudfw_load_textdomain();
	}

	$option = isset($map[$pfix ? PFIX.'_'.$option:$option]) ? $map[$pfix ? PFIX.'_'.$option:$option] : NULL;
	if ( $sub_option && isset($option) && !is_null($option) ) {
		if ( isset($option[$sub_option]) )
			$option = $option[$sub_option];
	}

	$option = isset($option ) && ( !empty($option) || $option === '0' || $option === 0 ) ? $option : $default;

	return $option;
}

/**
 *	Get a Theme Defaults
 *
 *	@since 1.0
 */
function cloudfw_get_default( $option = NULL, $sub_option = NULL, $default = NULL, $map_id = NULL, $pfix = TRUE ) {
	if ( cloudfw_vc_isset( __FUNCTION__, 'map' . $map_id ) ) {
		$map = cloudfw_vc_get( __FUNCTION__, 'map' . $map_id );
	} else {
		$map = cloudfw_vc_set( __FUNCTION__, 'map' . $map_id, apply_filters("cloudfw_options_map", cloudfw_get_content_maps('theme', $map_id)));
	}

	$option = isset($map[$pfix ? PFIX.'_'.$option:$option]) ? $map[$pfix ? PFIX.'_'.$option:$option] : NULL;
	if ( $sub_option && isset($option) && !is_null($option) ) {
		if ( isset($option[$sub_option]) )
			$option = $option[$sub_option];
	}

	$option = isset($option ) && ( !empty($option) || $option === '0' || $option === 0 ) ? $option : $default;

	return $option;
}

/**
 *	Checks the Option (On/Off)
 */
function cloudfw_check_onoff( $option = NULL, $sub_option = NULL, $default = NULL ){
	return _check_onoff( cloudfw_get_option( $option, $sub_option, $default ) );
}

/**
 *	Get Post Meta
 *
 *	@since 1.0
 */
function cloudfw_get_post_meta( $item_id = NULL, $key = NULL, $default = NULL, $check_default = NULL, $pfix = TRUE ) {
	if ( $pfix )
		$key = PFIX . '_' . $key;

	$option = get_post_meta($item_id, $key, 'FALSE');
	if ( isset($check_default) )
		$option = cloudfw_check_default( $option, $check_default );

	$option = isset($option ) && ( !empty($option) || $option === '0' || $option === 0 ) ? $option : $default;
	return $option;
}


/**
 *	Update an Option
 *
 *	@since 1.0
 */
function cloudfw_update_option( $option, $value = NULL, $section = 'theme' ) {

	if (!is_array($option))
		$options[$option] = $value;
	else
		$options = $option;

	$old_options = cloudfw_get_all_options($section, FALSE, TRUE);
	$options = cloudfw_array_merge($old_options, $options);

	update_option(PFIX.'_options', $options);
	return $options;
}

/**
 *	Delete an Option
 *
 *	@since 1.0
 */
function cloudfw_delete_option( $option = NULL, $sub_option = NULL, $pfix = TRUE, $section = 'theme' ) {

	global $_opt;

	$all_options = cloudfw_get_all_options($section, FALSE, TRUE);

	if ( $pfix )
		$the_option = PFIX.'_'.$option;
	else
		$the_option = $option;

	if ($sub_option && isset($all_options[$the_option][$sub_option]) )
		unset( $all_options[$the_option][$sub_option] );
	elseif ( !$sub_option && isset( $all_options[$the_option] ) )
		unset( $all_options[$the_option] );

	update_option(PFIX.'_options', $all_options);

	return $_opt = $all_options;
}

/**
 *	Walk Options
 *
 *	@since 1.0
 */
function cloudfw_walk_options( $walker, $data, $array_id = NULL, $filter = NULL ){
	$out = array();
	if ( isset($walker) && $walker ) {
		if ( !isset($walker['indicator']) || empty($walker['indicator']) )
			$walker['indicator'] = 'indicator';


		$indicator = $data[ $walker['indicator'] ];
		unset($walker['indicator']);

		if ( isset($indicator) && is_array($indicator) ) {
			foreach ($indicator as $i => $dummy) {
				foreach ($walker as $key => $value)
					$out[ isset($array_id) && $array_id ? $data[ $array_id ][ $i ] : $i ][ isset($key) ? $key : NULL ] = isset($data[ $value ][ $i ]) ? $data[ $value ][ $i ] : NULL;
			}

		}


	}

	if ( isset($filter) && $filter && is_array($out) && !empty($out) ) {
		if( isset($out[ $filter ]) && $out[ $filter ] )
			$out = $out[ $filter ];
		else
			return false;
	}

	return $out;
}


/**
 *	CloudFw Reset Options To Defaults
 *
 *	@since 1.0
 */
function cloudfw_reset_options(){
	return cloudfw_save_options( 'setup' );
}

/**
 *	Merge Array With Multi Level
 *
 *	@since 1.0
 */
function cloudfw_array_merge($arr1 = array(), $arr2 = array()) {

	foreach((array) $arr1 as $option => $old) {
		if ( (!isset($arr2[ $option ])) ) {
			# No New Option
			$arr2[$option] = $old;

		}

		# New Option
		if (( isset( $arr1[ $option ][0]) && $arr1[ $option ][0] ) || ( isset($arr2[$option][0]) && $arr2[$option][0] ))
			$arr2[ $option ] = $arr2[ $option ];
		else
			$arr2[ $option ] = loop_get_defaults( $arr1[ $option ], $arr2[ $option ] );

	}

	return $arr2;

}

/**
 *	Recursive Array Replace
 */
function cloudfw_array_replace( $find, $replace, $array ){
	if ( ! is_array( $array ) ) {
		return str_replace( $find, $replace, $array );
	}

	$newArray = array();

	foreach ($array as $key => $value) {
		$newArray[ $key ] = cloudfw_array_replace( $find, $replace, $value );
	}

	return $newArray;
}


/**
 *	Set Data
 *
 *	@since 1.0
 */
function cloudfw_set_data( $data = NULL ) {
	global $cloudfw_data;
	$cloudfw_data = $data;
}


/**
 *	Get Data
 *
 *	@since 1.0
 */
function cloudfw_get_data() {
	global $cloudfw_data;

	$current = $cloudfw_data;
	$value = '';
	foreach ((array) func_get_args() as $arg) {

		if ( !empty($arg) ) {
			if ( !isset($current[ $arg ]))
				return NULL;
			elseif ( !is_array($current[ $arg ]) ) {
				$value = $current[ $arg ];
				return $current = $value ? $current[ $arg ] : NULL;
			}
			else {
				$value = $current[ $arg ];
				$current = $current[ $arg ];
			}

		}
	}

	return isset($current) ? $current : NULL;
}


/**
 *	Check The Framework in Developing
 */
function cloudfw_in_developing(){
	if ( defined('CLOUDFW_DEVELOPING') && CLOUDFW_DEVELOPING === true/* && current_user_can('administration')*/ )
		return true;
	else
		return false;
}

if ( !function_exists('_if') ) {
	/**
	 *	Inline Conditional
	 *
	 *	@since 1.0
	 */
	function _if($cond = NULL , $is_true = NULL, $is_false = NULL, $echo = FALSE){
		$out = ($cond) ? $is_true : $is_false;
		if ($echo) echo $out; else; return $out;
	}
}

if ( !function_exists('_check_onoff') ) {
	/**
	 *	Check is On or Off
	 *
	 *	@since 1.0
	 */
	function _check_onoff( $val ){
		return ($val !== 'FALSE' && $val !== '0' && $val !== 0) ? TRUE: FALSE;
	}
}

/**
 *	Check Attributes for OnOff
 *
 *	@since 1.0
 */
function _check_onoff_false($data, $decode = false ){
	foreach((array)$data as $key => $value){
		if ( $value === "FALSE" )
			$data[$key] = '0';
		elseif ( $decode == true )
			$data[$key] = urldecode($value);
	}
	return $data;
}


/**
 *	Checks is multisite
 *
 *	@since 3.0
 */
function cloudfw_is_multisite() {
	return defined('MULTISITE') && MULTISITE === true;
}

/**
 *	Checks for retina display
 *
 * @link http://stackoverflow.com/questions/15234519/detect-retina-display-in-php
 * @return [type] [description]
 */
function cloudfw_is_retina() {
	if ( ! current_theme_supports('retina') ) {
		return false;
	}

    global $cloudfw_is_retina;

    if ( isset( $cloudfw_is_retina ) ) {
    	return $cloudfw_is_retina;
    }

    return $cloudfw_is_retina = isset( $_COOKIE["device_pixel_ratio"] ) && $_COOKIE["device_pixel_ratio"] >= 1.5;
}

/**
 *	Check the theme is responsive
 *
 *	@since 1.0
 */
function cloudfw_is_responsive() {
	return current_theme_supports('responsive') && cloudfw_check_onoff('global', 'responsive');
}

/**
 *	Check Plugin is Installed?
 *
 *	@since 1.0
 */
function cloudfw_check_language_plugin( $plugin = NULL ){

	$result = false;

	switch( $plugin ) {
		case 'wpml':
			$result = defined('ICL_LANGUAGE_CODE');
		break;
		case 'qtranslate':
			$result = isset($GLOBALS['q_config']['language']);
		break;
	}

	return apply_filters('cloudfw_check_language_plugin', $result, $plugin);
}

/**
 *	Check default.
 *
 *	@since 1.0
 */
function cloudfw_check_default( $value, $default ) {
	return $value == $default ? NULL : $value;
}

/**
 *	CloudFw Get Ajax URL
 *
 *	@since 1.0
 */
function cloudfw_ajax_url(){

	$url = 'admin-ajax.php';

	if ( cloudfw_check_language_plugin( 'wpml' ) ) {
		$url .= '?lang='.ICL_LANGUAGE_CODE;
	} elseif ( cloudfw_check_language_plugin( 'qtranslate' ) ) {
		$url .= '?lang='.$GLOBALS['q_config']['language'];
	}

	return admin_url($url);
}

/**
 *	CloudFw WP Content
 */
function cloudfw_wp_content(){
	return basename(untrailingslashit(content_url()));
}

/**
 *	CloudFw Detect Image Folder
 *
 *	@since 1.0
 */
function cloudfw_detect_image_folder( $src ){

	if ( cloudfw_is_multisite() ) {
		global $blog_id;

		$image_path = explode($_SERVER['SERVER_NAME'], $src);
		$image_path = $_SERVER['DOCUMENT_ROOT'] . $image_path[1];

		$the_image_src = $src;
		if (isset($blog_id) && $blog_id > 0) {
				$image_parts = explode('/files/', $the_image_src);

			if (isset($image_parts[1])) {
				$the_image_src = '/blogs.dir/' . $blog_id . '/files/' . $image_parts[1];
				$src = get_blogaddress_by_id(1).'/'. cloudfw_wp_content() .$the_image_src;
			}

		}

	}

	return $src;
}

/**
 *	CloudFw Auto-Resized Thumbnails
 *
 *	@since 1.0
 *	@version 3.0
 */

function cloudfw_thumbnail( $data, $placeholder = true ){

	extract(cloudfw_make_var(array(
		'src'	=> NULL,
		'w'		=> NULL,
		'h'		=> NULL,
		'r'		=> NULL,
		'q'		=> NULL,
		'cache'	=> 1,
		'fixed'	=> 1,
		'retina'=> FALSE,
	), $data));

	if ( ! is_array( $data ) ) {
		return $data;
	}

	$src =  cloudfw_detect_image_folder( $src );
	$plugin = cloudfw_get_option('global', 'thumb_resizer');

	switch ( $plugin ) {
		default:
		case 'aqua_resizer':

			if ( ! function_exists('cloudfw_aq_resize') ) {
				include_once(TMP_PATH.'/cloudfw/core/classes/class.aqua-resizer.php');
			}

			if( $src && $image = cloudfw_aq_resize( $src, $w, $h, $fixed, true, true, $retina ) ) {

				if ( $image == $src && $placeholder ) {

					$placeholder_image = cloudfw_placeholder( 'default', 'large' );

					if ( !empty($placeholder_image) ) {
						$data['src'] = $placeholder_image;
						return cloudfw_thumbnail( $data, FALSE );
					}

				}

				return $image;

			} else {

				if ( $placeholder ) {
					$placeholder_image = cloudfw_placeholder( 'default', 'large' );

					if ( !empty($placeholder_image) ) {
						$data['src'] = $placeholder_image;
						return cloudfw_thumbnail( $data, FALSE );
					}

				}
				return $src;
			}

		break;
	}
}

/**
 *	CloudFw Relative Path
 */
function cloudfw_relative_path( $dir ) {
	$dir = str_replace('\\', '/', $dir);
	$dir_pieces = explode(cloudfw_wp_content() . '/', $dir);
	$dir = content_url($dir_pieces[1]);

	return $dir;
}

/**
 *	CloudFw Absoulute Path
 */
function cloudfw_abs_path( $file ) {
	$path = str_replace('/', '\\', WP_CONTENT_DIR);
	$file = str_replace('\\', '/', $file);
	$file_pieces = explode(cloudfw_wp_content() . '/', $file);
	$url = isset($file_pieces[1]) ? path_join( $path, $file_pieces[1] ) : $file;
	$url = str_replace('\\', '/', $url);

	return $url;
}

/**
 *	CloudFw Get Admin Panel URL
 *
 *	@since 1.0
 */
function cloudfw_admin_url($tab = NULL, $jump = NULL){
	$url  = CLOUDFW_PAGE;
	if (!empty($tab)) $url .= '&tab='.$tab;
	if (isset($jump)) $url .= '&jump='.$jump;

	return admin_url($url);
}

/**
 *	CloudFw Fatal Error Messages
 *
 *	@since 1.0
 */
function cloudfw_error_message($message){
	return "<div class=\"cloudfw-fatal-error\"><strong>".__('Error','cloudfw')."</strong>: {$message}</div>";
}

/**
 *	CloudFw File Cache
 *
 *	@since 1.0
 */
function cloudfw_file_create_to_uploads( $filename = NULL, $data = NULL ){

	add_filter('upload_mimes', 'cloudfw_upload_mimes');
	$uploaded = wp_upload_bits( $filename, '', $data );

	if ( false === $uploaded['error'] ) {
		return $uploaded;
	} else {
		return $uploaded['error'];
	}
}

/**
 * Finds folder on remote system
 *
 * @param  string $path
 * @return string
 */
function cloudfw_find_folder( $path ){
    global $wp_filesystem;

    if ( $wp_filesystem->errors->get_error_code() ) {
    	return $path;
    }

	$parent = dirname( $path );
	$dirname = basename( $path );
	$path = $wp_filesystem->find_folder( $parent ) . $dirname;

    /*if ( $wp_filesystem->is_file( $path ) ) {
		$path = $wp_filesystem->find_folder( $parent ) . $dirname;
    } else {
		$path = $wp_filesystem->find_folder( $parent ) . $dirname;
    }*/

    return $path;
}

/**
 *	CloudFw File Cache
 *
 *	@since 1.0
 */
function cloudfw_file_create_direct( $file = NULL, $data = NULL ){
	cloudfw_check_dir( dirname($file) );
	global $wp_filesystem;

	if ( $wp_filesystem->put_contents( $file, $data, FS_CHMOD_FILE) ) {
		return $file;
	} else
		return false;
}

/**
 *	CloudFw File System - Write
 *
 *	@since 2.0
 */
function cloudfw_file_create( $path, $filename, $data, $callback = NULL ){
	global $wp_filesystem;

	$path = cloudfw_folder( $path );
	$file = $path . $filename;

	if ( empty( $data ) ) {
		return false;
	}

	cloudfw_check_dir( $path, $callback );

	if ( $wp_filesystem->put_contents( $file, $data, FS_CHMOD_FILE) ) {
		return $file;
	} else {
		return false;
	}
}

/**
 *	Get File Method
 */
function cloudfw_get_file_method(){
	global $cloudfw_get_file_method;

	if ( !empty($cloudfw_get_file_method) )
		 return $cloudfw_get_file_method;

	if( ini_get('allow_url_fopen') ) {
		$cloudfw_get_file_method = 'fopen';
	} else {
		$cloudfw_get_file_method = 'file_get_contents';
	}
}

/**
 *	CloudFw File System - Get File Contents
 *
 *	@since 3.0
 */
function cloudfw_get_file_contents( $path ) {
	if ( function_exists('realpath') )
		$path = realpath($path);

	if ( !$path || !@is_file($path) )
		return '';

	/** Detect get file method */
	$method = cloudfw_get_file_method();

	if ( $method == 'fopen' ) {

		$handle = fopen( $path, 'rb' );
		$content = '';
		if( $handle !== false ) {
			while (!feof($handle)) {
				$content .= fread($handle, 8192);
			}
			fclose( $handle );
		}
		return $content;

	} else {
		return file_get_contents($path);
	}


}

/**
 *	CloudFw File System - Delete
 *
 *	@since 2.0
 */
function cloudfw_file_delete( $file = NULL ){

	$upload_dir = wp_upload_dir();
	$upload_dir = $upload_dir["basedir"]."/";
	$file = "".$upload_dir."".$file;

	if (!@fopen($file, 'w+')) {return false;}

	@unlink($file);

}

/**
 *	Detect the Folder
 */
function cloudfw_folder( $path ){
	$path = str_replace('//', '/', $path);

	require_once( ABSPATH.'/wp-admin/includes/file.php' );
	/** Get the method */
	$method = get_filesystem_method();

	global $wp_filesystem;
	if ( !isset($wp_filesystem) || !$wp_filesystem || !is_object($wp_filesystem) ) {
		WP_Filesystem();
	}

	if ( $method == 'direct' ) {
		return $path;
	}


	$add_slash = substr($path, -1) == '/';
	$parent = dirname($path);
	$dirname = basename($path);
	$path = $wp_filesystem->find_folder( $parent ) . $dirname;

	if ( $add_slash )
		$path .= '/';

	return $path;
}

/**
 *	CloudFw File System - Chech directory
 *
 *	@since 3.0
 */
function cloudfw_check_dir( $path, $callback = NULL, $error = true ){
	//$path = cloudfw_folder( $path, $error );
	return wp_mkdir_p( $path ) === TRUE;
}

/**
 *	CloudFw File System - Chech directory, deep version
 *
 *	@since 3.0
 */
function cloudfw_check_dir_deep( $base, $path, $callback = NULL ){
	cloudfw_check_dir( trailingslashit($base), $callback );
	$folders = explode('/',  untrailingslashit(str_replace($base, '', $path)));

	if ( !empty($folders[0]) ) {
		cloudfw_check_dir_deep( trailingslashit($base . $folders[0]), trailingslashit($path), $callback );
	}

}

/**
 *	Check whether the folder is writable
 *
 *	@since 1.0
 */
function cloudfw_is_writable($path) {
	return wp_mkdir_p( $path );
}


/**
 *  CloudFw Save an Image to the Library
 *
 *  @since 3.0
 */
function cloudfw_save_to_library( $args = array() ){
	extract(cloudfw_make_var(array(
		'title'         => '',
		'filename'      => '',
	), $args));

	if ( empty($filename) )
		return false;

	if (!empty( $title ))
		$filetitle = $title;
	else
		$filetitle = basename($filename);

	$wp_filetype = wp_check_filetype(basename($filename), null );
	$wp_upload_dir = wp_upload_dir();
	$guid = str_replace( $wp_upload_dir['baseurl'], '', $filename );
	$attachment = array(
		'guid'           => $guid,
		'post_mime_type' => $wp_filetype['type'],
		'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filetitle)),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);
	$attach_id = wp_insert_attachment( $attachment, $guid, NULL );
	require_once(ABSPATH . 'wp-admin/includes/image.php');

	$attach_data = wp_generate_attachment_metadata( $attach_id, $guid );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	return $attach_id;
}

/**
 * Copies placeholder images into the upload folder
 *
 * @param  (string) $type placeholder type
 * @param  (string) $size image size
 * @return (string)       image URL
 */
function cloudfw_placeholder( $type, $size = 'large' ) {

	$attachment_id = cloudfw_placeholder_id( $type );
	$image_link = wp_get_attachment_url( $attachment_id );

	if ( ! $image_link ) {
		return cloudfw_placeholder_source( $type, 'relative' );
	}

	$image = wp_get_attachment_image_src( $attachment_id, $size);

	return $image[0];
}

/**
 * Gets placeholder images' source
 *
 * @param  (string) $type placeholder type
 * @param  (string) $source
 * @return (string)
 */
function cloudfw_placeholder_source( $type, $source = 'absolute' ) {
	$image = '';

	switch ($type) {
		case 'default':
			$image = 'images/default-placeholder.png';
			break;

		case 'shop':
			$image = 'images/shop-placeholder.png';
			break;

		default:
			$image = 'images/shop-placeholder.png';
			break;
	}
	return ($source == 'relative' ? TMP_LIB : TMP_LIB_PATH) . $image;
}

/**
 * Gets placeholder ID from cache or generates ID
 *
 * @param  (string) $type placeholder type
 * @return (string)
 */
function cloudfw_placeholder_id( $type ) {

	$option_name = PFIX . '_placeholder_' . $type;
	$placeholder = get_option( $option_name );

	if ( ! $placeholder ) {
		$placeholder = cloudfw_placeholder_generate( $type );
		update_option( $option_name, $placeholder );
	}

	return $placeholder;

	if ( !empty( $sub ) ) {
		return isset($placeholder[ $sub ]) ? $placeholder[ $sub ] : NULL;
	} else {
		return $placeholder;
	}

}

/**
 * Registers placeholder image into the media library
 *
 * @param  (string) $type placeholder type
 * @return (string)
 */
function cloudfw_placeholder_generate( $type ){
	$attach_id = false;
	$source_file_path = cloudfw_abs_path( cloudfw_placeholder_source( $type ) );

    $pathinfo = pathinfo( $source_file_path );
    $filename = $pathinfo['filename'];
    $extension = $pathinfo['extension'];

	if ( $created_file = cloudfw_file_create_to_uploads( basename($source_file_path), file_get_contents( $source_file_path ) ) ) {
		$file = $created_file['file'];
		$file_abs = cloudfw_abs_path( $created_file['url'] );
	}

	if( !empty( $file ) ) {
		$attach_id = cloudfw_save_to_library(array(
			'title'			=> '',
			'filename'		=> $file,
		));
	}

	return $attach_id;
}


/**
 *	Get Page URL from string
 *
 *	@since 1.0
 */
function cloudfw_get_page_link( $data ){
	if (empty($data)) {
		return false;
	}


	if(strstr($data,"||")){
		$data = explode('||', $data);
		return esc_attr($data[1]);
	} else {

		if ( $data[0] == '/' ) {
			$data = cloudfw_home_url() . $data;
		}

		return esc_attr($data);
	}
}

/**
 *	Get Page ID form string
 *
 *	@since 1.0
 */
function cloudfw_get_page_id($data){
	if (empty($data) || !strstr($data,"||"))
		return false;

	$data = explode('||', $data);

	return (int) $data[2];
}

/**
 *	Convert an array to string
 *
 *	@since 1.0
 */
function loop_the_array_to_string( $arr, $negative = false ) {
	if ($arr) {
		$last_arr = end($arr);
		foreach ((array) $arr as $t) {
			$arr .= ($negative) ? '-' : NULL;
			$arr .= $t;
			$arr .= ($last_arr == $t) ? NULL : ',';
		}
		return $arr;
	} else
		return false;
}

/**
 *	Convert a string to array
 *
 *	@since 1.0
 */
function loop_the_string_to_array( $arr ) {
	if ($arr) {
		$arr = array();
		$arr = explode(",", $arr);
		foreach ((array) $arr as $t) {
			$array[] = $t;
		}
		return $array;
	} else {
		return false;
	}
}

/**
 *	Convert an object to array
 *
 *	@since 1.0
 */
function cloudfw_object_to_array( $object ) {
	if (!is_object($object) && !is_array($object)) {
		return $object;
	}
	if (is_object($object)) {
		$object = get_object_vars($object);
	}
	return array_map('cloudfw_object_to_array', $object);
}

/**
 *	Sort An Array by Another Array
 *
 *	@since 1.0
 */
function cloudfw_array_sort_by_array($array,$orderArray) {
	$ordered = array();
	foreach((array)$orderArray as $key) {
		if(array_key_exists($key,$array)) {
				$ordered[$key] = $array[$key];
				unset($array[$key]);
		}
	}
	return $ordered + $array;
}

/**
 *  Fix Ajax Results
 *
 *  @since 1.0
**/
if ( defined ( 'DOING_AJAX' ) && DOING_AJAX ) {
	add_filter( 'doing_it_wrong_trigger_error', '__return_false', 10 );
}

/**
 *	Generate a random string
 *
 *	@since 1.0
 */
function cloudfw_randomizer($length = 10, $prefix = NULL, $type = 'all' ) {
	$numeric 		= '0123456789';
	$alphabet_upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$alphabet_lower = 'abcdefghijklmnopqrstuvwxyz';
	$alphabet 		= $alphabet_upper . $alphabet_lower;
	$string = '';

	if ( $type === '09' )
		$characters = $numeric;
	elseif ( $type === 'AZ' )
		$characters = $alphabet_upper;
	elseif ( $type === '09-AZ' )
		$characters = $numeric . $alphabet_upper;
	elseif ( $type === 'az' )
		$characters = $alphabet_lower;
	elseif ( $type === '09-az' )
		$characters = $numeric . $alphabet_lower;
	elseif ( $type === 'AZ-az' )
		$characters = $alphabet;
	else
		$characters = $numeric . $alphabet;

	for ($p = 0; $p < $length; $p++) {
		$string .= $characters[mt_rand(0, strlen($characters) - 1 )];
	}

	if ( isset($prefix) && !empty($prefix) && is_string($prefix) )
		$string = $prefix . $string;

	return $string;
}

/**
 *	Make Icon URL
 *
 *	@since 1.0
 */
function cloudfw_make_icon( $value, $extra_class = NULL, $style = NULL ) {
	if ( empty( $value ) )
		return;

	$out = '';
	$classes = array();
	$data_attr = array();

	$classes[] = 'ui--icon';
	$classes[] = $extra_class;

	$extension = pathinfo( $value, PATHINFO_EXTENSION );

	if ( empty( $extension ) ) {
		$value = explode('||', $value);
		$id = $value[0];

		if ( strpos($id, '/') == false )
			return;

		$id = str_replace('icon-', 'fontawesome-', $id);

		$id_attributes = explode('/', $id);
		$icon_family = $id_attributes[0];
		$icon_class = $id_attributes[1];

		if ( empty($icon_class) )
			return;

		do_action( 'cloudfw_make_icon', $icon_family, $icon_class );

		$classes[] = $icon_class;

		$args = array_slice( $value, 1 );
		$attributes = array();

		if ( !empty($args) && is_array($args) ) {
			foreach ($args as $attribute) {
				$attribute = explode(':', $attribute);
				if ( count( $attribute ) === 2 )
					$attributes[$attribute[0]] = $attribute[1];
			}
		}

		$is_admin = is_admin();

		if ( is_admin() ) {
			$data_attr['data-icon-class']        = $id;
			$data_attr['data-icon-color']        = isset($attributes['color']) ? $attributes['color'] : NULL;
			$data_attr['data-icon-background']   = isset($attributes['background']) ? $attributes['background'] : NULL;
			$data_attr['data-icon-size']         = isset($attributes['size']) ? $attributes['size'] : NULL;
			$data_attr['data-icon-border-color'] = isset($attributes['border_color']) ? $attributes['border_color'] : NULL;
			$data_attr['data-icon-border-width']  = isset($attributes['border_width']) ? $attributes['border_width'] : NULL;
			$data_attr['data-icon-border-radius']  = isset($attributes['border_radius']) ? $attributes['border_radius'] : NULL;
		}


		$size = isset($attributes['size']) ? $attributes['size'] : NULL;

		$styles = array();

		if ( $size ) {
			$styles['font-size'] = $size;
			$styles['width'] = $size + 4;
			$styles['height'] = $size + 4;
			$classes[] = 'icon-inline-block';
		}
		$styles['!color'] = isset($attributes['color']) ? $attributes['color'] : NULL;
		$styles['background-color'] = isset($attributes['background']) ? $attributes['background'] : NULL;
		$styles['border-color'] = isset($attributes['border_color']) ? $attributes['border_color'] : NULL;
		$styles['border-width'] = isset($attributes['border_width']) ? $attributes['border_width'] : NULL;

		if ( !empty($styles['border-color']) && ( empty($styles['border-width']) || (int) $styles['border-width'] < 1 ) ) {
			$styles['border-width'] = 1;
		}

		if ( !empty($styles['border-color']) || !empty($styles['border-width']) ) {
			$styles['border-style'] = 'solid';
		}

		if ( !empty($styles['background-color']) || !empty($styles['border-color']) || !empty($styles['border-width']) ) {
			$classes[] = 'icon-with-background';
			$classes[] = 'icon-inline-block';
		}

		if ( !empty($attributes['border_radius']) ) {
			$classes[] = $attributes['border_radius'];
		}

		$styles['style'] = $style;

		/** Image */
		$out .= "<i".
			cloudfw_make_class($classes, true) .
			cloudfw_make_attribute( $data_attr, FALSE ) .
			cloudfw_make_style_attribute( $styles, FALSE, TRUE )
		."></i>";

	} else {

		$explode = explode('||', $value);

		if ( !empty($explode[0]) && !empty($explode[1]) ) {
			$value  = $explode[0];
			$retina = $explode[1];
		}

		$value = cloudfw_make_icon_url( $value );

		if ( empty($value) )
			return;

		/** Image */
		$out .= "<img".
			cloudfw_make_class($classes, true) .
			cloudfw_make_attribute( array(
				'src'              => $value,
				'alt'              => '',
				'data-at2x'        => isset($retina) ? $retina : NULL,
				'data-retina-auto' => true,
			), FALSE ) .
			cloudfw_make_style_attribute( array(
				'style'			=>	$style,
			), FALSE, TRUE )

		."/>";

	}

	return $out;

}

/**
 *	Make Icon URL
 *
 *	@since 1.0
 */
function cloudfw_make_icon_url( $url ) {
	if ( empty( $url ) )
		return;

	$url = rawurldecode($url);
	$path = ICONS_DIR_PATH . '/' . $url;
	if( ! @file_exists( $path ) )
		return $url;

	return ICONS_DIR . $url;
}


/**
 *	Make Less Texts
 *
 *	@since 1.0
 */
function cloudfw_less_text( $text = NULL, $count = 50, $after = '..' ) {
	/** Check wheter it's empty */
	if(empty($text)) {
		return false;
	}

	/** Match the lenght of the string */
	$text_length = strlen($text);

	/** Return */
	return ($text_length > $count) ? mb_substr($text, 0, $count) . $after : $text;
}

/**
 *	Get the Excerpt
 *
 *	@since 1.0
 */
if ( ! function_exists( 'cloudfw_the_excerpt' ) &&  ! function_exists( 'cloudfw_get_the_excerpt' )  ):

function cloudfw_the_excerpt( $args = array() ) {
	$args['echo'] = true;
	return cloudfw_get_the_excerpt( $args );
}

/**
 * Custom excerpt function
 *
 * @param  array  $args
 * @return string
 */
function cloudfw_get_the_excerpt( $args = array() ) {
	global $post;

	$defaults = array(
		'length' 			=> 50,
		'allowedtags' 		=> '',
		'filter_type'		=> 'none',
		'use_more_link' 	=> true,
		'more_link_text' 	=>  __('Read More','cloudfw'),
		'more_link_class'	=> '',
		'force_more'		=> false,
		'fakeit'			=> 1,
		'no_more'			=> true,
		'more_tag'			=> 'span',
		'more_link_title'	=> __('Continue reading this entry','cloudfw'),
		'showdots'			=> true,
		'strip_shortcodes'	=> true,
		'echo'				=> false
	);

	if ( isset($args['filter_type']) && $args['filter_type'] ) {
		if(preg_match('%^content($|_rss)|^excerpt($|_rss)%', $args['filter_type'])) {
			$args['filter_type'] = 'the_' . $filter_type;
		}
	}

	extract(cloudfw_make_var($defaults, $args));

	if (!empty($post->post_password)) { // if there's a password
		$output = '';
		if ( !isset( $_COOKIE['wp-postpass_'.COOKIEHASH] ) || $_COOKIE['wp-postpass_'.COOKIEHASH] != $post->post_password) { // and it doesn't match cookie
			if(is_feed()) { // if this runs in a feed
				$output = __('There is no excerpt because this is a protected post.','cloudfw');
			} else {
				//if ( $length > 20 )
				//	$output = get_the_password_form();
			}
		}
		return $output;
	}

	$post->post_content = cloudfw_composer_the_content( $post->post_content, NULL, 'excerpt' );

	if($fakeit == 2) { // force content as excerpt
		$text = $post->post_content;
	} elseif($fakeit == 1) { // content as excerpt, if no excerpt
		$text = (empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { // excerpt no matter what
		$text = $post->post_excerpt;
	}

	if($strip_shortcodes)
		$text = strip_shortcodes($text);

	if ( !is_numeric($length) )
		$length = 50;

	if( $length < 0 ) {
		$output = $text;
	} else {
		if(!$no_more && strpos($text, '<!--more-->')) {
			$text = explode('<!--more-->', $text, 2);
			$l = count($text[0]);
			$more_link = 1;
		} else {
			$text = explode(' ', $text);
			if(count($text) > $length) {
				$l = $length;
				$ellipsis = 1;
			} else {
				$l = count($text);
				$more_link_text = '';
				$ellipsis = 0;
			}
		}
		$output = '';
		for ($i=0; $i<$l; $i++)
			$output .= $text[$i] . ' ';
	}

	if(isset($allowedtags) && 'all' != $allowedtags) {
		$output = strip_tags($output, $allowedtags);
	}

//	$output = str_replace(array("\r\n", "\r", "\n", "  "), " ", $output);

	$output = rtrim($output, "\s\n\t\r\0\x0B");
	$output = (isset($fix_tags) && $fix_tags) ? $output : balanceTags($output);
	$output .= ($showdots && $ellipsis) ? '...' : '';

	switch($more_tag) {
		case('div') :
			$tag = 'div';
		break;
		case('span') :
			$tag = 'span';
		break;
		case('p') :
			$tag = 'p';
		break;
		default :
			$tag = 'span';
	}

	if ($use_more_link && $more_link_text) {
		if($force_more) {
			$output .= ' <' . $tag . ' class="more-link"><a class="'. $more_link_class .'" href="'. __url(get_permalink( $post->ID )) . '#more-' . $post->ID .'" title="' . $more_link_title . '">' . $more_link_text . '</a></' . $tag . '>' . "\n";
		} else {
			$output .= ' <' . $tag . ' class="more-link"><a class="'. $more_link_class .'" href="'. __url(get_permalink( $post->ID )) . '" title="' . $more_link_title . '">' . $more_link_text . '</a></' . $tag . '>' . "\n";
		}
	}

	$output = apply_filters($filter_type, $output);

	if ( $echo )
		echo $output;

	return $output;
}
endif;


/**
 *	CloudFw Register Pattern
 *
 *	@since 1.0
 */
function cloudfw_register_skin_style( $id, $name, $code, $group = NULL, $namespace = 'default' ){
	global $cloudfw_pre_styles;
	$cloudfw_pre_styles[$id] = array('name' => $name, 'code' => $code, 'group' => $group, 'namespace' => $namespace);
}

/**
 *	CloudFw Deregister Pattern
 *
 *	@since 1.0
 */
function cloudfw_deregister_pattern( $id ){
	global $cloudfw_pre_styles;
	if(!empty($id))
		unset($cloudfw_pre_styles[$id]);
}

/**
 *	CloudFw - Generate ID for sequenced arrays
 *
 *	@since 3.0
 */
function cloudfw_id_for_sequence( &$array, $seq = 10 ) {
	if (!isset($seq))
		 $seq = 10;

	/** Search for a blank row */
	while ( isset( $array[ $seq ] ) )
		$seq++;

	/** Reserve the row */
	$array[ $seq ] = array();

	/** Return to the reserved number */
	return $seq;
}

/**
 *	Transfer Shortcode Attribute
 *
 *	@since 3.0
 */
function cloudfw_transfer_shortcode_attributes( $code, $atts, $content = NULL, $close_tag = true, $encode = false ) {
	$out  = "[{$code}";
		foreach ((array)$atts as $attribute => $value) {
			if ( $attribute == 'content' ) {
				continue;
			}

			if ( is_null( $value ) ) {
				continue;
			}

			if ( ! is_array($value) ) {

				if ( $encode ) {
					$out .= " {$attribute}=\"". (urlencode( $value )) ."\"";
				} else {
					$value = str_replace('[', '&#91;', $value); 
					$value = str_replace(']', '&#93;', $value); 
					$out .= " {$attribute}=\"". esc_attr( $value ) ."\"";
				}

			} else {
				$out .= " {$attribute}=\"". esc_attr( serialize($value) ) ."\"";
			}
		}
	$out .= "]";

	if ( $close_tag ) {
		if ( !empty($content) )
			$out .= " {$content} ";

		$out .= "[/{$code}]";
	}

	return $out;
}

/**
 *	Convert toBytes
 *
 *	@since 1.0
 */
function cloudfw_to_bytes($str) {
	$val = trim($str);
	$last = strtolower($str[strlen($str)-1]);
	switch($last) {
		case 'g': $val *= 1024;
		case 'm': $val *= 1024;
		case 'k': $val *= 1024;
	}
	return $val;
}

/**
 *	CloudFw Make JSON for Ajax Responses
 */
function cloudfw_ajax_make_json( $results = array() ){
	if ( is_array($results) && !empty($results) ) {
		echo htmlspecialchars( json_encode( $results ), ENT_NOQUOTES );
	}
}

/**
 *	Check Is Blog
 *
 *	@since 1.0
 */
if ( !function_exists('is_blog') ) {
	function is_blog () {
		global $cloudfw_is_blog;

		if( $cloudfw_is_blog )
			return $cloudfw_is_blog;


		$cloudfw_is_blog = ( (
				   ( is_archive() )
				|| ( is_search() )
				|| ( is_author() )
				|| ( is_category() )
				|| ( is_home() )
				|| ( is_single() && get_post_type() == 'post' )
				|| ( is_tag() )
				|| ( get_option('page_for_posts') == get_queried_object_id() )
				) ) ? true : false;

		return apply_filters( 'cloudfw_is_blog', $cloudfw_is_blog );

	}
}

/**
 *	Check BBPress Activated
 *
 *	@since 1.0
 */
function cloudfw_bbpress() {
	return class_exists('bbPress');
}

/**
 *	Check WooCommerce Activated
 *
 *	@since 1.0
 */
function cloudfw_woocommerce() {
	return class_exists('Woocommerce');
}

/**
 *	Generate Cache Id for Static Function Caches
 *
 *	@since 1.0
 */
function cloudfw_generate_cache_ID( $args ){
	$out = array();

	if ( is_array( $args ) ) {
		foreach ($args as $num => $value) {
			if ( is_array( $value ) )
				$value = serialize( $value );

			$out[] = $value;
		}
	}
	return md5( implode( '_', $out ) );
}

/**
 *	Custom Unserialize
 *
 *	@since 1.0
 */
function cloudfw_unserialize( $serial_str ) {
	$serial_str = (string) $serial_str;
	$serial_str_original = $serial_str;
	$serial_str = trim( $serial_str );
	$serial_str = @unserialize($serial_str);


	if ( $serial_str === false ) {
		$serial_str = preg_replace_callback('/s:(\d+):"(.*?)";/s', "cloudfw_fix_serialize_method_3_callback", $serial_str_original);
		$serial_str = @unserialize( $serial_str );
	}

	if ( $serial_str === false ) {
		$serial_str = cloudfw_fix_serialize_method_1( $serial_str_original );
		$serial_str = @unserialize( $serial_str );
	}

	if ( $serial_str === false ) {
		$serial_str = cloudfw_fix_serialize_method_2( $serial_str_original );
	}

	return $serial_str;
}

/**
 *	Serialize Fix Callback
 *
 *	@since 1.0
 */
function cloudfw_fix_serialize_method_3_callback( $match ) {
	return 's:' . strlen( $match[2] ) . ':"'. $match[2] .'"';
}

/**
 *	Serialize Fix Callback
 *
 *	@since 1.0
 */
function cloudfw_fix_serialize_method_1_callback($match) {
	return 's:' . strlen( $match[2] );
}

/**
 *	Serialize Fix
 *
 *	@since 1.0
 */
function cloudfw_fix_serialize_method_1( $data ){
	if ( ! $data ) {
		return $data;
	}

	$new = preg_replace_callback(
		'!^s:(\d+)(?=:"(.*?)";$)!s',
		'cloudfw_fix_serialize_method_1_callback',
		$data
	);

	if ($new === $data) {
		$new = preg_replace_callback(
			'!(?<=^|;)s:(\d+)(?=:"(.*?)";(?:}|a:|s:|b:|d:|i:|o:|N;))!s',
			'cloudfw_fix_serialize_method_1_callback',
			$new
		);
	}

	return $new;
}


/**
 *	Serialize Fix Callback
 *
 *	@since 1.0
 */
function cloudfw_fix_serialize_method_2($serialized) {
    $tmp = preg_replace('/^a:\d+:\{/', '', $serialized);
    return cloudfw_fix_serialize_method_2_callback($tmp); // operates on and whittles down the actual argument
}

/**
 *	Serialize Fix Callback
 *
 *	@since 1.0
 */
function cloudfw_fix_serialize_method_2_callback(&$broken) {
    $data       = array();
    $index      = null;
    $len        = strlen($broken);
    $i          = 0;

    while(strlen($broken)) {
        $i++;

        if ( $i > $len ) {
            break;
        }

        if (substr($broken, 0, 1) == '}') {
            $broken = substr($broken, 1);
            return $data;

        } else {

            $bite = substr($broken, 0, 2);

            switch($bite) {
                case 's:':
                    $re = '/^s:\d+:"([^\"]*)";/';
                    if (preg_match($re, $broken, $m)) {

                        if ($index === null) {
                            $index = $m[1];
                        } else {
                            $data[$index] = $m[1];
                            $index = null;
                        }

                        $broken = preg_replace($re, '', $broken);
                    }
                break;

                case 'i:':
                    $re = '/^i:(\d+);/';
                    if (preg_match($re, $broken, $m)) {

                        if ($index === null) {
                            $index = (int) $m[1];
                        } else {
                            $data[$index] = (int) $m[1];
                            $index = null;
                        }

                        $broken = preg_replace($re, '', $broken);
                    }
                break;

                case 'b:':
                    $re = '/^b:[01];/';
                    if (preg_match($re, $broken, $m)) {

                        $data[$index] = (bool) $m[1];
                        $index = null;
                        $broken = preg_replace($re, '', $broken);
                    }
                break;

                case 'a:':
                    $re = '/^a:\d+:\{/';
                    if (preg_match($re, $broken, $m)) {
                        $broken         = preg_replace('/^a:\d+:\{/', '', $broken);
                        $data[$index]   = cloudfw_fix_serialize_method_2_callback($broken);
                        $index = null;
                    }
                break;

                case 'N;':
                    $broken = substr($broken, 2);
                    $data[$index]   = null;
                    $index = null;
                break;
            }
        }
    }

    return $data;
}

/**
 *	Format Text in some Composer Widgets
 *
 *	@since 1.0
 */
function cloudfw_inline_format( $content ){
	$content = wptexturize( $content );
	$content = wpautop( $content );

	return $content;
}

function cloudfw_pre_process_shortcode( $content ) {
	global $cloudfw_pre_do_shortcodes, $shortcode_tags, $orig_shortcode_tags;

	// Backup current registered shortcodes and clear them all out
	$orig_shortcode_tags = $shortcode_tags;
	remove_all_shortcodes();

	foreach ((array)$orig_shortcode_tags as $shortcode => $callback) {
		if ( in_array($shortcode, $cloudfw_pre_do_shortcodes) ) {
			add_shortcode( $shortcode, $callback );
		}
	}

	// Do the shortcode (only the selected shortcodes)
	$content = do_shortcode($content);

	// Put the original shortcodes back
	$shortcode_tags = $orig_shortcode_tags;

	return $content;
}
add_filter('the_content', 'cloudfw_pre_process_shortcode', 7);


/**
 *	Video Embed
 *
 *	@since 1.0
 */
function cloudfw_video_embed( $atts, $content ) {
	extract(shortcode_atts(array(
		'url' 		=> '',
		'autoplay' 	=> 0,
	), _check_onoff_false($atts)));

	if ( !empty($content) )
		return $content;

	if ( empty( $url ) )
		return cloudfw_error_message(__('Please insert an url to embed the video','cloudfw'));

	$result =  wp_oembed_get( $url );

	if ( $result === false ) {
		return false;
	}

	$autoplay = _check_onoff( $autoplay ) === true ? 1 :0;

	if ( !strpos($url, 'youtube') == false || !strpos($url, 'youtu.be') == false  ) {
		$pattern = '#(youtube.com/embed/)(.*)\?#i';
		$args = array(
			'wmode'          => 'transparent',
			'vq'             => 'hd1080',
			'rel'            => 0,
			'showinfo'       => 0,
			'iframe'         => 1,
			'fs'             => 1,
			'modestbranding' => 0,
			'autoplay'       => $autoplay,
			'theme'          => 'dark',
		);

	} elseif ( !strpos($url, 'vimeo') == false ) {
		$pattern = '#(player.vimeo.com/video/)([0-9]*)(\??)#i';
		$args = array(
			'wmode'          => 'transparent',
			'fullscreen'     => 1,
			'title'          => 0,
			'byline'         => 0,
			'portrait'       => 0,
			'autoplay'       => $autoplay,
			'color'          => cloudfw_get_skin_value( 'accent', 'gradient', 1 ),
		);

	} elseif ( !strpos($url, 'dailymotion') == false ) {
		$pattern = '#(dailymotion.com/embed/video/)([A-Za-z0-9]+)(\??)#i';
		$args = array(
			'wmode'          => 'transparent',
			'fullscreen'     => 1,
			'hideInfos'      => 1,
			'expandVideo'    => 1,
			'related'  		 => 0,
			'logo'  		 => 0,
			'autoPlay'       => $autoplay,
			'forcedQuality'  => 'hd1080',
			'background'  	 => '333333',
			'foreground'  	 => 'FFFFFF',
			'highlight'  	 => 'FFFFFF',
		);

	}

	if ( (isset($pattern) && $pattern) && (isset($args) && $args) ) {
		$result = cloudfw_video_embed_codes( $result, $pattern, $args );
	}

	/*echo '<pre>';
	 var_dump($url);
	 var_dump($pattern);
	 var_dump($args);
	 var_dump($result);
	echo '</pre>';*/

	return $result;

}

/**
 *	CloudFw - Get Home URL
 *
 *	@since 1.0
 */
function cloudfw_home_url( $type = NULL  ){
	if ( $type == 1 )
		return home_url();

	if ( cloudfw_is_multisite() )
		return get_blogaddress_by_id(1);
	else
		return home_url();
}

/**
 *	Get Base Directory
 *
 * 	@return WordPress subdirectory if applicable
 *	@since 3.0
 */
function cloudfw_base_dir() {
	preg_match('!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches);
	if ( count($matches) === 3 ) {
		return end($matches);
	} else {
		return '';
	}
}

/**
 *	Excludes the site url from a folder url
 *
 *	@since 3.0
 */
function cloudfw_only_folder_url( $folder ){
	return str_replace( home_url(), '', $folder );
}

/**
 *	Add folder url
 *
 *	@since 3.0
 */
function cloudfw_add_folder_url( $folder ){
	return home_url().$folder;
}

/**
 *	Excludes the site path from a folder path
 *
 *	@since 3.0
 */
function cloudfw_only_folder_path( $folder ){
	return str_replace( TMP_PATH, '', $folder );
}

/**
 *	CloudFw - Get Template URL
 *
 *	@since 1.0
 */
 function cloudfw_get_template_url(){
	static $cloudfw_template_url;

	if ( empty( $cloudfw_template_url ) ){

		if ( cloudfw_is_multisite() ){
			$url = TMP_URL;

			/** Explode the URL */
			$exploded_url = explode( '/'. cloudfw_wp_content() .'/', $url );
			if( !empty( $exploded_url[1] ) )
				$url = untrailingslashit( get_blogaddress_by_id(1) ) . '/'. cloudfw_wp_content() .'/' . $exploded_url[1];

			$cloudfw_template_url = $url;

		} else
			$cloudfw_template_url = TMP_URL;

	}

	return $cloudfw_template_url;
 }

/**
 *	CloudFw - Get Custom Sidebars
 *
 *	@since 3.0
 */
function cloudfw_get_custom_sidebars(){
	global $cloudfw_custom_sidebars;

	if ( !isset( $cloudfw_custom_sidebars ) ) {
		$cloudfw_custom_sidebars = array();
		$custom_sidebars = cloudfw_get_option('custom_sidebars');
		$sidebars_ids = $custom_sidebars['id'];

		foreach ($sidebars_ids as $i => $sidebar_id) {
			if ( empty($sidebar_id) || empty($custom_sidebars['name'][$i]) )
				continue;

			$cloudfw_custom_sidebars[$custom_sidebars['id'][$i]] = array(
				'id'   => $sidebar_id,
				'name' => $custom_sidebars['name'][$i],
				'desc' => $custom_sidebars['desc'][$i],
			);
		}

	}

	return $cloudfw_custom_sidebars;
}

/**
 *	CloudFw - Check Sidebar Exists
 *
 *	@since 3.0
 */
function cloudfw_custom_sidebar_exists( $sidebar ){
	$custom_sidebars = cloudfw_get_custom_sidebars();
	return isset( $custom_sidebars[$sidebar] );
}

/**
 *	CloudFw Set Javascript Option
 *
 *	@since 1.0
 */
 function cloudfw_set_js( $option, $value='', $single = false ) {
	global $cloudfw_js_options;
	return $cloudfw_js_options[$option] = array('val' => $value, 'single' => $single);
 }

/**
 *	CloudFw Set Javascript Option
 *
 *	@since 1.0
 */
 function cloudfw_get_js( $option ) {
	global $cloudfw_js_options;
	return $cloudfw_js_options[$option];
 }


/**
 *	CloudFw Get All Javascript Options
 *
 *	@since 1.0
 */
 function cloudfw_get_all_js() {
	global $cloudfw_js_options;
	return $cloudfw_js_options;
 }


/**
 *	CloudFw Render Javascript Options
 *
 *	@since 1.0
 */
function cloudfw_render_js_options(){

	$out = array();
	if ( $options = cloudfw_get_all_js() ):
		foreach( $options as $option => $value ) {
			$out[ $option ] = is_int( $value['val'] ) ? (int) $value['val'] : $value['val'];
		}
	endif;
	wp_localize_script('jquery', 'CloudFwOp', $out);

}

/**
 *	CloudFw Cufon Init
 *
 *	@since 1.0
 */
function cloudfw_cufon_init() {
	echo '<script type=\'text/javascript\'>	Cufon.now(); </script>';
}

/**
 *	Combine Versions
 *
 *	@since 1.0
 */
 function cloudfw_get_combined_version() {
	global $cloudfw_combined_version;

	if ( !empty($cloudfw_combined_version) )
		return $cloudfw_combined_version;

	return $cloudfw_combined_version = CLOUDFW_THEMEVERSION;
 }

/**
 *  Facebook Like Count
 *
 *  @since 1.0
 */
function cloudfw_facebook_like_counter($page = '', $force= false, $expiration = 3600){

	if ( empty( $page ) )
		return false;

	if ( !is_numeric( $expiration ) || !($expiration > 60) )
		$expiration = 3600;

	$key = PFIX . '_facebook_like_count_' . $page;

	$followers_count = get_transient($key);
	if ($followers_count !== false && !$force)
		return ''.$followers_count;
	else {
		$response = wp_remote_get('http://graph.facebook.com/'. urlencode( $page ));
		if (is_wp_error($response))
			return get_option($key);

		else {
			$json = json_decode(wp_remote_retrieve_body($response));
			$count = intval($json->likes);

			if (! ($count > 0) )
				return get_option($key);

			set_transient($key, $count, $expiration);
			update_option($key, $count);
			return $count;
		}
	}

}

/**
 *  Twitter Follower Counter
 *
 *  @since 1.0
 */
function cloudfw_twitter_followers_counter($screen_name = '', $force= false, $expiration = 3600){

	if ( empty( $screen_name ) )
		return false;

	if ( !is_numeric( $expiration ) || !($expiration > 60) )
		$expiration = 3600;

	$key = PFIX . '_twitter_like_count_' . $screen_name;

	$followers_count = get_transient($key);
	if ($followers_count !== false && !$force)
		return ''.$followers_count;
	else {
		$response = wp_remote_get("http://api.twitter.com/1/users/show.json?screen_name={$screen_name}");
		if (is_wp_error($response))
			return get_option($key);

		else
		{
			$json = json_decode(wp_remote_retrieve_body($response));
			$count = intval($json->followers_count);

			if (! ($count > 0) )
				return get_option($key);

			set_transient($key, $count, $expiration);
			update_option($key, $count);
			return $count;
		}
	}
}


/**
 *	CloudFw Loop Multi Framework Options
 *
 *	@since 3.0
 */
function cloudfw_core_loop_multi_option( $args = array() ){
	extract( cloudfw_make_var(
		array(
		'start'			=> 5,
		'indicator' 	=> array(),
		'data' 			=> array(),
		'before' 		=> array(),
		'after' 		=> array(),
		'append' 		=> array(),
		'prepend' 		=> array(),
	), $args) );

	if( !is_array($indicator) )
		$indicator = array();

	$count = count($indicator);
	$final_data = array();

	if ( !empty($before) && is_array($before) ){
		$final_data[$start] = $before;
		$start++;
	}

	if ( ($count > 0) ){
		foreach ($indicator as $i => $dummy) {
			$final_data[$start] = cloudfw_core_loop_get_value($i, $data);
			$start++;
		}
	} else {
		$final_data[$start] = $data;
		$start++;
	}

	if ( !empty($after) && is_array($after) ){
		$final_data[$start] = $after;
		$start++;
	}

	if ( is_array($prepend) ){
		foreach ($prepend as $prepend_id => $prepend_element) {
			array_unshift($final_data, $prepend_element);
		}
	}

	if ( is_array($append) ){
		foreach ($append as $append_id => $append_element) {
			array_push($final_data, $append_element);
		}
	}


	return $final_data;

}

/**
 *	Get Value for Loops
 *
 *	@since 1.0
 */
function cloudfw_core_loop_get_value( $i, $data = array() ){

	foreach ($data as $key => $value) {
		if ( $key === 'value' ) {
			if ( $data['type'] == 'gradient' ) {
				$data[$key] = array( $value[0][$i], $value[1][$i] );
			}
			else
				$data[$key] = isset($value[$i]) ? $value[$i] : NULL;

		}
		elseif ( is_array($value) )
			$data[$key] = cloudfw_core_loop_get_value($i, $value);
	}

	return $data;

}

/**
 *	Generates class name for device types
 *
 *	@since 1.0
 */
function cloudfw_visible( $device, $extra_class = '', $space = true ) {
	$class = '';
	switch ($device) {
		default:
		case 'all':
			$class = '';
			break;
		case 'widescreen':
		case 'desktop':
		case 'desktops':
			$class = 'visible-desktop';
			break;
		case 'desktop-tablet':
		case 'tablet-desktop':
			$class = 'hidden-phone';
			break;
		case 'tablet':
		case 'tablets':
			$class = 'visible-tablet';
			break;
		case 'tablet-phone':
		case 'tablet-phones':
		case 'phone-tablet':
		case 'phones-tablet':
			$class = 'hidden-desktop';
			break;
		case 'phone':
		case 'phones':
			$class = 'visible-phone';
			break;
	}

	if ( !empty($extra_class) )
		$class .= (!empty($class) ? ' ' : '' ) . $extra_class;

	if ( !empty($class) && $space )
		$class .= ' ';

	return $class;

}

/**
 *	Generates responsive attribute via HTML data- attribute
 *
 *	@since 1.0
 */
function cloudfw_json_attribute( $attribute, $options = array(), $echo = TRUE ){
	if ( empty($options) )
		return;

	$json_options = htmlspecialchars( json_encode( $options ), ENT_NOQUOTES );

	$out = cloudfw_make_attribute( array( $attribute => $json_options  ), FALSE );

	if ( $echo )
		echo $out;

	return $out;
}

/**
 *	Generates responsive options via HTML data- attribute
 *
 *	@since 1.0
 */
function cloudfw_responsive_options( $options = array(), $echo = TRUE ){
	return cloudfw_json_attribute( 'data-responsive', $options, $echo);
}

/**
 *	Get Page Content
 *
 *	@since 1.0
 */
function cloudfw_get_page_content( $id, $before = '', $after = '' ){

	if ( empty( $id ) ) {
		return '';
	}

	global $post;
	$tmp_post = $post;

	$out = '';
	$args = array(
		'showposts'	 		=>	'1',
		'page_id'			=>	$id
	);

	$posts = new WP_Query( $args );
	if( $posts->have_posts()) : while( $posts->have_posts() ) : $posts->the_post();
		$out = cloudfw_composer_the_content( __t( get_the_content() ), get_the_ID() );
	endwhile; endif;

	$post = $tmp_post;
	wp_reset_query();

	if ( !empty( $out ) ) {
		return $before . $out . $after;
	} else {
		return '';
	}

}

/**
 *	Human readable time function.
 *
 *	@since 1.0
 */
function cloudfw_time_humanreadble( $ptime ){
	$etime = time() - $ptime;

	if ($etime < 1)
	{
		return __('Now','cloudfw');
	}

	if ( cloudfw_vc_isset( __FUNCTION__, 'algorithm' ) ) {
		$algorithm = cloudfw_vc_get( __FUNCTION__, 'algorithm' );
	} else {
		$algorithm = cloudfw_vc_set( __FUNCTION__, 'algorithm',
			array(
				12 * 30 * 24 * 60 * 60  =>  array( cloudfw_translate( 'time_years' ), cloudfw_translate( 'time_year' ) ),
				30 * 24 * 60 * 60       =>  array( cloudfw_translate( 'time_months' ), cloudfw_translate( 'time_month' ) ),
				24 * 60 * 60            =>  array( cloudfw_translate( 'time_days' ), cloudfw_translate( 'time_day' ) ),
				60 * 60                 =>  array( cloudfw_translate( 'time_hours' ), cloudfw_translate( 'time_hour' ) ),
				60                      =>  array( cloudfw_translate( 'time_minutes' ), cloudfw_translate( 'time_minute' ) ),
				1                       =>  array( cloudfw_translate( 'time_seconds' ), cloudfw_translate( 'time_second' ) )
			)
		);
	}

	foreach ($algorithm as $secs => $str)
	{
		$d = $etime / $secs;
		if ($d >= 1)
		{
			$r = round($d);
			return sprintf( ($r > 1 ? $str[0] : $str[1]),  $r );
		}
	}
}

/**
 *	Makes layout if exists.
 *
 *	@since 1.0
 */
function cloudfw_make_layout( $type, $out, $atts = array() ){

	switch ($type) {
		case 'masonry':
			if ( class_exists('CloudFw_Composer_Masonry') ) {
				$obj = new CloudFw_Composer_Masonry();
				$out = $obj->shortcode( $atts, $out );
			}
			break;
		case 'carousel':
			if ( class_exists('CloudFw_Composer_Carousel') ) {
				$obj = new CloudFw_Composer_Carousel();
				$out = $obj->shortcode( $atts, $out );
			}
			break;
	}

	return $out;
}

/**
 * Makes shortcode string
 * @param  string $shortcode
 * @param  array  $atts
 * @param  string $content
 * @return string
 */
function cloudfw_do_shortcode( $shortcode, $atts = array(), $content = '' ){
	return do_shortcode(cloudfw_transfer_shortcode_attributes( $shortcode, $atts, $content ));
}