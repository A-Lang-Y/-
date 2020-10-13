<?php
/*
 * Plugin Name: MailChimp
 * Plugin URI: http://cloudfw.net
 * Description: MailChimp
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */

if ( !class_exists('CloudFw_MailChimp') ) {

	/** Class */
	class CloudFw_MailChimp extends CloudFw_Widgets{

		/** Init */
		function __construct() {
			$this->WP_Widget(
				/** Base ID */
				'cloudfw_MailChimp',
				/** Title */
				__('Theme - MailChimp','cloudfw'),
				/** Other Options */
				array( 
					'classname'   => 'widget_cloudfw_mailChimp', 
					'description' => __('MailChimp Signup Form','cloudfw'),
				),
				/** Size */
				array( 'width'  => 300 )
			);
		}

		/** Render */
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			extract($instance, EXTR_SKIP);
			echo $before_widget;


			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$submit_text = empty($instance['submit_text']) ? __('Subscribe','cloudfw') : $instance['submit_text'];
			$placeholder_text = empty($instance['placeholder_text']) ? __('Email Address','cloudfw') : $instance['placeholder_text'];

			if ( !empty( $title ) )	
				echo $before_title . $title . $after_title; 
						
			if ( empty($action) ) {
				echo cloudfw_error_message(__('Please insert a form url for the mailchimp signup form.','cloudfw'));
			} else {
				?>

					<?php if ( ! empty( $instance['text_before'] ) ) { ?>
						<?php echo do_shortcode(cloudfw_inline_format($instance['text_before'])); ?>
					<?php } ?>

					<!-- Begin MailChimp Signup Form -->
					<div id="mc_embed_signup">
						<form action="<?php echo $action; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
							
						<div class="ui--mailchimp mc-field-group">
							<input type="email" value="" name="EMAIL" placeholder="<?php echo esc_attr(__t($placeholder_text)); ?>" class="required email" id="mce-EMAIL">
							<button type="submit" value="<?php echo esc_attr(__t($submit_text)); ?>" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary"><?php echo __t($submit_text); ?></button>
						</div>
							<div id="mce-responses" class="clearfix">
								<div class="response" id="mce-error-response" style="display:none"></div>
								<div class="response" id="mce-success-response" style="display:none"></div>
							</div>	
						</form>
					</div>

					<!--End mc_embed_signup-->

					<?php if ( ! empty( $instance['text_after'] ) ) { ?>
						<?php echo do_shortcode(cloudfw_inline_format($instance['text_after'])); ?>
					<?php } ?>

				<?php
			}

			echo $after_widget;
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
					'title'		=>	__('Form Action URL','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'text',
							'id'		=>	$this->get_field_name('action'),
							'value'		=>	isset($data['action']) ? $data['action'] : NULL,
							'default'	=>	'',
							'_class'	=>	'input_200'
						)
					)
				),

				## Module Item
				array(
					'type'		=>	'module',
					'title'		=>	__('Text Before the Form','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'textarea',
							'id'		=>	$this->get_field_name('text_before'),
							'value'		=>	isset($data['text_before']) ? $data['text_before'] : NULL,
							'width'		=>	'90%',
							'line'		=>	3
						)
					)
				),

				## Module Item
				array(
					'type'		=>	'module',
					'title'		=>	__('Text After the Form','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'textarea',
							'id'		=>	$this->get_field_name('text_after'),
							'value'		=>	isset($data['text_after']) ? $data['text_after'] : NULL,
							'width'		=>	'90%',
							'line'		=>	3
						)
					)
				),

				## Module Item
				array(
					'type'		=>	'module',
					'title'		=>	__('Email Input Placeholder Text','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'text',
							'id'		=>	$this->get_field_name('placeholder_text'),
							'value'		=>	isset($data['placeholder_text']) ? $data['placeholder_text'] : NULL,
							'_class'	=>	'input_200'
						)
					)
				),

				## Module Item
				array(
					'type'		=>	'module',
					'title'		=>	__('Submit Button Text','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'text',
							'id'		=>	$this->get_field_name('submit_text'),
							'value'		=>	isset($data['submit_text']) ? $data['submit_text'] : NULL,
							'_class'	=>	'input_100'
						)
					)
				),

			);

			return $scheme;

		}

	}

	/** Register */
	register_widget('CloudFw_MailChimp');
}