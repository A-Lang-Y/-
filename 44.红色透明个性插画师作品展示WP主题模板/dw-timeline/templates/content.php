<article data-page="<?php $page = get_query_var('paged'); echo  $page ? $page : 1; ?>" <?php post_class(); ?>>
  <div class="entry-inner">
    <?php if(has_post_thumbnail()) : ?>
    <div class="entry-thumbnail">
      <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
    </div>
    <?php endif; ?>
    <div class="entry-format"><?php echo get_post_format_string(get_post_format()); ?></div>
    <header>
      <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php the_content( __('Continue Reading &rarr;', 'dw-timeline') ); ?>
    </div>
  </div>
</article>
