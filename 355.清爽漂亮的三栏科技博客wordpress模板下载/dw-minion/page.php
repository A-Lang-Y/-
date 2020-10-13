<?php get_header(); ?>
<div id="primary" class="content-area">
	<div class="primary-inner">
		<div id="content" class="site-content" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
			<?php if ( comments_open() ) comments_template(); ?>
		<?php endwhile; ?>
		</div>
	</div>
</div>
<?php get_sidebar('secondary'); ?>
<?php get_footer(); ?>