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