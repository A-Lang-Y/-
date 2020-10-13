<?php  
  $class = 'no-cover';
  if ( is_front_page() || is_archive() || is_search() || is_home() ) {
    $class = 'cover';
  }

  if ( is_single() ) {
    $post_thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
    if ( ! empty($post_thumbnail_url) ) {
      $class = 'cover';
      ?>
      <style>
        .banner.cover {
          background-image: url( <?php echo $post_thumbnail_url; ?> );
        }
      </style>
      <?php
    }
  }
?>

<header class="banner <?php echo $class ?>" role="banner">
  <div class="header-inner">
      <nav class="nav-main" role="navigation">
        <div class="container">
        <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
          endif;
        ?>
        </div>
      </nav>
      <?php if( is_front_page() || is_archive() || is_home() ) : ?>
        <hgroup>
          <div class="container">
            <h1 class="page-title">
              <?php echo dw_timeline_title(); ?>
            </h1>
            <h2 class="page-description"><?php bloginfo('description'); ?></h2>
            <button id="get-started" class="btn btn-default btn-coner"><?php echo dw_timeline_get_theme_option('get_start','Get Start Now') ?></button>
          </div>
        </hgroup>
      <?php elseif( is_search() ) : ?>
        <div class="container">
          <h1 class="page-title">
            <?php echo dw_timeline_title(); ?>
          </h1>
        </div>
      <?php endif; ?>
  </div>
</header>
