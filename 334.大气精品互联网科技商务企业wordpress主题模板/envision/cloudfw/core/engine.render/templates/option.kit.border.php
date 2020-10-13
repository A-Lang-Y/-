<?php

/**
 *	Border Option Kit
 */
function cloudfw_predefined_kit_border( $args = array() ){
	extract(cloudfw_make_var(array(
		'title'   => '',
		'id'      => '',
		'value'   => array(),
		'options' => array(),
	), _check_onoff_false($args)));

	if ( !isset($defaults) || empty($defaults) ) {
		$defaults = array(
		    'border-width'    => array( 'id' => cloudfw_sanitize( $id, 'border-width' ), 'value' => isset($value['border-width']) ? $value['border-width'] : NULL ),
		    'border-style'    => array( 'id' => cloudfw_sanitize( $id, 'border-style' ), 'value' => isset($value['border-style']) ? $value['border-style'] : NULL ),
		    'border-color'    => array( 'id' => cloudfw_sanitize( $id, 'border-color' ), 'value' => isset($value['border-color']) ? $value['border-color'] : NULL ),
		);
	}

	$options = cloudfw_make_var( $defaults, $options);
	$out = array();

	if ( $options['border-width'] !== false ) {
		$out[] = array(
			'type'		=>	'text',
			'title'		=>	__('Size','cloudfw'),
			'id'		=>	$options['border-width']['id'],
			'value'		=>	$options['border-width']['value'],
			'width'		=>	40,
			'unit'		=>	'px',
		);
	}

	if ( $options['border-style'] !== false ) {
		$out[] = array(
			'type'		=>	'select',
			'title'		=>	__('Style','cloudfw'),
			'id'		=>	$options['border-style']['id'],
			'value'		=>	$options['border-style']['value'],
			'source'	=>	array( 
				'NULL' 		=> __('Default','cloudfw'), 
				'solid' 	=> __('Solid','cloudfw'), 
				'dotted' 	=> __('Dotted','cloudfw'), 
				'dashed' 	=> __('Dashed','cloudfw'), 
				'hidden'	=> __('Hidden','cloudfw'), 
				'none' 		=> __('None','cloudfw'), 
			),
			'width'		=>	150
		);
	}

	if ( $options['border-color'] !== false ) {
		$out[] = array(
			'type'		=>	'color',
			'title'		=>	__('Color','cloudfw'),
			'id'		=>	$options['border-color']['id'],
			'value'		=>	$options['border-color']['value'],
			'style'		=>	'horizontal',
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