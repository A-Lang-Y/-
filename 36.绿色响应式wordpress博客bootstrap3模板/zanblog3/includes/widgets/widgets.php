<?php
/**
 * ZanBlog 小工具函数加载与操作
 *
 * @package 	  ZanBlog
 * @subpackage  Include
 * @since 		  3.0.0
 * @author      YEAHZAN
 */

// 加载小工具组件
include( WIDGETSPATH . 'zan-widget-search.php' );
include( WIDGETSPATH . 'zan-widget-slide.php' );
include( WIDGETSPATH . 'zan-widget-author.php' );
include( WIDGETSPATH . 'zan-widget-hotest-posts.php' );
include( WIDGETSPATH . 'zan-widget-latest-posts.php' );
include( WIDGETSPATH . 'zan-widget-posts-category.php' );
include( WIDGETSPATH . 'zan-widget-latest-comments.php' );
include( WIDGETSPATH . 'zan-widget-audio.php' );
include( WIDGETSPATH . 'zan-widget-video.php' );
include( WIDGETSPATH . 'zan-widget-login.php' );
include( WIDGETSPATH . 'zan-widget-ad.php' );
include( WIDGETSPATH . 'zan-widget-custom.php' );


// 注销系统默认小工具
add_action( 'widgets_init', 'zan_deregister_widgets' );

// 注册自定义小工具侧边栏
add_action( 'widgets_init', 'zan_register_sidebar' );


/**
 * 系统默认小工具注销
 *
 * @since Zanblog 3.0.0
 * @return void
 */
function zan_deregister_widgets() {
	unregister_widget( 'WP_Widget_Search' );         
}

/**
 * 注册自定义小工具侧边栏
 *
 * @since Zanblog 2.0.0
 * @return void
 */
function zan_register_sidebar() {
	if( function_exists( 'register_sidebar' ) ) {
		register_sidebar( array(
		  'name'          => '幻灯片位置',
		  'description'   => '放置幻灯片',
		  'before_widget' => '<aside id="%1$s">',
      'after_widget'  => '</aside>'
		) );

		register_sidebar( array(
		  'name'          => '首页侧边栏',
		  'description'   => '首页侧边栏，只有首页可见',
		  'before_widget' => '<aside id="%1$s">',
      'after_widget'  => '</aside>'
		) );

		register_sidebar( array(
		  'name'          => '文章侧边栏',
		  'description'   => '文章侧边栏，只有single页面可见',
		  'before_widget' => '<aside id="%1$s">',
      'after_widget'  => '</aside>'
		) );

    register_sidebar( array(
      'name'          => '归档侧边栏',
      'description'   => '归档侧边栏，包括分类、标签、作者、归档等页面',
      'before_widget' => '<aside id="%1$s">',
      'after_widget'  => '</aside>'
    ) );
	}
}