<?php
/**
 * Get Theme options
 */
function dw_minion_get_theme_option( $option_name, $default = '' ) {
  $options = get_option( 'dw_minion_theme_options' );
  if( isset($options[$option_name]) ) {
    return $options[$option_name];
  }
  return $default; 
}

/**
 * Site Layout
 */
function dw_minion_site_layout() {
  if (dw_minion_get_theme_option('layout', 'left') == 1) {
    ?>
    <style type="text/css" id="minion_layout" media="screen">
    .container {margin: 0 auto;}
    </style>
    <?php
  }
}
add_filter('wp_head','dw_minion_site_layout');

/**
 * Body Custom classes
 */
function dw_minion_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	return $classes;
}
add_filter( 'body_class', 'dw_minion_body_classes' );

/**
 * Change Favicon
 */
function dw_minion_favicon() {
  $favicon = dw_minion_get_theme_option('favicon');
  if($favicon)
    echo '<link type="image/x-icon" href="'.$favicon.'" rel="shortcut icon">';
}
add_action( 'wp_head', 'dw_minion_favicon' );

/**
 * Site Title
 */
function dw_minion_wp_title( $title, $sep ) {
	global $page, $paged;
	if ( is_feed() )
		return $title;
	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'dw-minion' ), max( $paged, $page ) );
	return $title;
}
add_filter( 'wp_title', 'dw_minion_wp_title', 10, 2 );

/**
 * Display Logo
 */
function dw_minion_logo() {
  $header_display = (dw_minion_get_theme_option( 'header_display', 'site_title') == 'site_title') ? 'display-title' : 'display-logo';
  $logo = dw_minion_get_theme_option( 'logo' );
  $tagline = get_bloginfo( 'description' );
  $about = dw_minion_get_theme_option( 'about', get_bloginfo( 'description' ) );
  echo '<h1 class="site-title '.$header_display.'"><a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">';
  if ($header_display == 'display-logo') {
    echo '<img alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" src="'.$logo.'" />';
  } else {
    echo get_bloginfo( 'name' );
  }
  echo '</a></h1>';
  if($tagline)
    echo '<p class="site-subtitle">'.$tagline.'</p>';
  if($about)
    echo '<h2 class="site-description">'.$about.'</h2>';
}

/**
 * Header Code
 */
function dw_minion_custom_header_code() {
  echo dw_minion_get_theme_option( 'header_code' );
}
add_action('wp_head', 'dw_minion_custom_header_code');

/**
 * Footer Code
 */
function dw_minion_custom_footer_code() {
  echo dw_minion_get_theme_option( 'footer_code' );
}
add_action('wp_footer', 'dw_minion_custom_footer_code');

/**
 * Left Sidebar Color
 */
function dw_minion_leftbar_color() {
  $leftbar_bgcolor      = dw_minion_get_theme_option('leftbar_bgcolor');
  $leftbar_bghovercolor = dw_minion_get_theme_option('leftbar_bghovercolor');
  $leftbar_color        = dw_minion_get_theme_option('leftbar_color');
  $leftbar_hovercolor   = dw_minion_get_theme_option('leftbar_hovercolor');
  $leftbar_bordercolor  = dw_minion_get_theme_option('leftbar_bordercolor');
  if($leftbar_bgcolor || $leftbar_bghovercolor || $leftbar_color || $leftbar_hovercolor || $leftbar_bordercolor) { ?>
    <style type="text/css" id="minion_leftbar_color" media="screen">
      .show-nav .show-site-nav i,.action.search label,.site-actions i {
        color: <?php echo $leftbar_color ?>;
      }
      .site-actions,.show-nav .show-site-nav i,.action.search label,.site-actions i {
        background: <?php echo $leftbar_bgcolor ?>;
      }
      .no-touch .site-actions .social:hover i,.back-top:hover i,.no-touch .action.search:hover label,.action.search.active label,.action.search .search-query {
        color: <?php echo $leftbar_hovercolor ?>;
      }
      .no-touch .site-actions .social:hover i,.back-top:hover i,.no-touch .action.search:hover label,.action.search.active label,.action.search .search-query {
        background: <?php echo $leftbar_bghovercolor ?>;
      }
      @media (min-width: 768px) {
        .site-actions,.site-actions .actions>.back-top {
          border-top: 1px solid <?php echo $leftbar_bordercolor ?>;
        }
        .social,.site-actions .actions > .action,.show-site-nav {
          border-bottom: 1px solid <?php echo $leftbar_bordercolor ?>;
        }
        .pager .nav-next a:hover .btn, .pager .nav-previous a:hover .btn {
          background: <?php echo $leftbar_bordercolor ?>;
        }
      }
    </style>
    <?php
  }
}
add_filter('wp_head','dw_minion_leftbar_color');

/**
 * Color Selector
 */
function dw_minion_typo_color() {
  if ( dw_minion_get_theme_option('custom-color') != '' ) {
    $minion_color = dw_minion_get_theme_option('custom-color');
  } else {
    $minion_color = dw_minion_get_theme_option('select-color'); 
  } 
  if($minion_color) { ?>
    <style type="text/css" id="minion_color" media="screen">
      .btn:hover,#nav-below .btn:hover,.accordion-heading .accordion-toggle,.nav-tabs > li > a:hover, .nav-tabs > li > a:focus,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.pager .pager-title .nav-next a:hover .btn, .pager .pager-title .nav-previous a:hover .btn, .entry-footer .entry-tags .tags-links a:hover,#cancel-comment-reply-link:hover,#commentform #submit,.post-password-required .entry-content input[type="submit"]:hover,blockquote p {
        background-color: <?php echo $minion_color; ?>;
      }
      a:hover,.btn-link:hover,.btn-link:focus,.comment-list .comment-datetime:hover,.comment-list .comment-edit-link:hover,.entry-meta a, .entry-meta .posted-on a:hover, .entry-meta .comments-link a:hover,.format-link .entry-content a,.format-quote .bq-meta a,.widget_nav_menu .current_page_item > a, .widget_nav_menu .current-menu-item > a,[class*="widget_recent_comments"] .url,.dw_twitter .tweet-content a {
        color: <?php echo $minion_color; ?>;
      }
      .nav-tabs > .active > a:before,blockquote cite:before {
        border-top: 6px solid <?php echo $minion_color; ?>;
      }
    </style>
    <?php
  }
}
add_filter('wp_head','dw_minion_typo_color');

/**
 * Font Selector
 */
function dw_minion_typo_font(){
  if (dw_minion_get_theme_option('heading_font') && dw_minion_get_theme_option('heading_font') != '') {
    $heading_font = explode(':dw:', dw_minion_get_theme_option('heading_font') );
    ?>
      <style type="text/css" id="heading_font" media="screen">
        @font-face {
          font-family: "<?php echo $heading_font[0]; ?>";
          src: url('<?php echo $heading_font[1] ?>');
        } 
        h1,h2,h3,h4,h5,h6 {
          font-family: "<?php echo $heading_font[0]; ?>";
        }
      </style>
    <?php
  }
  if (dw_minion_get_theme_option( 'body_font') && dw_minion_get_theme_option( 'body_font') != '') {
    $body_font = explode( ':dw:', dw_minion_get_theme_option( 'body_font' ));
    ?>
      <style type="text/css" id="body_font" media="screen">
        @font-face {
          font-family: "<?php echo $body_font[0]; ?>";
          src: url('<?php echo $body_font[1] ?>');
        } 
        body,.entry-content,.page-content,.site-description,.entry-meta .byline, .entry-meta .cat-links {
          font-family: "<?php echo $body_font[0]; ?>";
        }
      </style>
    <?php
  }
  if (dw_minion_get_theme_option( 'article_font_size') && dw_minion_get_theme_option( 'article_font_size') != '') {
    ?>
    <style type="text/css" id="article_font-size" media="screen">
        .entry-content, .page-content {
          font-size: <?php echo dw_minion_get_theme_option( 'article_font_size' ).'px'; ?>;
        }
      </style>
    <?php
  }
}
add_filter('wp_head','dw_minion_typo_font');

if( ! function_exists('dw_get_gfonts') ) {
  function dw_get_gfonts(){
    $fontsSeraliazed = wp_remote_fopen( get_template_directory_uri() . '/inc/font/gfonts_v2.txt' );
    $fontArray = unserialize( $fontsSeraliazed );
    return $fontArray->items;
  }
}

/**
 * Site Actions
 */
add_action('after_navigation', 'dw_minion_site_actions');
function dw_minion_site_actions() {
  $social_links['facebook'] = dw_minion_get_theme_option( 'facebook', '' );
  $social_links['twitter'] = dw_minion_get_theme_option( 'twitter', '' );
  $social_links['google_plus'] = dw_minion_get_theme_option( 'google_plus', '' );
  $social_links['youtube'] = dw_minion_get_theme_option( 'youtube', '' );
  $social_links['linkedin'] = dw_minion_get_theme_option( 'linkedin', '' );
  ?>
  <div id="actions" class="site-actions clearfix">
      <div class="action show-site-nav">
          <i class="icon-reorder"></i>
      </div>
      <div class="clearfix actions">
          <div class="action search">
              <form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="action searchform">
                  <input type="text" placeholder="Search" id="s" name="s" class="search-query">
                  <label for="s"></label>
              </form>
          </div>
          <a class="back-top action" href="#page"><i class="icon-chevron-up"></i></a>
          <?php ?>
          <div class="action socials">
              <i class="icon-link active-socials"></i>
              <?php if(count($social_links) > 0 ) { ?><ul class="unstyled list-socials clearfix" style="width: <?php echo count($social_links)*40; ?>px;">
                  <?php if($social_links['facebook']!='') { ?><li class="social"><a href="<?php echo $social_links['facebook']; ?>"><i class="icon-facebook"></i></a></li><?php } ?>
                  <?php if($social_links['twitter']!='') { ?><li class="social"><a href="<?php echo $social_links['twitter']; ?>"><i class="icon-twitter"></i></a></li><?php } ?>
                  <?php if($social_links['google_plus']!='') { ?><li class="social"><a href="<?php echo $social_links['google_plus']; ?>"><i class="icon-google-plus"></i></a></li><?php } ?>
                  <?php if($social_links['youtube']!='') { ?><li class="social"><a href="<?php echo $social_links['youtube']; ?>"><i class="icon-youtube"></i></a></li><?php } ?>
                  <?php if($social_links['linkedin']!='') { ?><li class="social"><a href="<?php echo $social_links['linkedin']; ?>"><i class="icon-linkedin"></i></a></li><?php } ?>
              </ul><?php } ?>
          </div>
      </div>
  </div>
  <?php 
}

/**
 * Display gallery as carousel
 */
add_filter( 'post_gallery', 'dw_minion_post_gallery', 10, 2 );
function dw_minion_post_gallery( $output, $attr) {
  global $post, $wp_locale;
  static $instance = 0;
  $instance++;
  if ( isset( $attr['orderby'] ) ) {
      $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
      if ( !$attr['orderby'] )
          unset( $attr['orderby'] );
  }
  extract(shortcode_atts(array(
      'order'      => 'ASC',
      'orderby'    => 'menu_order ID',
      'id'         => $post->ID,
      'itemtag'    => 'div',
      'icontag'    => 'div',
      'captiontag' => 'div',
      'columns'    => 3,
      'size'       => array(620,350),
      'include'    => '',
      'exclude'    => ''
  ), $attr));
  $id = intval($id);
  if ( 'RAND' == $order )
      $orderby = 'none';
  if ( !empty($include) ) {
      $include = preg_replace( '/[^0-9,]+/', '', $include );
      $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
      $attachments = array();
      foreach ( $_attachments as $key => $val ) {
          $attachments[$val->ID] = $_attachments[$key];
      }
  } elseif ( !empty($exclude) ) {
      $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
      $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
      $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }
  if ( empty($attachments) )
      return '';
  if ( is_feed() ) {
      $output = "\n";
      foreach ( $attachments as $att_id => $attachment )
          $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
      return $output;
  }
	$itemtag = tag_escape($itemtag);
	$selector = "carousel-{$instance}";
	$captiontag = tag_escape($captiontag);
  $output = "<div class='entry-gallery'>";
	$output .= "<div id='{$selector}' class='carousel slide carousel-{$id}'>";
	$output .= "<ol class='carousel-indicators'>";
	$j = 0;
  foreach ( $attachments as $id => $attachment ) {
  	$itemclass = ($j==0) ? 'active' : '';
  	$output .= "<li class='{$itemclass}' data-slide-to='{$j}' data-target='#{$selector}'></li>";
  	$j++;
  }
  $output .= "</ol>";
	$i = 0;
  $output .= "<div class='carousel-inner'>";
  foreach ( $attachments as $id => $attachment ) {
  	$itemclass = ($i==0) ? 'item active' : 'item';
  	$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
  	$output .= "<{$itemtag} class='{$itemclass}'>";
  	$output .= "
      <{$icontag} class='carousel-icon'>
        $link
      </{$icontag}>";
  	if ( $captiontag && trim($attachment->post_excerpt) ) {
      $output .= "
        <{$captiontag} class='carousel-caption'>
        " . wptexturize($attachment->post_excerpt) . "
        </{$captiontag}>";
    }
  	$output .= "</{$itemtag}>";
  	$i++;
  }
  $output .= "</div>";
  $output .= "<a data-slide='prev' href='#{$selector}' class='carousel-control left'><i class='icon-chevron-left'></i></a>";
  $output .= "<a data-slide='next' href='#{$selector}' class='carousel-control right'><i class='icon-chevron-right'></i></a>";
  $output .= "</div>";
  $output .= "</div>";
  return $output;
}

/**
 * Remove #more Anchor from Permalinks
 */
add_filter('the_content_more_link', 'remove_more_jump_link');
function remove_more_jump_link($link) { 
  $offset = strpos($link, '#more-');
  if ($offset) { $end = strpos($link, '"',$offset); }
  if ($end) { $link = substr_replace($link, '', $offset, $end-$offset); }
  return $link;
}