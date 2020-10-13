<?php
/**
 *  Hook for Custom Skins
 *
 *	@package CloudFw
 *	@since 	 1.0
 */
add_filter('cloudfw_skin_id', 'cloudfw_hook_custom_skins');
function cloudfw_hook_custom_skins( $current_skin_id ) {
    if ($skin = cloudfw_module( 'CloudFw_Page_Generator_Custom_Skins', 'custom_skin_id' ))
        return $skin;
    else
        return $current_skin_id;

}