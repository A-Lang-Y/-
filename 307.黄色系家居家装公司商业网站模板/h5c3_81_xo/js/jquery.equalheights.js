(function($){$.fn.equalHeights=function(minHeight,maxHeight){tallest=(minHeight)?minHeight:0;this.each(function(){if($(this).height()>tallest){tallest=$(this).height()}});if((maxHeight)&&tallest>maxHeight)tallest=maxHeight;return this.each(function(){$(this).height(tallest)})}})(jQuery)
$(window).load(function(){
	if($(".maxheight").length){
	$(".maxheight").equalHeights()}
})

$(window).load(function(){
	if($(".maxheight2").length){
	$(".maxheight2").equalHeights()}
})