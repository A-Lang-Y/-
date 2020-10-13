<header>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</header>

<div class="entry-quote">
	<blockquote><?php echo get_post_meta($post->ID, SN.'quote_post', true); ?></blockquote>

	<span class="quote-author">~ <?php echo get_post_meta($post->ID, SN.'quote_author', true); ?> ~</span>
</div>

<div class="entry-content">
	<?php the_excerpt(); ?>
</div>

<?php get_template_part( '/lib/post-formats/content-meta' ); ?>