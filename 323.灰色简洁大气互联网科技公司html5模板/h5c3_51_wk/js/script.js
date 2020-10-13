$(function() { 
	$('.list-services a').hover(
	function(){$(this).stop().animate({opacity:.6}, {duration:250})},
	function(){$(this).stop().animate({opacity:1}, {duration:250})});
}); 