<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'container',
	'width'			=>	940,
	'footer'		=>	false,
	'title'			=>	__('Headings','cloudfw'),
	'before_head'	=>	'',
	'data'			=>	array(


		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Headings','cloudfw'),
			'id'		=>	cloudfw_sanitize('headings'),
			'value'		=>	$data['headings'],
			'data'		=>	array( 
			    'font-size'       => false,
			    'line-height'     => false,
			    'letter-spacing'  => false,				
			)
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Strong tags in Headings <br/>(H1, H2 ... > strong)','cloudfw'),
			'id'		=>	cloudfw_sanitize('strong_headings'),
			'value'		=>	$data['strong_headings'],
			'data'		=>	array( 
			    'font-size'       => false,
			    'line-height'     => false,
			    'letter-spacing'  => false,				
			)
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('H1','cloudfw'),
			'id'		=>	cloudfw_sanitize('h1'),
			'value'		=>	$data['h1'],
		),
				
		array(
			'type'		=>	'typo-set',
			'title'		=>	__('H2','cloudfw'),
			'id'		=>	cloudfw_sanitize('h2'),
			'value'		=>	$data['h2'],
		),
				
		array(
			'type'		=>	'typo-set',
			'title'		=>	__('H3','cloudfw'),
			'id'		=>	cloudfw_sanitize('h3'),
			'value'		=>	$data['h3'],
		),
				
		array(
			'type'		=>	'typo-set',
			'title'		=>	__('H4','cloudfw'),
			'id'		=>	cloudfw_sanitize('h4'),
			'value'		=>	$data['h4'],
		),
				
		array(
			'type'		=>	'typo-set',
			'title'		=>	__('H5','cloudfw'),
			'id'		=>	cloudfw_sanitize('h5'),
			'value'		=>	$data['h5'],
		),
				
		array(
			'type'		=>	'typo-set',
			'title'		=>	__('H6','cloudfw'),
			'id'		=>	cloudfw_sanitize('h6'),
			'value'		=>	$data['h6'],
		),
				
	) 

);