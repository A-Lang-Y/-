<form  class="sending_form" action="<?php echo $this_page;?>" method="POST">
<input type="hidden" id="form_selector" name="form_selector" value="<?php echo PFIX.'_create_skin'; ?>" />
<input type="hidden" value="1" name="<?php echo PFIX;?>_update" id="update_identifier">
<?php wp_nonce_field('cloudfw','_wp_nonce');?>

 <div class="grid oneof4" style="padding-top: 10px;"><span class="title"><?php _e('Set Name:','cloudfw'); ?></span></div>
    <div class="grid threeof4 last">

			<?php
			   admin_create_input(
					array(
						'id'    =>	'skin_name',
						'value' =>	'',
						'case'  => 'input',
						'type'  => 'text',
						'class' => 'input input_200_bold',
					)
				);
			   
			?><div class="small-button small-sky button-float-none" style="margin-left: 10px !important;"><input type="submit" value="<?php _e('Create','cloudfw'); ?>"></div>

    </div>
    	
<div class="clear"></div>


</form>