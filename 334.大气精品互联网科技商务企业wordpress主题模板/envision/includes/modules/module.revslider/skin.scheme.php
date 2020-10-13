<?php

/** Skin scheme */
add_filter( 'cloudfw_schemes_skin', 'cloudfw_revslider_skin_scheme', 10, 2 );
function cloudfw_revslider_skin_scheme( $schemes, $data ){
	return cloudfw_add_skin_scheme( 'slider',
		$schemes,
		array(
			'type'		=>	'module-set',
			'title'		=>	__('Revolution Slider','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'SLIDER REVOLUTION',
					'title'		=>	array( __('Arrows Background','cloudfw'), __('Arrows Icon Color','cloudfw') ),
					'layout'	=>	'split',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'gradient',
							'id'		=>	cloudfw_sanitize('revoslider_arrows','gradient'),
							'value'		=>	$data['revoslider_arrows']['gradient'],
						), // #### element: 0

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('revoslider_arrows','color'),
							'value'		=>	$data['revoslider_arrows']['color'],

						),
					)

				),

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'SLIDER REVOLUTION',
					'title'		=>	array( __('Arrows Background Hover','cloudfw'), __('Arrows Icon Color Hover','cloudfw') ),
					'layout'	=>	'split',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'gradient',
							'id'		=>	cloudfw_sanitize('revoslider_arrows_hover','gradient'),
							'value'		=>	$data['revoslider_arrows_hover']['gradient'],
						), // #### element: 0

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('revoslider_arrows_hover','color'),
							'value'		=>	$data['revoslider_arrows_hover']['color'],

						),
					)

				),

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'SLIDER REVOLUTION',
					'title'		=>	array( __('Caption Primary Background','cloudfw'), __('Caption Primary Text Color','cloudfw') ),
					'layout'	=>	'split',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'gradient',
							'id'		=>	cloudfw_sanitize('revoslider_captions_primary','gradient'),
							'value'		=>	$data['revoslider_captions_primary']['gradient'],
						), // #### element: 0

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('revoslider_captions_primary','color'),
							'value'		=>	$data['revoslider_captions_primary']['color'],

						),
					)

				),

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'SLIDER REVOLUTION',
					'title'		=>	__('Caption White Background Text Color','cloudfw'),
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('revoslider_captions_white','color'),
							'value'		=>	$data['revoslider_captions_white']['color'],

						),
					)

				),

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'SLIDER REVOLUTION',
					'title'		=>	__('Caption Long Text Color','cloudfw'),
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('revoslider_captions_long','color'),
							'value'		=>	$data['revoslider_captions_long']['color'],

						),
					)

				),

	
													
			)

		),

		5 // seq
		
	);

}