<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'		=> 'page',
	'page' 		=> 'dashboard',
	'dashboard'	=> array(
		'page_title' 	=>	__('Dashboard','cloudfw'),
		'page_nice_title'=>	__('dashboard','cloudfw'),
		'page_slug' 	=>	'',
		'page_css_id' 	=>	'cloud_nav_dashboard'
	),
	'data'	=> array(
		array(
			'type'		=>	'render',
			'condition'	=> array(
				'!'				=>	true,
				'type'			=>	'function',
				'function'		=>	'cloudfw_dummy_show_ui',
				'vars'			=>	array('dashboard')
			),
			'source'	=>	array(
				'type'			=>	'function',
				'function'		=>	'cloudfw_render_import_dummy',
				'vars'			=>	array('dashboard')
			)
		),
		array(
			'type'	=>	'include',
			'path'	=>	TMP_PATH.'/cloudfw/core/framework/cloudfw_dashboard.php'
		)
	)
	
);