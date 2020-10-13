<?php
/**
 *  Register Module Metaboxes
 *
 *  @package CloudFw
 *  @since   1.0
 */
add_filter( 'cloudfw_metaboxes', 'cloudfw_module_metaboxes_blog', 10, 2 );
function cloudfw_module_metaboxes_blog( $metaboxes, $post_id ) {
	$slugs = array('post'); 

	$metaboxes[ cloudfw_id_for_sequence( $metaboxes, 1 ) ] = array(
		'type'  => 'metabox',
		'id'    => 'cloudfw_metabox_blog_post_settings',
		'title' => __('Blog Post Settings', 'cloudfw'),
		'pages' => $slugs,
		'context' => 'normal',
		'priority' => 'high',
		'data'  => array(

			array(
				'type'      =>  'module',
				'title'     =>  __('Thumbnail Type','cloudfw'),
				'data'      =>  array(
					## Element
					array(
						'type'      =>  'select',
						'id'        =>  PFIX.'_blog_thumbnail_type',
						'value'     =>  get_post_meta($post_id, PFIX.'_blog_thumbnail_type', true),
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
						'related'       => 'blogThumbnailOptions',
						'conditions'    => array(
							array( 'val' => '', 'e' => '.blogThumbnailImageOption' ),
							array( 'val' => 'video', 'e' => '.blogThumbnailVideoOption' ),
						)
					),
				)

			),

			array(
				'type'      =>  'group',
				'related'   =>  'blogThumbnailOptions blogThumbnailVideoOption',
				'data'      =>  array(
		
					array(
						'type'      =>  'module',
						'title'     =>  __('Video Embed Type','cloudfw'),
						'data'      =>  array(
							## Element
							array(
								'type'      =>  'select',
								'id'        =>  PFIX.'_blog_video_type',
								'value'     =>  get_post_meta($post_id, PFIX.'_blog_video_type', true),
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
								'related'       => 'blogVideoOptions',
								'conditions'    => array(
									array( 'val' => '', 'e' => '.blogVideoAuto' ),
									array( 'val' => 'manual', 'e' => '.portfolioVideoManual' ),
								)
							),
						)

					),

					array(
						'type'      =>  'module',
						'title'     =>  __('Video URL','cloudfw'),
						'related'   =>  'blogVideoOptions blogVideoAuto',
						'data'      =>  array(
							## Element
							array(
								'type'      =>  'text',
								'id'        =>  PFIX.'_blog_video',
								'value'     =>  get_post_meta($post_id, PFIX.'_blog_video', true),
								'_class'    =>  'input_400',
								'desc'      => __('E.g:', 'cloudfw') . "<code>http://www.youtube.com/watch?v=3_FueKBoROa</code>",
						   ), // #### element: 0
								
						)

					),

					array(
						'type'      =>  'module',
						'title'     =>  __('Custom Video Embed Code','cloudfw'),
						'related'   =>  'blogVideoOptions portfolioVideoManual',
						'data'      =>  array(
							## Element
							array(
								'type'      =>  'textarea',
								'id'        =>  PFIX.'_blog_video_embed_code',
								'value'     =>  get_post_meta($post_id, PFIX.'_blog_video_embed_code', true),
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
				'title'     =>  __('Custom Link','cloudfw'),
				'data'      =>  array(
					## Element
					array(
						'type'      =>  'page-selector',
						'id'        =>  PFIX.'_blog_custom_link',
						'value'     =>  get_post_meta($post_id, PFIX.'_blog_custom_link', true),
						'response'  =>  'URL',
				   ), // #### element: 0
						
				)

			),

		)

	);


	$metaboxes[ cloudfw_id_for_sequence( $metaboxes, 1 ) ] = array(
		'type'  => 'metabox',
		'id'    => 'cloudfw_metabox_blog_settings',
		'title' => __('Single Blog Page Options', 'cloudfw'),
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
				'condition' =>  _check_onoff( cloudfw_get_option( 'blog',  'related_posts' ) ),
				'title'     =>  __('Display Related Posts?','cloudfw'),
				'data'      =>  array(
					## Element
					array(
						'type'      =>  'select',
						'id'        =>  PFIX.'_related_posts',
						'value'     =>  get_post_meta($post_id, PFIX.'_related_posts', true),
						'source'    =>  array(
							'NULL'      =>  __('Use Global Setting','cloudfw'),
							'show'      =>  __('Display','cloudfw'),
							'hide'      =>  __('Don\'t Display','cloudfw'),
						),
						'class'     =>  'select',
						'main_class'=>  'input input_300',
				   ), // #### element: 0
						
				)

			),

			array(
				'type'      =>  'module',
				'title'     =>  __('Display Featured Image on Single Blog Post Page?','cloudfw'),
				'data'      =>  array(
					## Element
					array(
						'type'      =>  'select',
						'id'        =>  PFIX.'_display_featured',
						'value'     =>  get_post_meta($post_id, PFIX.'_display_featured', true),
						'source'    =>  array(
							'NULL'      =>  __('Use Global Setting','cloudfw'),
							'show'      =>  __('Display','cloudfw'),
							'hide'      =>  __('Don\'t Display','cloudfw'),
						),
						'class'     =>  'select',
						'main_class'=>  'input input_300',
				   ), // #### element: 0
						
				)

			),

			array(
				'type'      =>  'module',
				'title'     =>  __('Display Post Title on Single Blog Post Page?','cloudfw'),
				'data'      =>  array(
					## Element
					array(
						'type'      =>  'select',
						'id'        =>  PFIX.'_display_title',
						'value'     =>  get_post_meta($post_id, PFIX.'_display_title', true),
						'source'    =>  array(
							'NULL'      =>  __('Use Global Setting','cloudfw'),
							'show'      =>  __('Display','cloudfw'),
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
		'id'    => 'cloudfw_metabox_blog_galleries',
		'title' => __('Blog Gallery Options', 'cloudfw'),
		'pages' => $slugs,
		'context' => 'normal',
		'priority' => 'high',
		'data'  => array(

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
									'indicator' => get_post_meta($post_id, PFIX.'_blog_gallery_indicator', true),
									'dummy'     => true,
									'data'      => 

										array(
											'type'      =>  'gallery',
											'sync'      =>  PFIX.'_blog_gallery_image',
											'value'		=> 	get_post_meta($post_id, PFIX.'_blog_gallery_image', true),
											'data'      =>  array(

												## Module Item
												array(
													'type'      =>  'indicator',
													'id'        =>  PFIX.'_blog_gallery_indicator',
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
															'id'        =>  PFIX.'_blog_gallery_image',
															'value'     =>  get_post_meta($post_id, PFIX.'_blog_gallery_image', true),
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
						'data'      =>  '<a data-target="" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Gallery Item','cloudfw').'</span></a><a data-target="" class="cloudfw-action-gallery-from-library cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-grey" href="javascript:;"><span>'.__('Insert from Media Library','cloudfw').'</span></a>
						',
					), // #### element: 0

						
				),
			),



		)

	);



	return $metaboxes;
}
