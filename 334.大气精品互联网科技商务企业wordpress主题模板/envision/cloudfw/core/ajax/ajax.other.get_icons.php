<?php

$icon_list = cloudfw_get_icons();
	
echo '
	<div id="icon-box-title">
		Icon List <span id="icon-box-append"></span>
		<a class="ui-icon-box-icons cloudfw-tooltip" title="'.__('Back','cloudfw').'" style="display:none;" id="ui-icon-box-back" href="javascript:void(null);"></a>
		<a class="ui-icon-box-icons cloudfw-tooltip" title="'.__('Close','cloudfw').'" id="ui-icon-box-close" href="javascript:void(null);"></a>
	</div>
	<div id="icon-box-content">
';

foreach( (array)$icon_list as $icon_cat_name => $icon_cat ) {
	
	echo '
	<div class="ui-icon-loop">
	<a href="#" class="ui-icon-cat-title">'.$icon_cat_name.'</a>';
	echo '<ul class="grouped">';
	
	foreach((array)$icon_cat as $icon_url => $icon_name) {
	
		echo '
			<li>
				<a href="#" class="the-icon" data-id="'.$icon_url.'">
					<div><img src="'.cloudfw_make_icon_url($icon_url).'" alt="'.$icon_name.'" /></div>
				</a>
			</li>
		';

	}
	
	echo '</ul></div>';

}

echo '</div>';