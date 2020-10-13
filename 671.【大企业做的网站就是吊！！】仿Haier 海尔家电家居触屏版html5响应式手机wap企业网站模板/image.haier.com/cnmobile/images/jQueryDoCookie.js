var jq = jQuery.noConflict();
jq.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
       var expires = '';
       if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
           var date;
           if (typeof options.expires == 'number') {
               date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
               date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        var path = options.path ? '; path=' + options.path : '';
        var domain = options.domain ? '; domain=' + options.domain : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
           var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
function getcookie(name) {
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	return cookie_start == -1 ? '' : unescape(document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length)));
}
function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
    var expires = new Date();
    expires.setTime(expires.getTime() + seconds);
    document.cookie = escape(cookieName) + '=' + escape(cookieValue)
                                            + (expires ? '; expires=' + expires.toGMTString() : '')
                                            + (path ? '; path=' + path : '/')
                                            + (domain ? '; domain=' + domain : '')
                                            + (secure ? '; secure' : '');
}
//reURL（产品详细信息跳转路径）、title（产品标题）、model（产品型号）、imageURL（产品图片路径）proprice(产品价格)
function saveCookie(reURL,title,model,imageURL,proprice){
	if(reURL==""){
		return;
	}
	if(title==""){
		return;
	}
	if(model==""){
		return;
	}
	if(imageURL==""){
		return;
	}
	if(proprice==""){
		return;
	}
	var arr2 = new Array();
	var newpro = new Array(reURL,title,model,imageURL,proprice);
	var proshuzu = jq.cookie('productHistory');
	if(proshuzu!=null && proshuzu!=''){
		var ss = proshuzu.split(",");
		for(var l=0; l<ss.length; l++){
			//if(l==2 || l==6 || l==10 || l==14){
			if(l==2 || l==7 || l==12 || l==17){
				if(model==ss[l]){//根据产品型号判断是否重复，如果重复了先把这个产品的五个信息从数组中删除
					ss.splice(l-2,5);
				}
			}
		}
		var proinfos = ss.length;
		var pro = proinfos/5;//当前数组中有多少产品浏览历史
		if(pro>3){//大于三个，得到最新的三个放在当前的数组中
			for(var k=0; k<3; k++){
				var num11 = new Array(ss[5*k],ss[5*k+1],ss[5*k+2],ss[5*k+3],ss[5*k+4]);
				arr2.push(num11);
				pro = pro-1;
			}
		}else{//三个或三个一下直接再把它们重新添加到数组中
			for(var j=pro; j>0; j--){
				var num11 = new Array(ss[j*5-5],ss[j*5-4],ss[j*5-3],ss[j*5-2],ss[j*5-1]);
				arr2.unshift(num11);
			}
		}
	}
	arr2.unshift(newpro);//把当前浏览的产品信息放在数组的最前端
	jq.cookie('productHistory', arr2,{expires: 7,path: ROOT_PATH,domain:'m.haier.com'});
}

//判断当前是否存在同域Cookie
function istrsidssdssotoken(){
	var trsidssdssotoken = "trsidssdssotoken";//同域Cookie
	var sdssotoken = jq.cookie(trsidssdssotoken);
	if(sdssotoken!=null){
		return true;
	}else{
		return false;
	}
}
var $ = jQuery.noConflict();