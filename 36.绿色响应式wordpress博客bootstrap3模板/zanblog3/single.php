<?php
/**
 * Single 主题文件
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 3.0.0
 */
?>

<?php get_header(); ?>
<div id="zan-bodyer">
	<div class="container">
		<section class="row">
			<div class="col-md-8">
				<!-- 广告 -->
        <?php if ( get_option( 'zan_single_top_ad' ) ) : ?>
        <div class="ad hidden-xs">
          <?php echo stripslashes( get_option( 'zan_single_top_ad' ) ); ?>
        </div>
        <?php endif; ?>
        <!-- 广告结束 -->	
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
				<article class="zan-article">
					<!-- 面包屑 -->
					<div class="breadcrumb">
					    <?php 
					    	if(function_exists( 'bcn_display' ) ) {
				        	echo '<i class="fa fa-map-marker"></i> ';
				        	bcn_display();
					    	}
					    ?>
					</div>
					<!-- 面包屑结束 -->
					<!-- 大型设备文章显示 -->
					<div class="hidden-xs">
						<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
						<p class="post-big-info">
	            <span class="label label-zan"><i class="fa fa-calendar"></i> <?php the_time( 'm月j日, Y' ); ?></span>
							<span class="label label-zan"><i class="fa fa-tags"></i> <?php the_category(' '); ?></span>
							<span class="label label-zan"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span>
							<span class="label label-zan"><i class="fa fa-eye"></i> <?php if( function_exists( 'the_views' ) ) { the_views(); } ?></span>
						</p>
					</div>
					<!-- 大型设备文章显示结束 -->
					<!-- 小型设备文章显示 -->
					<div class="visible-xs">
						<div class="title-article">
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
						</div>
						<p class="post-info">
							<span><i class="fa fa-calendar"></i> <?php the_time( 'm月j日, Y' ); ?></span>
							<span><i class="fa fa-eye"></i> <?php if( function_exists( 'the_views' ) ) { the_views(); } ?></span>
						</p>
					</div>
					<!-- 小型设备文章显示结束 -->
					<?php $thumb_img = get_the_post_thumbnail( $post->
					ID, array( 750, 450 ), array('alt' => trim( strip_tags( $post->post_title ) ),'title'=> trim( strip_tags( $post->post_title ) ) ) );?>
					<figure class="thumbnail zan-thumb"><?php echo $thumb_img;?></figure>
          <article class="zan-single-content">				                 
						<?php the_content(); ?>
          </article>
	        <!-- 百度分享 -->
	        <div class="zan-share clearfix">
		        <div class="bdsharebuttonbox pull-right">
		        	<a href="#" class="bds_more" data-cmd="more"></a>
		        	<a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
		        	<a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
		        	<a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
		        	<a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
		        	<a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
		        </div>
		      </div>
					<!-- 百度分享结束 -->
					<!-- 文章版权信息 -->
					<div class="copyright well">
						<p>
							版权属于:
							<?php
								if( get_post_meta( $post->ID, "版权属于:", true ) ) {
									echo get_post_meta( $post->ID, "版权属于:", true );
								}else {
									echo '<a href="http://www.yeahzan.com" target="_blank">佚站互联</a> - <a href="http://www.yeahzan.com" target="_blank">杭州网站建设</a>';
								}
							?>
						</p>
						<p>
							原文地址:
							<?php
								if( get_post_meta( $post->ID, "原文地址:", true ) ) {
									echo get_post_meta( $post->ID, "原文地址:", true );
								} else {
									echo '<a href="';
									echo the_permalink().'">';
									echo the_permalink().'</a>';
								}
							?>
						<p>转载时必须以链接形式注明原始出处及本声明。</p>
					</div>
					<!-- 文章版权信息结束 -->
          <!-- 分页 -->
          <div clas="zan-page">
            <ul class="pager">
              <li class="previous"><?php previous_post_link( '%link', '<i class="fa fa-angle-left"></i> 上一篇', TRUE ); ?></li>
              <li class="next"><?php next_post_link( '%link', '下一篇 <i class="fa fa-angle-right"></i>', TRUE ); ?></li>
            </ul>
          </div>
          <!-- 分页结束 -->
				</article>
				<?php endwhile; ?>
				<!-- 广告 -->
        <?php if ( get_option( 'zan_single_down_ad' ) ) : ?>
        <div class="ad hidden-xs">
          <?php echo stripslashes( get_option( 'zan_single_down_ad' ) ); ?>
        </div>
        <?php endif; ?>
        <!-- 广告结束 -->
				<!-- 相关文章 -->
        <div class="visible-md visible-lg" id="post-related">
        	<div id="related-title"><i class="fa fa-share-alt"></i> 相关推荐</div>
					<div class="row">
						<?php
							global $post;
							$cats = wp_get_post_categories( $post->ID );

							if ( $cats ) {
								$args = array(
												'category__in' => array( $cats[0] ),
												'post__not_in' => array( $post->ID ),
												'showposts' => 6,
								);
								query_posts( $args );

								if ( have_posts() ) {
									while ( have_posts() ) {
										the_post(); update_post_caches( $posts ); ?>
										<div class="col-md-4">
				              <div class="thumbnail">
				                <div class="caption">
													<p class="post-related-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
													<p class="post-related-content"><?php echo mb_strimwidth( strip_tags( apply_filters( 'the_content', $post->post_content ) ), 0, 150, "..." ); ?></p>
												</div>
				              </div>					                
				            </div>
										<?php
									}
								} 
								wp_reset_query(); 
							}
						?>
					</div>
				</div>
				<!-- 相关文章结束 -->
				<?php comments_template(); ?>								
			</div>
			<?php get_sidebar(); ?>
		</section>
	</div>
</div>
<?php get_footer(); ?>
<script type="text/javascript">
  jQuery( '#commentform' ).validate(
  {
    rules: {
      author: {
        required: true,
      },
      email: {
        required: true,
        email: true
      },
      url: {
        url:true
      },
      comment: {
        required: true,
      }
    },
    messages: {
      author: {
        required: "用户名不能为空！"
      },
      email: {
        required: "邮箱不能为空！",
        email: "输入的邮箱格式不正确！"
      },
      url: {
        url: "输入的网址不正确！"
      },
      comment: {
        required: "留言内容不能为空！"
      }
    }
  } );
</script>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
</body>
</html>