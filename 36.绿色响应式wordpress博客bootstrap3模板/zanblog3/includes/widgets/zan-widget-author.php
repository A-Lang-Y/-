<?php
/**
 * ZanBlog 作者组件
 *
 * @package    ZanBlog
 * @subpackage Widget
 */
 
class Zan_Author extends WP_Widget {

  // 设定小工具信息
  function Zan_Author() {
    $widget_options = array(
          'name'        => '作者组件（ZanBlog）', 
          'description' => 'ZanBlog 作者展示组件' 
    );
    parent::WP_Widget( false, false, $widget_options );  
  }

  // 设定小工具结构
  function widget( $args, $instance ) {  
  	extract( $args );
    echo $before_widget;
    ?>
    <div class="zan-author text-center hidden-xs">
        <div class="author-top"></div>
        <div class="author-bottom">
          <?php echo get_avatar( get_the_author_meta( 'email' ), '120' ); ?>
          <div class="author-content">
            <span class="author-name"><?php echo get_the_author_meta( 'display_name' ); ?></span>
            <span class="author-social">
              <div class="btn-group btn-group-justified">
                <a class="btn btn-zan-solid-wi" target="_blank" href="<?php echo get_the_author_meta( 'sina_weibo' ); ?>"><i class="fa fa-weibo"></i> 新浪微博</a>
                <a class="btn btn-zan-solid-wi" target="_blank" href="<?php echo get_the_author_meta( 'tencent_weibo' ); ?>"><i class="fa fa-tencent-weibo"></i> 腾讯微博</a>
              </div>
            </span>
          </div>
        </div>
    </div>

    <?php
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) {                
     return $new_instance;
  }

  function form( $instance ) {        
    ?>
      <p>没有相关设定</p>
    <?php
  }
} 

register_widget( 'Zan_Author' );
?>
