<div id="framework">
<?php 
	global $_opt;
	
	$tab = $_GET['tab'];
	$this_page = CLOUDFW_PAGE;
	($tab) ? $this_page .= '&tab='.$tab:NULL;
	$main_slider_id = $id;
	$raw_this_page = $this_page;
	$this_page = $this_page.'&amp;id='.$main_slider_id;
	
	
	$header_title = $cloudfw_sliders[$type]["name"];
	$cloudfw_nav_pages = NULL;
	
	$sector_id = $type;
	$onloadscript = 'jQuery(".tabs").tabs();';


	require (TMP_PATH.'/cloudfw/core/framework/cloudfw_header.php'); 
	require (TMP_PATH.'/cloudfw/core/engine.slider/core.slider.include_forms.php');
	
	 echo '
		<input type="hidden" id="slider_form_option_thispage" value="'.$this_page.'" />
		<input type="hidden" id="slider_form_option_lastid" value="'.$lastID.'" />
		<input type="hidden" id="slider_form_option_main_slider_id" value="'.$main_slider_id.'" />
		<input type="hidden" id="slider_form_option_case" value="'.$type.'" />
	'; ?>
  
		<div class="wrap">
            
            
            <div class="framework_container" style="overflow:visible;" id="add-update-form">
        
        	<div class="header"></div>
        	
            <div class="content">
                
                <div class="head">
                <div style="float:right; margin-left:20px;">

                <span id="goback-toggle" class="hidden"><a href="#" class="small-button small-grey backtoAllSliders"><span><?php _e('Back','cloudfw'); ?></span></a></span>
                <a href="#" id="add_new_slider" class="small-button small-brown"><span><?php _e('Add New Item','cloudfw'); ?></span></a>

                </div>
                
                <div id="small-loading" class="small_loading"></div> <div id="removed_message" class="item_deleted"><?php _e('Slider Item Deleted','cloudfw'); ?>
                
                
                </div> <div class="area">1</div><h1><?php _e('Slider Items','cloudfw'); ?></h1>
                </div>
				
        <?php echo '<a id="to-main-slider" class="right-navigation cloudfw-tooltip" title="'.__('Slider Options','cloudfw').'" href="'.$raw_this_page.'&amp;msid='.$main_slider_id.'"><span></span></a>'; ?>

                
                <div id="sliderforms">
                
                	<?php cloudfw_loop_slider_items(cloudfw_get_slider($main_slider_id),$type, $main_slider_id); ?>    
      		        <div class="clear cf"></div>

                </div>
                	
      		</div>

            
         </div>
         
        </div>
        

</div>

<?php require (TMP_PATH.'/cloudfw/core/framework/cloudfw_footer.php');  ?>