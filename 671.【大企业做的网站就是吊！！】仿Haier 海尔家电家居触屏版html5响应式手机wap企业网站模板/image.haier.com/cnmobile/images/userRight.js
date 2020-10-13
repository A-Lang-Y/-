jQuery(function(){
		loadUser();
		
		//读取用户信息条数，三秒后执行
		getMessNum();
		jQuery(".logout").attr("href", "../../../../user.haier.com/ids/cn/haier_logout.jsp@returnUrl=_2Fcnmobile_2F");
});

function getMessNum(){
	createIframeCallBack(function(){
		jQuery.ajax({
			type: "post",
			dataType: "json",
			url: "../../../HaierBBS/bbsmessage/getNoReadMess.do@rdm="+Math.random(),
			data:{},
			error : function(XMLHttpRequest, textStatus, errorThrown){
				return "error";
			},
			success: function(data){
				if(data.isSuccess==true){
					$("#messNum").html("<em>"+data.newpm+"</em>");
				}else{
					$("#messNum").hide();
				}
			}
		});                             
	});
}
function createIframeCallBack(fn) {
	  var iframe = document.createElement("iframe");   
	  iframe.src = "../../../HaierBBS/index.jsp";
	  iframe.width = "0px";
	  iframe.height = "0px";  
	  if(iframe.attachEvent){   
			  iframe.attachEvent("onload", fn);   
	  }else{   
			  iframe.onload = fn;   
	  }
	  $(".js_check_login").remove();
	  $("<div class='js_check_login' style='display:none'></div>").html(iframe).appendTo("body");
}
function logout(){
	window.location.href = "../../../HaierFramework/logoutSendRedirect.jsp@param=_2Fids_2Fcn_2Fhaier_logout.jsp@returnUrl=_2Fcnmobile_2F";
}
function loadUser(){
	if(!istrsidssdssotoken()){
		//用户未登录
		var returnUrl = window.location.href;
		var base = new Base64();
		var path = base.encode("../../../HaierFramework/loginSendRedirect.jsp@param="+returnUrl);
		window.location.href = "../../../ids/mobile/login.jsp@returnUrl="+path;
	}else{
		loadUserinfo();
	}
}
//用户信息
function loadUserinfo(){
	var surl = "../../../HaierFramework/haier/appuser/queryAppuserMo.do";
	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: surl,
		data: {
		},
		error : function(XMLHttpRequest, textStatus, errorThrown){
			return "error";
		},
		success: function(returnData){
			//用户名
			var userName = returnData.appuser.username;
			jQuery(".userName").html(userName);
			jQuery("#bind_userName").val(userName);//绑定手机页面使用
			//上次登录时间
			var lastlogindate = returnData.appuser.lastlogindate;
			jQuery("#lastlogindate").html(lastlogindate);
			//头像,头像存储全路径
			var headPath = returnData.appuser.headPath;
			if(headPath!=null && headPath.length > 0 && headPath.indexOf("http:") > -1){
				jQuery(".headPic").attr("src", headPath);
			}else{
				jQuery(".headPic").attr("src", "../../../cnmobile/images/defaultHeadPic_96.jpg");
			}
			
			//星级 22%  50%  79%  
			var starUser = returnData.appuser.starUser;
			var loginByVip = returnData.appuser.loginByVip;
			if(starUser == 0 && loginByVip == 0){
				jQuery("#starUser").hide();
				jQuery("#myPoints").hide();
				jQuery("#myright").hide();
			}else if( starUser == 1 || loginByVip == 1 ){
				jQuery("#starUser").show();
				jQuery("#starUser_1").addClass("star1");
				jQuery("#starUser_2").addClass("star2");
				jQuery("#starUser_3").attr("style", "width:22%");
			}else if( starUser == 2){
				jQuery("#starUser").show();
				jQuery("#starUser_1").addClass("star2");
				jQuery("#starUser_2").addClass("star3");
				jQuery("#starUser_3").attr("style", "width:50%");
			}else if( starUser == 3){
				jQuery("#starUser").show();
				jQuery("#starUser_1").addClass("star3");
				jQuery("#starUser_2").addClass("star3");
				jQuery("#starUser_3").attr("style", "width:100%");
			}
			//梦想积分
			var score = returnData.appuser.score;
			jQuery("#score").html(score);
			
			
		}
	});		
}

//时间转换
function formartDate(dataFormate, time) {
	var date = new Date();
	date.setTime(time);
	return date.pattern(dataFormate);
}
Date.prototype.pattern = function(fmt) {
	var o = {
		"M+" : this.getMonth() + 1, //月份     
		"d+" : this.getDate(), //日     
		"h+" : this.getHours() % 12 == 0 ? 12 : this.getHours() % 12, //小时     
		"H+" : this.getHours(), //小时     
		"m+" : this.getMinutes(), //分     
		"s+" : this.getSeconds(), //秒     
		"q+" : Math.floor((this.getMonth() + 3) / 3), //季度     
		"S" : this.getMilliseconds()
	//毫秒     
	};
	var week = {
		"0" : "日",
		"1" : "一",
		"2" : "二",
		"3" : "三",
		"4" : "四",
		"5" : "五",
		"6" : "六"
	};
	if (/(y+)/.test(fmt)) {
		fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "")
				.substr(4 - RegExp.$1.length));
	}
	if (/(E+)/.test(fmt)) {
		fmt = fmt.replace(RegExp.$1,
				((RegExp.$1.length > 1) ? (RegExp.$1.length > 2 ? "星期" : "周")
						: "")
						+ week[this.getDay() + ""]);
	}
	if (/(e+)/.test(fmt)) {
		fmt = fmt.replace(RegExp.$1,
				((RegExp.$1.length > 1) ? (RegExp.$1.length > 2 ? "星期" : "周")
						: "")
						+ this.getDay());
	}
	for ( var k in o) {
		if (new RegExp("(" + k + ")").test(fmt)) {
			fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k])
					: (("00" + o[k]).substr(("" + o[k]).length)));
		}
	}
	return fmt;
}