<?php

add_action('cloudfw_side_panel', 'cloudfw_side_widget_content');
function cloudfw_side_widget_content(){

	for ($i=1; $i <= 3; $i++) { 

		if ( cloudfw_check_onoff( 'side_panel_' . $i, 'enable' ) ) {

			$id = cloudfw_get_option( 'side_panel_' . $i, 'page_id' );
			$title = cloudfw_get_option( 'side_panel_' . $i, 'title' );

			if ( empty( $title ) ) {
				$title = get_the_title( $id );
			}

	?>
		<div id="ui--side-content-widget-<?php echo $i; ?>">
			<h3><strong><?php echo $title; ?></strong></h3>

			<?php echo cloudfw_get_page_content( $id ); ?>

		</div>
	<?php

		}

	}

}

add_action('wp_footer', 'cloudfw_side_widget_content_footer');
function cloudfw_side_widget_content_footer(){

	for ($i=1; $i <= 3; $i++) { 

		if ( cloudfw_check_onoff( 'side_panel_' . $i, 'enable' ) ) {

			$icon = cloudfw_get_option( 'side_panel_' . $i, 'icon' );
			$icon = cloudfw_make_icon( $icon ); 

			if ( empty( $icon ) ) {
				continue;
			}

			$visibility = cloudfw_get_option( 'side_panel_' . $i, 'visibility' );
			$position = cloudfw_get_option( 'side_panel_' . $i, 'position' );

			if ( empty( $position ) ) {
				$position = 'bottom right';
			}

			$position = explode(' ', $position);
			$button_color = cloudfw_get_option( 'side_panel_' . $i, 'button_style', 'btn-primary' );

			echo '<div class="ui--fixed-button position--' . implode(' position--', $position) . ' ' . cloudfw_visible( $visibility ) . '">';
			echo cloudfw_create_button(array(
				'link'	=> 'javascript:;',
				'color' => $button_color,
				'block' => false,
				'class'	=> 'ui--side-panel',
				'attributes' => array(
					'data-target' => 'ui--side-content-widget-' . $i,
				),
				'margin_top' => cloudfw_get_option('side_panel_' . $i, 'margin_top'),
				'margin_bottom' => cloudfw_get_option('side_panel_' . $i, 'margin_bottom'),
			), $icon);

			echo '</div>';

		}

	}

}