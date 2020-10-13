<?php get_header(); ?>

	<main id="main" class="hfeed" role="main" itemscope itemtype="http://schema.org/SearchResultsPage">

		<header class="page-header">
			<h1 class="page-title"><?php printf( '搜索结果：%s', get_search_query() ); ?></h1>
		</header>

		<?php if ( get_option( 'minty_gcse' ) == 1 ) : ?>

<script>
  (function() {
    var cx = '<?php echo get_option( 'minty_gcse_id' ); ?>';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<div class="gcse-searchresults-only"></div>

		<?php else : ?>
	
			<?php if ( have_posts() ) : ?>
	
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
	
				<?php minty_paging_nav(); ?>
	
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		
		<?php endif; ?>

	</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>