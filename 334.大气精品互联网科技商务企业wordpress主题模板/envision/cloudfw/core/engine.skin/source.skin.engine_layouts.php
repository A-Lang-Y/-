<?php
/*

# CloudFW Skin Engine Layouts Functions
# Author: Orkun Gürsel - contact@orkungursel.com - support@cloudfw.net

*/

function _remove_empty_internal($value) {
  return $value;
}

/**
 *  Get All Skins Array
 *
 *  @since 1.0
 */
function cloudfw_admin_get_all_skins_array($data, $args){
	
	$tab = isset($_GET['tab']) ? $_GET['tab'] : NULL;
	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	$this_page = CLOUDFW_PAGE;

	if ( $tab ) {
		$this_page_only_tab = $this_page .= '&tab='. $tab ;
	}

	if ( $id ) {
		$this_page .= '&id='. $id ;
	}
	
	$custom_skins_array = (array) cloudfw_get_all_skins();
	krsort($custom_skins_array);

	$home_url = cloudfw_home_url(1); 
	$nonce = wp_create_nonce('cloudfw'); 
	$preview_nonce = wp_create_nonce('cloudfw-live-preview'); 

	$custom_skins = array(); 
	foreach ((array)$custom_skins_array  as $skin_id) {
		
			if ( !$skin_custom = cloudfw_get_a_skin( $skin_id ) )
				continue;

			$colors     = array();
			$colors[]   = isset($skin_custom["data"]["accent"]["gradient"][0]) ? $skin_custom["data"]["accent"]["gradient"][0] : NULL; 
			$colors[]   = isset($skin_custom["data"]["accent"]["gradient"][1]) ? $skin_custom["data"]["accent"]["gradient"][1] : NULL; 
			$colors[]   = isset($skin_custom["data"]["footer"]["background-color"]) ? $skin_custom["data"]["footer"]["background-color"] : NULL; 
			$colors[]   = isset($skin_custom["data"]["link"]["color"]) ? $skin_custom["data"]["link"]["color"] : NULL; 
			$colors[]   = isset($skin_custom["data"]["accent"]["color"]) ? $skin_custom["data"]["accent"]["color"] : NULL; 

			$colors     = array_filter($colors, '_remove_empty_internal');
			$colors     = array_values($colors);
	
			if ( isset($skin_custom["data"]["options"]["thumbnail"]) && $skin_custom["data"]["options"]["thumbnail"] )
				$preview = '
					<div class="mini-preview-item-thumbs">
						<img src="'. cloudfw_thumbnail(array('src'=> $skin_custom["data"]["options"]["thumbnail"],'w'=> 120,'h'=> 90 )) .'" alt="" />
					</div>';
			else {
				$color_count = 3; //count($colors); 

				if ( $color_count >= 4 ) {
					$color_count = 4;
					$colors = array_slice($colors, 0, 4, true);
				}
				
				$preview  = '<div class="mini-preview-colour color-count-'. $color_count .'">';
				/*              
				foreach ($colors as $color) {
					$preview .= '<span class="colour" style="'._makeAttr(NULL,'background-color',$color).'"></span>'; 
				}*/
				for ($i=0; $i <= $color_count ; $i++) {
					$color = isset($colors[$i]) ? $colors[$i] : NULL;
					$preview .= '<span class="colour" style="'._makeAttr( NULL,'background-color', $color ).'"></span>'; 
				}
				$preview .= '</div>';

			}
			
			$custom_skins[] =  array(
			"item_value"    => $skin_id,
			"item_class"    => "",
			"item_html"     => '
						<div class="mini-preview slider-preview">
							'. $preview .'
							<div class="item-divider"></div>
						</div>

						<div class="inset overflow-hidden">
							<div id="skin-id-'. esc_attr( $skin_id ) .'" class="cont">
								<span title="'.esc_attr($skin_custom["name"]).'" class="title">'.cloudfw_less_text($skin_custom["name"], 30).'</span>
							</div>
						',
			"item_before"   => '
				<div>
					<div class="overflow-hidden relative">
						<input type="hidden" class="skin_sorting_id" name="skin_sorting[]" value="'. $skin_id .'" />
			',
			"item_after"    => '
							<div class="item-action" style="width: 267px;">
								<div class="action-divider"></div>
								<div class="mini-action-icons horizontal item-5">
									<span>
										<a class="edit cloudfw-tooltip" title="'.__('edit','cloudfw').'" href="'.$this_page_only_tab.'&amp;jump=1&amp;id='.$skin_id.'"></a>
										<a class="duplicate duplicateSkin cloudfw-tooltip" title="'.__('duplicate','cloudfw').'" href="'.$this_page_only_tab.'&amp;q=1&amp;duplicateSkin=true&amp;id='.$skin_id.'" data-id="'.$skin_id.'"></a>
										<a class="export cloudfw-tooltip" title="'. __('export','cloudfw') .'" href="'.admin_url('admin.php').'?do=CloudFw_Export&nonce='.wp_create_nonce('cloudfw').'&amp;case=export-skins&amp;zip=true&amp;ids='.$skin_id.'"></a>
										<a class="preview cloudfw-tooltip" title="'.__('live preview','cloudfw').'" target="_blank" href="'.$home_url.'?_nonce='.$preview_nonce.'&amp;skin='.$skin_id.'"></a>
										<a class="remove cloudfw-tooltip cloudfw-ui-confirm" title="'.__('delete','cloudfw').'" href="'.$this_page_only_tab.'&amp;q=1&amp;deleteSkin=true&amp;id='.$skin_id.'"></a>
									</span>
								</div>
							</div>
							<div class="item-handle">
								<div class="action-divider"></div>
								<div class="handler"></div>
							</div>
						</div><!-- /inset overflow-hidden -->
					</div>
				</div>
			'
			);
						
	}
	
	return $custom_skins;
	
}

/**
 *  Get Default Skins Array
 *
 *  @since 1.0
 */
function cloudfw_admin_get_default_skins_array(){
	global $cloudfw_theme_skins;
					
	foreach ( (array)  $cloudfw_theme_skins as $skin_id => $skin) {
		
		$skin_version_echo =  ($skin["version"]) ? '<span class="skin-version">with version '.$skin["version"].'</span>':NULL;
		
		$skins[] =  array(
		"item_value"    => $skin_id,
		"item_class"    => "",
		"item_html"     => '<span class="skin-thumb" style="background: url('.$skin["thumbnail"].') no-repeat scroll 0 0 transparent;"></span><span class="skin-name">'.$skin["name"].''.$skin_version_echo.'</span>',
		"item_before"   => '<span class="edit_remove_skin_container">',
		"item_after"    => _if(!empty($skin["css"]),'<span class="edit_remove_skin"><a class="find cloudfw-tooltip" title="'.__('CSS Location:','cloudfw').SKINS_DIR.$skin["css"].'" href="#"><span>'.__('Css','cloudfw').'</span></a></span>').'</span>'
		);
						
	}
	
	return $skins;
	
}


/**
 *  CloudFw Background Set
 *
 *  @since 1.0
 */
function cloudfw_predefined_kit_background($atts = array()){
	extract($atts);
	global $array_patterns, $array_image_repeat, $array_image_attachment, $array_image_positions;
	static $cloudfw_SEL_i;

	$cloudfw_SEL_i++;
	$setID = "cloudfw_bgset_{$cloudfw_SEL_i}";

	$backgroundVal = $data[$sectionModule]["background-image"]; 
	$patternVal = $data[_if($sectionModule_pattern, $sectionModule_pattern, $sectionModule)]["pattern"]; 

	if ( !empty( $backgroundVal ) )
		$jump = '0';
	elseif ( !empty( $patternVal ) )
		$jump = '1';
	else
		$jump = '0';

?>
			<script type="text/javascript">
			// <![CDATA[
				jQuery(function(){
					jQuery("#<?php echo $setID; ?>").tabs({ selected: <?php echo $jump; ?>});

				});
 
			// ]]>
			</script>

			<div id="<?php echo $setID;?>" class="microtabWrap">
				<ul class="microtab">
						
					<li><a class="microTabIcons cImage" href="#<?php echo isset($sectionModule_) ? $sectionModule_ : NULL;?>_cimage"><?php _e('Custom Image','cloudfw'); ?></a>
						<div id="<?php echo isset($sectionModule_) ? $sectionModule_ : NULL;?>_cimage" class="microTabContent">
						<div class="sub-title"><?php _e('Image URL','cloudfw'); ?>:</div>
						<?php
						admin_create_upload_button_v2(array(
							'id'                  => cloudfw_sanitize($sectionModule,'background-image'),
							'value'               => $backgroundVal,
							'preview'             => FALSE,
							'thumb_path'          => isset($data['thumbnail']) ? $data['thumbnail'] : NULL,
							'upload_button_value' => __('Upload','cloudfw'),
							'class'               => 'input_230',
							'wrapClass'           => 'minimal-upload',
						));
						
						?>
						<div class="grid oneof2">
						<div class="sub-title"><?php _e('Image-Repeat','cloudfw'); ?>:</div>

							<?php

								admin_create_selectlist(array(
									'id'                => cloudfw_sanitize($sectionModule,'background-repeat'),
									'items'             => $array_image_repeat,
									'type'              => 'select',
									'value'             => $data[$sectionModule]["background-repeat"],
									'main_class'        => 'cloudfw-ui-select',
									'ui'                => TRUE,
									'width'             => 153,
								));
							
							?>


						 <div class="clear"></div>
						</div><!--/oneof2-->
					  <div class="grid oneof2 last">

						<div class="sub-title"><?php _e('Image-Position','cloudfw'); ?>:</div>
							<?php


								admin_create_selectlist(array(
									'id'                => cloudfw_sanitize($sectionModule,'background-position'),
									'items'             => $array_image_positions,
									'type'              => 'select',
									'value'             => $data[$sectionModule]["background-position"],
									'main_class'        => 'cloudfw-ui-select',
									'ui'                => TRUE,
									'width'             => 153,
								));
							
							?>
						 <div class="clear"></div>
						</div><!--/oneof2-->
					  <?php if ($array_image_attachment && $attachment):?>
					  <div class="grid">
						
						<div class="sub-title"><?php _e('Image-Attachment','cloudfw'); ?>:</div>
							<?php
						   
								admin_create_selectlist(array(
									'id'                => cloudfw_sanitize($sectionModule,'background-attachment'),
									'items'             => $array_image_attachment,
									'type'              => 'select',
									'value'             => $data[$sectionModule]["background-attachment"],
									'main_class'        => 'cloudfw-ui-select',
									'ui'                => TRUE,
									'width'             => 215,
								));
							
							?>
						 <div class="clear"></div>
						 
						</div><!--/grid-->
					  <?php endif;?>
					  
						</div><!--/Tab-->
						<div class="clear"></div>
					</li>
					<li><a class="microTabIcons pDefined" href="#<?php echo isset($sectionModule_) ? $sectionModule_ : NULL;?>_pdefined"><?php _e('Predefined Styles','cloudfw'); ?></a>
						<div id="<?php echo isset($sectionModule_) ? $sectionModule_ : NULL;?>_pdefined" class="microTabContent">
							<div class="sub-title"><?php _e('Styles','cloudfw'); ?>:</div>
							<?php
							
							admin_create_gf_menu (array(
								'id'        => cloudfw_sanitize(_if($sectionModule_pattern, $sectionModule_pattern, $sectionModule),'pattern'),
								'value'     => $patternVal,
								'content'   => $array_patterns,
								'width'     => '260',
								'class'     => '',
								'acc'       => TRUE
								)
							);
							
							?>
						<div class="clear"></div>
						</div><!--/Tab-->
					</li>

				</ul>
				
			</div>


<?php
}