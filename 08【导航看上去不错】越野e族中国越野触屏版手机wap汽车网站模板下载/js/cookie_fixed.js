$(document).ready(function(){
	//cookie扩展
	$.extend({
		fn_getcookie:function(name){
			var _cookie=document.cookie;
			//切割
			var _arrcookie=_cookie.split('; ');
			var _cookietmp = '';
			for(var i=0,len=_arrcookie.length;i<len;i++){
				_cookietmp = _arrcookie[i].split('=');
				if(_cookietmp[0]==name){
					return unescape(_cookietmp[1]);
				}
			}
			return '';
		},
		fn_setcookie:function(name,value,expiretime){
			var _odate = new Date();
			_odate.setSeconds(_odate.getSeconds()+expiretime);
			//cookie.setPath("default.htm");
			document.cookie=name+'='+escape(value)+';expires='+_odate.toGMTString()+";path=/";
		},
		fn_clearcookie:function(name){
			this.fn_setcookie(name,'',-1);
		}
	});
	
	//app弹出层处理
	$("#app_close").click(function(){
		$("#app_pop").hide();
		$("#g_detailh").css("marginTop","0px");
		//记录cookie
		$.fn_setcookie('cmswapapp','1',86400);	
	});
	
	//页面加载,判断cookie是否存在
	var _cmswapcookie = $.fn_getcookie('cmswapapp');	
	if(_cmswapcookie==''){
		$("#app_pop").show();
		$("#g_detailh").css("marginTop","50px");
	}
	
});