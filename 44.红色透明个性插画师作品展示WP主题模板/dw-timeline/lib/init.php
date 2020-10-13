<?php
/**
 *  DW Timeline initial setup and constants
 */
function dw_timeline_setup() {
  // Make theme available for translation
  load_theme_textdomain('dw-timeline', get_template_directory() . '/lang');

  // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'dw-timeline'),
  ));

  // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
  add_theme_support('post-thumbnails');
  // set_post_thumbnail_size(150, 150, false);
  // add_image_size('category-thumb', 300, 9999); // 300px wide (and unlimited height)

  // Add post formats (http://codex.wordpress.org/Post_Formats)
  add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

  // Tell the TinyMCE editor to use a custom stylesheet
  add_editor_style('/assets/css/editor-style.css');

  // This feature enables post and comment RSS feed links to head
  add_theme_support( 'automatic-feed-links' );
}
add_action('after_setup_theme', 'dw_timeline_setup');

// Backwards compatibility for older than PHP 5.3.0
if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }
