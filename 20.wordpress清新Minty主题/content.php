<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting">
	<?php $featuredImageType = get_option('minty_featured_image_type', 'banner'); ?>

	<?php if ($featuredImageType == 'banner') minty_post_cover(); ?>

	<?php if ($featuredImageType == 'thumb' && !is_single()) { echo minty_post_thumb(); echo '<div class="entry-body">'; } ?>

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
	<?php get_template_part('ad', 'single-title'); ?>
	<div class="entry-content" itemprop="articleBody">
		<?php if ($featuredImageType == 'banner-below') minty_post_cover(); ?>
		<?php the_content( '' ); ?>
		<?php wp_link_pages(); ?>
		<?php get_template_part('ad', 'single-footer'); ?>
	</div>
	<?php else : ?>
	<div class="entry-summary" itemprop="articleBody">
		<?php if ($featuredImageType == 'banner-below') minty_post_cover(); ?>
		<?php ((is_search() &&  get_option( 'minty_search_use_excerpt', 1 ) == 1) || get_option( 'minty_use_excerpt', 0 ) == 1) ? the_excerpt() : the_content( '' ); ?>
	</div>
	<?php endif; ?>

	<?php if ( !is_search() ) : ?>
	<footer class="entry-footer">
		<?php if ( !is_single() ) : ?>
			<a href="<?php the_permalink(); ?>" rel="nofollow" class="more-link">继续阅读 &raquo;</a>
		<?php endif; ?>
		<?php $tag_list = get_the_tag_list();
		if ( $tag_list ) {
			echo '<span class="tags-links" itemprop="keywords">' . $tag_list . '</span>';
		}; ?>
		<?php minty_single_footer(); ?>
	</footer>
	<?php endif; ?>

	<?php if ($featuredImageType == 'thumb' && !is_single()) echo '</div>'; ?>
</article>
