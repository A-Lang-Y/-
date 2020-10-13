$(function(){
	$(".click_more").click(function(){
		$(this).hide();
		$(this).next().toggle();	
	});
});
