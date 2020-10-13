<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'container',
	'width'			=>	940,
	'footer'		=>	false,
	'title'			=>	__('General Elements','cloudfw'),
	'data'			=>	array(
	

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Body','cloudfw'),
			'id'		=>	cloudfw_sanitize('body'),
			'value'		=>	$data['body'],
			'data'		=>	array( 
			    'font-weight'     => false,
			    'letter-spacing'  => false,				
			)
			
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Form Elements (Inputs)','cloudfw'),
			'id'		=>	cloudfw_sanitize('inputs'),
			'value'		=>	$data['inputs'],
			'data'		=>	array( 
			    'letter-spacing'  => false,				
				//'font-size'		=>	array( 'id' => cloudfw_sanitize('test', 'font-size'), 'value' => $data['test']['font-size'] ),
			)

		),
	
	) 


);