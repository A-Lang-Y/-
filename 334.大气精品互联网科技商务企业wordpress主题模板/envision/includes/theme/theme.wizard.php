<?php
/**
 *	Configuration Wizard
 *
 *	@since 1.0
 */

$g_page = 'admin.php?page='.$cloudfw_setting_slug.'&q=1&';

/*-----------------------------------------------------------------------------------*/
/*	Activate - Document
/*-----------------------------------------------------------------------------------*/

$guide["installing"] = array(
	'msg' => sprintf(__('Activate %s','cloudfw'), CLOUDFW_THEMENAME ), 
	'score' => 3,
	'done'	=> TRUE
);

$guide["doc"] = array(
	'msg' => __('Read the theme documentation','cloudfw'), 
	'score' => 1,
	'url'	=> CLOUDFW_ITEMDOC,
	'custom_text'	=> array(__('mark as read','cloudfw'),__('mark as unread','cloudfw'))
);

/*-----------------------------------------------------------------------------------*/
/*	General
/*-----------------------------------------------------------------------------------*/

$guide[] = array(
	'group'	=> __('General Settings','cloudfw')
);

$guide["logo"] = array(
	'msg'	=> __('Upload a logo image','cloudfw'), 
	'score'	=> 4,
	'url'	=> cloudfw_admin_url('global') . '#logo_favicon',
	'done'	=> (!empty($_opt[PFIX."_logo"]["image"]) && $_opt[PFIX."_logo"]["image"] !== TMP_URL.'/lib/images/logo.png') ? TRUE: FALSE,
);

$guide["custom_sidebars"] = array(
	'msg'	=> __('Create custom sidebars','cloudfw') . ' <em>' . __('(optional)','cloudfw') . ' </em>', 
	'score'	=> 0,
	'url'	=> cloudfw_admin_url('global', '4'),
);

$guide["widgets"] = array(
	'msg'	=> __('Manage sidebars and widgets','cloudfw'), 
	'score'	=> 4,
	'url'	=> admin_url('widgets.php'),
);


/*-----------------------------------------------------------------------------------*/
/*	Visual Settings
/*-----------------------------------------------------------------------------------*/

$guide[] = array(
	'group'	=> __('Visual Settings','cloudfw')
	);

$guide["visual_set"] = array(
	'msg' 	=> __('Edit the default visual set or create new one','cloudfw'), 
	'score' => 5,
	'url'	=> cloudfw_admin_url('visual', '0'),
	'done'	=> ($skin["mode"] !== 'defined' && $skin["id"] !== PFIX.'_skin_default_data' ) ? TRUE: FALSE
	);


/*-----------------------------------------------------------------------------------*/
/*	Sliders
/*-----------------------------------------------------------------------------------*/

$guide[] = array(
	'group'	=> __('Slider','cloudfw')
);

$guide["revslider"] = array(
	'msg'	=> __('Install Revolution slider plugin','cloudfw'), 
	'score'	=> 3,
	'done'	=> (class_exists('RevSlider')) ? TRUE: FALSE,
	'unlink'=> false
);

/*-----------------------------------------------------------------------------------*/
/*	Homepage
/*-----------------------------------------------------------------------------------*/

$guide[] = array(
	'group'	=> __('Homepage','cloudfw')
	);

$guide["homepage"] = array(
	'msg'	=> __('Create a page for your front page','cloudfw'), 
	'score'	=> 3,
	'url'	=> admin_url('post-new.php?post_type=page'),
	'done'	=> (get_option('page_on_front'))? TRUE: FALSE,
	'help'	=> (get_option('page_on_front'))? '<a class="inlink" href="post.php?action=edit&post='.get_option('page_on_front').'">'.__('edit','cloudfw').'</a>': '',
	'unlink'=> false,
);

$guide["homepage_define"] = array(
	'msg'	=> __('Define the page as the front page','cloudfw'), 
	'score'	=> 3,
	'url'	=> admin_url('options-reading.php'),
	'done'	=> (get_option('page_on_front'))? TRUE: FALSE,
	'unlink'=> false,
);

/*-----------------------------------------------------------------------------------*/
/*	Blog
/*-----------------------------------------------------------------------------------*/

$guide[] = array(
	'group'	=> __('Blog','cloudfw')
);

$guide["blog"] = array(
	'msg'	=> __('Create a page for blog','cloudfw'), 
	'score'	=> 5,
	'url'	=> admin_url('post-new.php?post_type=page'),
	'done'	=> (get_option('page_for_posts'))? TRUE: FALSE,
	'help'	=> (get_option('page_for_posts'))? '<a class="inlink" href="post.php?action=edit&post='.get_option('page_for_posts').'">'.__('edit','cloudfw').'</a>': '',
	'unlink'=> false
);

$guide["homepage_define"] = array(
	'msg'	=> __('Define the page as the blog page','cloudfw'), 
	'score'	=> 3,
	'url'	=> admin_url('options-reading.php'),
	'done'	=> (get_option('page_for_posts'))? TRUE: FALSE,
	'unlink'=> false,
);

$guide["blog_posts"] = array(
	'msg'	=> __('Create some posts for your blog','cloudfw'), 
	'score'	=> 1,
	'url'	=> admin_url('post-new.php?post_type=post'),
	'unlink'=> false
);

/*-----------------------------------------------------------------------------------*/
/*	Portfolio
/*-----------------------------------------------------------------------------------*/

$guide[] = array(
	'group'	=> __('Portfolio','cloudfw')
);


$guide["portcatcreate"] = array(
	'msg'	=> __('Create some portfolio categories','cloudfw'), 
	'score'	=> 2,
	'url'	=> admin_url('edit-tags.php?taxonomy=portfolio-category&post_type=' . cloudfw_get_option( 'portfolio', 'slug' )),
	'done'	=> (count((array) get_terms('portfolio-category', 'hide_empty=0'))>0)? TRUE: FALSE,
);

$guide["portpost_create"] = array(
	'msg'	=> __('Create some portfolio posts','cloudfw'), 
	'score'	=> 4,
	'url'	=> admin_url('post-new.php?post_type=' . cloudfw_get_option( 'portfolio', 'slug' )),
	//'done'	=> (count((array) get_terms('portfolio-category', 'hide_empty=0'))>0)? TRUE: FALSE,
);

$guide["portpage_create"] = array(
	'msg'	=> __('Create a page for your portfolio','cloudfw'), 
	'score'	=> 3,
	'url'	=> admin_url('post-new.php?post_type=page'),
	'done'	=> _if(!empty($_opt[PFIX."_portfolio"]["page"]), TRUE, FALSE),
);

$guide["portpage_define"] = array(
	'msg'	=> __('Define the page as main portfolio page','cloudfw'), 
	'score'	=> 2,
	'url'	=> cloudfw_admin_url('portfolio', '0'),
	'done'	=> _if(!empty($_opt[PFIX."_portfolio"]["page"]), TRUE, FALSE),
);


/*-----------------------------------------------------------------------------------*/
/*	Navigation Menu
/*-----------------------------------------------------------------------------------*/

$guide[] = array(
	'group'	=> __('Navigation Menu','cloudfw')
	);


$guide["navmenu"] = array(
	'msg'	=> __('Manage the navigation menu','cloudfw'), 
	'score'	=> 3,
	'url'	=> 'nav-menus.php',
	'done'	=> ( has_nav_menu( 'primary' ) )? TRUE: FALSE
	);

/*-----------------------------------------------------------------------------------*/
/*	Optional
/*-----------------------------------------------------------------------------------*/

$guide[] = array(
	'group'	=> __('Optional','cloudfw')
	);

$guide["backup"] = array(
	'msg'	=> __('Backup all options','cloudfw'), 
	'score'	=> 0,
	'url'	=> $g_page.'tab=system#import_export'
	);

$guide["vote"] = array(
	'msg'	=> sprintf( __('Please vote %s on ThemeForest','cloudfw'), CLOUDFW_THEMENAME ), 
	'score'	=> 0,
	'url'	=> CLOUDFW_ITEMPAGE
	);