<?php
/**
	* CloudFw Composer - Save Callback
	*
	* @since 3.0
	*/ 
add_action('save_post', 'cloudfw_composer_save_callback');
function cloudfw_composer_save_callback( $post_id ) {
	$sandbox = 0; 

		/* Check Autosave */
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
				return $post_id;
		
		$composer_activate = isset($_POST['composer_activate']) ? $_POST['composer_activate'] : NULL;
		$composer_post_id = isset($_POST['composer_post_id']) ? $_POST['composer_post_id'] : NULL;
		if ( $composer_activate != true ) {
			
			if ( isset($composer_post_id) )
				update_post_meta( $post_id, PFIX . '_composer_activate', 'FALSE' );

			return $post_id;

		} else {

			update_post_meta( $post_id, PFIX . '_composer_activate', true );

		}

		$composer_data = array();
		$composer = isset($_POST['_composer']) ? $_POST['_composer'] : NULL; 

		if ( !is_array($composer) ) 
			$composer = array();

		$composer_data = ( $composer );
		$composer_data = cloudfw_composer_check_input_types( $composer );

		if ( $sandbox ) {
				echo '<pre>';
				 print_r($composer_data);
				echo '</pre>';
			exit;
		}
		
		cloudfw_save_composer_data( $post_id, $composer_data );

}

/**
 *  Composer revision
 */
function cloudfw_composer_revision_restore( $post_id, $revision_id ) {
	$post     = get_post( $post_id );
	$revision = get_post( $revision_id );
	$meta     = get_metadata( 'post', $revision->ID, cloudfw_composer_data_key(), true );

	if ( false === $meta )
		delete_post_meta( $post_id, cloudfw_composer_data_key() );
	else
		update_post_meta( $post_id, cloudfw_composer_data_key(), $meta );
}

/**
 *  Save the composer data for revision
 */
function cloudfw_composer_revision_save_post( $post_id, $post ) {
	if ( $parent_id = wp_is_post_revision( $post_id ) ) {

		$parent = get_post( $parent_id );
		$meta = get_post_meta( $parent->ID, cloudfw_composer_data_key(), true );

		if ( false !== $meta )
			add_metadata( 'post', $post_id, cloudfw_composer_data_key(), $meta );

	}
}

/** Register functions for revision hooks */
add_action( 'save_post',                   'cloudfw_composer_revision_save_post', 10, 2 );
add_action( 'wp_restore_post_revision',    'cloudfw_composer_revision_restore', 10, 2 );

function cloudfw_copy_composer_data_check( $composer_data ){
		foreach((array) $composer_data as $data) {
			if ( !isset($data['_composer-type']) && isset($data['_composer_data']) )
				$composer_data = cloudfw_copy_composer_data_check( $data['_composer_data'] );
		}

		return $composer_data;
}

/**
 *  Copy Composer Data
 *
 *  @since 1.0
 */
function cloudfw_copy_composer_data(){
		$composer_data = array();
		$composer = isset($_POST['_composer']) ? $_POST['_composer'] : NULL; 

		if ( !is_array($composer) ) {
			$composer = array();
		}

		$composer_data = ( $composer );
		$composer_data = cloudfw_copy_composer_data_check( $composer_data );
		$composer_data = cloudfw_composer_check_input_types( $composer_data );

		return $composer_data;
}

/**
 *  Get All Skins
 *
 *  @version 1.0
 */
function cloudfw_composer_template_all() {
	return get_option(PFIX.'_composer_templates');
}

/**
 *  Get Composer Template
 */
function cloudfw_composer_template( $id ) {
	return get_option($id);
}

/**
 *  Manage Composer Templates
 *
 *  @version 1.0
 */
function cloudfw_composer_template_manager( $op = 'add', $args = array(), $data = array() ) {
		extract(cloudfw_make_var(array(
			'id'       => NULL,
			'name'     => NULL,
	), $args));

	$composer_templates = cloudfw_composer_template_all();
							
	switch ($op) {
		case 'add': default:
			$random_id = 'composer_tmp_'.cloudfw_randomizer(10);
			if (empty($id)) $id = $random_id;
			
			if (!in_array($id, (array)$composer_templates)){  
				$composer_templates[$id] = array('name' => $name );

				if (!empty($data)) {
					update_option(PFIX.'_composer_templates', $composer_templates);
					update_option($id, $data);
				}
				
				return $id;
			}
			return false;
			
		break;
		case 'export':

			$name = sanitize_title( $name );
			$filename = sanitize_file_name( $name ) . '.txt';
			$serialized_data = json_encode( $data );
			return cloudfw_file_create( trailingslashit( PREPAGES_DIR_PATH ), $filename, $serialized_data );
			
		break;
		case 'update':
			if (empty($id) || !in_array( $id, (array)$composer_templates ) ) {
				return;
			}

			if (!empty($data)) {
				update_option($id, $data);
				return $id;
			}
		
			return false;
			
		break;
		case 'delete':

			unset($composer_templates[$id]);
			update_option(PFIX.'_composer_templates', $composer_templates);
			delete_option($id);
			
			return $id;
			return false;
			
		break;

	}
	
}

/**
 *  CloudFw Get Item Scheme for Composer Element
 *
 *  @since 3.0
 */
function cloudfw_composer_get_item_scheme( $item_class, $type = NULL ){
	$maps = array();

	if ( class_exists($item_class . '_Admin') ) {
			$item_class .= '_Admin';
	}

	if ( !class_exists($item_class) )
			return false;

	$item_class_object = new $item_class;
	$item_class_object->is_composer = true;  

	if ( method_exists($item_class_object, 'composer_scheme') ) {
		$maps['composer'] = $item_class_object->composer_data_prepare( $item_class, $item_class_object->composer_scheme() );
		if (  $type ) {
			$maps['composer']['type'] = $type;
		}
	}

	if ( method_exists($item_class_object, 'scheme') ) {
		$maps['shortcode'] = $item_class_object->composer_data_prepare( $item_class, $item_class_object->scheme() );
		if (  $type ) {
			$maps['shortcode']['type'] = $type;
		}
	}

	return $maps;

}

/**
 *  CloudFw Set Composer Data
 *
 *  @since 1.0
 */
function cloudfw_set_composer_data( $data ){
	global $cloudfw_composer_data, $CloudFw_Shortcodes;

	$CloudFw_Shortcodes->set_data($data);
	$cloudfw_composer_data = $data;
}

/**
 *  Save Composer Data
 *
 *  @since 1.0
 */
function cloudfw_save_composer_data( $post_id, $data = array() ) {
	//$data = json_encode($data);
	return update_post_meta( $post_id, cloudfw_composer_data_key(), $data /*esc_sql( $data ) */);
}

/**
 *  CloudFw Composer - Check Input Types
 *
 *  @since 1.0
 */
function cloudfw_composer_check_input_types( $data ){
	if ( !is_array($data) )
		return $data;

	foreach ($data as $name => $value) {
				if ( is_array( $value ) ) {
						$value =  cloudfw_composer_check_input_types( $value );
				} else
						$value = stripslashes( $value );

		if( strpos($name, 'is_defined_') !== false ) {
			$current_name = str_replace('is_defined_', '', $name); 
			
			/** Onoff */
			if ( $value == 'onoff' ) {
				if ( empty($data[ $current_name ]) )
					$data[ $current_name ] = 'FALSE'; 
			}

			unset($data[$name]);

		} else {

			$data[ $name ] = $value;
		}

	}

	return $data;

}

/**
 *  CloudFw Composer Get Source
 *
 *  @since 1.0
 */
function cloudfw_composer_get_source( $type, $via_ajax = false  ) {
		$maps = cloudfw_composer_get_item_scheme( $type );

		if ( isset( $maps['shortcode'] ) ) {
			$composer_data = isset($maps['composer']['data']) ? $maps['composer']['data'] : NULL; 
			echo cloudfw_render_page( array( 'data' => $maps['shortcode'] ), array( 'data' => $composer_data, 'via_ajax' => isset($via_ajax) ? $via_ajax : NULL ) );
		} else {
			echo cloudfw_render_page( array( 'data' => $maps['composer'] ), array( 'wrap_options' => false, 'via_ajax' => isset($via_ajax) ? $via_ajax : NULL ) );
		}

		unset( $maps );
}

/**
 *    CloudFw Composer Render Items
 *
 *    @since 1.0
 */
function cloudfw_composer_render_sources( $classes = array() ){
		foreach ((array)$classes as $type) {
				cloudfw_composer_get_source( $type );        
		}

}

/**
 *    CloudFw Composer Render Items
 *
 *    @since 1.0
 */
function cloudfw_composer_render_item( $sub = false, $data = array() ){
	 if ( empty($data) ) {
		global $cloudfw_composer_data;
		$data = $cloudfw_composer_data;
	 }

	 if ( isset($sub) && $sub ) {
		$data = isset($data['_composer_data']) ? $data['_composer_data'] : NULL;
	 }

	 foreach ((array)$data as $item_number => $item) {
		$type = $item['_composer-type']; 
		cloudfw_set_composer_data( $item );
		$maps = cloudfw_composer_get_item_scheme( $type, 'composer:item' );

		if ( isset( $maps['shortcode'] ) ) {
			$composer_data = isset($maps['composer']['data']) ? $maps['composer']['data'] : NULL;
			echo cloudfw_render_page( array( 'data' => $maps['shortcode'] ), array( 'data' => $composer_data ) );
		} else {
			echo cloudfw_render_page( array( 'data' => $maps['composer'] ), array( 'wrap_options' => false ) );
		}

		unset( $maps );
	 }

}

/**
	* CloudFw - Composer Elements
	*
	* @since 3.0
	*/
 function cloudfw_render_composer_elements( $items, $shortcode_map ) {
	$developing = cloudfw_in_developing();

	if ( !is_array($items) )
		return '';
	
	ksort($items);

	$shortcode_block = '';

	echo '<ul id="cloudfw-composer-components">';
		echo '<li id="cloudfw-composer-logo"><span></span></li>';
		$i = 0;

		foreach ($items as $item_id => $item) {

			if (is_array( $item['sub'] ))
				ksort( $item['sub'] );

			if ( $item['_optgroup'] ) {
				if ( empty($item['sub']) )
					continue;

				$i++;
				$classes = array();
				$classes[] = "item-{$i}";
				echo '<li '. cloudfw_make_class($classes, 1) .'><a href="javascript:;">'. $item['_title'] .' <i class="fontawesome-angle-down" style="font-size: 14px; margin-left: 3px;"></i></a>';
				
					if ( !empty( $item['sub'] ) && is_array( $item['sub'] ) ) {
						$ii = 0; 
						$total = count((array) $item['sub']); 
						$columns = 1; 
						$columns_class = 'one-column';

						if ( ($total / 4) > 5 ) {
							$columns = 4;
							$columns_class = 'four-column'; 

						} elseif ( ($total / 3) > 4 ) {
							$columns = 3;
							$columns_class = 'three-column'; 

						} elseif ( ($total / 2) > 5 ) {
							$columns = 2;
							$columns_class = 'two-column'; 
						}


						echo '<ul class="'. $columns_class .'">';
							foreach ((array) $item['sub'] as $sub_item_id => $sub_item) { $ii++;
								$options = $sub_item['_options'];
								$classes = array();
								$classes[] = "item-{$ii}";
								$classes[] = $sub_item['_composer_id'];

								/*if ( $ii % 2 == 0 ) {
									$classes[] = "odd";
								} else {
									$classes[] = "even";
								}*/
								
								$classes[] = "mod-" . ($ii % $columns);
								$classes[] = "last-" . ($total - $ii);
																	
								if ( $total == ($ii + 1) ) {
									$classes[] = "before-last";
								} elseif ( $total == $ii ) {
									$classes[] = "last";
								}

								echo '<li '. cloudfw_make_class($classes, 1) .'>';
									echo '<a class="dragable-element" data-type="'.$sub_item['_composer_id'].'" href="javascript:;"'. _if( $developing && $sub_item['_alt'], ' title="'. $sub_item['_alt'] .'"' ) .'>';
										if ( $sub_item['_icon'] )
											echo '<i><img src="'. TMP_ADMIN_GUI . '/composer-icons/' . $sub_item['_icon'] .'.png" alt=""/></i>';;

										echo $sub_item['_title'];
									echo '</a>';
								echo '</li>';
							}
						echo '</ul>';
					}

				echo '</li>';
			} else {
				echo '<a class="dragable-element" data-type="'.$item['_composer_id'].'" href="javascript:;">'.$item['_title'].'</a>';
			}

		}

		echo '<div style="position: absolute; top: 6px; right: 10px;">';

		if ( cloudfw_is_multilingual() ) {
			if( cloudfw_ml_plugin() == 'qtranslate' ) {


					/** Get Languages */
				$languages = cloudfw_get_languages();
				if ( !empty( $languages ) ):

						/** Get Current Language */
					$current_language_code = cloudfw_get_current_language();

					$cl = $languages[$current_language_code];
					$languages_count = count( (array) $languages );

					/** Loop */
						if ( $languages_count > 1 ):

								echo '<li class="cloudfw-languages current-language language-'.$current_language_code.'">';
										echo '<a href="javascript:;" data-lang="'. $current_language_code .'">';
												echo '<img class="flag" src="'.$cl['flag'].'" alt="'.esc_attr( $cl['name'] .' flag' ).'" />';
												echo $cl['name'];
										echo '</a>';

								echo '<ul class="cloudfw-languages">';
										foreach ($languages as $language => $l) {
												if ($l['current'] == 1)
														continue;
																				
												$link = add_query_arg('lang', $language);
												$link = (strpos($link, "wp-admin/") === false) ? preg_replace('#[^?&]*/#i', '', $link) : preg_replace('#[^?&]*wp-admin/#i', '', $link);


												echo '<li class="language-item language-'.$language.'">';
														echo '<a href="'. $link .'" data-lang="'. $language .'">';
																echo '<img class="flag" src="'.$l['flag'].'" alt="'.esc_attr( $l['name'] .' flag' ).'" />';
																echo $l['name'];
														echo '</a>';
												echo '</li>';

										}       

								echo '</ul>';
								
								echo '</li>';
						endif;

				endif;




			}
		}

		echo '
				<div class="cloudfw-composer-editing-buttons hidden" style="float:left;">
								<a href="javascript:;" id="cloudfw-composer-edit-prev-button" class="minimal-button">
										<span>'. __('Previous','cloudfw') .'</span>
								</a>
								<a href="javascript:;" id="cloudfw-composer-edit-next-button" class="minimal-button">
										<span>'. __('Next','cloudfw') .'</span>
								</a>
								<a href="javascript:;" id="cloudfw-composer-done-button" class="cloudfw-composer-done small-button small-green cloudfw-tooltip" title="'.esc_attr('Shortcut: CTRL + E').'">
										<span>'. __('Done Editing','cloudfw') .'</span>
								</a>
				</div>
				<div style="float:left;">
								<a href="javascript:;" id="cloudfw-composer-save-button" class="small-button small-sky cloudfw-tooltip" title="'.esc_attr('Shortcut: CTRL + S').'">
										<span>'. __('Save','cloudfw') .'</span>
								</a>
				</div>
			</div>
		';

	echo '</ul><div class="clear"></div>';

 }

function cloudfw_render_composer_javascript( $data ){
?>
	
	<script type="text/javascript">
		//<![CDATA[
		function cloudfw_composer_javascript_utilities( type, active_element ){
			switch( type ){
				<?php echo cloudfw_render_composer_javascript_utilities( $data ); ?>
			}
		}
		//]]>
	</script>

<?php
}


 /**
 *  CloudFw Composer Render Javascripts Utilities
 *
 *  @since 1.0
 */
function cloudfw_render_composer_javascript_utilities( $data = array(), $render = '' ){
	if ( ! is_array($data) )
		return;

	$i = (int) 0;
	ksort($data);
	
	foreach ($data as $data_number => $datas): $i++;

		if ( isset($datas['type']) && $datas['type'] == 'composer:sub' ) {
			$render .= "\ncase '". $datas['composer_id'] ."':\n";
		}
		
		if ( isset($datas['script']) && !empty($datas['script']['if']) && is_array($datas['script']['if']) ):
			
			foreach($datas['script']['if'] as $condition){       

				switch ( $condition['type'] ) {
					case 'toggle':

						$script = ''; 
						$element = $condition['e'];
						$val_element = 'val_' . $element;
						$condition_operator = isset($condition['!']) && $condition['!'] == true ? '!=' : '==';

						foreach ( (array) $condition['targets'] as $target ) {
							$script .= "\nif (".$val_element." ". $condition_operator ." '".$target[0]."') {";
								$script .= "\nvar currentElement = jQuery('".$target[1]."', active_element)";

								if ( (isset($condition['mode']) && $condition['mode'] == 'parent') || empty($condition['mode']) )
									$script .= ".parents('.indicator').first()";
								
								$script .= ";";

								$script .= "\ncurrentElement.removeClass('hidden').show().prev('.divider').show();";
							$script .= "\n}\n";
						}

						$render .= "\nvar ".$val_element." = cloudfw_get_value(jQuery('#".$element."', active_element));";
						$render .= "\njQuery('.".$condition['related']."', active_element).hide().prev('.divider').hide();";
						$render .= $script;
						
						$render .= "\njQuery('#".$element."', active_element).on('change',function(){ ";
						$render .= "\nvar ".$val_element." = cloudfw_get_value(jQuery(this)); ";
						$render .= "\njQuery('.".$condition['related']."', active_element).hide().prev('.divider').hide();";
							$render .= $script; 
						$render .= "});";

					break;
				}

			}

		endif;

		if ( !empty($datas['data']) && is_array($datas['data']) ) {
			$render = cloudfw_render_composer_javascript_utilities( $datas['data'], $render );
		}

		if ( isset($datas['type']) && $datas['type'] == 'composer:sub' ) {
			$render .= "\nbreak;\n\n";
		}

	endforeach;

	return $render;
	
}