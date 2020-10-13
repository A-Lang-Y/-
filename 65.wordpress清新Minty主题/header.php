<!DOCTYPE html>
<!--[if lt IE 7]>      <html <?php language_attributes(); ?> class="lt-ie9 lt-ie8 lt-ie7 ie6"> <![endif]-->
<!--[if IE 7]>         <html <?php language_attributes(); ?> class="lt-ie9 lt-ie8 ie7"> <![endif]-->
<!--[if IE 8]>         <html <?php language_attributes(); ?> class="lt-ie9 ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php echo is_home() ? get_bloginfo('name') . ' | ' . get_bloginfo('description') : wp_title( '|', false, 'right' ) . get_bloginfo('name'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<link rel="shortcut icon" href="<?php echo get_option('minty_favicon'); ?>" />
<link rel="apple-touch-icon" href="<?php echo get_option('minty_apple_touch_icon'); ?>" />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
if (get_option('minty_meta') == true) {
	$keywords = '';
	$description = '';
	if ( is_singular() ) {
		$keywords = '';
		$tags = get_the_tags();
		$categories = get_the_category();
		if ($tags) {
			foreach($tags as $tag) {
				$keywords .= $tag->name . ','; 
			};
		};
		if ($categories) {
			foreach($categories as $category) {
				$keywords .= $category->name . ','; 
			};
		};
		$description = mb_strimwidth( str_replace("\r\n", '', strip_tags($post->post_content)), 0, 240, '…');
	} else {
		$keywords = get_option('minty_meta_keywords');
		$description = get_option('minty_meta_description');
	};
?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>

<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/vendor/html5shiv.js"></script><![endif]-->

<?php wp_head(); ?>
<?php echo stripslashes(get_option('minty_header_code')); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
	<header id="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
		<?php $logotag = ( is_singular() ) ? 'h4' : 'h1'; ?>
		<a id="hgroup" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<<?php echo $logotag; ?> id="logo"><?php bloginfo( 'name' ); ?></<?php echo $logotag; ?>>
			<?php $slogan = get_option( 'minty_slogan', get_bloginfo( 'description' ) );?>
			<i class="slogan" title="返回首页" style="width:<?php echo mb_strlen($slogan, 'UTF8'); ?>em"><?php echo $slogan; ?></i>
		</a>

		<a class="screen-reader-text skip-link" href="#main">跳至内容</a>

		<?php if ( get_option('minty_header_userinfo') == 1 ) : ?>
		<div class="userinfo">
			<?php minty_userinfo(); ?>
		</div>
		<?php endif; ?>

		<div class="connect">
			<?php if (get_option('minty_newsletter_url') != '') : ?><a target="_blank" href="<?php echo get_option('minty_newsletter_url'); ?>" class="mail" title="邮件订阅"><span>邮件订阅</span></a><?php endif; ?>
			
			<?php
			$socialPlatforms = array(
				'weibo' => '新浪微博', 
				'tqq' => '腾讯微博',
				'twitter' => 'Twitter', 
				'renren' => '人人网', 
				'facebook' => 'Facebook', 
				'googleplus' => 'Google+', 
				'linkedin' => 'LinkedIn', 
				'flickr' => 'Flickr', 
				'github' => 'GitHub'
			);
			foreach ($socialPlatforms as $platform => $name) {
            	$url = get_option('minty_' . $platform);
            	if (!empty($url)) echo '<a target="_blank" href="' . $url . '" class="' . $platform . '" title="' . $name . '"><span>' . $name . '</span></a>';
            }
			?>

			<a target="_blank" href="<?php echo get_option('minty_rss_url'); ?>" class="rss" title="RSS"><span>RSS</span></a>
			<?php get_search_form(); ?>
		</div>

		<nav id="nav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<?php wp_nav_menu( array(
				'theme_location'  => 'primary',
				'container'       => false,
				'menu_class'      => 'nav-menu',
				'depth'           => 2
			) ); ?>
		</nav>

		<div id="m-btns">
			<div class="menu" title="菜单">
				<?php
				$mNav = strip_tags( wp_nav_menu( array(
					'theme_location'  => 'primary',
					'container'       => false,
					'menu_id'         => 'm-menu',
					'items_wrap'      => '<select id="%1$s" onchange="location.href=this.value">%3$s</select>',
					'depth'           => 2,
					'echo'            => false
				) ), '<select><optgroup><a><ul>' );

				$mNav = str_replace( array('<a', '</a>', ' href'),  array('<option', '</option>', ' value'), $mNav);
				$mNav = preg_replace( '/<option[^<]*?>([^<]*)<\/option>\n*<ul class="sub-menu">(.*?)<\/ul>/is', '<optgroup label="\1">\2</optgroup>', $mNav);
				echo $mNav;
				?>
			</div>
			<span class="search" title="搜索"></span>
			<?php if (get_option('minty_mblog', 'none') != 'none') : ?><a class="<?php echo get_option('minty_mblog'); ?>" title="微博" target="_blank" href="<?php echo get_option('minty_' . get_option('minty_mblog')); ?>"></a><?php endif; ?>
		</div>
	</header>

	<!--[if lt IE 8]><div id="browsehappy">你正在使用的浏览器版本过低，请<a href="http://browsehappy.com/"><strong>升级你的浏览器</strong></a>，获得最佳的浏览体验！</div><![endif]-->

	<div id="container" class="clearfix<?php if ( get_option( 'minty_one_column' ) == 1 ) echo ' onecolumn' ?>">

		<?php if (get_option('minty_breadcrumb') == 'top' && (get_option('minty_breadcrumb_nohome') == 1 ? !is_home() : true)) minty_breadcrumb(); ?>

        <?php if (is_home() && get_option('minty_featured_content_position') == 'container') minty_featured_content(); ?>