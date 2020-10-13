<?php get_header(); ?>

	<main id="main" class="hfeed" role="main" itemscope itemtype="http://schema.org/Blog">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', get_post_format() ); ?>
			
		<?php if ( ! has_post_format( 'status' ) ) : ?>
		<div id="explorer" class="clearfix">
			<?php echo stripslashes(get_option( 'minty_share_code' )); ?>

			<nav id="postination" tole="navigation">
				<span class="previous-post">
				<?php
					$prev_post = get_previous_post();
					if (!empty( $prev_post )) {
						previous_post_link( '%link','<span class="arrow">&lsaquo;</span> 上一篇' );
					} else {
						echo '<span class="arrow">&lsaquo;</span> 上一篇';
					}
				?>
				</span>
				<span class="dot"> &bull; </span>
				<span class="next-post">
				<?php
					$next_post = get_next_post();
					if (!empty( $next_post )) {
						next_post_link( '%link','下一篇 <span class="arrow">&rsaquo;</span>' );
					} else {
						echo '下一篇 <span class="arrow">&rsaquo;</span>';
					}
				?>
				</span>
			</nav>
		</div>
		<?php endif; ?>
	
		<?php get_template_part( 'ad', 'single' ); ?>

		<?php comments_template(); ?>

	<?php endwhile; ?>

	</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>