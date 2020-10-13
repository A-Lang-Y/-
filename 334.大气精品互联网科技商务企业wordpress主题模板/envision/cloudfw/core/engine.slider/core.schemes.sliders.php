<?php

global $_opt;
$id = isset($_GET['id']) ? $_GET['id'] : NULL;

#	Dashboard
$scheme[5] = array(
	'type'		=> 'page',
	'page' 		=> 'dashboard',
	'is_current'=> empty($id),
	'dashboard'	=> array(
		'page_title' 	=>	__('All Sliders','cloudfw'),
		'page_slug' 	=>	'',
		'page_css_id' 	=>	'cloud_nav_slider_main',

	),
	'data'	=> array(
		array(
			'type'		=>	'require',
			'path'		=>	TMP_PATH.'/cloudfw/core/engine.slider/core.slider.include_forms.php'
		),
		array(
			'type'		=>	'require',
			'path'		=>	TMP_PATH.'/cloudfw/core/engine.slider/source.slider.php'
		),

		1000 => array(
			'type'			=>	'include',
			'path'			=>	TMP_PATH.'/cloudfw/core/engine.slider/source.slider.create_form.php',
			'before'		=>	'<span style="display: none; height: auto;" id="mb_create_slider"><div style="padding: 20px 20px 0;">',
			'after'			=>	'</div><div class="clear"></div></span>'
		),

		1001 => array(
			'type'			=>	'include',
			'path'			=>	TMP_PATH.'/cloudfw/core/engine.slider/source.slider.import_form.php',
			'before'		=>	'<span style="display: none; height: auto;" id="mb_import_slider"><div style="padding: 20px 20px 0;">',
			'after'			=>	'</div><div class="clear"></div></span>'
		),

		## Container Item
		array(
			'type'			=>	'container',
			'id'			=>	'add-update-form',
			'footer'		=>	false,
			'number'		=>	false,
			'title'			=>	__('Slider Manager','cloudfw'),
			'prepend_head'	=>	'
						<div style="float:right; margin-left:20px;">
								<a href="javascript:;" title="'. __('Import','cloudfw') .'" width="m" rel="mb_import_slider" class="small-button small-green help">
									<span>'. __('Import','cloudfw') .'</span>
								</a>
								<a href="javascript:;" title="'. __('Create A New Slider','cloudfw') .'" width="m" rel="mb_create_slider" class="small-button small-brown help">
									<span>'. __('Create','cloudfw') .'</span>
								</a>
						</div>
			',
			'data'			=>	array(

				array(
					'type'		=>	'run',
					'function'	=>	'cloudfw_admin_get_main_sliders'
				)

			)
			
		),


	)
	
);


#	Dashboard
$scheme[10] = array(
	'type'		=> 'page',
	'page' 		=> 'items',
	'condition'	=> !empty($id),
	'is_current'=> !empty($id),
	'items'		=> array(
		'page_title' 	=>	__('Manage Slider Items','cloudfw'),
		'page_slug' 	=>	'',
		'page_li_id' 	=>	'manageSlider',
		'page_css_id' 	=>	'cloud_nav_slider_items',
		'page_queries'	=>	array( 'id' => $id ),
	),
	'data'	=> array(
		array(
			'type'		=>	'require',
			'path'		=>	TMP_PATH.'/cloudfw/core/engine.slider/core.slider.include_forms.php'
		),
		array(
			'type'		=>	'require',
			'path'		=>	TMP_PATH.'/cloudfw/core/engine.slider/source.slider.php'
		),


		## Container Item
		array(
			'type'			=>	'container',
			'id'			=>	'add-update-form',
			'auto_width'	=>	true,
			'min_width'		=>	900,
			'footer'		=>	false,
			'number'		=>	false,
			'title'			=>	__('Slider Items','cloudfw'),
			'prepend_head'	=>	'
						<div style="float:right; margin-left:20px;">
								<a href="javascript:;" id="slider_paste" class="small-button small-grey">
									<span>'. __('Import Item','cloudfw') .'</span>
								</a>
								<a href="javascript:;" id="add_new_slider" class="small-button small-green">
									<span>'. __('Add New Item','cloudfw') .'</span>
								</a>
						</div>
			',
			'data'			=>	array(

				array(
					'type'		=>	'run',
					'function'	=>	'cloudfw_admin_get_slider_items'
				)

			)
			
		),

	)
	
);