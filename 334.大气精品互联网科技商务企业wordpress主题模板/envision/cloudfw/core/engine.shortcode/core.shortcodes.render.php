<?php
/**
 *  CloudFW Shortcode Generator - Render Functions
 *  
 *  @author Orkun Gürsel - contact@orkungursel.com - support@cloudfw.net
 *  @since 1.0
 */
	require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
	require_once(TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.php');

	$is_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX; 
	$shortcode_map = cloudfw_get_schemes('shortcodes');
	$shortcodes = array();

	foreach ($shortcode_map as $shortcode_number => $shortcode):
		if ((isset($shortcode['type']) && $shortcode['type'] == 'shortcode:group') || (isset($shortcode['type']) && $shortcode['type'] == 'shortcode')){
			$shortcodes[$shortcode_number] = array(
				'_id'       => isset($shortcode['id']) ? $shortcode['id'] : NULL,
				'_title'    => isset($shortcode['title']) ? $shortcode['title'] : NULL,
				'_div'      => isset($shortcode['type']) && $shortcode['type'] == 'shortcode' ? true : false,
				'_optgroup' => isset($shortcode['type']) && $shortcode['type'] == 'shortcode:group' ? true : false,
			);

			if ( !empty($shortcode['data']) && is_array($shortcode['data']) && isset($shortcode['type']) && $shortcode['type'] == 'shortcode:group' ) {
				
				foreach ($shortcode['data'] as $sub_shortcode_number => $sub_shortcode):

					if ($sub_shortcode['type'] != 'shortcode:sub') {
						continue;
					}

					$shortcodes[$shortcode_number]['sub'][$sub_shortcode_number] = array(
						'_id'    => isset($sub_shortcode['id']) ? $sub_shortcode['id'] : NULL,
						'_title' => isset($sub_shortcode['title']) ? $sub_shortcode['title'] : NULL,
						'_div'   => true

					);

				endforeach;
				
			}
		}
	endforeach;

	$div_parent = 'cloudfw-shortcode-generator';
	$div_prefix = cloudfw_sanitize( $div_parent ); 

	if ( !$is_ajax )
		echo '<div id="'. $div_parent .'">';
		
		echo '<div class="module"><div class="grid oneof4"><label for="cloudfw_shortcode_selector" class="title">' . __('Shortcode','cloudfw') . ':</label></div><div class="grid threeof4 last">';
		cloudfw_render_shortcodes( $shortcodes, $shortcode_map );
		echo '</div><div class="clear"></div><div class="divider"></div></div>';

		echo cloudfw_render_page( $shortcode_map );
		cloudfw_render_shortcodes_javascript( $div_parent, $shortcodes, $shortcode_map );

	echo '<div class="module" style="background: transparent; border: 0; padding-bottom: 0;"><div class="grid oneof4">&nbsp;</div><div class="grid threeof4 last"><div class="clear"></div><a href="javascript:void(0);" id="cloudfw_send_the_code" class="small-button small-brown"><span>'.__('Generate Shortcode','cloudfw').'</span></a> <a id="copyShortcode" href="javascript:void(0);" class="small-button small-grey"><span>'.__('Copy','cloudfw').'</span></a>';
	echo '</div><div class="clear"></div></div>';

	if ( !$is_ajax )
		echo '</div>';

 ?>

 <script type="text/javascript">
// <![CDATA[

	jQuery(document).ready(function(){

		var cb = function(){

			if ( !jQuery('#cloudfw_send_the_code', '#<?php echo $div_parent; ?>').hasClass('inProccess') ) {
				
				var default_sc_button_text = jQuery('#cloudfw_send_the_code', '#<?php echo $div_parent; ?>').text();

				jQuery('#cloudfw_send_the_code', '#<?php echo $div_parent; ?>').addClass('inProccess').children('span').text('The Code Generated').parent().removeClass("small-brown").addClass("small-green");
				jQuery.scrollTo( jQuery("#wp-content-wrap"), {duration: 500, offset:{top:-40 } } );

				var getBackTheShortcodeButton = setInterval(function() {
					jQuery('#cloudfw_send_the_code', '#<?php echo $div_parent; ?>').removeClass('inProccess').children('span').text( default_sc_button_text ).parent().removeClass("small-green").addClass("small-brown");
					clearInterval(getBackTheShortcodeButton);
				}, 1500);
			}

		} 
		
				
		jQuery('#cloudfw_send_the_code', '#<?php echo $div_parent; ?>').bind('click',function(){ 
			cloudfw_send_the_code_to_editor_<?php echo $div_prefix; ?>(jQuery('#<?php echo $div_parent; ?>'), jQuery(this), cb); return false;
		});

		jQuery('#cloudfw_preview_the_code', '#<?php echo $div_parent; ?>').bind('click',function(){
			var copy_result = '' + cloudfw_send_the_code_to_editor_<?php echo $div_prefix; ?>(jQuery('#<?php echo $div_parent; ?>'),jQuery('#cloudfw_send_the_code', '#<?php echo $div_parent; ?>'), cb, 'result' );
			if ( copy_result == '' || copy_result == 'false' || copy_result == 'undefined' )
				return '';
			copy_result = encodeURIComponent( copy_result );
			copy_result = jQuery.base64.encode( copy_result );
			tb_show('Preview Shortcode', '<?php echo TMP_URL . "/includes/theme/theme.shortcodes.preview.php"; ?>?_wpnonce=<?php echo wp_create_nonce('cloudfw'); ?>&shortcode='+copy_result+'&type=html&TB_iframe=true&width=100%');
			return false;
		});

		jQuery('#copyShortcode', '#<?php echo $div_parent; ?>').zclip({
			path: '<?php echo TMP_ADMIN . '/js/zclip/ZeroClipboard.swf'?>',
			copy: function(){
				var copy_result = '' + cloudfw_send_the_code_to_editor_<?php echo $div_prefix; ?>(jQuery('#<?php echo $div_parent; ?>'), jQuery('#cloudfw_send_the_code', '#<?php echo $div_parent; ?>'), cb, 'result' );
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

		shortcut.remove("Ctrl+G");
		shortcut.add("Ctrl+G",function() {jQuery('#cloudfw_send_the_code', '#<?php echo $div_parent; ?>').click();},{'type':'keydown','propagate':false,'target':document});

	});
 
// ]]>
 </script>