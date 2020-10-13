<?php
/**
 * Tag 主题文件
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
        <!-- 面包屑 -->
        <div class="breadcrumb clearfix" id="zan-breadcrumb">
          <?php 
            if( function_exists( 'bcn_display' ) ) {
              echo '<i class="fa fa-map-marker"></i> ';
              bcn_display();
            }
          ?>
        </div>
        <!-- 面包屑结束 -->
        <div class="zan-post-th tab-pane">
          <div class="row">
            <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <div class="col-sm-6">
              <div class="post-th">
                  <?php $thumb_img = get_the_post_thumbnail( $post->
                  ID, array( 400, 240 ), array( 'alt' => trim( strip_tags( $post->post_title ) ),'class'=> '','title'=> trim( strip_tags( $post->post_title ) ) ) );?>
                  <figure class="thumbnail zan-thumb">
                    <a href="<?php the_permalink() ?>"><?php echo $thumb_img;?></a>
                  </figure>
                  <div class="title">
                    <a title="<?php the_title(); ?>" href="<?php the_permalink() ?>">
                      <?php echo mb_strimwidth( strip_tags( apply_filters( 'the_title', $post->post_title ) ), 0, 30, "..." ); ?>
                    </a>
                  </div>
                  <div class="info clearfix">
                    <span class="pull-left visible-md visible-lg"><i class="fa fa-calendar"></i> <?php the_time( 'm月j日, Y' ); ?></span>
                    <span class="pull-left visible-sm visible-xs"><i class="fa fa-calendar"></i> <?php the_time( 'm月j日' ); ?></span>
                    <span class="pull-right"><i class="fa fa-comment"></i> <a href="<?php the_permalink() ?>#comments"><?php comments_number( '0', '1', '%' ); ?></a></span>
                  </div>
              </div>
            </div>
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>
          </div>
        </div>
        <!-- 分页 -->
        <?php if ( function_exists( 'show_paginate' ) ) { show_paginate(); } ?>
        <!-- 分页结束 -->
      </section>
      <?php get_sidebar(); ?>
    </section>
  </div>
</section>
<?php get_footer(); ?>
</body>
</html>