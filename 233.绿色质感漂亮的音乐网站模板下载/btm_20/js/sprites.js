(function($){
var pl=function(_){
	_=$.extend({
		preFu:function(){
			var _=this
			_.getWH(function(){
				_.holder.css({background:'none'})
				if(_.holder.css('zIndex')=='auto')
					_.holder.css({zIndex:1})
				if(_.holder.css('position')=='static')
					_.holder.css({position:'relative'})
				_.l=$('<div></div>')
					.css({
						width:_.width,
						height:_.hh,
						position:'absolute',
						background:_.url+' 0 0',
						left:0,
						top:0,
						zIndex:-1
					})
					.appendTo(_.holder)
				_.r=$('<div></div>')
					.css({
						width:_.width,
						height:_.hh,
						position:'absolute',
						background:_.url+' 0 -'+_.hh+'px',
						right:0,
						top:0,
						zIndex:-1
					})
					.appendTo(_.holder)
				_.t=$('<div></div>')
					.css({
						height:_.hh,
						position:'absolute',
						background:_.url+' 0 -'+_.hh*2+'px',
						left:_.width,
						right:_.width,
						top:0,
						zIndex:-1
					})
					.appendTo(_.holder)
			})
		},
		getWH:function(fn){
			var _=this,
				img=new Image(),
				url=_.url=_.holder.css('backgroundImage'),
				src=url.replace(/(^url\('?"?)|('?"?\)$)/g,'')
			_.hw=_.holder.width()
			_.hh=_.holder.height()
			img=$(img).appendTo('body')
			$(img).attr({src:src})
			if(img[0].complete)
				_.width=img.width(),
				_.height=img.height(),
				img.remove(),
				fn()
			else
				img.load(function(){
					_.width=img.width()
					_.height=img.height()
					img.remove()
					fn()
				})
		}		
	},_)
	this.each(function(){
		$.extend({},_,{holder:$(this)}).preFu()
	})	
}
$.fn.extend({sprites:pl})
})(jQuery)

function clone(obj){
	if(!obj||typeof obj!=typeof {})
		return obj
	if(obj instanceof Array)
		return [].concat(obj)
	var tmp=new obj.constructor(),
		i
	for(i in obj)
		if(obj.hasOwnProperty(i))
			tmp[i]=clone(obj[i])
	return tmp
}