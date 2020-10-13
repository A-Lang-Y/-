<?php
/**
 * Custom-Dashboard 自定义仪表盘
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 3.0.0
 */

/**
 * 移除仪表盘内容
 */
function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);    //WordPress China 博客
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);  //其它WordPress新闻
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);  //近期草稿
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);//链入链接
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);     //概况
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);   //插件
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

?>