<?php

function cloudfw_get_form_import_all_options(){
?>
<form enctype="multipart/form-data" class="sending_form" action="<?php echo isset($this_page) ? $this_page : NULL;?>" method="POST">
	<input type="hidden" id="form_selector" name="form_selector" value="import-data" />
	<input type="hidden" id="case" name="case" value="import-all-options" />
    <input type="hidden" id="comeback" name="comeback" value="<?php echo $this_page?>" />
    <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('cloudfw'); ?>" />
    <input type="hidden" name="<?php echo PFIX.'_update'; ?>" value="1" />

    <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
    <div class="description"><?php _e('Choose a file to upload:','cloudfw'); ?></div>
    	<input id="upload-all-files" name="uploadedfile" class="cloudfw-ui-custom-uploader upload-input" type="file" /><br/>
    <div class="small-button small-sky"><input type="submit" autocomplete="off" value="<?php _e('Import The File','cloudfw'); ?>"></div>
</form>
	
<?php }


function cloudfw_get_form_export_slider(){
	include_once( TMP_PATH.'/cloudfw/core/engine.shortcode/source.shortcodes.php' );
?>	

<form id="export-sliders" class="" action="<?php echo admin_url('admin.php').'?do=CloudFw_Export&nonce='.wp_create_nonce('cloudfw').'&amp;case=export-sliders';?>" method="POST">
	<input type="hidden" id="form_selector" name="form_selector" value="import-data" />
    <input type="hidden" id="comeback" name="comeback" value="<?php echo isset($this_page) ? $this_page : NULL;?>" />
    <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('cloudfw'); ?>" />
    <input type="hidden" name="zip" value="true" />
    
    <?php

	admin_create_selectlist(
		array(
	        'id'                => 'ids',
	        'items'             => cloudfw_admin_loop_sliders(),
	        'type'              => 'select',
	        'main_class'        => 'cloudfw-ui-select',
	        'main_select_class' => 'input_400',
	        'ui'                => TRUE,
		)
	);


	
	?>
	<div class="clear"></div>
    <div class="small-button small-sky"><input type="submit" autocomplete="off" value="<?php _e('Export','cloudfw'); ?>"></div>
</form>

	
<?php }



function cloudfw_get_form_import_slider(){
?>	
<div class="clear"></div>
<form enctype="multipart/form-data" class="sending_form" action="<?php echo isset($this_page) ? $this_page : NULL; ?>" method="POST">
	<input type="hidden" id="form_selector" name="form_selector" value="import-data" />
    <?php wp_nonce_field('cloudfw','_wp_nonce');?>
    <input type="hidden" name="<?php echo PFIX.'_update'; ?>" value="1" />
    <input type="hidden" name="type" value="slider" />

	<input id="upload-slider" class="cloudfw-ui-custom-uploader upload-input" name="uploadedfile" type="file" />	<br/>

    <div class="upload-submit"><div class="small-button small-sky button-float-none"><input type="submit" autocomplete="off" value="<?php _e('Import Slider(s)','cloudfw'); ?>"></div>
    <?php         
		$sizeLimit = apply_filters('cloudfw_upload_limit', cloudfw_upload_size());
		$sizeLimit = max(1, $sizeLimit / 1024 / 1024) . 'M';             

        echo "<em class=\"description fileSizeLimit\">File Size Limit: {$sizeLimit}</em>";

     ?>

    </div>    
</form>
	
<?php }



function cloudfw_get_form_export_skin(){
?>	

<form id="export-skins" class="" action="<?php echo admin_url('admin.php').'?do=CloudFw_Export&nonce='.wp_create_nonce('cloudfw').'&amp;case=export-skins';?>" method="POST">
	<input type="hidden" id="form_selector" name="form_selector" value="import-data" />
    <input type="hidden" id="comeback" name="comeback" value="<?php echo isset($this_page) ? $this_page : NULL; ?>" />
    <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('cloudfw'); ?>" />
    <input type="hidden" id="zip" name="zip" value="1" />

    <?php

		$all_skins = cloudfw_get_all_skins();
		
		 foreach ((array)$all_skins as $skin):
		 	
		 	$skin_data = cloudfw_get_a_skin($skin);
			
			if ($skin_data) {
				$items[ $skin ] = $skin_data["name"];
			}
					
		endforeach;
		
		admin_create_selectlist(
			array(
		        'id'                => 'ids',
		        'items'             => isset($items) ? $items : NULL,
		        'type'              => 'select',
		        'main_class'        => 'cloudfw-ui-select',
		        'main_select_class' => 'input_400',
		        'ui'                => TRUE,
			)
		);

	
	?>
                
	<div class="clear"></div>
    <div class="small-button small-sky"><input type="submit" autocomplete="off" value="<?php _e('Export','cloudfw'); ?>"></div>
</form>  
	
<?php }



function cloudfw_get_form_import_skin(){
?>	

<div class="clear"></div>
<form enctype="multipart/form-data" class="sending_form" action="<?php echo isset($this_page) ? $this_page : NULL;?>" method="POST">
	<input type="hidden" id="form_selector" name="form_selector" value="import-data" />
	<input type="hidden" id="comeback" name="comeback" value="<?php echo CLOUDFW_PAGE;?>&amp;tab=visual&amp;jump=0" />
    <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('cloudfw'); ?>" />
    <input type="hidden" name="<?php echo PFIX.'_update'; ?>" value="1" />
    <input type="hidden" name="type" value="skin" />
    <?php wp_nonce_field('cloudfw','_wp_nonce');?>
	<input id="upload-skin" class="cloudfw-ui-custom-uploader upload-input" name="uploadedfile" type="file" /><br/>
    <div class="upload-submit"><div class="small-button small-sky button-float-none"><input type="submit" autocomplete="off" value="<?php _e('Import','cloudfw'); ?>"></div>

    <?php         

		$sizeLimit = apply_filters('cloudfw_upload_limit', cloudfw_upload_size());
		$sizeLimit = max(1, $sizeLimit / 1024 / 1024) . 'M';             

        echo "<em class=\"description fileSizeLimit\">File Size Limit: {$sizeLimit}</em>";

     ?>

    </div>
</form>
	
<?php }


function cloudfw_get_form_import_iconset(){
?>	
<div class="clear"></div>
<form enctype="multipart/form-data" class="sending_form" action="<?php echo $this_page;?>" method="POST">
	<input type="hidden" id="form_selector" name="form_selector" value="import-zip" />
	<input type="hidden" id="case" name="case" value="import-icon-set" />
    <input type="hidden" id="comeback" name="comeback" value="<?php echo isset($this_page) ? $this_page : NULL; ?>" />
    <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('cloudfw'); ?>" />
    <input type="hidden" name="<?php echo PFIX.'_update'; ?>" value="1" />
    <?php wp_nonce_field('cloudfw','_wp_nonce');?>

    <input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
    <div class="description"><?php _e('Choose a .zip file to upload','cloudfw'); ?>:</div><input id="upload-iconset" name="uploadedfile" class="cloudfw-ui-custom-uploader upload-input" type="file" /><br/>
    <div class="small-button small-sky"><input type="submit" autocomplete="off" value="<?php _e('Import The File','cloudfw'); ?>"></div>
</form>	
<?php }