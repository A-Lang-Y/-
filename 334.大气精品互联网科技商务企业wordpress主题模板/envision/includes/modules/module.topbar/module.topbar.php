<?php

/** Skin map */
add_filter( 'cloudfw_skin_map_object', 'cloudfw_topbar_skin_map' );
function cloudfw_topbar_skin_map( $map ){
    $map  -> id      ( 'topbar_accent_gradient' )
          -> selector( '#top-bar .ui--accent-gradient' )
          -> sync    ( 'color', 'accent', 'color', true )
          -> sync    ( 'text-shadow', 'accent', 'text-shadow', true )
          -> sync    ( 'gradient', 'accent', 'gradient', true );


    return $map;
}

if ( !is_admin() && !cloudfw_check_onoff( 'topbar', 'enable' ) )
	return;

class CloudFw_TopBar_Widgets {
	public $widgets = array();
	public $basedir = '';

	/**
	 *	Construct Function
	 */
	function __construct(){
		/** Set the basedir */
		$this->basedir = dirname(__FILE__); 

		/** Get widgets array */ 
		$this->widgets = cloudfw_walk_options( array( 
		    'widget'   => 'widget',
		    'device'   => 'device',
		), cloudfw_get_option('topbar_widgets') );

	}

	/**
	 *	Widget List
	 */
	public function widget_list() {
		$widgets = array(
			'search' 			=>	__('Search Widget','cloudfw'),
			'social-icons' 		=>	__('Social Icons Widget','cloudfw'),
			'custom-menu' 		=>	__('Custom Menu Widget','cloudfw'),
		);

		//if ( cloudfw_woocommerce() ) {
			$widgets['shop-cart'] = __('Shopping Cart Widget for WooCommerce','cloudfw'); 
			$widgets['login'] = __('User Login Widget for WooCommerce','cloudfw'); 
		//}
		
		$widgets['login_default'] = __('User Login Widget','cloudfw'); 
		
		if ( cloudfw_is_multilingual() ) {
			$widgets['language-switcher'] = __('Language Switcher Widget','cloudfw'); 
		}

		return apply_filters( 'cloudfw_topbar_widgets', $widgets );
	}


	/**
	 *	Render Widgets
	 */
	static function render(){
		$class = new CloudFw_TopBar_Widgets;
		ob_start();	$class->get_widgets(); 
		$out = ob_get_contents(); ob_end_clean();

		echo $out;
	}

	/**
	 *	Get Widgets
	 */
	private function get_widgets() {
		foreach ((array)$this->widgets as $w) {
			$this->call_widget( $w['widget'], $w['device'] );
		}
	}

	/**
	 *	Class Widget
	 */
	private function call_widget( $widget, $device ) {
		$path = trailingslashit($this->basedir) . 'topbar-widgets/' . $widget . '.php';

		if ( file_exists($path) ) {
			include($path);
		} else {
			do_action( "cloudfw_topbar_widget_{$widget}", compact( 'device' ) );
		}

	}

}