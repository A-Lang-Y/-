<?php
/**
 * ZanBlog 音频组件
 *
 * @package    ZanBlog
 * @subpackage Widget
 */
 
class Zan_Audio extends WP_Widget {

  // 设定小工具信息
  function Zan_Audio() {
    $widget_options = array(
          'name'        => '音频组件（ZanBlog）', 
          'description' => 'ZanBlog 音频组件' 
    );
    parent::WP_Widget( false, false, $widget_options );  
  }

  // 设定小工具结构
  function widget( $args, $instance ) {  
  	extract( $args );
    $title = $instance['title'] ? $instance['title'] : '音乐盒';
    $url = $instance['url'] ? $instance['url'] : '';
    echo $before_widget;
    ?>
    <div class="panel panel-zan hidden-xs">
      <div class="panel-heading"><?php echo $title; ?></div>
      <audio src="<?php echo $url ?>" type="audio/mpeg" preload="auto"></audio>
    </div>
    <?php
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) {                
     return $new_instance;
  }

  function form( $instance ) {  
    @$title = esc_attr( $instance['title'] );
    @$url = esc_attr( $instance['url'] );
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
          标题（默认音乐盒）：
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </label>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'url' ); ?>">
          歌曲路径：
          <input class="widefat"  name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo $url; ?>" />
        </label>
      </p>
    <?php 
  }
} 

register_widget( 'Zan_Audio' );
?>
