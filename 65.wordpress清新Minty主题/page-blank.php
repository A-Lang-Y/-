<?php
/*
Template Name: Blank Page
*/
?>

<?php get_header(); ?>
	
	<main id="main" class="hfeed" role="main" itemscope itemtype="http://schema.org/WebPage">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>
	
	<?php endwhile; ?>

	</main>

<?php get_footer(); ?>