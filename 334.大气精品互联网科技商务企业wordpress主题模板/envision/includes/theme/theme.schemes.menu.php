<?php
$location = isset($args[1]) ? $args[1] : NULL;
$item = isset($args[0]) ? $args[0] : NULL;
if ( $item )
	$item_suffix = '_' . $item;
else
	$item_suffix = '';

$scheme = array(); 
switch ($location) {
	default:
		break;
	
	case 'primary':

			$scheme = array_merge( $scheme, array(
					array(
					    'type'      =>  'group',
					    'id'		=>	'',
					    //'menu-condition' =>	'= 0',
					    'data'		=>	array(

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Visibility','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'select',
							            'id'        =>  PFIX.'_visibility' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'visibility'),
							            'default'	=> '',
							            'source'	=>	array(
							            	'type'		=>	'function',
							            	'function'	=>	'cloudfw_admin_get_visibility_options'
							            ),
							            'width'		=> 180
							        ), // #### element: 0
							            
							    )
							),

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Sub Menu Direction','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'select',
							            'id'        =>  PFIX.'_dropdown_direction' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'dropdown_direction'),
							            'default'	=> '',
							            'source'	=>	array(
							            	'NULL'		=>	__('Default','cloudfw'),
							            	'left'		=>	__('To Left','cloudfw'),
							            	'right'		=>	__('To Right','cloudfw'),
							            ),
							            'width'		=> 180
							        ), // #### element: 0
							            
							    )
							),
					    )
					),

					array(
					    'type'      =>  'group',
					    'id'		=>	'',
					    'menu-condition' =>	'= 0',
					    'data'		=>	array(

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Enable Mega Menu','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'onoff',
							            'id'        =>  PFIX.'_megamenu' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu'),
							            'default'	=>	'FALSE',
							        ), // #### element: 0
							            
							    )
							),

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Mega Menu Columns','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'slider',
							            'id'        =>  PFIX.'_megamenu_columns' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_columns'),
							            'default'	=>	3,
							            'max'		=>	4,
							            'min'		=>	1,
							            'unit'		=>	__('column(s)','cloudfw'),
							            'class' 	=> 'input input_100',
							            'width'		=>	'150',
							        ), // #### element: 0
							            
							    )
							),

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Mega Menu Layout','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'select',
							            'id'        =>  PFIX.'_megamenu_layout' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_layout'),
							            'default'	=> '',
							            'source'	=>	array(
							            	'NULL'			=>	__('Specific Width','cloudfw'),
							            	'fullwidth'		=>	__('Fullwidth','cloudfw'),
							            ),
							            'width'		=> 180
							        ), // #### element: 0
							            
							    )
							),


							array(
							    'type'      =>  'module',
							    'title'     =>  __('Mega Menu Width','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'slider',
							            'id'        =>  PFIX.'_megamenu_width' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_width'),
							            'default'	=>	'-1',
							            'max'		=>	960,
							            'min'		=>	-1,
							            'steps'		=>	array( '-1' => __('default','cloudfw') ),
							            'class' 	=> 'input input_100',
							            'width'		=>	'150',
							            'desc'		=>	__('This option is for the "Specific Width" layout','cloudfw')
							        ), // #### element: 0
							            
							    )
							),

					    )

					),

					array(
					    'type'      =>  'group',
					    'menu-condition' =>	'> 0',
					    'data'		=>	array(

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Link Text Align','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'select',
							            'id'        =>  PFIX.'_dropdown_text_align' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'dropdown_text_align'),
							            'default'	=> '',
							            'source'	=>	array(
							            	'NULL'		=>	__('Default','cloudfw'),
							            	'left'		=>	__('Left','cloudfw'),
							            	'center'	=>	__('Center','cloudfw'),
							            	'right'		=>	__('Right','cloudfw'),
							            ),
							            'width'		=> 180
							        ), // #### element: 0
							            
							    )
							),

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Mega Menu Item Style','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'select',
							            'id'        =>  PFIX.'_megamenu_style' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_style'),
							            'default'	=> '',
							            'source'	=>	array(
							            	'NULL'			=>	__('Default','cloudfw'),
							            	'standard'		=>	__('Standard Style','cloudfw'),
							            	'big-title'		=>	__('Big Title Style','cloudfw'),
							            	'strong-title'	=>	__('Strong Title Style','cloudfw'),
							            	'list'			=>	__('List Style','cloudfw'),
							            ),
							            'width'		=> 180
							        ), // #### element: 0
							    )
							),

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Mega Menu Image','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'upload',
							            'id'        =>  PFIX.'_megamenu_image' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_image', ''),
							            'store'		=>	true,
							            'removable'	=>	true,
							            'hide_input'=>	true,
							        ), // #### element: 0
							            
							    )
							),

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Mega Menu HTML Code','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'textarea',
							            'id'        =>  PFIX.'_megamenu_html' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_html', ''),
							            'width'		=>	230,
							            'line'		=>	3
							        ), // #### element: 0
							            
							    )
							),

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Mega Menu Custom Text Color','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'color',
							            'style'     =>  'mini',
							            'id'        =>  PFIX.'_megamenu_text_color' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_text_color', ''),
							        ), // #### element: 0
							            
							    )
							),

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Hide Title','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'onoff',
							            'id'        =>  PFIX.'_megamenu_hide_title' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_hide_title', 'FALSE'),
							        ), // #### element: 0
							            
							    )
							),

					    )
					),

					/*array(
					    'type'      =>  'group',
					    'menu-condition' =>	'= 1',
					    'data'		=>	array(

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Divider','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'onoff',
							            'id'        =>  PFIX.'_megamenu_divider' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_divider', 'FALSE'),
							        ), // #### element: 0
							            
							    )
							),

					    )
					),*/

					array(
					    'type'      =>  'group',
					    //'menu-condition' =>	'> 0',
					    'data'		=>	array(

							array(
							    'type'      =>  'module',
							    'title'     =>  __('Disable Link','cloudfw'),
							    'data'      =>  array(
							        ## Element
							        array(
							            'type'      =>  'onoff',
							            'id'        =>  PFIX.'_disable_link' . $item_suffix,
							            'value'     =>  cloudfw_get_post_meta($item, 'disable_link', 'FALSE'),
							        ), // #### element: 0
							            
							    )
							),

					    )
					),

					array(
					    'type'      =>  'module',
					    'title'     =>  __('Inline Style Code For Item','cloudfw'),
					    'data'      =>  array(
					        ## Element
					        array(
					            'type'      =>  'text',
					            'id'        =>  PFIX.'_megamenu_inline_style' . $item_suffix,
					            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_inline_style', ''),
					            'width'		=>	230,
					        ), // #### element: 0
					            
					    )
					),

					array(
					    'type'      =>  'module',
					    'title'     =>  __('Inline Style Code For Link','cloudfw'),
					    'data'      =>  array(
					        ## Element
					        array(
					            'type'      =>  'text',
					            'id'        =>  PFIX.'_megamenu_inline_style_link' . $item_suffix,
					            'value'     =>  cloudfw_get_post_meta($item, 'megamenu_inline_style_link', ''),
					            'width'		=>	230,
					        ), // #### element: 0
					            
					    )
					),

				)

			);

		break;

}



?>