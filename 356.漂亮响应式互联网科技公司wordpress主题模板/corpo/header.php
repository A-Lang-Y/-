<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title><?php wp_title(); ?></title>
		<?php wp_head(); ?>
	</head>
    <?php if ( is_front_page() && of_get_option('corpo_hp_style') == 1 ) { $class = 'custom-front'; } else { $class = ''; } ?>
	<body <?php body_class($class); ?>>
	
    <div id="wrapper">
        <div id="top-bar">
            <div class="right">
                <?php corpo_social_icons(); ?>
            </div>
            <?php if ( of_get_option('corpo_social_phone') ) : ?>
            <div class="left"><?php _e('Call us at','corpo'); ?> <?php echo of_get_option('corpo_social_phone'); ?></div>
            <?php endif; ?>
        </div>
        <!-- header -->
        <header id="header">
            <div id="header-inner">
                <div id="logo">
                    <?php if (of_get_option('corpo_logo_image')) : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-img"><img src="<?php echo of_get_option('corpo_logo_image'); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
                    <?php else : ?>
                    <h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo('description'); ?>" rel="home"><?php bloginfo('name'); ?></a></h1><p class="site_tagline"><?php bloginfo('description'); ?></p>
                    <?php endif; ?>		
                </div>
                <!-- navigation -->
                <nav id="main-nav" role="navigation">
                    <?php
                    if(has_nav_menu('main-menu')){
                         wp_nav_menu(array(
                            'theme_location'  => 'main-menu',
                            'container'       => false, 
                            'menu_class'      => 'menu', 
                            'menu_id'         => 'main-menu',
                            'echo'            => true,
                            'fallback_cb'     => 'wp_page_menu',
                            'before'          => '',
                            'after'           => '',
                            'link_before'     => '',
                            'link_after'      => '',
                            'depth'           => 0,
                            'walker'          => ''
                         ));
                    }else {
                    ?>
                        <ul class="nav" id="main-menu">
                            <?php wp_list_pages('title_li='); ?>
                        </ul>
                    <?php
                    }
                    ?>
                </nav>
                <!-- END navigation -->
            </div>
        </header>
        <!-- END #header -->

        <?php 
        $home_style = '';
        
        if ( ( get_option( 'show_on_front' ) == 'posts' || get_option( 'show_on_front' ) == 'page' ) && (int)of_get_option('corpo_hp_style') != 1 ) { 
            $home_style = 'posts';
        }
        if ( !is_front_page() || $home_style == 'posts' ) : ?>
            <div id="content-wrapper">
        <?php endif; ?>