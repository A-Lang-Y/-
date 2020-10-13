$(window).load(function() {
	$('body').append('<div class="image_roll_shadow"></div>');
	connectImage();
	blogImageHover();
});
$(window).resize(function() {
	$('.blog_content_image').unbind('mouseenter');
	$('.blog_content_image').unbind('mouseleave');
	connectImage();
	blogImageHover();
});

function blogImageHover() {
	var blogMinHeight = $('.blog_content_inner').width()*135/560;
	var blogMaxHeight = $('.blog_content_inner').width()*215/560;
	if($('body').width() < 960) {
		$('.blog_content_image').height(blogMaxHeight)
			.find('.blog_content_slider').css({marginTop:0});
	}
	else {
		$('.blog_content_image').height(blogMinHeight)
			.find('.blog_content_slider').css({marginTop:-40});
		
		$('.blog_content_image').hover(function(){
			$(this).stop(true).animate({height:blogMaxHeight}, 1000, 'easeOutBounce');
			$(this).find('.blog_content_slider').stop(true).animate({marginTop: 0}, 1000, 'easeOutBounce');	
		}, function(){
			$(this).stop(true).animate({height:blogMinHeight}, 500, 'easeOutQuint');
			$(this).find('.blog_content_slider').stop(true).animate({marginTop: -40}, 500, 'easeOutQuint');	
		});
	}
}
	
function connectImage(){
	$('.image_rollover').unbind('hover').conRollover('content');
	$('.image_rollover_top').unbind('hover').conRollover('top');
	$('.image_rollover_right').unbind('hover').conRollover('right');
	$('.image_rollover_bottom').unbind('hover').conRollover('bottom');
	$('.image_rollover_left').unbind('hover').conRollover('left');
	
}

$.fn.conRolloverWithCheck = function(a) {
	if (!a) var a =false;
	$(this).find('.image_rollover').unbind('hover').conRollover('content',a);
	$(this).find('.image_rollover_top').unbind('hover').conRollover('top',a);
	$(this).find('.image_rollover_right').unbind('hover').conRollover('right',a);
	$(this).find('.image_rollover_bottom').unbind('hover').conRollover('bottom',a);
	$(this).find('.image_rollover_left').unbind('hover').conRollover('left',a);
}

$.fn.conRollover = function(a) {
	
	var lstart,lend;
	var tstart,tend;
	var type;
	cnt = false;
	var bugFix;
	bugFix = false;
	type = arguments[0];
	var counter = true;
	if(arguments.length>1 && arguments[1]==true){
		bugFix=true;
	}
	
	
	switch (type)
	{
		case 'top' : lstart='0'; lend='0'; tstart='-100%'; tend='0'; break;
		case 'right' : lstart='100%'; lend='0'; tstart='0'; tend='0'; break;
		case 'bottom' : lstart='0'; lend='0'; tstart='100%'; tend='0'; break;
		case 'left' : lstart='-100%'; lend='0'; tstart='0'; tend='0'; break;
		case 'content' :cnt=true; break;
	}
	
	$(this).each(function(){
		if($(this).find('.image_roll_zoom').length>0) {
			$(this).find('.image_roll_zoom').remove();
		}
		
		if(type != 'content') $(this).append('\n<div class="image_roll_zoom"><div style="padding:'+($(this).height()/2 - ($(this).height()>=150 ? 25 : $(this).height()/8)) +'px 0; font-size:'+($(this).height()>=150 ? 50 : $(this).height()/4)+'px;  height:'+($(this).height()>=150 ? 50 : $(this).height()/4)+'px" class="image_roll_text">'+$(this).attr('data-description')+'</div></div>');
	})
	
	if(cnt)
	{
		
		$(this).hover(function(){
			if(bugFix){
        		$(this).css('z-index', '101').find('.image_roll_info').stop(true, true).delay(600).animate({bottom: 0},500);
				$('.image_roll_shadow').stop(true,true).delay(600).fadeIn(400);
			}
			else{
        		$(this).css('z-index', '101').find('.image_roll_info').stop(true, true).animate({bottom: 0},500);
				$('.image_roll_shadow').stop(true,true).fadeIn(200);
			}
 		},function() {
			if(bugFix){
				$(this).css('z-index', '1').find('.image_roll_info').stop(true,true).delay(600).animate({bottom: '-100%'},1000);
				$('.image_roll_shadow').stop(true,true).delay(200).fadeOut(400);
			}
			else
			{
				$(this).css('z-index', '1').find('.image_roll_info').stop(true,true).animate({bottom: '-100%'},1000);
				$('.image_roll_shadow').stop(true,true).fadeOut(200);
			}
    	});	
		
	}
	else
	{
		$(this).hover(function(){
			$(this).find('.image_roll_zoom').stop(true, true).animate({left: lend, top:tend},200);
			$(this).find('.image_roll_glass').stop(true, true).fadeIn(200);
 		},function() {
			$(this).find('.image_roll_zoom').stop(true).animate({left:lstart, top:tstart},200);
			$(this).find('.image_roll_glass').stop(true, true).fadeOut(200);
    	});
	}
	
	
	
} 