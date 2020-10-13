<?php
/**
 *	CloudFw Widget Class
 *
 *	@since 3.0
 */
class CloudFw_Widgets extends WP_Widget {

	/**
	 *	Render Form
	 *
	 *	@since 3.0
	 */
	function form( $data ) {
		/** Get the Scheme */
		$scheme = $this->scheme( $data );

        /* Load CloudFw Render Functions */
        require_once(CLOUDFW_PATH.'/core/engine.render/core.render.php');

        ob_start();
			cloudfw_render_page( $scheme['data'] );

		$out = ob_get_contents();
		ob_end_clean();
		
		echo $out;
	}

	/**
	 *	Save Options
	 *
	 *	@since 3.0
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$multi_number = !empty( $_POST['multi_number'] ) ? $_POST['multi_number'] : $_POST['widget_number']; 
		$onOffElements = $_POST['is_defined_widget-' . $this->id_base][ $multi_number ];

		if ( isset( $onOffElements ) && is_array( $onOffElements ) ) {
			foreach ($onOffElements as $element => $value) {
				if ( empty( $new_instance[$element] ) ) {
                    $new_instance[$element] = 'FALSE';
				}
			}
		}

        foreach ($new_instance as $instance_key => $instance_value) {
        	if ( is_array($instance_value) )
        		$instance[ $instance_key ] = ($instance_value);
        	else
        		$instance[ $instance_key ] = ($instance_value);
  
        }
        
		return $instance;
	}

}