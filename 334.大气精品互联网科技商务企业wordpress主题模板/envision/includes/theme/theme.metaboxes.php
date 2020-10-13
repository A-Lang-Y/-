<?php

function cloudfw_metaboxes( $key = NULL, $post_id = -1 ){

    global $opt;

    /* Load Metabox Sources */
    include_once( TMP_PATH.'/cloudfw/core/framework/source.options.php');
    include_once( TMP_PATH.'/cloudfw/core/engine.metabox/source.metabox.php' );
    include_once( TMP_PATH.'/cloudfw/core/engine.shortcode/source.shortcodes.php' );

    $post_types_core = apply_filters( 'cloudfw_post_types_for_core_metaboxes', array( 'page', 'post' ) );
    $post_types_composer = apply_filters( 'cloudfw_post_types_for_composer', array( 'page', 'post' ) );
    $post_types_all = apply_filters( 'cloudfw_all_post_types_for_core_metaboxes', cloudfw_get_all_post_types() );
    $meta_boxes = array();

    /*-----------------------------------------------------------------------------------*/
    /*  Metabox: Composer
    /*-----------------------------------------------------------------------------------*/

    $meta_boxes[cloudfw_id_for_sequence( $metaboxes, 0 )] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_composer_metabox',
        'title' => __('Content Composer', 'cloudfw') . '<sup id="composer-beta">beta</sup>',
        'pages' => $post_types_composer,
        'context'   => 'normal',
        'priority'  => 'high',
        'data'      => array(
            array(
                'type'      => 'render:composer'
            ),
        )
    );

    /*-----------------------------------------------------------------------------------*/
    /*  Metabox: Shortcodes
    /*-----------------------------------------------------------------------------------*/

    /*$meta_boxes[cloudfw_id_for_sequence( $metaboxes, 0 )] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_shortcodes',
        'title' => __('Shortcode Generator', 'cloudfw'),
        'pages' => $post_types_composer,
        'context'   => 'normal',
        'priority'  => 'high',
        'data'      => array(
            array(
                'type'      => 'render:shortcodes'
            ),
        )
    );*/

    /*-----------------------------------------------------------------------------------*/
    /*  Metabox: Header Slider
    /*-----------------------------------------------------------------------------------*/

    $meta_boxes[cloudfw_id_for_sequence( $metaboxes, 15 )] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_metabox_header_slider',
        'title' => __('Slider', 'cloudfw'),
        'pages' => $post_types_core,
        'context' => 'side',
        'priority' => 'high',
        'data'  => array(
        
            array(
                'type'      =>  'module',
                'title'     =>  __('Sliders','cloudfw'),
                'data'      =>  array(

                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  PFIX.'_rev_slider',
                        'value'     =>  cloudfw_get_post_meta($post_id, 'rev_slider'),
                        'source'    =>  array(
                                'type'      =>  'function',
                                'function'  =>  'cloudfw_admin_loop_rev_sliders'
                        ),
                        'width'     =>  230
                    ), // #### element: 0
                        
                )

            ),

            array(
                'type'      =>  'module',
                'title'     =>  __('Visibility','cloudfw'),
                'data'      =>  array(

                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  PFIX.'_rev_slider_visibility',
                        'value'     =>  cloudfw_get_post_meta($post_id, 'rev_slider_visibility'),
                        'source'    =>  array(
                            'type'      =>  'function',
                            'function'  =>  'cloudfw_admin_get_visibility_options'
                        ),
                        'width'     =>  230
                    ), // #### element: 0
                        
                )

            ),

            array(
                'type'      =>  'module',
                'title'     =>  __('Slider Shadow','cloudfw'),
                'data'      =>  array(

                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  PFIX.'_rev_slider_shadow',
                        'value'     =>  cloudfw_get_post_meta($post_id, 'rev_slider_shadow'),
                        'source'    =>  array(
                            'type'      =>  'function',
                            'function'  =>  'cloudfw_admin_loop_shadows'
                        ),
                        'width'     =>  230
                    ), // #### element: 0
                        
                )

            ),
        
        )

    );

    /*-----------------------------------------------------------------------------------*/
    /*  Metabox: Blurb Area
    /*-----------------------------------------------------------------------------------*/

    $meta_boxes[cloudfw_id_for_sequence( $metaboxes, 20 )] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_metabox_titlebar_area',
        'title' => __('Page Options', 'cloudfw'),
        'pages' => $post_types_core,
        'context' => 'normal',
        'priority' => 'high',
        'data'  => array(

            array(
                'type'      => 'mini-section',
                'title'     => __('Title Bar','cloudfw'),
                'data'      => array(

                
                    array(
                        'type'      =>  'module',
                        'title'     =>  __('Show Titlebar','cloudfw'),
                        'data'      =>  array(
                            ## Element
                            array(
                                'type'      =>  'onoff',
                                'id'        =>  PFIX.'_titlebar',
                                'value'     =>  cloudfw_get_post_meta($post_id, 'titlebar', true),
                            ), // #### element: 0
                                
                        ),
                        'js'        => array(
                            ## Script Item
                            array(
                                'type'          => 'toggle',
                                'related'       => 'titlebarOptions',
                                'conditions'    => array(
                                    array( 'val' => '1', 'e' => '.titlebarOptions' ),
                                )
                            ),

                        )
                        
                    ), 


                    array(
                        'type'      => 'group',
                        'related'   =>  'titlebarOptions',
                        'data'      => array(


                            array(
                                'type'      =>  'module',
                                'title'     =>  __('Titlebar Title','cloudfw'),
                                'data'      =>  array(
                                    ## Element
                                    array(
                                        'type'      =>  'text',
                                        'id'        =>  PFIX.'_titlebar_title',
                                        'value'     =>  cloudfw_get_post_meta($post_id, 'titlebar_title'),
                                        'class'     =>  'input input_400 bold',
                                        'editor'    =>  true,
                                        'holder'    =>  get_the_title()
                                    ), // #### element: 0
                                        
                                )

                            ), 
                        
                            array(
                                'type'      =>  'module',
                                'title'     =>  __('Titlebar Title Second Line / Description Text','cloudfw'),
                                'data'      =>  array(
                                    ## Element
                                    array(
                                        'type'      =>  'textarea',
                                        'id'        =>  PFIX.'_titlebar_text',
                                        'value'     =>  cloudfw_get_post_meta($post_id, 'titlebar_text'),
                                        '_class'    =>  'textarea_95per_3line',
                                        'editor'    =>  true
                                    ), // #### element: 0
                                        
                                )
                            ), 

                            array(
                                'type'      =>  'module',
                                'title'     =>  __('Titlebar Layout','cloudfw'),
                                'data'      =>  array(
                                    ## Element
                                    array(
                                        'type'      =>  'select',
                                        'id'        =>  PFIX.'_titlebar_orientation',
                                        'value'     =>  cloudfw_get_post_meta($post_id, 'titlebar_orientation'),
                                        'source'    =>  array(
                                            'NULL'      => __('Title / BreadCrumb', 'cloudfw'),
                                            'right'     => __('BreadCrumb / Title', 'cloudfw'),
                                        ),
                                        'ui'        =>  true,
                                        'width'     =>  200,
                                    ), // #### element: 0
                                        
                                )
                            ), 

                            array(
                                'type'      => 'module',
                                'title'     => __('Titlebar Style','cloudfw'),
                                'data'      => array(

                                    ## Element
                                    array(
                                        'type'      =>  'select',
                                        'id'        =>  PFIX.'_titlebar_style',
                                        'value'     =>  cloudfw_get_post_meta($post_id, 'titlebar_style'),
                                        'source'    =>  array(
                                            'type'          => 'function',
                                            'function'      => 'cloudfw_admin_loop_titlebar_styles',
                                        ),
                                        'ui'        =>  true,
                                        'main_class'=>  'input input_300',
                                        'action_link'=>  '<a class="cloudfw-ui-action-link" target="_blank" href="'. cloudfw_admin_url('visual') .'#titlebar_styles"><i class="cloudfw-ui-icon cloudfw-ui-icon-plus"></i>'.__('Add New','cloudfw').'</a>'
                                    )

                                )

                            ),

                            array(
                                'type'      =>  'module',
                                'title'     =>  __('Titlebar Override Background Image','cloudfw'),
                                'data'      =>  array(
                                    ## Element
                                    array(
                                        'type'      =>  'upload',
                                        'id'        =>  PFIX.'_titlebar_background_image',
                                        'value'     =>  cloudfw_get_post_meta($post_id, 'titlebar_background_image'),
                                        'hide_input'=>  true,
                                        'removable' =>  true,
                                        'store'     =>  true,
                                        'library'   =>  true,
                                    ), // #### element: 0
                                        
                                )

                            ), 

                            array(
                                'type'      => 'module',
                                'title'     => __('Titlebar Override Background Style','cloudfw'),
                                'data'      => array(

                                    ## Element
                                    array(
                                        'type'      =>  'select',
                                        'id'        =>  PFIX.'_titlebar_background_style',
                                        'value'     =>  cloudfw_get_post_meta($post_id, 'titlebar_background_style'),
                                        'source'    =>  array(
                                            'NULL'      =>  __('The same with the style option','cloudfw'),
                                            'cover'     =>  __('Cover','cloudfw'),
                                            'repeat'    =>  __('Repeated Image','cloudfw'),
                                        ),
                                        'main_class'=>  'input input_300',
                                    )

                                )

                            ),

                            array(
                                'type'      => 'module',
                                'title'     => __('Display Title?','cloudfw'),
                                'data'      => array(

                                    ## Element
                                    array(
                                        'type'      =>  'select',
                                        'id'        =>  PFIX.'_titlebar_display_title',
                                        'value'     =>  cloudfw_get_post_meta($post_id, 'titlebar_display_title'),
                                        'source'    =>  array(
                                            'NULL'      => __('Default', 'cloudfw'),
                                            'on'        => __('Display', 'cloudfw'),
                                            'off'       => __('Don\'t display', 'cloudfw')
                                        ),
                                        'ui'        =>  true,
                                        'width'     =>  200,
                                    )

                                )

                            ),  

                            array(
                                'type'      => 'module',
                                'title'     => __('Display BreadCrumb?','cloudfw'),
                                'data'      => array(

                                    ## Element
                                    array(
                                        'type'      =>  'select',
                                        'id'        =>  PFIX.'_breadcrumb',
                                        'value'     =>  cloudfw_get_post_meta($post_id, 'breadcrumb'),
                                        'source'    =>  array(
                                            'NULL'      => __('Default', 'cloudfw'),
                                            'on'        => __('Display', 'cloudfw'),
                                            'off'       => __('Don\'t display', 'cloudfw')
                                        ),
                                        'ui'        =>  true,
                                        'width'     =>  200,
                                    )

                                )

                            ),  

                            array(
                                'type'      => 'module',
                                'conditions' => get_post_type() == 'page',
                                'title'     => __('Allow Comments for The Page?','cloudfw'),
                                'data'      => array(

                                    ## Element
                                    array(
                                        'type'      =>  'select',
                                        'id'        =>  PFIX.'_comments_allow',
                                        'value'     =>  cloudfw_get_post_meta($post_id, 'comments_allow'),
                                        'source'    =>  array(
                                            'NULL'      => __('Default', 'cloudfw'),
                                            'on'        => __('Allow', 'cloudfw'),
                                            'off'       => __('Don\'t allow', 'cloudfw')
                                        ),
                                        'ui'        =>  true,
                                        'width'     =>  200,
                                    )

                                )

                            ),  

                        )

                    ),  

                )

            ),  


        )

    );

    /*-----------------------------------------------------------------------------------*/
    /*  Metabox: Custom Sidebar
    /*-----------------------------------------------------------------------------------*/

    $meta_boxes[cloudfw_id_for_sequence( $metaboxes, 40 )] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_metabox_sidebar',
        'title' => __('Custom Sidebar', 'cloudfw'),
        'pages' => $post_types_core,
        'context' => 'side',
        'priority' => 'high',
        'data'  => array(
        
            array(
                'type'      =>  'module',
                'title'     =>  __('Sidebars','cloudfw'),
                'data'      =>  array(

                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  PFIX.'_custom_sidebar',
                        'value'     =>  get_post_meta($post_id, PFIX.'_custom_sidebar', true),
                        'source'    =>  array(
                                'type'      =>  'function',
                                'function'  =>  'cloudfw_admin_loop_custom_sidebars'
                        ),
                        'action_link'      =>  '<a class="cloudfw-ui-action-link cloudfw-tooltip" title="'. __('Add New Sidebar','cloudfw') .'" href="'. cloudfw_admin_url('global') .'#sidebar_manager" target="_blank" style="margin: 3px 0 0 5px;"><i class="cloudfw-ui-icon cloudfw-ui-icon-plus"></i></a>',
                        'width'     =>  195
                    ), // #### element: 0
                        
                )
            ),
        
        )

    );

    $meta_boxes = apply_filters('cloudfw_metaboxes', $meta_boxes, $post_id, $post_types_core );
    ksort( $meta_boxes );

    return isset( $key ) ? $meta_boxes[$key] : $meta_boxes;
}