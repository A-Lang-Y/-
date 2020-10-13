$(document).ready(function(){
	$.fn.gallerySplash = function(){
		var gallery = $(this),
			imageHolder = $(">ul",gallery),
			allImg = $(">ul>li",gallery).length,
			nextImg=true,
			stepImg= $(">ul>li",gallery).eq(0).width(),
			arrayImg = [],
			sliceImagePop,
			sliceImageShift,
			imgPosition,
			animateState = true,
			showGallery = false,
			tweenTime = 0;

		init();
		function init(){	
		  
			$(">ul>li" , gallery).each(function(i){
				imgPosition =  Math.ceil(i-(allImg/3));
				arrayImg[i] = imgPosition;
			})
			for (var i = 0; i < Math.ceil(allImg / 3); i++ ) {
				sliceImagePop = arrayImg.pop();
				arrayImg.unshift(sliceImagePop)
			}
			addButonsEventHandler();
			changeImageHandler();
		}
		function addButonsEventHandler(){
			$("#prev").click(function(){
				if(!animateState){
					nextImg = true;
					changeImageHandler();
				}
				return false;
			});
			$("#next").click(function(){
				if(!animateState){
					nextImg = false;
					changeImageHandler();
				}
				return false;		
			});
			
		
		
		}
		function changeImageHandler(){
			animateState = true;
			if(showGallery){
				if(nextImg){
					sliceImageShift = arrayImg.shift();
					arrayImg.push(sliceImageShift);
				}else{
					sliceImagePop = arrayImg.pop();
					arrayImg.unshift(sliceImagePop);
				}
				}
			$(">ul>li" , gallery).each(function(i){
				if(arrayImg[i] < -1 || arrayImg[i] > 3){
					$(this).css({'z-index':1})
                    $(this).css({left:(arrayImg[i]*stepImg)});
				}else{
					$(this).css({'z-index':2})
                    $(this).animate({left:(arrayImg[i]*stepImg)}, tweenTime, "easeOutSine");
				}
                //console.log("i "+i);
				//$(this).animate({left:(arrayImg[i]*stepImg)}, tweenTime, "easeOutSine");
				
			})
			setTimeout(function(){	animateState = false;}, tweenTime);
			
			showGallery=true;
			tweenTime = 600;
		}
	}
})