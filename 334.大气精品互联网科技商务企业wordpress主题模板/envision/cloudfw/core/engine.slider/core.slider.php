<?php
/**
 *	Slider Functions
 *
 *  @author Orkun GURSEL <support@cloudfw.net>
 *	@since 2.0
 */

class CloudFw_Sliders {

	public static $data;

	/**
	 *	Construct
	 *
	 *	@since 3.0
	 */
	function __construct(){
		
		if ( is_admin() ) {

			/** Add skinable options for the slider */
			if ( method_exists($this, 'skin_scheme')) {
				add_filter( 'cloudfw_schemes_skin', array( &$this, 'skin_scheme' ), 20, 2 );
			}
		
		} 
		
		if ( method_exists($this, 'skin_map') ) {
			add_filter( 'cloudfw_skin_map_object', array( &$this, 'skin_map' ) );		
		}

	}

	/**
	 *	Set Slider Data
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function set_data( $data ){
		self::$data = $data; 
	}

	/**
	 *	Get Value
	 *
	 *	@package CloudFw
	 *	@since 3.0
	 */
	public function get_value( $key, $default = '' ){
		if ( empty( $key ) ) {
			return '';
		}

		if ( !empty( self::$data[ $key ] ) ) {
			return self::$data[ $key ];
		}

		if ( isset(self::$data[ $key ]) && (self::$data[ $key ] === '0' || self::$data[ $key ] === 0) ) {
			return self::$data[ $key ];
		}
		
		return $default;
	}


}

/**
 *  CloudFw Sliders
 *
 *  @hook: cloudfw_sliders
 *  @since 1.0
 */  
function cloudfw_sliders() {
    global $cloudfw_sliders;
    return apply_filters('cloudfw_sliders', $cloudfw_sliders);    
}

/**
 *	CloudFw Register Slider
 *
 *	@since 1.0
 */
function cloudfw_register_slider( $id, $class, $name, $options = array() ){
	global $cloudfw_sliders;
	$cloudfw_sliders[ $id ] = array( 
		'name' 		=> $name, 
		'class' 	=> $class, 
		'options' 	=> $options, 
	);

	cloudfw_include_slider($id);
	if ( class_exists($class) )
		new $class();

}

/**
 *	CloudFw Get Slider Class
 *
 *	@since 1.0
 */
function cloudfw_get_slider_class( $id ){
	global $cloudfw_sliders;
	return isset($cloudfw_sliders[ $id ]['class']) ? $cloudfw_sliders[ $id ]['class'] : NULL;
}

/**
 *	CloudFw Deregister Slider
 *
 *	@since 1.0
 */
function cloudfw_deregister_slider( $id ){
	global $cloudfw_sliders;
	if(!empty($id) && isset($cloudfw_sliders[$id])) 
		unset($cloudfw_sliders[$id]);
}

/**
 *	CloudFw Include Slider Schemes
 *
 *	@since 1.0
 */
function cloudfw_include_slider( $id ){
	if ( file_exists( TMP_SLIDERS . "/{$id}/slider.{$id}.php" ) )
		require_once( TMP_SLIDERS . "/{$id}/slider.{$id}.php" );
	/*else
		echo cloudfw_error_message(__('Slider source cannot found','cloudfw'));*/
}

/**
 *	Get Slider
 *
 *	@since 2.0
 */
function cloudfw_get_the_slider($atts = array(), $data = NULL ) {
	/* Get Sliders Options */
	
	$id = isset($atts["id"]) ? $atts["id"] : NULL;
	$slider_type = cloudfw_get_slider_type( $id );
	
	if (empty( $id )) 
		return cloudfw_error_message(__('Please set a slider ID','cloudfw'));
		
	cloudfw_include_slider( $slider_type );
	$class_name = cloudfw_get_slider_class( $slider_type );

	if ( ! class_exists( $class_name ) )
		return '<br/><br/>'.cloudfw_error_message(__('Slider cannot found','cloudfw')).'<br/><br/>';

	$class = new $class_name;

	if ( method_exists( $class,'css' ) )
		$class->css( $slider_type );	

	if ( method_exists( $class,'js' ) )
		$class->js( $slider_type );

	return $class->slider( $atts, $data );
	
}


/**
 *	Get Slider Datas
 *
 *	@since 2.0
 */
function cloudfw_get_slider($id) {
	$slider = get_option($id);
	return $slider;
}

/**
 *	Get Slider Options
 *
 *	@since 2.0
 */
function cloudfw_get_slider_options($id = NULL) {
	if (!isset($id)) return false;
	
	global $_opt;
	$slider_ids = $_opt[PFIX.'_slider_ids'];
	
	$options = isset($slider_ids[$id]) ? $slider_ids[$id] : NULL;
	return $options;
}

/**
 *	Get Slider Type
 *
 *	@since 2.0
 */
function cloudfw_get_slider_type($id = NULL) {
	if (!isset($id)) return false;
	
	global $_opt;
	$slider_ids = $_opt[PFIX.'_slider_ids'];
	$type = isset($slider_ids[$id]["type"]) ? $slider_ids[$id]["type"] : NULL;
	return $type;
}

/**
 *	Create New Slider
 *
 *	@since 2.0
 */
function cloudfw_create_slider($atts = array(), $reg_a_page = NULL) {
	$_opt = cloudfw_get_all_options('theme', TRUE, TRUE);
	
	$slider_types = cloudfw_sliders();

	
	extract(cloudfw_make_var(array(
		'id'				=> NULL,
		'title'				=> NULL,
		'type'				=> NULL,
		'default_height'	=> 400,
	), $atts));	


	$random_id = cloudfw_randomizer(20);
	
	if (empty($title))
		$atts["title"] = __('(Untitled)','cloudfw') . ' ' .$slider_types[$type]["name"];
		
	if (empty($id))
		$id = $random_id;
	
	if (!$type) $atts["type"] = cloudfw_get_slider_type($id);
	
	$new_slider[$id] = $atts;
	
	$slider_ids = $_opt[PFIX.'_slider_ids'];
	if (empty($id)) {
		$new_slider[$id]["created_date"] = $new_slider[$id]["updated_date"] = time(); 
		is_array($slider_ids) ? $slider_ids += $new_slider: $slider_ids = $new_slider;
	} else {
		$new_slider[$id]["updated_date"] = time(); 
		if ( !isset($new_slider[$id]["created_date"]) )
			$new_slider[$id]["created_date"] = $new_slider[$id]["updated_date"];
			 
		$slider_ids[$id] = $new_slider[$id];
	}
	
	update_option(PFIX.'_slider_ids', $slider_ids);
	
	
	if ($reg_a_page) {
		$old_val = get_post_meta($reg_a_page, PFIX.'_slider_id', TRUE);
		if (empty($old_val)) add_post_meta($reg_a_page, PFIX.'_slider_id', $id); else; update_post_meta($reg_a_page, PFIX.'_slider_id', $id, $old_val);	
	
	}
	
	delete_transient('cloudfw_slider_'.$id);
	return $id;
}

/**
 *	Duplicate Slider
 *
 *	@since 3.0
 */
function cloudfw_duplicate_slider($id = array()) {
	$_opt = cloudfw_get_all_options('theme', TRUE, TRUE);
	$slider_options = cloudfw_get_slider_options( $id ); 
	$slider = cloudfw_get_slider( $id ); 


	/** Generate New ID */
	$random_id = cloudfw_randomizer(20);
		
	$slider_options['id'] = $random_id; 
	$slider_options['title'] = '(Copy)' . $slider_options['title']; 
	$new_slider[$random_id] = $slider_options;

	$slider_ids = $_opt[PFIX.'_slider_ids'];
	$slider_ids[$random_id] = $new_slider[$random_id];

	update_option(PFIX.'_slider_ids', $slider_ids);
	update_option($random_id, $slider);
		
	delete_transient('cloudfw_slider_'.$id);
	return $id;
}

/**
 *	Delete Slider
 *
 *	@since 2.0
 */
function cloudfw_delete_slider($id = NULL) {
	
	if (!isset($id))
		return false;
	
	global $_opt;
	$slider_ids = $_opt[PFIX.'_slider_ids'];
	unset($slider_ids[$id]);
	
	update_option(PFIX.'_slider_ids', $slider_ids);
	delete_option($id);

	return $slider_ids;
}

/**
 *	Delete Slider
 *
 *	@since 3.0
 */
function cloudfw_find_slider_images($id = NULL) {
	
	if (!isset($id))
		return false;
	
	global $_opt;
	$slider_ids = $_opt[PFIX.'_slider_ids'];
	unset($slider_ids[$id]);
	
	update_option(PFIX.'_slider_ids', $slider_ids);
	delete_option($id);

	return $slider_ids;
}

/**
 *	Get Gallery Posts for Slider
 *
 *	@since 2.0
 */
function cloudfw_get_post_gallery_source($post_id = NULL){
	
	if (empty( $post_id ))
		return false;
	
	$gallery = $attachments = get_children( array(
			'post_parent'    => $post_id,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order'
		) 
	);
	
	if (is_array($attachments)):
	
	foreach ($gallery as $gal_id => $gal) {
		
		$image = wp_get_attachment_image_src($gal_id, 'full', TRUE );
		$image_src = $image[0];			
		$out[] = array(
			'slider_image'   => $image_src,
			'slider_title'   => $gal->post_title,
			'slider_caption' => $gal->post_content
		);
		
	}
	
	endif;
	
	return $out;
	
}