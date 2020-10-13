$(document).ready(function(){			 
	//Set opacity on each span to 0%
	$(".rollover").css({'opacity':'0'});	
	$(".rollover-zoom").css({'opacity':'0'});	
	$(".rollover-list").css({'opacity':'0'});	
	
	$('ul a').hover(
		function() {
			$(this).find('.rollover').stop().fadeTo(500, 1);
			$(this).find('.rollover-zoom').stop().fadeTo(500, 1);
			$(this).find('.rollover-list').stop().fadeTo(500, 1);
		},
		function() {
			$(this).find('.rollover').stop().fadeTo(500, 0);
			$(this).find('.rollover-zoom').stop().fadeTo(500, 0);
			$(this).find('.rollover-list').stop().fadeTo(500, 0);
		}
	)			
	
	
});	

