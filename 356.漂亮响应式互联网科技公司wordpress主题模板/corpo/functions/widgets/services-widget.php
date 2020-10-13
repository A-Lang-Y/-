<?php
/**
 * Plugin Name: Services Widget
 */

class corpo_services_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function corpo_services_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'corpo_services_widget', 'description' => __('Displays services box, designed for use on Home Page', 'corpo') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'corpo_services_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'corpo_services_widget', __('Corpo: Services widget', 'corpo'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$icon = $instance['icon'];
		$heading = $instance['heading'];
		$desc = $instance['desc'];
		$anchor = $instance['anchor'];
		$url = $instance['url'];


        /* Before widget (defined by themes). */
		echo $before_widget;
		?>

            <i class="<?php echo $icon; ?> icon-3x icon"></i>
            <h5><?php echo $heading; ?></h5>
            <p><?php echo $desc; ?></p>
            <?php if( $url != '' ) : ?>
            <a href="<?php echo esc_url($url); ?>" class="more"><?php echo $anchor; ?></a>
            <?php endif; ?>
		<?php
        /* Before widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['icon'] = strip_tags( $new_instance['icon'] );
		$instance['heading'] = strip_tags( $new_instance['heading'] );
		$instance['desc'] = strip_tags( $new_instance['desc'] );
		$instance['anchor'] = strip_tags( $new_instance['anchor'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array('heading' => '', 'icon' => '', 'desc' => '', 'anchor' => 'Learn more', 'url' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<!-- Widget Icon -->
		<p>
			<label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _e('Icon','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>" value="<?php echo $instance['icon']; ?>" style="width:90%;" />
            <em><?php _e('Icon name, for example: icon-search','corpo') ?></em><br / >
            <em><?php _e('List of all avaialable icons and their names can be found at','cotpo'); ?> <a href="http://fontawesome.io/cheatsheet/">FontAwesome</a>.</em>
		</p>
		<!-- Heading -->
		<p>
			<label for="<?php echo $this->get_field_id( 'heading' ); ?>"><?php _e('Heading','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'heading' ); ?>" name="<?php echo $this->get_field_name( 'heading' ); ?>" value="<?php echo $instance['heading']; ?>" style="width:90%;" />
		</p>
		<!-- Description -->
		<p>
			<label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php _e('Service description','corpo') ?>:</label>
			<textarea id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>" style="width:90%;"><?php echo $instance['desc']; ?></textarea>
		</p>
		<!-- Anchor text -->
		<p>
			<label for="<?php echo $this->get_field_id( 'anchor' ); ?>"><?php _e('Anchor text','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'anchor' ); ?>" name="<?php echo $this->get_field_name( 'anchor' ); ?>" value="<?php echo $instance['anchor']; ?>" style="width:90%;" />
		</p>        
		<!-- URL -->
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('URL Address','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" style="width:90%;" />
		</p>        
	<?php
	}
}

?>