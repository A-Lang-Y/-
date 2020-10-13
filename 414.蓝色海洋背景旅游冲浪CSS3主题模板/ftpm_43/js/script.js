if($.browser.mozilla||$.browser.opera){document.removeEventListener("DOMContentLoaded",$.ready,false);document.addEventListener("DOMContentLoaded",function(){$.ready()},false)}$.event.remove(window,"load",$.ready);$.event.add( window,"load",function(){$.ready()});$.extend({includeStates:{},include:function(url,callback,dependency){if(typeof callback!='function'&&!dependency){dependency=callback;callback=null}url=url.replace('\n','');$.includeStates[url]=false;var script=document.createElement('script');script.type='text/javascript';script.onload=function(){$.includeStates[url]=true;if(callback)callback.call(script)};script.onreadystatechange=function(){if(this.readyState!="complete"&&this.readyState!="loaded")return;$.includeStates[url]=true;if(callback)callback.call(script)};script.src=url;if(dependency){if(dependency.constructor!=Array)dependency=[dependency];setTimeout(function(){var valid=true;$.each(dependency,function(k,v){if(!v()){valid=false;return false}});if(valid)document.getElementsByTagName('head')[0].appendChild(script);else setTimeout(arguments.callee,10)},10)}else document.getElementsByTagName('head')[0].appendChild(script);return function(){return $.includeStates[url]}},readyOld:$.ready,ready:function(){if($.isReady) return;imReady=true;$.each($.includeStates,function(url,state){if(!state)return imReady=false});if(imReady){$.readyOld.apply($,arguments)}else{setTimeout(arguments.callee,10)}}});
$.include('js/superfish.js')
$.include('js/jquery.hoverIntent.minified.js')
$.include('js/tms-0.4.1.js')
$.include('js/uCarousel.js')
$.include('js/jquery.easing.1.3.js')
$.include('js/jquery.tools.min.js')
$.include('js/jquery.jqtransform.js')
$.include('js/jquery.quicksand.js')
$.include('js/jquery.snippet.min.js')
$.include('js/jquery-ui-1.8.17.custom.min.js')
$.include('js/jquery.cycle.all.min.js')
$.include('js/jquery.cookie.js')
$(function(){
	if($('.pro_tweet').length)$.include('js/jquery.tweet.js');
	if($('.lightbox-image').length)$.include('js/jquery.prettyPhoto.js');
	if($('#pro_contact-form').length)$.include('js/forms.js');
	if($('#form1').length)$.include('js/forms.js');
	if($('.pro_kwicks').length)$.include('js/kwicks-1.5.1.pack.js');
	if($('#pro_counter').length)$.include('js/jquery.countdown.min.js');
	if($('.fixedtip').length||$('.clicktip').length||$('.normaltip').length)$.include('js/jquery.atooltip.pack.js')
// Code
	$("pre.pro_htmlCode2").snippet("html",{style:"print",showNum:false,menu:false});
	$("pre.pro_jsCode2").snippet("javascript",{style:"print",showNum:false,menu:false});
// SlideDown
	$(".pro_description-box dd").show()
	$("pre.pro_htmlCode").snippet("html",{style:"print"});			
	$("pre.pro_cssCode").snippet("css",{style:"print"});			
	$("pre.pro_jsCode").snippet("javascript",{style:"print"});
	$(".pro_description-box dd").hide()	
	$(".pro_description-box dt").click(function(){
		$(this).toggleClass("active").parent(".pro_description-box").find("dd").slideToggle(400);					
	});
	$(".pro_slide-down-box dt").click(function(){$(this).toggleClass("active").parent(".pro_slide-down-box").find("dd").slideToggle(200);});
	$(".pro_slide-down-box2 dt").click(function(){$(this).toggleClass("active").parent(".pro_slide-down-box2").find("dd").slideToggle(200);});	
// Tabs
	$(".pro_tabs1 ul").tabs(".pro_tabs1 .pro_tab-content");
	$(".pro_tabs2 ul").tabs(".pro_tabs2 .pro_tab-content");
	$(".pro_tabs3 ul").tabs(".pro_tabs3 .pro_tab-content");
	$(".pro_tabs4 ul").tabs(".pro_tabs4 .pro_tab-content");
	$(".pro_tabs5 ul").tabs(".pro_tabs5 .pro_tab-content");
	$(".pro_tabs-horz-top ul.pro_tabs-nav").tabs(".pro_tabs-horz-top .pro_tab-content");
	$(".pro_tabs-horz-bottom ul.pro_tabs-nav").tabs(".pro_tabs-horz-bottom .pro_tab-content");
	$(".pro_tabs-horz-top2 ul.pro_tabs-nav").tabs(".pro_tabs-horz-top2 .pro_tab-content");
	$(".pro_tabs-horz-bottom2 ul.pro_tabs-nav").tabs(".pro_tabs-horz-bottom2 .pro_tab-content");
	$(".pro_tabs-vert-left ul.pro_tabs-nav").tabs(".pro_tabs-vert-left .pro_tab-content");
	$(".pro_tabs-vert-right ul.pro_tabs-nav").tabs(".pro_tabs-vert-right .pro_tab-content");	
// Forms
	$('#pro_form2').jqTransform({imgPath:'images/'});
// Carausel
	$('.pro_list-car').uCarousel({show:4,buttonClass:'pro_car-button', pageStep:1, shift:false})
	$('.pro_carousel').uCarousel({show:4,buttonClass:'pro_car-button'})
	$('.carousel').uCarousel({show:1,pageStep:1,buttonClass:'car-button'})
// Slider
	$('.pro_slider')._TMS({
		show:0,
		pauseOnHover:false,
		prevBu:'.pro_prev',
		nextBu:'.pro_next',
		playBu:'.pro_play',
		items:'.pro_items>li',
		duration:1000,
		preset:'simpleFade',
		bannerCl:'pro_banner',
		numStatusCl:'pro_numStatus',
		pauseCl:'pro_paused',
		pagination:true,
		paginationCl:'pro_pagination',
		pagNums:false,
		slideshow:7000,
		numStatus:true,
		banners:'fade',// fromLeft, fromRight, fromTop, fromBottom
		waitBannerAnimation:false,
		progressBar:'<div class="pro_progbar"></div>'})	
// Simple Gallery
	$('.pro_simple_gallery')._TMS({
			show:0,
			pauseOnHover:true,
			prevBu:false,
			nextBu:false,
			playBu:false,
			pagNums:false,
			numStatus:false,
			duration:1000,
			preset:'simpleFade',
			items:'.pro_items>li',
			bannerCl:'pro_banner',
			pagination:$('.pro_img-pags').uCarousel({show:10,shift:0,buttonClass:'pro_btn'}),
			paginationCl:'pro_gal-pags',
			slideshow:5000,
			banners:'fade',// fromLeft, fromRight, fromTop, fromBottom
			waitBannerAnimation:false,
			progressBar:'<div class="pro_progbar"></div>'})		
// Ranges	
$("#pro_font-size-slider").change(function(e) {$(".pro_icons.pro_basic li a").css("font-size", $(this).val() + "px");});
$(".pro_color-slider").change(function(e) {$(".pro_icons.pro_basic li a").css("color", "hsla(" + $("#pro_color-slider-1").val() + ", " + $("#pro_color-slider-2").val() + "%, " + $("#pro_color-slider-3").val() + "%, 1)");	});
$(".pro_shadow-slider").change(function(e) {	$(".pro_icons.pro_basic li a").css("text-shadow", $("#pro_shadow-slider-1").val() + "px " + $("#pro_shadow-slider-2").val() + "px " + $("#pro_shadow-slider-3").val() + "px black");	 });
// Testimonials
	$('#pro_testimonials').cycle({fx:'fade', height:'auto',timeout:0,next:'#pro_next_testim',prev:'#pro_prev_testim', after: onAfter });
// Buttons
	$(".pro_notClicked").click(function(event) {event.preventDefault();});
})
// Panel
$(function(){
	
$('body').prepend('<div id="advanced"><span class="trigger"><strong></strong><em></em></span><div class="bg_pro"><div class="pro_main"><span class="pro_logo"></span><ul class="pro_menu"><li><a href="index.html"><img src="images/pro_images/pro_home.png" alt=""></a></li><li><a href="404.html">Pages<span></span></a><ul>	<li><a href="under_construction.html">Under Construction</a></li><li><a href="intro.html">Intro Page</a></li><li><a href="404.html">404 page</a></li></ul></li><li><a href="layouts.html">Layouts</a></li><li><a href="typography.html">Typography</a></li><li><a href="portfolio.html">Gallery Layouts<span></span></a><ul><li><a href="portfolio.html">Portfolio</a></li><li><span></span><a href="just-slider.html">Sliders</a><ul><li><a href="just-slider.html">Just Slider</a></li><li><a href="kwicks.html">Kwicks Slider</a></li><li><a href="functional-slider.html">Functional Slider</a></li></ul></li><li><a href="gallery-page1.html">Gallery</a></li></ul></li><li><a href="misc.html">Extras<span></span></a><ul><li><a href="social_media.html">Social and Media<br> Sharing</a></li><li><a href="css3.html">CSS3 Tricks</a></li><li><a href="misc.html">Misc</a></li></ul></li></ul><div class="pro_clear"></div></div></div><div class="bg_pro2"></div></div>');

	$(window).scroll(function(){if ($(this).scrollTop() > 0) {$("#advanced").css({position:'fixed'});} else {$("#advanced").css({position:'relative'});}});
	$.cookie("panel");	
	$.cookie("panel2");	
	var strCookies = $.cookie("panel");
	var strCookies2 = $.cookie("panel2");
	if(strCookies=='boo')
	{
		if(strCookies2=='opened'){$("#advanced").css({marginTop:'0px'}).removeClass('closed')}else{$("#advanced").css({marginTop:'-40px'}).addClass('closed')}
		$("#advanced .trigger").toggle(function(){
			$(this).find('strong').animate({opacity:0}).parent().parent('#advanced').removeClass('closed').animate({marginTop:'0px'},"fast");
			strCookies2=$.cookie("panel2",'opened');
			strCookies=$.cookie("panel",null);},
		function(){
			$(this).find('strong').animate({opacity:1}).parent().parent('#advanced').addClass('closed').animate({marginTop:'-40px'},"fast")
			strCookies2=$.cookie("panel2",null);
			strCookies=$.cookie("panel",'boo');});
		if ($(window).scrollTop() > 0) {$("#advanced").css({position:'fixed'});}else {$("#advanced").css({position:'relative'});}
	}
	else
	{
		$("#advanced").css({marginTop:'0px'}).removeClass('closed');
		$("#advanced .trigger").toggle(function(){
			$(this).find('strong').animate({opacity:1}).parent().parent('#advanced').addClass('closed').animate({marginTop:'-40px'},"fast");
			strCookies2=$.cookie("panel2",null);
			strCookies=$.cookie("panel",'boo');},
		function(){
			$(this).find('strong').animate({opacity:0}).parent().parent('#advanced').removeClass('closed').animate({marginTop:'0px'},"fast")
			strCookies2=$.cookie("panel2",'opened');
			strCookies=$.cookie("panel",null);});
		if ($(window).scrollTop() > 0) {$("#advanced").css({position:'fixed'});} else {$("#advanced").css({position:'relative'});}
	}
	// Main Slider
	$('.slider')._TMS({
		show:0,
		pauseOnHover:false,
		duration:1000,
		preset:'simpleFade',
		prevBu:'.prev',
		nextBu:'.next',
		pagination:false,
		pagNums:false,
		slideshow:7000,
		numStatus:false,
		banners:'fade',// fromLeft, fromRight, fromTop, fromBottom
		waitBannerAnimation:false})	
});
function onAfter(curr, next, opts, fwd){var $ht=$(this).height();$(this).parent().animate({height:$ht})}
