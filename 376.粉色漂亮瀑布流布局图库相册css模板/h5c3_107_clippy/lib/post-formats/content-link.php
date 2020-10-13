<header>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</header>

<div class="entry-link">
	<h3><a href="<?php echo get_post_meta($post->ID, SN.'link_post_url', true); ?>"><?php echo get_post_meta($post->ID, SN.'link_post_description', true); ?></a></h3>
</div>

<div class="entry-content">
	<?php the_excerpt(); ?>
</div>

<?php get_template_part( '/lib/post-formats/content-meta' ); ?>