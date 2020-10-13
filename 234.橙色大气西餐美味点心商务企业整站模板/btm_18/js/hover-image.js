$(document).ready(function() { 
	$(".lightbox-image").append("<span></span>");
	
	$('.lightbox-image')
		.live('mouseenter',function(){
			$(this).find("span").stop()
			.animate({top:'0%'},{duration:350, easing:'easeOutQuart'});
		})
		.live('mouseleave',function(){
			$(this).find("span").stop()
			.animate({top:'-100%'},{duration:350, easing:'easeOutQuart'});
	});
});