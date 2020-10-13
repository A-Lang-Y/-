//0.3.0
(function($){
	$.fn.bgStretch=function(o){
		this.each(function(){
			var th=$(this),
				data=th.data('bgStretch'),
				_={
					align:'leftTop',
					css:{
						leftTop:{
							left:0,
							right:'auto',
							top:0,
							bottom:'auto'
						},
						rightTop:{
							left:'auto',
							right:0,
							top:0,
							bottom:'auto'
						},
						leftBottom:{
							left:0,
							right:'auto',
							top:'auto',
							bottom:0
						},
						rightBottom:{
							left:'auto',
							right:0,
							top:'auto',
							bottom:0
						}
					},
					preFu:function(){
						_.img
							.load(function(){
								_.k=_.img.height()/_.img.width()
								_.img
									.css({
										width:'100%',
										height:'100%',
										position:'absolute',
										zIndex:-1,
										left:0,
										top:0
									})
							})
						_.img[0].complete
							&&_.img.trigger('load')
						_.me
							.css({
								position:'absolute',
								zIndex:-1
							})
							.css(_.css[_.aalign=_.align])
						_.wrap
							.css({
								width:'100%',
								height:'100%',
								position:'fixed',
								left:0,
								top:0,
								overflow:'hidden',
								zIndex:-1
							})
						$(window).trigger('resize')
					},
					resizeFu:function(){
						var wh=_.win.height(),
							ww=_.win.width()+20,
							k=wh/ww
						if(_.aalign!=_.align)
							_.me
								.css(_.css[_.aalign=_.align])

						if(k<_.k)
							_.me
								.css({
									width:ww,
									height:ww*_.k
								})
						else
							_.me
								.css({
									width:wh/_.k,
									height:wh
								})
						
					},
					chngFu:function(str){
						$.fn.sImg
							?_.me.sImg(str)
							:_.img.attr({src:str})
					},
					init:function(){
						_.win=$(window)						
						_.img=$('img',_.me)
						_.me.wrap('<div></div>')
						_.wrap=_.me.parent()
						
						_.preFu()
						$(window)
							.resize(function(){
								_.resizeFu()
							})
							.trigger('resize')
						_.navs&&_.navs.data('navs')
							&&_.navs.navs(function(n,__){
								_.chngFu(__.href)
							})
							
					}
				}
			data?_=data:th.data({bgStretch:_})
			typeof o=='object'&&$.extend(_,o)
			_.me||_.init(_.me=th)
			
			typeof o=='string'&&_.chngFu(o)
		})
		return this		
	}
})(jQuery)

//0.2.3 image changer
;(function($){
	$.fn.sImg=function(o,cb){
		this.each(function(){
			var th=$(this),
				data=th.data('sImg'),
				_={
					duration:1000,
					sleep:300,
					spinner:false,
					preFu:function(){
						_.me.css('position')=='static'
							&&_.me.css({position:'relative',zIndex:1})
					},					
					chngFu:function(src){
						if(src==_.src)
							return false
						_.src=src
						_.buff=_.buff||$('<img>').css({position:'absolute',top:'-999%',left:'-999%'})
						if(_.clone&&_.clone.is(':animated'))
							_.clone.stop()
						if(_.clone)
							_.clone.remove()
						if(_.spinner!==false)
							if(typeof _.spinner=='string')
								_.spinner=$(_.spinner).hide()
							else
								if(typeof _.spinner=='object')
									_.spinner
										.appendTo(_.me)
										.fadeIn()
						_.buff
							.appendTo('body')
							.unbind('load')
							.load(function(){
								setTimeout(function(){
									if(_.img.css('position')=='static')										
										_.me
											.css({
												width:_.buff.width(),
												height:_.buff.height()
											}),
										_.img
											.css({
												position:'absolute',
												left:0,
												top:0
											})
									_.clone=_.img.clone()
										.css({
											position:'absolute',
											left:_.img.prop('offsetLeft'),
											top:_.img.prop('offsetTop')
										})
										.appendTo(_.me)
									_.spinner
										&&_.spinner.fadeOut()
									_.img.attr({src:src})
									_.clone
										.stop()
										.animate({
											opacity:0
										},{
											duration:_.duration,
											complete:function(){
												_.clone.remove()
												cb&&cb()
											}
										})
										_.buff.detach()
										_.spinner
											&&_.spinner.hide()
								},_.sleep)
							})
							.attr({src:src})
					},
					init:function(){
						_.img=$('>img',_.me)
						_.preFu()						
					}
				}
			data?_=data:th.data({sImg:_})
			typeof o=='object'&&$.extend(_,o)
			_.me||_.init(_.me=th)
			
			if(_.spinner!==false)
				if(typeof _.spinner=='string')
					_.spinner=$(_.spinner).hide()
			
			typeof o=='string'&&_.chngFu(o)
		})
		return this
	}
})(jQuery)
