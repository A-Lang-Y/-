$(document).ready(function() { 
	$(".list-services .tooltips").easyTooltip();
}); 

$(window).load(function() {
	$('#bgSlider').bgSlider({
		duration:1000,
		pagination:'.pagination',
		preload:true,
		slideshow:30000,
		spinner:'.bg_spinner'
	});
});