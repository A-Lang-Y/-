<?php
/**
 * ZanBlog 最新评论组件
 *
 * @package    ZanBlog
 * @subpackage Widget
 */
 
class Zan_Latest_Comments extends WP_Widget {

  // 设定小工具信息
  function Zan_Latest_Comments() {
    $widget_options = array(
          'name'        => '最新评论组件（ZanBlog）', 
          'description' => 'ZanBlog 最新评论组件' 
    );
    parent::WP_Widget( false, false, $widget_options );  
  }

  // 设定小工具结构
  function widget($args, $instance) {  
  	extract($args);
    $title = $instance[ 'title' ] ? $instance[ 'title' ] : '最新评论';
    $num = $instance[ 'num' ] ? $instance[ 'num' ] : 5;
    $size = $instance[ 'size' ] ? $instance[ 'size' ] : 75;
    echo $before_widget;
    ?>
      <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="panel-body">
          <ul class="list-group">
            <?php 
              $comments = zan_get_latest_comments( $num );
              foreach ( $comments as $comment ) :
            ?>
              <li class="zan-list clearfix">
                <div class="sidebar-avatar">
                  <?php echo get_avatar($comment->comment_author_email, $size); ?>
                </div>
                 <h6>
                  发表于：<a href="<?php echo get_permalink( $comment->comment_post_ID ); ?>"><?php echo get_the_title( $comment->comment_post_ID ); ?></a>
                 </h6>
                <div class="sidebar-comment">
                  <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
                    <?php echo mb_strimwidth(strip_tags(apply_filters('comment_content', $comment->comment_content ) ), 0, 80, "..." ); ?>
                  </a>
                </div>
              </li>
            <?php
              endforeach;
            ?>
          </ul>
        </div>
      </div>
    <?php
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) {                
     return $new_instance;
  }

  function form( $instance ) {        
    @$title = esc_attr($instance['title']);
    @$size = esc_attr($instance['size']);
    @$num = esc_attr($instance['num']);
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
          标题（默认最新评论）：
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </label>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'size' ); ?>">
          头像尺寸（默认75px）：
          <input class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" type="text" value="<?php echo $size; ?>" />
        </label>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'num' ); ?>">
          评论显示条数（默认显示5条）：
          <input class="widefat" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" type="text" value="<?php echo $num; ?>" />
        </label>
      </p>
    <?php 
  }
} 

register_widget( 'Zan_Latest_Comments' );
?>
