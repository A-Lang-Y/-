<?php


/**
 *	Register Options Map
 *
 *	@package 	CloudFw
 *	@version 	1.0
 */
add_filter( 'cloudfw_maps_options_object', 'cloudfw_module_map_nav_lang_switcher' );
function cloudfw_module_map_nav_lang_switcher( $map ) {
    $map  -> option	 ( 'nav_lang_switcher' )
          -> sub  	 ( 'enable', 'FALSE' )
          -> sub  	 ( 'name' )
          -> sub  	 ( 'flag' )
          -> sub  	 ( 'link_type' )
          -> sub  	 ( 'dropdown_position', 'left' )
    ;
	return $map;
}

/**
 *	Register Options Scheme
 *
 *	@package 	CloudFw
 *	@version 	1.0
 */
add_filter( 'cloudfw_schemes_options', 'cloudfw_module_option_nav_lang_switcher' );
function cloudfw_module_option_nav_lang_switcher( $schemes ) {
	return cloudfw_add_option_scheme( 'module',
		$schemes,

		 array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'nav_lang_switcher',
			'tab_title' =>	__('Language Switcher for Navigation Menu','cloudfw'),
			'data'		=>	array(

				array(
					'type'			=>	'container',
					'title'			=>	__('Language Switcher for Navigation Menu','cloudfw'),
					'footer'		=>	true,
					'data'			=>	array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Enable?','cloudfw'),
							'data'      =>  array(
								## Element
								array(
									'type'      =>  'onoff',
									'id'        =>  cloudfw_sanitize(PFIX.'_nav_lang_switcher enable'),
									'value'     =>  cloudfw_get_option('nav_lang_switcher', 'enable'),
								),
							)
						),

						array(
							'type'		=>	'message',
							'color'		=>	'yellow',
							'fill'		=>	true,
							'data'		=>	__('The <strong>WPML Multilingual CMS</strong> and <strong>WPML String Translation</strong> plugins should be installed to add the language switcher widget to the main navigation','cloudfw')
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Link Type','cloudfw'),
							'data'      =>  array(
								## Element
								array(
									'type'      =>  'select',
									'id'        =>  cloudfw_sanitize(PFIX.'_nav_lang_switcher link_type'),
									'value'     =>  cloudfw_get_option('nav_lang_switcher', 'link_type'),
									'source'    =>  array(
										'NULL'      => __('Go to current page','cloudfw'),
										'home'      => __('Go to homepage','cloudfw'),
									),
									'width'     =>  250,
								), // #### element: 0
							)
						),


						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Show Language Names','cloudfw'),
							'data'      =>  array(
								## Element
								array(
									'type'      =>  'onoff',
									'id'        =>  cloudfw_sanitize(PFIX.'_nav_lang_switcher name'),
									'value'     =>  cloudfw_get_option('nav_lang_switcher', 'name'),
								),
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Show Language Flags','cloudfw'),
							'data'      =>  array(
								## Element
								array(
									'type'      =>  'onoff',
									'id'        =>  cloudfw_sanitize(PFIX.'_nav_lang_switcher flag'),
									'value'     =>  cloudfw_get_option('nav_lang_switcher', 'flag'),
								),
							)
						),
																						
						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Drop Down Menu Position','cloudfw'),
							'data'      =>  array(
								## Element
								array(
									'type'      =>  'select',
									'id'        =>  cloudfw_sanitize(PFIX.'_nav_lang_switcher dropdown_position'),
									'value'     =>  cloudfw_get_option('nav_lang_switcher', 'dropdown_position'),
									'source'    =>  array(
										'NULL'      => __('Default','cloudfw'),
										'left'      => __('Left','cloudfw'),
										'right'     => __('Right','cloudfw'),
									),
									'width'     =>  250,
								), // #### element: 0
							)
						),

					)

				),

			)

		)
	);

	return $schemes;
}