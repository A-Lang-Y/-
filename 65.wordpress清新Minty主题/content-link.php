<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting">
	<i class="entry-icon"></i>
	
	<header class="entry-header">
		<h1 class="entry-title" itemprop="name headline">
			<a href="<?php echo esc_url( minty_get_link_url() ); ?>" target="_blank"><?php the_title(); ?></a>
		</h1>
		<a href="<?php echo esc_url( minty_get_link_url() ); ?>" target="_blank"><?php echo minty_get_link_url(); ?></a>

		<div class="entry-meta">
			<?php minty_entry_meta(); ?>
		</div>
	</header>
</article>
