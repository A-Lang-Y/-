
$.extend({
	
	//补齐位数  原字符串 补充字符串 总长度  填充方向
	fn_str_pad:function(strsrc,strpad,len,direct){
		var len = len || 2;
		var direct = direct || 0;
		var allflag=1;  //0左 1右
		

		
		direct = direct>2 ? 0 : direct;
		if(typeof(strsrc) != 'string'){
			strsrc = strsrc.toString();
		}
		if(strsrc.length>=len){
			return strsrc;
		}

		for(var i=strsrc.length;i<len;i++){
			switch(direct){
				case 0:
					strsrc = strpad + strsrc;
					break;
				case 1:
					strsrc += strpad;
					break;
				case 2:
					if(allflag%2){
						strsrc = strpad + strsrc;
			        }else{
			        	strsrc += strpad;
			        }
					break;
			}
		}
		return strsrc; 
	}
});


$(document).ready(function(){
	
	//上部滑动
	var iNum=0;
	var iTimer=null;
	$('#f_ifocus_lis > li').first().css({opacity:'1',zIndex:'2'});//默认显示第一张图片
	$('#f_ifocus_btn > a').click(function(){
		iNum = $(this).index();//顺序问题
		$.tabSwitch();
	});

	$.extend({
		set_play:function(){
			iNum++;
			if(iNum==$('#f_ifocus_btn > a').length){
				iNum=0;
			}
			$.tabSwitch();
		},
		tabSwitch:function(){
			$('#f_ifocus_btn > a').removeClass();
			$('#f_ifocus_btn > a').eq(iNum).addClass('f_ifocus_cur');
			$('#f_ifocus_lis > li').css({opacity:'0',zIndex:'1'});
			$('#f_ifocus_lis > li').eq(iNum).stop(true,false).animate({opacity:'1'},500);
			$('#f_ifocus_lis > li').eq(iNum).css('z-index','2');
		}
	});

	iTimer=setInterval($.set_play,2000);
	
	
	
	/**
	 * 图片处理开始
	 */	
	//定义图片属性
	var _objpic = {
		xhr:null, //ajax对象	
		xhrtimer:null, //图片请求超时定时器	
		xhrtimeout:5000, //ajax请求超时时间	
		picload:[], //要处理图片数组	
		picloadtimer:null, //图片加载定时器	
		picloadtimeout:30, //图片加载时间间隔
		picloadi:0, //当前图片索引	
		picloadj:0, //当前图片加载次数	
		picattr:'truesrc', //图片真实路径属性	
		picloadtimerout:null, //图片真实路径属性	
		picloadtimeout:30, //图片真实路径属性	
		picpid:document.getElementById('f_inews_lis_ul'), //ul id
		//复位
		reset:function(){
			this.picloadi=0;
			this.picloadj=0;
		},
		//建立所需要数组
		getloadpic:function(){
			this.picload=[];
			
			var _imgs = this.picpid.getElementsByTagName('img');
			for(var i=0,len=_imgs.length;i<len;i++){
				if(_imgs[i].getAttribute('src').indexOf("static/")!==-1){
					this.picload.push(_imgs[i]);
				}
			}
		},
		//加载图片
		setloadpic:function(){
			var _this = this;
			
		   clearInterval(_this.picloadtimerout);
		   _this.picloadtimerout=setInterval(function(){
			   _this.getloadpic();
			   var picload = _this.picload;
			   if(picload.length>0){
		    	   for(var i=0,len=picload.length;i<len;i++){
		    		   picload[i].src=picload[i].getAttribute(_this.picattr);
		    	   }   
			   }else{
				   clearInterval(_this.picloadtimerout);  
			   }
	       },_this.picloadtimeout);
		}	
	};
	
	//页面加载完 开始加载图片
	_objpic.setloadpic();

	
	//点击加载更多
	$("#a_getmorenews").click(function(){
		
		$("#span_timeout").hide();  //提示文字消失
		$("#div_getmorenews").hide();//加载更多隐藏
		$("#f_loadimg").show();//等待图片出现

		//定义超时函数
		_objpic.xhrtimer = setTimeout(function(){
			_objpic.xhr.abort();//终止请求
			$("#f_loadimg").hide();//等待图片隐藏
			$("#span_timeout").show(); //提示文字出现
			$("#a_getmorenews").text('点击重新加载'); //提示文字友好处理
			$("#div_getmorenews").show();//加载更多出现
		},_objpic.xhrtimeout);
		
		_objpic.xhr = $.ajax({
			url:'web.php@c=wapnews&a=getnewsajax&channelid='+_global_var._channelid+'&page='+_global_var._curpage+'&t='+(new Date()).valueOf(),
			dataType:'json',
			success:function(msg){
				//清除定时器
				clearTimeout(_objpic.xhrtimer);
				
				//等待图片隐藏
				$("#f_loadimg").hide();
				
				if(msg.error==0){
					//拼接数据
					var _newslist=msg.newslist,
				        _strnewslist='';
					for(var i in _newslist){
						var _odate = new Date(parseInt(_newslist[i].publishtime+'000'));
						var _month = $.fn_str_pad(_odate.getMonth()+1,0,2);
						var _date =  $.fn_str_pad(_odate.getDate(),0,2);
						var _strdate = _month+'-'+_date;
						
						_strnewslist +='<li>';
						_strnewslist +='<a class="f_inewsimg" href="'+_newslist[i].newslink+'">';
						_strnewslist +='<img src="'+_global_var._staticdomain+'/static/wapnews/images/defaultpic.png" truesrc="'+_global_var._picdomain+'/'+_newslist[i].photo+'.180x120.jpg" />';
						_strnewslist +='</a>';
						_strnewslist +='<div class="f_inewscon">';
						_strnewslist +='<h4><a href="'+_newslist[i].newslink+'">'+_newslist[i].stitle+'</a></h4>';
						_strnewslist +='<p class="clears">'+_newslist[i].summary+'<span>'+_strdate+'</span></p>';
						_strnewslist +='</div>';
						_strnewslist +='</li>';
					}
					//页码+1
					_global_var._curpage++;
					$("#f_inews_lis_ul").append(_strnewslist);

					$("#span_timeout").hide();  //提示文字消失
					$("#a_getmorenews").text('点击加载更多').show();//加载更多出现
					$("#div_getmorenews").show();
				//无数据
				}else if(msg.error==1){
					$("#div_getmorenews").text('没有更多数据').css({color:'red'}).show();
				}else{
					//异常
				}
				
				//继续加载图片
				_objpic.setloadpic();
			}
		});
	});
	
	
	//搜索框
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
	
	//点击form提交
	$("#form_search").submit(function(){
		if($.trim(_obj_query.val())=='' || $.trim(_obj_query.val())==_default_text){
			return false;
		}
		return true;
	});
	
	
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
	
});