$(document).ready(function(){

	//����
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
	
	//���ض���
//	$("#w_hidnav").scroll(
//		function(){//����������ʾ
//			if($("#w_hidnav").scrollTop()>200){
//				$("#gotop").show();
//			}else{
//				$("#gotop").hide();
//			}
//		}
//	);
//	$("#gotop").click(function(){//���Ʒ��ض���
//	$("#w_hidnav").animate({scrollTop:0},0);
//		return false;
//	}); 
	
	//��ʱ����
	//$("#weibo_pl").load(function(){
		//$(window).scrollTop($("#weibo_pl").offset().top);
	//});
	

	
	/**
	 * ���ض�������
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
	
	//���ض������
	_objscroll.gotopdiv.click(function(){//���Ʒ��ض���
		_objscroll.win.scrollTop(0);
		return false;
		
	}); 
	
	

	//�û�������
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
	
	//ҳ��հ׵�� ͷ�񵯳�����ʧ
	$(document).click(function(){
		if (usermenu.is(":visible")){
			usermenu.hide();
		}
	});
	
	
	
	//��ǰҳ��ˢ��
	$("#reloadcur").click(function(){
		window.location.href = window.location.href;
	});
	
	//����������
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