<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'container',
	'width'			=>	940,
	'footer'		=>	false,
	'title'			=>	__('Footer','cloudfw'),
	'data'			=>	array(
	

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Footer Widget Titles','cloudfw'),
			'id'		=>	cloudfw_sanitize('footer_widgets_title'),
			'value'		=>	$data['footer_widgets_title'],
			'data'		=>	array()
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Footer Widget Titles (Strong Style)','cloudfw'),
			'id'		=>	cloudfw_sanitize('footer_widgets_title_strong'),
			'value'		=>	$data['footer_widgets_title_strong'],
			'data'		=>	array(
				'line-height' => false
			)
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Footer Widget Contents','cloudfw'),
			'id'		=>	cloudfw_sanitize('footer_widgetized'),
			'value'		=>	$data['footer_widgetized'],
			'data'		=>	array( 
				'line-height' => false
			)
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Footer Bottom Bar','cloudfw'),
			'id'		=>	cloudfw_sanitize('footer_bottom'),
			'value'		=>	$data['footer_bottom'],
			'data'		=>	array()
		),

	
	) 


);