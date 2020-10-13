<?php
/**
 *	Register Module Metaboxes
 *
 *	@package CloudFw
 *	@since 	 1.0
 */
add_filter( 'cloudfw_metaboxes', 'cloudfw_custom_skins_metaboxes', 10, 3 );

function cloudfw_custom_skins_metaboxes( $metaboxes, $post_id, $post_types_core = array('page') ) {

	$metaboxes[ cloudfw_id_for_sequence( $metaboxes ) ] = array(
	    'type'  => 'metabox',
	    'id'    => 'cloudfw_metabox_custom_skins',
	    'title' => __('Custom Skins', 'cloudfw'),
	    'pages' => $post_types_core,
	    'context' => 'side',
	    'priority' => 'high',
	    'data'  => array(

            5   => array(
                'type'      =>  'module',
                'title'     =>  __('Skins','cloudfw') . '<a href="javascript:;" target="_blank;" id="cloudfw-skin-edit-indicator" style="float:right; display: none ">'. __('Edit the skin','cloudfw') .'</a>',
                'data'      =>  array(

                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  PFIX.'_custom_skin',
                        'value'     =>  get_post_meta($post_id, PFIX.'_custom_skin', true),
						'source'	=>	array(
							'type'		=>	'function',
							'function'	=>	'cloudfw_module_admin_gel_all_skins_array',
							'send_data'	=>	true,
							'send_args'	=>	true,
						),
                        'width'     =>  230,
                        'after'		=>	array(
                        	array(
                        		'type'	=>	'jquery',
                        		'data'	=>	'
                        			var custom_skin_button = jQuery("#cloudfw-skin-edit-indicator"),
                        				custom_skin_select = jQuery("#'.PFIX.'_custom_skin'.'");

                        			custom_skin_select.on("change", function(){
                        				var custom_skin = custom_skin_select.val();

                        				if ( custom_skin != "" ) {
                        					custom_skin_button.show().attr("href", "'.cloudfw_admin_url('visual', '1').'&id=" + custom_skin);
                        				} else {
                        					custom_skin_button.hide();

                        				}
                        			}).change();


                        		',
                        	)
                        )

                    ), // #### element: 0
                        
                )
            ), 

	    )

	);
	return $metaboxes;
}

/**
 *	Get All Skins Array
 *
 *	@since 1.0
 */
function cloudfw_module_admin_gel_all_skins_array($data, $args){
	$custom_skins_array = (array) cloudfw_get_all_skins();		
	
	krsort($custom_skins_array);	
	$custom_skins[ 'NULL' ] = __('- Primary Skin -','cloudfw'); 

	foreach ((array)$custom_skins_array  as $skin_id) {
			if (!$skin_custom = cloudfw_get_a_skin($skin_id)) continue;
			$custom_skins[ $skin_id ] = $skin_custom["name"];  
						
	}
	return $custom_skins;
	
}