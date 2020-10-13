<?php
/**
 * Cleaner walker for wp_nav_menu()
 *
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *   <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9"><a href="/sample-page/">Sample Page</a></l
 *
 * dw_timeline_Nav_Walker example output:
 *   <li class="menu-home"><a href="/">Home</a></li>
 *   <li class="menu-sample-page"><a href="/sample-page/">Sample Page</a></li>
 */
class dw_timeline_Nav_Walker extends Walker_Nav_Menu {
  function check_current($classes) {
    return preg_match('/(current[-_])|active|dropdown/', $classes);
  }

  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $item_html = '';
    parent::start_el($item_html, $item, $depth, $args);

    if ( $item->is_dropdown && $depth === 0 ) {
      $item_html = str_replace('</a>', '<span class="glyphicon glyphicon-chevron-down"></span></a>', $item_html);
    } elseif ( $item->is_dropdown && $depth > 0 ) {
      $item_html = str_replace('</a>', '<span class="glyphicon glyphicon-chevron-right"></span></a>', $item_html);
    }

    $item_html = apply_filters('dw_timeline_wp_nav_menu_item', $item_html);
    $output .= $item_html;
  }

  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    $element->is_dropdown = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

    if ($element->is_dropdown) {
      $element->classes[] = 'has-submenu';
    }

    parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }
}

/**
 * Remove the id="" on nav menu items
 * Return 'menu-slug' for nav menu classes
 */
function dw_timeline_nav_menu_css_class($classes, $item) {
  $slug = sanitize_title($item->title);
  $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);
  $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

  $classes[] = 'menu-' . $slug;

  $classes = array_unique($classes);

  return array_filter($classes, 'dw_timeline_is_element_empty');
}
add_filter('nav_menu_css_class', 'dw_timeline_nav_menu_css_class', 10, 2);
add_filter('nav_menu_item_id', '__return_null');

/**
 * Clean up wp_nav_menu_args
 *
 * Remove the container
 * Use dw_timeline_Nav_Walker() by default
 */
function dw_timeline_nav_menu_args($args = '') {
  $dw_timeline_nav_menu_args['container'] = false;

  if (!$args['items_wrap']) {
    $dw_timeline_nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
  }

  if (!$args['walker']) {
    $dw_timeline_nav_menu_args['walker'] = new dw_timeline_Nav_Walker();
  }

  return array_merge($args, $dw_timeline_nav_menu_args);
}
add_filter('wp_nav_menu_args', 'dw_timeline_nav_menu_args');

function dw_timeline_is_element_empty($element) {
  $element = trim($element);
  return empty($element) ? false : true;
}