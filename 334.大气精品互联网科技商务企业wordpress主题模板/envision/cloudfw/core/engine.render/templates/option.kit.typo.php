<?php

/**
 *	Typogrpahy Option Kit
 */
function cloudfw_predefined_kit_typo( $title, $id, $data, $options = array() ){

	if ( !isset($defaults) || empty($defaults) ) {
		$defaults = array(
		    'font-family'     => array( 'id' => cloudfw_sanitize( $id, 'font-family' ), 'value' => isset($data['font-family']) ? $data['font-family'] : NULL ),
		    'font-size'       => array( 'id' => cloudfw_sanitize( $id, 'font-size' ), 'value' => isset($data['font-size']) ? $data['font-size'] : NULL ),
		    'font-weight'     => array( 'id' => cloudfw_sanitize( $id, 'font-weight' ), 'value' => isset($data['font-weight']) ? $data['font-weight'] : NULL ),
		    'line-height'     => array( 'id' => cloudfw_sanitize( $id, 'line-height' ), 'value' => isset($data['line-height']) ? $data['line-height'] : NULL ),
		    'letter-spacing'  => array( 'id' => cloudfw_sanitize( $id, 'letter-spacing' ), 'value' => isset($data['letter-spacing']) ? $data['letter-spacing'] : NULL ),
		);
	}

	$options = cloudfw_make_var( $defaults, $options);

	$out = array();

	if ( $options['font-family'] !== false ) {
		$out[] = array(
			'type'		=>	'select',
			'title'		=>	__('Font Family','cloudfw'),
			'id'		=>	$options['font-family']['id'],
			'value'		=>	$options['font-family']['value'],
			'source'	=>	array( 
				'type' 		=> 'function', 
				'function' 	=> 'cloudfw_grouped_font_list_cached' 
			),
			'width'		=>	200
		);
	}

	if ( $options['font-size'] !== false ) {
		$out[] = array(
			'type'		=>	'select',
			'title'		=>	__('Size','cloudfw'),
			'id'		=>	$options['font-size']['id'],
			'value'		=>	$options['font-size']['value'],
			'source'	=>	array( 
				'type' => 'function', 
				'function' => 'cloudfw_font_sizes' 
			),
			'width'		=>	85,
			'compact'	=>	true,
		);
	}

	if ( $options['line-height'] !== false ) {
		$out[] = array(
			'type'		=>	'select',
			'title'		=>	__('Line-Height','cloudfw'),
			'id'		=>	$options['line-height']['id'],
			'value'		=>	$options['line-height']['value'],
			'source'	=>	array( 
				'type' => 'function', 
				'function' => 'cloudfw_font_line_heights' 
			),
			'width'		=>	85,
			'compact'	=>	true,
		);
	}

	if ( $options['font-weight'] !== false ) {
		$out[] = array(
			'type'		=>	'select',
			'title'		=>	__('Weight','cloudfw'),
			'id'		=>	$options['font-weight']['id'],
			'value'		=>	$options['font-weight']['value'],
			'source'	=>	array( 
				'type' => 'function', 
				'function' => 'cloudfw_font_weights' 
			),
			'width'		=>	90,
			'compact'	=>	true,
		);
	}

	if ( $options['letter-spacing'] !== false ) {
		$out[] = array(
			'type'		=>	'select',
			'title'		=>	__('Letter-Spacing','cloudfw'),
			'id'		=>	$options['letter-spacing']['id'],
			'value'		=>	$options['letter-spacing']['value'],
			'source'	=>	array( 
				'type' => 'function', 
				'function' => 'cloudfw_font_letter_spacing' 
			),
			'width'		=>	90,
			'compact'	=>	true,
		);
	}


	if ( !empty($out) ) {

		$out = array(
			'type'		=>	'module',
			'auto_column'=>	false,
			'title'		=>	$title,
			'layout'	=>	'float',
			'data'		=>	$out
		);

		cloudfw_render_page( array( 'data' => $out ) );

	}

}