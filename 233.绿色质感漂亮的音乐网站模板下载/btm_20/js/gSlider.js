;(function($,undefined){
	var _timer=[],
		_fw=window._fw=$.fn._fw=function(_){
			var i,name=[]
			for(i in _)
				if(_.hasOwnProperty(i))
					name.push(i)
			$(this).each(function(){
				for(var i=0,opt;i<name.length;i++)
					if(_fw.meth[name[i]])						
						opt=$.extend(clone(_fw.meth[name[i]]),_[name[i]]),
						opt.init.call($(this).data(name[i],opt),opt)
			})
			return this
		},
		_meth=_fw.meth={
			tumbvr:{
		items:'ul>li',
		duration:1000,
		easing:'linear',
		preFu:function(){
			var _=this,
				w=h=mm=0
			_.itms				
				.each(function(){
				 	$(this).show()
						var tmp,
							th=$(this),
							img=$('img',this),
							wdth=th.outerWidth()+parseInt(th.css('marginRight'))+parseInt(th.css('marginLeft'))
						w+=wdth
						h=h<(tmp=th.height())?tmp:h
						mm=mm<wdth?wdth:mm
				})
			_.mm=mm
			_.ul
				.css({
					width:_.ulW=w,
					position:'relative'
				})
			_.holder.css({
				overflow:'hidden'				
			})
			if(_.holder.css('position')=='static')
				_.holder.css({position:'relative'})
			_.resizeFu()
		},
		resizeFu:function(){
			var _=this
			_.holder.width(_.hW=$(document.body).width())
		},
		moveFu:function(x){
			var _=this,
				mouse=x-_.holder.attr('offsetLeft'),
				dX=-((_.ulW-_.hW)-_.hW)*mouse/_.hW
			mouse=mouse<_.mm?0:mouse
			mouse=mouse>_.hW-_.mm?_.hW:mouse
			if(mouse==dX)
					_.ul.stop()
				else
					if(mouse>dX)
						_.ul
							.stop()
							.animate({
								left:dX-mouse
							},{
								duration:_.duration,
								easing:_.easing
							})
					else
						_.ul
							.stop()
							.animate({
								left:mouse-dX
							},{
								duration:_.duration,
								easing:_.easing
							})
		},
		init:function(_){
			var holder=_.holder=this,
				ul=_.ul=$('>ul',holder),
				items=_.itms=$(_.items,holder)
			_.preFu()
			holder
				.bind('mousemove',function(e){
					if(_.hW<_.ulW)
						_.moveFu(e.pageX)
				})
				
			$(window).resize(function(){
				_.resizeFu()
			})
		}
	},
			gSlider:{
				show:0,
				itms:[],
				duration:400,
				easing:'swing',
				prevBu:false,
				nextBu:false,
				preFu:function(){
					var _=this,
						w=0
					_.itms.each(function(i){
						var th=$(this)
						w+=th.width()+parseInt(th.css('margin-right')||0)+parseInt(th.css('margin-left')||0)
						th
							.data({
								left:th.attr('offsetLeft')
							})
						_.itms[i]=th
					})
					_.itms[0].parent().css({position:'relative'}).width(w)
					_.ul.css({position:'relative'})
					},
				changeFu:function(n){
					var _=this
					_.curr=n
					_.ul
						.stop()
						.animate({
							left:'-'+_.itms[n].attr('offsetLeft')+'px'
						},{
							duration:_.duration,
							easing:_.easing
						})
				},
				init:function(_){
					var holder=_.holder=this,
						ul=_.ul=$('>ul',holder),
						itms=_.itms=$('>ul>li',holder)
					_.preFu()
					_.changeFu(_.show)
					if(_.nextBu)
						$(_.nextBu)
							.click(function(){
								_.changeFu(++_.curr<_.itms.length?_.curr:0)
							})
					if(_.prevBu)
						$(_.prevBu)
							.click(function(){
								_.changeFu(--_.curr>=0?_.curr:_.itms.length-1)
							})
				}
			}			
		}
	
	$.fn.gSlider=function(opt){
		opt=opt||{}
		this._fw({
			gSlider:opt
		})
	}
	$.fn.tumbvr=function(opt){
		opt=opt||{}
		this._fw({
			tumbvr:opt
		})
	}
})(jQuery)

/**/