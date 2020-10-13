<form  class="sending_form" action="#" method="GET">
<?php //wp_nonce_field('cloudfw','_wp_nonce');?>

 <div class="grid oneof4" style="padding-top: 10px;"><span class="title"><?php _e('Skin Name:','cloudfw'); ?></span></div>
    <div class="grid threeof4 last">

			<?php

			   admin_create_input(
					array(
						'id'    =>	'skin_duplicate_name',
						'value' =>	'',
						'case'  => 'input',
						'type'  => 'text',
						'class' => 'input input_200_bold',
					)
				);
			   
			?><div class="small-button small-sky button-float-none" style="margin-left: 10px !important;"><input type="submit" value="<?php _e('Duplicate','cloudfw'); ?>"></div>

    </div>
    	
<div class="clear"></div>
</form>