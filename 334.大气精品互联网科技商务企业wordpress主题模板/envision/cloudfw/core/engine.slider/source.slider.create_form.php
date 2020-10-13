<?php $this_page = cloudfw_admin_this_page(); ?>

    <div>

    <?php								
					
	$theme_sliders = cloudfw_sliders();
	
	if ( !empty($theme_sliders) ):

	?>
    
<form method="post" id="add_slider_form" class="sending_form" action="<?php echo $this_page;?>">
<input type="hidden" id="comeback" name="comeback" value="<?php echo $this_page?>" />
<input type="hidden" id="form_selector" name="form_selector" value="<?php echo 'manage_main_slider'; ?>" />
<input type="hidden" id="no_validate" name="no_validate" value="1" />
<input type="hidden" value="1" name="<?php echo PFIX;?>_update" id="<?php echo PFIX;?>_update">
<?php wp_nonce_field('cloudfw','_wp_nonce');?>

 <div class="grid oneof4" style="padding-top: 10px;"><span class="title"><?php _e('Slider Name:','cloudfw'); ?></span></div>
    <div class="grid threeof4 last">

			<?php

				admin_create_input(
					array(
						'id'    =>	'title',
						'value' =>	'',
						'case'  => 'input',
						'type'  => 'text',
						'class' => 'input input_300 bold',
					)
				);
			   
			?>

    </div>
    	
<div class="clear"></div>

 <div class="grid oneof4" style="padding-top: 10px;"><span class="title"><?php _e('Slider Type:','cloudfw'); ?></span></div>
    <div class="grid threeof4 last">

        <?php								
		
			foreach ((array)$theme_sliders as $slider_id => $slider_item) {
				$slides[] =  array(
				"item_title"	=> isset($slider_item["name"]) ? $slider_item["name"] : NULL,
				"item_value"	=> isset($slider_id) ? $slider_id : NULL
				);			
			}
						
			admin_create_selectlist(
				array(
			        'id'                => 'slider_type',
			        'items'             => isset($slides) ? $slides : NULL,
			        'default_value'     => 'default_slider',
			        'type'              => 'select',
			        'value'             => isset($data["type"]) ? $data["type"] : NULL,
			        'main_class'        => 'cloudfw-ui-select',
			        'main_select_class' => 'input input_250',
			        'ui'                => TRUE,
		        )
			);
		?>

<div class="clear"></div>
<div class="small-button small-sky" style="margin-top: 10px !important;"><input type="submit" value="<?php _e('Create','cloudfw'); ?>"></div>

    </div>
    	
<div class="clear"></div>



</form>

</div>


<?php

	else:

		echo cloudfw_error_message( __('There is no any slider type which installed into the theme.','cloudfw') );

	endif;
  ?>