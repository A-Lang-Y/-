<?php
/**
 * Plugin Name: Recent Posts
 */

class corpo_recent_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function corpo_recent_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'corpo_recent_posts_widget', 'description' => __('Displays a list of recent posts', 'corpo') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'corpo_recent_posts_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'corpo_recent_posts_widget', __('Corpo: Recent posts list', 'corpo'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = $instance['title'];
		$number = $instance['number'];

        /* Before widget (defined by themes). */
		?>

        <div class="widget recent-posts">
            <h4 class="widget-title"><?php echo $title; ?></h4>
			<ul>
				
			<?php
			
			$posts = new WP_Query(array('showposts' => $number,'post_status' => 'publish', 'ignore_sticky_posts' => 1));
			
			?>
			
				<?php while($posts->have_posts()): $posts->the_post(); ?>
                
                <li>
                    <i class="icon-rss icon"></i>
                    <div class="post">
                        <a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a>
                        <i class="meta"><?php the_time('M j, Y') ?></i>
                    </div>
                </li>

				<?php endwhile; ?>
			</ul>
			<?php wp_reset_query(); ?>
			
		<?php
        /* After widget (defined by themes). */
		echo $after_widget;
    }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array('title' => '', 'number' => 3);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<!-- Widget Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		<!-- Number of posts -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show','corpo') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
		</p>


	<?php
	}
}

?>