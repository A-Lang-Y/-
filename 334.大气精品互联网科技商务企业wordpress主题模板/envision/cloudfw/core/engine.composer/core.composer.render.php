<?php
/**
 *	CloudFW Composer - Render Functions
 *	
 *	@author Orkun Gürsel - contact@orkungursel.com - support@cloudfw.net
 *	@since 1.0
 */
 	require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
 	require_once(TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.php');

    global $post, $CloudFw_Shortcodes;
    $CloudFw_Shortcodes->is_composer = true;
    
    $post_id = $post->ID;

 	$composer_map = cloudfw_get_schemes('composer');
 	$composer_activate = cloudfw_composer_is_activated( $post_id );
 	$post_composer_data = cloudfw_composer_get_data( $post_id );

 	if ( empty($composer_activate) )
 		if ( !in_array($post->post_type, apply_filters( 'cloudfw_composer_default_types' , array('page') ) ) )
 			$composer_activate = 'FALSE'; // default state

 	$composers = array();
	$composer_sources = array(); 

	foreach ($composer_map as $composer_number => $composer):
		if ($composer['type'] == 'composer:group' || $composer['type'] == 'composer'){
			$composers[$composer_number] = array(
				'_id' 		=> $composer['id'],
				'_title' 	=> $composer['title'],
				'_div' 		=> _if($composer['type'] == 'composer', true, false),
				'_optgroup'	=> _if($composer['type'] == 'composer:group', true, false),
			);

			if ( is_array($composer['data']) && $composer['type'] == 'composer:group' ) {

				foreach ($composer['data'] as $sub_composer_number => $sub_composer):

					if ($sub_composer['type'] != 'composer:sub')
						continue;

					if ( !isset($sub_composer['composer']['list']) || $sub_composer['composer']['list'] !== false ) {

						$composers[$composer_number]['sub'][$sub_composer_number] = array(
							'_composer_id' 	=> isset($sub_composer['composer_id']) ? $sub_composer['composer_id'] : NULL,
							'_id'        	=> 'composer-' . isset($sub_composer['number']) ? $sub_composer['number'] : NULL,
							'_title'     	=> isset($sub_composer['composer']['options']['title']) ? $sub_composer['composer']['options']['title'] : NULL,
							'_icon'     	=> isset($sub_composer['composer']['icon']) ? $sub_composer['composer']['icon'] : NULL,
							'_list'     	=> isset($sub_composer['composer']['list']) ? $sub_composer['composer']['list'] : NULL,
							'_options'		=> isset($sub_composer['composer']['options']) ? $sub_composer['composer']['options'] : NULL,
							'_alt'			=> 'ALT-' . $sub_composer_number,
							'_div'       	=> true,

						);

					}
					$composer_sources[] =  $sub_composer['composer_id'];


				endforeach;
 				ksort($composers[$composer_number]['sub']);
				
			} 
		}
	endforeach;
	ksort($composers);

	$composer_sources = array_unique($composer_sources); 

 	echo '<div id="cloudfw-composer" class="cloudfw-content-composer cloudfw-hidden">';	
 		echo '<input type="checkbox" value="1" id="cloudfw-composer-new-post" name="composer_new_post" class="cloudfw-hidden-input" autocomplete="off" '. _if( empty($_GET["post"]), ' checked="checked"' ) .'>';
 		echo '<input type="checkbox" value="1" id="cloudfw-composer-activate" name="composer_activate" class="cloudfw-hidden-input" autocomplete="off" '. _if( _check_onoff($composer_activate), ' checked="checked"' ) .'>';
 		echo '<input type="hidden" value="'. $post_id .'" id="cloudfw-composer-post-id" name="composer_post_id" autocomplete="off">';
 		echo '<div id="cloudfw-composer-header">';
 			
			 	cloudfw_render_composer_elements( $composers, $composer_map );

 			echo '<div id="cloudfw-composer-sources" class="dont-make-ui">';
				echo cloudfw_composer_render_sources( $composer_sources );
 			echo '</div>';


 		echo '</div>';

 		echo '<div class="cloudfw-composer-content-wrap">';
	 		echo '<ul id="cloudfw-composer-content" class="cloudfw-composer-content 1stlevel CloudFw_Composer row-fluid normal-mode" data-variable="_composer">';

	 			if( !empty( $post_composer_data ) ) {
	 				echo cloudfw_composer_render_item( false, $post_composer_data );
	 			}

	 		echo '</ul>';
	 		echo '<div id="cloudfw-composer-footer">';
	 			echo '<ul id="cloudfw-composer-footer-menu" class="not">';
	 				echo '<li class="first"><a class="cloudfw-composer-copy" data-copy="selected" href="javascript:;">'. __('Export','cloudfw') .'</a>';
	 					echo '<ul class="not">';
	 						echo '<li><a class="cloudfw-composer-copy" data-copy="all" href="javascript:;">'. __('Export All','cloudfw') .'</a></li>';
	 						echo '<li><a class="cloudfw-composer-copy" data-copy="selected" href="javascript:;">'. __('Export Selected','cloudfw') .'</a></li>';
	 					echo '</ul>';
	 				echo '</li>';
	 				echo '<li><a id="cloudfw-composer-paste" href="javascript:;">'. __('Import','cloudfw') .'</a></li>';
	 				echo '<li><a id="cloudfw-composer-delete-all" href="javascript:;">'. __('Delete All','cloudfw') .'</a></li>';
	 				echo '<li class="right"><a id="cloudfw-composer-toggle-shortcuts" href="javascript:;"><i class="fontawesome-question" style="font-size: 16px;"></i></a></li>';

	 				$save_load_template_cap = cloudfw_get_option( 'caps', 'save_load_template' );
	 				$show_save_load_template = false;
	 				if ( empty( $save_load_template_cap ) || current_user_can( $save_load_template_cap ) ) {
	 					$show_save_load_template = true;
	 				}

	 				if ( $show_save_load_template ) {
		 				echo '<li class="right"><a id="cloudfw-composer-save-template" href="javascript:;">'. __('Save as Template','cloudfw') .'</a></li>';
		 				echo '<li class="right"><a id="cloudfw-composer-load-templates" href="javascript:;">'. __('Load Templates','cloudfw') .'</a></li>';
	 				}

	 				$prebuilt_pages_cap = cloudfw_get_option( 'caps', 'prebuilt_pages' );
	 				$show_prebuilt_pages = false;
	 				if ( empty( $prebuilt_pages_cap ) || current_user_can( $prebuilt_pages_cap ) ) {
	 					$show_prebuilt_pages = true;
	 				}

	 				if ( $show_prebuilt_pages ) {
		 				echo '<li class="right"><a id="cloudfw-composer-load-prebuilt-templates" href="javascript:;">'. __('Pre-Built Pages','cloudfw') .'</a>';
		 					if ( cloudfw_in_developing() ) { 						
			 					echo '<ul class="not">';
			 						echo '<li><a id="cloudfw-composer-save-prebuilt-template" href="javascript:;">'. __('Save as Pre-Built Page','cloudfw') .'</a></li>';
			 					echo '</ul>';
		 					}
		 				echo '</li>';
	 				}


 				echo '</ul><div class="clear cf"></div>';

	 			echo '<ul id="cloudfw-composer-shortcuts" class="not hidden">';
	 				echo '<li><span class="shortcut-title">'. __('Save','cloudfw') .':</span> <span class="shortcut-key">CTRL + S</span></li>';
	 				echo '<li><span class="shortcut-title">'. __('Edit/Done','cloudfw') .':</span> <span class="shortcut-key">CTRL + E</span></li>';
	 				echo '<li><span class="shortcut-title">'. __('Clone','cloudfw') .':</span> <span class="shortcut-key">CTRL + D</span></li>';
	 				echo '<li><span class="shortcut-title">'. __('Delete','cloudfw') .':</span> <span class="shortcut-key">DEL</span></li>';
	 				echo '<li><span class="shortcut-title">'. __('Edit Title','cloudfw') .':</span> <span class="shortcut-key">F2</span></li>';
	 				echo '<li><span class="shortcut-title">'. __('Move Up','cloudfw') .':</span> <span class="shortcut-key">CTRL + UP</span></li>';
	 				echo '<li><span class="shortcut-title">'. __('Move Down','cloudfw') .':</span> <span class="shortcut-key">CTRL + DOWN</span></li>';
	 				echo '<li><span class="shortcut-title">'. __('Decrease Width','cloudfw') .':</span> <span class="shortcut-key">CTRL + LEFT</span></li>';
	 				echo '<li><span class="shortcut-title">'. __('Increase Width','cloudfw') .':</span> <span class="shortcut-key">CTRL + RIGHT</span></li>';
 				echo '</ul><div class="clear cf"></div>';
 			echo '</div>';
 		echo '</div>';

 		echo '<!-- /JSJS -->';

 		cloudfw_render_composer_javascript($CloudFw_Shortcodes->get_composer_data());

 		echo '<div id="cloudfw-composer-overlay" class=""></div>';
 	echo '</div>';
 	echo '<div id="cloudfw-composer-loading" class="loading"></div>';