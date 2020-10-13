/*
 + Generated with SMK SKINR v1.0
 + Date and time: 09/10/2012 08:21:16 pm - Australia/Melbourne
 + SMK SKINR URL: http://www.smartik-themes.com/themeforest/html/perspective/template-builder.php
 + Color Scheme: #620405 | #b31416 | #d93639 | #ff696c
 + General info: 
	header: ../../images/headers/header52.jpg
	wrap: none
	loader: ../../images/loaders/1.gif
	caption: ../../images/caption/13.png
	footer: ../../images/pattern/62.png
	blog icons set: 0
*/

/*Links*/
a {
	color: #620405;
	transition: all .3s;
	-moz-transition: all .3s;
	-webkit-transition: all .3s;
	-o-transition: all .3s;
}
a:hover, 
h1 a:hover,
h2 a:hover, 
h3 a:hover, 
h4 a:hover, 
h5 a:hover, 
h6 a:hover {
	color: #b31416
}

/*Top Bar(with menu)*/
.top_head_separator{
	background: #FFFFFF; 
	border-bottom: #EEEEEE solid 10px;
}

/*Menu*/
.nav_simple ul li a {
	border-bottom: 1px solid transparent;
	padding-top: 7px;
	padding-bottom: 7px;
}
.nav_simple ul li a:hover,
.nav_simple ul li a.hov,
.nav_simple ul li a.active {
	border-bottom: 1px solid #b31416;
	background: #222222;
	color: #FFFFFF;
}
.nav_simple li.nav_badge em,
.nav_simple li.nav_badge a em{
	background: #ff696c;
	color: #fff;
}



/*Header*/
.header, 
.page_top_details{ 
	background: url(../../images/headers/header52.jpg) center top #ffffff;
	border-bottom: 10px solid #EEEEEE;
}

/*Wrap*/
.wrap{
	background: #ffffff;
}

/*Image/Video Wrap*/
.image_wrap,
.image_wrap_simple,
.blog_article .blog_slider.flexslider,
.post_article_single .post_slider.flexslider,
.blog_article .container_video,
.post_article_single .container_video{
	background: #fafafa;
}
.image_wrap:hover, 
.image_wrap_simple:hover, 
.blog_article .blog_slider.flexslider:hover,
.post_article_single .post_slider.flexslider:hover,
.blog_article .container_video:hover, 
.post_article_single .container_video:hover{
	background: #eaeaea;
}
.img_wrap_in{
	margin: 5px;
}
.image_wrap,
.image_wrap_simple,
.blog_article .blog_slider.flexslider,
.post_article_single .post_slider.flexslider,
.blog_article .container_video,
.post_article_single .container_video,
.image_wrap img,
.image_wrap_simple img,
.blog_article .blog_slider.flexslider img,
.post_article_single .post_slider.flexslider img,
.blog_article .container_video iframe,
.post_article_single .container_video iframe,
.img_wrap_in{
	border-radius: 2px;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
}

/*Forms*/
input[type=text], 
input[type=password], 
input[type=url], 
input[type=email], 
input.text, 
input.title, 
textarea, 
select{
	border-color: #BBBBBB;
	background: #FFFFFF;
	color: #000000;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
}
input[type=text]:focus, 
input[type=password]:focus, 
input[type=url]:focus, 
input[type=email]:focus, 
input.text:focus, 
input.title:focus, 
textarea:focus, 
select:focus{
	border-color: #b31416;
	background: #FFFFFF;
	color: #000000;
}

/*Image Preloader*/
.preloader { background:url(../../images/loaders/1.gif) center center no-repeat #ffffff; }

/*Site Footer*/
#site_footer{ 
	background-image: url(../../images/pattern/62.png);
	background-color: #32303D;
	background-repeat: repeat; 
	background-position: center top; 
}
#site_footer
#site_footer .widgetized_footer,
#site_footer .widgetized_footer .widget-title,
#site_footer .widgetized_footer .widget ul li{
	color: #FFFFFF;
}
#site_footer .widgetized_footer a,
#site_footer .widgetized_footer .widget ul li a{
	color: #FFFFFF;
}
#site_footer a:hover,
#site_footer .widgetized_footer a:hover,
#site_footer .widgetized_footer .widget ul li a:hover{
	color: #ff696c;
}
#site_footer_second{
	background: #32303D;
	border-top: 1px solid #49475C;
}
#site_footer_second,
#site_footer_second .site_footer_inner,
.site_copyright{
	color: #FFFFFF;
}
#site_footer_second a,
#site_footer_second .site_footer_inner a{
	color: #FFFFFF;
}
#site_footer_second a:hover,
#site_footer_second .site_footer_inner a:hover{
	color: #ff696c;
}


/* Blog icons */
.blog_article.blog_article_s3 .blog_s3_meta ul.metasingle li.blog_user { 
	background-image: url(../../images/icons/blog/blog-user0.png); 
}
.blog_article.blog_article_s3 .blog_s3_meta ul.metasingle li.blog_date { 
	background-image: url(../../images/icons/blog/blog-calendar0.png); 
}
.blog_article.blog_article_s3 .blog_s3_meta ul.metasingle li.blog_category { 
	background-image: url(../../images/icons/blog/blog-category0.png); 
}
.blog_article.blog_article_s3 .blog_s3_meta ul.metasingle li.blog_comments { 
	background-image: url(../../images/icons/blog/blog-comments0.png); 
}
.blog_article.blog_article_s3 .blog_s3_meta ul.metasingle li.blog_tag { 
	background-image: url(../../images/icons/blog/blog-tag0.png); 
}


/* Image hover icon */
.image_wrap .img_caption_zoom,
.image_wrap .img_caption_more,
.image_wrap .img_caption_video,
.image_wrap .img_caption_link{
	filter: alpha(opacity=0);
	opacity: 0;
	background: url(../../images/caption/13.png);
	left: 50%; 
	top: 50%;
	-webkit-transform: scale(5);
	-moz-transform: scale(5);
	-o-transform: scale(5);
	-ms-transform: scale(5);
	transform: scale(5);
	-webkit-transition: all 0.3s ease-in-out;
	-moz-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	-ms-transition: all 0.3s ease-in-out;
	transition: all 0.3s ease-in-out;
}
.image_wrap .img_caption_zoom,.image_wrap:hover .img_caption_zoom {background-position: 0 0; }
.image_wrap .img_caption_more,.image_wrap:hover .img_caption_more{background-position: -48px 0;}
.image_wrap .img_caption_video,.image_wrap:hover .img_caption_video{background-position: -96px 0;}
.image_wrap .img_caption_link,.image_wrap:hover .img_caption_link{background-position: -144px 0;}
.image_wrap:hover .img_caption_zoom,
.image_wrap:hover .img_caption_more,
.image_wrap:hover .img_caption_video,
.image_wrap:hover .img_caption_link{
	left: 50%;
	top: 50%;
	filter: alpha(opacity=100);
	opacity: 1;
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-o-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
}


/* Button */
.default_button{
	border: solid 1px #111111;
	color: #FFFFFF;
	background: #444444;
 }
.default_button:hover,
.default_button:active { 
	color: #FFFFFF; 
	background: #d93639; 
	border-color: #620405; 
}


/*General color scheme
------------------------------------------------------------------------------------------*/
/* Price box title */
.price_box.pb2col .pb_column.pb_active,
.price_box.pb3col .pb_column.pb_active,
.price_box.pb4col .pb_column.pb_active,
.price_box.pb5col .pb_column.pb_active {
	border-color:#d93639;
	box-shadow: 0px 0px 47px #ff696c;
	-moz-box-shadow: 0px 0px 47px #ff696c;
	-webkit-box-shadow: 0px 0px 47px #ff696c;
}

/* Default color for selected text */
::selection, 
::-moz-selection { 
	background: #b31416
}

/* Top search form */
.page_top_details #searchform #s{
	border: 1px solid #fff;
	background: #fff;
	color: #222;
}
.page_top_details #searchform #s:focus{
	/* border-color: #b31416; */
	background: #fff;
	color: #222;
}

/* Pagination */
#smk_pagination a{
	color:#777; 
	border-bottom: 3px solid #ddd; 
}
#smk_pagination a:hover { 
	border-color:#b31416; 
	color:#b31416; 
}
#smk_pagination .active_smk_link { 
	border-bottom: 3px solid #620405; 
	color:#620405; 
}
#smk_pagination .disabled_smk_pagination { 
	border-bottom:3px solid #EBEBEB; 
	color:#D7D7D7; 
}

/* Home clients */
.home_clients .hp_item_grid_client:hover{ 
	border-top-color: #b31416;
}

/* Portfolio styles */
.portf_item .pf_icons .pf_icon.img_zoom:hover,
.portf_item .pf_icons .pf_icon.img_info:hover { 
	background-color: #d93639;
}
.portf_item h2:hover{ 
	color: #ff696c;
}
#portfolio_menu li a:hover { 
	color: #b31416;
}
#portfolio_menu li a.active_cat { 
	color: #b31416; 
	border-bottom: 1px solid #b31416;
}

/* Blog colors */
.blog_article.blog_article_s3 .blog_s3_meta ul.metasingle a:hover {
	color: #b31416;
}

/* Widgets */
.widget ul li a { 
	border-bottom: 1px solid #eee; 
	color: #666; 
}
.widget ul li a:hover,
.widget ul li a:focus,
.widget ul li a:active {
	border-color:#b31416; 
	color:#b31416;
}
.widget ul li.current-menu-item a {	
	color:#b31416;
}

/* Team link color */
.team_member .team_mb_name a:hover{ 
	color: #b31416;
}