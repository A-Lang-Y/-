<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'container',
	'width'			=>	940,
	'footer'		=>	false,
	'title'			=>	__('Sidebar','cloudfw'),
	'data'			=>	array(
	

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Sidebar Widget Titles','cloudfw'),
			'id'		=>	cloudfw_sanitize('sidebar_widgets_title'),
			'value'		=>	$data['sidebar_widgets_title'],
			'data'		=>	array()
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Footer Widget Titles (Strong Style)','cloudfw'),
			'id'		=>	cloudfw_sanitize('sidebar_widgets_title_strong'),
			'value'		=>	$data['sidebar_widgets_title_strong'],
			'data'		=>	array(
				'line-height' => false
			)
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Sidebar Texts','cloudfw'),
			'id'		=>	cloudfw_sanitize('sidebar_texts'),
			'value'		=>	$data['sidebar_texts'],
			'data'		=>	array()
		),


	
	) 


);