$(document).ready(function() {
	// hover
	
	$('footer a').hover(function(){
		$(this).stop().animate({color:'#fff'})						 
	}, function(){
		$(this).stop().animate({color:'#6ab2b1'})						 
	})
	
	$('.link1, .link2').hover(function(){
		$(this).stop().animate({color:'#000'})					   
	}, function(){
		$(this).stop().animate({color:'#81b003'})					   
	})
	
	$('.promos span').css({opacity:0})
	
	$('.promos a').hover(function(){
		$(this).find('span').stop().animate({opacity:0.5})						
	}, function(){
		$(this).find('span').stop().animate({opacity:0})						
	})
	
	$('.button1').hover(function(){
		$(this).stop().animate({backgroundColor:'#4d4d4d'})						 
	}, function(){
		$(this).stop().animate({backgroundColor:'#81b003'})						 
	})
	
	$('.list1 a').hover(function(){
		$(this).stop().animate({color:'#81b003'})					   
	}, function(){
		$(this).stop().animate({color:'#4d4d4d'})					   
	})
	
	$('ul#menu').superfish({
      delay:       600,
      animation:   {height:'show'},
      speed:       600,
      autoArrows:  false,
      dropShadows: false
    });
	
	$('#content > ul > li').each(function(){
		var height=$(this).height()+10;
		$(this).data({height:height})
	})
	
	
 });
$(window).load(function() {	
	
	var min_height=300, height=300;
	
	//content switch
	var content=$('#content'),
		nav=$('.menu');
	nav.navs({
		useHash:true,
		hoverIn:function(li){
			Cufon.replace('#menu a', { fontFamily: 'Kozuka Gothic Pro OpenType', hover:true });
		},
		hoverOut:function(li){
			Cufon.replace('#menu a', { fontFamily: 'Kozuka Gothic Pro OpenType', hover:true });
		}				
	})	
	content.tabs({
		actFu:function(_){
			if (_.prev && _.curr) {
				_.prev.stop().animate({height:0}, function(){
					$(this).css({display:'none'})
					height=_.curr.data('height')
					$('#content').css({height:height});
					if (height<min_height) {height=min_height}
					centre();
					_.curr.css({display:'block'}).stop().animate({height:height})
				})
			} else {
				if (_.prev) {
					_.prev.stop().animate({height:0}, function(){
						$(this).css({display:'none'})
						height=min_height;
						centre();
						$('#content').css({height:min_height});
					})	
				} 
				if (_.curr) {
					height=_.curr.data('height')
					$('#content').css({height:height});
					if (height<min_height) {height=min_height}
					centre();
					_.curr.css({display:'block'}).stop().animate({height:height})
				}
			}
		},
		preFu:function(_){						
			_.li.css({display:'none', position:'absolute', height:0});
			$('#content').css({height:min_height});
		}
	})
	nav.navs(function(n, _){
		if (n=='close' || n=='#!/') {
			content.tabs(n);
		} else {
			content.tabs(n);
		}
	})
	
	
	var m_top=30;
	function centre() {
		var h=$(window).height();
		h_cont=height+212;
		if (h>h_cont) {
			m_top=(h-h_cont);
		} else {
			m_top=30
		}
		$('#content').css({paddingTop:m_top})
		
	}
	centre();
	$(window).resize(centre);
	
})