<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/VideoObject">
	<?php if ( !is_single() ) : ?>
	<div class="entry-media" itemprop="articleBody">
		<?php the_content(''); ?>
	</div>
	<?php endif; ?>

	<i class="entry-icon"></i>
	
	<header class="entry-header">
		<?php if ( is_single() ) : ?>
		<h1 class="entry-title" itemprop="name headline"><?php the_title(); ?></h1>
		<?php else : ?>
		<h2 class="entry-title" itemprop="name headline">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<?php endif; ?>

		<div class="entry-meta">
			<?php minty_entry_meta(); ?>
		</div>
	</header>

	<?php if ( is_single() ) : ?>
	<div class="entry-media" itemprop="articleBody">
		<?php the_content(''); ?>
	</div>

	<footer class="entry-footer">
		<?php minty_single_footer(); ?>
	</footer>

	<?php endif; ?>
</article>
