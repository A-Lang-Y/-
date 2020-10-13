<?php
/**
 * ZanBlog 前台登录组件
 *
 * @package    ZanBlog
 * @subpackage Widget
 */
 
class Zan_Login extends WP_Widget {

  // 设定小工具信息
  function Zan_Login() {
    $widget_options = array(
          'name'        => '前台登录组件（ZanBlog）', 
          'description' => 'ZanBlog 前台登录组件' 
    );
    parent::WP_Widget( false, false, $widget_options );  
  }

  // 设定小工具结构
  function widget( $args, $instance ) {  
    // 获取当前用户信息
    global $current_user;        
    get_currentuserinfo();
  	extract($args);
    $user_login = '';
    $title_login = '';
    $title_logout = '';
    @$title_login = $instance['title_login'] ? $instance['title_login'] : '请登录';
    @$title_logout = $instance['title_logout'] ? $instance['title_logout'] : '<i class="fa fa-quote-left"></i> 欢迎！ <i class="fa fa-quote-right"></i>';
    echo $before_widget;
    ?>
    <?php if ( !( current_user_can('level_0') ) ) { ?>
    <div class="panel panel-zan">
      <div class="panel-heading"><?php echo $title_login; ?></div>
      <form class="login-form clearfix" action="<?php echo get_option( 'home' ); ?>/wp-login.php" method="post">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-user"></i></div>
            <input class="form-control" type="text" name="log" id="log" value="<?php echo $user_login ?>" size="20" />
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
            <input class="form-control" type="password" name="pwd" id="pwd" size="20" />
          </div>
        </div>
        <button class="btn btn-zan-solid-ip pull-left" type="submit" name="submit">登录</button>
        <a href="<?php echo home_url().'/wp-login.php?action=register'?>" class="btn btn-zan-solid-ip pull-right">注册</a>
      </form>
    </div>
    <?php } else { ?>
    <div class="panel panel-zan">
      <div class="panel-heading"><?php echo $title_logout; ?></div>
      <div class="login-panel text-center">
          <?php echo get_avatar( $current_user->user_email, '60' ); ?>
          <a class="user-name" href="<?php echo home_url().'/wp-admin';?>"><?php echo $current_user->user_login; ?></a>
          <a class="btn btn-zan-solid-pw" href="<?php echo wp_logout_url( get_bloginfo( 'url' ) ); ?>" title="退出登录">退出登录</a>
      </div>
    </div>
    <?php }?>
    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance) {                
     return $new_instance;
  }

  function form($instance) { 
    @$title_login = esc_attr( $instance['title_login'] );   
    @$title_logout = esc_attr( $instance['title_logout'] );   
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title_login' ); ?>">
          登录框标题（默认请登录）：
          <input class="widefat" id="<?php echo $this->get_field_id( 'title_login' ); ?>" name="<?php echo $this->get_field_name( 'title_login' ); ?>" type="text" value="<?php echo $title_login; ?>" />
        </label>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'title_logout' ); ?>">
          注销框标题（默认欢迎）：
          <input class="widefat" id="<?php echo $this->get_field_id( 'title_logout' ); ?>" name="<?php echo $this->get_field_name( 'title_logout' ); ?>" type="text" value="<?php echo $title_logout; ?>" />
        </label>
      </p>
    <?php
  }
} 

register_widget( 'Zan_Login' );
?>
