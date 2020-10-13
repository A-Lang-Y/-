<?php
/**
 * Author 主题文件
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
			<section class="col-md-8" id="mainstay"> 
				<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
  				<div class="article zan-post clearfix">
  					<!-- PC端设备文章显示 -->
  					<section class="visible-md visible-lg">
              <span class="label label-zan"><?php the_category(' '); ?></span>
  						<h3>
  							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
  						</h3>
  						<hr>
              <?php if ( has_post_thumbnail() ) { ?>
              <div class="row">
                <div class="col-md-5">
                  <?php $thumb_img = get_the_post_thumbnail( $post->
                  ID, array(300, 180), array('alt' => trim(strip_tags( $post->post_title )),'title'=> trim(strip_tags( $post->post_title ))) );?>
                  <figure class="thumbnail zan-thumb"><a href="<?php the_permalink() ?>"><?php echo $thumb_img;?></a></figure>  
                </div>            
                <div class="col-md-7 visible-lg zan-outline">         
                  <?php echo mb_strimwidth( strip_tags( apply_filters( 'the_content', $post->post_content ) ), 0, 250,"..." ); ?>
                </div>
                <div class="col-md-7 visible-md zan-outline">         
                  <?php echo mb_strimwidth( strip_tags( apply_filters( 'the_content', $post->post_content ) ), 0, 180,"..." ); ?>
                </div>
              </div>
              <?php } else {?>
                <div class="row">
                  <div class="col-md-12 zan-outline">          
                    <?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 250,"..."); ?>
                  </div>
                </div>       
              <?php } ?>
              <hr>
  						<div class="pull-right post-info">
  							<i class="fa fa-calendar"></i> <?php  the_time('m月j日, Y'); ?>
  							<i class="fa fa-user"></i> <?php the_author_posts_link(); ?>
  							<i class="fa fa-eye"></i> <?php if(function_exists('the_views')) { the_views(); } ?>
                <i class="fa fa-comment"></i> <a href="<?php the_permalink() ?>#comments"><?php comments_number( '0', '1', '%' ); ?></a>
  						</div>
  					</section>
  					<!-- PC端设备文章显示结束 -->
  					<!-- 移动端设备文章显示 -->
  					<section class="visible-xs  visible-sm">
  						<div class="title-article">
  							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
  						</div>
  						<p class="post-info">
  							<i class="fa fa-calendar"></i> <?php the_time('m月j日, Y'); ?>
  							<i class="fa fa-eye"></i> <?php if(function_exists('the_views')) { the_views(); } ?>
  						</p>
  						<div class="content-article">					
  							<?php $thumb_img = get_the_post_thumbnail( $post->
  							ID, array(750, 450), array('alt' => trim(strip_tags( $post->post_title )),'title'=> trim(strip_tags( $post->post_title ))) );?>
  							<figure class="thumbnail"><a href="<?php the_permalink() ?>"><?php echo $thumb_img;?></a></figure>							
  							<div class="well">					
  								<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 150,"..."); ?>
  							</div>
  						</div>
  						<a class="btn btn-zan-line-pp btn-block" href="<?php the_permalink() ?>"  title="详细阅读 <?php the_title(); ?>">阅读全文 <span class="badge"><?php comments_number( '0', '1', '%' ); ?></span></a>
  					</section>
  					<!-- 移动端设备文章显示结束 -->
  				</div>
				<?php endwhile; ?>
        <!-- 分页 -->
        <?php if (function_exists('show_paginate')) { show_paginate(); } ?>
        <!-- 分页 -->
			</section>
			<?php get_sidebar(); ?>
		</section>
	</div>
</section>
<?php get_footer(); ?>
</body>
</html>
