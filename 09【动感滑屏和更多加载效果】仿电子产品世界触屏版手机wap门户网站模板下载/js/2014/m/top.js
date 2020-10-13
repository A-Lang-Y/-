$(function(){
	$("#goTopBtn").click(function(){
		var sc=$(window).scrollTop();
		$('body,html').animate({scrollTop:0},500);
	});	
});