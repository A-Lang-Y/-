<?php
/**
 *	Register Module Metaboxes
 *
 *	@package CloudFw
 *	@since 	 1.0
 */
add_filter( 'cloudfw_metaboxes', 'cloudfw_module_metaboxes_portfolio', 10, 2 );
function cloudfw_module_metaboxes_portfolio( $metaboxes, $post_id ) {
    $slugs = array('portfolio'); 

    $metaboxes[ cloudfw_id_for_sequence( $metaboxes, 1 ) ] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_metabox_portfolio_settings_list',
        'title' => __('Portfolio Settings for Post Lists', 'cloudfw'),
        'pages' => $slugs,
        'context' => 'normal',
        'priority' => 'high',
        'data'  => array(

        
            array(
                'type'      =>  'module',
                'title'     =>  __('Caption Text','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'text',
                        'id'        =>  PFIX.'_port_caption',
                        'value'     =>  get_post_meta($post_id, PFIX.'_port_caption', true),
                        'width'     =>  400,
                        'editor'    =>  true,
                   ), // #### element: 0
                        
                )

            ),


        
            array(
                'type'      =>  'module',
                'title'     =>  __('Description Text','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'textarea',
                        'id'        =>  PFIX.'_port_desc',
                        'value'     =>  get_post_meta($post_id, PFIX.'_port_desc', true),
                        'line'      =>  3,
                        'width'     =>  '95%',
                        'editor'    =>  true,
                        'autogrow'  =>  true,

                   ), // #### element: 0
                        
                )

            ),

            array(
                'type'      =>  'module',
                'title'     =>  __('Link Action','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  PFIX.'_port_link_action',
                        'value'     =>  get_post_meta($post_id, PFIX.'_port_link_action', true),
                        'source'    =>  array(
                            'goto'      => __('Classic: Go to post page', 'cloudfw'),
                            'lightbox'  => __('Lightbox: Display this post\'s image(s) or video in lightbox', 'cloudfw'),
                            'nolink'    => __('No Link', 'cloudfw'),
                        ),
                        'class'     =>  'select',
                        //'main_class'=>  'input input_300',
                        'width'     =>  400
                    ), // #### element: 0
                        
                ),
                'js'        => array(
                    ## Script Item
                    array(
                        'type'          => 'toggle',
                        'related'       => 'portfolioOptions',
                        'conditions'    => array(
                            array( 'val' => 'goto', 'e' => '.portfolioGotoOption' ),
                            array( 'val' => 'lightbox', 'e' => '.portfolioLightboxOption' ),
                        )
                    ),
                )

            ),
        
            array(
                'type'      =>  'module',
                'title'     =>  __('Custom Full Size Image for Lightbox','cloudfw'),
                'related'   =>  'portfolioOptions portfolioLightboxOption',
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'upload',
                        'id'        =>  PFIX.'_port_custom_image',
                        'value'     =>  get_post_meta($post_id, PFIX.'_port_custom_image', true),
                        'desc'      => __('(optional) it\'s full size of featured image as default', 'cloudfw'),
                        'hide_input'=> true,
                        'removable' => true,
                        'library'   => true,
                   ), // #### element: 0
                        
                )

            ),

            array(
                'type'      =>  'module',
                'title'     =>  __('Custom URL','cloudfw'),
                'related'   =>  'portfolioOptions portfolioGotoOption portfolioLightboxOption',
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'page-selector',
                        'id'        =>  PFIX.'_port_custom_link',
                        'value'     =>  get_post_meta($post_id, PFIX.'_port_custom_link', true),
                        '_class'    =>  'input_400',
                        'desc'      =>  __('Default: Post permalink','cloudfw'),
                   ), // #### element: 0
                        
                )
            ),

            array(
                'type'      =>  'module',
                'title'     =>  __('Thumbnail Type','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  PFIX.'_port_thumbnail_type',
                        'value'     =>  get_post_meta($post_id, PFIX.'_port_thumbnail_type', true),
                        'source'    =>  array(
                            'NULL'      => __('Featured Image or Gallery', 'cloudfw'),
                            'video'     => __('Video', 'cloudfw'),
                        ),
                        'class'     =>  'select',
                        'width'     =>  400
                    ), // #### element: 0
                        
                ),
                'js'        => array(
                    ## Script Item
                    array(
                        'type'          => 'toggle',
                        'related'       => 'portfolioThumbnailOptions',
                        'conditions'    => array(
                            array( 'val' => '', 'e' => '.portfolioThumbnailImageOption' ),
                            array( 'val' => 'video', 'e' => '.portfolioThumbnailVideoOption' ),
                        )
                    ),
                )

            ),

            array(
                'type'      =>  'group',
                'related'   =>  'portfolioThumbnailOptions portfolioThumbnailVideoOption',
                'data'      =>  array(
        
                    array(
                        'type'      =>  'module',
                        'title'     =>  __('Video Embed Type','cloudfw'),
                        'data'      =>  array(
                            ## Element
                            array(
                                'type'      =>  'select',
                                'id'        =>  PFIX.'_port_video_type',
                                'value'     =>  get_post_meta($post_id, PFIX.'_port_video_type', true),
                                'source'    =>  array(
                                    'NULL'      => __('Auto', 'cloudfw'),
                                    'manual'    => __('Manual Embed Code', 'cloudfw'),
                                ),
                                'class'     =>  'select',
                                'width'     =>  400
                            ), // #### element: 0
                                
                        ),
                        'js'        => array(
                            ## Script Item
                            array(
                                'type'          => 'toggle',
                                'related'       => 'portfolioVideoOptions',
                                'conditions'    => array(
                                    array( 'val' => '', 'e' => '.portfolioVideoAuto' ),
                                    array( 'val' => 'manual', 'e' => '.portfolioVideoManual' ),
                                )
                            ),
                        )

                    ),

                    array(
                        'type'      =>  'module',
                        'title'     =>  __('Video URL','cloudfw'),
                        'related'   =>  'portfolioVideoOptions portfolioVideoAuto',
                        'data'      =>  array(
                            ## Element
                            array(
                                'type'      =>  'text',
                                'id'        =>  PFIX.'_port_video',
                                'value'     =>  get_post_meta($post_id, PFIX.'_port_video', true),
                                '_class'    =>  'input_400',
                                'desc'      => __('E.g:', 'cloudfw') . "<code>http://www.youtube.com/watch?v=3_FueKBoROa</code>",
                           ), // #### element: 0
                                
                        )

                    ),

                    array(
                        'type'      =>  'module',
                        'title'     =>  __('Custom Video Embed Code','cloudfw'),
                        'related'   =>  'portfolioVideoOptions portfolioVideoManual',
                        'data'      =>  array(
                            ## Element
                            array(
                                'type'      =>  'textarea',
                                'id'        =>  PFIX.'_port_video_embed_code',
                                'value'     =>  get_post_meta($post_id, PFIX.'_port_video_embed_code', true),
                                '_class'    =>  'tab-textfields tabtext',
                                'width'     =>  '95%',
                                'line'      =>  3,
                           ), // #### element: 0
                                
                        )

                    ),

                )
            ),

            array(
                'type'      =>  'module',
                'title'     =>  __('Thumbnail Hover Icon','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'icon-selector',
                        'id'        =>  PFIX.'_port_icon',
                        'value'     =>  get_post_meta($post_id, PFIX.'_port_icon', true),
                    ), // #### element: 0
                        
                ),
            ),

            array(
                'type'      =>  'module',
                'title'     =>  __('Thumbnail Hover Button Text','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'text',
                        'id'        =>  PFIX.'_port_default_button_text',
                        'value'     =>  get_post_meta($post_id, PFIX.'_port_default_button_text', true),
                    ), // #### element: 0
                        
                ),
            ),

        )

    );


	$metaboxes[ cloudfw_id_for_sequence( $metaboxes, 1 ) ] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_metabox_portfolio_settings',
        'title' => __('Portfolio Settings for Detail Page', 'cloudfw'),
        'pages' => $slugs,
        'context' => 'normal',
        'priority' => 'high',
        'data'  => array(

            array(
                'type'      =>  'module',
                'title'     =>  __('Page Template','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  '_wp_page_template',
                        'value'     =>  get_post_meta($post_id, '_wp_page_template', true),
                        'source'    =>  array(
                            'type'      =>  'function',
                            'function'  =>  'cloudfw_admin_loop_page_templates'
                        ),
                        'class'     =>  'select',
                        'main_class'=>  'input input_300',
                    ), // #### element: 0
                        
                )
            ),

            array(
                'type'      =>  'module',
                'condition' =>  cloudfw_check_onoff( 'portfolio',  'comments' ),
                'title'     =>  __('Display Comments?','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  PFIX.'_comments_enable',
                        'value'     =>  get_post_meta($post_id, PFIX.'_comments_enable', true),
                        'source'    =>  array(
                            'NULL'      =>  __('Display','cloudfw'),
                            'hide'      =>  __('Don\'t Display','cloudfw'),
                        ),
                        'class'     =>  'select',
                        'main_class'=>  'input input_300',
                   ), // #### element: 0
                        
                )

            ),
                
            array(
                'type'      =>  'module',
                'condition' =>  cloudfw_check_onoff( 'portfolio',  'related_posts' ),
                'title'     =>  __('Display Related Portfolio Posts?','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  PFIX.'_related_posts',
                        'value'     =>  get_post_meta($post_id, PFIX.'_related_posts', true),
                        'source'    =>  array(
                            'NULL'      =>  __('Display','cloudfw'),
                            'hide'      =>  __('Don\'t Display','cloudfw'),
                        ),
                        'class'     =>  'select',
                        'main_class'=>  'input input_300',
                   ), // #### element: 0
                        
                )

            ),
                
        )

    );

    $metaboxes[ cloudfw_id_for_sequence( $metaboxes, 1 ) ] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_metabox_portfolio_galleries',
        'title' => __('Portfolio Gallery Options', 'cloudfw'),
        'pages' => $slugs,
        'context' => 'normal',
        'priority' => 'high',
        'data'  => array(

            array(
                'type'      =>  'module',
                'title'     =>  __('Show gallery images instead of post thumbnail in portfolio post list?','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'onoff',
                        'id'        =>  PFIX.'_gallery_in_list',
                        'value'     =>  get_post_meta($post_id, PFIX.'_gallery_in_list', true),
                        'default'   =>  'FALSE',
                   ), // #### element: 0
                        
                )
            ),

            array(
                'type'      =>  'module',
                'title'     =>  __('Show gallery images in lightbox?','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'onoff',
                        'id'        =>  PFIX.'_gallery_in_lightbox',
                        'value'     =>  get_post_meta($post_id, PFIX.'_gallery_in_lightbox', true),
                        'default'   =>  'FALSE',
                   ), // #### element: 0
                        
                ),
                'js'        => array(
                    ## Script Item
                    array(
                        'type'          => 'toggle',
                        'related'       => 'portfolioLightboxGalleryOptions',
                        'conditions'    => array(
                            array( 'val' => '1', 'e' => '.portfolioLightboxGalleryAddFetured' ),
                        )
                    ),
                )
            ),

            array(
                'type'      =>  'module',
                'title'     =>  __('Add the featured image to the lightbox gallery?','cloudfw'),
                'related'   =>  'portfolioLightboxGalleryOptions portfolioLightboxGalleryAddFetured',
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'onoff',
                        'id'        =>  PFIX.'_gallery_in_lightbox_featured',
                        'value'     =>  get_post_meta($post_id, PFIX.'_gallery_in_lightbox_featured', true),
                        'default'   =>  true,
                   ), // #### element: 0
                        
                )
            ),


            array(
                'type'      =>  'module',
                'layout'    =>  'raw',
                'data'      =>  array(

                    array(
                        'type'      =>  'sorting',
                        'id'        =>  'gallery',
                        'item:id'   =>  'gallery_clone',
                        'axis'      =>  'both',
                        'data'      => 

                            cloudfw_core_loop_multi_option( 
                                
                                array(
                                    'start'     => 5,
                                    'indicator' => get_post_meta($post_id, PFIX.'_port_gallery_indicator', true),
                                    'dummy'     => true,
                                    'data'      => 

                                        array(
                                            'type'      =>  'gallery',
                                            'sync'      =>  PFIX.'_port_gallery_image',
                                            'data'      =>  array(

                                                ## Module Item
                                                array(
                                                    'type'      =>  'indicator',
                                                    'id'        =>  PFIX.'_port_gallery_indicator',
                                                ),

                                                ## Module Item
                                                array(
                                                    'type'      =>  'module',
                                                    'title'     =>  __('Image','cloudfw'),
                                                    'data'      =>  array(

                                                        ## Element
                                                        array(
                                                            'type'      =>  'upload',
                                                            'title'     =>  __('Image','cloudfw'),
                                                            'id'        =>  PFIX.'_port_gallery_image',
                                                            'value'     =>  get_post_meta($post_id, PFIX.'_port_gallery_image', true),
                                                            'reset'     =>  '',
                                                            'brackets'  =>  true,
                                                            'store'     =>  true,
                                                            'removable' =>  true,
                                                            'library'   =>  true,
                                                            'hide_input'=>  true,

                                                        ),

                                                    )

                                                ),

                                            )

                                        ),

                                )

                            )

                    ),

                    ## Element
                    array(
                        'type'      =>  'html',
                        'data'      =>  '<a data-target="" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Gallery Item','cloudfw').'</span></a><a data-target="" class="cloudfw-action-gallery-from-library cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-grey" href="javascript:;"><span>'.__('Insert from Media Library','cloudfw').'</span></a>',
                    ), // #### element: 0

                        
                ),
            ),



        )

    );



	return $metaboxes;
}
