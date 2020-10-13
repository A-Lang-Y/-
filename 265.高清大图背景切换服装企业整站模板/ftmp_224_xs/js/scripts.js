$(document).ready(function(){

	/* CREATE RESPONSIVE MENU */
	
	$(".responsive_menu").click(function(){
		var nowpm = $(this).find(".pm").text();
		if (nowpm == "+") {
			newpm = "-";
		}
		if (nowpm == "-") {
			newpm = "+";
		}
		$(this).find(".pm").text(newpm);
	
		$(".responsive-menu-items").slideToggle("fast", function(){
			content_setup();														 
		});
		
	});
	
	$(".responsive-menu-items").html("<ul class='resp-menu'></ul>");
	$('.head_menu .menu > li').each(function(index) {
		var thisli = $(this).clone();
		$(".resp-menu").append(thisli);
	});
	$('.resp-menu .sub-menu li a').each(function(index) {
		var nowtext = $(this).text();
		var newtext = "- " + nowtext;
		$(this).text(newtext);
	});
		
	//$('#gallery_buttons a').animate({'background-position' : '0 0px'},1);
	//$('.subfooter').slideUp(1);
	content_setup();
	/*MainMenu SetUp
	================*/
	$('ul.menu').superfish();
	$('.menu').find('li:has(ul)').addClass('has-menu');
	$('.menu').find('li').each(function(){
		cur_link = $(this).children("a");
		if (!$(this).parent('ul').hasClass('sub-menu')) {
			//$('#mobile_select').append('<option value='+cur_link.attr("href")+'>'+cur_link.text()+'</option>');
		}
		else if (!$(this).parent('ul').hasClass('level1')) {
			//$('#mobile_select').append('<option value='+cur_link.attr("href") +'> -- '+cur_link.text()+'</option>');
		}
		else {
			//$('#mobile_select').append('<option value='+cur_link.attr("href") +'> - '+cur_link.text()+'</option>');
		}
	});
	$('#mobile_select').change(function(){
		//window.location.hash = $(this).find									
		select_val = $(this).val();		
		window.location = select_val;
	});	
			
	/*Supersized Animation
	=======================*/
	$('#btn_show').slideUp(1);
	$('#hide_gallery').click(function(){
		$('#gallery_buttons').stop().animate({'opacity' : 0},250);
		$('.supersized').stop().animate({'top' : '-4px', 'height' : '36px'}, 300, function(){
			$('#btn_show').slideDown(250);
			$('.supersized').addClass('hided');
		});
		
	});
	$('.btn_show').click(function(){
	  	$('#btn_show').slideUp(250,function(){
			$('.supersized').removeClass('hided');
			$('#gallery_buttons').stop().animate({'opacity' : 1},250);
			$('.supersized').stop().animate({'top' : '-69px', 'height' : '68px'}, 300);
		});		
	});
	
	/*Footer Toggler*/
	$('.footer_toggler').click(function(e){
		e.preventDefault();
		if(!$(this).hasClass('clicked')) {
			$(this).toggleClass('clicked');
			$('.subfooter').slideDown(600, 'easeOutCirc');			
		}
		else {
			$(this).toggleClass('clicked');			
			$('.subfooter').slideUp(500, 'easeOutCirc');		
		}
		var deviceAgent = navigator.userAgent.toLowerCase();
		var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);						   
		if (agentID) {		
			setTimeout('$("html:not(:animated)" +( !$.browser.opera ? ",body:not(:animated)" : "")).animate({ scrollTop: $(document).height()}, 600 );  return false',600);
		}
		
	});
	/*Cookie Works
	===============*/
	if($.cookie("cookie_layout")) {
		$('#css_layout').attr('href', 'css/layout/'+$.cookie("cookie_layout")+'.css');
	}		
	if($.cookie("cookie_skin")) {
		$('#css_skin').attr('href', 'css/'+$.cookie("cookie_skin")+'.css');
	}
	else {
		$('#css_skin').attr('href', 'css/skin_light.css');
	}
	if($.cookie("cookie_color")) {
		$('#css_color').attr('href', 'css/colors/'+$.cookie("cookie_color")+'.css');
	}
	else {
		$('#css_color').attr('href', 'css/colors/color_green.css');
	}
	if($.cookie("cookie_pattern")) {
		$('#css_pattern').attr('href', 'css/patterns/'+$.cookie("cookie_pattern")+'.css');
	}			
	
	/*Map Script
	=============*/
	$('a.show_map').click(function(){
		$(this).toggleClass('hide_map');
		$('.map_container').slideToggle(400);
	});
	
	/*Blog Scripts
	===============*/
	$('.like a').click(function(){
		$(this).toggleClass('clicked');
	});
	$('.btn_tags').click(function(){
		$(this).next('.blog_tags').slideToggle(300);
	});
	$('.blog_2col').find('.blog_post_preview:odd').after('<div class="clear"></div>');

	/*Tabs
	=======*/
	// tab setup
	$('.tab-content').addClass('clearfix').not(':first').hide();
	$('ul.tabs').each(function(){
		var current = $(this).find('li.current');
		if(current.length < 1) { $(this).find('li:first').addClass('current'); }
		current = $(this).find('li.current a').attr('href');
		$(current).show();
	});
	
	// tab click
	$('ul.tabs a[href^="#"]').live('click', function(e){
		e.preventDefault();
		var tabs = $(this).parents('ul.tabs').find('li');
		var tab_next = $(this).attr('href');
		var tab_current = tabs.filter('.current').find('a').attr('href');
		$(tab_current).hide();
		tabs.removeClass('current');
		$(this).parent().addClass('current');
		$(tab_next).show();
		return false;
	});	

	$('#flickr').jflickrfeed({
		limit: 9,
		qstrings: {
		id: '40962351@N00'
	},
	itemTemplate: '<li><a href="{{image_b}}" style="display:block;position:relative;" class="flickrPhoto"><img src="{{image_s}}" alt="{{title}}" class="bordered1" width="56" height="56"/></a></li>'
	}, function(){
		$('a.flickrPhoto').prettyPhoto();
		content_setup();
	});
	
	$('.btn_win_close').click(function(){
		$('.block404').slideUp(400);
	});
	
	$('.feedback_go').click(function(){
		var par = $(this).parents("#contact");
		var name = par.find(".field-name").val();
		var email = par.find(".field-email").val();
		var message = par.find(".field-message").val();
		
		
		$.ajax({
			url: "mail.php",
			type: "POST",
			data: { name: name, email: email, message: message },
			success: function(data) {
				$('.ajaxanswer').hide().empty().html(data).show("slow");
		  }
		});


	});

});

$(window).resize(function(){
	content_setup();
});

$(window).load(function(){
	content_setup();
});

function content_setup() {
	//$(".content_block").preloader();
	var deviceAgent = navigator.userAgent.toLowerCase();
	var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);						   
	if (agentID) {		
		$('.content_wrapper').height($(document).height());
		$('footer').css({'position' : 'absolute', 'top' : $(document).height()-36+'px'});
	}	
}