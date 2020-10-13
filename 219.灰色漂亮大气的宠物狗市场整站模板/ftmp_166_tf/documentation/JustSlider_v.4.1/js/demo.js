$(document).ready(function(){
		$('.slider')._TMS({
			show:0,
			pauseOnHover:false,
			prevBu:'.prev',
			nextBu:'.next',
			playBu:'.play',
			duration:10000,
			preset:'zoomer',
			pagination:true,//'.pagination',true,'<ul></ul>'
			pagNums:false,
			slideshow:7000,
			numStatus:true,
			banners:'fromRight',// fromLeft, fromRight, fromTop, fromBottom
			waitBannerAnimation:false,
			progressBar:'<div class="progbar"></div>'
		})		
 })