<?php
$themename = "Minty";
$shortname = "minty";

$options   = array(
    array(
        'title' => __('General Settings'),
        'id'    => 'panel_general',
        'type'  => 'panelstart'
    ),
    array(
        'title' => '网站图标',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => 'Favicon 站点图标（URL）',
        'desc'  => '',
        'id'    => $shortname . '_favicon',
        'type'  => 'text',
        'std'   => site_url('favicon.ico')
    ),
    array(
        'name'  => 'iOS 主屏幕图标（URL）',
        'desc'  => '建议尺寸：152x152',
        'id'    => $shortname . '_apple_touch_icon',
        'type'  => 'text',
        'std'   => site_url('apple-touch-icon-precomposed.png')
    ),
    array(
        'title' => '搜索引擎优化（SEO）',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '自定义关键字/描述',
        'desc'  => '启用',
        'id'    => $shortname . "_meta",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '首页关键字',
        'desc'  => '各关键字间用半角逗号","分割，数量在5个以内最佳。',
        'id'    => $shortname . "_meta_keywords",
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '首页描述',
        'desc'  => '用简洁的文字描述本站点，字数建议在120个字以内。',
        'id'    => $shortname . "_meta_description",
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'title' => '辅助功能',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '快捷键导航',
        'desc'  => '启用',
        'id'    => $shortname . "_keyboard_navigation",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '延迟加载评论者头像',
        'desc'  => '启用',
        'id'    => $shortname . "_lazyload",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '加载进度条',
        'desc'  => '启用',
        'id'    => $shortname . "_nprogress",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '下雪效果',
        'desc'  => '',
        'id'    => $shortname . '_snowfall',
        'type'  => 'radio',
        'options' => array(
            '禁用' => 'disabled',
            '仅首页' => 'home',
            '全站' => 'site'
        ),
        'std'   => 'disabled'
    ),
    array(
        'name'  => '无限滚动加载',
        'desc'  => '自动加载次数（小于1表示禁用）',
        'id'    => $shortname . '_infinitescroll',
        'type'  => 'number',
        'std'   => 0
    ),
    array(
        'title' => __('Text'),
        'type'  => 'subtitle'
    ),
    array(
        'name'  => __('Search'),
        'desc'  => '占位文本',
        'id'    => $shortname . "_search_placeholder",
        'type'  => 'text',
        'std'   => '搜索&hellip;'
    ),
    array(
        'name'  => '404 页面',
        'desc'  => __('Title'),
        'id'    => $shortname . "_404_title",
        'type'  => 'text',
        'std'   => '有点尴尬诶。'
    ),
    array(
        'name'  => '',
        'desc'  => __('Tagline'),
        'id'    => $shortname . "_404_tagline",
        'type'  => 'text',
        'std'   => '这儿似乎什么都没有，试试搜索？'
    ),
    array(
        'name'  => '评论',
        'desc'  => '评论框占位文本',
        'id'    => $shortname . "_comment_placeholder",
        'type'  => 'text',
        'std'   => '说点什么吧…'
    ),
    array(
        'name'  => '',
        'desc'  => '暂无评论时的提示文本',
        'id'    => $shortname . "_comment_sofatext",
        'type'  => 'text',
        'std'   => '沙发空缺中，还不快抢~'
    ),
    array(
        'type'  => 'panelend'
    ),
    
    
    array(
        'title' => '样式设置',
        'id'    => 'panel_sidebar',
        'type'  => 'panelstart'
    ),
    array(
        'title' => __('Navigation'),
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '分页导航',
        'desc'  => '使用传统分页列表导航',
        'id'    => $shortname . "_pagination_list",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '面包屑导航',
        'desc'  => '移动端自动隐藏',
        'id'    => $shortname . '_breadcrumb',
        'type'  => 'radio',
        'options' => array(
            '禁用' => 'disabled',
            '顶部' => 'top',
            '底部' => 'bottom'
        ),
        'std'   => 'disabled'
    ),
    array(
        'name'  => '',
        'desc'  => '不在首页显示面包屑导航',
        'id'    => $shortname . "_breadcrumb_nohome",
        'type'  => 'checkbox'
    ),
    array(
        'title' => __('Featured Image'),
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '图片形式',
        'desc'  => '',
        'id'    => $shortname . '_featured_image_type',
        'type'  => 'radio',
        'options' => array(
            '横幅' => 'banner',
            '横幅（在标题下面）' => 'banner-below',
            '缩略图' => 'thumb'
        ),
        'std'   => 'banner'
    ),
    array(
        'name'  => '横幅高度',
        'desc'  => 'px',
        'id'    => $shortname . '_post_thumbnail_size_h',
        'type'  => 'number',
        'std'   => 220
    ),
    array(
        'name'  => '悬停效果',
        'desc'  => '禁用悬停效果',
        'id'    => $shortname . '_featured_image_noeffect',
        'type'  => 'checkbox'
    ),
    array(
        'title' => __('Sidebar'),
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '单栏模式',
        'desc'  => '禁用侧边栏',
        'id'    => $shortname . "_one_column",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '小工具标题',
        'desc'  => '使用文字替代图标',
        'id'    => $shortname . "_show_widget_title",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '固定侧边栏',
        'desc'  => '侧边栏（上）：当页面滚动到侧边栏消失时，固定显示该侧边栏；侧边栏（下）：当页面滚动到该侧边栏时，固定显示该侧边栏',
        'id'    => $shortname . "_sticky_widget",
        'type'  => 'radio',
        'options' => array(
            '禁用' => 'disabled',
            '侧边栏（上）' => 'top',
            '侧边栏（下）' => 'bottom'
        ),
        'std'   => 'disabled'
    ),
    array(
        'name'  => '响应式',
        'desc'  => '在平板布局中显示侧边栏',
        'id'    => $shortname . "_sidebar_on_tablet",
        'type'  => 'checkbox'
    ),
    array(
        'title' => sprintf(__('Customize %s'), 'CSS'),
        'type'  => 'subtitle'
    ),
    array(
        'name'  => sprintf(__('Customize %s'), 'CSS'),
        'desc'  => '输入您自定义的CSS代码，无需填写<code>&lt;style&gt;</code>标签。',
        'id'    => $shortname . "_custom_css",
        'type'  => 'textarea',
        'std'   => "/* 代码示例：当浏览器宽度小于540px时，隐藏页脚导航，不需要可删除。*/\n@media only screen and (max-width: 540px) {\n    #footer .links { display: none; }\n}"
    ),
    array(
        'type'  => 'panelend'
    ),
    
    array(
        'title' => __('Header') . '设置',
        'id'    => 'panel_header',
        'type'  => 'panelstart'
    ),
    array(
        'name'  => 'LOGO 右侧标语',
        'desc'  => '',
        'id'    => $shortname . "_slogan",
        'type'  => 'text',
        'std'   => get_bloginfo( 'description' )
    ),
    array(
        'name'  => '用户信息',
        'desc'  => '显示用户模块（用户头像、登录、注册和登出链接）',
        'id'    => $shortname . "_header_userinfo",
        'type'  => 'checkbox'
    ),
    array(
        'title' => '顶部小图标',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => 'RSS地址（URL）',
        'desc'  => '如果您想使用自定义的RSS地址，请在这里输入您期望的地址。',
        'id'    => $shortname . '_rss_url',
        'type'  => 'text',
        'std'   => get_bloginfo('rss2_url')
    ),
    array(
        'name'  => '邮件订阅（URL）',
        'desc'  => '邮件订阅地址，不显示请留空。',
        'id'    => $shortname . '_newsletter_url',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'title' => '社交小图标',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '新浪微博',
        'desc'  => '',
        'id'    => $shortname . '_weibo',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '腾讯微博',
        'desc'  => '',
        'id'    => $shortname . '_tqq',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => 'Twitter',
        'desc'  => '',
        'id'    => $shortname . '_twitter',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '人人网',
        'desc'  => '',
        'id'    => $shortname . '_renren',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => 'Facebook',
        'desc'  => '',
        'id'    => $shortname . '_facebook',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => 'Google+',
        'desc'  => '',
        'id'    => $shortname . '_googleplus',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => 'LinkedIn',
        'desc'  => '',
        'id'    => $shortname . '_linkedin',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => 'Flickr',
        'desc'  => '',
        'id'    => $shortname . '_flickr',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => 'GitHub',
        'desc'  => '',
        'id'    => $shortname . '_github',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '移动端微博',
        'desc'  => '',
        'id'    => $shortname . '_mblog',
        'type'  => 'radio',
        'options' => array(
            '不显示' => 'none',
            '新浪微博' => 'weibo',
            '腾讯微博' => 'tqq',
            'Twitter' => 'twitter'
        ),
        'std'   => 'weibo'
    ),
    array(
        'title' => '自定义代码',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '自定义代码',
        'desc'  => '填写需要追加到<code>&lt;head&gt;...&lt;/head&gt;</code>标签内的代码，不需要请留空。',
        'id'    => $shortname . "_header_code",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'title' => '首页推荐',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '首页推荐',
        'desc'  => '',
        'id'    => $shortname . '_featured_content_position',
        'type'  => 'radio',
        'options' => array(
            '禁用' => 'disabled',
            '主体上方' => 'container',
            '列表上方' => 'main'
        ),
        'std'   => 'disabled'
    ),
    array(
        'name'  => '展现形式',
        'desc'  => '',
        'id'    => $shortname . '_featured_content_type',
        'type'  => 'radio',
        'options' => array(
            '幻灯片' => 'slides',
            '网格' => 'grid'
        ),
        'std'   => 'slides'
    ),
    array(
        'name'  => '幻灯片自动播放间隔',
        'desc'  => '（单位：毫秒）',
        'id'    => $shortname . '_featured_content_timeout',
        'type'  => 'number',
        'std'   => '4000'
    ),
    array(
        'name'  => '文字描述',
        'desc'  => '',
        'id'    => $shortname . '_featured_content_caption',
        'type'  => 'radio',
        'options' => array(
            '不显示' => 'hidden',
            '在图片上方' => 'cover',
            '在图片下方' => 'below'
        ),
        'std'   => 'cover'
    ),
    array(
        'name'  => '列表数据',
        'desc'  => '格式请参考[Minty]幻灯片的数据格式。（最佳数量：3~4）',
        'id'    => $shortname . "_featured_content_data",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'type'  => 'panelend'
    ),


    array(
        'title' => '文章设置',
        'id'    => 'panel_post',
        'type'  => 'panelstart'
    ),
    array(
        'name'  => '文章信息',
        'desc'  => '显示文章作者',
        'id'    => $shortname . "_show_post_author",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '索引显示',
        'desc'  => '全文：文章中 More 标签之前的内容；摘要：手动“摘要”或自动截取',
        'id'    => $shortname . '_use_excerpt',
        'type'  => 'radio',
        'options' => array(
            '全文' => 0,
            '摘要' => 1
        ),
        'std'   => 0
    ),
    array(
        'name'  => '',
        'desc'  => '摘要长度',
        'id'    => $shortname . '_excerpt_length',
        'type'  => 'number',
        'std'   => 160
    ),
    array(
        'name'  => '文章摘要',
        'desc'  => '手机端显示文章摘要',
        'id'    => $shortname . "_show_post_summary_on_mobile",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '作者评论',
        'desc'  => '在作者名称后面显示的标记文本',
        'id'    => $shortname . "_postauthor_text",
        'type'  => 'text',
        'std'   => '作者'
    ),
    array(
        'name'  => '版权声明',
        'desc'  => '留空则不显示。（你可以使用：<code>{{title}}</code>表示文章标题，<code>{{link}}</code>表示文章链接）',
        'id'    => $shortname . "_copyright",
        'type'  => 'textarea',
        'std'   => '原创文章转载请注明：转载自：<a href="{{link}}">{{title}}</a>'
    ),
    array(
        'name'  => '分享代码',
        'desc'  => '位于文章页的正文下方，不需要则留空。<a href="http://notepad.cc/m1nty4" target="_blank">获取代码</a>',
        'id'    => $shortname . "_share_code",
        'type'  => 'textarea',
        'std'   => '<div class="bdsharebuttonbox">' . "\n" . '    <i>分享到：</i>' . "\n" . '    <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>' . "\n" . '    <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>' . "\n" . '    <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>' . "\n" . '    <a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>' . "\n" . '    <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>' . "\n" . '    <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>' . "\n" . '    <a href="#" class="bds_more" data-cmd="more"></a>' . "\n" . '</div>' . "\n" . '<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"32"},"share":{"bdCustomStyle":"bdshare:"}};with(document)0[(getElementsByTagName(\'head\')[0]||body).appendChild(createElement(\'script\')).src=\'http://bdimg.share.baidu.com/static/api/js/share.js?v=86835285.js?cdnversion=\'+~(-new Date()/36e5)];</script>'
    ),
    array(
        'type'  => 'panelend'
    ),
    
    
    array(
        'title' => __('Page Template'),
        'id'    => 'panel_template',
        'type'  => 'panelstart'
    ),
    array(
        'name'  => __('Search Results'),
        'desc'  => '',
        'id'    => $shortname . '_search_use_excerpt',
        'type'  => 'radio',
        'options' => array(
            '全文' => 0,
            '摘要' => 1
        ),
        'std'   => 1
    ),
    array(
        'name'  => '',
        'desc'  => 'Google 自定义搜索',
        'id'    => $shortname . "_gcse",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '',
        'desc'  => '搜索引擎 ID',
        'id'    => $shortname . '_gcse_id',
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => __('Links') . '（Links）',
        'desc'  => '按分类目录显示',
        'id'    => $shortname . "_template_links_categorize",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '',
        'desc'  => __('Tagline'),
        'id'    => $shortname . "_template_links_tagline",
        'type'  => 'text',
        'std'   => '我的网络邻居们，排名不分先后'
    ),
    array(
        'name'  => '留言簿（Guestbook）',
        'desc'  => '显示活跃评论者',
        'id'    => $shortname . "_template_readers",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '',
        'desc'  => __('Title'),
        'id'    => $shortname . "_template_readers_title",
        'type'  => 'text',
        'std'   => '活跃评论者'
    ),
    array(
        'name'  => '',
        'desc'  => '排除使用指定邮箱的用户（多个邮箱请使用 <code>|</code> 分隔）',
        'id'    => $shortname . "_template_readers_exclude_emails",
        'type'  => 'text',
        'std'   => get_bloginfo( 'description' )
    ),
    array(
        'name'  => '关于（About）',
        'desc'  => '请将微博秀嵌入代码粘贴到这里（留空则显示侧边栏）。获取代码：<a href="http://weibo.com/tool/weiboshow" target="blank">新浪微博秀</a> / <a href="http://dev.t.qq.com/websites/show/" target="blank">腾讯微博秀</a> / <a href="https://twitter.com/settings/widgets" target="blank">Twitter 小工具</a>',
        'id'    => $shortname . "_template_mblogshow",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'type'  => 'panelend'
    ),
    
    
    array(
        'title' => '桌面端广告',
        'id'    => 'panel_ad',
        'type'  => 'panelstart'
    ),
    array(
        'name'  => '索引页广告',
        'desc'  => '位于索引页第一篇文章的下方，最大宽度为700px，不需要则留空。',
        'id'    => $shortname . "_ad_index",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'name'  => '单页面广告',
        'desc'  => '位于单页面的标题下方，最大宽度为660px，不需要则留空。',
        'id'    => $shortname . "_ad_single_title",
        'type'  => 'textarea',
        'std'   => ''
    ),
	array(
        'name'  => '',
        'desc'  => '位于单页面的正文下方，最大宽度为660px，不需要则留空。',
        'id'    => $shortname . "_ad_single_footer",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'name'  => '',
        'desc'  => '位于单页面的评论上方，最大宽度为700px，不需要则留空。',
        'id'    => $shortname . "_ad_single",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'type'  => 'panelend'
    ),
    
    array(
        'title' => '移动端广告',
        'id'    => 'panel_mobile_ad',
        'type'  => 'panelstart'
    ),
    array(
        'name'  => '索引页广告',
        'desc'  => '位于索引页第一篇文章的下方，不需要则留空。',
        'id'    => $shortname . "_mobile_ad_index",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'name'  => '单页面广告',
        'desc'  => '位于单页面的标题下方，不需要则留空。',
        'id'    => $shortname . "_mobile_ad_single_title",
        'type'  => 'textarea',
        'std'   => ''
    ),
	array(
        'name'  => '',
        'desc'  => '位于单页面的正文下方，不需要则留空。',
        'id'    => $shortname . "_mobile_ad_single_footer",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'name'  => '',
        'desc'  => '位于单页面的评论上方，不需要则留空。',
        'id'    => $shortname . "_mobile_ad_single",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'type'  => 'panelend'
    ),
    
    
    array(
        'title' => __('Footer') . '设置',
        'id'    => 'panel_footer',
        'type'  => 'panelstart'
    ),
    array(
        'name'  => '底部导航分割符',
        'desc'  => '',
        'id'    => $shortname . "_footer_nav_separator",
        'type'  => 'text',
        'std'   => '//'
    ),
    array(
        'name'  => '页脚信息',
        'desc'  => '可填写备案号、版权信息等，请使用 <code>&middot;</code> 作为分隔符。',
        'id'    => $shortname . "_footer_code",
        'type'  => 'textarea',
        'std'   => " &middot; 沪ICP备XXXXXXXX号"
    ),
    array(
        'name'  => '统计代码',
        'desc'  => '隐藏统计代码产生的图片',
        'id'    => $shortname . "_stat_hidden",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '',
        'desc'  => '不对管理员添加统计代码',
        'id'    => $shortname . "_stat_noadmin",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '',
        'desc'  => '',
        'id'    => $shortname . "_stat_code",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'type'  => 'panelend'
    )
);

function minty_add_theme_options_page() {
    global $themename, $shortname, $options;
    if ($_GET['page'] == basename(__FILE__)) {
        if ('save' == $_REQUEST['action']) {
            foreach($options as $value) {
                if (isset($_REQUEST[$value['id']])) {
                    update_option($value['id'], $_REQUEST[$value['id']]);
                } else {
                    delete_option($value['id']);
                }
            }
            update_option('minty_options_setup', true);
            header('Location: themes.php?page=theme-options.php&saved=true');
            die;
        } else if( 'reset' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                delete_option($value['id']);
            }
            delete_option('minty_options_setup');
            header('Location: themes.php?page=theme-options.php&reset=true');
            die;
        }
    }
    add_theme_page(__('Theme Options'), __('Theme Options'), 'edit_theme_options', basename(__FILE__) , 'minty_options_page');
}
add_action('admin_menu', 'minty_add_theme_options_page');

function minty_options_page() {
    global $themename, $shortname, $options;
    $optionsSetup = get_option('minty_options_setup') != '';
    if ($_REQUEST['saved']) echo '<div class="updated"><p><strong>设置已保存。</strong></p></div>';
    if ($_REQUEST['reset']) echo '<div class="updated"><p><strong>设置已重置。</strong></p></div>';
?>

<div class="wrap">
<form method="post">
<?php screen_icon(); echo '<h2>' . $themename . ' ' . __('Theme Options') . '</h2>'; ?>

<h2 class="nav-tab-wrapper">
<?php
$themeVersion = wp_get_theme()->get('Version');
$updateData = @file_get_contents('http://c7sky.com/api/minty.json');
$newVersionAvailable = false;
if ($updateData !== FALSE) {
    $updateData = json_decode($updateData);
    if ($updateData->version > $themeVersion) $newVersionAvailable = true;
};

$panelIndex = 0;
foreach ($options as $value ) {
    if ( $value['type'] == 'panelstart' ) echo '<a href="#' . $value['id'] . '" class="nav-tab' . ( $panelIndex == 0 ? ' nav-tab-active' : '' ) . '">' . $value['title'] . '</a>';
    $panelIndex++;
}

echo '<a href="#panel_feedback" class="nav-tab">' . __('Theme') . __('Feedback') . '</a>';
if ($newVersionAvailable) echo '<a href="#panel_update" class="nav-tab"><i></i>' . __('Theme') . __('Update') . '</a>';
?>
</h2>

<?php
$panelIndex = 0;
foreach ($options as $value) {
switch ( $value['type'] ) {
    case 'panelstart':
        echo '<div class="panel" id="' . $value['id'] . '" ' . ( $panelIndex == 0 ? ' style="display:block"' : '' ) . '><table class="form-table">';
        $panelIndex++;
        break;
    case 'panelend':
        echo '</table></div>';
        break;
    case 'subtitle':
        echo '<tr><th colspan="2"><h3>' . $value['title'] . '</h3></th></tr>';
        break;
    case 'text':
?>
<tr>
    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
    <td>
        <label>
        <input name="<?php echo $value['id']; ?>" class="regular-text" id="<?php echo $value['id']; ?>" type='text' value="<?php if ( $optionsSetup || get_option( $value['id'] ) != '') { echo stripslashes(get_option( $value['id'] )); } else { echo $value['std']; } ?>" />
        <span class="description"><?php echo $value['desc']; ?></span>
        </label>
    </td>
</tr>
<?php
    break;
    case 'number':
?>
<tr>
    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
    <td>
        <label>
        <input name="<?php echo $value['id']; ?>" class="small-text" id="<?php echo $value['id']; ?>" type="number" value="<?php if ( $optionsSetup || get_option( $value['id'] ) != '') { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
        <span class="description"><?php echo $value['desc']; ?></span>
        </label>
    </td>
</tr>
<?php
    break;
    case 'textarea':
?>
<tr>
    <th><?php echo $value['name']; ?></th>
    <td>
        <p><label for="<?php echo $value['id']; ?>"><?php echo $value['desc']; ?></label></p>
        <p><textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" rows="10" cols="50" class="large-text code"><?php if ( $optionsSetup || get_option( $value['id'] ) != '') { echo stripslashes(get_option( $value['id'] )); } else { echo $value['std']; } ?></textarea></p>
    </td>
</tr>
<?php
    break;
    case 'select':
?>
<tr>
    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
    <td>
        <label>
            <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                <?php foreach ($value['options'] as $option) : ?>
                <option value="<?php echo $option; ?>" <?php selected( get_option( $value['id'] ), $option); ?>>
                    <?php echo $option; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <span class="description"><?php echo $value['desc']; ?></span>
        </label>
    </td>
</tr>

<?php
    break;
    case 'radio':
?>
<tr>
    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
    <td>
        <?php foreach ($value['options'] as $name => $option) : ?>
        <label>
            <input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php echo $option; ?>" <?php checked( get_option( $value['id'] ), $option); ?>>
            <?php echo $name; ?>
        </label>
        <?php endforeach; ?>
        <p><span class="description"><?php echo $value['desc']; ?></span></p>
    </td>
</tr>
 
<?php
    break;
    case 'checkbox':
?>
<tr>
    <th><?php echo $value['name']; ?></th>
    <td>
        <label>
            <input type='checkbox' name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="1" <?php echo checked(get_option($value['id']), 1); ?> />
            <span><?php echo $value['desc']; ?></span>
        </label>
    </td>
</tr>

<?php
    break;
    case 'checkboxs':
?>
<tr>
    <th><?php echo $value['name']; ?></th>
    <td>
        <?php $checkboxsValue = get_option( $value['id'] );
        if ( !is_array($checkboxsValue) ) $checkboxsValue = array();
        foreach ( $value['options'] as $id => $title ) : ?>
        <label>
            <input type="checkbox" name="<?php echo $value['id']; ?>[]" id="<?php echo $value['id']; ?>[]" value="<?php echo $id; ?>" <?php checked( in_array($id, $checkboxsValue), true); ?>>
            <?php echo $title; ?>
        </label>
        <?php endforeach; ?>
        <span class="description"><?php echo $value['desc']; ?></span>
    </td>
</tr>
 
<?php
    break;
}
}
?>
<div class="panel" id="panel_feedback">
    <table class="form-table">
    <tbody>
    <tr>
        <th>邮件反馈</th>
        <td>
            <iframe width="540" height="460" frameborder="0" scrolling="no" style="width:100%;max-width:700px" src="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=awgEGwcOKx0CG0UaGkUIBAY">
            </iframe>
        </td>
    </tr>
    <tr>
        <th>QQ反馈</th>
        <td>
            <a target="_blank" href="http://sighttp.qq.com/authd?IDKEY=b8c88de05999f9333f172a0a46b625a0e9b0da72b30ec0b6"><img src="http://wpa.qq.com/imgd?IDKEY=b8c88de05999f9333f172a0a46b625a0e9b0da72b30ec0b6&pic=51" alt="QQ交谈" title="点击这里给作者发消息"/></a>
        </td>
    </tr>
    <tr>
        <th>博客留言</th>
        <td>
            <a href="http://c7sky.com/wordpress-theme-minty.html" target="_blank">http://c7sky.com/wordpress-theme-minty.html</a>
        </td>
    </tr>
    </tbody>
    </table>
</div>
<?php if ($newVersionAvailable) : ?>
 <div class="panel" id="panel_update">
    <table class="form-table">
    <tbody>
    <tr>
        <th>主题版本</th>
        <td><?php echo $updateData->version; ?></td>
    </tr>
    <tr>
        <th>更新记录</th>
        <td>
            <ul>
<?php
foreach ($updateData->changelog as $item) {
    echo '<li>' . $item . '</li>';
}
?>
             </ul>
        </td>
    </tr>
    <tr>
        <th>下载地址</th>
        <td>
            <a href="<?php echo $updateData->download; ?>" target="_blank"><?php echo $updateData->download; ?></a>
        </td>
    </tr>
    <tr>
        <th>更新备注</th>
        <td><?php echo $updateData->info; ?></td>
    </tr>
    </tbody>
    </table>
</div>
<?php endif; ?>
<p class="submit">
    <input name="save" type="submit" class="button button-primary" value="保存选项"/>
    <input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p>
    <input name="reset" type="submit" class="button button-secondary" value="重置选项" onclick="return confirm('你确定要重置选项吗？');"/>
    <input type="hidden" name="action" value="reset" />
</p>
</form>
</div>
<style>
.panel { display:none; }
.panel h3{ font-size: 1.2em; margin: 0; }
#panel_update ul { list-style-type: disc; }
.nav-tab { position: relative;}
.nav-tab i:before {
font: 400 18px/1 dashicons;
speak: none;
color: #fff;
display: inline-block;
content: "\f463";
vertical-align: text-bottom;
background: #e14d43;
border-radius: 50%;
padding: 2px;
position: absolute;
right: -8px;
top: -10px;
}
</style>
<script>
jQuery(function ($) {
    $(".nav-tab").click(function () {
        $(this).addClass("nav-tab-active").siblings().removeClass("nav-tab-active");
        $(".panel").hide();
        $($(this).attr("href")).show();
        return false;
    });
});
</script>
<script>
var _hmt = [];
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F70c52f6b0f8b2f05ff5adccb6c7c4f55' type='text/javascript'%3E%3C/script%3E"));
_hmt.push(['_setCustomVar', 1, 'version', <?php echo $themeVersion; ?>]);
</script>
<?php
}

function minty_theme_activated() {
  if ( get_option('minty_options_setup') == '' ) echo '<div class="error"><p><b>新主题已启用。该主题支持选项，请访问<a href="themes.php?page=theme-options.php">主题选项</a>页面进行配置。<a href="themes.php?page=theme-options.php">立即配置</a></b></p></div>';
}
add_action('admin_footer', 'minty_theme_activated');

/**
 * WordPress Pointer
 */
function minty_enqueue_pointer_script_style( $hook_suffix ) {
    
    // Assume pointer shouldn't be shown
    $enqueue_pointer_script_style = false;

    // Get array list of dismissed pointers for current user and convert it to array
    $dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    // Check if our pointer is not among dismissed ones
    if( !in_array( 'minty_options_pointer', $dismissed_pointers ) ) {
        $enqueue_pointer_script_style = true;
        
        // Add footer scripts using callback function
        add_action( 'admin_print_footer_scripts', 'minty_pointer_print_scripts' );
    }

    // Enqueue pointer CSS and JS files, if needed
    if( $enqueue_pointer_script_style ) {
        wp_enqueue_style( 'wp-pointer' );
        wp_enqueue_script( 'wp-pointer' );
    }
    
}
add_action( 'admin_enqueue_scripts', 'minty_enqueue_pointer_script_style' );

function minty_pointer_print_scripts() {
    ?>
    
    <script>
    jQuery(document).ready(function($) {
        var $menuAppearance = $("#menu-appearance");
        $menuAppearance.pointer({
            content: '<h3>恭喜，Minty 主题安装成功！</h3><p>该主题支持选项，请访问<a href="themes.php?page=theme-options.php">主题选项</a>页面进行配置。</p>',
            position: {
                edge: "left",
                align: "center"
            },
            close: function() {
                $.post(ajaxurl, {
                    pointer: "minty_options_pointer",
                    action: "dismiss-wp-pointer"
                });
            }
        }).pointer("open").pointer("widget").find("a").eq(0).click(function() {
            var href = $(this).attr("href");
            $menuAppearance.pointer("close");
            setTimeout(function(){
                location.href = href;
            }, 700);
            return false;
        });

        $(window).on("resize scroll", function() {
            $menuAppearance.pointer("reposition");
        });
        $("#collapse-menu").click(function() {
            $menuAppearance.pointer("reposition");
        });
    });
    </script>

<?php
}
?>