$(document).ready(function() {
	// hover
	
	$('footer > a').hover(function(){
		$(this).stop().animate({color:'#4d4d4d'})						 
	}, function(){
		$(this).stop().animate({color:'#ad2f00'})						 
	})
	
	$('.link1').each(function(){
		$(this).prepend('<span></span>')
		var col=$(this).css('color')
		$(this).find('span').css({background:col})
	})
	
	$('.list1 a').each(function(){
		$(this).prepend('<span></span>')						
	})
	
	$('.link1, .list1 a').hover(function(){
		$(this).find('span').css({opacity:1, width:0}).stop().animate({width:'100%'})
	}, function(){
		$(this).find('span').stop().animate({opacity:0})
	})
	
	$('.close span').css({opacity:0})
	
	$('.close').hover(function(){
		$(this).find('span').stop().animate({opacity:1})					  
	}, function(){
		$(this).find('span').stop().animate({opacity:0})					  
	})
	
	$('#icons .img_act').css({opacity:0})
	
	$('#icons a').hover(function(){
		$(this).find('.img_act').stop().animate({opacity:1})					  
	}, function(){
		$(this).find('.img_act').stop().animate({opacity:0})					  
	})
	
	// gallery
	
	$("#gallery1").jCarouselLite({
			btnNext: ".next",
		 	btnPrev: ".prev",
       		mouseWheel: true,
			visible: 3,
			speed: 600,
			easing: 'easeOutCirc'
	});
	
	$('.prev span, .next span').css({opacity:0})
	
	$('.prev, .next').hover(function(){
		$(this).find('span').stop().animate({opacity:1})						 
	}, function(){
		$(this).find('span').stop().animate({opacity:0})						 
	})
	
	var Img='.'+$(".gallery_big_img img#active").attr('class')
	$(".gallery_big_img img").css({opacity:0});
	$("#caption li").css({opacity:0, display:'none'});
	$(".gallery_big_img img#active").css({opacity:1});
	$("#caption li"+Img).css({opacity:1, display:'block'});
	$("#caption li"+Img).css({opacity:'none'});
	$("#gallery1 a").click(function(){
  		var ImgId = '.'+$(this).attr("href").slice(1);
  		if (ImgId!=Img) {
			 $(Img).stop().animate({opacity:0}, 600, function(){$(this).css({display:'none'})})
			 $(Img).attr({id:''});
			 $(ImgId).css({display:'block'}).stop().animate({opacity:1}, 600, function(){$(this).css({opacity:'none'})});
			 $(ImgId).attr({id:'active'})
		}
		Img=ImgId;
  	  return false;
   })
	
	$('.submenu_1 span').css({opacity:0})
	
	$('.submenu_1 li').hover(function(){
		$(this).find('span').stop().animate({opacity:1})							  
	}, function(){
		$(this).find('span').stop().animate({opacity:0})							  
	})
	
	$('ul#menu').superfish({
      delay:       600,
      animation:   {height:'show'},
      speed:       600,
      autoArrows:  false,
      dropShadows: false
    });
	
	$('#content > ul > li').each(function(){
		$(this).data({height:$(this).height()})
		$(this).css({top:$(this).data('height')/2})
	})
	
 });
$(window).load(function() {	
	
	var m_top=30;
	h_cont=340;
	// scroll
	$('.scroll').cScroll({
		duration:700,
		step:75,
		trackCl:'track',
		shuttleCl:'shuttle'
	})	
	
	$('#bgStretch').bgStretch({
			align:'leftBottom',
			navs:$('#bg_pagination').navs({
				hoverIn:function(li){
					$('span',li).stop().animate({opacity:1})
					$('a',li).stop().animate({color:'#fff'})
				},
				hoverOut:function(li){
					$('span',li).stop().animate({opacity:0})
					$('a',li).stop().animate({color:'#ad2f00'})
				}	
			})
	}).sImg({
			spinner:$('.spinner').css({opacity:.7}).hide()
	})
	
	
	
	$('#bg_pagination').navs(0)
	
	//content switch
	var content=$('#content'),
		nav=$('.menu');
	nav.navs({
		useHash:true,
		hoverIn:function(li){
			$('> a',li).stop().animate({color:'#ad2f00'})
		},
		hoverOut:function(li){
			if (!li.hasClass('with_ul') || !li.hasClass('sfHover')) {
				$('> a',li).stop().animate({color:'#fff'})
			}
		}				
	})	
	content.tabs({
		actFu:function(_){
			if (_.prev && _.curr) {
					h_last=_.prev.data('height');
					h_new=_.curr.data('height');
					_.prev.stop().animate({height:0, top:h_last/2}, function(){
						_.prev.css({display:'none'})
						_.curr.css({display:'block'}).stop().animate({height:h_new, top:0})
						content.css({height:h_new});
						h_cont=h_new+340;
						centre()
					})
			} else {
				if (_.curr) {
					h_new=_.curr.data('height');
					_.curr.css({display:'block'}).stop().animate({height:h_new, top:0})
					content.css({height:h_new})
					h_cont=h_new+340;
					centre()
				}
				if (_.prev) {
					h_last=_.prev.data('height');
					_.prev.stop().animate({height:0, top:h_last/2}, function(){
						_.prev.css({display:'none'});
						content.css({height:0})
						h_cont=340;
						centre()
					})
					
				}
			}
		},
		preFu:function(_){						
			$('#content > ul > li').css({display:'none', position:'absolute', height:0})
		}
	})
	nav.navs(function(n, _){
		
		if (n=='close' || n=='#!/') {
			content.tabs(n);
			
		} else {
			content.tabs(n);
			
		}
	})
	
	
	
	function centre() {
		var h=$(window).height();
		if (h>h_cont) {
			m_top=(h-h_cont)/2+30;
		} else {
			m_top=30
		}
		$('#content').css({marginTop:m_top})
		
	}
	centre()
	$(window).resize(centre);
	
})