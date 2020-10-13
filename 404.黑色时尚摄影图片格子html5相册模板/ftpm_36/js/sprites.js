//0.2.0
;(function($){
	$.fn.sprites=function(o){
		this.each(function(){
			var th=$(this),
				data=th.data('sprites'),
				_={
					ready:false,
					method:'corners',
					pasta:'<div></div>',
					hover:false,
					altEventIn:'hoverin',
					altEventOut:'hoverout',
					duration:300,
					easing:'linear',
					crossFade:true,
					processFu:function(){
						({
	 						vStretch:function(){
								_.layers=_.layers||{}
								_.corners=_.corners||{}
								_.tails=_.tails||{}
								
								_.layers['t']=_.corners['t']=_.etal.clone()
									.css({
										top:0,
										backgroundPosition:'0 0'
									})
								_.layers['b']=_.corners['b']=_.etal.clone()
									.css({
										bottom:0,
										backgroundPosition:'-'+_.width/3+'px 0'
									})
								_.layers['c']=_.tails['c']=_.etal.clone()
									.css({
										top:_.height,
										bottom:_.height,
										backgroundPosition:'-'+_.width/3*2+'px 0',
										backgroundRepeat:'repeat-y'
									})
								$.each(_.layers,function(k,d){
									d
									.css({
										position:'absolute',
										backgroundImage:_.url,
										zIndex:-1,
										left:0,
										width:_.width/3
									})
									.appendTo(_.me)
								})
								$.each(_.corners,function(k,d){
									d
									.css({
										height:_.height
									})
								})
								_.me.css({background:'none'})
							},
						 	gStretch:function(){
								var step=_.hover?_.height/6:_.height/3
								_.layers=_.layers||{}
								_.corners=_.corners||{}
								_.tails=_.tails||{}
								_.hovers=_.hovers||{}
								
								_.layers['l']=_.corners['l']=_.etal.clone()
									.css({
										left:0,
										backgroundPosition:'0 0'
									})
								_.layers['r']=_.corners['r']=_.etal.clone()
									.css({
										right:0,
										backgroundPosition:'0 -'+step+'px'
									})
								_.layers['c']=_.tails['c']=_.etal.clone()
									.css({
										right:_.width,
										left:_.width,
										backgroundPosition:'0 -'+step*2+'px'
									})
								$.each(_.layers,function(k,d){
									d
									.css({
										position:'absolute',
										backgroundImage:_.url,
										zIndex:-1,
										top:0,
										height:step
									})
									.appendTo(_.me)
								})
								$.each(_.corners,function(k,d){
									d
									.css({
										width:_.width
									})
								})
								if(_.hover)
									$.each(_.layers,function(k,d){
										_.hovers[k]=d.clone().appendTo(_.me).hide()
										if(!($.browser.msie&&$.browser.version<9))
											_.hovers[k].css({opacity:0})
									}),
									_.hovers['l'].css({backgroundPosition:'0 -'+step*3+'px'}),
									_.hovers['r'].css({backgroundPosition:'0 -'+step*4+'px'}),
									_.hovers['c'].css({backgroundPosition:'0 -'+step*5+'px'})
								_.me.css({background:'none'})
							},
							simple:function(){
								_.layers=_.layers||{}
								_.hovers=_.hovers||{}
								_.layers['bg']=_.etal.clone()
									.css({
										left:0,
										top:0,
										zIndex:-1,
										width:_.width,
										height:_.height/2,
										backgroundImage:_.url,
										backgroundRepeat:'no-repeat',
										backgroundPosition:'0 0'
									})
									.appendTo(_.me)
								_.hovers['bg']=_.etal.clone()
									.css({
										left:0,
										top:0,
										zIndex:-1,
										width:_.width,
										height:_.height/2,
										backgroundImage:_.url,
										backgroundRepeat:'no-repeat',
										backgroundPosition:'0 -'+_.height/2+'px'
									})
									.appendTo(_.me)
								if($.browser.msie&&$.browser.version<9)
									_.hovers['bg'].hide()
								else
									_.hovers['bg'].css({opacity:0})
								_.me.css({background:'none'})
							},
							corners:function(){
								_.layers=_.layers||{}
								_.corners=_.corners||{}
								_.tails=_.tails||{}
								_.layers['l-t']=_.corners['l-t']=_.etal.clone()
									.css({
										left:0,
										top:0,
										backgroundPosition:'0 0'
									})
								_.layers['r-t']=_.corners['r-t']=_.etal.clone()
									.css({
										right:0,
										top:0,
										backgroundPosition:'-'+(_.width/4)+'px 0'
									})
								_.layers['l-b']=_.corners['l-b']=_.etal.clone()
									.css({
										left:0,
										bottom:0,
										backgroundPosition:'0 -'+(_.height/4)+'px'
									})
								_.layers['r-b']=_.corners['r-b']=_.etal.clone()
									.css({
										right:0,
										bottom:0,
										backgroundPosition:'-'+(_.width/4)+'px -'+(_.height/4)+'px'
									})
								_.layers['t-l']=_.etal.clone()
									.css({
										left:0,
										top:_.height/4,
										bottom:_.height/4,
										width:_.width/4,
										backgroundPosition:'-'+(_.width/2)+'px 0'
									})
								_.layers['t-l-c']=_.layers['t-l'].clone()
									.css({backgroundPosition:'-'+(_.width/2)+'px -'+(_.height/2)+'px'})
								_.layers['t-r']=_.etal.clone()
									.css({
										right:0,
										top:_.height/4,
										bottom:_.height/4,
										width:_.width/4,
										backgroundPosition:'-'+(_.width/2+_.width/4)+'px 0'
									})
								_.layers['t-r-c']=_.layers['t-r'].clone()
									.css({backgroundPosition:'-'+(_.width/2+_.width/4)+'px -'+(_.height/2)+'px'})
								_.layers['t-t']=_.etal.clone()
									.css({
										top:0,
										height:_.height/4,
										left:_.width/4,
										right:_.width/4,
										backgroundPosition:'0 -'+(_.height/2)+'px'
									})
								_.layers['t-t-c']=_.layers['t-t'].clone()
									.css({backgroundPosition:'-'+(_.width/2)+'px -'+(_.height/2)+'px'})
								_.layers['t-b']=_.etal.clone()
									.css({
										bottom:0,
										height:_.height/4,
										left:_.width/4,
										right:_.width/4,
										backgroundPosition:'0 -'+(_.height/2+_.height/4)+'px'
									})
								_.layers['t-b-c']=_.layers['t-b'].clone()
									.css({backgroundPosition:'-'+(_.width/2)+'px -'+(_.height/2+_.height/4)+'px'})
								
								_.layers['bgc']=_.etal.clone()
									.css({
										left:_.width/4,
										right:_.width/4,
										top:_.height/4,
										bottom:_.height/4
									})
									
								$.each(_.layers,function(k,d){
									d
									.css({
										position:'absolute',
										backgroundImage:_.url,
										zIndex:-1
									})
									.appendTo(_.me)
								})
								$.each(_.corners,function(k,d){
									d
									.css({
										width:_.width/4,
										height:_.height/4
									})								
								})
								_.layers['bgc'].css({background:_.me.css('backgroundColor')})
								_.me.css({background:'none'})
							}
						})[_.method]()
					},
					showHoverFu:function(){
						$.each(_.hovers,function(k,d){
							if($.browser.msie&&$.browser.version<9)
								d.show()
							else
								d
									.stop()
									.show()
									.animate({
										opacity:1
									},{
										duration:_.duration,
										easing:_.easing
									})
						})
						$.each(_.layers,function(k,d){
							if($.browser.msie&&$.browser.version<9)
								d.hide()
							else
								if(_.crossFade)
								d
									.stop()
									.show()
									.animate({
										opacity:0
									},{
										duration:_.duration,
										easing:_.easing,
										complete:function(){
											d.hide()
										}
									})								
						})
					},
					hideHoverFu:function(){
						_.hovers
						&&$.each(_.hovers,function(k,d){
							if($.browser.msie&&$.browser.version<9)
								d.hide()
							else								
								d
									.stop()
									.show()
									.animate({
										opacity:0
									},{
										duration:_.duration,
										easing:_.easing,
										complete:function(){
											d.hide()
										}
									})
								
						})
						&&$.each(_.layers,function(k,d){
							if($.browser.msie&&$.browser.version<9)
								d.show()
							else
								d
									.stop()
									.show()
									.animate({
										opacity:1
									},{
										duration:_.duration,
										easing:_.easing
									})
						})
					},
					hoverFu:function(){
						if(_.hover)
							_.me
								.bind(_.hover===true?'mouseenter':_.altEventIn,function(){
									_.showHoverFu()
									_.hoverIn(_.me,_)
								})
								.bind(_.hover===true?'mouseleave':_.altEventOut,function(){
									_.hideHoverFu()
									_.hoverOut(_.me,_)
								})
					},
					preFu:function(){
						var img=$('<img src="">').appendTo('body')
						_.url=th.css('backgroundImage')
						_.src=_.url.replace(/(^url\('?"?)|('?"?\)$)/g,'')
						if(_.me.css('position')=='static')
							_.me.css({position:'relative'})
						
						if(_.me.css('display')=='inline')
							_.me.css({display:'inline-block'})
						
						if(_.me.css('zIndex')=='auto')
							_.me.css({zIndex:1})

						_.etal=$(_.pasta).css({position:'absolute',zIndex:-1})
						_.hh=_.me.outerHeight()
						_.hw=_.me.outerWidth()
						img
							.css({
								position:'absolute',
								left:'-999%',
								top:'-999%',
								display:'block'
							})							
							.load(function(){
								setTimeout(function(){
									_.width=img.width()
								_.height=img.height()
								img.remove()
								_.processFu()
								_.ready=true
								_.lazyFu&&_.lazyFu()
								},1)
							})							
							.attr({src:_.src})
							
						if(_.hover)
							_.hoverFu()
					},
					init:function(){
						_.preFu()
					},
					controlFu:function(str){
						if(str=='hoverin')
							_.showHoverFu()
						if(str=='hoverout')
							_.hideHoverFu()
					},
					hoverIn:function(){},
					hoverOut:function(){}
				}
			data?_=data:th.data({sprites:_})
			typeof o=='object'&&$.extend(_,o)
			_.me||_.init(_.me=th)
			
			if(typeof o=='string')
				if(_.ready)
					_.controlFu(o)
				else
					_.lazyFu=function(){
						_.controlFu(o)
						_.me.trigger('ready')
					}
		})
		return this
	}
})(jQuery)