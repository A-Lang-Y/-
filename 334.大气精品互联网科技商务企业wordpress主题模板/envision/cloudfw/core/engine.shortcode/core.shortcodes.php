<?php

/** Register Globals for Shortcode API */
$GLOBALS['cloudfw_registered_shortcodes'] = array();
$GLOBALS['cloudfw_pre_do_shortcodes'] = array();

/**
 *	CloudFw Shortcodes API
 *
 *	@since 3.0
 */
class CloudFw_Shortcodes {
	public static  $groups;
	public static  $schemes;
	private static $shortcode_number = 0;
	private static $shortcode_number_in_group = array();

	//public static  $composer_element_map;
	public 		   $do_before   = true;
	public 		   $is_composer = false;
	public 		   $is_widget   = false;
	public 		   $widget;
	public static  $data;
	public static  $composer_groups;
	public static  $composer_schemes;
	public static  $composer_schemes_data;
	private static $composer_number = 0;
	private static $composer_number_in_group = array();

	public static  $shortcode_vars;

	/**
	 *	Register
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	function __construct() {}
	
	/**
	 *	Register
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function _register( $class = NULL, $shortcode = NULL, $group = NULL, $spec_line = NULL ) {
		$called_class = $this->get_called_class();

		if ( is_admin() ) {
			if ( class_exists( $called_class . '_Admin' ) )
				$called_class .= '_Admin'; 
		}

		if ( !class_exists($called_class) ) {
			return;
		}

		if ( in_array($called_class, $GLOBALS['cloudfw_registered_shortcodes'] ) ) 
			return;
		else
			$GLOBALS['cloudfw_registered_shortcodes'][] = $called_class;

		if ( is_admin() ) {

			/** Check if the shortcode has admin scheme */
			if ( method_exists($this, 'scheme') ){

				if ( $group ) {
					
					self::$shortcode_number++;
					$group_id = $this->group_id($group); 

					if ( !isset( self::$shortcode_number_in_group[ $group_id ] ) )
						self::$shortcode_number_in_group[ $group_id ] = 0;

					if ( isset( $spec_line ) )
						self::$shortcode_number_in_group[ $group_id ] = $spec_line;

					$line = self::$shortcode_number_in_group[ $group_id ];

					while ( isset( self::$schemes[ $group_id ][ 'data' ][ $line ] ) ){
						self::$shortcode_number_in_group[ $group_id ]++;
						$line = self::$shortcode_number_in_group[ $group_id ];
					}

					self::$schemes[ $group_id ][ 'data' ][ $line ] = $this->data_prepare( $this->scheme() );

				}

			}


			/** Add the shortcode to the composer list */
			$composer_settings = $this->composer(); 
			if ( $composer_settings['composer'] === true ) {

				if ( method_exists($this, 'composer_scheme') )
					$composer_scheme = $this->composer_scheme();
				elseif ( method_exists($this, 'scheme') )
					$composer_scheme = $this->scheme();
				else
					$composer_scheme = false; 


				/** Check Scheme */
				if ( $composer_scheme ) {

					self::$composer_number++;
					$composer_group_id = $this->composer_group_id( $composer_settings['group'] ); 

					if ( !isset( self::$composer_number_in_group[ $composer_group_id ] ) )
						self::$composer_number_in_group[ $composer_group_id ] = 0;

					if ( isset( $composer_settings['line'] ) )
						self::$composer_number_in_group[ $composer_group_id ] = $composer_settings['line'];

					$composer_line = self::$composer_number_in_group[ $composer_group_id ];

					while ( isset( self::$composer_schemes[ $composer_group_id ][ 'data' ][ $composer_line ] ) ){
						self::$composer_number_in_group[ $composer_group_id ]++;
						$composer_line = self::$composer_number_in_group[ $composer_group_id ];
					}

					//self::$composer_schemes[ $composer_group_id ][ 'data' ][ $composer_line ] = $class;
					self::$composer_schemes[ $composer_group_id ][ 'data' ][ $composer_line ] = $this->composer_title_prepare( $class, $composer_scheme );
					
					if ( method_exists($this, 'scheme') )
						self::$composer_schemes_data[ $composer_group_id ][ 'data' ][ $composer_line ] = $this->composer_data_prepare( $class, $this->scheme() );

					unset( $composer_scheme );

				}

			}

			/** Add skinable options for the shortcode */
			if ( method_exists($this, 'skin_scheme') && function_exists('cloudfw_add_skin_scheme') )
				add_filter( 'cloudfw_schemes_skin', array( &$this, 'skin_scheme' ), 10, 2 );

			if ( method_exists($this, 'typo_scheme') )
				add_filter( 'cloudfw_typo_scheme', array( &$this, 'typo_scheme' ), 10, 3 );

		} else {
			global $cloudfw_pre_do_shortcodes;

			/** Detect register method for the shortcode */
			if ( method_exists($this, 'register') ) {
				$shortcodes = $this->register();
				foreach ($shortcodes as $shortcode) {
					add_shortcode( $shortcode, array( &$this, 'shortcode' ) );
					if ( $this->do_before ) {
						$cloudfw_pre_do_shortcodes[] = $shortcode;
					}
				} 
			}
			elseif ( method_exists($this, 'add') ) {
				$shortcodes = $this->add();
				foreach ($shortcodes as $shortcode => $callback) {
					add_shortcode( $shortcode, $callback );
					if ( $this->do_before ) {
						$cloudfw_pre_do_shortcodes[] = $shortcode;
					}
				} 
			}
			elseif ( $shortcode ) {
				add_shortcode( $shortcode, array( &$this, 'shortcode' ) );
				if ( $this->do_before ) {
					$cloudfw_pre_do_shortcodes[] = $shortcode;
				}
			}

		}
		
		if ( method_exists($this, 'skin_map') ) {
			add_filter( 'cloudfw_skin_map_object', array( &$this, 'skin_map' ) );
		}

		if ( method_exists($this, 'typo_map') ) {
			add_filter( 'cloudfw_typo_map_object', array( &$this, 'typo_map' ) );
		}

	}

	/**
	 *	Get Scheme
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function get_scheme() {
		$schemes = self::$schemes;
		$groups  = self::$groups;
		$groups  = $this->group_prepare( $groups );
		return cloudfw_array_merge( $groups,  $schemes );
	}

	/**
	 *	Register Group
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function group_register( $key, $line, $data ) {
		$data[ 'type' ]   = 'shortcode:group';
		$data[ 'number' ] = $line;
		$data[ 'id' ]  	  = $key;
		return self::$groups[ $key ] = $data;
	}

	/**
	 *	Detect Group ID
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	private function group_id( $key ) {
		$groups = self::$groups;
		return isset($groups[ $key ][ 'number' ]) ? $groups[ $key ][ 'number' ] : NULL;
	}

	/**
	 *	Prepare Group
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	private function group_prepare() {
		$groups_raw = self::$groups;
		$groups = array();

		foreach ((array) $groups_raw as $key => $data)
			$groups[ $data['number'] ] = $data;

		return $groups;

	}

	/**
	 *	Prepare Data
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	private function data_prepare( $data ) {
		$data['type'] = 'shortcode:sub';
		$data['id']   = 'sc_' . self::$shortcode_number;
		return (array) $data;

	}

	/**
	 *	Composer
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function composer(){
		return false;
	}

	/**
	 *	Get Composer Scheme
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function get_composer_scheme() {
		$schemes = self::$composer_schemes;
		$composer_groups  = self::$composer_groups;
		$composer_groups  = $this->composer_group_prepare( $composer_groups );
		return cloudfw_array_merge( $composer_groups,  $schemes );
	}

	/**
	 *	Get Composer Data
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function get_composer_data() {
		$schemes = self::$composer_schemes_data;
		$composer_groups  = self::$composer_groups;
		$composer_groups  = $this->composer_group_prepare( $composer_groups );
		return cloudfw_array_merge( $composer_groups,  $schemes );
	}


	/**
	 *	Register Composer Group
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function composer_group_register( $key, $line, $data ) {
		$data[ 'type' ]   = 'composer:group';
		$data[ 'number' ] = $line;
		$data[ 'id' ]  	  = $key;
		return self::$composer_groups[ $key ] = $data;
	}

	/**
	 *	Detect Composer Group ID
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	private function composer_group_id( $key ) {
		$composer_groups = self::$composer_groups;
		return $composer_groups[ $key ][ 'number' ];
	}

	/**
	 *	Prepare Composer Group
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	private function composer_group_prepare() {
		$composer_groups_raw = self::$composer_groups;
		$composer_groups = array();

		foreach ((array) $composer_groups_raw as $key => $data)
			$composer_groups[ $data['number'] ] = $data;

		return $composer_groups;

	}

	/**
	 *	Prepare Composer Titles
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function composer_title_prepare( $class, $data ) {
		$title = array();
		$title['composer_id'] = $class;
		$title['type'] 		= 'composer:sub';
		$title['id']        = 'composer-' . self::$composer_number;
		$title['number']    = self::$composer_number;
		$title['composer']  = $this->composer();


		return (array) $title;
	}

	/**
	 *	Prepare Composer Data
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function composer_data_prepare( $class, $data ) {
		$data['composer_id'] = $class;
		$data['type']      = 'composer:sub';
		$data['id']        = 'composer-' . self::$composer_number;
		$data['number']    = self::$composer_number;
		$data['composer']  = $this->composer();

		return (array) $data;
	}

	/**
	 *	Set Composer Data
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function set_data( $data ){
		self::$data = $data; 
	}

	/**
	 *	Get Value
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function get_value( $key, $default = '' ){
		if ( $this->is_composer || $this->is_widget ) {
			if ( isset(self::$data[ $key ]) && (!empty( self::$data[ $key ] ) || self::$data[ $key ] === '0' || self::$data[ $key ] === 0 ))
				return self::$data[ $key ];
			else
				return $default;

		}
		else
			return $default;
	}

	/**
	 *	Get Filed Name
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function get_field_name( $key ){
		if ( $this->is_widget ) {
			if ( $this->widget )
				return $this->widget->get_field_name($key);
			else
				return $key;
		
		} else {
			return $key;
		}
	}

	/**
	 *	Load Scheme File
	 *
	 *	@package CloudFw
	 *	@since 3.1
	 */
	public function load_scheme( $filepath ) {
		return is_admin() ? array(
			array(
				'type'		=>	'scheme',
				'source'	=>	$filepath,
				'this'		=>	$this
			)
		) : NULL; 
	}


}

/**
 *	CloudFw Register Shortcode
 *
 *	@since 3.0
 */
function cloudfw_register_shortcode( $class ){
	global $cloudfw_shortcodes_to_load,
		   $cloudfw_shortcodes_double_load;

	if ( isset( $cloudfw_shortcodes_to_load[ $class ] ) )
		$cloudfw_shortcodes_double_load[] = $class;

	$cloudfw_shortcodes_to_load[ $class ] = array_slice( func_get_args(), 1 );
}

/**
 *	CloudFw Load Shortcodes
 *
 *	@since 3.0
 */
function cloudfw_load_shortcodes(){
	global $cloudfw_shortcodes_to_load;

	foreach ((array) $cloudfw_shortcodes_to_load as $class => $vars) {
		if ( class_exists( $class ) ) {
			$cloudfw_shortcodes = new $class;
			$var_0 = isset($vars[0]) ? $vars[0] : NULL;
			$var_1 = isset($vars[1]) ? $vars[1] : NULL;
			$var_2 = isset($vars[2]) ? $vars[2] : NULL;

			$cloudfw_shortcodes->_register( $class, $var_0, $var_1, $var_2 );
		}
	}	
}

/**
 *****************************************
 *	Only Admin Functions
 *****************************************
 */

if (is_admin()):

/**
 *	CloudFw Debug Shortcodes
 *
 *	@since 3.0
 */
function cloudfw_debug_shortcodes(){
	global $cloudfw_shortcodes_to_load,
		   $cloudfw_shortcodes_double_load;

	echo 'Double Shortcodes: ' . count($cloudfw_shortcodes_double_load);
	echo '<pre>';
	 print_r($cloudfw_shortcodes_double_load);
	echo '</pre>';

	echo 'Total Shortcodes: ' . count($cloudfw_shortcodes_to_load);
	echo '<pre>';
	 print_r($cloudfw_shortcodes_to_load);
	echo '</pre>';

}

/**
 *	CloudFW Shortcode Generator - Functions
 *	
 *	@since 1.0
 */

 function cloudfw_render_shortcodes( $items, $shortcode_map ) {
 	if ( !is_array($items) )
 		return '';
 	
 	ksort($items);

 	$shortcode_block = '';
 	$shortcode_items = array();

 	$shortcode_items['NULL'] = '';

	 	foreach ($items as $item_id => $item) {

	 		if (is_array( $item['sub'] ))
	 			ksort( $item['sub'] );

	 		if ( $item['_optgroup'] ) {
	 			if ( empty($item['sub']) )
	 				continue;

	 			$shortcode_items[ $item['_title'] ] = array(); 

	 				foreach ((array) $item['sub'] as $sub_item_id => $sub_item) {
	 					$shortcode_items[ $item['_title'] ][ $sub_item['_id'] ] = $sub_item['_title']; 
	 				}
	 		} else {
				$shortcode_items[ $item['_id'] ] = $item['_title']; 
	 		}

	 	}

	admin_create_selectlist(array(
        'id'                => 'cloudfw_shortcode_selector',
        'items'             => $shortcode_items,
        'type'              => 'select',
        'main_class'        => 'cloudfw-ui-select',
        'main_select_class' => 'input input_250',
        'ui'                => true,
        'width'             => '250',
	));

 	echo '<div id="shortcode-loading" class="float-loading" style="display:none;"></div> <div class="clear"></div>';

 }


/**
 *	Shortcodes Render Scripts
 *
 *	@since 1.0
 */
function cloudfw_render_shortcodes_javascript_elements($div_parent, $data = array(), $final_render = '', $custom_out = NULL, $custom_div_id = NULL, $custom_parent = NULL ){
	
	if ( !is_array($data) ) {
		return;
	}
	
	$i = (int) 0;
	ksort($data);

	if ( isset($custom_out) && $custom_out ) {
		$out = $custom_out; 
	} else {
		$out = 'out'; 
	}
	
	foreach ( $data as $data_number => $datas ): $i++;
		
		$render = $render_head = $render_footer = '';

		$datas['type'] = isset($datas['type']) ? $datas['type'] : NULL;
		$type = isset($force_type) && $force_type ? $force_type : $datas['type'];

		if ( isset($datas['script']) && is_array($datas['script']) ):
			$is_manual = false;

			if ( isset($datas['parent']) && $datas['parent'] ) {
				$id = $datas['parent'];
			} elseif ( isset($datas['id']) && $datas['id'] ) {
				$id = $datas['id'];
			} else {
				$id = '';
			}
			
			if ( isset($custom_div_id) && $custom_div_id ) {
				$div_id = $custom_div_id;
			} else {
				$div_id = 'cloudfw_shortcode_div_' . $id;
			}

			if ( !is_string($datas['id']) ) {
				continue;
			}

			$the_shortcode_var = isset($custom_out) && $custom_out ? 'the_shortcode_' . $custom_out : 'the_shortcode'; 

			if ( !isset($custom_out) || !$custom_out ) {
				$render_head = "\n\n\ncase '". esc_attr( $div_id ) ."':\n";
			}

				if ( isset($datas['script']['shortcode']) && is_array( $datas['script']['shortcode'] ) ) {

					foreach ( (array) $datas['script']['shortcode'] as $shortcode ) {
						$render .= "\nif ( jQuery('#".$div_id."', '#{$div_parent}').find('#".$shortcode[0]."').val() "._if( !empty($shortcode[3]), $shortcode[3], '==' )." '".$shortcode[1]."' ) {";

						if ( $shortcode[4] !== 'manual' ):
							$render .= "\nvar {$the_shortcode_var} = '".$shortcode[2]."'; }\n";
						else:
							$is_manual = true;
							$render .= "\n{$out} += '". $shortcode[2] ."'; }\n";
						endif;
					}

				} elseif ( isset($datas['script']['shortcode:sync']) && $datas['script']['shortcode:sync'] ) {

					$render .= "\nvar {$the_shortcode_var} = jQuery('#". $div_id ."', '#{$div_parent}').find('#". $datas['script']['shortcode:sync'] ."').val();\n";

				} else {

					$the_shortcode = isset($datas['script']['shortcode']) ? $datas['script']['shortcode'] : NULL;
					$render .= "\nvar {$the_shortcode_var} = '". $the_shortcode ."';\n";

				}

				if ( !isset($is_manual) || !$is_manual ) {

					$render .= "\nif ( {$the_shortcode_var} == '' )\n\treturn false;\n";

					if ( isset($datas['script']['tag_newline']) && $datas['script']['tag_newline'] ) {
						$render .= "\n{$out} += ''+\$nl+'';";
					}

					if ( !isset( $datas['script']['tag_newline_default'] ) || $datas['script']['tag_newline_default'] ) {
						$render .= "\n{$out} += ''+\$nl+'';";
					}

					if ( isset($datas['script']['prepend'] ) && $datas['script']['prepend'] ) {
						$render .= "\n{$out} += '". $datas['script']['prepend'] ."';";
					}

					$render .= "\n{$out} += '[';";
					$render .= "\n{$out} += {$the_shortcode_var};\n";

					/*Attributes*/
					$render .= cloudfw_prepare_shortcodes_javascript_attributes($div_parent, $datas, $div_id, $custom_out, $custom_parent );

					if ( isset($datas['script']['tag_newline']) && $datas['script']['tag_newline'] ) {
						$render .= "\n{$out} += ''+\$nl+'';";
					}

					if ( isset($datas['script']['tag_close']) && $datas['script']['tag_close'] ) {
						$render .= "\n{$out} += '[/' + {$the_shortcode_var} + ']';";
					} else {
						$render .= "\n{$out} += ']';";
					}

				}

				if ( isset($datas['script']['append']) && $datas['script']['append'] ) {
					$render .= "\n{$out} += '". $datas['script']['append'] ."';";
				}

				if ( !isset( $datas['script']['tag_newline_default'] ) || $datas['script']['tag_newline_default'] ) {
					$render .= "\n{$out} += ''+\$nl+'';";
				}

			if ( !isset($custom_out) || !$custom_out ) {
				$render_footer = "\n\nbreak;\n\n\n";
			}

		if ( $custom_out ) {
			return $render;

		} else {

			$final_render[$id][] = array(
				'head'	=> $render_head,
				'body'	=> $render,
				'footer'=> $render_footer
			);

		}

		endif;

		//$final_render[$id] = isset( $final_render[$id] ) ? $final_render[$id] . $render : $render;

		if ( isset($datas['data']) && is_array($datas['data']) ) {
			$final_render = cloudfw_render_shortcodes_javascript_elements($div_parent, $datas['data'], $final_render, $custom_out );
		}

	endforeach;

	return $final_render;
	
}

/**
 *	Prepare Shortcodes Attributes
 *
 *	@since 1.0
 */
function cloudfw_prepare_shortcodes_javascript_attributes( $div_parent, $data = array(), $div_id, $custom_out = NULL, $custom_parent = NULL  ){
	
	if ( !isset( $data['script']['attributes'] ) || !is_array($data['script']['attributes'] ) )
		return '';

	$pfix = 'sc_val_';
	if ( isset($custom_out) && $custom_out ) {
		$out = $custom_out; 
	} else {
		$out = 'out'; 
	}

	$render = '';

	foreach( $data['script']['attributes'] as $attribute => $options ) {
			
		if ( !isset($options['multi']) )
			$options['multi'] = FALSE;

		if ( (!isset($options['e']) || !$options['e']) && ( !isset($options['multi']) || !$options['multi']) ){
			continue;
		}

		if ( isset($options['attribute']) && $options['attribute'] ) {
			$attribute = $options['attribute'];
		}

		if ( isset($options['multi']) && $options['multi'] ) {
			$var_attribute = $pfix.$options['multi'];
			$the_parent_element = "this";
			$the_element_selector = "jQuery(".$the_parent_element.")";

			if ( !isset($options['check_visiblity']) || $options['check_visiblity'] )
				$render .= "\n\tif ( jQuery('#".$div_id."', '#{$div_parent}').find('#".$options['e']."').parents('.module').first().is(':visible') ) {";
			
			$render .= "\n".$var_attribute." = ''; ".$var_attribute."_total = '';";
			$render .= "\n\t
				".$options['multi']."_array = jQuery('#".$div_id."', '#{$div_parent}').find('.".$options['multi']."');
				".$options['multi']."_count = ".$options['multi']."_array.length;
				".$options['multi']."_array.each(function(i){
				\n\n".$var_attribute." = '';
			\n";

		} else {

			$var_attribute = $pfix.$options['e']."";

			if ( $custom_parent ){
				$the_parent_element = "this";
				$the_element = "'#".$options['e']."'";

			} else {
				$the_parent_element = "'#". $div_id ."', '#{$div_parent}'";
				$the_element = "'#". $options['e'] ."'";
			}

			$the_element_selector = "jQuery(". $the_parent_element .").find(". $the_element .")";

			if ( !isset($options['check_visiblity']) || $options['check_visiblity'] ) {
				$render .= "\n\tif ( ". $the_element_selector .".parents('.module').first().is(':visible') ) {";
			}
			
		}


		/* Element Type */
		if ( !isset($options['onoff']) || !$options['onoff'] ){
			
			//$render .= "\n\t".$var_attribute." "._if($options['multi'], '+')."= ". $the_element_selector .".val()";
			$render .= "\n\t".$var_attribute." ";
			if ( isset($options['multi']) && $options['multi'] ) {
				$render .= '+';
			}
			$render .= "= ". $the_element_selector .".val()";
			
			if ( ( $attribute !== 'content' ) && ( !isset( $options['array'] ) || $options['array'] ) ):
			
				$render .= ".split('\"').join('')";
				if( isset($options['replace']) && is_array($options['replace']) ) {
					foreach ($options['replace'] as $bad_key => $replace_to) {
						$render .= ".split(\"$bad_key\").join(\"$replace_to\")";
					}
				}
			endif;


			$render .= ";";

		} else {
			$render .= "\n\tvar ".$var_attribute." = jQuery(".$the_parent_element.").find('#".$options['e'].":checked').val() !== undefined ? '1' : '0';";
		}
				
		/* Check if null */
		if ( isset($options['check-null']) && $options['check-null'] )
			$render .= "\n\tif( !(".$var_attribute.") )\n\t".$var_attribute." "._if($options['multi'], '+')."= '';";

		/* Check if default */
		if ( isset($options['check-default']) )
			$render .= "\n\tif( ".$var_attribute." == '".$options['check-default']."' )\n\t".$var_attribute." "._if($options['multi'], '+')."= '';";

		/* Default if empty */
		if ( isset($options['default']) )
			$render .= "\n\tif(".$var_attribute." == '')\n\t".$var_attribute." "._if($options['multi'], '+')."= '".esc_attr($options['default'])."';";

		/* Is required? */
		if ( !empty($options['required']) ) {
			if ( is_array( $options['required'] ) && isset($options['required']['custom']) ) {
				$required_variable = _if( $options['multi'], 'pre_after_render', 'render' );
				$$required_variable .= "\n\tif( ".$options['required']['custom']." )";	
			} else {	
				$required_variable = 'render';
				$$required_variable .= "\n\tif((".$var_attribute." == '' || typeof ".$var_attribute." == 'undefined') ";
				if ( is_array($options['required'] ) ) {
					$$required_variable .= "&& (jQuery('#{$div_parent}').find('#".$options['required']['e'];
					if ( $options['required']['onoff'] ) {
						$$required_variable .= ':checked';
					}
					$$required_variable .= "').val() ";
					if ( $options['required']['operator'] ) {
						$$required_variable .= $options['required']['operator'];
					} else {
						$$required_variable .= '==';
					}
					$$required_variable .= " ";
					
					if ( isset( $options['required']['auto-colon']) && !$options['required']['auto-colon'] )
						$$required_variable .=  $options['required']['value'];
					else
						$$required_variable .=  "'".$options['required']['value']."'";

				$$required_variable .= ")";
				}
				$$required_variable .= ")";
			}

			$$required_variable .= "{\n\t\t	cloudfw_error_message_js('"; 
			$$required_variable .= esc_attr((is_array( $options['required'] ) && isset($options['required']['message'])) ? $options['required']['message'] : $options['required']);
			$$required_variable .= "');";
			$$required_variable .= $the_element_selector .".parents('.module').first().addClass('hasError'); return false;";
			$$required_variable .= "}";

		}
		
		/* Prepend */
		if ( isset($options['prepend']) ) {
			if ( is_array($options['prepend']) )
				$render .= "\n\tif(".$var_attribute." != '' && jQuery('#{$div_parent}').find('#".$options['prepend']['e']."', '#".$div_id."').length > 0 )\n\t\t\t".$var_attribute." = jQuery('#{$div_parent}').find('#".$options['prepend']['e']."', '#".$div_id."').val() + ".$var_attribute.";\n";
			else 
				$render .= "\n\tif(".$var_attribute." != '')\n\t\t\t".$var_attribute." = '".$options['prepend']."' + ".$var_attribute.";\n";			
		}
		
		/* Append */
		if ( isset($options['append']) ) {
			if ( is_array($options['append']) )
				$render .= "\n\tif(".$var_attribute." != '' && jQuery('#{$div_parent}').find('#".$options['append']['e']."', '#".$div_id."').length > 0 )\n\t\t\t".$var_attribute." += jQuery('#{$div_parent}').find('#".$options['append']['e']."', '#".$div_id."').val();\n";
			else 
				$render .= "\n\tif(".$var_attribute." != '')\n\t\t\t".$var_attribute." += '".$options['append']."';\n";			
		} 

		if ( ( !isset($options['force']) || !$options['force'] ) && $attribute !== 'content' )
			$render .= "\n\tif(".$var_attribute." != '')";

		if ( $attribute !== 'content' )
			if ( $options['multi'] ) {
				
				$render .= "\n\t\t var is_last_item = (i == (".$options['multi']."_count - 1)); var is_first_item  = (i == 0);
				if ( is_first_item ) {
					{$out} += ' ".$attribute."=\''+ ".$var_attribute .";
					if ( ".$options['multi']."_count > 1 )
						{$out} += '".$options['seperator']."';
					else if ( ".$options['multi']."_count == 1 )
						{$out} += '\'';
						
				} else if ( is_last_item )
					{$out} += ".$var_attribute ." + '\'';
				else
					{$out} += ".$var_attribute ." + '".$options['seperator']."';
				";
			} else
				$render .= "\n\t\t{$out} += ' ".$attribute."=\''+ ".$var_attribute ." +'\'';";
				
		else {

			if ( $options['multi'] ) {
				$render .= "".$var_attribute."_total += ".$var_attribute.";\n";
			}

			if ( isset($options['data']) && is_array( $options['data'] ) ) {
				$render .= '// Second Level Attribute';
					$render .= cloudfw_render_shortcodes_javascript_elements($div_parent, $options['data'], NULL, $var_attribute . _if( $options['multi'], '_total' ), $div_id, _if( $options['multi'], true, false ));
				$render .= '// End of Second Level Attribute';
			}

			$after_render = "\n\t\t{$out} += ".$var_attribute. _if( $options['multi'], '_total' ) .";";

		}
		
		
		

		if ( $options['multi'] )
			$render .= "\n\n\t});//end of each\n\n";

		$render .= isset($pre_after_render) ? $pre_after_render : NULL;
		$pre_after_render = '';

		if ( !isset($options['check_visiblity']) || $options['check_visiblity'] )
			$render .= "\n\n} \n";


	}

	if ( isset($data['script']['tag_close']) ? $data['script']['tag_close'] : NULL ) {
		$render .= "\n{$out} += ']';";
	}

	$render .= isset($after_render) ? $after_render : NULL;
	return $render;
		
}

/**
 *	Echo Shortcodes Render
 *
 *	@since 1.0
 */
function cloudfw_echo_render_shortcodes_javascript( $data = array() ){
	if ( !is_array($data) )
		return;

	foreach($data as $module_id => $module) {
		if ( !is_array($module) )
			continue;

		$first_item =  @reset(@array_keys($module));
		$last_item =  @end(@array_keys($module));
		foreach($module as $module_item_id => $module_item) {
			if ( $first_item == $module_item_id ) {
				echo $module_item['head'];
				$temp_footer = $module_item['footer'];
			}
			echo $module_item['body'];
			if ( $last_item == $module_item_id )
				echo $temp_footer;
			
		}
	}
		
}



/**
 *	Shortcodes Render Other Scripts
 *
 *	@since 1.0
 */
function cloudfw_render_shortcodes_javascript_others( $div_parent, $data = array(), $render = '' ){
	
	if ( ! is_array($data) )
		return;
	
	$i = (int) 0;
	ksort($data);

	
	foreach ($data as $data_number => $datas): $i++;
		
		if ( isset($datas['script']['if']) && is_array($datas['script']['if']) ):

			$id = isset($datas['parent']) && $datas['parent'] ? $datas['parent'] : $datas['id'];
			$div_id = 'cloudfw_shortcode_div_'.$id;
			
			foreach( $datas['script']['if'] as $condition ){
				switch ( $condition['type'] ) {
					case 'toggle':
						
						$element = $condition['e'];
						$val_element = 'val_' . $element;

						$render .= "\njQuery('#".$div_parent."').delegate('#".$element."', 'change',function(){";
						$render .= "\nvar ".$val_element." = cloudfw_get_value(jQuery(this));";
						$render .= "\njQuery('#".$div_id."', '#".$div_parent."').find('.".$condition['related']."').slideUp().next('.divider').hide();";
						$condition_operator = isset($condition['!']) && $condition['!'] == true ? '!=' : '==';

						foreach ( (array) $condition['targets'] as $target ) {
							$render .= "\nif (".$val_element." ". $condition_operator ." '".$target[0]."') {";
								$render .= "\nvar currentElement = jQuery('#".$div_id."', '#".$div_parent."').find('".$target[1]."', '#".$div_id."').parents('.indicator').first();";
								$render .= "\nvar height = currentElement.stop(1).css('height', 'auto').show().height(); currentElement.css('height', 0);";
								$render .= "\ncurrentElement.animate({ 'height': height }, 500, function(){ currentElement.css('height', 'auto'); }).next('.divider').show();";
							$render .= "\n}\n";
						}

						$render .= "});";

					break;
					case 'clone':
						
						$trigger_element = isset($condition['e-trigger']) ? $condition['e-trigger'] : NULL;
						$element = isset($condition['e']) ? $condition['e'] : NULL;
						$bind = isset($condition['bind']) && $condition['bind'] ? $condition['bind'] : 'click';
						$val_element = 'val_' . isset($condition['action']) ? $condition['action'] : NULL;

						$render .= "\njQuery('#".$div_parent."').delegate('".$trigger_element."', '".$bind."',function(){";

							$render .= "\n\t
								var ".$val_element." = jQuery('".$element."', '#".$div_parent."');
								".$val_element.".addClass('".$val_element."');
								jQuery('.".$val_element."', '#".$div_parent."').last().after(  ".$val_element.".clone().removeAttr('id').removeAttr('name').addClass('clonedElement') );
							";
						
						if ( isset($condition['destroyAddLink']) && $condition['destroyAddLink'] ) {
							$render .= "\n\tjQuery('.clonedElement', '#".$div_parent."').find('".$trigger_element."').remove();";
						}

						if ( is_array($condition['reset']) ) {
							$render .= "\n\tjQuery('.clonedElement', '#".$div_parent."').last().find('".implode( ',', $condition['reset'] )."').val('').text('').empty();";
						}

						$render .= "\n\n}); //end bind \n";

					break;
				}

			}

		endif;

		if ( isset( $datas['data'] ) && is_array( $datas['data'] ) ) {
			$render = cloudfw_render_shortcodes_javascript_others( $div_parent, $datas['data'], $render );
		}

	endforeach;

	return $render;
	
}



/**
 *	CloudFw Render Javascripts for Shortcodes
 *
 *	@since 1.0
 */
function cloudfw_render_shortcodes_javascript( $div_parent, $items, $shortcode_map ) {
 	if ( !is_array($items) )
 		return '';

 	$div_prefix = cloudfw_sanitize( $div_parent ); 

?>
	<script type="text/javascript">
	// <![CDATA[
	
		var cloudfw_send_the_code_to_editor_<?php echo $div_prefix; ?>;
		jQuery(document).ready(function(){
	
			var cloudfw_parent_div 			= jQuery('#<?php echo $div_parent; ?>'),
				cloudfw_shortcode_selector 	= jQuery('#cloudfw_shortcode_selector', '#<?php echo $div_parent; ?>');
	
			function cloudfw_get_shortcode_module_<?php echo $div_prefix; ?>(){
				var cloudfw_shortcode_module = cloudfw_shortcode_selector.val(),
					shortcode_loading = jQuery( '#shortcode-loading', '#<?php echo $div_parent; ?>' );
	
				//console.log( 'cloudfw_get_shortcode_module_<?php echo $div_prefix; ?>' );
	
				jQuery('.shortcode-block', '#<?php echo $div_parent; ?>').slideUp();
				jQuery('.active-module', '#<?php echo $div_parent; ?>').removeClass('active-module');
				if ( cloudfw_shortcode_module != '' ) {
	
					var sectionEl = jQuery('#cloudfw_shortcode_div_' + cloudfw_shortcode_module, '#<?php echo $div_parent; ?>');
					
	
					if ( sectionEl.hasClass('needAjax') ) {
						
						shortcode_loading.show();
						cloudfw_shortcode_selector.prop("disabled", true);
	
						jQuery.ajax({
							url: CloudFwOp.ajaxUrl,
							cache: false,
							data: ({ 	
								nonce 	: CloudFwOp.cloudfw_nonce,
								action 	: "cloudfw_call_shortcode_section",
								section : sectionEl.attr( 'data-section-id' ),
								parent  : sectionEl.attr( 'data-parent-id' )
							}),
							success: function(data) {
								shortcode_loading.hide();
								cloudfw_shortcode_selector.prop("disabled", false);
								sectionEl.html(data);
								sectionEl.removeClass('needAjax').addClass('active-module').slideDown( function(){} );
								cloudfw_main(sectionEl);
							}
						});
						
						
					} else { 
						sectionEl.addClass('active-module').slideDown();
					}
	
				}
			}
	
			cloudfw_get_shortcode_module_<?php echo $div_prefix; ?>();
	
			jQuery(cloudfw_shortcode_selector).on('change',function(){
				cloudfw_get_shortcode_module_<?php echo $div_prefix; ?>();
			});
	
		cloudfw_send_the_code_to_editor_<?php echo $div_prefix; ?> = function ( parent_div, el, cb, act ) {
			var is_close = false;
			var id = parent_div.find('.active-module').attr('id');
	
			jQuery('.hasError').removeClass('hasError');
		
			if ( cloudfw_shortcode_selector.val() == '' )
				cloudfw_error_message_js('<?php _e('Please select a shortcode type to generate your code','cloudfw'); ?>');
	
	
			if (!(!window.tinyMCE || !jQuery('#edButtonPreview').hasClass('active'))) {
				var activeEditor = tinyMCE.activeEditor;
				var selection = activeEditor.selection.getContent();
				var selection_text = activeEditor.selection.getContent({format : 'text'});
				var selection_d = selection;
				var $nl = "<br/>";
				var $tb = "&nbsp;&nbsp;&nbsp;&nbsp;";
			} else {
				var activeEditor = jQuery('#content');
				var selection = '';
				var selection_text = selection;
				var selection_d = selection;
				var $nl = "\n";
				var $tb = "\t";
			}
			var out = "";
			
			if (!selection)
				selection = 'Content';
	
	
			switch (id){
				//CFJSswich
	
				<?php 
					cloudfw_echo_render_shortcodes_javascript(
						cloudfw_render_shortcodes_javascript_elements( $div_parent, $shortcode_map )
					);
				?>
	
			} // end switch
	
			if (out) {
				
				switch( act ){
					default:
						window.send_to_editor(out);
					break;
					case 'result':
						return out;
					break;
				}
	
				if ( typeof cb === 'function' )
					cb.call( out );
	
						
			}
	
		};
	
		<?php echo cloudfw_render_shortcodes_javascript_others($div_parent, $shortcode_map); ?>
	
	});
	 
	// ]]>
	</script>

 <?php 

 }

 endif;