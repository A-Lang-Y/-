/* Jquery plugins required for this template 
@ file version: 1.0
@last edit: 03.09.2012, 11:04 PM
-------------------------------------------*/

/* =========================================== MENU */
$(document).ready(function() {
var site = function() {
	this.navLi = $('#nav li').children('ul').hide().end();
	this.init();
};

site.prototype = {
 	
 	init : function() {
 		this.setMenu();
 	},
 	
 	setMenu : function() {
 	
 	$.each(this.navLi, function() {
 		if ( $(this).children('li ul li ul')[0] ) {
 			$(this)
 				.append('<span />')
 				.children('span')
 					.addClass('menuChildren')
 		}
 	}); //Add span element(arrow) to each parrent
 	
 		this.navLi.hover(function() {
 			// mouseover
			$(this).find('> ul').stop(true, true).fadeIn({duration:500});
			$(this).children('a:first').addClass("hov");
 		}, function() {
 			// mouseout
 			$(this).find('> ul').stop(true, true).hide(); 
			$(this).children('a:first').removeClass("hov");			
		}); // Add/remove .hov class
 		
		$('.add_divider_before').append('<span class="menu_divider"></span>'); //This is the menu divider, it is added automaticaly(top) when a li tag has .add_divider class. Ex: <li class="add_divider_before"><a href="#">Text</a></li>
		$('.add_divider_after').append('<span class="menu_divider"></span>'); //This is the menu divider, it is added automaticaly(bottom) when a li tag has .add_divider class. Ex: <li class="add_divider_after"><a href="#">Text</a></li>
		
 	}
 
};
new site();
});

/* =========================================== MENU [responsive] */
$(function () {
	  // TinyNav.js
	  $('#nav').tinyNav({
		active: 'selected',
		header: true,
	  });
});

/* =========================================== Alerts */
$('<span class="alert_close"></span>').prependTo('.alert');
$('.alert_close').click(function () {
    $(this).parent(".alert").slideUp(500); //Set the speed in miliseconds 1000 = 1second
}); //Close alert function


/* =========================================== TABS */
$(document).ready(function() {

	$(".tab_content").hide(); 
	$("ul.tabs li:first").addClass("active").show();
	$(".tab_content:first").show(); 

	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content").hide();

		var activeTab = $(this).find("a").attr("href"); 
		$(activeTab).fadeIn();
		return false; 
	});

});


/* =========================================== ACCORDION */
$(document).ready(function() {
	 
	$('.accordion_button').click(function() {
	
		$('.accordion_button').removeClass('acdn_on');
	 	$('.accordion_container').slideUp('fast');
		
		if($(this).next().is(':hidden') == true) {
			$(this).addClass('acdn_on');
			$(this).next().slideDown('fast');
			$('.accordion_button span').addClass('minus');
		 } 
		  
	 });
	$('.accordion_button').mouseover(function() {
		$(this).addClass('acdn_over');
		
	}).mouseout(function() {
		$(this).removeClass('acdn_over');										
	});
	;
		
	$('.accordion_container').hide();

});


/* =========================================== TOGGLE */
$(".box_toggle .block").show();
	$(".closed .block").hide();
	
	$(".tg_title").click(function(){
		$(this).toggleClass("tgg_isopen").next().slideToggle("fast");
});

/* =========================================== LIGHTBOX */
  jQuery(document).ready(function($){
    $('.lightbox').lightbox();
  });








