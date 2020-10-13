/**
 * @author Alexander Farkas
 * v. 1.21
 * upg to jQuery-1.6 by plzkn
 */
;(function($){
	if(!document.defaultView||!document.defaultView.getComputedStyle){//IE6-IE8
		var oldCurCSS = jQuery.curCSS
		jQuery.curCSS = function(elem,name,force){
			if(name === 'background-position')
				name='backgroundPosition'
			if(name!=='backgroundPosition'||!elem.currentStyle||elem.currentStyle[name])
				return oldCurCSS.apply(this,arguments)
			var style=elem.style
			if (!force&&style&&style[name])
				return style[name]
			return oldCurCSS(elem,'backgroundPositionX',force)+' '+oldCurCSS(elem,'backgroundPositionY',force)
		}
	}
	
	function toObj(s){
		var r=s
			.replace(/center/g,'50%')
			.replace(/left|top/g,'0px')
			.replace(/right|bottom/g,'100%')
			.replace(/([0-9\.]+)(\s|\)|$)/g,"$1px$2")
			.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/)
		return {x:r[1],y:r[3],xu:r[2],yu:r[4]}
	}
	
	$.fx.step.backgroundPosition=function(fx){
		if(!fx.bgPosObj)
			fx.bgPosObj={from:toObj($.curCSS(fx.elem,'backgroundPosition')),to:toObj(fx.end)}
		fx.elem.style.backgroundPosition=(
			parseInt(fx.bgPosObj.from.x/1+(fx.bgPosObj.to.x-fx.bgPosObj.from.x)*fx.pos)
			+fx.bgPosObj.to.xu
			+' '
			+parseInt(fx.bgPosObj.from.y/1+(fx.bgPosObj.to.y-fx.bgPosObj.from.y)*fx.pos)
			+fx.bgPosObj.to.yu
		)
	}
})(jQuery)