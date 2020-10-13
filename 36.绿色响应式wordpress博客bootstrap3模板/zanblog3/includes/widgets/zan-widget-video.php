<?php
/**
 * ZanBlog 视频组件
 *
 * @package    ZanBlog
 * @subpackage Widget
 */
 
class Zan_Video extends WP_Widget {

  // 设定小工具信息
  function Zan_Video() {
    $widget_options = array(
          'name'        => '视频组件（ZanBlog）', 
          'description' => 'ZanBlog 视频组件' 
    );
    parent::WP_Widget( false, false, $widget_options );  
  }

  // 设定小工具结构
  function widget( $args, $instance ) {  
  	extract( $args );
    $url = $instance['url'] ? $instance['url'] : '';
    echo $before_widget;
    ?>
    <video class="hidden-xs" width="100%" height="auto" controls="controls">
      <source src="<?php echo $url ?>" type="video/mp4">
    </video>
    <?php
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) {                
     return $new_instance;
  }

  function form( $instance ) {        
    @$url = esc_attr( $instance['url'] );
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'url' ); ?>">
          视频路径：
          <input class="widefat"  name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo $url; ?>" />
        </label>
      </p>
    <?php 
  }
} 

register_widget( 'Zan_Video' );
?>
