<?php
/**
 * Enqueue scripts and stylesheets
 */
function dw_timeline_scripts() {
  wp_enqueue_style('dw_timeline_main', get_template_directory_uri() . '/assets/css/main.css', false, '6c39f42987ae297a5a21e2bb35bf3402');

  wp_enqueue_style( 'dw_timeline_style', get_stylesheet_uri(), false, 'c1a58eb4baaf24c3771085df3d54ff8d' );

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.7.0.min.js', false, null, false);
  wp_enqueue_script('jquery');
  wp_enqueue_script('nivo_lightbox', get_template_directory_uri() . '/assets/js/vendor/nivo-lightbox.min.js', false, null, false);
  wp_enqueue_script('infinitescroll', get_template_directory_uri() . '/assets/js/vendor/jquery.infinitescroll.min.js', false, '', true);
  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/vendor/bootstrap-3.0.3.min.js', false, '', true);
  wp_enqueue_script('dw_timeline_scripts', get_template_directory_uri() . '/assets/js/scripts.js', false, '', true);
  wp_localize_script( 'dw_timeline_scripts', 'dwtl', array(
    'template_directory_uri' => get_template_directory_uri()
  ) );
  wp_localize_script( 'dw_timeline_scripts', 'infinitescroll', array(
    'page' => __('page','dw-timeline'),
    'the_end' => __('the end','dw-timeline'),
  ) );
}
add_action('wp_enqueue_scripts', 'dw_timeline_scripts', 100);