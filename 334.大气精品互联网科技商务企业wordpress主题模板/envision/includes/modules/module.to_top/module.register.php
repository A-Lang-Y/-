<?php

add_action('init', 'cloudfw_module_to_top_register_scripts');
function cloudfw_module_to_top_register_scripts() {
	wp_register_script ('theme-to-top',  cloudfw_relative_path( dirname(__FILE__) ).'/source/to_top.js', array( 'jquery' ), cloudfw_get_combined_version(), true);
	wp_enqueue_script ('theme-to-top');
}

/**
 *    Register the post type for breadcrumb trial
 */
add_filter('wp_footer', 'cloudfw_module_to_top_init');
function cloudfw_module_to_top_init() {
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			if ( jQuery.isFunction(jQuery.fn.UItoTop) ) {
				jQuery().UItoTop({
					text: '<i class="fontawesome-angle-up px24"></i>',
					min: 200,
					inDelay:600,
					outDelay:400,
					scrollSpeed: 500,
					containerID: 'toTop',
					className: 'btn <?php echo esc_attr(cloudfw_make_button_style( cloudfw_get_option( 'to_top', 'button_color', 'btn-primary' ), true )); ?>',
					containerHoverID: 'toTopHover',
				});
			}
		});
	</script>
<?php
}