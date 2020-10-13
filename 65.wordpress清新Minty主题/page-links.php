<?php
/*
Template Name: Links Page
*/
?>

<?php get_header(); ?>

	<main id="main" class="hfeed" role="main" itemscope itemtype="http://schema.org/Blog">

	<?php while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title" itemprop="name headline"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content" itemprop="articleBody">
				<p class="links-desc"><?php echo get_option('minty_template_links_tagline');?></p>
				<ul id="links" class="blogroll clearfix">
					<?php if ( get_option('minty_template_links_categorize') == true ) : ?>
						<?php wp_list_bookmarks(); ?>
					<?php else : ?>
						<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
					<?php endif; ?>
				</ul>
				<?php the_content(); ?>
			</div>
		</article>

		<?php get_template_part( 'ad', 'single' ); ?>
		<?php comments_template(); ?>

	<?php endwhile; ?>

	</main>
<script>
(function(links){
for (var i = 0; i < links.length; i++) {
	var link = links[i];
	link.parentNode.innerHTML = "<img src='https://www.google.com/s2/favicons?domain=" + link.href + "' width='16' height='16' />" + link.parentNode.innerHTML;
}
})(document.getElementById("links").getElementsByTagName("a"));
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>