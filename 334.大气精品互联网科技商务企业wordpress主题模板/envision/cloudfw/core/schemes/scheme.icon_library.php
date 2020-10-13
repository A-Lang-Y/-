<?php
$data = $args[0]; 


$scheme = array();

$scheme[] =	array(
	'type'		=>	'html',
	'data'		=>	'<div id="ui-icon-library">',
);

$scheme[] =	array(
	'type'		=>	'module',
	'title'		=>	__('Icon Sets','cloudfw'),
	'data'		=>	array(
		array(
			'type'		=>	'select',
			'id'		=>	'icon_set_selector',
			'value'		=>	'',
			'source'	=>	$data['icon_categories'],
			'width'		=>	400
		)
	)
);

foreach ($data['icon_list'] as $set_id => $set_icons) {

	$scheme[] =	array(
		'type'		=>	'module',
		'layout'	=>	'raw',
		'before'	=>	'<div id="icon-set-'. $set_id .'" class="library-icons-set" style="display:none;">',
		'prepend'	=>	'<div class="" style="height: 250px; overflow-y: auto;">',
		'append'	=>	'</div>',
		'after'		=>	'</div>',
		'data'		=>	array(
			array(
				'type'		=>	'radio',
				'id'		=>	'library_icon',
				'class'		=>	'icon_selector_label',
				'value'		=>	$data['icon'],
				'source'	=>	$set_icons,
			)
		)

	);

}

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