<?php

echo '  <form id="slider_form_2" class="ajax_form ctrl_s_form" method="post" action="'. $this_page .'">

		<input type="hidden" id="comeback" name="comeback" value="'. $this_page .'" />
		<input type="hidden" id="form_selector" name="form_selector" value="manage_main_slider" />
		<input type="hidden" id="slider_id" name="slider_id" value="'. $id .'" />';

		wp_nonce_field('cloudfw','_wp_nonce');
		
		global $slider_id;
		$slider_id = $id;
		
		
		cloudfw_include_slider( $slider_type );
		$class_name = cloudfw_get_slider_class( $slider_type );
		$class = new $class_name;
		$scheme = $class->main_scheme( $slider_data );

		$tabs = cloudfw_prepare_tabs( $scheme, 'tabs' );
		if ($tabs) {
			echo '<div class="cloudfw-ui-tabs cloudfw-ui-mini-tabs">';
			echo cloudfw_render_tabs($tabs);
		}
		else
			$tabs = false;
		
		cloudfw_render_page( $scheme , isset($GLOBALS["args"]) ? $GLOBALS["args"] : NULL );
		
		if ($tabs)
				echo '</div>';		
?>       

    <div class="divider"></div>
    <div class="module submit-helper" style="margin-top: 10px;">
        <div class="fixed-submit">
    
        <input type="hidden" name="no_validate" value="true" />
        <?php if (isset($id)) echo '<div style="float:left;"><a class="small-button small-grey" href="'.$this_page.'&amp;id='.$id.'"><span>'.__('Manage Slider Items','cloudfw').'</span></a></div>'; ?>
        <div style="float:right;"> 
            <div class="small-button small-grey small-hover-red backtoAllSliders"><input value="<?php _e('Cancel','cloudfw'); ?>" type="button"/></div>
			<?php cloudfw_admin_submit( array(
				'message'   => __('Update the slider','cloudfw'),
				'case'      => "onlybutton",
			) ); ?>
        </div>
        
        <div class="clear"></div>
    
    	</div>     
    </div>     

<script type="text/javascript">
// <![CDATA[
	jQuery(window).ready(function(){

		cloudfw_add_dynamics_menu_item({ 
			id: 	'manageSliderOptions',
			title: 	'<?php _e('Slider Options','cloudfw'); ?>',
			link: 	'<?php echo $this_page.'&msid='.$id; ?>',
			icon: 	'cloud_nav_slider_options'
		});

		cloudfw_add_dynamics_menu_item({ 
			id: 	'manageSlider',
			title: 	'<?php _e('Manage Slider Items','cloudfw'); ?>',
			link: 	'<?php echo $this_page.'&id='.$id; ?>',
			icon: 	'cloud_nav_slider_items'
		});

		cloudfw_add_dynamics_menu_item({ 
			id: 	'backtoAllSliders',
			class: 	'backtoAllSliders',
			title: 	'Back',
			link: 	'javascript:;',
			icon: 	'cloud_nav_go_back'
		});
		
		cloudfw_select_dynamics_menu_item('#manageSliderOptions');

	});
	 
// ]]>
</script>

<?php echo '</form>'; ?>