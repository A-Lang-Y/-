<?php
$data = $args[0]; 
$scheme = array();

$scheme[] =	array(
	'type'		=>	'html',
	'data'		=>	'<div id="ui-icon-library">',
);

$scheme[] =	array(
	'type'		=>	'module',
	'layout'	=>	'split',
	'title'		=>	array( __('Color','cloudfw'), __('Background','cloudfw') ),
	'data'		=>	array(
		
		array(
			'type'		=>	'color',
			'style'		=>	'horizontal',
			'id'		=>	'icon_color',
			'value'		=>	$data['color'],
		),

		array(
			'type'		=>	'color',
			'style'		=>	'horizontal',
			'id'		=>	'icon_background',
			'value'		=>	$data['background'],
		)

	)
);

$scheme[] =	array(
	'type'		=>	'module',
	'title'		=>	__('Icon Size','cloudfw'),
	'data'		=>	array(
		array(
			'type'		=>	'text',
			'id'		=>	'icon_size',
			//'value'		=>	(int) $data['size'],
			'value'		=>	trim(str_replace('px', '', $data['size'])),
			'width'		=>	50,
			'holder'	=>	'12',
			'unit'		=>	__('px','cloudfw'),

		)
	)
);

if ( $data['allow_customization'] ) {

	$scheme[] =	array(
		'type'		=>	'module',
		'layout'	=>	'split',
		'title'		=>	array( __('Border Color','cloudfw'), __('Border Size','cloudfw') ),
		'data'		=>	array(
			
			array(
				'type'		=>	'color',
				'style'		=>	'horizontal',
				'id'		=>	'icon_border_color',
				'value'		=>	$data['border_color'],
			),

			array(
				'type'		=>	'text',
				'id'		=>	'icon_border_width',
				'value'		=>	trim(str_replace('px', '', $data['border_width'])),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw'),

			)
		)
	);

	$scheme[] =	array(
		'type'		=>	'module',
		'title'		=>	__('Border Radius','cloudfw'),
		'data'		=>	array(

			array(
				'type'		=>	'select',
				'id'		=>	'icon_border_radius',
				'value'		=>	$data['border_radius'],
				'source'	=>	array(
					'NULL'			=> __('No Radius','cloudfw'),
					'radius-3px'	=> __('3px Radius','cloudfw'),
					'radius-6px'	=> __('6px Radius','cloudfw'),
					'radius-30px'	=> __('30px Radius','cloudfw'),
					'radius-circle'	=> __('Circle','cloudfw'),
				),
				'width'		=>	250

			),

		)

	);

}


$scheme[] =	array(
	'type'		=>	'module',
	'layout'	=>	'raw',
	'prepend'	=>	'<div id="library-font-icons" style="height: 250px; overflow-y: auto;">',
	'append'	=>	'</div>',
	'data'		=>	array(
		array(
			'type'		=>	'radio',
			'id'		=>	'icon_class',
			'value'		=>	$data['icon'],
			'source'	=>	$data['icon_list'],
			'width'		=>	400
		)
	)
);

$scheme[] =	array(
	'type'		=>	'html',
	'data'		=>	'
 		<div class="module clean relative" style="background: transparent; border: 0; padding-bottom: 0;"><div class="grid oneof4">&nbsp;</div>
 			<div class="grid threeof4 last"><div class="clear"></div>
			<div id="" class="small-button small-green" style="float:right; margin-right: -40px !important;"><input type="submit" value="'.__('Done','cloudfw').'" ></div>
			</div><div class="clear"></div></div></div>
 	',
);

$scheme[] =	array(
	'type'		=>	'html',
	'data'		=>	'</div>',
);
