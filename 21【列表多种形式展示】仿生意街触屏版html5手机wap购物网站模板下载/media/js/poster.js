$(function(){ 
		$(".sub_message").click(function(){ 
			$(".message_box").show();
			$(".head_icon3").hide();
			$(".head_icon2").hide();
			$(".poster_bottom").hide();
			$(".bj_color").css({"background":"#000","opacity":"0.5"});
		});
		
		$(".message_box .subCen_p1 img").click(function(){ 
			$(".message_box").hide();
			$(".head_icon3").show();
			$(".head_icon2").show();
			$(".poster_bottom").show();
			$(".bj_color").css({"background":"#000","opacity":"1"});
			
		});
		
	});