<?php
/**
 * Shortcodes 主题文件
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 3.0.0
 */

// 在侧边栏 Widgets 中使用 Shortcode
add_filter( 'widget_text', 'do_shortcode' );

// 解决 Shortcode 中自动添加的 br 或者 p 标签
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

add_action( 'admin_print_footer_scripts', 'shortcode_buttons', 100 );
function shortcode_buttons() {
?>
<script type="text/javascript">
  QTags.addButton( '1', '提示框-primary', '[primary]内容[/primary]' );  
  QTags.addButton( '2', '提示框-success', '[success]内容[/success]' );
  QTags.addButton( '3', '提示框-info', '[info]内容[/info]' );  
  QTags.addButton( '4', '提示框-warning', '[warning]内容[/warning]' );  
  QTags.addButton( '5', '提示框-danger', '[danger]内容[/danger]' ); 
  QTags.addButton( '6', '按钮-primary', '[btn-primary href=""]内容[/btn-primary]' );
  QTags.addButton( '7', '按钮-inverse', '[btn-inverse href=""]内容[/btn-inverse]' ); 
  QTags.addButton( '8', '按钮-success', '[btn-success href=""]内容[/btn-success]' ); 
  QTags.addButton( '9', '按钮-info', '[btn-info href=""]内容[/btn-info]' ); 
  QTags.addButton( '10', '按钮-warning', '[btn-warning href=""]内容[/btn-warning]' ); 
  QTags.addButton( '11', '按钮-danger', '[btn-danger href=""]内容[/btn-danger]' ); 
  QTags.addButton( '12', '面板-success', '[panel-success title="标题"]内容[/panel-success]' );
  QTags.addButton( '13', '面板-info', '[panel-info title="标题"]内容[/panel-info]' );  
  QTags.addButton( '14', '面板-warning', '[panel-warning title="标题"]内容[/panel-warning]' );  
  QTags.addButton( '15', '面板-danger', '[panel-danger title="标题"]内容[/panel-danger]' );  
  QTags.addButton( '17', 'well', '[well]内容[/well]' );
  QTags.addButton( '18', '引用', '[blockquote]内容[/blockquote]' ); 
  QTags.addButton( '19', '音频', '[audio]歌曲路径(请先将文件上传到媒体库或者外链)[/audio]' );  
  QTags.addButton( '20', '视频', '[video]视频路径(请先将文件上传到媒体库或者外链)[/video]' );  
</script>
<?php }
function add_editor_buttons( $buttons ) { $buttons[] = 'fontselect'; $buttons[] = 'fontsizeselect'; $buttons[] = 'cleanup'; $buttons[] = 'styleselect'; $buttons[] = 'hr'; $buttons[] = 'del'; $buttons[] = 'sub'; $buttons[] = 'sup'; $buttons[] = 'copy'; $buttons[] = 'paste'; $buttons[] = 'cut'; $buttons[] = 'undo'; $buttons[] = 'image'; $buttons[] = 'anchor'; $buttons[] = 'backcolor'; $buttons[] = 'wp_page'; $buttons[] = 'charmap'; return $buttons; } add_filter( "mce_buttons_3", "add_editor_buttons" );

/**
 * 提示框
 */
// 获取zanblog自定义的提示框样式，调用样式[primary]内容[/primary]
function alert_primary( $atts, $content="" ) { 
	return '<div class="alert alert-primary">'.$content.'</div>'; 
} 
add_shortcode( 'primary', 'alert_primary' ); 

// 获取bootstrap的success框样式，调用样式[success]内容[/success]
function alert_success( $atts, $content="" ) { 
	return '<div class="alert alert-success">'.$content.'</div>'; 
} 
add_shortcode( 'success', 'alert_success' ); 

// 获取bootstrap的info框样式，调用样式[info]内容[/info]
function alert_info( $atts, $content="" ) { 
	return '<div class="alert alert-info">'.$content.'</div>'; 
} 
add_shortcode( 'info', 'alert_info' ); 

// 获取bootstrap的warning框样式，调用样式[warning]内容[/warning]
function alert_warning( $atts, $content="" ) { 
	return '<div class="alert alert-warning">'.$content.'</div>'; 
} 
add_shortcode( 'warning', 'alert_warning' ); 

// 获取bootstrap的danger框样式，调用样式[danger]内容[/danger]
function alert_danger( $atts, $content="" ) { 
	return '<div class="alert alert-danger">'.$content.'</div>'; 
} 
add_shortcode( 'danger', 'alert_danger' ); 

// 获取bootstrap的可关闭danger框样式，调用样式[dismissible-warning]内容[/dismissible-warning]
function alert_dismissible_warning( $atts, $content="" ) { 
	return '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$content.'</div>'; 
} 
add_shortcode( 'dismissible-warning', 'alert_dismissible_warning' ); 

/**
 * 按钮
 */
// 获取zanblog自定义的按钮样式-primary，调用样式[btn-primary href=""]内容[/btn-primary]
function btn_primary( $atts, $content="" ) { 
	extract( shortcode_atts( array( 
		"href" => 'http://', 
	), $atts ) );
	return '<a href="'.$href.'" class="btn btn-primary">'.$content.'</a>'; 
} 
add_shortcode( 'btn-primary', 'btn_primary' ); 

// 获取zanblog自定义的按钮样式-inverse，调用样式[btn-inverse href=""]内容[/btn-inverse]
function btn_inverse( $atts, $content="" ) { 
	extract( shortcode_atts( array( 
		"href" => 'http://', 
	), $atts ) );
	return '<a href="'.$href.'" class="btn btn-inverse">'.$content.'</a>';
} 
add_shortcode( 'btn-inverse', 'btn_inverse' );

// 获取bootstrap的按钮样式-success，调用样式[btn-success href=""]内容[/btn-success]
function btn_success( $atts, $content="" ) { 
	extract( shortcode_atts( array( 
		"href" => 'http://', 
	), $atts ) );
	return '<a href="'.$href.'" class="btn btn-success">'.$content.'</a>';
} 
add_shortcode( 'btn-success', 'btn_success' ); 

// 获取bootstrap的按钮样式-info，调用样式[btn-info href=""]内容[/btn-info]
function btn_info( $atts, $content="" ) { 
	extract( shortcode_atts( array( 
		"href" => 'http://', 
	), $atts ) );
	return '<a href="'.$href.'" class="btn btn-info">'.$content.'</a>';
} 
add_shortcode( 'btn-info', 'btn_info' ); 

// 获取bootstrap的按钮样式-warning，调用样式[btn-warning href=""]内容[/btn-warning]
function btn_warning( $atts, $content="" ) { 
	extract( shortcode_atts( array( 
		"href" => 'http://', 
	), $atts ) );
	return '<a href="'.$href.'" class="btn btn-warning">'.$content.'</a>';
} 
add_shortcode( 'btn-warning', 'btn_warning' ); 

// 获取bootstrap的按钮样式-danger，调用样式[btn-danger href=""]内容[/btn-danger]
function btn_danger( $atts, $content="" ) { 
	extract( shortcode_atts( array( 
		"href" => 'http://', 
	), $atts ) );
	return '<a href="'.$href.'" class="btn btn-danger">'.$content.'</a>';
} 
add_shortcode( 'btn-danger', 'btn_danger' ); 


/**
 * 面板
 */
// 获取bootstrap的面板样式-success，调用样式[panel-success title=""]内容[/panel-success]
function panel_success( $atts,  $content="" ) { 
	extract( shortcode_atts( array( 
		"title" => '标题', 
	), $atts ) );
	return '<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title">'.$title.'</h3></div><div class="panel-body">'.$content.'</div></div>'; 
} 
add_shortcode( 'panel-success', 'panel_success' );

// 获取bootstrap的面板样式-info，调用样式[panel-info title=""]内容[/panel-info]
function panel_info( $atts,  $content="" ) { 
	extract( shortcode_atts( array( 
		"title" => '标题', 
	), $atts ) );
	return '<div class="panel panel-info"><div class="panel-heading"><h3 class="panel-title">'.$title.'</h3></div><div class="panel-body">'.$content.'</div></div>'; 
} 
add_shortcode( 'panel-info', 'panel_info' );

// 获取bootstrap的面板样式-warning，调用样式[panel-warning title=""]内容[/panel-warning]
function panel_warning( $atts,  $content="" ) { 
	extract( shortcode_atts( array( 
		"title" => '标题', 
	), $atts ) );
	return '<div class="panel panel-warning"><div class="panel-heading"><h3 class="panel-title">'.$title.'</h3></div><div class="panel-body">'.$content.'</div></div>'; 
} 
add_shortcode( 'panel-warning', 'panel_warning' );  

// 获取bootstrap的面板样式-danger，调用样式[panel-danger title=""]内容[/panel-danger]
function panel_danger( $atts,  $content="" ) { 
	extract( shortcode_atts( array( 
		"title" => '标题', 
	), $atts ) );
	return '<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">'.$title.'</h3></div><div class="panel-body">'.$content.'</div></div>'; 
} 
add_shortcode( 'panel-danger', 'panel_danger' );

/**
 * well
 */
// 获取bootstrap的well样式，调用样式[well]内容[/well]
function well( $atts, $content="" ) { 
	return '<div class="well">'.$content.'</div>'; 
} 
add_shortcode( 'well', 'well' ); 

/**
 * 引用
 */
// 获取bootstrap的blockquote样式，调用样式[blockquote]内容[/blockquote]
function blockquote( $atts, $content="" ) { 
	return '<blockquote>'.$content.'</blockquote>'; 
} 
add_shortcode( 'blockquote', 'blockquote' ); 

/**
 * 音频
 */
// 调用样式[audio]歌曲路径(请先将文件上传到媒体库)[/audio]
function mp3player( $atts, $content="" ) {
 	return '<audio src="'.$content.'" type="audio/mpeg" preload="auto"></audio>';
}
add_shortcode( 'audio','mp3player' );

/**
 * 视频
 */
// 调用样式[video]视频路径(请先将文件上传到媒体库)[/video]
function videoplayer( $atts, $content="" ) {
 	return '<video width="100%" height="auto" controls="controls"><source src="'.$content.'" type="video/mp4"></video>';
}
add_shortcode( 'video','videoplayer' );

?>