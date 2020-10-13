<?php
/*
 * Plugin Name: Twitter
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Twitter', 'twitter_timeline', 'social', 5 );
if ( ! class_exists('CloudFw_Shortcode_Twitter') ) {
	class CloudFw_Shortcode_Twitter extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		public $do_before   = false;


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'twitter',
				'group'			=> 'composer_widgets',
				'line'			=> 290,
				'options'		=> array(
					'title'				=> __('Twitter Timeline','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
				)
			);
		}

		function CloudFw_Shortcode_Twitter(){


	
			
			add_action('init', array( &$this, 'register_sources' ));
		}

		function register_sources(){
			$schema = is_ssl() ? 'https://' : 'http://';
			wp_register_script ('theme-twitter-api',  $schema . 'platform.twitter.com/widgets.js', NULL, NULL, false);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'style'			=> '',
				'username'		=> NULL,
				'count'			=> 20,
				'columns'		=> 3,
				'avatars'		=> 0,

				'carousel'		=> 0,
				'effect'        => 'slide',
				'auto_rotate'   => 'FALSE',
				'arrows'        => true,
				'rotate_time'   => '',
			), _check_onoff_false($atts)));
			
			if ( !is_numeric( $columns ) || $columns > 4 || $columns < 1 )
				$columns = 3;

			if ( $this->is_widget )
				$columns = 1;

			$id = 'twitter-'.cloudfw_randomizer(5);

			$api_basedir = trailingslashit( dirname(__FILE__) ) . 'api/';
			require_once($api_basedir . 'StormTwitter.class.php');

			if ( empty( $style ) ) {
				$style = 'default';
			}

			$config = array();
			$config['key'] = cloudfw_get_option('twitter', 'consumer_key');
			$config['secret'] = cloudfw_get_option('twitter', 'consumer_secret');
			$config['token'] = cloudfw_get_option('twitter', 'access_token');
			$config['token_secret'] = cloudfw_get_option('twitter', 'access_token_secret');
			$config['screenname'] = $username ? $username : cloudfw_get_option('twitter', 'screenname');
			$config['cache_expire'] = intval(cloudfw_get_option('twitter', 'cache_expire'));
			$config['count'] = $count;

			if ($config['cache_expire'] <= 1) {
				$config['cache_expire'] = 3600;
			}

			$obj = new StormTwitter($config);
			$tweets = $obj->getTweets( $count, $username, $config );
			update_option( PFIX. '_twitter_last_error',$obj->st_last_error);

			$out = '';
			$profile_url = 'http://twitter.com/' . $config['screenname'];

			if( is_array($tweets) ){

				if ( !empty($tweets['error']) ) {
					return cloudfw_error_message( __('Please set your <em>Twitter oAuth API Keys</em> on Control Panel > Global Settings > API Keys page.','cloudfw') . ' (' . $tweets['error'] . ')' );
				}

				if( empty($tweets) ){

					return '<p class="ui--not-found muted">'. sprintf(__('There is no any tweet for @%s account.','cloudfw'), $config['screenname']) .'</p>';

				} else {

					// to use with intents
					wp_enqueue_script( 'theme-twitter-api' );

					$i = 0;
					$total = count($tweets);
					foreach($tweets as $tweet){

						if($tweet['text']){

							$name = '';
							if( isset($tweet['user']) && $tweet['user'] ) {
								$name = $tweet['user']['name'];
							}

							$text = $tweet['text'];

							if(is_array($tweet['entities']['user_mentions'])){
								foreach($tweet['entities']['user_mentions'] as $key => $user_mention){
									$text = preg_replace(
										'/@'.$user_mention['screen_name'].'/i',
										'<a href="http://www.twitter.com/'.$user_mention['screen_name'].'" target="_blank">@'.$user_mention['screen_name'].'</a>',
										$text);
								}
							}

							if(is_array($tweet['entities']['hashtags'])){
								foreach($tweet['entities']['hashtags'] as $key => $hashtag){
									$text = preg_replace(
										'/#'.$hashtag['text'].'/i',
										'<a href="https://twitter.com/search?q=%23'.$hashtag['text'].'&src=hash" target="_blank">#'.$hashtag['text'].'</a>',
										$text);
								}
							}

							if(is_array($tweet['entities']['urls'])){
								foreach($tweet['entities']['urls'] as $key => $link){
									$text = preg_replace(
										'`'.$link['url'].'`',
										'<a href="'.$link['url'].'" target="_blank">'.$link['url'].'</a>',
										$text);
								}
							}

							$image = '';
							if( $avatars && isset($tweet['user']) && $tweet['user'] ) {
								$image = $tweet['user']['profile_image_url'];
							}

							$date = '<a href="https://twitter.com/'. $config['screenname'] .'/status/'.$tweet['id_str'].'" class="muted" target="_blank">'. cloudfw_time_humanreadble( strtotime($tweet['created_at']) ).'</a> ';

							/*echo '
							<div class="twitter_intents">
								<p><a class="reply" href="https://twitter.com/intent/tweet?in_reply_to='.$tweet['id_str'].'">Reply</a></p>
								<p><a class="retweet" href="https://twitter.com/intent/retweet?tweet_id='.$tweet['id_str'].'">Retweet</a></p>
								<p><a class="favorite" href="https://twitter.com/intent/favorite?tweet_id='.$tweet['id_str'].'">Favorite</a></p>
							</div>';*/

							if ( $style == 'plain' ) {
								$out_part = '

								<div class="ui--carousel-item ui--twitter-style-'. $style .' ui--twitter-timeline-wrap ui--animation clearfix">

									<div class="ui--twitter-timeline clearfix">


										<div class="ui--twitter-timeline-content auto-format clearfix">
											'. cloudfw_make_icon( 'FontAwesome/fontawesome-twitter||size:22' ) .'
											'.( cloudfw_inline_format( $text ) ).'
										</div>

									</div>


								<div class="clearfix"></div>
								</div>';

							} else {
								$out_part = '

								<div class="ui--carousel-item ui--twitter-style-'. $style .' ui--twitter-timeline-wrap ui--animation clearfix">

									<div class="ui--twitter-timeline clearfix">

										<div class="ui--twitter-timeline-content ui--box ui--gradient ui--gradient-grey auto-format clearfix">
											'.( cloudfw_inline_format( $text ) ).'
											<div class="ui--twitter-timeline-arrow"><i class="fontawesome-caret-down"></i></div>
										</div>

										'._if(!empty($name),'
										<div class="ui--twitter-timeline-brand clearfix ui--animation" data-fx="fx--fadein-btt">

											'._if(!empty($image),'
											<div class="ui--twitter-timeline-image">
												<div class="ui--twitter-timeline-image-position"><a href="'. $profile_url .'" target="_blank"><img src="'.$image.'" alt="" /></a></div>
											</div>').'

											<div class="ui--twitter-timeline-user">
												<strong class="name">'. $name .'</strong>
													'._if(!empty( $date ), '<small class="cap timestamp">'. $date .'</small>').'
											</div>

										</div>').'

									</div>


								<div class="clearfix"></div>
								</div>';
							}

							$i++;
							$out .= cloudfw_UI_column( array('_key' => 'twitter'), $out_part, '1of' . $columns . ( $i % $columns == 0 ? '_last' : '' ), $i == $total );


						} else {}

					}

					if ( $carousel ) {
						$out = cloudfw_make_layout( 'carousel', $out, array(
							'effect'      => $effect,
							'auto_rotate' => $auto_rotate,
							'rotate_time' => (int) $rotate_time * 1000,
							'arrows'      => $arrows,
						));

					}

				}

			}

			return $out;

		}

		/**
		 *	Global Render Scheme
		 */
		function global_scheme(){
			return array(

				array(
					'type'		=> 'group',
					'data'		=> array(

						array(
							'type'		=>	'module',
							'condition'	=>	$this->is_widget,
							'title'		=>	__('Title','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	$this->get_field_name('title'),
									'value'		=>	$this->get_value('title'),
									'_class'		=>	'widefat',
								)
							),
						),

						array(
							'type'		=> 'module',
							'title'		=> __('Style','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	$this->get_field_name('twitter_style'),
									'value'		=>	$this->get_value('twitter_style'),
									'source'	=>	array(
										'NULL'		=>	__('Default Boxed Style','cloudfw'),
										'plain'		=>	__('Plain Style','cloudfw'),
									),
									'width'		=>  250,
								), // #### element: 0

							)

						),

						array(
							'type'		=> 'module',
							'related'	=> 'twitterTypes',
							'title'		=> __('Twitter Username','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'text',
									'id'		=>	$this->get_field_name('twitter_username'),
									'value'		=>	$this->get_value('twitter_username'),
									'_class'	=>	'bold',
								), // #### element: 0

							)

						),


						array(
							'type'		=>	'module',
							'condition'	=>	! $this->is_widget,
							'title'		=>	__('Columns','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'slider',
									'id'		=>	$this->get_field_name('twitter_columns'),
									'value'		=>	$this->get_value('twitter_columns', 1),
									'class'		=>	'input_250',
									'min'		=>	1,
									'max'		=>	4,
									'unit'		=>	__('column(s)','cloudfw')
								)
							)
						),

						array(
							'type'		=>	'module',
							'title'		=>	__('The Number of Tweets','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'slider',
									'id'		=>	$this->get_field_name('twitter_count'),
									'value'		=>	$this->get_value('twitter_count', 3),
									'class'		=>	'input_250',
									'min'		=>	1,
									'max'		=>	20,
									'unit'		=>	__('tweet(s)','cloudfw')
								)
							)
						),

						array(
							'type'		=>	'module',
							'title'		=>	__('Display User Avatars?','cloudfw'),
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	$this->get_field_name('twitter_avatars'),
									'value'		=>	$this->get_value('twitter_avatars', true),
								), // #### element: 0

							)

						),

						array(
							'type'		=>	'module',
							'title'		=>	__('Enable Carousel?','cloudfw'),
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	$this->get_field_name('twitter_carousel'),
									'value'		=>	$this->get_value('twitter_carousel', true),
								), // #### element: 0

							)

						),

						array(
							'type'		=>	'module',
							'title'		=>	__('Carousel Transition Effect','cloudfw'),
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	$this->get_field_name('effect'),
									'value'		=>	$this->get_value('effect'),
									'main_class'=>  'widefat',
									'source'	=>	array(
										'NULL'		=>	__('Slide','cloudfw'),
										'fade'		=>	__('Fade','cloudfw')
									),
									'width'		=>	350
								), // #### element: 0

							)

						),


						array(
							'type'		=>	'module',
							'title'		=>	__('Carousel Auto Rotate?','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'onoff',
									'id'		=>	$this->get_field_name('auto_rotate'),
									'value'		=>	$this->get_value('auto_rotate'),
								)
							),
						),

						array(
							'type'		=>	'module',
							'title'		=>	__('Carousel Auto Rotate Time','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'slider',
									'id'		=>	$this->get_field_name('rotate_time'),
									'value'		=>	$this->get_value('rotate_time'),
									'min'		=>	0,
									'max'		=>	120,
									'step'		=>	.5,
									'steps'		=>	array( 0 => __('Default','cloudfw') ),
									'unit'		=>	__('seconds','cloudfw'),
									'desc'		=>	__('Leave blank for default','cloudfw'),
									'width'		=>	250
								)
							),
						),

						array(
							'type'		=>	'module',
							'title'		=>	__('Carousel navigation arrows?','cloudfw'),
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	$this->get_field_name('twitter_arrows'),
									'value'		=>	$this->get_value('twitter_arrows', true),
								), // #### element: 0

							)

						),


					)

				),

			);

		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Twitter Timeline','cloudfw'),
				'script'	=> array(
					'shortcode' 	=> 'twitter_timeline',
					'tag_close'  	=> false,
					'attributes' 	=> array(
						'username' 		=> array( 'e' => 'twitter_username', 'required' => __('Please insert your Twitter username','cloudfw') ),
						'style' 		=> array( 'e' => 'twitter_style' ),
						'columns' 		=> array( 'e' => 'twitter_columns' ),
						'count' 		=> array( 'e' => 'twitter_count' ),
						'avatars' 		=> array( 'e' => 'twitter_avatars', 'onoff' => true),

						'carousel' 		=> array( 'e' => 'twitter_carousel', 'onoff' => true),
						'effect'    	=> array( 'e' => 'effect' ),
						'auto_rotate'   => array( 'e' => 'auto_rotate' ),
						'rotate_time'   => array( 'e' => 'rotate_time' ),
						'arrows' 		=> array( 'e' => 'twitter_arrows', 'onoff' => true),

					),
				),
				'data'		=>	$this->global_scheme()

			);

		}


		/** Skin map */
		function skin_map( $map ){
			$map  -> id      ( 'twitter_timeline' )
			      -> selector( '.ui--twitter-timeline-content.ui--box' )
			      -> attr    ( 'gradient', array(), true )
			      -> attr    ( 'border-kit', array(), true );

			$map  -> id      ( 'witter_timeline_arrow' )
			      -> selector( '.ui--twitter-timeline-arrow' )
			      -> sync    ( 'color', 'twitter_timeline', array( 'gradient' ) );

			$map  -> id      ( 'twitter_timeline_text' )
			      -> selector( '.ui--twitter-timeline-content.ui--box (|p|a)' )
			      -> attr    ( 'text-shadow-kit', array(), true );

		    return $map;
		}


		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Twitter Timeline','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	array(

						## Module Item
						array(
							'divider'	=>	false,
							'type'		=>	'module',
							'ucode'		=>	'TWITTER',
							'title'		=>	__('Background','cloudfw'),
							'data'		=>	array(

								array(
									'type'		=>	'gradient',
									'id'		=>	cloudfw_sanitize('twitter_timeline','gradient'),
									'value'		=>	$data['twitter_timeline']['gradient'],
								),

							)

						),

						## Module Item
						array(
							'type'		=>	'border',
							'title'		=>	__('Border','cloudfw'),
							'id'		=>	cloudfw_sanitize('twitter_timeline'),
							'value'		=>	$data['twitter_timeline'],
							'merge'		=>	'module',
							'ucode'		=>	'TWITTER',
						),

						## Module Item
						array(
							'type'		=>	'text-shadow-kit',
							'merge'		=>	'module',
							'title'		=>	__('Text','cloudfw'),
							'id'		=>	cloudfw_sanitize('twitter_timeline_text'),
							'value'		=>	$data['twitter_timeline_text'],
							'ucode'		=>	'TWITTER',
						),

															
					) // module set data
						
				)
				
			);

		}

	}

}


/** Class */
class CloudFw_Widget_Twitter extends CloudFw_Widgets{
	/** Variables */
	private $class;

	/** Init */
	function __construct() {
		$this->WP_Widget(
			/** Base ID */
			'widget_cloudfw_twitter',
			/** Title */
			__('Theme - Twitter Timeline','cloudfw'),
			/** Other Options */
			array(
				'classname'   => 'widget_cloudfw_twitter',
				'description' => '',
			),
			/** Size */
			array( 'width'  => 300 )
		);

		/** Services */
		$this->class = new CloudFw_Shortcode_Twitter();
		$this->class->is_widget = true;
		$this->class->widget = $this;
	}

	/** Render */
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = isset($instance['title']) ? $instance['title'] : NULL;

		echo $before_widget;
		$title = empty($title) ? '' : apply_filters('widget_title', $title);

		if ( !empty( $title ) )
			echo $before_title . $title . $after_title;

		$shortcode_options = $this->class->scheme();
		$instance = cloudfw_composer_convert_data( $instance, $shortcode_options['script'] );

			echo do_shortcode($this->class->shortcode( $instance ));

		echo $after_widget;
	}

	/** Scheme */
	function scheme( $data = array() ) {

		/** Defaults */
		$data = wp_parse_args( $data, array() );
		$this->class->set_data( $data );

		$scheme = array();
		$scheme['data'] = $this->class->global_scheme();

		return $scheme;

	}

}


/**
 *	Register Widget
 */
register_widget('CloudFw_Widget_Twitter');