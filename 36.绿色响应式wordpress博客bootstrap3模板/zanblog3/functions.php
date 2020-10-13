<?php
/**
 * Functions 整体函数调用
 *
 * @package 	  ZanBlog
 * @subpackage  Theme
 * @since 		  3.0.0
 * @author      YEAHZAN
 */

// 自定义theme路径
define( 'THEMEPATH', TEMPLATEPATH . '/' );

// 自定义includes路径
define( 'INCLUDESEPATH', THEMEPATH . 'includes/' );

// 自定义widgets路径
define( 'WIDGETSPATH', INCLUDESEPATH . 'widgets/' );

// 自定义classes路径
define( 'CLASSESPATH', INCLUDESEPATH . 'classes/' );

// 自定义admin路径
define( 'ADMINPATH', INCLUDESEPATH . 'admin/' );

// 加载主题配置文件
require_once( INCLUDESEPATH . 'theme-options.php' );

// 加载主题函数文件
require_once( INCLUDESEPATH . 'theme-functions.php' );

// 加载短代码文件
require_once( INCLUDESEPATH . 'shortcodes.php' );

// 加载小工具文件
require_once( WIDGETSPATH . 'widgets.php' );

// 加载类文件
require_once( CLASSESPATH . 'classes.php' );

// 自定义登录
require_once( ADMINPATH . 'custom-login.php' );

// 自定义用户资料
require_once( ADMINPATH . 'custom-user.php' );

// 自定义仪表盘
require_once( ADMINPATH . 'custom-dashboard.php' );