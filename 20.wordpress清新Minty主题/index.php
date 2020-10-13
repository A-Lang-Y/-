<?php get_header(); ?>

	<main id="main" class="hfeed" role="main" itemscope itemtype="http://schema.org/Blog">

		<?php if (is_home() && get_option('minty_featured_content_position') == 'main') minty_featured_content(); ?>

		<?php if ( have_posts() ) : ?>

			<?php $count = 1; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php if ( $count++ == 1 ) get_template_part('ad', 'index'); ?>
			<?php endwhile; ?>

			<?php minty_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
	</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>