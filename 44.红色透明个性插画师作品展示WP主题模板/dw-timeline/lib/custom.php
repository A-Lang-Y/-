<?php
/**
 * Manage output of wp_title()
 */
function dw_timeline_wp_title($title) {
  if (is_feed()) {
    return $title;
  }

  $title .= get_bloginfo('name');

  return $title;
}
add_filter('wp_title', 'dw_timeline_wp_title', 10);

/**
 *  Add grid value in post class
 */

// Add Metabox
function dw_timeline_meta_box() {
  add_meta_box(
      'dw_timeline_post_setting',
      __( 'Post Settings', 'dw-timeline' ),
      'dw_timeline_post_setting_callback',
      'post',
      'side',
      'high'
  );
}
add_action( 'add_meta_boxes', 'dw_timeline_meta_box' );

function dw_timeline_post_setting_callback( $post ) {
  wp_nonce_field( 'dw_timeline_post_setting_callback', 'dw_timeline_post_setting_callback_nonce' );

  $grid_value = get_post_meta( $post->ID, 'dw-grid', true );
  ?>
    
  <table width="100%">
    <tr><td><strong><?php _e('Select Grid','dw-timeline') ?></strong></td></tr>
    <tr>
      <td width="50%">
        <label>
        <input type="radio" name="dw_timeline_post_grid_setting" value="normal" checked="checked">
        <span><?php _e('Normal','dw-timeline') ?></span>
        </label>
      </td>

      <td width="50%">
        <label>
        <input type="radio" name="dw_timeline_post_grid_setting" value="full" <?php if ($grid_value == 'full') echo 'checked="checked"'  ?> >
        <span><?php _e('Full','dw-timeline') ?></span>
        </label>
      </td>
    </tr>
  </table>

  <?php
}

function dw_timeline_post_setting_save_postdata( $post_id ) {
  // Check if our nonce is set.
  if ( ! isset( $_POST['dw_timeline_post_setting_callback_nonce'] ) )
  return $post_id;

  $nonce = $_POST['dw_timeline_post_setting_callback_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'dw_timeline_post_setting_callback' ) )
  return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return $post_id;

  // Check the user's permissions.
  if ( 'page' == $_POST['post_type'] ) {

  if ( ! current_user_can( 'edit_page', $post_id ) )
    return $post_id;
  }

  /* OK, its safe for us to save the data now. */
  $dw_timeline_post_grid_setting_data = $_POST['dw_timeline_post_grid_setting'];
  if ( $dw_timeline_post_grid_setting_data ) {
    update_post_meta( $post_id, 'dw-grid', $dw_timeline_post_grid_setting_data );  
  }
}
add_action( 'save_post', 'dw_timeline_post_setting_save_postdata' );

// Add grid value in post class
function dw_timeline_grid_class($classes) {
    global $post;
    $grid_value = get_post_meta( $post->ID, 'dw-grid', true );
    if ( empty($grid_value) ) {
      $grid_value = 'normal';
    }
    $classes[] = 'dwtl ' . $grid_value;
    return $classes;
}
add_filter('post_class', 'dw_timeline_grid_class');

// Ignore Sticky post
function dw_timeline_prepare_posts($query){
  if ( $query->is_home() && $query->is_main_query() ) {
    $query->set( 'ignore_sticky_posts', true );
    $sticky = get_option( 'sticky_posts' );
    $query->set( 'post__not_in', $sticky );
  }
}
add_action( 'pre_get_posts', 'dw_timeline_prepare_posts' );