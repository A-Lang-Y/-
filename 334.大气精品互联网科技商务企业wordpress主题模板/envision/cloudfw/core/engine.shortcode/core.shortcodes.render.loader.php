<?php
/**
 *	CloudFW Shortcode Generator - Render Functions
 */

 echo '<div id="cloudfw-shortcode-generator" class="loading"></div>';
?>
<script type="text/javascript">
// <![CDATA[

	jQuery(window).ready(function(){

			var ajaxForm_vars = {
				nonce: CloudFwOp.cloudfw_nonce,
				action: 'cloudfw_load_shortcode_generator'
			};

			jQuery.ajax({
				url: CloudFwOp.ajaxUrl,
				cache: false,
				type: "POST",
				data: (jQuery.param(ajaxForm_vars, true)),
				success: function(data) {
					try {

						jQuery("#cloudfw-shortcode-generator").removeClass('loading').html( data )
						
						
					} catch (e) {
						alert(data);					
					}
					
					cloudfw_destroy();
					
				} 
				
			});

	});
 
// ]]>
</script>