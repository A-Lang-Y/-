<?php
$_opt = $args[0]; 
$purchase_code = $args[1]; 

$scheme[ cloudfw_id_for_sequence( $scheme, 10 ) ] = array(
	'type'		=> 'page',
	'page'  	=> 'upgrade',
	'is_current'=>	true,
	'upgrade' 		=>  array(
		'page_title' 	=>	__('Theme Upgrade','cloudfw'),
		'page_slug' 	=>	'upgrade',
		'page_css_id' 	=>	'cloud_nav_upgrade'
	),
	'data'	=>  array(
			
				## Container Item
				array(
					'type'		=>	'container',
					'condition'	=>	empty($purchase_code),
					'title'		=>	__('Purchase Code','cloudfw'),
					'submit_title'	=>	__('Save & Upgrade','cloudfw'),
					'form'		=>	array(
						'id'		=> 'form-purchase-code',
						'enable'	=> true,
						'ajax'		=> true,
						'shortcut'	=> true,
					),
					'data'		=>	array(

						array(
							'type'		=>	'message',
							'fill'		=>	true,
							'title'		=>	__('Where can I find my Item Purchase Code?','cloudfw'),
							'data'		=>	__('You will find your Item Purchase Code contained within the License Certificate of your purchase. You can view your License Certificate at anytime by logging into your ThemeForest account and visiting your downloads section.','cloudfw') . ' <a href="http://cl.ly/7Ert" target="_blank">'. __('Click here for more instructions.','cloudfw').'</a>',
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Item Purchase Code','cloudfw'),
							'data'		=>	array(
									array(
										'type'		=>	'text',
										'id'		=>	cloudfw_sanitize(PFIX.'_envato purchase_code'),
										'value'		=>	$_opt[PFIX.'_envato']['purchase_code'],
										'_class'	=>	'input_400',
										'description'=>	__('It will be used for verifying before update','cloudfw'),
									)
							)
						),
							
					)

				), // #### container: 10

				array(
					'type'		=>	'jquery',
					'condition'	=>	empty($purchase_code),
					'data'		=>	'

						jQuery("#form-purchase-code").bind("ajaxCallback", function(){
							location.reload();
						});

					'
				),
			

	) // page -> data
	
);