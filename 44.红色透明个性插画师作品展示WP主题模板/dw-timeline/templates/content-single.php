<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'dw-timeline'), 'after' => '</p></nav>')); ?>
    </div>
    <footer>
      <?php
        $tags_list = get_the_tag_list( '', __( ', ', 'dw-timeline' ) );
        if ( $tags_list ) :
      ?>
        <div class="entry-tags">
          <span class="tags-title"><?php _e('Tags: ','dw-timeline') ?></span>
          <span class="tags-links">
          <?php printf( __( '%1$s', 'dw-timeline' ), $tags_list ); ?>
        </span>
        </div>
      <?php endif; ?>
    </footer>
  </article>
  <?php comments_template('/templates/comments.php'); ?>
<?php endwhile; ?>
