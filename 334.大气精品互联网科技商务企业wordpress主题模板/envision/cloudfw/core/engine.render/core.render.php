<?php
/**
 *  CloudFW Render Functions
 *
 *  @author Orkun Gürsel - contact@orkungursel.com - support@cloudfw.net
 *  @since 1.0
 */

/**
 *  Render Page Styles
 *
 *  @since 1.0
 */
function cloudfw_render_page( $data = array(), $args = array(), $force_type = NULL ){

	if ( ! is_array($data) )
		return;

	$i = (int) 0;
	ksort($data);

	foreach ($data as $data_number => $datas):

		if ( isset( $datas['condition'] ) ) {
			if ( $datas['condition'] === false || $datas['condition'] === 0 ) {
				continue;
			} elseif ( is_array($datas['condition']) ){
				if ( $datas['condition']['!'] ) {
					if ( ! cloudfw_render_filters( $datas['condition'], $args ) )
						continue;
				} else {
					if ( cloudfw_render_filters( $datas['condition'], $args ) )
						continue;
				}
			}
		}

		$i++;

		$datas['type'] = isset($datas['type']) ? $datas['type'] : NULL;
		$type = !isset($force_type) || !$force_type ? $datas['type'] : $force_type;

		/** Set Default */
		if ( isset($datas['default']) ) {
			if ( ! isset($datas['value']) )
				$datas['value'] = $datas['default'];

		}

		if ( isset( $data['desc'] ) )
			$data['description'] = $data['desc'];

		if ( isset($data['clear_before']) && $data['clear_before'] )
			echo '<div class="clear"></div>';

	cloudfw_options_route_set( $type, $datas );

	switch($type){

/*  Scheme  */
		case 'scheme':
			if (! is_array($datas))
				continue;

		$source = isset($datas["source"]) ? $datas["source"] : NULL;
		if ( $source && file_exists($source) ) {

			$filename = basename( $source );
			if ( strpos($filename, '.scheme.php') == false ) {
				$source = trailingslashit( dirname($source) ) . pathinfo($source, PATHINFO_FILENAME) . '.scheme.php';
				if ( !file_exists( $source ) )
					continue;
			}

			$that = isset($datas['this']) ? $datas['this'] : NULL;
			$scheme = include( $source );
			cloudfw_render_page( $scheme, $args );

			if ( $that )
				unset($that);

			unset($datas);

		} else {
			continue;
		}

		break;

/*  Global Scheme   */
		case 'global-scheme':
			if (! is_array($datas))
				continue;

			$that = isset($datas['this']) ? $datas['this'] : NULL;

			$function_variables = array();
			$function_variables[] = $datas['scheme'];
			$function_variables[] = false;
			$function_variables[] = $that;

			if ( isset($datas['vars']) && is_array($datas['vars']) && $datas['vars'] ) {
				$function_variables = array_merge( $function_variables, $datas['vars'] );
			}

			$scheme = call_user_func_array( 'cloudfw_get_schemes', $function_variables );
			cloudfw_render_page( $scheme, $args );

			unset($that);
			unset($datas);

		break;

/*  VERTICAL TABS   */
		case 'vertical_tabs':
			if (! is_array($datas))
				continue;

			if ( isset( $datas['form'] ) && $datas['form'] )
				cloudfw_render_form_header($datas["form"], $args);

			echo '<div id="'.$datas['tab_id'].'">';//.$datas['tab_id'].'';

						$tabs = cloudfw_prepare_tabs( $datas["data"], 'tabs' );
						if ( isset( $tabs ) && $tabs ) {
							echo '<div class="cloudfw-ui-tabs" rel="'. @md5(@serialize($tabs)) .'">';

							$tabs_align = isset($datas["tabs_align"]) ? $datas["tabs_align"] : NULL;
							echo cloudfw_render_horizontal_tabs($tabs, $tabs_align);
						}

						cloudfw_render_page( $datas["data"], $args );

						if ( isset( $tabs ) && $tabs )
							echo '</div>';

			echo '</div>';

			if ( isset( $datas['form'] ) && $datas['form'] )
				cloudfw_render_form_footer($datas["form"], $args);

		break;

/*  TABS    */
		case 'tabs':
			if (! is_array($datas))
				continue;

			if ( isset( $datas['form'] ) && $datas['form'] )
				cloudfw_render_form_header($datas["form"], $args);

			echo '<div id="'.$datas['tab_id'].'">';
				 cloudfw_render_page( $datas["data"], $args );
			echo '</div>';

			if ( isset( $datas['form'] ) && $datas['form'] )
				cloudfw_render_form_footer($datas["form"], $args);

		break;
/*  CONTAINERS  */
		case 'container':
			if ( !isset($datas) || !is_array($datas) )
				continue;

			if ( isset($datas["form"]) && $datas["form"] )
				cloudfw_render_form_header($datas["form"], $args);

			if ( empty($datas["class"]) )
				 $datas['class'] = array('framework_container');

			?>

			<!--CONTAINER-->
			<div<?php

				if (isset($datas["id"]) && $datas["id"])
					echo ' id="'. $datas["id"] .'"';
				echo cloudfw_make_class($datas['class']);

				$style = '';
				if ( isset($datas["auto_width"]) && $datas["auto_width"] )
					$style .= "width: auto !important;";

				if ( isset($datas["width"]) && $datas["width"] )
					$style .= "width: {$datas["width"]}px;";

				if ( isset($datas["min_width"]) && $datas["min_width"] )
					$style .= "min-width: {$datas["min_width"]}px;";

				if ( isset($datas["max_width"]) && $datas["max_width"] )
					$style .= "max-width: {$datas["max_width"]}px;";


				if ( isset($style) && $style )
					echo ' style="'. $style .'"';


			?>>

				<div class="content">

				<?php
					echo isset($datas['before_head']) ? $datas['before_head'] : NULL;
					if( ! (isset($datas['header']) && !$datas['header']) ):
					 ?>
					<div class="head">

					   <?php
					   if ( isset($datas['prepend_head']) && $datas['prepend_head'] )
							echo $datas['prepend_head'];

					   if( !(isset($datas['number']) && !$datas['number']) ): ?>
						<div class="area">
							<?php echo (isset($datas['number']) && $datas['number']) ? $datas['number']: $i; ?>
						</div>
					   <?php endif; ?>

						<h1>
							<?php echo isset($datas['before_title']) ? $datas['before_title'] : NULL; ?>
							<?php echo isset($datas['title']) && $datas['title'] ? $datas['title'] : 'Untitled Container'; ?>
							<?php echo isset($datas['after_title']) ? $datas['after_title'] : NULL; ?>
						</h1>

						<?php echo cloudfw_options_route_button('container'); ?>

					<?php echo isset($datas['append_head']) ? $datas['append_head'] : NULL; ?>
					<div class="clear"></div>
					</div>
				<?php
					endif;

					if( isset($datas['after_head']) && $datas['after_head'] )
						echo $datas['after_head'];
				?>


					<?php


						if(isset($datas['layout']) && $datas['layout'] == 'subtab') {
							$tabs = cloudfw_prepare_tabs( $datas["data"], 'tabs' );
							if (isset($tabs) && $tabs) {
								echo '<div class="cloudfw-ui-tabs cloudfw-ui-mini-tabs">';
								echo cloudfw_render_tabs($tabs);
							}
						} else
							$tabs = false;

						 cloudfw_render_page( $datas["data"], $args ); ?>

				   <?php
						if ( isset( $tabs ) && $tabs )
							echo '</div>';
				   ?>

					<?php
					echo isset($datas['before_footer']) ? $datas['before_footer'] : NULL;
					if( ! (isset($datas['footer']) && !$datas['footer']) ):
					echo isset($datas['prepend_footer']) ? $datas['prepend_footer'] : NULL;
					 ?>

				   <?php
				   if ( !isset($datas['submit_button']) || $datas['submit_button'] )
				   cloudfw_admin_submit( array(
						'message'       => isset($datas['submit_title']) ? $datas['submit_title'] : __('Save Changes','cloudfw'),
						'send_message'  => isset($datas['send_text']) ? $datas['send_text'] : __('Saving...','cloudfw'),
						'ok_message'    => isset($datas['ok_text']) ? $datas['ok_text'] : __('Saved','cloudfw'),
						'case'          => "inline",
				   ) ); ?>

				   <?php
						if ( isset($datas["footer"]) )
							cloudfw_render_page( $datas["footer"], $args );
					?>

					<?php
					echo isset($datas['append_footer']) ? $datas['append_footer'] : NULL;
					endif;
					echo isset($datas['after_footer']) ? $datas['after_footer'] : NULL;
					?>


				</div>

			</div>
			<!--/CONTAINER-->

			<?php
			if ( isset($datas["form"]) && $datas["form"] )
				cloudfw_render_form_footer($datas["form"], $args);

		break;

/*  Module-Set  */
		case 'module-set':
			if (! is_array($datas))
				continue;

			if ( isset( $datas['form'] ) && $datas['form'] ) cloudfw_render_form_header($datas["form"], $args);

			$datas['classes'][] = 'module-set';

			if ( isset( $datas['closable'] ) && $datas['closable'] )
				$datas['classes'][] = 'module-set-closable';

			if ( isset($datas["state"]) && $datas["state"] == 'closed' )
				$datas['classes'][] = 'module-set-state-closed';
			else
				$datas['classes'][] = 'module-set-state-opened';

			if ( isset( $datas['style'] ) && $datas['style'] )
				$datas['classes'][] = $datas["style"];

			if ( isset( $datas['close_others'] ) && $datas['close_others'] )
				$datas['classes'][] = 'module-set-group';

			if ( isset( $datas['margin_top'] ) && $datas['margin_top'] )
				$datas['classes'][] = 'margin-top-20';

			if ( isset( $datas['margin_bottom'] ) && $datas['margin_bottom'] )
				$datas['classes'][] = 'margin-bottom-20';

			if ( isset( $datas['class'] ) && $datas['class'] )
				$datas['classes'][] = $datas["class"];

			if ( isset( $datas['related'] ) && $datas['related'] )
				$datas['classes'][] = $datas["related"];

			?>

			<!--MODULE_SET-->
			<div id="<?php echo isset($datas['id']) ? $datas['id'] : NULL; ?>" <?php echo cloudfw_make_class($datas['classes']); ?>>

				<div class="module-set-header">
						<?php if ( isset( $datas['closable'] ) && $datas['closable'] ): ?>
							<div class="module-set-arrow">
								<div></div>
							</div>
						<?php endif; ?>
					<h3><?php
						echo isset($datas['before_title']) ? $datas['before_title'] : NULL;

						if ( isset($datas['before_title']) && $datas['before_title'] ) {
							echo $datas['before_title'];
						}

							if ( isset($datas['title']) && $datas['title'] ) {
								echo $datas['title'];
							} else {
								echo __('Untitled Module','cloudfw');
							}

						if ( isset($datas['after_title']) && $datas['after_title'] ) {
							echo $datas['after_title'];
						}

					?></h3>
					<div class="module-set-header-right">
						<?php echo isset($datas['title_right']) ? $datas['title_right'] : NULL; ?>
						<div></div>
					</div>

				</div>

				<div class="module-content">

					<?php


						if(isset($datas['layout']) && $datas['layout'] == 'subtab') {
							$tabs = cloudfw_prepare_tabs( $datas["data"], 'tabs' );
							if ( isset( $tabs ) && $tabs ) {
								echo '<div class="cloudfw-ui-tabs cloudfw-ui-mini-tabs">';
								echo cloudfw_render_tabs($tabs);
							}
						} else
							$tabs = false;

						 cloudfw_render_page( $datas["data"], $args ); ?>

				   <?php
						if ( isset( $tabs ) && $tabs )
							echo '</div>';
				   ?>


				</div>

			</div>
			<!--/MODULE_SET-->

			<?php

			if ( isset( $datas['form'] ) && $datas['form'] )
				cloudfw_render_form_footer($datas["form"], $args);

		break;
/*  MODULES */
		case 'module':
			if (! is_array( $datas )) {
				continue;
			}

			if ( !isset($datas['layout']) ) {
				$datas['layout'] = 'default';
			}

			if ( (!isset($datas['class']) || !$datas['class']) && (!isset($datas['layout']) || $datas['layout'] == 'default') ) {
				$datas['class'] = array( 'module' );
			}
			elseif ( (!isset($datas['class']) || !$datas['class']) && (isset($datas['layout']) && $datas['layout'] == 'split') ) {
				$datas['class'] = array( 'module split' );
			}
			elseif ( (!isset($datas['class']) || !$datas['class']) && (isset($datas['layout']) && $datas['layout'] == 'float') ) {
				$datas['class'] = array( 'module liquid-float' );
			}
			elseif ( (!isset($datas['class']) || !$datas['class']) && (isset($datas['layout']) && $datas['layout'] == 'vertical') ) {
				$datas['class'] = array( 'module vertical' );
			}

			if ( isset($datas['padding-t']) && !$datas['padding-t'] ) {
				$datas['class'][] = 'padding-t';
			}

			if ( isset($datas['padding-b']) && !$datas['padding-b'] ) {
				$datas['class'][] = 'padding-b';
			}

			if ( isset($datas['related']) ) {
				$datas['class'][] = 'indicator '. $datas['related'];
			}

			if ( isset($datas['hidden']) && $datas['hidden'] ) {
				$datas['class'][] = 'hidden';
			}

			if ( isset($datas['_class']) && $datas['_class'] ) {
				$datas['class'][] = $datas['_class'];
			}

			if ( isset($datas['style']) && $datas['style'] == 'fullwidth' ) {
				$datas['class'][] = 'module-fullwidth';
			}

			if ( isset($datas['desc'])) {
				$datas['description'] = $datas['desc'];
			}

			if ( isset($datas['description'])) {
				$datas['description'] = '<div class="description">'.$datas['description'].'</div>';
			}

			$count = count($datas['data']);
			?>

			<?php if( ! (isset($datas['divider']) && !$datas['divider']) ): ?>
				<div class="divider<?php if (isset( $datas['hidden']) &&  $datas['hidden'] ) echo ' hidden'; ?>"></div>
			<?php endif; ?>


			<?php
			if (isset($datas['before']))
				echo $datas['before'];
			?>

				<!--MODULE-->
				<div<?php
					if ( isset($datas['id']) )
						echo ' id="'.$datas['id'].'"';
					if ( isset($datas['class']) && $datas['class'] )
						echo cloudfw_make_class($datas['class']);
				?>>

			<?php

				if (isset($datas['ucode']) && $datas['ucode'])
					$datas['ucode'] = '<div class="ucode">'.$datas['ucode'].'</div>';
				else
					$datas['ucode'] = '';


				if (isset($datas['layout']) && ($datas['layout'] == 'default' || $datas['layout'] == 'float')):

					if (isset($datas['title']) && $datas['title']) {

						$for = isset($datas['data'][0]['id']) ? $datas['data'][0]['id'] : NULL;
						$datas['title'] = '<label class="title" for="'. $for .'">' . $datas['title'];

						if ( !( isset($datas['colon']) && !$datas['colon'] ) )
							$datas['title'] .= ':';

						if ( isset($datas['optional']) && $datas['optional'] )
							$datas['title'] .= ' <span class="optional">'.__('(optional)','cloudfw').'</span>';

						$datas['title'] .= ' ' . cloudfw_options_route_button( $type );

						$datas['title'] .= '</label>';

						if ( isset($datas['code']) && $datas['code'] )
							$datas['title'] .= ' <code class="code">'. $datas['code'] .'</code>';

						$has_title = true;
					} else {
						$datas['title'] = '&nbsp;';
						$datas['title'] .= cloudfw_options_route_button( $type );
						$has_title = false;
					}


				?>
						<div class="grid oneof4<?php if ( $has_title == false ) echo ' no-title'; ?>"><?php echo isset($datas['title']) ? $datas['title'] : NULL; ?><?php echo $datas['ucode']; ?></div>
						<div class="grid threeof4 last">

						<?php

							if ( isset( $datas['layouts'] ) && is_array( $datas['layouts'] ) ) {
								$layouts = $datas['layouts'];
							} else {
								$layouts = '';
							}

							if ($count == 1 ):
								echo cloudfw_render_page( $datas['data'], $args );

							elseif ($count == 2 ):
								if ( !isset( $layouts  ) || !$layouts  ) {
									$layouts = array( 'oneof2', 'oneof2' );
								}

								echo '<div class="grid '. $layouts[0] .'" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 0, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[1] .' last" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 1, 1, true) , $args );
								echo '</div> <div class="clear"></div>';

							elseif ($count == 3 ):
								if ( !isset( $layouts  ) || !$layouts  ) {
									$layouts = array( 'oneof3', 'oneof3', 'oneof3' );
								}

								echo '<div class="grid '. $layouts[0] .'" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 0, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[1] .'" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 1, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[2] .' last" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 2, 1, true) , $args );
								echo '</div> <div class="clear"></div>';

							elseif ($count == 4 ):
								if ( !isset( $layouts  ) || !$layouts  ) {
									$layouts = array( 'oneof4', 'oneof4', 'oneof4', 'oneof4' );
								}

								echo '<div class="grid '. $layouts[0] .'" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 0, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[1] .'" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 1, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[2] .'" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 2, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[3] .' last" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 3, 1, true) , $args );
								echo '</div> <div class="clear"></div>';

							elseif ($count == 5 ):

								if ( !isset($datas['auto_column'] ) || $datas['auto_column'] == true ):

									if ( !isset( $layouts  ) || !$layouts  ) {
										$layouts = array( 'oneof4', 'oneof4', 'oneof4', 'oneof4', 'oneof4' );
									}

									echo '<div class="grid '. $layouts[0] .'" style="margin-bottom:20px;">';
										echo cloudfw_render_page( array_slice($datas['data'], 0, 1, true) , $args );
									echo '</div> <div class="grid '. $layouts[1] .'" style="margin-bottom:20px;">';
										echo cloudfw_render_page( array_slice($datas['data'], 1, 1, true) , $args );
									echo '</div> <div class="grid '. $layouts[2] .'" style="margin-bottom:20px;">';
										echo cloudfw_render_page( array_slice($datas['data'], 2, 1, true) , $args );
									echo '</div> <div class="grid '. $layouts[3] .' last" style="margin-bottom:20px;">';
										echo cloudfw_render_page( array_slice($datas['data'], 3, 1, true) , $args );
									echo '</div> <div class="clear"></div>';

									echo '<div class="grid '. $layouts[4] .'" style="margin-bottom:0;">';
										echo cloudfw_render_page( array_slice($datas['data'], 4, 1, true) , $args );
									echo '</div> <div class="clear"></div>';
								else:

									if ( !isset( $layouts  ) || !$layouts  )
										$layouts = array( 'oneof5', 'oneof5', 'oneof5', 'oneof5', 'oneof5' );

									echo '<div class="grid '. $layouts[0] .'" style="margin-bottom:0;">';
										echo cloudfw_render_page( array_slice($datas['data'], 0, 1, true) , $args );
									echo '</div> <div class="grid '. $layouts[1] .'" style="margin-bottom:0;">';
										echo cloudfw_render_page( array_slice($datas['data'], 1, 1, true) , $args );
									echo '</div> <div class="grid '. $layouts[2] .'" style="margin-bottom:0;">';
										echo cloudfw_render_page( array_slice($datas['data'], 2, 1, true) , $args );
									echo '</div> <div class="grid '. $layouts[3] .'" style="margin-bottom:0;">';
										echo cloudfw_render_page( array_slice($datas['data'], 3, 1, true) , $args );
									echo '</div> <div class="grid '. $layouts[4] .' last" style="margin-bottom:0;">';
										echo cloudfw_render_page( array_slice($datas['data'], 4, 1, true) , $args );
									echo '</div> <div class="clear"></div>';

								endif;

							elseif ($count == 6 ):
								if ( !isset( $layouts  ) || !$layouts  )
									$layouts = array( 'oneof3', 'oneof3', 'oneof3', 'oneof3', 'oneof3', 'oneof3' );

								echo '<div class="grid '. $layouts[0] .'" style="margin-bottom:20px;">';
									echo cloudfw_render_page( array_slice($datas['data'], 0, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[1] .'" style="margin-bottom:20px;">';
									echo cloudfw_render_page( array_slice($datas['data'], 1, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[2] .' last" style="margin-bottom:20px;">';
									echo cloudfw_render_page( array_slice($datas['data'], 2, 1, true) , $args );
								echo '</div> <div class="clear"></div>';


								echo '<div class="grid '. $layouts[3] .'" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 3, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[4] .'" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 4, 1, true) , $args );
								echo '</div> <div class="grid '. $layouts[5] .' last" style="margin-bottom:0;">';
									echo cloudfw_render_page( array_slice($datas['data'], 5, 1, true) , $args );
								echo '</div> <div class="clear"></div>';

							endif; // count

							if (isset($datas['append']) && $datas['append']) {
								cloudfw_render_page( $datas['append'], $args );
							}

							echo isset($datas['description']) ? $datas['description'] : NULL;
						?>
						</div>
						<div class="clear"></div>

				<?php elseif ($datas['layout'] == 'split'):

						$datas['echo_title'][0] = '
								<label class="title" for="'. $datas['data'][0]['id'] .'">'.
								_if($datas['title'][0], $datas['title'][0], __('Untitled Module','cloudfw')).
								_if( !( isset($datas['colon']) && !$datas['colon'] ), ':').'
								</label>
						';
						$datas['echo_title'][1] = '
								<label class="title" for="'. $datas['data'][1]['id'] .'">'.
								_if($datas['title'][1], $datas['title'][1], __('Untitled Module','cloudfw')).
								_if( !( isset($datas['colon']) && !$datas['colon'] ), ':').'
								</label>
						';

				?>
						<div class="grid oneof4"><?php echo $datas['echo_title'][0]; ?><?php echo $datas['ucode']; ?></div>
						<div class="grid oneof4 odd"><?php echo cloudfw_render_page( array_slice($datas['data'], 0, 1, true) , $args ); ?></div>
						<div class="grid oneof4"><?php echo $datas['echo_title'][1]; ?></div>
						<div class="grid oneof4 odd last"><?php echo cloudfw_render_page( array_slice($datas['data'], 1, 1, true) , $args ); ?></div>
						<div class="clear"></div>
						<?php echo isset($datas['description']) ? $datas['description'] : NULL; ?>

				<?php elseif ($datas['layout'] == 'vertical'):


					if ( isset( $datas['title'] ) && $datas['title'] ) {

						$for = isset($datas['data'][0]['id']) ? $datas['data'][0]['id'] : NULL;
						$datas['title'] = '<label class="title" for="'. $for .'">' . $datas['title'];

							if ( !( isset($datas['colon']) && !$datas['colon'] ) ) {
								$datas['title'] .= ':';
							}

							if ( isset($datas['optional']) && $datas['optional'] ) {
								$datas['title'] .= ' <span class="optional">'.__('(optional)','cloudfw').'</span>';
							}


						$datas['title'] .= '</label>';
						$has_title = true;

					} else {
						$datas['title'] = '&nbsp;';
						$has_title = false;
					}

					$datas['title'] .= ' ' . cloudfw_options_route_button( $type );

				?>
						<div class="grid oneof4<?php if ( $has_title == false ) echo ' no-title'; ?>"><?php echo isset($datas['title']) ? $datas['title'] : NULL; ?></div>
						<div class="grid threeof4 last">

						<?php
						foreach ($datas['data'] as $item_number => $item) { ?>

							<div class="module-vertical-item">
								<?php cloudfw_render_page( array( 'data' => $item), $args ); ?>
							</div>
							<div class="clear"></div>

						<?php } ?>

						<?php echo isset($datas['description']) ? $datas['description'] : NULL; ?>
						</div>
						<div class="clear"></div>

				<?php elseif ($datas['layout'] == 'single'): ?>

						<div class="module"><div class="grid fullpage"><?php cloudfw_render_page( $datas['data'], $args ) ?></div> <div class="clear"></div></div>

				<?php elseif ($datas['layout'] == 'raw'): ?>

						<div class="module">
						<?php
							if (isset($datas['prepend'])) {
								echo $datas['prepend'];
							}

							cloudfw_render_page( $datas['data'], $args );

							if (isset($datas['append'])) {
								echo $datas['append'];
							}

							echo cloudfw_options_route_button( $type );

						?>
						 <div class="clear"></div></div>

				<?php endif; ?>

					</div><div class="clear"></div>
					<!--/MODULE-->
				<?php
					if (isset($datas['after'])) {
						echo $datas['after'];
					}

				?>

			<?php

		break;
/*  Gallery */
		case 'mini-section':

			if (isset($datas['before']))
				echo $datas['before'];

			$classes = array('mini-section-wrapper');

			if ( isset( $datas['related'] ) && $datas['related'] )
				$classes[] = $datas['related'];
			?>

				<div <?php echo cloudfw_make_class( $classes ); ?>>
					<div class="mini-section">
						<div class="mini-section-title <?php echo isset($datas['align']) && $datas['align'] == 'center' ? 'mini-section-title-centered' : NULL; ?>">
							<div><?php echo isset($datas['title']) ? $datas['title'] : NULL; ?></div>
						</div>
					</div>
					<div class="mini-section-content"><?php
						if( isset($datas['data']) && $datas['data'] ) {
							cloudfw_render_page( $datas['data'], $args );
						}
					?></div>
				</div>

			<?php
			if (isset($datas['after']))
				echo $datas['after'];

		break;
/*  Gallery */
		case 'gallery':
			if (! is_array( $datas ))
				continue;

			if ( isset($datas['class']) && !is_array($datas['class']) ) {
				$datas['class'] = array( $datas['class'] );
			}

			if ( !isset($datas['class']) ) {
				$datas['class'] = array();
			}

			$datas['class'][] = 'gallery-item';


			if (isset($datas['desc']))
				$datas['description'] = $datas['desc'];

			if (isset($datas['description']))
				$datas['description'] = '<div class="description">'.$datas['description'].'</div>';

			$count = count( $datas['data'] );

			if ( isset( $datas['before'] ) )
				echo $datas['before'];

			?>

				<!--GALLERY-->

				<!-- Preview -->
				<div <?php echo cloudfw_make_class(array('gallery-preview')); ?> data-sync="<?php echo isset($datas['sync']) ? $datas['sync'] : NULL; ?>">
					<div class="image">
						<?php
							$src = isset($datas['value']) ? $datas['value'] : NULL;
							if ( !empty( $src ) ) {
								echo '<img src="'. cloudfw_thumbnail( array( 'src' => $src, 'width' => 200, 'height' => 120 ) ) .'" alt="">';
							}

						?>

					</div>
					<div class="gallery-actions">
						<div class="centered">
							<a href="javascript:;" class="gallery-edit cloudfw-action-edit cloudfw-tooltip" title="<?php _e('edit','cloudfw'); ?>"></a>
							<a href="javascript:;" class="gallery-duplicate cloudfw-action-clone cloudfw-tooltip" title="<?php _e('clone','cloudfw'); ?>"></a>
							<a href="javascript:;" class="gallery-remove cloudfw-action-remove cloudfw-tooltip" data-target="li" title="<?php _e('remove','cloudfw'); ?>"></a>
						</div>
					</div>
				</div>
				<!-- /Preview -->

				<div<?php if ( isset($datas['id']) ) echo ' id="'.$datas['id'].'"'; echo cloudfw_make_class($datas['class']); ?>>

					<?php
						$out = '';
						ob_start();
						foreach ($datas['data'] as $item_number => $item) { ?>

							<?php cloudfw_render_page( array( 'data' => $item), $args ); ?>

						<?php }

						echo '
							<div class="module clean relative" style="background: transparent; border: 0; padding-bottom: 0;padding-right: 0;margin-right: -20px;">
								<div class="grid oneof4">&nbsp;</div>
								<div class="grid threeof4 last">
									<div class="clear"></div>
									<a href="javascript:void(0);" id="" class="small-button small-grey" style="float: right;"><span>'.__('Save','cloudfw').'</span></a>
								</div>
								<div class="clear"></div>
							</div>
						';

						$out .= ob_get_contents();
						ob_get_clean();

					?>

						<?php echo isset($out) ? $out : NULL; ?>

						<div class="clear"></div>
				</div>
				<!--/GALLERY-->
				<?php


					if (isset($datas['after']))
						echo $datas['after'];
				?>

			<?php

		break;
/*  SECTION */
		case 'section':
			if (! is_array( $datas ))
				continue;

			if (isset( $datas['check_empty'] ) && $datas['check_empty'] === true ) {
				if ( empty( $datas['data'] ) ) {
					continue;
				}
			}


			if ( !isset( $datas['class'] ) || !$datas['class'] )
				$datas['class'] = array('section-toggle');

			if (!is_array($datas['class']))
				$datas['class'] = array($datas['class']);

			if (empty($datas['status']) || ($datas['status'] == 'closed'))
				$datas['class'][] = 'hiddenSection';
			elseif (($datas['status'] == 'opened'))
				$datas['class'][] = 'visibleSection';

	?>

<!--SECTION-->
<div id="<?php echo isset($datas['id']) ? $datas['id'] : NULL; ?>"<?php echo cloudfw_make_class($datas['class']); ?>>

<div class="section-container">
<a href="javascript:void(0);" class="section-title colorTitle section-run"><?php
		echo isset($datas['before_title']) ? $datas['before_title'] : NULL;
		echo _if($datas['title'], $datas['title'], __('Untitled Module','cloudfw'));

		if ( ! (isset($datas['indicator']) && !($datas['indicator']) ) ):?>
			<span class="wrapIconSection"><span></span></span>
		<?php endif; ?>
</a>
<?php echo isset($datas['after_title']) ? $datas['after_title'] : NULL; ?>
</div>

	<div class="section-content">

		<?php cloudfw_render_page( $datas['data'], $args ) ?>

	</div>
	<!-- /.section-content -->

</div>
<!--/SECTION-->

	<?php

		break;
/*  SECTION */
		case 'section-title':
			if (! is_array( $datas ))
				continue;

			if (isset( $datas['check_empty'] ) && $datas['check_empty'] === true ) {
				if ( empty( $datas['data'] ) ) {
					continue;
				}
			}


			if ( !isset( $datas['class'] ) || !$datas['class'] )
				$datas['class'] = array('section-toggle');

			if (!is_array($datas['class']))
				$datas['class'] = array($datas['class']);

			if (empty($datas['status']) || ($datas['status'] == 'closed'))
				$datas['class'][] = 'hiddenSection';
			elseif (($datas['status'] == 'opened'))
				$datas['class'][] = 'visibleSection';

	?>

<!--SECTION-TITLE-->
<div id="<?php echo isset($datas['id']) ? $datas['id'] : NULL; ?>"<?php echo cloudfw_make_class($datas['class']); ?>>

	<div class="cloudfw-ui-sections-title">
		<div class="inset">
			<a href="javascript:void(0);" class="section-run"><?php
				echo isset($datas['before_title']) ? $datas['before_title'] : NULL;
				echo _if($datas['title'], $datas['title'], __('Untitled Module','cloudfw'));

				if ( (isset($datas['indicator']) && ($datas['indicator']) ) ):?>
					<span class="wrapIconSection"><span></span></span>
				<?php endif; ?>
				<?php echo isset($datas['after_title']) ? $datas['after_title'] : NULL; ?>
			</a>
		</div>
	</div>

<div class="section-content">

	<?php cloudfw_render_page( $datas['data'], $args ) ?>

</div>
<!-- /.section-content -->

</div>
<!--/SECTION-TITLE-->

	<?php

		break;
/*  MICRO GRIDS */
		case 'grid':

			$count = count($datas['data']);

				if (!isset($datas['layout']) || $datas['layout'] == 'spaced'):
					$datas['grid_class'][0] = 'microGridLeft';
					$datas['grid_class'][1] = 'microGridRight';
				else:
					$datas['grid_class'][0] = 'microGridColors';
					$datas['grid_class'][1] = 'microGridColors';
					$datas['grid_class'][2] = 'microGridColors_Right';
				endif;

			if ($count == 1 ):

				echo cloudfw_render_page( $datas['data'], $args );

			elseif ($count == 2 ):

				echo ' <div class="'.$datas['grid_class'][0].'">';
					echo cloudfw_render_page( array_slice($datas['data'], 0, 1, true) , $args );
				echo '<div class="clear"></div> </div> <div class="'.$datas['grid_class'][1].'">';
					echo cloudfw_render_page( array_slice($datas['data'], 1, 1, true) , $args );
				echo '</div> <div class="clear"></div>';

			elseif ($count == 3 ):

				echo ' <div class="'.$datas['grid_class'][0].'">';
					echo cloudfw_render_page( array_slice($datas['data'], 0, 1, true) , $args );
				echo '<div class="clear"></div> </div> <div class="'.$datas['grid_class'][1].'">';
					echo cloudfw_render_page( array_slice($datas['data'], 1, 1, true) , $args );
				echo '<div class="clear"></div> </div> <div class="'.$datas['grid_class'][2].'">';
					echo cloudfw_render_page( array_slice($datas['data'], 2, 1, true) , $args );
				echo '</div> <div class="clear"></div>';

			else:

				foreach($datas['data'] as $grid_data_id => $grid_data):
					echo ' <div class="'.$datas['grid_class'][0].'">' , cloudfw_render_page( array_slice($datas['data'], $grid_data_id, 1, true) , $args ) , ' <div class="clear"></div> </div>';

				endforeach;

			endif; // count

			echo isset($datas['description']) ? $datas['description'] : NULL;

		break;
/*  BLANK   */
		case 'blank':
			if (!is_array($datas))
				continue;

			cloudfw_render_page( $datas['data'], $args );

		break;
/*  SORTING */
		case 'sorting':
			if (!is_array($datas))
				continue;

			$items = cloudfw_render_filters( $datas['data'], $datas, $args );

			$classes = array();
			$classes[] = 'sortable_ul';

			if ( isset( $datas['class'] ) && $datas['class'] )
				$classes[] = $datas['class'];

			if ( isset( $datas['related'] ) && $datas['related'] )
				$classes[] = $datas['related'];

			/** Set attributes */
			$attributes = array();
			$attributes['id']    = $datas['id'];
			$attributes['class'] = cloudfw_make_class($classes, 0);

			$attributes['data-axis'] = isset($datas['axis']) ? $datas['axis'] : 'y';

			$secture = isset($datas['secture']) ? $datas['secture'] : NULL;

			if ( $secture = 'ul' ) {
				$parent_dom = 'ul';
				$child_dom = 'li';
			} else {
				$parent_dom = 'div';
				$child_dom = 'div';

			}

			echo '
			<!--SORTING-->
			<'. $parent_dom . cloudfw_make_attribute( $attributes, 0 ) .'>';


			$sorting_number = 0;
			foreach ((array) $items as $item_id => $item) {
				$sorting_number++;

				echo '<' . $child_dom;

				if ( !empty($datas['item:id']) || !empty($datas['first-item:id']) ) {
					/** id */
					echo ' id="';
						if ( !empty($datas['first-item:id']) ) {
							if ( $sorting_number === 1 )
								echo $datas['first-item:id'];

						} else {
							echo $datas['item:id'];

						}

					echo '"';
					/** end of id */
				}

				/** class */
				echo ' class="';
				echo ' sorting-item';
				echo ' item-'. $item_id;

				if ( $sorting_number === 1 )
					echo ' first';
				echo '"';
				/** end of class */

				echo '>';
				$item = array( 'data' => $item );
					echo cloudfw_render_page( $item, $args );
				echo '</'. $child_dom .'>';
			}

			echo '</'. $parent_dom .'><!--/SORTING--><div class="clear"></div>';

		break;
/*  GROUP   */
		case 'group':
			if (!is_array($datas))
				continue;

			$items = cloudfw_render_filters( $datas['data'], $datas, $args );

			$classes = array();
			$classes[] = 'cloudfw-ui-group';

			if ( !empty($datas['menu-condition']) )
			$datas['menu-condition'] = trim($datas['menu-condition']);

			if ( !empty($datas['menu-condition']) && $datas['menu-condition'] ) {
				list( $delimiter, $level ) = explode(' ', $datas['menu-condition']);
				if ( !isset($level) ) {
					$level = $delimiter;
					$delimiter = false;
				}

				$condition_class = 'cloudfw-ui-menu-filter';

				foreach ((array) explode( ',', $level) as $level_current) {

					switch ($delimiter) {
						case '>':
							$condition_class .= ' above';
							break;
						case '<':
							$condition_class .= ' below';
							break;
						case '=':
						default:
							$condition_class .= ' equal';
							break;
					}

					if ( isset($level_current) ) {
						$condition_class .= '-' . $level_current;
					}

				}

				if ( $condition_class )
					$classes[] = $condition_class;

				unset($datas['menu-condition']);
			}


			if ( isset($datas['class']) && $datas['class'] )
				$classes[] = $datas['class'];

			/** Set attributes */
			$attributes = array();
			$attributes['id']    = isset($datas['id']) ? $datas['id'] : NULL;

			if ( isset($datas['related']) )
				$classes[] = 'indicator '. $datas['related'];


			$attributes['class'] = cloudfw_make_class($classes, 0);
			$secture = isset($datas['secture']) ? $datas['secture'] : NULL;

			if ( isset($secture) && $secture = 'ul' ) {
				$parent_dom = 'ul';
				$child_dom = 'li';
			} else {
				$parent_dom = 'div';
				$child_dom = 'div';

			}

			echo '
			<!--GROUP-->
			<'. $parent_dom . cloudfw_make_attribute( $attributes, 0 ) .'>';

				echo cloudfw_render_page( $items, $args );

			echo '</'. $parent_dom .'><!--/GROUP-->';

		break;
/*  INCLUDE */
		case 'include':
		case 'require':

			if ( isset( $args ) && $args )
				extract($args);

			if (file_exists($datas['path'])):
				echo isset($datas['before']) ? $datas['before'] : NULL;
				if($datas['type'] == 'include') include_once($datas['path']); else require_once($datas['path']);
				echo isset($datas['after']) ? $datas['after'] : NULL;
			else:
				printf(__('%s file cannot found','cloudfw'), $datas['path']);
			endif;

		break;
/*  CSS */
		case 'css':

			if ( isset( $args ) && $args )
				extract($args);

			if ( isset($datas['path']) ) {
				if (file_exists($datas['path'])):
					$content = cloudfw_get_file_contents( $datas['path'] );
				else:
					printf(__('%s css file cannot found','cloudfw'), $datas['path']);
				endif;
			} else {
				$content = $datas['data'];
			}

			if ( !empty($content) ) {
				if ( !empty($datas['replace']) && is_array($datas['replace']) ) {
					foreach ($datas['replace'] as $key => $value)
						$content = str_replace( $key, $value, $content );
				}

				echo '<style type="text/css">';
					echo isset($content) ? $content : NULL;
				echo '</style>';

			} elseif ( !empty($datas['load']) ) {
				echo '<link rel="stylesheet" href="'.$datas['load'].'" type="text/css" media="all" />';
			}

		break;
/*  INCLUDE */
		case 'filter':
			cloudfw_render_filters( $datas, $args );
		break;
/*  RUN */
		case 'run':


			$exists = false;
			/** Call a Function */
			if ( isset( $datas['function'] ) && $datas['function'] ) {
				if ( is_array($datas['function']) ) {
					$exists = method_exists( $datas['function'][0], $datas['function'][1] );
				} else {
					$exists = function_exists( $datas['function'] );
				}

				if ( isset( $exists ) && $exists )
					is_array($datas['function']) ? call_user_func_array( $datas['function'], array(  $data, $args ) ) : $datas['function']( $data, $args );
				else
					return cloudfw_error_message(sprintf(__('(%s) function cannot found','cloudfw'), $datas['function']));

			}


		break;
/*  SHORTCODE   */
		case 'shortcode':
		case 'shortcode:sub':
			if (! is_array($datas))
				continue;

			echo '<div id="cloudfw_shortcode_div_'. $datas['id'] .'" class="', ( isset($datas['ajax']) && $datas['ajax'] === true ? 'needAjax ' : NULL ) ,'shortcode-block hidden"', ( isset($datas['ajax']) && $datas['ajax'] === true ? ' data-parent-id="'.$data[0]['parent'].'" data-section-id="'.$data_number.'"' : NULL ) ,'>';
				if ( !isset($datas['ajax']) || !$datas['ajax'] ) {
					cloudfw_render_page( $datas["data"], $args );
				}
			echo '</div>';

		break;
/*  SHORTCODE:GROUP */
		case 'shortcode:group':
			if (! is_array($datas))
				continue;
			$datas["data"][0]['parent'] = $data_number;
			cloudfw_render_page( $datas["data"], $args );

		break;
/*  COMPOSER    */
		case 'composer':
		case 'composer:sub':
		case 'composer:item':
			if (! is_array($datas))
				continue;

			global $cloudfw_composer_data;
			$composer_options = $datas['composer']['options'];
			$classes = array();
			$ajax = false;

			if ( $type == 'composer' || $type == 'composer:sub' ){
				$id = 'composer-'.$datas['composer_id'];
				$classes[] = 'hidden';

				/** Need Ajax */
				if ( isset($datas['composer']['ajax']) && $datas['composer']['ajax'] === true ){
					$classes[] = 'ajax';
					$ajax = true;
				}

			} else {
				$id = '';
			}

			/** Add hidden class */
			if ( !isset($datas['composer']['droppable']) || !$datas['composer']['droppable'] )
				$classes[] = 'composer-element-hidden';

			/** Add 2nd level class */
			if ( isset($datas['composer']['droppable']) && $datas['composer']['droppable'] === true )
				$classes[] = 'composer-2ndlevel';

			/** Add Custom Class */
			if ( !empty($datas['composer']['class']) )
				$classes[] = $datas['composer']['class'];


			if ( isset($cloudfw_composer_data['_composer-column']) && $cloudfw_composer_data['_composer-column'] )
				$composer_options['column'] = $cloudfw_composer_data['_composer-column'];

			$composer_options['original_title'] = $composer_options['title'];

			if ( $cloudfw_composer_data['_composer-title'] )
				$composer_options['title'] = $cloudfw_composer_data['_composer-title'];

			$json_options = htmlspecialchars( json_encode( $composer_options ), ENT_NOQUOTES );

			if ( !isset( $args['via_ajax'] ) || !$args['via_ajax'] )
			echo '<div id="'. $id .'" data-type="'.$datas['composer_id'].'" data-title="' . esc_attr($composer_options['title']) . '" class="composer-element '.$datas['composer_id'].' '. cloudfw_make_class($classes, 0) .' dont-make-ui" data-composer-options=\''. esc_attr($json_options) .'\'>';

				if ( (!isset( $ajax  ) || !$ajax) || $args['via_ajax'] ) {
					echo '
						<input type="hidden" id="_composer-type" name="_composer-type" value="'. $datas['composer_id'] .'" />
						<input type="hidden" id="_composer-column" name="_composer-column" value="" />
						<input type="hidden" id="_composer-last" name="_composer-last" value="" />
					';

					if ( !isset( $args["wrap_options"] ) || $args["wrap_options"] !== false ) {
						echo '<div class="composer-item-options">';
							cloudfw_render_page( $datas["data"] );
						echo '</div>';
					} else {
						cloudfw_render_page( $datas["data"] );
					}

					if ( isset( $args["data"] ) ) {
						cloudfw_render_page( $args["data"] );
					}
				}

			if ( !isset( $args['via_ajax'] ) || !$args['via_ajax'] )
			echo '</div>';
		break;

/*  COMPOSER:GROUP  */
		case 'composer:group':
			if (! is_array($datas))
				continue;
			$datas["data"][0]['parent'] = $data_number;
			cloudfw_render_page( $datas["data"], $args );

		break;

/*  COMPOSER:GROUP  */
		case 'render':
			if (! is_array($datas))
				continue;

			$source = cloudfw_render_filters( $datas['source'], $data, $args );
			cloudfw_render_page( array('data' => $source), $args );

		break;

/*  METABOX */
		case 'metabox':
			if (! is_array($datas))
				continue;
			cloudfw_render_page( $datas["data"], $args );
		break;

/*  GROWL   */
		case 'growl':
			echo cloudfw_dialog( $datas['title'], $datas['message'], $datas['case'], $datas['timeout'] );
		break;
/*  MESSAGE */
		case 'message':
			$classes   = array();
			$classes[] = 'cloudfw-ui-message';

			if ( isset($datas["fill"]) && $datas["fill"] )
				$classes[] = 'fill';
			else
				$classes[] = 'inline';

			if ( isset($datas["color"]) && $datas["color"] )
				$classes[] = $datas["color"];

			if ( isset($datas["space"]) && $datas["space"] )
				$classes[] = 'space-bottom';

			echo '<div id="', isset($datas['id']) ? $datas['id'] : NULL ,'" class="'. cloudfw_make_class($classes, 0) .'">';
				if ( isset($datas["title"]) && $datas["title"] )
					echo '<div class="cloudfw-ui-message-title">'. $datas["title"] .'</div>';
				echo '<div class="cloudfw-ui-message-content">'. $datas["data"] .'</div>';
			echo '</div>';

		break;
/*  JSON    */
		case 'json':

			$data_array = $datas["data"];
			if ( (isset($data_array) && $data_array) && (isset($datas["variable"]) && $datas["variable"]) ) {

				echo "\n<div id=\"json-{$datas["variable"]}\" class=\"json\" style=\"display:none !important;\">";
					echo htmlspecialchars( json_encode( $data_array ), ENT_NOQUOTES );
				echo "</div>\n";

			}

		break;
/*  ELEMENTS    */
		default:
			cloudfw_render_element( $datas, $args );
		break;
	} // switch


	/** Run JS Codes */
	if ( isset( $datas['js'] ) ) {
		cloudfw_render_javascript( $datas['js'], $datas, $args );
	}



	endforeach;

}

/**
 *  Render Elements
 *
 *  @since 1.0
 */
function cloudfw_render_element( $data = array(), $args = array(), $force_type = NULL ){

	$type = ! $force_type ? $data['type'] : $force_type;

	if ( isset( $data['__'] ) && !empty($data['__']) ) {
		if ( !is_array($data['__']) )
			$data['__'] = explode(' ', $data['__']);

		$data['id'] = cloudfw_sanitize(PFIX . '_' . implode( ' ', $data['__'] ) );
		$data['value'] = cloudfw_get_option( $data['__'][0], isset($data['__'][1]) ? $data['__'][1] : '' );

	}


	/** Set Default */
	if ( isset($data['default']) ) {
		if ( ! isset($data['value']) )
			$data['value'] = $data['default'];

	}

	if ( isset( $data['desc'] ) )
		$data['description'] = $data['desc'];

	if ( isset($data['clear_before']) && $data['clear_before'] )
		echo '<div class="clear"></div>';

	switch($type){

/*  HTML  */
		case 'html':
			if (isset($data['before']) && $data['before'])
				cloudfw_render_page( $data['before'], $args );

			if (isset($data['before_html']) && $data['before_html'])
				echo $data['before_html'];

			echo cloudfw_render_filters(
				isset($data['source']) ? $data['source'] : NULL,
				isset($data) ? $data : NULL,
				isset($args) ? $args : NULL
			);
			echo isset($data['data']) ? $data['data'] : NULL;

			if (isset($data['after_html']) && $data['after_html'])
				echo $data['after_html'];

			if (isset($data['after']) && $data['after'])
				cloudfw_render_page( $data['after'], $args );

		break;
/*  SUBMIT  */
		case 'submit':

			echo isset($data['before']) ? $data['before'] : NULL;
			cloudfw_admin_submit( array(
				'id'                => isset($data['id']) ? $data['id'] : NULL,
				'message'           => isset($data['text']) ? $data['text'] : __('Save Changes','cloudfw'),
				'send_message'      => isset($data['send_text']) ? $data['send_text'] : __('Saving...','cloudfw'),
				'ok_message'        => isset($data['ok_text']) ? $data['ok_text'] : __('Saved','cloudfw'),
				'case'              => isset($data['layout']) ? $data['layout'] : 'inline',
				'remove_margin_top' => isset($data['nomargin']) ? $data['nomargin'] : NULL,
				'before'            => cloudfw_render_filters( isset($data['before_button']) ? $data['before_button'] : NULL, $data, $args ),
				'after'             => cloudfw_render_filters( isset($data['after_button']) ? $data['after_button'] : NULL, $data, $args ),
				'prepend'           => cloudfw_render_filters( isset($data['prepend']) ? $data['prepend'] : NULL, $data, $args ),
				'append'            => cloudfw_render_filters( isset($data['append']) ? $data['append'] : NULL, $data, $args ),
			) );
			echo isset($data['action_link']) ? $data['action_link'] : NULL;

			echo isset($data['after']) ? $data['after'] : NULL;

		break;
/*  TEXT  */
		case 'text':
		case 'textarea':

		if ( ( !isset($data['class']) || !$data['class']) && $data['type'] == 'text' )
			$data['class'] = array( 'input input_400' );

		if ( ( !isset($data['class']) || !$data['class']) && $data['type'] == 'textarea' )
			$data['class'] = array( 'input' );

		if (!isset( $data['class'] ))
			$data['class'] = array();

		if (!is_array( $data['class'] ))
			$data['class'] = array( $data['class'] );

		if ( isset( $data['_class']) &&  $data['_class'] )
			 $data['class'] = array_merge((array) $data['class'], (array) $data['_class']);

		if ( isset($data['tabkey']) && $data['tabkey'] === true )
			$data['class'][] = 'tab-textfields tabtext';

		if ( isset($data['editor']) && $data['editor'] === true )
			$data['class'][] = 'cloudfw-ui-editor';

		if ( isset($data['autogrow']) && $data['autogrow'] === true )
			$data['class'][] = 'cloudfw-ui-autogrow';

		if (isset($data['before']) && $data['before'])
			cloudfw_render_page( $data['before'], $args );

		if (isset($data['title']) && $data['title'])
			echo '<label class="sub-title" for="'. $data['id'] .'">'.$data['title'].'</label><div class="clear"></div>';

		$value = isset($data['value']) && ($data['value'] || $data['value'] === '0' || $data['value'] === 0) ? $data['value'] : (isset($data['default']) ? $data['default'] : NULL);

		if ( !empty($value) && !is_array($value) )
			$value = esc_textarea( $value );

		admin_create_input(
			array(
				'id'       => isset($data['id']) ? $data['id'] : NULL,
				'value'    => $value,
				'case'     => $data['type'] == 'text' ? 'input' : 'textarea',
				'type'     => 'text',
				'class'    => cloudfw_make_class($data['class'], 0),
				'brackets' => isset($data['brackets']) ? $data['brackets'] : NULL,
				'width'    => isset($data['width']) ? $data['width'] : NULL,
				'line'     => isset($data['line']) ? $data['line'] : NULL,
				'reset'    => isset($data['reset']) ? $data['reset'] : NULL,
				'wrap'     => isset($data['wrap']) ? $data['wrap'] : NULL,
				'editor'   => isset($data['editor']) ? $data['editor'] : NULL,
				'autogrow' => isset($data['autogrow']) ? $data['autogrow'] : NULL,
				'holder'   => isset($data['holder']) ? $data['holder'] : NULL,
			)
		);

		echo isset($data['unit']) ? '<span class="ui-unit">'. $data['unit'] .'</span>' : NULL;

		echo isset($data['action_link']) ? $data['action_link'] : NULL;

		if (isset($data['description']) && $data['description'])
			echo '<div class="description">'.$data['description'].'</div>';

		if (isset($data['after']) && $data['after'])
			cloudfw_render_page( $data['after'], $args );


		break;

/*  ONOFF  */
		case 'onoff':

		if ( !isset($data['class']) || !$data['class'] )
			$data['class'] = array( 'onoff' );

		if ( isset($data['style']) && $data['style'] )
			$data['class'][] = $data['style'];

		if ( !isset($data['value']) )
			$data['value'] = isset($data['default']) ? $data['default'] : NULL;

		if ( isset($data['value']) && is_string($data['value']) && $data['value'] === '' )
			$data['value'] = isset($data['default']) ? $data['default'] : NULL;

		if ( !isset($data['value']) )
			$data['value'] = true;

		if (isset($data['title']) && $data['title'])
			echo '<label class="sub-title" for="'. $data['id'] .'">'.$data['title'].'</label><div class="clear"></div>';

		admin_create_onoff(
			isset($data['id']) ? $data['id'] : NULL,
			isset($data['value']) ? $data['value'] : NULL,
			isset($data['is_check']) && $data['is_check'] ? $data['is_check'] : FALSE,
			isset($data['default_value']) ? $data['default_value']: "true",
			isset($data['class']) ? cloudfw_make_class($data['class'], 0) : NULL,
			isset($data['brackets']) ? $data['brackets'] : NULL
		);
		if (isset($data['description']) && $data['description'])
			echo '<div class="clear"></div> <div class="description">'.$data['description'].'</div>';

		break;
/*  COLOR  */
		case 'color':

		if ( $data['value'] == 'transparent' )
			unset($data['value']);


		if ( !isset( $data['class'] ) || !$data['class'] )
			$data['class'] = array();

		if ( !empty( $data['class'] ) && !is_array($data['class']) )
			$data['class'] = array( $data['class'] );

		if ( isset($data['style']) && $data['style'] )
			$data['class'][] = $data['style'];

		if (isset($data['title']) && $data['title'])
			echo '<label class="sub-title" for="', isset($data['id']) ? $data['id'] : '' ,'">'.$data['title'].'</label><div class="clear"></div>';

		if (!isset($data['layout']) || $data['layout'] == 'normal'):
			admin_create_color_selection_v2(
				array(
					'id'        => isset($data['id']) ? $data['id'] : NULL,
					'value'     => isset($data['value']) ? $data['value'] : NULL,
					'default'   => isset($data['default_value']) ? $data['default_value'] : NULL,
					'class'     => isset($data['class']) ? cloudfw_make_class($data['class'], 0) : NULL,
					'reset'     => isset($data['reset']) ? $data['reset'] : NULL,
					'brackets'  => isset($data['brackets']) ? $data['brackets'] : NULL
				)
			);
		else:
			 admin_create_color_selection(
				$data['id'], // id
				$data['preview'], // preview
				$data['value'], // value
				$data['default_value'], // default value
				cloudfw_make_class($data['class'], 0) // external classes
			);
		endif;

		if (isset($data['description']) && $data['description'])
			echo '<div class="description">'.$data['description'].'</div>';


		break;

/*  GRADIENT  */
		case 'gradient':

		if ( !isset( $data['class'] ) || !$data['class'] )
			$data['class'] = array();

		if ( !empty( $data['class'] ) && !is_array($data['class']) )
			$data['class'] = array( $data['class'] );

		if ( isset($data['style']) && $data['style'] )
			$data['class'][] = $data['style'];

		if (isset($data['title']) && $data['title'])
			echo '<label class="sub-title" for="', isset($data['id']) ? $data['id'] : '' ,'">'.$data['title'].'</label><div class="clear"></div>';

		admin_create_gradient_selection(
			array(
				'id'        => isset($data['id']) ? $data['id'] : NULL,
				'value'     => isset($data['value']) ? $data['value'] : NULL,
				'default'   => isset($data['default_value']) ? $data['default_value'] : NULL,
				'class'     => isset($data['class']) ? cloudfw_make_class($data['class'], 0) : NULL,
				'reset'     => isset($data['reset']) ? $data['reset'] : NULL,
				'brackets'  => isset($data['brackets']) ? $data['brackets'] : NULL
			)
		);

		if (isset($data['description']) && $data['description'])
			echo '<div class="description">'.$data['description'].'</div>';


		break;

/*  UPLOAD  */
		case 'upload':

		if ( !isset( $data['class'] ) || !$data['class'] )
			$data['class'] = array( 'input_500' );

		if ( isset( $data['_class'] ) && $data['_class'] )
			$data['class'][] = $data['_class'];

		if ( isset( $data['description'] ) && $data['description'] )
			$data['description'] = '<div class="description">'.$data['description'].'</div><div class="clear"></div>';

			if (!isset( $data['version'] ))
				$data['version'] = 2;

			$data['version'] = apply_filters('cloudfw_upload_method', $data['version']);

			if ( isset( $data['title'] ) && $data['title'] )
				echo '<label class="sub-title" for="'. $data['id'] .'">'.$data['title'].'</label><div class="clear"></div>';

			if ( $data['version'] == 2 || !isset($data['version']) ) {
				admin_create_upload_button_v2(array(
					'id'                  => isset($data['id']) ? $data['id'] : NULL,
					'value'               => isset($data['value']) ? $data['value'] : NULL,
					'preview'             => !isset($data['preview']) || $data['preview'] ? TRUE : FALSE,
					'thumb_path'          => isset($data['thumbnail']) ? $data['thumbnail'] : NULL,
					'upload_button_value' => isset($data['button_text']) ? $data['button_text'] : __('Upload','cloudfw'),
					'description'         => isset($data['description']) ? $data['description'] : NULL,
					'class'               => isset($data['class']) ? cloudfw_make_class($data['class'], 0) : NULL,
					'wrapClass'           => NULL,
					'brackets'            => isset($data['brackets']) ? $data['brackets'] : NULL,
					'hide_input'          => isset($data['hide_input']) ? $data['hide_input'] : NULL,
					'removable'           => isset($data['removable']) ? $data['removable'] : NULL,
					'from_library'        => isset($data['library']) ? $data['library'] : NULL,
					'store'               => isset($data['store']) ? $data['store'] : NULL,
					'reset'               => isset($data['reset']) ? $data['reset'] : NULL,
				));

			} elseif ( $data['version'] == 1 ) {
				admin_create_upload_button(
					$data['id'], // id of input:text
					$data['value'], // value
					$data['preview'] || !isset($data['preview']) ? TRUE : FALSE, //preview
					$data['thumbnail'], // thumbnail creator url
					$data['button_text'] ? $data['button_text'] : __('Upload An Image','cloudfw'), // upload button test,
					$args['lastID'], // reference Post ID of Uploading Images
					$data['description'], // description
					FALSE, // delete button text
					cloudfw_make_class($data['class'], 0) // external classes for the text input
				);
			}

		break;

/*  SLIDER  */
		case 'slider':

		if ( !isset( $data['name'] ) || !$data['name'] )
			$data['name'] = $data['id'];

		if ( !isset( $data['class'] ) || !$data['class'] )
			$data['class'] = array( 'input_400' );

		if ( isset( $data['description'] ) && $data['description'] )
			$data['description'] = '<div class="description">'.$data['description'].'</div><div class="clear"></div>';

		if ( ! isset($data['value']) || ! $data['value']  )
			$data['value'] = isset($data['default_value']) && $data['default_value'] ? $data['default_value'] : 0;

		if ( ! isset( $data['slide_func'] ) || !$data['slide_func'] )
			$data['slide_func'] = 'jQuery("#amount_'.$data['id'].'").html(ui.value); ';

		if ( ! isset($data['unit']) )
			$data['unit'] = 'px';

		if ( !isset( $data['preview_func'] ) || !$data['preview_func'] )
			$data['preview_func'] = '<span class="cloudfw-ui-slider-container-preview-value"><strong><span id="amount_'.$data['id'].'" class="amount">'.$data['value'].'</span></strong> '. $data['unit'] .'</span><span class="cloudfw-ui-slider-container-preview-step"></span>';

		if ( isset( $data['before'] ) && $data['before'] )
			cloudfw_render_page( $data['before'], $args );


		if ( isset( $data['title'] ) && $data['title'] ) {
			$for = isset($data['id']) ? $data['id'] : NULL;
			echo '<label class="sub-title ', isset($data['mtop']) ? " mtop" : NULL ,'" for="'. $for .'">'.$data['title'].'</label><div class="clear"></div>';
		}

		echo '<div class="cloudfw-ui-slider-container">';
				admin_create_slider ( array(
					'id'          => isset($data['id']) ? $data['id'] : NULL,
					'name'        => isset($data['name']) ? $data['name'] : NULL,
					'value'       => isset($data['value']) ? $data['value'] : NULL,
					'brackets'    => isset($data['brackets']) ? $data['brackets'] : NULL,
					'min'         => isset($data['min']) ? $data['min'] : NULL,
					'max'         => isset($data['max']) ? $data['max'] : NULL,
					'step'        => isset($data['step']) ? $data['step'] : NULL,
					'steps'       => isset($data['steps']) ? $data['steps'] : NULL,
					'range'       => isset($data['range']) ? $data['range'] : NULL,
					'min_range'   => isset($data['min_range']) ? $data['min_range'] : NULL,
					'slide'       => isset($data['slide_func']) ? $data['slide_func'] : NULL,
					'preview'     => isset($data['preview_func']) ? $data['preview_func'] : NULL,
					'orientation' => isset($data['orientation']) ? $data['orientation'] : NULL,
					'class'       => isset($data['class']) ? cloudfw_make_class($data['class'], 0) : NULL,
					'width'       => isset($data['width']) ? $data['width'] : NULL,
					'reset'       => isset($data['reset']) ? $data['reset'] : NULL,
				) );
		echo '</div>';

		if ( isset( $data['after'] ) && $data['after'] )
			cloudfw_render_page( $data['after'], $args );

		echo isset($data['description']) ? $data['description'] : NULL;

		break;

/*  RADIO  */
		case 'radio':
		case 'checkbox':
		case 'select':

		if ( !isset( $data['class'] ) || !$data['class'] ) {
			$data['class'] = array( 'custom_label' );
		}

		if ( isset( $data['description'] ) && $data['description'] )
			$data['description'] = '<div class="description">'.$data['description'].'</div><div class="clear"></div>';

			if ( isset( $data['value'] ) && $data['value'] )
				$data['value'] = cloudfw_render_filters( $data['value'], $data, $args );

			if ( isset( $data['source'] ) && $data['source'] )
				$data['source'] = cloudfw_render_filters( $data['source'], $data, $args );


			if (empty($data['source']) || ( is_array( $data['source'] ) && ! count( $data['source'] > 0 ) ) ) {

				if ( isset( $data['prepend_no_result'] ) && $data['prepend_no_result'] )
					cloudfw_render_page( $data['prepend_no_result'], $args );

				echo isset($data['no_result']) ? $data['no_result'] : NULL;

				if ( isset($data['no_result_callback']) && $data['no_result_callback'] )
					cloudfw_render_page($data['no_result_callback']);

				if ( isset( $data['append_no_result'] ) && $data['append_no_result'] )
					cloudfw_render_page( $data['append_no_result'], $args );


			} else {

				if ( $type == 'select' )
					if ( !isset($data['ui']) )
						$data['ui'] = true;

				if ( isset( $data['prepend_results'] ) && $data['prepend_results'] )
					cloudfw_render_page( $data['prepend_results'], $args );

				if ($data['type'] == 'radio') {
					$type = 'radio';
				} elseif ($data['type'] == 'checkbox') {
					$type = 'check';
				} elseif ($data['type'] == 'select') {
					$type = 'select';
				}

				if ( isset($data['class']) && ! is_array($data['class']) )
					$data['class'] = array( $data['class'] );

				if ( isset($data['main_class']) && ! is_array($data['main_class']) )
					$data['main_class'] = array( $data['main_class'] );


				if ( $type == 'select' ) {
					if ( isset( $data['ui'] ) && $data['ui'] )
						$data['class'][] = 'cloudfw-ui-select';

					if ( isset( $data['chosen'] ) && $data['chosen'] )
						$data['class'][] = 'cloudfw-ui-chosen';

					if ( isset( $data['compact'] ) && $data['compact'] )
						$data['class'][] = 'cloudfw-ui-select-compact';

				}

				if ( isset( $data['title'] ) && $data['title'] )
					echo '<div class="clear"></div><label class="sub-title" for="'. $data['id'] .'">'.$data['title'].'</label><div class="clear"></div>';

				admin_create_selectlist(array(
					'id'                => isset($data['id']) ? $data['id'] : NULL,
					'items'             => isset($data['source']) ? $data['source'] : NULL,
					'default_value'     => isset($data['default_value']) ? $data['default_value'] : NULL,
					'type'              => isset($type) ? $type : NULL,
					'value'             => isset($data['value']) ? $data['value'] : NULL,
					'multiple'          => isset($data['multiple']) ? $data['multiple'] : NULL,
					'brackets'          => isset($data['brackets']) ? $data['brackets'] : NULL,
					'reset'             => isset($data['reset']) ? $data['reset'] : NULL,
					'ui'                => isset($data['ui']) ? $data['ui'] : NULL,
					'main_class'        => isset($data['class']) ? cloudfw_make_class($data['class'], 0) : NULL,
					'main_select_class' => isset($data['main_class']) ? cloudfw_make_class($data['main_class'], 0) : NULL,
					'width'             => isset($data['width']) ? $data['width'] : NULL,
					'height'            => isset($data['height']) ? $data['height'] : NULL,
				));

				echo isset($data['action_link']) ? $data['action_link'] : NULL;

				echo isset($data['description']) ? '<div class="cf clearfix"></div>' . $data['description'] : NULL;

				if ( isset( $data['append_results'] ) && $data['append_results'] )
					cloudfw_render_page( $data['append_results'], $args );

			}

			if ( isset( $data['after'] ) && $data['after'] )
				cloudfw_render_page( $data['after'], $args );


		break;
/*  DROP DOWN  */
		case 'dropdown':

			if ( isset( $data['source'] ) && $data['source'] )
				$data['source'] = cloudfw_render_filters( $data['source'], $data, $args );

			if ( isset( $data['value'] ) && $data['value'] )
				$data['value'] = cloudfw_render_filters( $data['value'], $data, $args );

			if (empty($data['source']) || ( is_array( $data['source'] ) && ! count( $data['source'] > 0 ) ) ) {

				if ( isset( $data['prepend_no_result'] ) && $data['prepend_no_result'] )
					cloudfw_render_page( $data['prepend_no_result'], $args );

				echo isset($data['no_result']) ? $data['no_result'] : NULL;

				if ( isset( $data['append_no_result'] ) && $data['append_no_result'] )
					cloudfw_render_page( $data['append_no_result'], $args );

				continue;
			}


			if ( isset( $data['before'] ) && $data['before'] )
				cloudfw_render_page( $data['before'], $args );

			if ( isset( $data['title'] ) && $data['title'] )
				echo '<label class="sub-title" for="'. $data['id'] .'">'.$data['title'].'</label><div class="clear"></div>';

			if ( isset( $data['prepend_results'] ) && $data['prepend_results'] )
				cloudfw_render_page( $data['prepend_results'], $args );

			   admin_create_gf_menu (array(
					'id'        => $data['id'],
					'value'     => $data['value'],
					'content'   => $data['source'],
					'width'     => $data['width'] ? $data['width'] : '210',
					'class'     => cloudfw_make_class($data['class'], 0),
					'def_val'   => $data['default_value'],
					'def_name'  => $data['default_name'],
					'toggle'    => $data['toggle'],
					'acc'       => $data['accordion']
					)
				);

			echo isset($data['description']) ? $data['description'] : NULL;

			if ( isset( $data['append_results'] ) && $data['append_results'] )
				cloudfw_render_page( $data['append_results'], $args );

			if ( isset( $data['after'] ) && $data['after'] )
				cloudfw_render_page( $data['after'], $args );

		break;

/*  PAGE SELECTOR  */
		case 'page-selector':

			if ( !isset( $data['class'] ) || !$data['class'] )
				$data['class'] = array( 'input input_400' );


			if ( isset( $data['before'] ) && $data['before'] )
				cloudfw_render_page( $data['before'], $args );

			if ( isset( $data['title'] ) && $data['title'] )
				echo '<label class="sub-title" for="'. $data['id'] .'">'.$data['title'].'</label><div class="clear"></div>';

				cloudfw_ui_page_selector(array(
					'id'                  => isset($data['id']) ? $data['id'] : NULL,
					'value'               => isset($data['value']) ? $data['value'] : NULL,
					'brackets'            => isset($data['brackets']) ? $data['brackets'] : NULL,
					'preview'             => isset($data['preview']) ? $data['preview'] : TRUE,
					'button_text'         => isset($data['button_text']) ? $data['button_text'] : __('Select Page','cloudfw'),
					'class'               => isset($data['class']) ? $data['class'] : NULL,
					'button_class'        => isset($data['button_class']) ? $data['button_class'] : NULL,
					'filter'              => empty($data['filter']) ? apply_filters('cloudfw_ui_page_selector_filters', array('page', 'post')) : $data['filter'],
					'response'            => isset($data['response']) ? $data['response'] : NULL,
					'scope'               => isset($data['scope']) ? $data['scope'] : NULL,
					'hide_input'          => isset($data['hide_input']) ? $data['hide_input'] : NULL,
				));

			echo isset($data['description']) ? '<div class="description">'. $data['description'] .'</div>' : NULL;

			if ( isset( $data['after'] ) && $data['after'] )
				cloudfw_render_page( $data['after'], $args );

		break;

/*  ICON SELECTOR  */
		case 'icon-selector':

		if ( isset( $data['title'] ) && $data['title'] ){
			$for = isset($data['id']	) ? $data['id']	 : NULL;
			echo '<label class="sub-title" for="'. $for .'">'.$data['title'].'</label><div class="clear"></div>';
		}

			admin_create_icon_selection(array(
				'id'           => isset($data['id']) ? $data['id'] : NULL,
				'value'        => isset($data['value']) ? $data['value'] : NULL,
				'class'        => cloudfw_make_class(isset($data['class']) ? $data['class'] : NULL, 0),
				'default'      => isset($data['default']) ? $data['default'] : NULL,
				'brackets'     => isset($data['brackets']) ? $data['brackets'] : NULL,
				'allow_custom' => isset($data['allow_custom']) ? $data['allow_custom'] : NULL
			));
		break;

/*  BACKGROUND SET  */
		case 'bg-set':

			if ( isset( $data['title'] ) && $data['title'] )
				echo '<label class="sub-title" for="'. $data['id'] .'">'.$data['title'].'</label><div class="clear"></div>';

			cloudfw_predefined_kit_background(array(
				'sectionModule'         => isset($data['id']) ? $data['id'] : NULL,
				'sectionModule_pattern' => isset($data['id:pattern']) ? $data['id:pattern'] : NULL,
				'data'                  => isset($data['value']) ? $data['value'] : NULL,
				'attachment'            => isset($data['attachment']) ? $data['attachment'] : NULL,
			));
		break;

/*  TYPOGRAPHY SET  */
		case 'typo-set':

			include_once( untrailingslashit(dirname(__FILE__)) . '/templates/option.kit.typo.php' );

			cloudfw_predefined_kit_typo(
				isset($data['title']) ? $data['title'] : NULL,
				isset($data['id']) ? $data['id'] : NULL,
				isset($data['value']) ? $data['value'] : NULL,
				isset($data['data']) ? $data['data'] : NULL
			);

		break;

/*  OPTION SETS  */
		case 'border':
		case 'text-shadow-kit':

			$type_sanitize = str_replace('-', '_', $type); 
			$kit_function = "cloudfw_predefined_kit_{$type_sanitize}";

			include_once( untrailingslashit(dirname(__FILE__)) . "/templates/option.kit.{$type}.php" );
			$kit_function( $data );

		break;
/*  MULTIPLE BLOG CATEGORIES    */
		case 'multi-blog-cats':

			if ( isset( $data['title'] ) && $data['title'] )
				echo '<label class="sub-title" for="'. $data['id'] .'">'.$data['title'].'</label><div class="clear"></div>';

			if ( !isset( $data['class'] ) || !$data['class'] )
				$data['class'] = array( 'input input_400' );

			if ( !isset( $data['height'] ) || !$data['height'] )
				$data['height'] = '150px';

				echo '<input type="hidden" value="true" id="is_defined_'.$data['id'].'" name="is_defined_'.$data['id'].'">';

				 $_blog_categories = wp_dropdown_categories('hierarchical=1&echo=0&hide_empty=0&name='.$data['id'].'[]&class='.urlencode(cloudfw_make_class($data['class'], 0)).'');

					$_blog_categories = str_replace("id='".$data['id']."[]'", "id='".$data['id']._if( !isset( $data['brackets'] ) || $data['brackets'], '[]' )."' multiple='multiple' autocomplete='off' style='height:".$data['height'].";'", $_blog_categories);

					if (is_array($data['value']))

					   {foreach ($data['value'] as $excluded_category){
							$_blog_categories = str_replace('value="'.$excluded_category.'"', 'value="'.$excluded_category.'" selected="selected"' , $_blog_categories);
						}
					}

			echo $_blog_categories;

		break;
		case 'user-select':

		if ( !isset( $data['class'] ) || !$data['class'] )
			$data['class'] = array( 'input input_400' );

			echo '<span class="cloudfw-ui-select" data-init="true">';

			wp_dropdown_users(array(
				'name'            => isset($data['id']) ? $data['id'] : NULL,
				'id'              => isset($data['id']) ? $data['id'] : NULL,
				'class'           => cloudfw_make_class(isset($data['class']) ? $data['class'] : NULL, 0),
				'selected'        => isset($data['value']) ? $data['value'] : NULL,
				'multi'           => isset($data['multi']) ? $data['multi'] : NULL,
				'show_option_all' => isset($data['all_user_text']) ? $data['all_user_text'] : __('All Administrators','cloudfw'),
				'who'             => 'authors'
			));

			echo '<span class="the-arrow-wrap"><span class="the-arrow"></span></span><span class="cloudfw-ui-select-title">'.  __('All Administrators','cloudfw') .'</span>';
			echo '</span>';

		break;

/*  JQUERY  */
		case 'jquery':
			echo '<script type="text/javascript">
			// <![CDATA[
			jQuery(document).ready(function(){
				"use strict";';

							if ( isset($data['source']) && $data['source'] ) {
								echo cloudfw_render_filters( $data['source'], $data, $args );
							}
							echo isset($data['data']) ? $data['data'] : NULL;
						echo "
			});
			// ]]>
			</script>";
		break;

/*  INDICATOR  */
		case 'indicator':
			echo '<input type="hidden" value="1" id="'. $data['id'] .'" name="'.$data['id'].'[]">';
		break;

/*  REMOVE  */
		case 'remove':
			echo '<a class="cloudfw-action-remove cloudfw-ui-module-remove cloudfw-tooltip" title="'. __('remove','cloudfw') .'" data-target="li" href="javascript:;">', isset($data['title']) ? $data['title'] : __('Remove','cloudfw') ,'</a>';
		break;

/*  DIVIDER  */
		case 'divider':
			echo '<div class="divider"></div>';
		break;

/*  SPACE  */
		case 'space':
			echo '<div class="space"></div>';
		break;

/*  RANDOMIZER  */
		case 'randomizer':

			if ( empty( $data['value'] ) ) {
				$data['value'] = cloudfw_randomizer(_if( empty($data['length']) && is_numeric($data['length']), $data['length'], 10 ), $data['prefix'], $data['chars']);
			}

			echo '<input type="hidden" value="'. $data['value'] .'" id="'.$data['id'].'" class="randomizer" name="'.$data['id'].'[]"';

			if ( isset($data['reset']) )
				echo ' data-reset="'.$data['reset'].'"';

			if ( isset($data['prefix']) )
				echo ' data-prefix="'.$data['prefix'].'"';

			if ( isset($data['length']) )
				echo ' data-length="'.$data['length'].'"';

			if ( isset($data['chars']) )
				echo ' data-chars="'.$data['chars'].'"';

			echo '/>';
		break;

/*  SHORTCODES  */
		case 'render:shortcodes':
		require_once(TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.render.loader.php');
		break;

/*  COMPOSER  */
		case 'render:composer':
			require_once(TMP_PATH.'/cloudfw/core/engine.composer/core.composer.render.php');
		break;

	} // switch

		if (isset($data['clear_after']) && $data['clear_after'])
			echo '<div class="clear"></div>';


}

/**
 *  Render Filters
 *
 *  @since 1.0
 */
function cloudfw_render_filters( $filter_data = array(), $data = array(), $args = NULL ){

	$type = isset($force_type) ? $force_type : NULL;
	if ( !isset( $type  ) || !$type  )
		$type = isset($filter_data['type']) ? $filter_data['type'] : NULL;


	switch($type){
/*  FUNCTION  */
		case 'function':
			/** Prepare Variables */
			$function_variables = isset($filter_data['vars']) ? $filter_data['vars'] : NULL;
			$function_variables_send_data = isset($filter_data['send_data']) ? $filter_data['send_data'] : NULL;
			$function_variables_send_args = isset($filter_data['send_args']) ? $filter_data['send_args'] : NULL;

			if ( !isset( $function_variables ) || !is_array( $function_variables ) )
				$function_variables = array();

			if ( isset( $function_variables_send_data ) && $function_variables_send_data )
				array_push( $function_variables, $data );

			if ( isset( $function_variables_send_args ) && $function_variables_send_args )
				array_push( $function_variables, $args );


			$exists = false;
			$results = NULL;
			/** Call a Function */
			if ($filter_data['function']) {

				if ( is_array($filter_data['function']) ) {
					$exists = method_exists( $filter_data['function'][0], $filter_data['function'][1] );

				} else {
					$exists = function_exists( $filter_data['function'] );
				}

				if ( isset( $exists ) && $exists ) {
					$results = $function_variables ?
							call_user_func_array( $filter_data['function'], $function_variables ) :
							$filter_data['function']();
				}

				if ( !empty( $results ) ) {

					$excludes = isset($filter_data['exclude']) ? $filter_data['exclude'] : array();

					if ( !empty( $excludes ) ) {
						foreach ($excludes as $exclude_key) {
							if ( !isset($results[ $exclude_key ]) ) {
								continue;
							}
							unset($results[ $exclude_key ]);
						}

					}

					$includes = isset($filter_data['include']) ? $filter_data['include'] : array();

					if ( !empty( $includes ) ) {
						foreach ($includes as $include_key => $include_value) {
							$results[ $include_key ] = $include_value;
						}

					}

					$prepend = isset($filter_data['prepend']) ? $filter_data['prepend'] : array();

					if ( !empty( $prepend ) ) {

						if ( !is_array( $prepend ) ) {
							$prepend = array( 'NULL' => $prepend ); 
						}

						$results = (array) $prepend + (array) $results; 
					}

					return $results;


				} else {
					return false;
				}

			}
			else {
				return false;
			}

		break;

/*  INCLUDE */
		case 'include':
		case 'require':

			if (file_exists($filter_data['path'])):
				echo isset($filter_data['before']) ? $filter_data['before'] : NULL;
				if($filter_data['type'] == 'include')
					include($filter_data['path']);
				else
					require($filter_data['path']);
				echo $filter_data['after'];
			else:
				printf(__('%s file cannot found','cloudfw'), $filter_data['path']);
			endif;

		break;

	}

	return $filter_data;
}

/**
 *  Render Filters
 *
 *  @since 1.0
 */
function cloudfw_render_javascript( $scripts = array(), $data = array(), $args = NULL ){


	foreach ((array) $scripts as $script_id => $script):

		$type = $script['type'];
		$out  = '';

		switch($type){

	/*  TOGGLE  */
			case 'toggle':

				$effect = isset($script['effect']) ? $script['effect'] : NULL;

				switch ($effect) {
					case 'fade':
					default:
						$effect_in  = 'fadeIn';
						$effect_out = 'fadeOut';
						break;

					case 'none':
						$effect_in  = 'show';
						$effect_out = 'hide';
						break;
				}

				/** Define Element */
				if ( !isset( $script['e'] ) )
					$element = isset($data['data'][0]['id']) ? $data['data'][0]['id'] : NULL;
				else
					$element = isset($script['e']) ? $script['e'] : NULL;

				if ( empty( $element ) )
					continue;

				$type = isset($script['compatibility']) ? $script['compatibility'] : NULL;

				$variable = "val_{$element}";

				$script_out = '';
				$script_out .= "\tvar {$variable} = cloudfw_get_value(jQuery('#{$element}')); \n //alert( {$variable}); \n\n";
				$script_out .= "\tjQuery('.".$script['related']."').hide().prev('.divider').hide();\n";
				foreach ($script['conditions'] as $cond_number => $condition) {
					$condition_element = ( strpos($condition['e'], '.') === false ) ? '#'.$condition['e'] : $condition['e'];
					$cond_value = isset($condition['val']) ? $condition['val'] : NULL;

					$script_out .= "\t\tif ({$variable} ";
					$script_out .= isset($condition['!']) && $condition['!']? "!" : "=";
					$script_out .= "= '{$cond_value}') {\n";

						if ( empty($condition['action']) || $condition['action'] == 'show' ) {
							$script_out .= "\t\t\tjQuery('{$condition_element}')";
							if ( $type == 'module' )
								$script_out .= ".parents('.module')";
							$script_out .= ".{$effect_in}().prev('.divider').removeClass('not').show();";
						} elseif ( $condition['action'] == 'hide' ) {
							$script_out .= "\t\t\tjQuery('{$condition_element}')";
							if ( $type == 'module' )
								$script_out .= ".parents('.module')";
							$script_out .= ".{$effect_out}().prev('.divider').addClass('not').hide();";
						}
					$script_out .= "\n\t\t}\n";

				}
				$out .= $script_out;
				$out .= "jQuery('#{$element}').bind('change',function(){\n\n";
					$out .= $script_out;
				$out .= "});\n\n";

			break;
		}

	endforeach;

	if ( isset( $out ) && $out ) {
		echo "<script type=\"text/javascript\">\n";
		echo "// <![CDATA[\n\n
		jQuery(window).ready(function(){ //CFJS\n\n";
					echo isset($out) ? $out : NULL;
				echo "\n\n});\n
		// ]]></script>";
	}
}

/**
 *  Render Tabs
 *
 *  @since 1.0
 */
function cloudfw_render_horizontal_tabs( $data = array(), $align = 'left' ){
		if ( ! is_array($data) )
			return false;

		if ( empty($align) )
			$align = 'left';

		echo '<span class="cloudfw_sub_navigation_items tabs_align-'.$align.'"><ul>';

			ksort($data);
			$keys = array_keys($data);
			$first_tab = reset($keys);
			$last_tab =  end($keys);
			$tab_counts = count($data);


			foreach($data as $tab_id => $tab_):
				if ($first_tab == $tab_id) {
					$tab_class = "firsttab";}
				elseif ($last_tab == $tab_id) {
					$tab_class = "lasttab";}
				else {unset($tab_class);}

				if ( $tab_counts == 1 )
					$tab_class = "onetab";

				echo '<li class="'.$tab_class.'">
						<a href="#'.$tab_["id"].'">'.$tab_["title"].'</a>
						<span class="indicator"></span>
					  </li>';

			endforeach;

		echo '</ul></span><div class="clear"></div>';
}

/**
 *  Render Tabs
 *
 *  @since 1.0
 */
function cloudfw_render_tabs( $data = array() ){

		if ( ! is_array($data) )
			return false;

		echo '
		<ul>';

			ksort($data);
			$tab_class = '';
			$keys = array_keys($data);
			$first_tab = reset($keys);
			$last_tab =  end($keys);

			foreach($data as $tab_id => $tab_):

				if ($first_tab == $tab_id) {
					$tab_class = "firsttab";
				}
				elseif ($last_tab == $tab_id) {
					$tab_class = "lasttab";
				} else {
					$tab_class = '';
				}

				if ( isset($tab_["icon"]) && $tab_["icon"] ) {
					$icon = true;
					$tab_class .= ' tab-icon tab-icon-' . $tab_["icon"];
				} else {
					$icon = false;
				}

				echo '<li class="'.$tab_class.'"><a href="#'.$tab_["id"].'">';
					if ( $icon ) {
						echo '<span class="tab-icon-handler"></span>';
					}

					echo $tab_["title"];
				echo '</a></li>';

			endforeach;

		echo '</ul><div class="clear"></div>';
}

/**
 *  Prepare Tab Arrays
 *
 *  @since 1.0
 */
function cloudfw_prepare_tabs( $data = array(), $force_type = NULL ){

	if ( ! is_array($data) )
		return;

	$out = array();
	foreach ($data as $data_number => $datas):

		$type = !isset($force_type) ? $datas['type'] : $force_type;
		switch($type){
			case 'tabs':
				if (
					 (!isset($datas) || !is_array($datas)) ||
					 (!isset( $datas['tab_title'] ) || !$datas['tab_title']) ||
					 (!isset( $datas['tab_id'] ) || !$datas['tab_id'])
				) continue;

				$prepared = array('forced_type' => $type,'type' => $datas['type'], 'id' => $datas['tab_id'], 'title' => $datas['tab_title']);

				unset($datas['tab_id']);
				unset($datas['tab_title']);
				unset($datas['data']);

				$out[$data_number] = array_merge( $datas, $prepared );
				break;

		}

	endforeach;

	return isset($out) && $out ? $out : false;
}

/**
 *  Prepare Tab Arrays
 *
 *  @since 1.0
 */
function cloudfw_prepare_tabs_vertical( $data = array(), $force_type = NULL ){

	if ( ! is_array($data) )
		return;

	$out = array();
	foreach ($data as $data_number => $datas):

		$type = !isset($force_type) ? $datas['type'] : $force_type;

		if ( isset( $datas['condition'] ) ) {
			if ( $datas['condition'] === false || $datas['condition'] === 0 ) {
				continue;
			} elseif ( is_array($datas['condition']) ){
				if ( isset($datas['condition']['!']) && $datas['condition']['!'] ) {
					if ( ! cloudfw_render_filters( isset($datas['condition']) ? $datas['condition'] : NULL ) )
						continue;
				} else {
					if ( cloudfw_render_filters( isset($datas['condition']) ? $datas['condition'] : NULL ) )
						continue;
				}
			}
		}

		switch($type){
			case 'vertical_tabs':
				if (! is_array($datas) || !$datas['tab_title'] || !$datas['tab_id'])
					continue;

				$prepared = array('forced_type' => $type,'type' => $datas['type'], 'id' => $datas['tab_id'], 'title' => $datas['tab_title']);

				unset($datas['tab_id']);
				unset($datas['tab_title']);
				unset($datas['data']);

				$out[$data_number] = array_merge( $datas, $prepared );
				break;
		}

	endforeach;

	return isset($out) && $out ? $out : false;
}


/**
 *  Render Form
 *
 *  @since 1.0
 */
function cloudfw_render_form_header( $data = array(), $args = array() ){

	if ( empty($data) || !$data['enable'] || (isset($data['load_header']) && !$data['load_header']) )
		return;

	if ( isset($data['class']) && !is_array($data['class']) )
		$data['class'] = $data['class'] ? array($data['class']) : array();
	else
		$data['class'] = array();

	if ( isset($data['ajax']) && $data['ajax'] )
		$data['class'][] = 'ajax_form';

	if ( isset($data['shortcut']) && $data['shortcut'] )
		$data['class'][] = 'ctrl_s_form';

	if ( isset($data['sending']) && $data['sending'] )
		$data['class'][] = 'sending_form';

	if( isset($data['before']) && $data['before'] )
		echo $data['before'];

	echo '<form';

		/** ID */
		if( isset($data['id']) )
			echo ' id="'. $data['id'] .'"';

		/** Class */
		if( isset($data['class']) )
			echo cloudfw_make_class($data['class']);

		/** Method */
		if( isset($data['method']) )
			echo ' method="'. $data['method'] .'"';
		else
			echo ' method="post"';

		/** Action */
		if( isset($data['action']) )
			echo ' action="'. $data['action'] .'"';

	echo '>';

	echo '<input type="hidden" value="1" name="'.PFIX.'_update" id="update_identifier">';


		wp_nonce_field('cloudfw','_wp_nonce');

		if( !isset($data['selector']) )
			$data['selector'] = 'save_options';

		if( isset($data['selector']) && $data['selector'] )
			echo '<input type="hidden" value="'.$data['selector'].'" name="form_selector" id="form_selector">';

		if( isset($data['comeback']) && $data['comeback'] )
			echo '<input type="hidden" value="'.$args['this_page'].'" name="comeback" id="comeback">';


		if( isset($data['message']) && $data['message'] )
			echo '<input type="hidden" value="'.$data['message'].'" name="message">';


	if( isset($data['prepend']) && $data['prepend'] )
		echo $data['prepend'];
}

function cloudfw_render_form_footer( $data = array(), $args = array() ){

	if ( empty($data) || !$data['enable'] || (isset($data['load_footer']) && !$data['load_footer']))
		return;

	if ( isset($data['append']) && !empty($data['append']) )
		echo $data['append'];

	echo '</form>';

	if ( isset($data['after']) && !empty($data['after']) )
		echo $data['after'];
}