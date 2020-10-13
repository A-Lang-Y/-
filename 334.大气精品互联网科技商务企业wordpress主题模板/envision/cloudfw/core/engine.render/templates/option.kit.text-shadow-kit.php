<?php

/**
 *	Text Shadow Kit
 */
function cloudfw_predefined_kit_text_shadow_kit( $args = array() ){
	extract(cloudfw_make_var(array(
		'title'   => '',
		'id'      => '',
		'value'   => array(),
		'options' => array(),
	), _check_onoff_false($args)));

	if ( !isset($defaults) || empty($defaults) ) {
		$defaults = array(
			'color'              => array( 'id' => cloudfw_sanitize( $id, 'color' ), 'value' => isset($value['color']) ? $value['color'] : NULL ),
			'text-shadow-enable' => array( 'id' => cloudfw_sanitize( $id, 'text-shadow-enable' ), 'value' => isset($value['text-shadow-enable']) ? $value['text-shadow-enable'] : NULL ),
			'text-shadow-color'  => array( 'id' => cloudfw_sanitize( $id, 'text-shadow-color' ), 'value' => isset($value['text-shadow-color']) ? $value['text-shadow-color'] : NULL ),
			'text-shadow-pos-v'  => array( 'id' => cloudfw_sanitize( $id, 'text-shadow-pos-v' ), 'value' => isset($value['text-shadow-pos-v']) ? $value['text-shadow-pos-v'] : NULL ),
			'text-shadow-pos-h'  => array( 'id' => cloudfw_sanitize( $id, 'text-shadow-pos-h' ), 'value' => isset($value['text-shadow-pos-h']) ? $value['text-shadow-pos-h'] : NULL ),
		);
	}

	$options = cloudfw_make_var( $defaults, $options);
	$out = array();

	if ( $options['color'] !== false ) {
		$out[] = array(
			'type'		=>	'color',
			'title'		=>	__('Text Color','cloudfw'),
			'id'		=>	$options['color']['id'],
			'value'		=>	$options['color']['value'],
			'style'		=>	'horizontal',
		);
	}

	if ( $options['text-shadow'] !== false ) {
		$out[] = array(
			'type'		=>	'select',
			'title'		=>	__('Text Shadow?','cloudfw'),
			'id'		=>	$options['text-shadow-enable']['id'],
			'value'		=>	$options['text-shadow-enable']['value'],
			'source'	=>	array(
				'NULL' 		=> __('Default','cloudfw'),
				'enable' 	=> __('Enable','cloudfw'),
				'disable' 	=> __('Disable','cloudfw'),
			),
			'width'		=>	120
		);
	}

	if ( $options['text-shadow-color'] !== false ) {
		$out[] = array(
			'type'		=>	'color',
			'title'		=>	__('Shadow Color','cloudfw'),
			'id'		=>	$options['text-shadow-color']['id'],
			'value'		=>	$options['text-shadow-color']['value'],
			'style'		=>	'horizontal',
		);
	}

	if ( $options['text-shadow-pos-v'] !== false ) {
		$out[] = array(
			'type'		=>	'select',
			'title'		=>	__('Shadow Position','cloudfw'),
			'id'		=>	$options['text-shadow-pos-v']['id'],
			'value'		=>	$options['text-shadow-pos-v']['value'],
			'source'	=>	array(
				'NULL' 		=> __('Default','cloudfw'),
				'-1' 		=> __('Top','cloudfw'),
				'1' 		=> __('Bottom','cloudfw'),
			),
			'width'		=>	120
		);
	}

	if ( ! empty( $out ) ) {

		$args = cloudfw_merge_option_args( $args );

		if ( !empty( $args['type'] ) ) {
			$args['data'] = $out;
			if ( !isset( $args['auto_column'] ) ) $args['auto_column'] = false;
			if ( !isset( $args['layout'] ) ) $args['layout'] = 'float';
			$out = array( 'data' => $args );
		}

		cloudfw_render_page( $out );

	}

}