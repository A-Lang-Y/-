<?php
/**
 * Page 主题文件
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 3.0.0
 */
?>

<?php get_header(); ?>
<section id="zan-bodyer">
	<div class="container">
		<section class="row">
			<div class="col-md-8">
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
					<article class="article zan-post">
						<!-- 面包屑 -->
						<div class="breadcrumb">
						    <?php 
						    	if( function_exists( 'bcn_display' ) ) {
					        	echo '<i class="fa fa-map-marker"></i> ';
					        	bcn_display();
						    	}
						    ?>
						</div>	
						<!-- 面包屑结束 -->
						<p><?php the_content(); ?></p>
					</article>
				<?php endwhile; ?>
			</div>
			<?php get_sidebar(); ?>
		</section>
	</div>
</section>
<?php get_footer(); ?>
</body>
</html>