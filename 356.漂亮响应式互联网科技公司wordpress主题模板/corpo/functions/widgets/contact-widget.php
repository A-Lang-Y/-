<?php
/**
 * Plugin Name: Contact Widget
 */

class corpo_contact_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function corpo_contact_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'corpo_contact_widget', 'description' => __('Displays conatct info with icons', 'corpo') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'corpo_contact_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'corpo_contact_widget', __('Corpo: Contact widget', 'corpo'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
        $title = $instance['title'];
		$address = $instance['address'];
		$phone = $instance['phone'];
		$email = $instance['email'];


		?>

        <div class="widget contact">
            <h4 class="widget-title"><?php echo $title; ?></h4>
            <ul>
                <li>
                    <i class="icon-home"></i>
                    <b><?php _e('Address','corpo'); ?>:</b> <?php echo $address; ?>
                </li>
                <li>
                    <i class="icon-phone"></i>
                    <b><?php _e('Phone','corpo'); ?>:</b> <?php echo $phone; ?>
                </li>
                <li>
                    <i class="icon-envelope-alt"></i>
                    <b><?php _e('Email','corpo'); ?>:</b> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                </li>
            </ul>
        </div>
        
		<?php
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array('title' => __('Contact','corpo'), 'address' => '', 'phone' => '', 'email' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<!-- Widget Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		<!-- Addres -->
		<p>
			<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e('Address','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo $instance['address']; ?>" style="width:90%;" />
		</p>
		<!-- Phone -->
		<p>
			<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e('Phone','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo $instance['phone']; ?>" style="width:90%;" />
		</p>
		<!-- Email -->
		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Email','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" style="width:90%;" />
		</p>        
	<?php
	}
}

?>