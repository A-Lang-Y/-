<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Custom CSS Code','cloudfw'),
	//'status'		=>	'opened',
	'data'			=>	array(
		
		## Module Item
		5	=> array(
			'type'		=>	'module',
			'ucode'		=>	'CSS',
			'title'		=>	__('CSS Code','cloudfw'),
			'data'		=>	array(
			
					## Element
					array(
						'type'		=>	'textarea',
						'id'		=>	cloudfw_sanitize('options','custom-css'),
						'value'		=>	$data['options']['custom-css'],
						'_class'	=>  'input textarea_500px_8line code tab-textfields tabtext',
						'wrap'		=>	'off',
						'description'=> sprintf(__("Do not use %s tag",'cloudfw'), '<code>&lt;style&gt;</code>')
					), // #### element: 0
			
			)
		), 
		
	)

);