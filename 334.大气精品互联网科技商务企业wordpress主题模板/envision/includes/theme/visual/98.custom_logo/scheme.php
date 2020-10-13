<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Override Logo','cloudfw'),
	//'status'		=>	'opened',
	'data'			=>	array(
		
		array(
			'type'      =>  'module-set',
			'title'     =>  __('Logo Image','cloudfw'),
			'closable'  =>  false,
			'state'     =>  'opened',
			'layout'    =>  'subtab',
			'data'      =>  array(

				## SubTab Item
				array(
					'type'      =>  'tabs',
					'tab_id'    =>  'tab:logo-primary',
					'tab_title' =>  __('Primary Logo','cloudfw'),
					'icon'      =>  'widescreen',
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Primary Logo','cloudfw'),
							'data'      =>  array(
								array(
									'type'      => 'upload',
									'id'		=>	cloudfw_sanitize('options','custom-logo'),
									'value'		=>	$data['options']['custom-logo'],
									'removable' => true,
									'hide_input'=> true,
									'store'     => true,
									'library'   => true,
								)
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Primary Logo for Retina Screens','cloudfw'),
							'data'      =>  array(
								array(
									'type'      => 'upload',
									'id'		=>	cloudfw_sanitize('options','custom-logo-retina'),
									'value'		=>	$data['options']['custom-logo-retina'],
									'removable' => true,
									'hide_input'=> true,
									'store'     => true,
									'library'   => true,
								)
							)
						),

					)

				),

				## SubTab Item
				array(
					'type'      =>  'tabs',
					'tab_id'    =>  'tab:logo-tablet',
					'tab_title' =>  __('For Tablets','cloudfw'),
					'icon'      =>  'tablet',
					'data'      =>  array(



						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Logo for Tablets','cloudfw'),
							'data'      =>  array(
								array(
									'type'      => 'upload',
									'id'		=>	cloudfw_sanitize('options','custom-logo-tablet'),
									'value'		=>	$data['options']['custom-logo-tablet'],
									'removable' => true,
									'hide_input'=> true,
									'store'     => true,
									'library'   => true,
								)
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Retina Logo for Tablets','cloudfw'),
							'data'      =>  array(
								array(
									'type'      => 'upload',
									'id'		=>	cloudfw_sanitize('options','custom-logo-tablet-retina'),
									'value'		=>	$data['options']['custom-logo-tablet-retina'],
									'removable' => true,
									'hide_input'=> true,
									'store'     => true,
									'library'   => true,
								)
							)
						),

					)

				),

				## SubTab Item
				array(
					'type'      =>  'tabs',
					'tab_id'    =>  'tab:logo-phone',
					'tab_title' =>  __('For Phones','cloudfw'),
					'icon'      =>  'phone',
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Logo for Phones','cloudfw'),
							'data'      =>  array(
								array(
									'type'      => 'upload',
									'id'		=>	cloudfw_sanitize('options','custom-logo-phone'),
									'value'		=>	$data['options']['custom-logo-phone'],
									'removable' => true,
									'hide_input'=> true,
									'store'     => true,
									'library'   => true,
								)
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Retina Logo for Phones','cloudfw'),
							'data'      =>  array(
								array(
									'type'      => 'upload',
									'id'		=>	cloudfw_sanitize('options','custom-logo-phone-retina'),
									'value'		=>	$data['options']['custom-logo-phone-retina'],
									'removable' => true,
									'hide_input'=> true,
									'store'     => true,
									'library'   => true,
								)
							)
						),


					)

				),

			)

		),
		
	)

);