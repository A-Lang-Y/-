<?php

class CloudFW_Likes {

    function __construct() 
    {	
        add_action('publish_post', array(&$this, 'setup'));
        add_action('wp_ajax_cloudfw_likes', array(&$this, 'ajax_callback'));
		add_action('wp_ajax_nopriv_cloudfw_likes', array(&$this, 'ajax_callback'));
	}

	function setup( $post_id ) 
	{
		if(!is_numeric($post_id)) return;
	
		add_post_meta($post_id, PFIX . '_likes', '0', true);
	}
	
	function ajax_callback($post_id) {

		$args = array();
		$post_id = $_POST['likes_id'];
		$args = !empty($_POST['options']) ? $_POST['options'] : array();
		$args = array_map('rawurldecode', $args);

		if( isset($post_id) ) {
			echo $this->like_this($post_id, $args, 'update');
		} else {
			echo $this->like_this($post_id, $args, 'get');
		}
		
		exit;
	}
	
	function like_this($post_id, $options = array(), $action = 'get') {
		if( !is_numeric( $post_id ) ) 
			return;

		$args = shortcode_atts(array(
		    'zero' => '%d',
		    'one'  => '%d',
		    'more' => '%d',
		), $options);
		extract( $args );

		switch($action) {
		
			case 'get':
				$likes = get_post_meta($post_id, PFIX . '_likes', true);
				if( !$likes ){
					$likes = 0;
					add_post_meta($post_id, PFIX . '_likes', $likes, true);
				}

				if( $likes      == 0 ) { $text = sprintf($zero, $likes); }
				elseif( $likes  == 1 ) { $text = sprintf($one, $likes); }
				else                   { $text = sprintf($more, $likes); }
								
				return '<span class="ui--likes-count">'. $text .'</span>';
				break;
				
			case 'update':
				$likes = get_post_meta($post_id, PFIX . '_likes', true);
				if( !isset($_COOKIE[PFIX . '_likes_'. $post_id]) ) {
					$likes++;
					update_post_meta($post_id, PFIX . '_likes', $likes);
					setcookie(PFIX . '_likes_'. $post_id, $post_id, time()*20, '/');
				}
				
				if( $likes      == 0 ) { $text = sprintf($zero, $likes); }
				elseif( $likes  == 1 ) { $text = sprintf($one, $likes); }
				else                   { $text = sprintf($more, $likes); }

				return '<span class="ui--likes-count">'. $text .'</span>';
				break;
		
		}
	}
	
	function render( $args = array() )
	{
		global $post;
		$output = $this->like_this( $post->ID, $args, 'get' );
  
  		$class = 'ui--likes';
  		$title = cloudfw_translate( 'sharrre.like_this' );
		if( isset($_COOKIE[PFIX . '_likes_'. $post->ID]) ){
			$class .= ' active';
			$title  = cloudfw_translate( 'sharrre.already_like_this' );
		}
		
		return '<a href="#" class="'. $class .'" title="'. esc_attr($title) .'"'.
			cloudfw_make_attribute( array( 
				'data-post-id' => $post->ID,
			), FALSE ) . 
			cloudfw_json_attribute( 'data-options', $args, FALSE )
		.'>'. $output .'</a>';
	}
	
}

global $cloudfw_likes;
$cloudfw_likes = new CloudFW_Likes();