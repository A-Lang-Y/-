<?php

/**
 *	CloudFw Gallery UI
 *
 *	@since 1.0
 */
class CloudFw_Gallery{
	public $instant = 0;
	public $items = array();
	public $options = array();

	function __construct(){
		$this->reset();
		return $this;
	}

	function __destruct(){
		$this->reset();
	}	

	/** Reset Function */
	function reset(){
		$this->instant = 0;
		$this->items = array();
		$this->options = array();

		return $this;
	}

	/** Set Function */
	function set( $key, $value = NULL ){
		$this->options[ $key ] = $value;
		return $this;
	}

	/** Get Function */
	function get( $key, $default = NULL ){
		return isset($this->options[ $key ]) ? $this->options[ $key ] : $default;
	}

	/** Set Items Function */
	function items( $items ){
		$this->items = $items;
		return $this;
	}

	/** Add Function */
	function add( $image ){
		$this->instant++;
		$this->items[ $this->instant ]['src'] = $image;
		return $this;
	}

	/** Image Function */
	function image( $image ){
		$this->items[ $this->instant ]['src'] = $image;
		return $this;
	}

	/** Caption Function */
	function caption( $text ){
		$this->items[ $this->instant ]['caption'] = $text;
		return $this;
	}

	/** Render Function */
	function render(){
		$out = '';
		$image_width = $this->get('width');
		$image_height = $this->get('height');
		$item_class = $this->get('item_class'); 

		if ( is_array($this->items) && !empty($this->items) ) {

			wp_enqueue_script( 'theme-flexslider' );

			$out .= "<div".
				cloudfw_make_id( $this->get('id') ) .
				cloudfw_make_class( $this->get('class'), true) .
				cloudfw_make_style_attribute( array(
				), FALSE, TRUE ) .
				cloudfw_json_attribute( 'data-options', array( 
					'effect'      => $this->get('effect', 'fade'),
					'auto_rotate' => $this->get('auto_rotate', false),
					'rotate_time' => $this->get('rotate_time', false),
				), FALSE )
			."><" . $this->get('slides_element', 'div') . cloudfw_make_class(array( $this->get('slides_class', 'slides') ), true) .">";

				$i = 0; 
				foreach ($this->items as $item_id => $item) {
					if ( empty($item['src']) )
						continue;

					$i++;

					if ( $image_width && $image_height ) {
						$item['src'] = cloudfw_thumbnail(array('src'=> $item['src'], 'w'=> $image_width, 'h'=> $image_height, 'retina' => cloudfw_is_retina() )); 
					}

					$out .= "<". $this->get('item_element', 'div') .
						cloudfw_make_class( array(
							$item_class,
							(isset($item_class) ? $item_class . '-' . $i : NULL),
						))
					.">";
						if ( !empty($item['link']) ) {
							$out .= "<a". 
								cloudfw_make_class(array( $this->get('link_class') ), true) .
								cloudfw_make_attribute( array( 
									'href'   => $item['link'],
									'data-rel'   => $this->get('lightbox_group'),
								), FALSE )
							.">";
						}

						$out .= "<img ". 
							cloudfw_make_class(array( $this->get('image_class') ), true) .
							cloudfw_make_attribute( array( 
								'src'   => isset($item['src']) ? $item['src'] : NULL,
								'width' => isset($item['width']) ? $item['width'] : NULL,
								'height' => isset($item['height']) ? $item['height'] : NULL,
								'alt'   => isset($item['alt']) ? $item['alt'] : $this->get('alt'),
							), FALSE )
						."/>";

						if ( !empty($item['link']) ) {
							$out .= "</a>";
						}

					$out .= "</". $this->get('item_element', 'div') .">";

				}

				$out .= "</". $this->get('slides_element', 'div') .">";
			$out .= "</div>";
		}

		return $out;

	}

}