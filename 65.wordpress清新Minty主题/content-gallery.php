<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/ImageGallery">
	<?php if ( !is_single() ) : ?>
	<div class="entry-media" itemprop="articleBody">
		<?php if ( ! get_post_gallery() ) : ?>
			<a href="<?php the_permalink(); ?>"><img src="<?php echo minty_get_first_img(); ?>" alt="" /></a>
		<?php else : ?>
			<?php echo get_post_gallery(); ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<i class="entry-icon"></i>

	<header class="entry-header">
		<?php if ( is_single() ) : ?>
		<h1 class="entry-title" itemprop="name headline"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title" itemprop="name headline">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php endif; ?>

		<div class="entry-meta">
			<?php minty_entry_meta(); ?>
		</div>
	</header>

	<?php if ( is_single() ) : ?>
	<div class="entry-content" itemprop="articleBody">
		<?php if ( ! get_post_gallery() ) : ?>
			<?php the_content( '' ); ?>
			<?php wp_link_pages(); ?>
		<?php else : ?>
			<?php echo get_post_gallery(); ?>
		<?php endif; ?>
	</div>

	<footer class="entry-footer">
		<?php minty_single_footer(); ?>
	</footer>

	<?php endif; ?>
</article>
