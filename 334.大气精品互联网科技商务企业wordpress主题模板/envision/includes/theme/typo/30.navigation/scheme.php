<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'container',
	'width'			=>	940,
	'footer'		=>	false,
	'title'			=>	__('Navigation','cloudfw'),
	'data'			=>	array(
	

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Navigation Menu (First Level)','cloudfw'),
			'id'		=>	cloudfw_sanitize('navigation_first_level'),
			'value'		=>	$data['navigation_first_level'],
			'data'		=>	array( 
				'line-height' => false
			)
			
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Navigation Menu (Sub Level)','cloudfw'),
			'id'		=>	cloudfw_sanitize('navigation_sub_level'),
			'value'		=>	$data['navigation_sub_level'],
			'data'		=>	array( 
				'line-height' => false
			)
			
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Mobile Navigation Menu Toggle','cloudfw'),
			'id'		=>	cloudfw_sanitize('navigation_mobile_toggle'),
			'value'		=>	$data['navigation_mobile_toggle'],
			'data'		=>	array( 
				'line-height' => false
			)
			
		),

	
	) 


);