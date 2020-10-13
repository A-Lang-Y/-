$(function() { 
	$('.list-services a')
	.hover(function(){
		$(this).stop().animate({opacity:.5}, {duration:300})
	}, function(){
		$(this).stop().animate({opacity:1}, {duration:300})
	});
}); 