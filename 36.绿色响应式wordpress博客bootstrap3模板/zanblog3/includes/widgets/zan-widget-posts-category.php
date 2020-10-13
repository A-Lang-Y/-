<?php
/**
 * ZanBlog 文章分类组件
 *
 * @package    ZanBlog
 * @subpackage Widget
 */
 
class Zan_Posts_Category extends WP_Widget {

  // 设定小工具信息
  function Zan_Posts_Category() {
    $widget_options = array(
          'name'        => '文章分类组件（ZanBlog）', 
          'description' => 'ZanBlog 文章分类组件' 
    );
    parent::WP_Widget(false, false, $widget_options);  
  }

  // 设定小工具结构
  function widget($args, $instance) {  
  	extract($args);
    $title = $instance['title'] ? $instance['title'] : '文章分类';
    @$caid = $instance['caid'] ? $instance['caid'] : 45;
    echo $before_widget;
    ?>
      <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="list-group zan-category">
          <?php zan_get_posts_category($caid); ?>
        </div>
      </div>
    <?php
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) {                
     return $new_instance;
  }

  function form( $instance ) {        
    @$title = esc_attr( $instance['title'] );
    @$caid = esc_attr( $instance['caid'] );
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
          标题（默认文章分类）：
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </label>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'caid' ); ?>">
          排除分类id（排除幻灯片分类）
          <input class="widefat" id="<?php echo $this->get_field_id( 'caid' ); ?>" name="<?php echo $this->get_field_name( 'caid' ); ?>" type="text" value="<?php echo $caid; ?>" />
        </label>
      </p>
    <?php 
  }
} 

register_widget( 'Zan_Posts_Category' );
?>
