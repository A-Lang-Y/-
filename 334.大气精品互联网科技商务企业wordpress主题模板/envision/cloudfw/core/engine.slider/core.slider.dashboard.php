<?php 
	
	$tab = $_GET['tab'];
	$this_page = CLOUDFW_PAGE;
	($tab) ? $this_page .= '&tab='.$tab:NULL;
	

	// Call Theme Options
	global $_opt;
	$config = NULL;
	$_opt = cloudfw_get_all_options(NULL,TRUE);

	$header_title = 'sliders';
	$cloudfw_nav_pages = NULL;
	$onloadscript = 'jQuery(".tabs").tabs({ cookie: { expires: 60, name: "CloudFW_PG_'.$sector_id.'" }});';

	require (TMP_PATH.'/cloudfw/core/framework/cloudfw_header.php'); 
	require (TMP_PATH.'/cloudfw/core/engine.slider/core.slider.include_forms.php'); 
	$msid = $_GET["msid"];
	
	 if (!empty($msid))
		 $toggle_classes = array(1 => "hidden");
	else
		 $toggle_classes = array(0 => "hidden");		
?>

  <?php echo '
        
    <input type="hidden" id="slider_form_option_thispage" value="'.$this_page.'" />
    <input type="hidden" id="slider_form_option_lastid" value="'.$lastID.'" />
    <input type="hidden" id="slider_form_action" value="loop" />
    <input type="hidden" id="slider_form_type" value="main_sliders" />
    
'; ?>
    

                
        <div class="framework_container" style="overflow:visible;" id="add-update-form">
    
    	<div class="header"></div>
    	
        <div class="content">
            
            <div class="head">
            <div style="float:right; margin-left:20px;">
           
                <span id="goback-toggle" class="<?php echo $toggle_classes[0]; ?>"><a href="#" class="small-button small-grey backtoAllSliders"><span><?php _e('Back','cloudfw'); ?></span></a></span>
                <span id="createnew-toggle">
              	<a href="#" title="<?php _e('Import Slider','cloudfw'); ?>" width="m" rel="mb_import_slider" class="small-button small-green help"><span><?php _e('Import','cloudfw'); ?></span></a>
                <a href="#" title="<?php _e('Create New Slider','cloudfw'); ?>" width="m" rel="mb_create_slider" class="small-button small-brown help">
                    <span><?php _e('Create New Slider','cloudfw'); ?></span></a>
				</span>
            </div>
            <div id="small-loading" class="small_loading"></div> <div id="removed_message" class="item_deleted"><?php _e('Slider Deleted','cloudfw'); ?></div> <div class="area">1</div><h1><?php _e('Slider Manager','cloudfw'); ?></h1>
            </div>
            
            <div id="sliderforms">
            
            <?php 
				
				if ( !empty($msid) ) {
					$data_ = $_opt[PFIX."_slider_ids"];
					$data = $data_[$msid];
					cloudfw_main_slider_forms($this_page,$lastID,$data,$msid);
				} else {
					cloudfw_loop_all_sliders($_opt[PFIX."_slider_ids"],NULL, $this_page);
				} 
			
			?>
        	<div class="clear cf"></div>
			</div>
         
             	
  		</div>
        
     </div>
     
    <?php
        
	echo '</form>';
			
?>
        
        
        
<span style="display: none; height: auto;" id="mb_create_slider">
			
    <div style="padding: 20px 20px 0;">
    
    <div>

    <?php								
					
	$theme_sliders = cloudfw_sliders();
	
	if ( !empty($theme_sliders) ):

	?>
    
<form method="post" id="add_slider_form" class="sending_form" action="<?php echo $this_page?>">
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
					"item_title"	=> $slider_item["name"],
					"item_value"	=> $slider_id
					);
								
			}
						
			admin_create_selectlist(
				array(
			        'id'                => 'slider_type',
			        'items'             => $slides,
			        'default_value'     => 'default_slider',
			        'type'              => 'select',
			        'value'             => $data["type"],
			        'main_class'        => 'select',
			        'ui'                => true,
			        'width'             => '300',
				)
			);


		?>

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
    </div>

<div class="clear"></div>
</span>

<span style="display: none; height: auto;" id="mb_import_slider">
			
    <div style="padding: 20px 20px 0;">
    
    <?php include(TMP_PATH.'/cloudfw/core/engine.slider/source.slider.import_form.php'); ?>
    

    </div>

<div class="clear"></div>
</span>

