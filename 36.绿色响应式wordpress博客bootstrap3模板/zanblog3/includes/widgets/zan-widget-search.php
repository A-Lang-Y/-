<?php
/**
 * ZanBlog 搜索框组件
 *
 * @package    ZanBlog
 * @subpackage Widget
 */
 
class Zan_Search extends WP_Widget {

  // 设定小工具信息
  function Zan_Search() {
    $widget_options = array(
          'name'        => '搜索框组件（ZanBlog）', 
          'description' => 'ZanBlog 搜索框组件' 
    );
    parent::WP_Widget( false, false, $widget_options );  
  }

  // 设定小工具结构
  function widget( $args, $instance ) {  
  	extract( $args );
    echo $before_widget;
    ?>
      <form method="get" id="searchform" class="form-inline clearfix hidden-xs" action="<?php bloginfo( 'url' ); ?>">
        <input class="form-control" type="text" name="s" id="s" placeholder="搜索关键词..." />
        <button class="btn btn-zan-solid-pi btn-small"><i class="fa fa-search"></i> 查找</button>
      </form>
    <?php echo $after_widget;
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

register_widget( 'Zan_Search' );
?>
