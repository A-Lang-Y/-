<?php
function cloudfw_admin_get_found_modules() {
	$found_modules = cloudfw_get_found_modules();

	foreach ((array)$found_modules as $module_id => $module) {
			
		$found_modules_array[] =  array(
			"item_value"	=> $module_id,
			"item_class"	=> "",
			"item_html" 	=> '<span class="skin-name">'.$module["title"].'</span><span class="block description">'.$module["desc"].'</span>'
		);
						
	}
	
	return $found_modules_array;
}