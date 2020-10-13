<?php

	$theme_sliders = cloudfw_sliders();
				
	echo '<div id="slider_items">'; 

	if (is_array( $data ) && !empty( $data )):



	echo '
	<ul id="cloudfw-main-slider-sorting" class="slider_items cloudfw-ui-list slider_ajax">';
		$i = 0;
		foreach($data as $slider_id => $slider_item):
			$i++;
			$type = $slider_item["type"];
			$slider_source = cloudfw_get_slider($slider_id);
			$count = is_array($slider_source) ? count($slider_source ): 0;
			
			if (strlen($slider_item["title"])>50) 
				mb_substr($slider_item["title"],0,50).'..';
			
			//$thumbnails = cloudfw_detect_image_URLs( $slider_source, cloudfw_home_url(0) );
			//$thumbnails_path = cloudfw_detect_image_URIs( $slider_source, cloudfw_home_url(0) );
			/*if ( $thumbnails[0] && file_exists($thumbnails_path[0]) )
				$preview = '
					<div class="mini-preview-item-thumbs">
						<img src="'. cloudfw_thumbnail(array('src'=> $thumbnails[0],'w'=> 120,'h'=> 90 )) .'" alt="" />
					</div>';
			else*/
				$preview = '
					<a class="mini-preview-item-count" href="'.$this_page.'&amp;id='.$slider_id.'">
						<div class="number">'. $count .'</div>
						<div class="text">'.__('items','cloudfw').'</div>
					</a>'; 
			
			if ( !isset( ${'echo_'.$type} ) )
				${'echo_'.$type} = ''; 

			${'echo_'.$type} .= '
			<li class="sortable_item">
				<div class="inset overflow-hidden">
				
				<input type="hidden" name="d_'.$slider_id.'" id="d_'.$slider_id.'" class="delete_input" value="" autocomplete="off" />
				<input type="hidden" class="slider_sorting_id" name="slider_sorting[]" value="'.$slider_id.'">

				<div class="mini-preview slider-preview">
					'. $preview .'
					<div class="item-divider"></div>
				</div>
				
				<div class="cont">
					<a style="text-decoration: none;" href="'.$this_page.'&amp;id='.$slider_id.'">      
						<span class="title">'.$slider_item["title"].'</span>
					</a>
					<div class="mini-buttons">
						<a href="'.$this_page.'&amp;msid='.$slider_id.'" class="edit" rel="'.$slider_id.'">'.__('Edit Options','cloudfw').'</a> / 
						<a href="'.$this_page.'&amp;id='.$slider_id.'">'.__('Manage Slider Items','cloudfw').'</a>
					</div>
				</div>
				
				
				<div class="item-action" style="width: 196px;">
					<div class="action-divider"></div>
					<div class="mini-action-icons horizontal item-5">
						<a href="'.$this_page.'&amp;msid='.$slider_id.'" class="edit options cloudfw-tooltip" title="'. __('slider options','cloudfw') .'"  rel="'.$slider_id.'"></a>
						<a href="'.$this_page.'&amp;id='.$slider_id.'" class="list cloudfw-tooltip" title="'. __('slider items','cloudfw') .'"  rel="'.$slider_id.'"></a>
						<a href="'.$this_page.'&amp;q=1&amp;duplicateSlider=true&amp;id='.$slider_id.'" class="duplicate cloudfw-tooltip" title="'. __('duplicate','cloudfw') .'"  rel="'.$slider_id.'"></a>
						<a href="'.admin_url('admin.php').'?do=CloudFw_Export&nonce='.wp_create_nonce('cloudfw').'&amp;case=export-sliders&amp;zip=true&amp;ids='.$slider_id.'" class="export cloudfw-tooltip" title="'. __('export','cloudfw') .'"  rel="'.$slider_id.'"></a>
						<a href="javascript:void(0);" class="remove cloudfw-tooltip" title="'. __('remove','cloudfw') .'" rel="'.$slider_id.'"></a>
					</div>
				</div>

				<div class="clear"></div>

				</div>
			
			</li>';
		
		endforeach;         
		
		foreach ( (array) $theme_sliders as $slider_id => $slider_item) {
				
			if (${'echo_'.$slider_id})
			echo '
			<div class="cloudfw-ui-sections-title"><div class="inset">'.$slider_item["name"].'</div></div>
				<ul class="cloudfw-ui-sortable">'.${'echo_'.$slider_id}.'</ul>
			';
							
		}

			echo '</ul><div class="clear"></div>';
			
			cloudfw_admin_submit( array(
				'id'                => 'cloudfw-main-slider-sort-button',
				'message'           => isset($data['text']) ? $data['text'] : __('Save sorting','cloudfw'),
				'case'              => 'inline',
			)); 

			else:

		echo '
			<div class="module">
				<div class="thereisno">'.__('There is no any slider','cloudfw').'. <a class="help" rel="mb_create_slider" width="m" title="'.__('Create New Slider','cloudfw').'" href="javascript:;"><span>'.__('Create New One','cloudfw').'</span></a></div>         
				<div class="clear"></div>
			</div>
		';      
			
	endif;
	echo '</div>';  

?>

<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function(){
		var slider_sorting = jQuery("#cloudfw-main-slider-sorting"),
			slider_sorting_button = jQuery("#cloudfw-main-slider-sort-button");

		slider_sorting.on("sortupdate", function( event, ui ) {
			slider_sorting_button.show();
		});

		slider_sorting_button.click(function(){
			
			// sending button
			var __sending = jQuery(this).__sending();

			var ajaxForm_vars = {
				action: "cloudfw_sort_main_sliders",
				nonce: CloudFwOp.cloudfw_nonce,
			};

			var form_elements   = slider_sorting.find( "input, textarea, select" ),
				serialized_data = form_elements.serialize();

			cloudfw_global_loading("show");
			jQuery.ajax({
				url: CloudFwOp.ajaxUrl,
				cache: false,
				type: "POST",
				data: (jQuery.param(ajaxForm_vars, true) + "&" + serialized_data),
				success: function(data) {
					try {
						var obj = jQuery.parseJSON(jQuery.trim( data ));                                    
						cloudfw_dialog(obj.messageTitle,obj.messageText,obj.messageCase);
						
						__sending.success();
						
					} catch (e) {
						//alert(data);
						slider_sorting.append(data);
						cloudfw_dialog("Couldn\'t be saved", "An error occurred when saving changes", "error");
						
						__sending.error();
					}
					
					
					cloudfw_global_loading("hide");
					cloudfw_destroy();
					
				}  
														
			});
			
			
			return false;

		});
	}); 
// ]]>
</script>