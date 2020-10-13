/**
 * 判断字符串结束字符串是否为s
 * @param {Object} s
 * @memberOf {TypeName} 
 * @return {TypeName} 
 */
String.prototype.endWith=function(s){
  if(s==null||s==""||this.length==0||s.length>this.length){
	 return false;
  }
  if(this.substring(this.length-s.length)==s){
	 return true;
  }
  else{
	 return false;
  }
  return true;
};

/**
 * 判断字符串开始字符串是否为s
 * @param {Object} s
 * @memberOf {TypeName} 
 * @return {TypeName} 
 */
String.prototype.startWith=function(s){
  if(s==null||s==""||this.length==0||s.length>this.length){
   return false;
  }
  if(this.substr(0,s.length)==s){
	 return true;
  }
  else{
	 return false;
  }
  return true;
};
/* 方法:Array.remove(dx)
   * 功能:删除数组元素.
   * 参数:dx删除元素的下标.
   * 返回:在原数组上修改数组
   */
//经常用的是通过遍历,重构数组.
Array.prototype.remove=function(dx)
{
    if(isNaN(dx)||dx>this.length){return false;}
    for(var i=0,n=0;i<this.length;i++)
    {
        if(this[i]!=this[dx])
        {
            this[n++]=this[i]
        }
    }
    this.length-=1
}
//去除json中的换行符单引号双引号
String.prototype.toValidJson=function(){
  	v = this;
  	if(v != undefined && v != null && v != ""){
	  	v=v.toString().replace(new RegExp('(["\"])', 'g'),"\\\""); 
		v=v.replace(/[\r\n]/g, "");
		v= v.replace(/\"/g," ");
		v = v.replace(/\'/g," ");
		v = v.replace(/&quot;/g," ");
		v = v.replace(/&#39;/g," ");
  	}
	return v;
};
/**
 * 删除逗号分割的字符串里的逗号分割字符串
 * @param {Object} strs 如 a,b,c,d,e
 * @param {Object} delStrs 如 b,e
 * return 如 a,c,d
 */
jQuery.removeStrsFromStrs=function(strs,delStrs){
	var nowVal = "";
	var arry = strs.split(",");
	var delArray = delStrs.split(",");
	if(delArray.length>0){
		for(var i=0;i<delArray.length;i++){
				if(arry.length>0){
					for(var j=0;j<arry.length;j++){
						if(arry[j]==delArray[i]){
							arry.remove(j);
						}
					}
				}
		}
	}
	if(arry.length>0){
		for(var i=0;i<arry.length;i++){
			if(nowVal==""){
				nowVal = arry[i];
			}else{
				nowVal += ","+ arry[i];
			}
		}
	}
	return nowVal;
}
jQuery.csCore={		
	postData:function (url,formData) {		
		var returnData;
		$.ajax( {
			url : url,
			type : "POST",
			dataType : "json",
			async : false,
			cache : false,
			data : formData,
			success : function(data) {
				returnData = data;
			}
		});
		return returnData;
	},
	getData:function (url) {
		url = encodeURI(url);
		var d;
		$.ajax({
			url: url,
			async: false,
			cache:false,
			success: function (data, textStatus, jqXHR) {
				d = data;
			},
			error: function (jqXHR, textStatus, errorThrown) {
				d = jqXHR;
			}
		});
		return d;
	}
};

jQuery.csDate={
	formatDateTime:function (date) {
		if(!$.csValidator.isNull(date)){
			var newDate = new Date(date);
			return newDate.pattern("yyyy-MM-dd HH:mm:ss");
		}
		return "";
	},
	getNow:function(){
		return new Date().pattern("yyyy年MM月dd日 EEE");
	},
	getChinaNowDate:function(date){
		return new Date(date).pattern("yyyy年MM月dd日");
	},
	formatDate:function (date) {
			if(!$.csValidator.isNull(date)){
				var newDate = new Date(date);
				return newDate.pattern("yyyy-MM-dd");
			}
			return "";
	},
	timestamp:function() {
		return new Date().pattern("yyyyMMddHHmmssSe")
	},
	/* 
	用途：检查开始日期是否小于等于结束日期
	输入： 
	s：字符串 开始日期 格式：2001-5-4

	e：字符串 结束日期 格式：2002-5-4
	返回： 
	如果通过开始日期小于等于结束日期返回true,否则返回false 
	 */
	data_compare : function(s, e) {
		var arr = s.split("-");
		var starttime = new Date(arr[0], arr[1], arr[2]);
		var starttimes = starttime.getTime();

		var arrs = e.split("-");
		var endtime = new Date(arrs[0], arrs[1], arrs[2]);
		var endtimes = endtime.getTime();

		if (starttimes >= endtimes) {
			//alert('开始时间大于离开时间，请检查');
			return false;
		} else
			return true;
	},
	//字符串转date
	StringToDate: function (s) 
	{  
	    var d = new Date(); 
	    d.setYear(parseInt(s.substring(0,4),10)); 
	    d.setMonth(parseInt(s.substring(5,7)-1,10)); 
	    d.setDate(parseInt(s.substring(8,10),10)); 
	    d.setHours(parseInt(s.substring(11,13),10)); 
	    d.setMinutes(parseInt(s.substring(14,16),10)); 
	    d.setSeconds(parseInt(s.substring(17,19),10)); 
	    return d;  
	} 

};

jQuery.csValidator={
	isNull:function(val){
		if(val == null || val == "" || val == "undefined" || val == "null" || val == "NULL"){
			return true;
		}
		return false;
	},
	replaceNull:function(str){
		return $.csValidator.isNull(str)?"":str;
	},
	//校验邮箱
	isEmail:function(val){
		var patrn = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if (!patrn.exec(s)) return false 
		return true 
	},
	//校验手机号
	isMobil:function(s){
		var patrn=/^[+]{0,1}(\d){1,3}[ ]?([-]?((\d)|[ ]){1,12})+$/; 
		if (!patrn.exec(s)) return false 
		return true 
	},
	//校验正整数
	isPositiveInt:function(s){
		var patrn=/^[0-9]*[1-9][0-9]*$/; 
		if (!patrn.exec(s)) return false 
		return true 
	},
	//校验普通电话、传真号码：可以“+”开头，除数字外，可含有“-”
	isTel:function(s){ 
		var patrn=/^[+]{0,1}(\d){1,3}[ ]?([-]?((\d)|[ ]){1,12})+$/; 
		if (!patrn.exec(s)) return false 
		return true 
	},
	//校验邮政编码 
	isPostalCode:function (s) { 
		var patrn=/^[a-zA-Z0-9 ]{3,12}$/; 
		if (!patrn.exec(s)) return false 
		return true 
	} 
};

jQuery.csControl={
	getFormData:function (containerID) {
		var result = "{";
		var elements = "";
		elements += '#'+containerID+' input[type=text],';
		elements += '#'+containerID+' input[type=password],';
		elements += '#'+containerID+' input[type=hidden],';
		elements += '#'+containerID+' textarea,';
		elements += '#'+containerID+' select,';
		elements += '#'+containerID+' input[type=checkbox],';
		elements += '#'+containerID+' input[type=radio]';
		$(elements).each(
			function(){
				if($(this).attr('type') == 'radio' || $(this).attr('type') == "checkbox"){
					if($(this).attr('checked') =='checked' || $(this).attr('checked') ==true){
						result += $.csControl.appendElement(this);
					}
				}else if(this.options){
					var selectName = $(this).attr('name');
					if($.csValidator.isNull(selectName)){
						selectName = $(this).attr('id');
					}
					var selectVal = "";
					$(this).find("option").each(function(){
						//alert(1);
						if($(this).attr("selected")=="selected"){
							selectVal = $(this).attr("value");
						}
					});
					//selectVal = selectVal.replace(/\"/g," ");
					//selectVal = selectVal.replace(/\'/g," ");
					result +='"' + selectName + '":"' + selectVal + '",';
				}
				else{
					result += $.csControl.appendElement(this);
				}
			}
		);
		if(result.endWith(","))
		{
			result = result.substring(0,result.length-1);
		}
		result += "}";
		return result;
	},
	appendElement:function(element){
		var name = $(element).attr('name');
		if($.csValidator.isNull(name)){
			name = $(element).attr('id');
		}
		if(!$.csValidator.isNull(name)){
			var val = $(element).val();
			
			if(!$.csValidator.isNull(val)){
				val = val.toValidJson();
				$("#"+name).parents("dl").find("dd ul li").each(function(){					
					if($.trim($(this).html())==$.trim(val)){
						val = $(this).attr("value");
					}
				});
				
			}
			
			
			return '"' + name + '":"' + val + '",';
		}
		return "";
	},getDataFromUrl:function(keyName){
		var url = location.href;
		//url解码
		url = decodeURIComponent(url);
		var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
		var paraObj = {}
		for (i = 0; j = paraString[i]; i++) {
			paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j
					.indexOf("=") + 1, j.length);
		}
		var returnValue = paraObj[keyName.toLowerCase()];
		if (typeof (returnValue) == "undefined") {
			return "";
		} else {
			return returnValue;
		}
	},
	//ajax加载html
	loadHtml:function(url) {
	var content = "";
	jQuery.ajax( {
		url : url,
		async : false,
		dataType : 'html',
		cache : false,
		error : function() {
				
		},
		success : function(returnHtml) {
			content =  returnHtml;
		}
	});
	return content;
	}
};
/**   
 * 对Date的扩展，将 Date 转化为指定格式的String   
 * 月(M)、日(d)、12小时(h)、24小时(H)、分(m)、秒(s)、周(E)、季度(q) 可以用 1-2 个占位符   
 * 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)   
 * eg:   
 * (new Date()).pattern("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423
 * (new Date()).pattern("yyyy-MM-dd e HH:mm:ss") ==> 2009-03-10 2 20:09:04
 * (new Date()).pattern("yyyy-MM-dd E HH:mm:ss") ==> 2009-03-10 二 20:09:04   
 * (new Date()).pattern("yyyy-MM-dd EE hh:mm:ss") ==> 2009-03-10 周二 08:09:04   
 * (new Date()).pattern("yyyy-MM-dd EEE hh:mm:ss") ==> 2009-03-10 星期二 08:09:04   
 * (new Date()).pattern("yyyy-M-d h:m:s.S") ==> 2006-7-2 8:9:4.18   
 */    
Date.prototype.pattern=function(fmt) {     
    var o = {     
    "M+" : this.getMonth()+1, //月份     
    "d+" : this.getDate(), //日     
    "h+" : this.getHours()%12 == 0 ? 12 : this.getHours()%12, //小时     
    "H+" : this.getHours(), //小时     
    "m+" : this.getMinutes(), //分     
    "s+" : this.getSeconds(), //秒     
    "q+" : Math.floor((this.getMonth()+3)/3), //季度     
    "S" : this.getMilliseconds() //毫秒     
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
    if(/(y+)/.test(fmt)){     
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));     
    }     
    if(/(E+)/.test(fmt)){     
        fmt=fmt.replace(RegExp.$1, ((RegExp.$1.length>1) ? (RegExp.$1.length>2 ? "星期" : "周") : "")+week[this.getDay()+""]);     
    }
    if(/(e+)/.test(fmt)){     
        fmt=fmt.replace(RegExp.$1, ((RegExp.$1.length>1) ? (RegExp.$1.length>2 ? "星期" : "周") : "")+this.getDay());     
    }
    for(var k in o){     
        if(new RegExp("("+ k +")").test(fmt)){     
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));     
        }     
    }     
    return fmt;     
}