$(document).ready(function(){
	/*Color Panel
	==============*/
	
	$('.panel_accordion').live("click", function(){
		$(this).parent('li').find('ul').slideToggle();
		$(this).toggleClass('selected');
	});
	//Layout Script
	$('.layout_categ a').live("click", function(){
		set_layout = $(this).attr('rel');
		$('#css_layout').attr('href', 'css/layout/'+set_layout+'.css');
		$.cookie("cookie_layout", set_layout);
	});
	//Color Script
	$('.color_categ a').live("click", function(){
		set_color = $(this).attr('rel');
		$('#css_color').attr('href', 'css/colors/'+set_color+'.css');
		$.cookie("cookie_color", set_color);
	});
	//Skin Script
	$('.theme_categ a').live("click", function(){
		set_skin = $(this).attr('rel');
		$('#css_skin').attr('href', 'css/'+set_skin+'.css');
		$.cookie("cookie_skin", set_skin);
	});
	//Patterns Script
	$('.bg_categ a').live("click", function(){
		set_pattern = $(this).attr('rel');
		$('#css_pattern').attr('href', 'css/patterns/'+set_pattern+'.css');
		$.cookie("cookie_pattern", set_pattern);
	});
	
	$('.cpl_toggle').live("click", function(){
		if(!$(this).hasClass('cpl_show')) {
			$(this).addClass('cpl_show');
			$('.color_panel').stop().animate({'left' : '-174px'},300);
		}
		else {
			$(this).removeClass('cpl_show');
			$('.color_panel').stop().animate({'left' : '0'},300);		
		}
	});
});