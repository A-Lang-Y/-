<?php

$this_page = cloudfw_admin_this_page(); 
			
if ($data):
ksort($data);
$is_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;
?>
<?php echo '<div id="slider_items">'; ?>

<?php
	
echo '<ul class="cloudfw-ui-sortable cloudfw-ui-list slider_items slider_ajax">';
					
	foreach($data as $slider => $slider_item):
	

		if( !isset($slider_item["slider_name"]) || empty($slider_item["slider_name"]) )
			$slider_item["slider_name"] =  __("Unnamed Item",'cloudfw');
		

	if ( isset($slider_item["slider_image"]) && $slider_item["slider_image"] ) {

		$preview = '
			<div class="mini-preview-item-thumbs">
				<a href="javascript:;" class="edit" rel="'.$slider.'"><img src="'. cloudfw_thumbnail(array('src'=> $slider_item["slider_image"],'w'=> 120,'h'=> 90 )) .'" alt="" /></a>
			</div>';

	} else {

		$preview = '
			<a class="mini-preview-item-count edit" href="javascript:;" rel="'.$slider.'">
				<div class="number">-</div>
				<div class="text">'.__('no image','cloudfw').'</div>
			</a>'; 

	}


	echo '
	<li class="sortable_item">
		<div class="inset overflow-hidden">

			<input type="hidden" name="s_'.$slider.'" id="s_'.$slider.'" class="sort_input" value="'.$slider.'" />
			<input type="hidden" name="d_'.$slider.'" id="d_'.$slider.'" class="delete_input" value="" autocomplete="off" />

			<div class="mini-preview slider-preview">
				'. $preview .'
				<div class="item-divider"></div>
			</div>

			<div class="cont">	
				<a href="#" rel="'.$slider.'" class="edit title">', (strlen($slider_item["slider_name"])>50) ? mb_substr($slider_item["slider_name"],0,50).'..': $slider_item["slider_name"] ,'</a>	 
				<div class="mini-buttons">
					<a href="javascript:;" class="edit" rel="'.$slider.'">'.__('Edit','cloudfw').'</a> 
				</div>
			</div>
					

			<div class="item-action" style="width: 234px;">
				<div class="action-divider"></div>
				<div class="mini-action-icons horizontal item-4">
					<a href="javascript:;" class="edit cloudfw-tooltip" title="'. __('edit','cloudfw') .'"  rel="'.$slider.'"></a>
					<a href="javascript:;" class="duplicate duplicate-ajax cloudfw-tooltip" title="'. __('duplicate','cloudfw') .'"  rel="'.$slider.'"></a>
					<a href="javascript:;" class="export copy-ajax cloudfw-tooltip" title="'. __('export item','cloudfw') .'"  rel="'.$slider.'"></a>
					<a href="javascript:;" class="remove cloudfw-tooltip" title="'. __('remove','cloudfw') .'" rel="'.$slider.'"></a>
				</div>
			</div>

			<div class="item-handle">
				<div class="action-divider"></div>
				<div class="handler"></div>
			</div>
			
			<div class="clear"></div>
		</div>
	
	</li>
	
	';
	
	endforeach;
	
					
echo '</ul>

<div class="module submit-helper">
	<div class="fixed-submit">	               
		<div style="float:right;">  
		<div class="small-button small-sky"><input autocomplete="off" value="'.__('Save Sorting','cloudfw').'" type="submit"/></div> 
		</div>
		<div class="clear"></div>
		
	</div>
</div>
';

?>

<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function(){
		
		jQuery('#sorting_form').bind('ajaxPreSend',function(){
			jQuery(this).hide();
			jQuery(this).parents("#sliderforms").addClass("loading");
			cloudfw_global_loading('hide');
		});
		
		jQuery('#sorting_form').bind('ajaxCallback',function(){	
			jQuery(this).show();
			jQuery(this).parents("#sliderforms").removeClass("loading");
			cloudfw_main();
		});
		
	}); 
// ]]>
</script>

<?php echo '</div>'; ?>

<?php

else:
							
	echo '<div class="module">
		<div class="thereisno">'. __('There is no any slider item','cloudfw') .'. <a id="add_new_slider" href="javascript:;"><span>'.__('Create New One','cloudfw').'</span></a></div>
	</div>';
	
endif;

?>
<script type="text/javascript">
// <![CDATA[
	jQuery(window).ready(function(){
			
		cloudfw_add_dynamics_menu_item({ 
			id: 	'mainSliderOptions',
			title: 	'<?php _e('Slider Options','cloudfw'); ?>',
			link: 	'<?php echo $this_page."&msid=".$main_slider_id; ?>',
			icon: 	'cloud_nav_slider_options',
			seq: 	1
		});

		cloudfw_select_dynamics_menu_item('#manageSlider');

	}); 
// ]]>
</script>