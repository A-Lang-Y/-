<?php
/**
 * ZanBlog 自定义组件
 *
 * @package    ZanBlog
 * @subpackage Widget
 */
 
class Zan_Custom extends WP_Widget {

  // 设定小工具信息
  function Zan_Custom() {
    $widget_options = array(
          'name'        => '自定义组件（ZanBlog）', 
          'description' => '自行添加想要的组件，例如公告栏' 
    );
    parent::WP_Widget( false, false, $widget_options );  
  }

  // 设定小工具结构
  function widget( $args, $instance ) {  
  	extract($args);
    $title = $instance['title'] ? $instance['title'] : '';
    $content = $instance['content'] ? $instance['content'] : '';
    echo $before_widget;
    ?>
    <div class="panel panel-zan hidden-xs">
      <div class="panel-heading"><?php echo $title; ?></div>
      <div class="panel-body custom"><?php echo $content; ?></div>
    </div>
    <?php
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) {                
     return $new_instance;
  }

  function form( $instance ) {  
    @$title = esc_attr( $instance['title'] );
    @$content = esc_attr( $instance['content'] );
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
          标题：
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </label>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'content' ); ?>">
          内容：
          <textarea name="<?php echo $this->get_field_name( 'content' ); ?>" class="widefat" rows="5"><?php echo $content; ?></textarea>
        </label>
      </p>
    <?php 
  }
} 

register_widget( 'Zan_Custom' );
?>
