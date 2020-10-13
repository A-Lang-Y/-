<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">
	<i class="entry-icon"></i>

	<div class="entry-content" itemprop="articleBody">
		<?php the_content(''); ?>
	</div>
	
	<footer class="entry-meta">
		<?php minty_entry_meta(); ?>
	</footer>
</article>