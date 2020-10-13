<?php
/**
 *	CloudFW Shortcode Generator - Render Functions
 *	
 *	@author Orkun Gürsel - contact@orkungursel.com - support@cloudfw.net
 *	@since 1.0
 */
 	require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
 	require_once(TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.php');

 	$is_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX; 
 	$shortcode_map = cloudfw_get_schemes('shortcodes');
 	$shortcodes = array();

	foreach ($shortcode_map as $shortcode_number => $shortcode):
		if ((isset($shortcode['type']) && $shortcode['type'] == 'shortcode:group') || (isset($shortcode['type']) && $shortcode['type'] == 'shortcode')){
			$shortcodes[$shortcode_number] = array(
				'_id' 		=> $shortcode['id'],
				'_title' 	=> $shortcode['title'],
				'_div' 		=> _if($shortcode['type'] == 'shortcode', true, false),
				'_optgroup'	=> _if($shortcode['type'] == 'shortcode:group', true, false),
			);

			if ( isset($shortcode['data']) && is_array($shortcode['data']) && isset($shortcode['type']) && $shortcode['type'] == 'shortcode:group' ) {
				
				foreach ($shortcode['data'] as $sub_shortcode_number => $sub_shortcode):
					if ($sub_shortcode['type'] != 'shortcode:sub')
						continue;

					$shortcodes[$shortcode_number]['sub'][$sub_shortcode_number] = array(
						'_id'    => $sub_shortcode['id'],
						'_title' => $sub_shortcode['title'],
						'_div' 	 => true

					);
				endforeach;
				
			} 
		}
	endforeach;

	$div_parent = 'cloudfw-dynamic-shortcode-generator';
 	$div_prefix = cloudfw_sanitize( $div_parent ); 

	echo '<div class="cloudfw-dynamic-shortcode-generator-result hidden">
		<div class="title"><strong>Code:</strong></div>
		<textarea class="cloudfw-ui-input cloudfw-ui-input-textarea input"></textarea>
		<a href="javascript:void(0);" id="cloudfw_ui_shortcode_generator_back_button" class="small-button small-grey"><span>'.__('Generate New Code','cloudfw').'</span></a>
	</div>';
	echo '<div id="'. $div_parent .'">';
		echo '<div class="">';
 		
	 		echo '<div class="module"><div class="grid oneof4"><label for="cloudfw_shortcode_selector" class="title">' . __('Shortcode','cloudfw') . ':</label></div><div class="grid threeof4 last">';
		 	cloudfw_render_shortcodes( $shortcodes, $shortcode_map );
		 	echo '</div><div class="clear"></div><div class="divider"></div></div>';

			echo cloudfw_render_page( $shortcode_map );
	
		echo '</div>';
	 	cloudfw_render_shortcodes_javascript( $div_parent, $shortcodes, $shortcode_map );

 	echo '
 		<div class="module clean relative" style="background: transparent; border: 0; padding-bottom: 0;"><div class="grid oneof4">&nbsp;</div>
 			<div class="grid threeof4 last"><div class="clear"></div>
		 		<a href="javascript:void(0);" id="cloudfw_ui_shortcode_generator_button" class="small-button small-brown"><span>'.__('Generate','cloudfw').'</span></a> 
		 		<a id="cloudfw_ui_shortcode_generator_copy_button" href="javascript:void(0);" class="small-button small-grey"><span>'.__('Copy','cloudfw').'</span></a>
			</div><div class="clear"></div></div></div>
 	';

	echo '</div>';

 ?>

 <script type="text/javascript">
// <![CDATA[
 	jQuery(document).ready(function(){

		var cb = function(){
			if ( !jQuery('#cloudfw_ui_shortcode_generator_button', '#<?php echo $div_parent; ?>').hasClass('inProccess') ) {
				
				var default_sc_button_text = jQuery('#cloudfw_ui_shortcode_generator_button', '#<?php echo $div_parent; ?>').text();
				jQuery('#cloudfw_ui_shortcode_generator_button', '#<?php echo $div_parent; ?>').addClass('inProccess').children('span').text('The Code Generated').parent().removeClass("small-brown").addClass("small-green");

				var getBackTheShortcodeButton = setInterval(function() {
					jQuery('#cloudfw_ui_shortcode_generator_button', '#<?php echo $div_parent; ?>').removeClass('inProccess').children('span').text( default_sc_button_text ).parent().removeClass("small-green").addClass("small-brown");
					clearInterval(getBackTheShortcodeButton);
				}, 1500);
			}
		} 
	 	
	 			
		jQuery('#cloudfw_ui_shortcode_generator_back_button').bind('click',function(){
			var result_container 	= jQuery('#<?php echo $div_parent; ?>').show().prev('.cloudfw-dynamic-shortcode-generator-result'),
				result_textarea 	= result_container.find('textarea');
				result_container.hide();
				result_textarea.text('');
		});

		jQuery('#cloudfw_ui_shortcode_generator_button', '#<?php echo $div_parent; ?>').bind('click',function(){ 
			var result = '' + cloudfw_send_the_code_to_editor_<?php echo $div_prefix; ?>(jQuery('#<?php echo $div_parent; ?>'),jQuery('#cloudfw_ui_shortcode_generator_button', '#<?php echo $div_parent; ?>'), cb, 'result' );
			
			if ( result == '' || result == 'false' || result == 'undefined' )
				return true;

			var result_container 	= jQuery('#<?php echo $div_parent; ?>').hide().prev('.cloudfw-dynamic-shortcode-generator-result'),
				result_textarea 	= result_container.find('textarea');

			result_container.show();
			result_textarea.text( result );
			result_textarea.select();
		    result_textarea.mouseup(function() {
		        // Prevent further mouseup intervention
		        jQuery(this).unbind("mouseup");
		        return false;
		    });

		});


		jQuery('#cloudfw_ui_shortcode_generator_copy_button', '#<?php echo $div_parent; ?>').zclip({
			path: CloudFwOp.zclipSwf,
			copy: function(){
				var copy_result = '' + cloudfw_send_the_code_to_editor_<?php echo $div_prefix; ?>(jQuery('#<?php echo $div_parent; ?>'), jQuery('#cloudfw_ui_shortcode_generator_button', '#<?php echo $div_parent; ?>'), cb, 'result' );
				if ( copy_result == '' || copy_result == 'false' || copy_result == 'undefined' )
					return '';
				else
					return copy_result;
			},
			afterCopy: function(){
					var copyShortcodeButton = jQuery(this);

					if ( copyShortcodeButton.hasClass('inProccess') )
						return;

					var default_sc_button_text_copy = copyShortcodeButton.text();
					copyShortcodeButton.addClass('inProccess').children('span').text('Copied').parent().removeClass("small-grey").addClass("small-green");
					var getBackTheCopyButton = setInterval(function() {
						copyShortcodeButton.removeClass('inProccess').children('span').text( default_sc_button_text_copy ).parent().removeClass("small-green").addClass("small-grey");
						clearInterval(getBackTheCopyButton);
					}, 1000);					
			}
		});

 	});
 
// ]]>
 </script>