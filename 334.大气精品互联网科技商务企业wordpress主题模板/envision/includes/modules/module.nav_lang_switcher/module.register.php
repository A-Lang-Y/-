<?php

if ( ! cloudfw_check_onoff( 'nav_lang_switcher', 'enable' ) ) {
	return false;
}

add_filter( 'wp_nav_menu_objects', 'cloudfw_add_language_selector_to_nav_menu', 10, 2 );
function cloudfw_add_language_selector_to_nav_menu( $items, $args = array() ){

	if ( $args->theme_location == 'primary' && $args->depth == 0 ) {

		if ( cloudfw_is_multilingual() ) {

			/** Get Languages */
			$languages = cloudfw_get_languages();
			if ( !empty( $languages ) ){
				/** Get Current Language */
				$current_language_code = cloudfw_get_current_language();

				$cl = $languages[$current_language_code];
				$languages_count = count( (array) $languages );
				
				$show_name = cloudfw_check_onoff( 'nav_lang_switcher', 'name' );
				$show_flag = cloudfw_check_onoff( 'nav_lang_switcher', 'flag' );
				$link_type = cloudfw_get_option( 'nav_lang_switcher', 'link_type' );



				if ( $languages_count > 1 ){

					$title = '';
					if ( $show_flag && $cl['flag'] ) {
						$title .= '<img class="flag" src="'.$cl['flag'].'" alt="'.esc_attr(  $cl['name'] .' flag' ).'" />';
					}
					if ( $show_name ) {
						$title .= $cl['name'];
					}

					$item_top = array(
						'noconvert' => TRUE,
						'ID'        => 99999,
						'db_id'     => 99999,
						'filter'    => 'raw',
						'menu_item_parent'
									=> 0,
						'object'    => 'custom',
						'type'      => 'custom',
						'type_label'=> 'Custom',
						'title'     => $title,
						'url'       => __home_url(),
					);

					$item_top['classes'][] = 'menu-item menu-item-type-custom menu-item-object-custom menu-item-lang-selector level-0 top-level-item to-' . cloudfw_get_option( 'nav_lang_switcher', 'dropdown_position', 'left' );
					
					if ( !$show_name ) {
						$item_top['classes'][] = 'o--no-lang-name';
					}


					if ( is_array( $items ) && !empty($items) ) {
						array_push($items, (object) $item_top);
					}


					foreach ($languages as $language => $l) {
						if ($l['current'] == 1)
							continue;

						$url = $link_type == 'home' ? $l['home_url'] : $l['url'];

						$title = '';
						if ( $show_flag && $l['flag'] ) {
							$title .= '<img class="flag" src="'.$l['flag'].'" alt="'.esc_attr(  $l['name'] .' flag' ).'" />';
						}
						if ( $show_name ) {
							$title .= $l['name'];
						}

						$item_sub = array(
							'noconvert' => TRUE,
							'ID'        => 0,
							'db_id'     => 0,
							'filter'    => 'raw',
							'menu_item_parent'
										=> 99999,
							'object'    => 'custom',
							'type'      => 'custom',
							'type_label'=> 'Custom',
							'title'     => $title,
							'url'       => $url,
						);

						$item_sub['classes'][] = 'menu-item menu-item-type-custom menu-item-object-custom level-1 sub-level-item';

						if ( is_array( $items ) && !empty($items) ) {
							array_push($items, (object) $item_sub);
						}

					}
			
				}

			}

		}


	}

	return $items;
}