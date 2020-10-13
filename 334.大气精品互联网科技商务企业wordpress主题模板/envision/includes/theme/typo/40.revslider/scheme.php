<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'container',
	'width'			=>	940,
	'footer'		=>	false,
	'title'			=>	__('Revolution Slider Captions','cloudfw'),
	'data'			=>	array(
	

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Caption Primary','cloudfw'),
			'id'		=>	cloudfw_sanitize('revslider_caption_primary'),
			'value'		=>	$data['revslider_caption_primary'],
			'data'		=>	array(), 
			'desc'		=>	'(.caption-primary)',
			
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Caption Primary Strong Style','cloudfw'),
			'id'		=>	cloudfw_sanitize('revslider_caption_primary_strong'),
			'value'		=>	$data['revslider_caption_primary_strong'],
			'data'		=>	array(
				'font-size'		=>	false,
				'font-family'	=>	false,
				'line-height'	=>	false,
				'letter-spacing'=>	false,
			), 
			
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Caption White Background','cloudfw'),
			'id'		=>	cloudfw_sanitize('revslider_caption_white_background'),
			'value'		=>	$data['revslider_caption_white_background'],
			'data'		=>	array(), 
			
		),

		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Caption Long Text','cloudfw'),
			'id'		=>	cloudfw_sanitize('revslider_caption_text'),
			'value'		=>	$data['revslider_caption_text'],
			'data'		=>	array(), 
			
		),

	
	) 


);