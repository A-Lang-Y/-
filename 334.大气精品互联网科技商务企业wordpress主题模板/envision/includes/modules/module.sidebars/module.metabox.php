<?php
/**
 *	Register Module Metaboxes
 *
 *	@package CloudFw
 *	@since 	 1.0
 */
add_filter( 'cloudfw_metaboxes', 'cloudfw_module_sidebar_metaboxes', 10, 2 );

function cloudfw_module_sidebar_metaboxes( $metaboxes, $post_id ) {
    global $wp_registered_sidebars;
    $seq = cloudfw_id_for_sequence( $metaboxes ); 

    $sidebars = array(
        'default-widget-area',
        'header-widget-area',
        'header-widget-area-2',
        'blog-widget-area',
        'footer-widget-area-1',
        'footer-widget-area-2',
        'footer-widget-area-3',
        'footer-widget-area-4',
        'footer-widget-area-5',
        'footer-widget-area-6',
    );

    $registered_sidebars = array();
    foreach ($sidebars as $id) {
        $registered_sidebars[ $id ] = (isset($wp_registered_sidebars[ $id ]['name']) && !empty($wp_registered_sidebars[ $id ]['name'])) ? $wp_registered_sidebars[ $id ]['name'] : $id;     
    }

    $metaboxes[ $seq ] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_metabox_sidebars',
        'title' => __('Custom Sidebars', 'cloudfw'),
        'pages' => array(
            'page', 'portfolio'
        ),
        'context' => 'normal',
        'priority' => 'high',
        'data'  => array(),
    );

    
    foreach ($registered_sidebars as $sidebar_id => $sidebar_name) {
        //if ( empty($sidebar_name) )
        //   continue;

        $metaboxes[ $seq ]['data'][] = array(
            'type'      =>  'module',
            'title'     =>  $sidebar_name,
            'data'      =>  array(
                ## Element
                array(
                    'type'      =>  'select',
                    'id'        =>  PFIX.'_cs_' . $sidebar_id,
                    'value'     =>  get_post_meta($post_id, PFIX.'_cs_' . $sidebar_id, true),
                    'source'    =>  array(
                        'type'      =>  'function',
                        'function'  =>  'cloudfw_admin_loop_custom_sidebars'
                    ),
                    'ui'        =>  true,
                    'main_class'=>  'input input_200'

               ), // #### element: 0
                    
            )

        );

    }

	return $metaboxes;
}


add_filter('cloudfw_sidebar', 'cloudfw_sidebar_callback', 10, 2);
function cloudfw_sidebar_callback( $sidebar ){
    $custom_sidebar = cloudfw('get_meta', 'cs_' . $sidebar);
    if ( !empty($custom_sidebar) )
        return is_array($custom_sidebar) ? $custom_sidebar[0] : $custom_sidebar;

    return $sidebar;
}