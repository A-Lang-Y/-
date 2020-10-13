<?php
/*
 * Plugin Name: Testimonials
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [testimonial]
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Testimonial', 'testimonial', 'advanced', 50 );
if ( ! class_exists('CloudFw_Shortcode_Testimonial') ) {
	class CloudFw_Shortcode_Testimonial extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'user-grey',
				'group'			=> 'composer_widgets',
				'line'			=> 270,
				'options'		=> array(
					'title'				=> __('Testimonial','cloudfw'),
					'sync_title'		=> 'testimonial_name',
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			extract(shortcode_atts(array(
				'image'		=> NULL,
				'height'	=> NULL,
				'icon'		=> NULL,
				'name'		=> NULL,
				'caption'	=> NULL
			), $atts));
			
			return '
			<div class="ui--carousel-item ui--testimonial-wrap ui--animation clearfix">
			
				<div class="ui--testimonial clearfix"'._if( !empty( $height ), ' style="height:'. $height .'px;"' ).'>
					
					<div class="ui--testimonial-content ui--box ui--gradient ui--gradient-grey auto-format clearfix">
						'.do_shortcode(cloudfw_inline_format($content)).'
						<div class="ui--testimonial-arrow"><i class="fontawesome-caret-down"></i></div>
					</div>

					'._if(!empty( $name ),'
					<div class="ui--testimonial-brand ui--animation clearfix" data-fx="fx--fadein-btt">

						'._if(!empty( $image ),'
						<div class="ui--testimonial-image">
							<div class="ui--testimonial-image-position"><img src="'. $image .'" alt="'. esc_attr( $name ) .'" /></div>
						</div>').'

						<div class="ui--testimonial-user">
							<strong class="name">'. $name .'</strong>
								'._if(!empty( $caption ), '<small class="cap">'. make_clickable( $caption ) .'</small>').'
							</div>').'
						</div>

				</div>	
			
			<div class="clearfix"></div>
			</div>
			';
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=> __('Testimonial','cloudfw'),
				'ajax' 		=> true,
				'script'	=> array(
					'shortcode'		=> 'testimonial',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'name' 			=> array( 'e' => 'testimonial_name' ),
						'caption' 		=> array( 'e' => 'testimonial_caption' ),
						'image' 		=> array( 'e' => 'testimonial_avatar' ),
						'content' 		=> array( 'e' => 'testimonial_text' ),
					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Testimonial Name','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'testimonial_name',
								'value'		=>	$this->get_value('testimonial_name')
							),

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Testimonial Caption','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'testimonial_caption',
								'value'		=>	$this->get_value('testimonial_caption')
							),

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Testimonial Avatar','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'upload',
								'id'		=>	'testimonial_avatar',
								'value'		=>	$this->get_value('testimonial_avatar'),
								'removable'	=>	true,
								'store'		=>	true,
								'library'	=>	true,
							)

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Testimonial Text','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'testimonial_text',
								'value'		=>	$this->get_value('testimonial_text'),
								'editor'	=>	true,
								'width'		=>  '90%',
								'line'		=>	5
							),

						)

					), 
				
				)

			);

		}


		/** Skin map */
		function skin_map( $map ){
			$map  -> id      ( 'testimonials' )
			      -> selector( '.ui--testimonial-content.ui--box' )
			      -> attr    ( 'gradient', array(), true )
			      -> attr    ( 'border-kit', array(), true );

			$map  -> id      ( 'testimonials_arrow' )
			      -> selector( '.ui--testimonial-arrow' )
			      -> sync    ( 'color', 'testimonials', array( 'gradient' ) );

			$map  -> id      ( 'testimonials_text' )
			      -> selector( '.ui--testimonial-content.ui--box (|p|a)' )
			      -> attr    ( 'text-shadow-kit', array(), true );

		    return $map;
		}


		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Testimonials','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	array(

						## Module Item
						array(
							'divider'	=>	false,
							'type'		=>	'module',
							'ucode'		=>	'TESTIMONIALS',
							'title'		=>	__('Testimonials Background','cloudfw'),
							'data'		=>	array(

								array(
									'type'		=>	'gradient',
									'id'		=>	cloudfw_sanitize('testimonials','gradient'),
									'value'		=>	$data['testimonials']['gradient'],
								),

							)

						),

						## Module Item
						array(
							'type'		=>	'border',
							'title'		=>	__('Testimonials Border','cloudfw'),
							'id'		=>	cloudfw_sanitize('testimonials'),
							'value'		=>	$data['testimonials'],
							'merge'		=>	'module',
							'ucode'		=>	'TESTIMONIALS',
						),

						## Module Item
						array(
							'type'		=>	'text-shadow-kit',
							'merge'		=>	'module',
							'title'		=>	__('Text','cloudfw'),
							'id'		=>	cloudfw_sanitize('testimonials_text'),
							'value'		=>	$data['testimonials_text'],
							'ucode'		=>	'TESTIMONIALS',
						),

															
					) // module set data
						
				)
				
			);

		}

	}

}