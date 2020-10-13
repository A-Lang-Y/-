<?php

$option_field = $args[1];
$options = isset($args[2]) ? $args[2] : array();
$field_layout = !empty($options['layout']) ? $options['layout'] : 'layout';
$field_sidebar = !empty($options['sidebar']) ? $options['sidebar'] : 'sidebar';
$field_skin = !empty($options['skin']) ? $options['skin'] : 'skin';
$field_titlebar_style = !empty($options['titlebar_style']) ? $options['titlebar_style'] : 'titlebar_style';
$reset = !empty($options['reset']) ? $options['reset'] : '';
$brackets = !empty($options['brackets']) ? $options['brackets'] : false;

return $scheme = array(

	array(
		'type'      => 'module',
		'title'     =>  __('Page Layout','cloudfw'),
		'data'      => array(

			## Element
			array(
				'type'      =>  'select',
				'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field . ' ' . $field_layout ),
				'value'     =>  cloudfw_get_option( $option_field, $field_layout ),
				'source'    =>  array(
					'type'      =>  'function',
					'function'  =>  'cloudfw_admin_loop_page_templates',
				),
				'width'     =>  250,
				'reset'     =>  $reset,
				'brackets'  =>  $brackets,
			)

		)

	),


	array(
		'type'      => 'module',
		'title'     =>  __('Sidebar','cloudfw'),
		'data'      => array(

			## Element
			array(
				'type'      =>  'select',
				'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field . ' ' . $field_sidebar ),
				'value'     =>  cloudfw_get_option( $option_field,  $field_sidebar ),
				'source'    =>  array(
					'type'      =>  'function',
					'function'  =>  'cloudfw_admin_loop_custom_sidebars'
				),
				'width'     =>  400,
				'reset'     =>  $reset,
				'brackets'  =>  $brackets,
			), // #### element: 0

		)

	),

	array(
		'type'      => 'module',
		'title'     =>  __('Page Skin','cloudfw'),
		'data'      => array(

			## Element
			array(
				'type'      =>  'select',
				'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field . ' ' . $field_skin ),
				'value'     =>  cloudfw_get_option( $option_field,  $field_skin ),
				'source'    =>  array(
					'type'          => 'function',
					'function'      => 'cloudfw_module_admin_gel_all_skins_array',
					'send_data' =>  true,
					'send_args' =>  true,
				),
				'ui'        =>  true,
				'main_class'=>  'input input_400',
				'reset'     =>  $reset,
				'brackets'  =>  $brackets,
			)

		)

	),

	array(
		'type'      => 'module',
		'title'     =>  __('Title Bar Style','cloudfw'),
		'data'      => array(

			## Element
			array(
				'type'      =>  'select',
				'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field . ' ' . $field_titlebar_style ),
				'value'     =>  cloudfw_get_option( $option_field,  $field_titlebar_style ),
				'source'    =>  array(
					'type'          => 'function',
					'function'      => 'cloudfw_admin_loop_titlebar_styles',
				),
				'ui'        =>  true,
				'main_class'=>  'input input_300',
				'reset'     =>  $reset,
				'brackets'  =>  $brackets,
			)

		)

	),

);