<?php if(has_post_thumbnail()): ?><a href="<?php the_permalink(); ?>"  class="post-thumb-link"><? the_post_thumbnail('post-thumb'); ?></a><?php endif; ?>

<header>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</header>

<?php echo extract_gallery(get_the_content()) ?>

<div class="entry-content">
	<?php the_excerpt(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'site5framework' ), 'after' => '</div>' ) ); ?>
</div>

<?php get_template_part( '/lib/post-formats/content-meta' ); ?>

