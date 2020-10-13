<?php

/*
 * Plugin Name: Sub Pages
 * Plugin URI: http://cloudfw.net
 * Description: MailChimp
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */

if ( !class_exists('CloudFw_Widget_Subpost') ) {

	/** Class */
	class CloudFw_Widget_Subpost extends CloudFw_Widgets{

		/** Init */
		function __construct() {
			$this->WP_Widget(
				/** Base ID */
				'cloudfw_subpages',
				/** Title */
				__('Theme - Sub Pages List','cloudfw'),
				/** Other Options */
				array(
					'classname'   => 'widget_cloudfw_subpages',
					'description' => __('Gets sub posts list of a post','cloudfw'),
				),
				/** Size */
				array( 'width'  => 300 )
			);
		}

		/** Render */
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			extract($instance, EXTR_SKIP);

			if ( empty( $page_id ) ) {
				$page_id = get_queried_object_id();
			}

			$parent_page = get_page( $page_id );

			if ( empty( $parent_page ) ) {
				return;
			}

			$hide_title = isset($hide_title) ? $hide_title : FALSE;

			if ( empty( $title ) ) {
				if ( ! empty( $parent_page->ID ) ) {
					$title = get_the_title( $parent_page->ID );
				}
			}

			if ( empty( $style ) ) {
				$style = 'default';
			}

			if ( $style == 'default' ) {
				$ul_style = 'ui--widget-subpages-smooth ui--box';
				$first_level_class = 'ui--gradient ui--gradient-grey';
			} elseif ( $style == 'classic' ) {
				$ul_style = 'ui--widget-subpages-classic';
				$first_level_class = '';
			}

			/** Include the Walker */
			include_once( trailingslashit(dirname(__FILE__)) . 'walker/walker.php' );

			$args = array(
				'child_of'          => $page_id,
				'depth'             => 1,
				'exclude'           => NULL,
				'title_li'          => 0,
				'sort_column'       => 'menu_order, post_title',
				'echo'              => 0,
				'first_level_class' => $first_level_class,
				'walker'            => new CloudFw_Walker_Sub_Pages,
				//'depth'           => _check_onoff( $hierarchy ) ? 0 : 1,
			);

			$pages = wp_list_pages( $args );



			if ( ! empty( $pages ) ) {

				echo $before_widget;


				/**
				 *	Start to Render
				 */
				if ( ! _check_onoff( $hide_title ) ) {

					$title = apply_filters('widget_title', $title);
					if ( !empty( $title ) )	{
						echo $before_title . $title . $after_title;
					}

				}

				echo '<ul class="'. $ul_style .'">';
					echo $pages;
				echo '</ul>';

				echo $after_widget;

			}

		}

		/** Scheme */
		function scheme( $data = array() ) {

			/** Defaults */
			$data = wp_parse_args( $data, array( 'submit_text' => __('Subscribe','cloudfw'), 'placeholder_text' => __('Email Address','cloudfw') ) );

			$scheme = array();
			$scheme['data'] = array(
				array(
					'type'		=>	'json',
					'variable'	=>	'widget_options',
					'data'		=>	array(
						'not_in'		=>	array( 'header-widget-area', 'header-widget-area-2' )
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

				## Module Item
				array(
					'type'		=>	'module',
					'title'		=>	__('Parent Page','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'select',
							'id'		=>	$this->get_field_name('page_id'),
							'value'		=>	isset($data['page_id']) ? $data['page_id'] : NULL,
							'default'	=>	'',
							'source'	=>	array(
								'type'		=>	'function',
								'function'	=>	'cloudfw_admin_loop_all_pages',
							),
							'_class'	=>	'input_200'
						)
					)
				),

				/*array(
					'type'		=>	'module',
					'title'		=>	__('Show Hierarchy','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'onoff',
							'id'		=>	$this->get_field_name('hierarchy'),
							'value'		=>	isset($data['hierarchy']) ? $data['hierarchy'] : 'FALSE',
						)
					)
				),*/

				array(
					'type'		=>	'module',
					'title'		=>	__('Hide Widget Title','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'onoff',
							'id'		=>	$this->get_field_name('hide_title'),
							'value'		=>	isset($data['hide_title']) ? $data['hide_title'] : 'FALSE',
						)
					)
				),

				array(
					'type'		=>	'module',
					'title'		=>	__('Style','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'select',
							'id'		=>	$this->get_field_name('style'),
							'value'		=>	isset($data['style']) ? $data['style'] : '',
							'source'	=>	array(
								'NULL'		=>	__('Smooth Gradient','cloudfw'),
								'classic'	=>	__('Classic List','cloudfw'),
							),
							'width'		=>	250,
						)
					)
				),

			);

			return $scheme;

		}

	}

	/** Register */
	register_widget('CloudFw_Widget_Subpost');
}
