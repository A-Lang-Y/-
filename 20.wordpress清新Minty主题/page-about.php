<?php
/*
Template Name: About Page
*/
?>

<?php get_header(); ?>
	
	<main id="main" class="hfeed" role="main" itemscope itemtype="http://schema.org/AboutPage">

	<?php while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title" itemprop="name headline"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content" itemprop="articleBody">
				<?php the_content(); ?>
			</div>
		</article>

		<?php get_template_part( 'ad', 'single' ); ?>
		<?php comments_template(); ?>
	
	<?php endwhile; ?>

	</main>

	<?php
	$mblogShowCode = get_option('minty_template_mblogshow');
	if ( empty($mblogShowCode) ) {
		get_sidebar();
	} else {
	?>
	<div id="sidebar" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
		<?php echo stripslashes($mblogShowCode); ?>
	</div>
	<?php }; ?>

<?php get_footer(); ?>