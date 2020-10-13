<?php
/**
 * Theme-Options 主题选项
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 3.0.0
 */

add_action( 'admin_menu', 'option_page' );
 
function option_page() {
  if ( count( $_POST ) > 0 && isset( $_POST['zan_settings'] ) ) {
    $options = array( 'zan_footer','zan_contact','zan_about','zan_keywords', 'zan_description', 'zan_analytics','zan_content_top_ad','zan_content_down_ad','zan_single_top_ad','zan_single_down_ad' );
    foreach ( $options as $opt ) {
      delete_option($opt, $_POST[$opt]);
      add_option($opt, $_POST[$opt]);
    }
  }
  $hookname =  add_menu_page( __( '主题选项' ), __( '主题选项' ), 'edit_themes', basename( __FILE__ ), 'zan_settings' );
  add_action( $hookname, 'zan_admin_scripts' );
}

// 引入样式
function zan_admin_scripts() {
  global $shortname, $options;

  wp_enqueue_style( 'theme-bootstrap', get_template_directory_uri() . '/ui/css/bootstrap.min.css', '', '3.0.0' );
  wp_enqueue_style( 'theme-zan', get_template_directory_uri() . '/ui/css/zan.css', '', '3.0.0' );
  wp_enqueue_style( 'theme-admin', get_template_directory_uri() . '/ui/css/options.css', '', '3.0.0' ); 
  wp_enqueue_script( 'theme-bootstrap', get_template_directory_uri() . '/ui/js/bootstrap.min.js', 'jquery', '3.0.0', true );
}
 
function zan_settings() {
?>

<div class="wrap">
  <h2>主题选项</h2>
  <div class="zan-tabs">
    <ul id="myTab" class="nav nav-tabs">
      <li class="active">
        <a href="#tab-1-1" data-toggle="tab">
          常规
        </a>
      </li>
      <li class="">
        <a href="#tab-1-2" data-toggle="tab">
          广告
        </a>
      </li>
      <li class="">
        <a href="#tab-1-3" data-toggle="tab">
          SEO
        </a>
      </li>
    </ul>
    <form role="form" method="post" action="">
      <div class="tab-content">
        <div class="tab-pane fade active in" id="tab-1-1">
          <dl class="dl-horizontal">
            <dt>统计代码<br><span>记录网站数据</span></dt>
            <dd>
              <textarea name="zan_analytics" id="zan_analytics" rows="6" autofocus><?php echo stripslashes( get_option( 'zan_analytics' ) ); ?></textarea>
            </dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>关于我们</dt>
            <dd>
              <textarea name="zan_about" id="zan_about" rows="5" autofocus><?php echo stripslashes( get_option( 'zan_about' ) ); ?></textarea>
            </dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>联系我们</dt>
            <dd>
              <textarea name="zan_contact" id="zan_contact" rows="5" autofocus><?php echo stripslashes( get_option( 'zan_contact' ) ); ?></textarea>
            </dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>页脚版权</dt>
            <dd>
              <textarea name="zan_footer" id="zan_footer" rows="5" autofocus><?php echo stripslashes( get_option( 'zan_footer' ) ); ?></textarea>
            </dd>
          </dl>
        </div>
        <div class="tab-pane fade" id="tab-1-2">
          <dl class="dl-horizontal">
            <dt>首页内容区域上部广告<br><span>建议规格：100px高 750px宽</span></dt>
            <dd>
              <textarea name="zan_content_top_ad" id="zan_content_top_ad" rows="3" autofocus><?php echo stripslashes( get_option( 'zan_content_top_ad' ) ); ?></textarea>
            </dd>
            <dt>首页内容区域下部广告<br><span>建议规格：100px高 750px宽</span></dt>
            <dd>
              <textarea name="zan_content_down_ad" id="zan_content_down_ad" rows="3" autofocus><?php echo stripslashes( get_option('zan_content_down_ad' ) ); ?></textarea>
            </dd>
            <dt>文章页上部广告<br><span>建议规格：100px高 750px宽</span></dt>
            <dd>
              <textarea name="zan_single_top_ad" id="zan_single_top_ad" rows="3" autofocus><?php echo stripslashes( get_option( 'zan_single_top_ad' ) ); ?></textarea>
            </dd>
            <dt>文章内页下部广告<br><span>建议规格：100px高 750px宽</span></dt>
            <dd>
              <textarea name="zan_single_down_ad" id="zan_single_down_ad" rows="3" autofocus><?php echo stripslashes( get_option( 'zan_single_down_ad' ) ); ?></textarea>
            </dd>
          </dl>
        </div>
        <div class="tab-pane fade" id="tab-1-3">
          <dl class="dl-horizontal">
            <dt>首页keywords标签</dt>
            <dd>
              <input name="zan_keywords"  id="zan_keywords" type="text" value="<?php echo get_option( 'zan_keywords' ); ?>">
              标签之间以","分隔
            </dd>
            <dt>首页description标签</dt>
            <dd>
              <textarea name="zan_description" id="zan_description" rows="3" autofocus><?php echo get_option( 'zan_description' ); ?></textarea>
            </dd>
          </dl>
        </div>
      </div>
      <p class="submit" >
        <input type="submit" name="Submit" class="btn btn-zan-line-pp" value="保存设置"/>
        <input type="hidden" name="zan_settings" value="save" style="display:none;"/>
      </p>
    </form>
  </div> 
</div>
 
<?php
}
?>