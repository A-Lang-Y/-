<?php
/**
 * ZanBlog 广告组件
 *
 * @package    ZanBlog
 * @subpackage Widget
 */
 
class Zan_Ad extends WP_Widget {

  // 设定小工具信息
  function Zan_Ad() {
    $widget_options = array(
          'name'        => '广告组件（ZanBlog）', 
          'description' => 'Zanblog 广告组件' 
    );
    parent::WP_Widget( false, false, $widget_options );  
  }

  // 设定小工具结构
  function widget( $args, $instance ) {  
  	extract( $args );
    $aurl = $instance['aurl'] ? $instance['aurl'] : '';
    $imgurl = $instance['imgurl'] ? $instance['imgurl'] : '';
    echo $before_widget;
    ?>
    <div class="ad hidden-xs">
      <a href="<?php echo $aurl; ?>" target="_blank"><img class="img-responsive" src="<?php echo $imgurl; ?>" /></a>
    </div>
    <?php
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) {                
     return $new_instance;
  }

  function form( $instance ) {  
    @$aurl = esc_attr( $instance['aurl'] );
    @$imgurl = esc_attr( $instance['imgurl'] );
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'aurl' ); ?>">
          指向链接：
          <input class="widefat" id="<?php echo $this->get_field_id( 'aurl' ); ?>" name="<?php echo $this->get_field_name( 'aurl' ); ?>" type="text" value="<?php echo $aurl; ?>" />
        </label>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'imgurl' ); ?>">
          广告图路径：
          <input class="widefat" id="<?php echo $this->get_field_id( 'imgurl' ); ?>" name="<?php echo $this->get_field_name( 'imgurl' ); ?>" type="text" value="<?php echo $imgurl; ?>" />
        </label>
      </p>
    <?php 
  }
} 

register_widget( 'Zan_Ad' );
?>
