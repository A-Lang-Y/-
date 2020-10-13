$(document).ready(function(){
		$('.mp-slider')._TMS({
			show:0,
			pauseOnHover:false,
			duration:1000,
			preset:'simpleFade',
			pagination:true,//'.pagination',true,'<ul></ul>'
			pagNums:false,
			slideshow:7000,
			numStatus:false,
			banners:false,// fromLeft, fromRight, fromTop, fromBottom
			waitBannerAnimation:false
		})
		function equalHeight(group) {
			var tallest = 0;
			group.each(function() {
				var thisHeight = $(this).height();
				if(thisHeight > tallest) {
					tallest = thisHeight;
				}
			});
			group.height(tallest);
		}	
 })