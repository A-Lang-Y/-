<?php
echo '<form id="slider-edit-form" class="ajax_form ctrl_s_form" method="post" action="', isset($this_page) ? $this_page : NULL ,'">
		<input type="hidden" id="comeback" name="comeback" value="', isset($this_page) ? $this_page : NULL ,'" />
		<input type="hidden" id="raw_this_page" name="raw_this_page" value="', isset($raw_this_page) ? $raw_this_page : NULL ,'" />
		<input type="hidden" id="form_selector" name="form_selector" value="manage_slider_items" />
		<input type="hidden" id="slider_id" name="slider_id" value="', isset($id) ? $id : NULL ,'" />
		<input type="hidden" id="main_slider_id" name="main_slider_id" value="', isset($main_slider_id) ? $main_slider_id : NULL ,'" />';
		wp_nonce_field('cloudfw','_wp_nonce');
		
		global $slider_id, $main_slider_id, $main_slider_data;

		$slider_id = $id;
		$main_slider_data = cloudfw_get_slider_options( $main_slider_id );

		cloudfw_include_slider( $slider_type );
		
		$class_name = cloudfw_get_slider_class( $slider_type );
		$class = new $class_name;
		$scheme = $class->item_scheme( $slider_data );
		$tabs = cloudfw_prepare_tabs( $scheme, 'tabs' );


		if (isset($tabs) && $tabs) {
			echo '<div class="cloudfw-ui-tabs cloudfw-ui-mini-tabs">';
			echo cloudfw_render_tabs( $tabs );
		} else {
			$tabs = false;
		}
		
		cloudfw_render_page( $scheme, isset($GLOBALS["args"]) ? $GLOBALS["args"] : NULL );
		
		if ( isset($tabs) && $tabs ) {
				echo '</div>';
		}
?>


<script type="text/javascript">
// <![CDATA[
	jQuery(window).ready(function(){
				
		cloudfw_add_dynamics_menu_item({ 
			id: 	'mainSliderOptions',
			title: 	'<?php _e('Slider Options','cloudfw'); ?>',
			link: 	'<?php echo $raw_this_page.'&msid='.$main_slider_id; ?>',
			icon: 	'cloud_nav_slider_options',
			seq: 	1

		});

		cloudfw_add_dynamics_menu_item({ 
			id: 	'backtoAllSliders',
			class: 	'backtoAllSliders',
			title: 	'Back',
			link: 	'javascript:;',
			icon: 	'cloud_nav_go_back'
		});


	}); 
// ]]>
</script>

	<div class="divider"></div>
    <div class="module submit-helper">
        <div class="fixed-submit">

        <div style="float:left;"> 
                  <div class="small-button small-grey backtoAllSliders"><input value="<?php _e('Back to Items','cloudfw'); ?>" type="button" /></div>
        </div>
        <div style="float:right;"> 
                <?php cloudfw_admin_submit( array( 
                		'message' => _if( !(strlen($id) > 0),  __('Create','cloudfw'),  __('Update','cloudfw') ),
                		'case' => 'onlybutton' ) 
                	);
                ?>
        </div>
        
        <div class="clear"></div>
    
    	</div>
    </div>

<?php echo '</form>'; ?>