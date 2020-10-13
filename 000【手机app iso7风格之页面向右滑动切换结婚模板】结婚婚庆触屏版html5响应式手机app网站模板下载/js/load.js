$(document).ready(function () {
	containerHeight = $('.blogheight').height();						
	$(".blogheight").css({height: containerHeight})						
	$(".posts li").hide();	
    size_li = $(".posts li").size();
    x=3;
    $('.posts li:lt('+x+')').show();
    $('#loadMore').click(function () {
        x= (x+1 <= size_li) ? x+1 : size_li;
        $('.posts li:lt('+x+')').show();
        if(x == size_li){
            $('#loadMore').hide();
			$('#showLess').show();
        }
    });
});
