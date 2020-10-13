<?php

if ( function_exists('cloudfw_metaboxes') ) {
	$meta_boxes = cloudfw_metaboxes( NULL );
}

foreach ((array) $meta_boxes as $meta_box_key => $meta_box) {
	/* Init Metaboxes */
	if ( $meta_box ) {
		new CloudFw_Metabox( $meta_box, $meta_box_key );
	}
}


class CloudFw_Metabox {
	protected $_meta_box;
	protected $_meta_box_key;
	
	function __construct( $meta_box, $meta_box_key = '' ) {
		if ( !is_admin() )
			return;
		
		$this->_meta_box = $meta_box;
		$this->_meta_box_key = $meta_box_key;
		
		// fix upload bug: http://www.hashbangcode.com/blog/add-enctype-wordpress-$post-and-$page-forms-471.html
		$current_page = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);
		if ($current_page == '$page' || $current_page == '$page-$new' || $current_page == '$post' || $current_page == '$post-$new') {
			add_action('admin_head', array(&$this, 'add_post_enctype'));
		}
		
		/* Add Metaboxes to Admin Area */
		add_action( 'admin_menu', array( &$this, 'add' ) );
 
		/* Add Save Hook for Metaboxes */       
		add_action( 'save_post', array( &$this, 'save' ) );
	}
	
	function add_post_enctype() {
		echo '
			<script type="text/javascript">
			// <![CDATA[
				jQuery(document).ready(function(){
					jQuery("#$post").attr("enctype", "multipart/form-data");
					jQuery("#$post").attr("encoding", "multipart/form-data");
				});
			// ]]>  
			</script>
		'; 
	}
	
	/**
	 *    Adding Function
	 *
	 *    @since 1.0
	 */
	function add() {

		foreach ((array) $this->_meta_box['pages'] as $page)
			add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array( &$this, 'render' ), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
		
	}
	
	/**
	 *    Call CloudFw Render API
	 *
	 *    @since 1.0
	 */
	function render() {

		/* Get Global Post Data */
		global $post;
		$post_id = $post->ID;

		/* Load CloudFw Render API */
		require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');

		/* Get Source of the Metabox */
		$metabox_source = cloudfw_metaboxes( $this->_meta_box_key, $post_id );

		/* Render the Metabox */
		echo '<input type="hidden" name="cloudfw_metabox_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';       
		echo '<div class="form-div">';
		echo  cloudfw_render_page( $metabox_source['data'] );
		echo '</div>';

	}
	
	// Save data from meta box
	function save( $post_id ) {      
		$nonce = isset($_POST['cloudfw_metabox_nonce']) ? $_POST['cloudfw_metabox_nonce'] : NULL;

		/* Verify Nonce */
		if ( ! wp_verify_nonce( $nonce, basename(__FILE__) ) )
			return $post_id;

		/* Check Autosave */
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return $post_id;
		
		/* Check Permissions */
		if ( '$page' == $_POST['post_type'] ) {
			if ( ! current_user_can('edit_page', $post_id) )
				return $post_id;

		} elseif ( ! current_user_can('edit_post', $post_id) )
			return $post_id;
		
		/* Check Metabox Options to be Saved */
		$options = cloudfw_detect_options( $this->_meta_box );

		/* Loop the Metabox Options */
		foreach ((array) $options as $field) {
			$name = isset($field['id']) ? $field['id'] : NULL;
			
			$old = get_post_meta( $post_id, $name, true );
			$new = isset($_POST[ $name ]) ? $_POST[ $name ] : NULL;
			$is_defined = isset($_POST[ 'is_defined_'. $name ]) ? $_POST[ 'is_defined_'. $name ] : NULL;
						
			if ( $is_defined == 'onoff' && empty( $new ) ) {
				$new = 'FALSE';
				$_POST[ $name ] = $new;

			} elseif ( $is_defined == 'true' && empty( $new ) ) {
				$_POST[ $name ] = '';

			}
			
			if ( !is_array( $new ) ) {
				$new = stripslashes( $new );
			}

			if ( array_key_exists($name, $_POST) && !is_null($new) && $new != $old ){
				update_post_meta( $post_id, $name, $new );
			} elseif (  array_key_exists($name, $_POST) && !is_null( $new ) && empty( $new ) && isset( $old ) ) {
				delete_post_meta( $post_id, $name, $old );
			}

		}
		

	}


	
}