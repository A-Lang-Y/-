 $(function(){
	showTip =  function(data) {var html = '<div class="float_div" style="border-radius:3px;position:fixed;top:0;left:0;background:rgba(0,0,0,0.8);padding:15px 0px 7px;min-width:100px;opacity:1;min-height:25px;text-align:center;color:#fff;display:block;z-index:999">'+data+'</div>';
	$('body').append($(html).css({'position':'absolute','display':'none','width':'242px','height':'30px'}));
	var $t = $('.float_div');
	 var winW = $(window).width()
			 	,winH = $(window).height()/2+$(window).scrollTop()
			 	,altW = $t.width()
			 	,altH = $t.height()
	$t.css({'top':winH+'px','left':(winW-altW)/2+'px'}).fadeIn(0).delay(2500).animate({top: ($(window).height()+$(window).scrollTop()-$t.height()*11)+'px' ,opacity: "hide"}, 0, function() {
            $t.remove();               
        });
        
	};
});


