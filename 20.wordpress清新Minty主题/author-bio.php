<div class="author-info" itemscope itemtype="http://schema.org/Person">
	<?php echo get_avatar( get_the_author_meta( 'user_email' ), 120 ); ?>
	<div class="author-description">
		<h2 class="author-title" itemprop="name"><?php echo get_the_author(); ?></h2>
		<a class="author-link" href="<?php the_author_meta('user_url'); ?>" rel="author" itemprop="url"><?php the_author_meta('user_url'); ?></a>
		<p class="author-bio" itemprop="description"><?php the_author_meta( 'description' ); ?></p>
	</div>
</div>