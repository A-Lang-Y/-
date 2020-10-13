<?php get_header(); ?>

	<main id="main" class="hfeed" role="main" itemscope itemtype="http://schema.org/Blog">

		<header class="page-header">
			<h1 class="page-title"><?php if ( is_category() ) {
				echo '分类归档：' . single_cat_title('', false);
			} elseif ( is_tag() ) {
				echo '标签归档：' . single_tag_title('', false);
			} elseif ( is_day() ) {
				echo '日度归档：' . get_the_date('Y年n月j日');
			} elseif ( is_month() ) {
				echo '月度归档：' . get_the_date('Y年n月');
			} elseif ( is_year() ) {
				echo '年度归档：' . get_the_date('Y年');
			} elseif ( is_author() ) {
				if ( have_posts() ) {
					the_post();
					echo '作者归档：' . get_the_author();
					rewind_posts();
				}
			} else {
				echo '文章归档';
			}
			?></h1>
		</header>
		
		<?php if ( is_author() && get_the_author_meta( 'description' ) ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php minty_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>