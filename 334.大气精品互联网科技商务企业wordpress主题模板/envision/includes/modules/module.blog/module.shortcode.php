<?php
/*
 * Plugin Name: Blog
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:
 * Attributes:
 */
require_once( trailingslashit(dirname(__FILE__)) . 'class/class.blog.php' );

cloudfw_register_shortcode( 'CloudFw_Shortcode_Blog', 'blog', 'advanced', 25 );
if ( ! class_exists('CloudFw_Shortcode_Blog') ) {
	class CloudFw_Shortcode_Blog extends CloudFw_Shortcodes {
		function get_called_class(){ return get_class($this); }

		public $do_before = false;

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> false,
				'ajax'			=> true,
				'icon'			=> 'comments',
				'group'			=> 'composer_post_list',
				'do_shortcode'	=> false,
				'line'			=> 100,
				'options'		=> array(
					'title'				=> __('Blog','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array() ) {
			require_once( trailingslashit(dirname(__FILE__)) . 'class/class.blog.php' );
			return cloudfw_module( 'CloudFw_Page_Generator_Blog', 'blog', $atts );
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Blog','cloudfw'),
				'ajax'		=>	true,
				'script'	=> array(
					'shortcode'  => 'blog',
					'tag_close'  => false,
					'attributes' =>	array(
						'layout' 			=> array( 'e' => 'blog_layout'),
						'from' 				=> array( 'e' => 'blog_source' ),
						'category'			=> array( 'e' => 'blog_filter_category' ),
						'columns'          	=> array( 'e' => 'blog_columns' ),
						'limit'            	=> array( 'e' => 'blog_limit', 'check-default' => '0' ),
						'pagination'       	=> array( 'e' => 'blog_pagination', 'onoff' => true, 'check-default' => 0 ),

						'title_element'     => array( 'e' => 'blog_title_size', 'onoff' => true ),
						'title_align'    	=> array( 'e' => 'blog_title_align', 'onoff' => true ),

						'excerpt_length' 	=> array( 'e' => 'blog_excerpt_length' ),
						'show_excerpt' 		=> array( 'e' => 'blog_post_excerpt', 'onoff' => true ),
						'meta_author' 		=> array( 'e' => 'blog_meta_author', 'onoff' => true ),
						'meta_date' 		=> array( 'e' => 'blog_meta_date', 'onoff' => true ),
						'meta_category' 	=> array( 'e' => 'blog_meta_category', 'onoff' => true ),

						'meta_comment' 		=> array( 'e' => 'blog_meta_comment', 'onoff' => true ),
						'meta_likes' 		=> array( 'e' => 'blog_meta_likes', 'onoff' => true ),

						'image_ratio'     	=> array( 'e' => 'blog_image_ratio' ),
						'video_ratio'  		=> array( 'e' => 'blog_video_ratio' ),

						'list_style'  		=> array( 'e' => 'blog_post_list_style' ),

						'shadow'  			=> array( 'e' => 'blog_shadow' ),

						'margin_top'     	=> array( 'e' => 'margin_top' ),
						'margin_bottom'  	=> array( 'e' => 'margin_bottom' ),

					),
					'if' =>	array(
						array(
							'type' 	  => 'toggle',
							'e' 	  => 'blog_layout',
							'mode' 	  => 'same',
							'related' => 'blogLayoutOptions',
							'targets' => array(
								array('', '.blogLayoutOptions-Standard, .blogLayoutOptions-Standard-Fullwidth'),
								array('medium', '.blogLayoutOptions-Standard, .blogLayoutOptions-Standard-Medium'),
								array('grid', '.blogLayoutOptions-Grid, .blogLayoutOptions-Grid-Default'),
								array('grid-masonry', '.blogLayoutOptions-Grid, .blogLayoutOptions-Grid-Masonry'),
								array('grid-carousel', '.blogLayoutOptions-Grid, .blogLayoutOptions-Grid-Carousel'),
								array('mini', '.blogLayoutOptions-Mini'),
								array('mini-carousel', '.blogLayoutOptions-Mini, .blogLayoutOptions-Mini-Carousel'),
							)
						),

						array(
							'type' 	  => 'toggle',
							'e' 	  => 'blog_source',
							'related' => 'blogSources',
							'targets' => array(
								array('a category', '#blog_filter_category'),
							)
						),

						array(
							'type' 	  => 'toggle',
							'e' 	  => 'blog_limit',
							'related' => 'blogPaginationOptions',
							'!'		  => true,
							'targets' => array(
								array('0', '#blog_pagination'),
							)
						)

					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Layout','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Layout','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'blog_layout',
										'value'		=>	$this->get_value('blog_layout'),
										'source'	=>	array(
											'NULL' 				=> __('Classic Layout - Fullwidth Thumbnails','cloudfw'),
											'medium' 			=> __('Classic Layout - Medium Thumbnails','cloudfw'),
											'grid' 				=> __('Grid Layout','cloudfw'),
											'grid-masonry'		=> __('Grid Masonry Layout','cloudfw'),
											'grid-carousel'		=> __('Grid Carousel Layout','cloudfw'),
											'mini' 				=> __('Mini Layout','cloudfw'),
											'mini-carousel'		=> __('Mini Carousel Layout','cloudfw'),
										),
										'width'		=> 400,
									), // #### element: 0

								)

							),

							array(
								'type'		=>	'module',
								'related'	=>	'blogLayoutOptions blogLayoutOptions-Grid blogLayoutOptions-Mini',
								'title'		=>	__('Columns','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'slider',
										'id'		=>	'blog_columns',
										'value'		=>	$this->get_value('blog_columns', 3),
										'class'		=>	'input_250',
										'min'		=>	1,
										'max'		=>	4,
										'unit'		=>	__('column(s)','cloudfw')
									)
								)
							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Post Limit / Post Per Page','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'slider',
										'id'		=>	'blog_limit',
										'value'		=>	$this->get_value('blog_limit', 0),
										'class'		=>	'input_250',
										'min'		=>	0,
										'max'		=>	40,
										'step'		=>	1,
										'steps'		=>	array(
											'0'			=>	__('no limit','cloudfw')
										),
										'unit'		=>	'post(s)',
									)
								)

							),

							array(
								'type'		=>	'group',
								'related'	=>	'blogLayoutOptions blogLayoutOptions-Standard blogLayoutOptions-Grid-Default blogLayoutOptions-Grid-Masonry',
								'data'		=>	array(

									array(
										'type'		=>	'module',
										'related'	=>	'blogPaginationOptions',
										'title'		=>	__('Pagination','cloudfw'),
										'data'		=>	array(
											array(
												'type'		=>	'onoff',
												'id'		=>	'blog_pagination',
												'value'		=>	$this->get_value('blog_pagination', 'FALSE'),
											)
										)

									),

								)

							),

							array(
								'type'		=> 'module',
								'related'	=>	'blogLayoutOptions blogLayoutOptions-Standard blogLayoutOptions-Grid',
								'layout'	=> 'split',
								'title'		=> array(__('Thumbnail Image Aspect Ratio','cloudfw'), __('Video Aspect Ratio','cloudfw')),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'blog_image_ratio',
										'value'		=>	$this->get_value('blog_image_ratio', '16:9'),
										'source'	=>	array(
											'type' 		=> 'function',
											'function'	=> 'cloudfw_admin_loop_aspect_ratio',
										),
										'width'		=>  150,
									), // #### element: 0


									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'blog_video_ratio',
										'value'		=>	$this->get_value('blog_video_ratio', '16:9'),
										'source'	=>	array(
											'type' 		=> 'function',
											'function'	=> 'cloudfw_admin_loop_aspect_ratio',
										),
										'width'		=>  150,
									), // #### element: 0

								)

							),


							array(
								'type'		=> 'module',
								'related'	=>	'blogLayoutOptions blogLayoutOptions-Grid',
								'title'		=> __('Box Shadow','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'blog_shadow',
										'value'		=>	$this->get_value('blog_shadow'),
										'source'	=>	array(
											'type'			=> 'function',
											'function'		=> 'cloudfw_admin_loop_shadows',
										),
										'width'		=>	250,

									), // #### element: 0

								)

							),


						)

					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Filter','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Filter','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'blog_source',
										'value'		=>	$this->get_value('blog_source'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'all' 				=> __('No Filter','cloudfw'),
											'a category' 		=> __('Get by a category','cloudfw'),
										)
									), // #### element: 0

								)

							),



							array(
								'type'		=>	'module',
								'related'	=>	'blogSources',
								'hidden'	=>	true,
								'title'		=>	__('Categories','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'blog_filter_category',
										'value'		=>	$this->get_value('blog_filter_category'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_terms',
											'vars'		=>	array('category', __('- Select a category -','cloudfw'))
										)
									), // #### element: 0

								)

							),

						)

					),

					array(
						'type'		=> 'mini-section',
						//'related'	=>	'blogLayoutOptions blogLayoutOptions-Grid blogLayoutOptions-Mini',
						'title'		=> __('Post Titles','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Title Size','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'blog_title_size',
										'value'		=>	$this->get_value('blog_title_size', 'h5'),
										'ui'		=>	true,
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'NULL'		=> __('Default','cloudfw'),
											'h1'		=> 'H1',
											'h2'			=> 'H2',
											'h3'		=> 'H3',
											'h4'		=> 'H4',
											'h5'		=> 'H5',
											'h6'		=> 'H6',
											'strong'	=> __('Strong','cloudfw'),
										)

									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Title Align','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'blog_title_align',
										'value'		=>	$this->get_value('blog_title_align', 'center'),
										'ui'		=>	true,
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'left'		=> __('Left','cloudfw'),
											'center'	=> __('Center','cloudfw'),
											'right'		=> __('Right','cloudfw'),
										)

									), // #### element: 0

								)

							),

						)

					),


					array(
						'type'		=> 'mini-section',
						'related'	=>	'blogLayoutOptions blogLayoutOptions-Standard',
						'title'		=> __('Blog Metas','cloudfw'),
						'data'		=> array(

							array(
								'type'		=>	'module',
								'layout'	=>	'split',
								'title'		=>	array(__('Author','cloudfw'), __('Date','cloudfw')),
								'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	'blog_meta_author',
										'value'		=>	$this->get_value('blog_meta_author', true),
									),

									array(
										'type'		=>	'onoff',
										'id'		=>	'blog_meta_date',
										'value'		=>	$this->get_value('blog_meta_date', true),
									)
								)
							),

							array(
								'type'		=>	'module',
								'layout'	=>	'split',
								'title'		=>	array(__('Category','cloudfw'), __('Comments Count','cloudfw')),
								'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	'blog_meta_category',
										'value'		=>	$this->get_value('blog_meta_category', true),
									),

									array(
										'type'		=>	'onoff',
										'id'		=>	'blog_meta_comment',
										'value'		=>	$this->get_value('blog_meta_comment', true),
									)
								)
							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Likes','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	'blog_meta_likes',
										'value'		=>	$this->get_value('blog_meta_likes', true),
									)
								)
							),

						)

					),

					array(
						'type'		=> 'mini-section',
						//'related'	=>	'blogLayoutOptions blogLayoutOptions-Standard blogLayoutOptions-Grid',
						'title'		=> __('Excerpt','cloudfw'),
						'data'		=> array(

							array(
								'type'		=>	'module',
								'title'		=>	__('Show Post Excerpt','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	'blog_post_excerpt',
										'value'		=>	$this->get_value('blog_post_excerpt', true),
									)
								)

							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Excerpt Length','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'text',
										'id'		=>	'blog_excerpt_length',
										'value'		=>	$this->get_value('blog_excerpt_length', 50),
										'width'		=>	50,
										'unit'		=>	__('words','cloudfw')

									)
								)

							),

						)

					),

					array(
						'type'		=> 'mini-section',
						'related'	=>	'blogLayoutOptions blogLayoutOptions-Standard blogLayoutOptions-Mini',
						'title'		=> __('List Style','cloudfw'),
						'data'		=> array(

							array(
								'type'		=>	'module',
								'title'		=>	__('List Style','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'select',
										'id'		=>	'blog_post_list_style',
										'value'		=>	$this->get_value('blog_post_list_style', 'date'),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_blog_list_styles'
										),
										'width'		=>	250,
									)
								)

							),

						)

					),


					array(
						'type'		=> 'mini-section',
						'title'		=> __('Margins','cloudfw'),
						'data'		=> array(

							array(
								'type'		=>	'global-scheme',
								'scheme'	=>	'margins',
								'this'		=>	$this
							),

						)

					),

				)

			);

		}

		/** Skin map */
		function skin_map( $map ){

			$map  -> id      ( 'blog_footer_date' )
			      -> selector( 'footer .ui--blog-date, footer .ui--blog-date .ui--blog-date-month' )
		          -> sync    ( 'background-color', 'auto-ui_footer_darker', 'background-color' );

			$map  -> id      ( 'blog_footer_date_color' )
			      -> selector( 'footer .ui--blog-date h1, footer .ui--blog-date h2, footer .ui--blog-date h3, footer .ui--blog-date h4, footer .ui--blog-date h5, footer .ui--blog-date h6' )
		          -> sync    ( 'color', 'auto-ui_footer_darker', 'color', true );

			$map  -> id      ( 'sync_blog_footer_date_borders' )
			      -> selector( 'footer .ui--blog-date .ui--blog-date-month, footer .ui--blog-date' )
			      -> sync    ( 'border-color', 'footer', 'background-color' );

			$map  -> id      ( 'blog_footer_icon' )
			      -> selector( 'footer .ui--blog-icon' )
		          -> sync    ( 'background-color', 'auto-ui_footer_darker', 'background-color' )
		          -> sync    ( 'color', 'footer_widgetized', 'color', true );

			$map  -> id      ( 'blog_footer_author' )
			      -> selector( 'footer .ui--blog-side-author img.avatar' )
		          -> sync    ( 'background-color', 'auto-ui_footer_darker', 'background-color' )
		          -> sync    ( 'border-color', 'auto-ui_footer_darker', 'background-color' );

			return cloudfw_UI_box_skin_map( $map, 'ui_blog', '.ui--blog' );

		}


		/** Skin scheme */
		function skin_scheme( $schemes, $data ){

			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Blog Posts Grid','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	cloudfw_UI_box_skin_scheme( $data, 'ui_blog', 'BLOG GRID' ),
				),
				5 //seq

			);

		}

		/** Typo map */
		function typo_map( $map ){
			cloudfw_add_typo_setting( $map, 'blog_single_titles', '.ui--blog-item.layout--single .ui--blog-title', array( 'font-weight' => 600 ), NULL, array( 'font-weight' ));
			cloudfw_add_typo_setting( $map, 'blog_standard_titles', '.ui--blog-item.layout--standard .ui--blog-title, .ui--blog-item.layout--medium .ui--blog-title', array( 'font-weight' => 600 ), NULL, array( 'font-weight' ));
			cloudfw_add_typo_setting( $map, 'blog_grid_titles', '.ui--blog .ui--content-box-title-text', array( 'font-weight' => 600 ), NULL, array( 'font-weight' ));
			cloudfw_add_typo_setting( $map, 'blog_mini_titles', '.ui--blog-item.layout--mini .ui--blog-title, .ui--blog-item.layout--mini-carousel .ui--blog-title', array( 'font-weight' => 600 ), NULL, array( 'font-weight' ));

			$map  -> id       ( 'ui_likes_count_sync' )
			      -> selector ( '.ui--likes-count > span' )
			      -> sync_typo( 'font-weight', 'headings', 'font-weight' )
			      -> sync_typo( 'font-size', 'h4', 'font-size' );

			$map  -> id       ( 'ui_likes_count_strong_sync' )
			      -> selector ( '.ui--likes-count > span > strong' )
			      -> sync_typo( 'font-weight', 'strong_headings', 'font-weight' );

		    return $map;
		}


		/** Typo Scheme */
		function typo_scheme( $scheme, $data, $number ){

			$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
				'type'			=>	'container',
				'width'			=>	940,
				'footer'		=>	false,
				'title'			=>	__('Blog Posts','cloudfw'),
				'data'			=>	array(

					array(
						'type'			=>	'mini-section',
						'title'			=>	__('Post Lists','cloudfw'),
						'data'			=>	array(

							array(
								'type'		=>	'typo-set',
								'title'		=>	__('Blog List - Standard Layout Post Titles','cloudfw'),
								'id'		=>	cloudfw_sanitize('blog_standard_titles'),
								'value'		=>	isset($data['blog_standard_titles']) ? $data['blog_standard_titles'] : NULL,
								'data'		=>	array()

							),


							array(
								'type'		=>	'typo-set',
								'title'		=>	__('Blog List - Grid Layout Post Titles','cloudfw'),
								'id'		=>	cloudfw_sanitize('blog_grid_titles'),
								'value'		=>	isset($data['blog_grid_titles']) ? $data['blog_grid_titles'] : NULL,
								'data'		=>	array()

							),

							array(
								'type'		=>	'typo-set',
								'title'		=>	__('Blog List - Mini Layout Post Titles','cloudfw'),
								'id'		=>	cloudfw_sanitize('blog_mini_titles'),
								'value'		=>	isset($data['blog_mini_titles']) ? $data['blog_mini_titles'] : NULL,
								'data'		=>	array()

							),

						)

					),

					array(
						'type'			=>	'mini-section',
						'title'			=>	__('Single Post Page','cloudfw'),
						'data'			=>	array(

							array(
								'type'		=>	'typo-set',
								'title'		=>	__('Single Page - Post Title','cloudfw'),
								'id'		=>	cloudfw_sanitize('blog_single_titles'),
								'value'		=>	isset($data['blog_single_titles']) ? $data['blog_single_titles'] : NULL,
								'data'		=>	array()

							),

						)

					),



				)


			);

			return $scheme;

		}


		/** Scheme */
		function composer_scheme() {
			return array(
				'data'		=>	array(
					cloudfw_composer_default_dropped_area()
				)
			);
		}

	}

}




/** Class */
class CloudFw_Widget_Blog_List extends CloudFw_Widgets {
	/** Variables */
	private $class;

	/** Init */
	function __construct() {
		$this->WP_Widget(
			/** Base ID */
			'widget_cloudfw_blog_list',
			/** Title */
			__('Theme - Blog Posts','cloudfw'),
			/** Other Options */
			array(
				'classname'   => 'widget_cloudfw_blog_list',
				'description' => '',
			),
			/** Size */
			array( 'width'  => 300 )
		);


	}

	/** Render */
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = isset($instance['title']) ? $instance['title'] : NULL;

		echo $before_widget;
		$title = empty($title) ? '' : apply_filters('widget_title', $title);

		if ( !empty( $title ) )
			echo $before_title . $title . $after_title;

		$instance['columns'] = 1;

		if ( empty($instance['layout']) )
			$instance['layout'] = 'mini-carousel';

		if ( empty($instance['limit']) || !is_numeric($instance['limit']) )
			$instance['limit'] = 2;

		if ( empty($instance['excerpt_length']) || !is_numeric($instance['excerpt_length']) )
			$instance['excerpt_length'] = 10;

		$this->class = new CloudFw_Shortcode_Blog();
		$this->class->is_widget = true;
		$this->class->widget = $this;
		echo $this->class->shortcode( $instance );

		echo $after_widget;
	}

	/** Scheme */
	function scheme( $data = array() ) {

		/** Defaults */
		$data = wp_parse_args( $data, array( 'layout' => 'mini', 'limit' => 2, 'excerpt_length' => 10  ) );

		$scheme = array();
		$scheme['data'] = array(
			array(
				'type'		=>	'json',
				'variable'	=>	'widget_options',
				'data'		=>	array(
					'not_in'		=>	array( 'header-widget-area' )
				)

			),

			## Module Item
			array(
				'type'		=>	'module',
				'title'		=>	__('Title','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'text',
						'id'		=>	$this->get_field_name('title'),
						'value'		=>	isset($data['title']) ? $data['title'] : NULL,
						'_class'	=>	'input_200'
					)
				)
			),

			array(
				'type'		=> 'module',
				'title'		=> __('Title Size','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'select',
						'id'		=>	$this->get_field_name('title_element'),
						'value'		=>	isset($data['title_element']) ? $data['title_element'] : NULL,
						'ui'		=>	true,
						'main_class'=>  'input input_250',
						'source'	=>	array(
							'NULL'		=> __('Default','cloudfw'),
							'h1'		=> 'H1',
							'h2'			=> 'H2',
							'h3'		=> 'H3',
							'h4'		=> 'H4',
							'h5'		=> 'H5',
							'h6'		=> 'H6',
							'strong'	=> __('Strong','cloudfw'),
						)

					), // #### element: 0

				)

			),

			array(
				'type'		=> 'module',
				'title'		=> __('Layout','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'select',
						'id'		=>	$this->get_field_name('layout'),
						'value'		=>	isset($data['layout']) ? $data['layout'] : NULL,
						'source'	=>	array(
							'mini' 				=> __('Mini Layout','cloudfw'),
							'mini-carousel'		=> __('Mini Carousel Layout','cloudfw'),
						),
						'width'		=> 200,
					), // #### element: 0

				)

			),

			array(
				'type'		=> 'module',
				'title'		=> __('List Style','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'select',
						'id'		=>	$this->get_field_name('list_style'),
						'value'		=>	isset($data['list_style']) ? $data['list_style'] : NULL,
						'source'	=>	array(
							'type' 			=> 'function',
							'function'		=> 'cloudfw_admin_loop_blog_list_styles',
						),
						'width'		=> 200,
					), // #### element: 0

				)

			),

			## Module Item
			array(
				'type'		=>	'module',
				'title'		=>	__('Show Excerpt','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'onoff',
						'id'		=>	$this->get_field_name('show_excerpt'),
						'value'		=>	isset($data['show_excerpt']) ? $data['show_excerpt'] : NULL,
					)
				)
			),

			## Module Item
			array(
				'type'		=>	'module',
				'title'		=>	__('Excerpt Length','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'text',
						'id'		=>	$this->get_field_name('excerpt_length'),
						'value'		=>	isset($data['excerpt_length']) ? $data['excerpt_length'] : NULL,
						'width'		=>	50,
						'unit'		=>	__('words','cloudfw')
					)
				)
			),

			array(
				'type'		=>	'module',
				'title'		=>	__('Category Filter','cloudfw'),
				'data'		=>	array(

					## Element
					array(
						'type'		=>	'select',
						'id'		=>	$this->get_field_name('category'),
						'value'		=>	isset($data['category']) ? $data['category'] : NULL,
						'main_class'=>  'input input_250',
						'ui'		=>	true,
						'source'	=>	array(
							'type'		=>	'function',
							'function'	=>	'cloudfw_admin_loop_terms',
							'vars'		=>	array('category', __('All Categories','cloudfw'))
						)
					), // #### element: 0

				)

			),


			## Module Item
			array(
				'type'		=>	'module',
				'title'		=>	__('Post Limit','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'text',
						'id'		=>	$this->get_field_name('limit'),
						'value'		=>	isset($data['limit']) ? $data['limit'] : NULL,
						'width'		=>	70
					)
				)
			),


		);

		return $scheme;

	}

}

/**
 *	Register Widget
 */
register_widget('CloudFw_Widget_Blog_List');