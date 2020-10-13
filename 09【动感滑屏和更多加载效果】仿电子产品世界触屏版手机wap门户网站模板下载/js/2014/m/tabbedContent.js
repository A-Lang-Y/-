//tab effects
var TabbedContent = {
	init: function() {	
		$(".tab_item").mouseover(function() {
			$(".hidden").hide();
			$(".click_more").show();
			var background = $(this).parent().find(".moving_bg");
			
			$(background).stop().animate({
				left: $(this).position()['left']
			}, {
				duration: 300
			});
			
			TabbedContent.slideContent($(this));			
		});
	},
	init2: function() {	
		$(".tabslider ul").bind("swipeleft",function(){
			 TabbedContent.slideContent2($(this));
		});
		
	},
	init3: function() {	
		$(".tabslider ul").bind("swiperight",function(){
			 TabbedContent.slideContent3($(this));
		});		
	},
	
	slideContent: function(obj) {
		
		var margin = $(obj).parent().parent().find(".slide_content").width();
		margin = margin * ($(obj).prevAll().size() - 1);
		margin = margin * -1;
		
		
		$(obj).parent().parent().find(".tabslider").stop().animate({
			marginLeft: margin + "px"
		}, {
			duration: 300
		});
	},
	slideContent2: function(obj) {
		var margin = $(obj).parent().parent().width();			
		margin = margin * ($(obj).prevAll().size());
		
		//求出一共有几个滑动区块		
		var len=($(obj).siblings().size()-1);
		var wid=$(obj).parent().parent().width();		
		var totalwidth=len * wid;
		
			
		margin = margin * -1;
		
		if(margin>=-totalwidth){
			$(obj).parent().parent().find(".tabslider").stop().animate({
				marginLeft: margin + "px"
				
			}, {
				duration: 300
			});
		}
		var index=$(obj).index();		
		
		
		var background =$(obj).parent().parent().parent().find(".moving_bg");
		var tabs=$(obj).parent().parent().parent().find(".tab_item");
		
		$(background).stop().animate({
			left: tabs.eq(index).position()['left']
		}, {
			duration: 300
		});
	},
	
	slideContent3: function(obj) {
		var margin = $(obj).parent().parent().width();			
		margin = margin * ($(obj).prevAll().size()-1);
		
		//求出一共有几个滑动区块		
		var len=($(obj).siblings().size()-1);
		var wid=$(obj).parent().parent().width();		
		var totalwidth=len * wid;
		
			
		margin = -(margin-wid);
		
		
		if(margin <= 0){
			$(obj).parent().parent().find(".tabslider").stop().animate({
				marginLeft: margin + "px"
				
			}, {
				duration: 300
			});
		}
		var index=$(obj).index();
		if(index == 1){
			index=2;
		}
	
		var background =$(obj).parent().parent().parent().find(".moving_bg");
		var tabs=$(obj).parent().parent().parent().find(".tab_item");
		
		
		$(background).stop().animate({
			left: tabs.eq(index-2).position()['left']
		}, {
			duration: 300
		});
	}
}

$(document).ready(function() {
	TabbedContent.init();
	TabbedContent.init2();
	TabbedContent.init3();
});