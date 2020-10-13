<?php
/**
 * Custom-User 自定义用户信息
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 3.0.0
 */

/**
 * 添加用户信息
 */
add_filter( 'user_contactmethods', 'zan_user_contactmethods' );

function zan_user_contactmethods( $user_contactmethods ) {
  //去掉默认联系方式
  unset( $user_contactmethods['aim'] );
  unset( $user_contactmethods['yim'] );
  unset( $user_contactmethods['jabber'] );

  //添加自定义联系方式
  $user_contactmethods['sina_weibo'] = '新浪微博';
  $user_contactmethods['tencent_weibo'] = '腾讯微博';
  return $user_contactmethods;
}

/*为用户预设默认的后台配色方案*/
function get_user_option_admin_color( $result, $option, $user ) {
	return 'sunrise';
}

?>