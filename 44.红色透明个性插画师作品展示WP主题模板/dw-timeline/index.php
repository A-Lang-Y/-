<div class="timeline two-col">
  <div data-page="1" class="timeline-pale dwtl full"><span><?php _e('Page 1','dw-timeline') ?></span></div>
  <?php if ( have_posts() ): ?>
    <?php  
      $pages = $wp_query->max_num_pages;
      if( $pages > 1 ) {
        $i = 1;
        echo '<div class="timeline-scrubber">';
        echo '<ul>';
        for ( $i=1 ; $i <= $pages; $i++) { 
          echo '<li ';
          if( $i == 1 ) {
            echo ' class="active" ';
          }
          echo ' data-page="'.$i.'"><a href="#" >'.__('Page','dw-timeline').' '.$i.'</a></li>';
        }
        echo '</ul>';
        echo '</div>';
      }
    ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('templates/content', get_post_format()); ?>
    <?php endwhile; ?>

    <?php if ($wp_query->max_num_pages > 1) : ?>
      <nav class="post-nav">
        <ul class="pager">
          <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'dw-timeline')); ?></li>
          <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'dw-timeline')); ?></li>
        </ul>
      </nav>
    <?php endif; ?>
  <?php else: ?>
    <?php get_template_part('templates/content', 'none'); ?>
  <?php endif ?>
</div>