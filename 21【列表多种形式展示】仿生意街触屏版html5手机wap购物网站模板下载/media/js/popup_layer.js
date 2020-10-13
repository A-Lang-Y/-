Function.prototype.binding = function() {
    if (arguments.length < 2 && typeof arguments[0] == "undefined") return this;
    var __method = this, args = jQuery.makeArray(arguments), object = args.shift();
    return function() {
        return __method.apply(object, args.concat(jQuery.makeArray(arguments)));
    }
}

var Class = function(subclass){
	subclass.setOptions = function(options){
		this.options = jQuery.extend({}, this.options,options);
		for(var key in options){
			if(/^on[A-Z][A-Za-z]*$/.test(key)){
				$(this).bind(key,options[key]);
			}
		}
	}
    var fn =  function(){
        if(subclass._init && typeof subclass._init == 'function'){
            this._init.apply(this,arguments);
        }
    }
    if(typeof subclass == 'object'){
        fn.prototype = subclass;
    }
    return fn;
}

var PopupLayer = new Class({
	options:{
		trigger:null,                            //触发的元素或id,必填参数
		popupBlk:null,                           //弹出内容层元素或id,必填参数
		closeBtn:null,                           //关闭弹出层的元素或id
		posturl:null,
		popupLayerClass:"popupLayer",            //弹出层容器的class名称
		eventType:"click",                       //触发事件的类型
		offsets:{                                //弹出层容器位置的调整值
			x:0,
			y:0
		},
		useFx:false,                             //是否使用特效
		useOverlay:false,                        //是否使用全局遮罩
		usePopupIframe:true,                     //是否使用容器遮罩
		isresize:true,                           //是否绑定window对象的resize事件
		onBeforeStart:function(){}            //自定义事件
	},
	_init:function(options){
		this.setOptions(options);                //载入设置
		this.isSetPosition = this.isDoPopup = this.isOverlay = true;    //定义一些开关
		this.popupLayer = $(document.createElement("div")).addClass(this.options.popupLayerClass);     //初始化最外层容器
		this.popupIframe = $(document.createElement("iframe")).attr({border:0,frameborder:0});         //容器遮罩,用于屏蔽ie6下的select
		this.trigger = $(this.options.trigger);                         //把触发元素封装成实例的一个属性，方便使用及理解
		this.popupBlk = $(this.options.popupBlk);                       //把弹出内容层元素封装成实例的一个属性
		this.closeBtn = $(this.options.closeBtn);                       //把关闭按钮素封装成实例的一个属性
		this.posturl = this.options.posturl;
		this.isresize = this.options.isresize;
		this.offsets = this.options.offsets;
		$(this).trigger("onBeforeStart");                               //执行自定义事件。
		this._construct();                                               //通过弹出内容层，构造弹出层，即为其添加外层容器及底层iframe
		this.trigger.bind(this.options.eventType,function(){
			var t = false;
			var url = '';
			var pop = this.popupBlk;
			$.ajax({
				async:false,
				url:this.posturl,
				success:function(r){
					closeleaveword();
					var json = eval('('+r+')');
					if (json['hashaibao'] == 1)
					{
						url = json['url'];
						t = false;
						window.location.href=url;
//						var a = $("<a href='"+url+"' target='_blank'>Apple</a>").get(0);
//			            var e = document.createEvent('MouseEvents');
//			            e.initEvent('click', true, true );
//			            a.dispatchEvent(e);
					}else 
					{
						t = true;
						pop.find('#mb_syj').html(json['contents']);
					}
			}});
			if (!t) {
				return false;
			}
			//给触发元素绑定触发事件
			if(this.isSetPosition){
				this.setPosition(this.trigger.offset().left + this.options.offsets.x, this.trigger.offset().top + this.trigger.get(0).offsetHeight + this.options.offsets.y);
			}
			this.options.useOverlay?this._loadOverlay():null;               //如果使用遮罩则加载遮罩元素
			(this.isOverlay && this.options.useOverlay)?this.overlay.show():null;
			if(this.isDoPopup && (this.popupLayer.css("display")== "none")){
				this.options.useFx?this.doEffects("open"):this.popupLayer.show();
			}							 
		}.binding(this));
		this.isresize?$(window).bind("resize",this.doresize.binding(this)):null;
		this.options.closeBtn?this.closeBtn.bind("click",this.close.binding(this)):null;   //如果有关闭按钮，则给关闭按钮绑定关闭事件
	},
	_construct:function(){                  //构造弹出层
		this.popupBlk.show();
		this.popupLayer.append(this.popupBlk.css({opacity:1})).appendTo($(document.body)).css({position:"absolute",'z-index':999,width:this.popupBlk.get(0).offsetWidth,height:this.popupBlk.get(0).offsetHeight});
		//this.options.usePopupIframe?this.popupLayer.append(this.popupIframe):null;
		//this.recalculatePopupIframe();
		this.popupLayer.hide();
	},
	_loadOverlay:function(){                //加载遮罩
		pageWidth = ($.browser.version=="6.0")?$(document).width()-21:$(document).width();
		this.overlay?this.overlay.remove():null;
		this.overlay = $(document.createElement("div"));
		this.overlay.css({position:"absolute","z-index":1,left:0,top:0,zoom:1,display:"none",width:'100%',height:$(document).height()}).appendTo($(document.body)).append("<div style='position:absolute;z-index:2;width:100%;height:100%;left:0;top:0;opacity:0.9;filter:Alpha(opacity=90);background:#000'></div>")
	},
	doresize:function(){
		this.overlay?this.overlay.css({width:'100%',height:$(document).height()}):null;
		if(this.isSetPosition){
			this.setPosition(this.trigger.offset().left + this.options.offsets.x, 14);
		}
	},
	setPosition:function(left,top){          //通过传入的参数值改变弹出层的位置
		this.popupLayer.css({left:left,top:14});
	},
	doEffects:function(way){                //做特效
		way == "open"?this.popupLayer.show("slow"):this.popupLayer.hide("slow");
		
	},
	recalculatePopupIframe:function(){     //重绘popupIframe,这个不知怎么改进，只好先用这个笨办法。
		this.popupIframe.css({position:"absolute",'z-index':-1,left:0,top:0,opacity:0,width:'100%',height:this.popupBlk.get(0).offsetHeight});
	},
	close:function(){                      //关闭方法
		this.options.useOverlay?this.overlay.hide():null;
		this.options.useFx?this.doEffects("close"):this.popupLayer.hide();
	}
});


function ee(){
	var buf = document.getElementById('J_builtFrame');
	if (buf == null)
	{
        var gaz = document.createElement('script'); gaz.type = 'text/javascript'; gaz.async = true;
        gaz.id='J_builtTempMg';
        gaz.src = '../../static-aone.tonglukuaijian.com/uniboard/static/js/builtinMsgTemp-3g.js@msgId=5';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gaz, s);
	}else 
	{
		document.getElementById('J_builtFrame').src = document.getElementById('J_builtFrame').src;
	}
}
// 刷新留言框
function openleaveword()
{
	 
	$("#sub_message").slideDown("slow");
	$(".subCen_p1").css({"background":"url(../media/images/introduce/subP11.jpg) no-repeat"}); 
	$(".subCen_p2").css({"background":"url(../media/images/introduce/subP22.jpg) no-repeat"});
	$(".sub_message").hide();
	$(".sub_message2").hide();
	$(".sub_phone").hide();
	$(".subCen_p3").show();
	ee();
}

// 关闭留言框
function closeleaveword()
{
	$("#sub_message").slideUp("slow");
	$(".subCen_p1").css({"background":"url(../media/images/introduce/subP1.jpg) no-repeat"}); 
	$(".subCen_p2").css({"background":"url(../media/images/introduce/subP2.jpg) no-repeat"});
	$(".sub_message").show();
	$(".sub_message2").show();
	$(".sub_phone").show();
	$(".subCen_p3").hide();
}﻿