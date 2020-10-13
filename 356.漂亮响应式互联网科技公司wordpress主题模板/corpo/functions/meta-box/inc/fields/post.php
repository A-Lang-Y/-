<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Make sure "select" field is loaded
require_once RWMB_FIELDS_DIR . 'select-advanced.php';

if ( !class_exists( 'RWMB_Post_Field' ) )
{
	class RWMB_Post_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			RWMB_Select_Advanced_Field::admin_enqueue_scripts();
		}

		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			$field['options'] = self::get_options( $field );
			switch ( $field['field_type'] )
			{
				case 'select':
					return RWMB_Select_Field::html( $html, $meta, $field );
					break;
				case 'select_advanced':
				default:
					return RWMB_Select_Advanced_Field::html( $html, $meta, $field );
			}
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$default_post_type = __( 'Post', 'rwmb' );
			if ( is_string( $field['post_type'] ) )
			{
				$post_type_object = get_post_type_object( $field['post_type'] );
				$default_post_type = $post_type_object->labels->singular_name;
			}

			$field = wp_parse_args( $field, array(
				'post_type'  => 'post',
				'field_type' => 'select_advanced',
				'parent'     => false,
				'query_args' => array()
			) );

			$field['std'] = empty( $field['std'] ) ? sprintf( __( 'Select a %s', 'rwmb' ), $default_post_type ) : $field['std'];

			if ( $field['parent'] )
			{
				$field['multiple'] = false;
				$field['field_name'] = 'parent_id';
			}

			$field['query_args'] = wp_parse_args( $field['query_args'], array(
				'post_type'      => $field['post_type'],
				'post_status'    => 'publish',
				'posts_per_page' => '-1'
			) );

			switch ( $field['field_type'] )
			{
				case 'select':
					return RWMB_Select_Field::normalize_field( $field );
					break;
				case 'select_advanced':
				default:
					return RWMB_Select_Advanced_Field::normalize_field( $field );
			}
		}

		/**
		 * Get meta value
		 * If field is cloneable, value is saved as a single entry in DB
		 * Otherwise value is saved as multiple entries (for backward compatibility)
		 *
		 * @see "save" method for better understanding
		 *
		 * @param $meta
		 * @param $post_id
		 * @param $saved
		 * @param $field
		 *
		 * @return array
		 */
		static function meta( $meta, $post_id, $saved, $field )
		{
			if ( isset( $field['parent'] ) && $field['parent'] )
			{
				$post = get_post( $post_id );
				return $post->post_parent;
			}
			return RWMB_Select_Field::meta( $meta, $post_id, $saved, $field );
		}

		/**
		 * Save meta value
		 * If field is cloneable, value is saved as a single entry in DB
		 * Otherwise value is saved as multiple entries (for backward compatibility)
		 *
		 * TODO: A good way to ALWAYS save values in single entry in DB, while maintaining backward compatibility
		 *
		 * @param $new
		 * @param $old
		 * @param $post_id
		 * @param $field
		 */
		static function save( $new, $old, $post_id, $field )
		{
			return RWMB_Select_Field::save( $new, $old, $post_id, $field );
		}

		/**
		 * Get posts
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function get_options( $field )
		{
			$results = get_posts( $field['query_args'] );
			$options = array();
			foreach ( $results as $result )
			{
				$options[$result->ID] = get_the_title( $result->ID );
			}
			return $options;
		}
	}
}
