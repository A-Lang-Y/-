$(window).load(function(){


$(".fadehover a.b img").hover(
function() {
	$(this).stop().animate({"opacity": "1"}, "slow");
},
function() {
	$(this).stop().animate({"opacity": "0"}, "slow");
});
 
});