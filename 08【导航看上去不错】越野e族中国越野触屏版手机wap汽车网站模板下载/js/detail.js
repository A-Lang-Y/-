$(document).ready(function(){

	//导航
	var oBtn = $("#w_menu");
	var oHid = $("#w_hidnav");
	var oRishow = $("#zhtushow");
	var onOff = true;
	oBtn.click(function(){
		if(onOff == true){
			//oHid.stop().animate({"left":197 + "px"},100);
			//oHid.addClass("changeone");
			oHid.addClass("changeleft");
			oHid.removeClass("lari");
			onOff = false;
		}
		else
		{
			//oHid.stop().animate({"left":0},100);
			//oHid.removeClass("changeone");
			oHid.addClass("lari");
			oHid.removeClass("changeleft");
			onOff = true;
		}
	});
	oRishow.click(function(){
		oHid.addClass("lari");
		oHid.removeClass("changeleft");
		onOff = true;
	});
	oRishow.bind("touchstart touchmove",
		function()
		{
			oHid.addClass("lari");
			oHid.removeClass("changeleft");
			onOff = true;
		}
	);
	
	//返回顶部
//	$("#w_hidnav").scroll(
//		function(){//控制隐藏显示
//			if($("#w_hidnav").scrollTop()>200){
//				$("#gotop").show();
//			}else{
//				$("#gotop").hide();
//			}
//		}
//	);
//	$("#gotop").click(function(){//控制返回顶部
//	$("#w_hidnav").animate({scrollTop:0},0);
//		return false;
//	}); 
	
	//临时调试
	//$("#weibo_pl").load(function(){
		//$(window).scrollTop($("#weibo_pl").offset().top);
	//});
	

	
	/**
	 * 返回顶部处理
	 */
	var _objscroll = {
		win:$(window),	
		doc:$(document),	
		gotopdiv:$('#gotop')	
	};
 	
	_objscroll.win.scroll(function(){
		if(_objscroll.win.scrollTop() > _objscroll.win.height()){
			_objscroll.gotopdiv.show();
		}else{
			_objscroll.gotopdiv.hide();
		}
		
	});
	
	//返回顶部点击
	_objscroll.gotopdiv.click(function(){//控制返回顶部
		_objscroll.win.scrollTop(0);
		return false;
		
	}); 
	
	

	//用户名下拉
	var usermenu = $("#usermenu");
	$("#upic").click(function(){
		if (usermenu.is(":hidden")){
			usermenu.show();
		}
		else
		{
			usermenu.hide();
		}
		return false;
	});
	
	//页面空白点击 头像弹出层消失
	$(document).click(function(){
		if (usermenu.is(":visible")){
			usermenu.hide();
		}
	});
	
	
	
	//当前页面刷新
	$("#reloadcur").click(function(){
		window.location.href = window.location.href;
	});
	
	//搜索框文字
	var _obj_query = $("#query");
	var _default_text = $.trim(_obj_query.val());
	_obj_query.focus(function(){
		if($.trim(_obj_query.val()) == _default_text){
			_obj_query.val('');
		}
	}).blur(function(){
		if($.trim(_obj_query.val()) == ''){
			_obj_query.val(_default_text);
		}
	});
	

	
	
	
	

});