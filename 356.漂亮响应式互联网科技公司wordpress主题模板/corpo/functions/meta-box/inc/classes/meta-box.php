<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Meta Box Class
if ( ! class_exists( 'RW_Meta_Box' ) )
{
	/**
	 * A class to rapid develop meta boxes for custom & built in content types
	 * Piggybacks on WordPress
	 *
	 * @author Rilwis
	 * @author Co-Authors @see https://github.com/rilwis/meta-box
	 * @license GNU GPL2+
	 * @package RW Meta Box
	 */
	class RW_Meta_Box
	{
		/**
		 * @var array Meta box information
		 */
		public $meta_box;

		/**
		 * @var array Fields information
		 */
		public $fields;

		/**
		 * @var array Contains all field types of current meta box
		 */
		public $types;

		/**
		 * @var array Validation information
		 */
		public $validation;

		/**
		 * Create meta box based on given data
		 *
		 * @see demo/demo.php file for details
		 *
		 * @param array $meta_box Meta box definition
		 *
		 * @return RW_Meta_Box
		 */
		function __construct( $meta_box )
		{
			// Run script only in admin area
			if ( ! is_admin() )
				return;

			// Assign meta box values to local variables and add it's missed values
			$this->meta_box   = self::normalize( $meta_box );
			$this->fields     = &$this->meta_box['fields'];
			$this->validation = &$this->meta_box['validation'];

			// Allow users to show/hide (e.g. include/exclude) meta boxes
			// 1st action applies to all meta boxes
			// 2nd action applies to only current meta box
			$show = true;
			$show = apply_filters( 'rwmb_show', $show, $meta_box );
			$show = apply_filters( "rwmb_show_{$this->meta_box['id']}", $show, $this->meta_box );
			if ( !$show )
				return;

			// Enqueue common styles and scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			// All fields
			$fields = self::get_fields( $this->fields );

			// Add additional actions for fields
			foreach ( $fields as $field )
			{
				$class = self::get_class_name( $field );

				if ( method_exists( $class, 'add_actions' ) )
					call_user_func( array( $class, 'add_actions' ) );
			}

			// Add meta box
			foreach ( $this->meta_box['pages'] as $page )
			{
				add_action( "add_meta_boxes_{$page}", array( $this, 'add_meta_boxes' ) );
			}

			// Hide meta box if it's set 'default_hidden'
			add_filter( 'default_hidden_meta_boxes', array( $this, 'hide' ), 10, 2 );

			// Save post meta
			add_action( 'save_post', array( $this, 'save_post' ) );

			// Attachment uses other hooks
			// @see wp_update_post(), wp_insert_attachment()
			add_action( 'edit_attachment', array( $this, 'save_post' ) );
			add_action( 'add_attachment', array( $this, 'save_post' ) );
		}

		/**
		 * Enqueue common styles
		 *
		 * @return void
		 */
		function admin_enqueue_scripts()
		{
			$screen = get_current_screen();

			// Enqueue scripts and styles for registered pages (post types) only
			if ( 'post' != $screen->base || ! in_array( $screen->post_type, $this->meta_box['pages'] ) )
				return;

			wp_enqueue_style( 'rwmb', RWMB_CSS_URL . 'style.css', array(), RWMB_VER );

			// Load clone script conditionally
			$has_clone = false;
			$fields = self::get_fields( $this->fields );

			foreach ( $fields as $field )
			{
				if ( $field['clone'] )
					$has_clone = true;

				// Enqueue scripts and styles for fields
				$class = self::get_class_name( $field );
				if ( method_exists( $class, 'admin_enqueue_scripts' ) )
					call_user_func( array( $class, 'admin_enqueue_scripts' ) );
			}

			if ( $has_clone )
				wp_enqueue_script( 'rwmb-clone', RWMB_JS_URL . 'clone.js', array( 'jquery' ), RWMB_VER, true );

			if ( $this->validation )
			{
				wp_enqueue_script( 'jquery-validate', RWMB_JS_URL . 'jquery.validate.min.js', array( 'jquery' ), RWMB_VER, true );
				wp_enqueue_script( 'rwmb-validate', RWMB_JS_URL . 'validate.js', array( 'jquery-validate' ), RWMB_VER, true );
			}

			// Auto save
			if ( $this->meta_box['autosave'] )
				wp_enqueue_script( 'rwmb-autosave', RWMB_JS_URL . 'autosave.js', array( 'jquery' ), RWMB_VER, true );
		}

		/**
		 * Get all fields of a meta box, recursively
		 *
		 * @param array $fields
		 *
		 * @return array
		 */
		static function get_fields( $fields )
		{
			$all_fields = array();
			foreach ( $fields as $field )
			{
				$all_fields[] = $field;
				if ( isset( $field['fields'] ) )
				{
					$all_fields = array_merge( $all_fields, self::get_fields( $field['fields'] ) );
				}
			}

			return $all_fields;
		}

		/**************************************************
		 SHOW META BOX
		 **************************************************/

		/**
		 * Add meta box for multiple post types
		 *
		 * @return void
		 */
		function add_meta_boxes()
		{
			foreach ( $this->meta_box['pages'] as $page )
			{
				add_meta_box(
					$this->meta_box['id'],
					$this->meta_box['title'],
					array( $this, 'show' ),
					$page,
					$this->meta_box['context'],
					$this->meta_box['priority']
				);
			}
		}

		/**
		 * Hide meta box if it's set 'default_hidden'
		 *
		 * @param array  $hidden Array of default hidden meta boxes
		 * @param object $screen Current screen information
		 *
		 * @return array
		 */
		function hide( $hidden, $screen )
		{
			if (
				'post' === $screen->base
				&& in_array( $screen->post_type, $this->meta_box['pages'] )
				&& $this->meta_box['default_hidden']
			)
			{
				$hidden[] = $this->meta_box['id'];
			}
			return $hidden;
		}

		/**
		 * Callback function to show fields in meta box
		 *
		 * @return void
		 */
		function show()
		{
			global $post;

			$saved = self::has_been_saved( $post->ID, $this->fields );

			// Container
			printf(
				'<div class="rwmb-meta-box" data-autosave="%s">',
				$this->meta_box['autosave']  ? 'true' : 'false'
			);

			wp_nonce_field( "rwmb-save-{$this->meta_box['id']}", "nonce_{$this->meta_box['id']}" );

			// Allow users to add custom code before meta box content
			// 1st action applies to all meta boxes
			// 2nd action applies to only current meta box
			do_action( 'rwmb_before' );
			do_action( "rwmb_before_{$this->meta_box['id']}" );

			foreach ( $this->fields as $field )
			{
				$meta = self::apply_field_class_filters( $field, 'meta', '', $post->ID, $saved );
				echo self::show_field( $field, $meta );
			}

			// Include validation settings for this meta-box
			if ( isset( $this->validation ) && $this->validation )
			{
				echo '
					<script>
					if ( typeof rwmb == "undefined" )
					{
						var rwmb = {
							validationOptions : jQuery.parseJSON( \'' . json_encode( $this->validation ) . '\' ),
							summaryMessage : "' . __( 'Please correct the errors highlighted below and try again.', 'rwmb' ) . '"
						};
					}
					else
					{
						var tempOptions = jQuery.parseJSON( \'' . json_encode( $this->validation ) . '\' );
						jQuery.extend( true, rwmb.validationOptions, tempOptions );
					};
					</script>
				';
			}

			// Allow users to add custom code after meta box content
			// 1st action applies to all meta boxes
			// 2nd action applies to only current meta box
			do_action( 'rwmb_after' );
			do_action( "rwmb_after_{$this->meta_box['id']}" );

			// End container
			echo '</div>';
		}


		/**
		 * Callback function to show fields in meta box
		 *
		 * @param array  $field
		 * @param string $meta
		 *
		 * @return string
		 */
		static function show_field( $field, $meta = '' )
		{
			$group = '';	// Empty the clone-group field
			$type = $field['type'];
			$id   = $field['id'];

			$meta = apply_filters( "rwmb_{$type}_meta", $meta );
			$meta = apply_filters( "rwmb_{$id}_meta", $meta );

			$begin = self::apply_field_class_filters( $field, 'begin_html', '', $meta );

			// Apply filter to field begin HTML
			// 1st filter applies to all fields
			// 2nd filter applies to all fields with the same type
			// 3rd filter applies to current field only
			$begin = apply_filters( 'rwmb_begin_html', $begin, $field, $meta );
			$begin = apply_filters( "rwmb_{$type}_begin_html", $begin, $field, $meta );
			$begin = apply_filters( "rwmb_{$id}_begin_html", $begin, $field, $meta );

			// Separate code for cloneable and non-cloneable fields to make easy to maintain

			// Cloneable fields
			if ( $field['clone'] )
			{
				if ( isset( $field['clone-group'] ) )
					$group = " clone-group='{$field['clone-group']}'";

				$meta = (array) $meta;

				$field_html = '';

				foreach ( $meta as $index => $meta_data )
				{
					$sub_field = $field;
					$sub_field['field_name'] = $field['field_name'] . "[{$index}]";
					if ( $field['multiple'] )
						$sub_field['field_name'] .= '[]';

					add_filter( "rwmb_{$id}_html", array( __CLASS__, 'add_clone_buttons' ), 10, 3 );

					// Wrap field HTML in a div with class="rwmb-clone" if needed
					$input_html = '<div class="rwmb-clone">';

					// Call separated methods for displaying each type of field
					$input_html .= self::apply_field_class_filters( $sub_field, 'html', '', $meta_data );

					// Apply filter to field HTML
					// 1st filter applies to all fields with the same type
					// 2nd filter applies to current field only
					$input_html = apply_filters( "rwmb_{$type}_html", $input_html, $field, $meta_data );
					$input_html = apply_filters( "rwmb_{$id}_html", $input_html, $field, $meta_data );

					$input_html .= '</div>';

					$field_html .= $input_html;
				}
			}
			// Non-cloneable fields
			else
			{
				// Call separated methods for displaying each type of field
				$field_html = self::apply_field_class_filters( $field, 'html', '', $meta );

				// Apply filter to field HTML
				// 1st filter applies to all fields with the same type
				// 2nd filter applies to current field only
				$field_html = apply_filters( "rwmb_{$type}_html", $field_html, $field, $meta );
				$field_html = apply_filters( "rwmb_{$id}_html", $field_html, $field, $meta );
			}

			$end = self::apply_field_class_filters( $field, 'end_html', '', $meta );

			// Apply filter to field end HTML
			// 1st filter applies to all fields
			// 2nd filter applies to all fields with the same type
			// 3rd filter applies to current field only
			$end = apply_filters( 'rwmb_end_html', $end, $field, $meta );
			$end = apply_filters( "rwmb_{$type}_end_html", $end, $field, $meta );
			$end = apply_filters( "rwmb_{$id}_end_html", $end, $field, $meta );

			// Apply filter to field wrapper
			// This allow users to change whole HTML markup of the field wrapper (i.e. table row)
			// 1st filter applies to all fields with the same type
			// 2nd filter applies to current field only
			$html = apply_filters( "rwmb_{$type}_wrapper_html", "{$begin}{$field_html}{$end}", $field, $meta );
			$html = apply_filters( "rwmb_{$id}_wrapper_html", $html, $field, $meta );

			// Display label and input in DIV and allow user-defined classes to be appended
			$classes = array( 'rwmb-field', "rwmb-{$field['type']}-wrapper" );
			if ( 'hidden' === $field['type'] )
				$classes[] = 'hidden';
			if ( !empty( $field['required'] ) )
				$classes[] = 'required';
			if ( !empty( $field['class'] ) )
				$classes[] = $field['class'];

			return sprintf(
				$field['before'] . '<div class="%s"%s>%s</div>' . $field['after'],
				implode( ' ', $classes ),
				$group,
				$html
			);
		}

		/**
		 * Show begin HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function begin_html( $html, $meta, $field )
		{
			if ( empty( $field['name'] ) )
				return '<div class="rwmb-input">';

			return sprintf(
				'<div class="rwmb-label">
					<label for="%s">%s</label>
				</div>
				<div class="rwmb-input">',
				$field['id'],
				$field['name']
			);
		}

		/**
		 * Show end HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function end_html( $html, $meta, $field )
		{
			$id = $field['id'];

			$button = '';
			if ( $field['clone'] )
				$button = '<a href="#" class="rwmb-button button-primary add-clone">' . __( '+', 'rwmb' ) . '</a>';

			$desc = ! empty( $field['desc'] ) ? "<p id='{$id}_description' class='description'>{$field['desc']}</p>" : '';

			// Closes the container
			$html = "{$button}{$desc}</div>";

			return $html;
		}

		/**
		 * Callback function to add clone buttons on demand
		 * Hooks on the flight into the "rwmb_{$field_id}_html" filter before the closing div
		 *
		 * @param string $html
		 * @param array  $field
		 * @param mixed  $meta_data
		 *
		 * @return string $html
		 */
		static function add_clone_buttons( $html, $field, $meta_data )
		{
			$button = '<a href="#" class="rwmb-button button remove-clone">' . __( '&#8211;', 'rwmb' ) . '</a>';

			return "{$html}{$button}";
		}

		/**
		 * Standard meta retrieval
		 *
		 * @param mixed $meta
		 * @param int   $post_id
		 * @param array $field
		 * @param bool  $saved
		 *
		 * @return mixed
		 */
		static function meta( $meta, $post_id, $saved, $field )
		{
			$meta = get_post_meta( $post_id, $field['id'], !$field['multiple'] );

			// Use $field['std'] only when the meta box hasn't been saved (i.e. the first time we run)
			$meta = ( !$saved && '' === $meta || array() === $meta ) ? $field['std'] : $meta;

			// Escape attributes for non-wysiwyg fields
			if ( 'wysiwyg' !== $field['type'] )
				$meta = is_array( $meta ) ? array_map( 'esc_attr', $meta ) : esc_attr( $meta );

			return $meta;
		}

		/**************************************************
		 SAVE META BOX
		 **************************************************/

		/**
		 * Save data from meta box
		 *
		 * @param int $post_id Post ID
		 *
		 * @return void
		 */
		function save_post( $post_id )
		{
			// Check whether form is submitted properly
			$id = $this->meta_box['id'];
			if ( empty( $_POST["nonce_{$id}"] ) || !wp_verify_nonce( $_POST["nonce_{$id}"], "rwmb-save-{$id}" ) )
				return;

			// Autosave
			if ( defined( 'DOING_AUTOSAVE' ) && !$this->meta_box['autosave'] )
				return;

			// Make sure meta is added to the post, not a revision
			if ( $the_post = wp_is_post_revision( $post_id ) )
				$post_id = $the_post;

			// Save post action removed to prevent infinite loops
			remove_action( 'save_post', array( $this, 'save_post' ) );

			// Before save action
			do_action( 'rwmb_before_save_post', $post_id );
			do_action( "rwmb_{$this->meta_box['id']}_before_save_post", $post_id );

			foreach ( $this->fields as $field )
			{
				$name = $field['id'];
				$old  = get_post_meta( $post_id, $name, !$field['multiple'] );
				$new  = isset( $_POST[$name] ) ? $_POST[$name] : ( $field['multiple'] ? array() : '' );

				// Allow field class change the value
				$new = self::apply_field_class_filters( $field, 'value', $new, $old, $post_id );

				// Use filter to change field value
				// 1st filter applies to all fields with the same type
				// 2nd filter applies to current field only
				$new = apply_filters( "rwmb_{$field['type']}_value", $new, $field, $old );
				$new = apply_filters( "rwmb_{$name}_value", $new, $field, $old );

				// Call defined method to save meta value, if there's no methods, call common one
				self::do_field_class_actions( $field, 'save', $new, $old, $post_id );
			}

			// After save action
			do_action( 'rwmb_after_save_post', $post_id );
			do_action( "rwmb_{$this->meta_box['id']}_after_save_post", $post_id );

			// Reinstate save_post action
			add_action( 'save_post', array( $this, 'save_post' ) );
		}

		/**
		 * Common functions for saving field
		 *
		 * @param mixed $new
		 * @param mixed $old
		 * @param int   $post_id
		 * @param array $field
		 *
		 * @return void
		 */
		static function save( $new, $old, $post_id, $field )
		{
			$name = $field['id'];

			if ( '' === $new || array() === $new )
			{
				delete_post_meta( $post_id, $name );
				return;
			}

			if ( $field['multiple'] )
			{
				foreach ( $new as $new_value )
				{
					if ( !in_array( $new_value, $old ) )
						add_post_meta( $post_id, $name, $new_value, false );
				}
				foreach ( $old as $old_value )
				{
					if ( !in_array( $old_value, $new ) )
						delete_post_meta( $post_id, $name, $old_value );
				}
			}
			else
			{
				update_post_meta( $post_id, $name, $new );
			}
		}

		/**************************************************
		 HELPER FUNCTIONS
		 **************************************************/

		/**
		 * Normalize parameters for meta box
		 *
		 * @param array $meta_box Meta box definition
		 *
		 * @return array $meta_box Normalized meta box
		 */
		static function normalize( $meta_box )
		{
			// Set default values for meta box
			$meta_box = wp_parse_args( $meta_box, array(
				'id'             => sanitize_title( $meta_box['title'] ),
				'context'        => 'normal',
				'priority'       => 'high',
				'pages'          => array( 'post' ),
				'autosave'       => false,
				'default_hidden' => false,
			) );

			// Set default values for fields
			$meta_box['fields'] = self::normalize_fields( $meta_box['fields'] );

			return $meta_box;
		}

		/**
		 * Normalize an array of fields
		 *
		 * @param array $fields Array of fields
		 *
		 * @return array $fields Normalized fields
		 */
		static function normalize_fields( $fields )
		{
			foreach ( $fields as &$field )
			{
				$field = wp_parse_args( $field, array(
					'multiple'   => false,
					'clone'      => false,
					'std'        => '',
					'desc'       => '',
					'format'     => '',
					'before'     => '',
					'after'      => '',
					'field_name' => isset( $field['id'] ) ? $field['id'] : '',
					'required'   => false
				) );

				// Allow field class add/change default field values
				$field = self::apply_field_class_filters( $field, 'normalize_field', $field );

				if( isset( $field['fields'] ) )
				{
					$field['fields'] = self::normalize_fields( $field['fields'] );
				}
			}

			return $fields;
		}

		/**
		 * Get field class name
		 *
		 * @param array $field Field array
		 *
		 * @return bool|string Field class name OR false on failure
		 */
		static function get_class_name( $field )
		{
			$type  = ucwords( $field['type'] );
			$class = "RWMB_{$type}_Field";

			if ( class_exists( $class ) )
				return $class;

			return false;
		}

		/**
		 * Apply filters by field class, fallback to RW_Meta_Box method
		 *
		 * @param array  $field
		 * @param string $method_name
		 * @param mixed  $value
		 *
		 * @return mixed $value
		 */
		static function apply_field_class_filters( $field, $method_name, $value )
		{
			$args   = array_slice( func_get_args(), 2 );
			$args[] = $field;

			// Call:     field class method
			// Fallback: RW_Meta_Box method
			$class = self::get_class_name( $field );
			if ( method_exists( $class, $method_name ) )
			{
				$value = call_user_func_array( array( $class, $method_name ), $args );
			}
			elseif ( method_exists( __CLASS__, $method_name ) )
			{
				$value = call_user_func_array( array( __CLASS__, $method_name ), $args );
			}

			return $value;
		}

		/**
		 * Call field class method for actions, fallback to RW_Meta_Box method
		 *
		 * @param array  $field
		 * @param string $method_name
		 *
		 * @return mixed
		 */
		static function do_field_class_actions( $field, $method_name )
		{
			$args   = array_slice( func_get_args(), 2 );
			$args[] = $field;

			// Call:     field class method
			// Fallback: RW_Meta_Box method
			$class = self::get_class_name( $field );
			if ( method_exists( $class, $method_name ) )
			{
				call_user_func_array( array( $class, $method_name ), $args );
			}
			elseif ( method_exists( __CLASS__, $method_name ) )
			{
				call_user_func_array( array( __CLASS__, $method_name ), $args );
			}
		}

		/**
		 * Format Ajax response
		 *
		 * @param string $message
		 * @param string $status
		 *
		 * @return void
		 */
		static function ajax_response( $message, $status )
		{
			$response = array( 'what' => 'meta-box' );
			$response['data'] = 'error' === $status ? new WP_Error( 'error', $message ) : $message;
			$x = new WP_Ajax_Response( $response );
			$x->send();
		}

		/**
		 * Check if meta box has been saved
		 * This helps saving empty value in meta fields (for text box, check box, etc.)
		 *
		 * @param int   $post_id
		 * @param array $fields
		 *
		 * @return bool
		 */
		static function has_been_saved( $post_id, $fields )
		{
			foreach ( $fields as $field )
			{
				$value = get_post_meta( $post_id, $field['id'], !$field['multiple'] );
				if (
					( !$field['multiple'] && '' !== $value )
					|| ( $field['multiple'] && array() !== $value )
				)
				{
					return true;
				}
			}
			return false;
		}
	}
}
