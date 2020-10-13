/* 
	Author: http://codecanyon.net/user/sike
*/
;(function($) {	
 	
	// the available ease animation style
	var easeTypeArr = ['rollIn', 'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight'];
	var easeTypeNum = easeTypeArr.length;			    
	
    $.fn.oneByOne = function(options) {  
	
	   	// plugin default options
		var settings = { 
			className: 'oneByOne', 
			sliderClassName: 'oneByOne_item',
			easeType: 'fadeInLeft',
			width: 960,
			height: 420, 
			delay: 300,
			tolerance: 0.25,  
			enableDrag: true,
			showArrow: true,
			showButton: true,
			slideShow: false,
			slideShowDelay: 3000
		}; 	          	

		// extends settings with options provided
        if (options) {
			$.extend(settings, options);
		}                    
		
		var parent;
		var _this;	
		var currentBannerNum = -1;	 
	
		var bannerWidth = settings.width; 
		var bannerHeight = settings.height;
		var xdiff = 0;    
		var isMouseDown = false; 
		var isTweenning = false; 
		// store the ease animation style of each slider
		var realEaseTypeArr = []; 
		var _easeType;
		                               		
		var bannerArr = [];     
		var bannerNum = 0;    
		var _preBannerNum = 0, buttonArea, buttonCon, arrowButton; 		             		    
		
		
		_this = this; 	        
		_this.wrap('<div class="' + settings.className + '"/>');  	 
		parent = _this.parent();                                 
		
		parent.css('overflow', 'hidden')
		
		_this.find('.'+settings.sliderClassName).each(function(index) { 
			/*				
			if($(this).children().length>1){        
				if(!($.browser.msie||$.browser.opera)){
					$(this).hide();																				
				} 
			}                                     
			*/                                                                                                  
 			$(this).hide();																								
			bannerNum++;		
			$(this).css('left', bannerWidth*index)
			bannerArr[index] = $(this);  

		});     
		
	    // add the mobile touch screen support 
	   	_this.bind('touchstart', function (event) {
            event.preventDefault();
            var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
            if (!isMouseDown) {
                isMouseDown = true;
                this.mouseX = touch.pageX;
            }  
			if(buttonCon)buttonCon.fadeIn();  				
			if(arrowButton)arrowButton.fadeIn();
			return false;
		});                

		_this.bind('touchmove', function (event) {
			event.preventDefault();
			var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
			if (isMouseDown) {
				xdiff = touch.pageX - this.mouseX;
				_this.css('left', -currentBannerNum * bannerWidth + xdiff);
				if (settings.slideShow) {
					stopSlideShow();
				}
			}
			return false;
		});        

		_this.bind('touchend', function (event) {
			var _n = currentBannerNum;
			event.preventDefault();  
			var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
			isMouseDown = false;
			if (!xdiff) return false;
			var fullWidth = parseInt(settings.width);
			var halfWidth = fullWidth / 2;
			if (-xdiff > halfWidth - fullWidth * settings.tolerance) {
				_n++;
				_n = _n >= bannerNum ? bannerNum - 1 : _n;
				tweenTo(_n);
			} else if (xdiff > halfWidth - fullWidth * settings.tolerance) {
				_n--;
				_n = _n < 0 ? 0 : _n;
				tweenTo(_n);
			} else {
				tweenTo(_n);  
				if (settings.slideShow) {
					startSlideShow();
				} 			
			}
			xdiff = 0; 
			if(buttonCon)buttonCon.delay(400).fadeOut();  				
			if(arrowButton)arrowButton.delay(400).fadeOut();
			return false;            
		})    
		
		// enable or disable the drag function of the slider
		if(settings.enableDrag){
 			_this.mousedown(function (event) {  
                if (!isMouseDown) {
                    isMouseDown = true;
                    this.mouseX = event.pageX;
                }         
                return false;  
            });                                         
                    
            _this.mousemove(function (event) {
                if (isMouseDown) {             
                   	xdiff = event.pageX - this.mouseX;   	
					_this.css('left', -currentBannerNum * bannerWidth + xdiff);
					if (settings.slideShow) {
						stopSlideShow();
					} 
					
				}
                return false;
            });       

		
			_this.mouseup(function (event) {
                isMouseDown = false;     
				var _n = currentBannerNum;
                if (!xdiff) return false;
                var fullWidth = parseInt(settings.width);
                var halfWidth = fullWidth / 2;
                if (-xdiff > halfWidth - fullWidth * settings.tolerance) {
                    _n++;
                    _n = _n >= bannerNum ? bannerNum - 1 : _n;
            		tweenTo(_n);

                } else if (xdiff > halfWidth - fullWidth * settings.tolerance) {
                    _n--;
                    _n = _n < 0 ? 0 : _n;
					tweenTo(_n);
                } else {
					tweenTo(_n);     
					if (settings.slideShow) {
						startSlideShow();
					} 
					
                }
                xdiff = 0;
                return false;
            });  

            _this.mouseleave(function (event) {
                $(this).mouseup();
            });    				
			
		}
 		    
		parent.mouseover(function (event){
			if(buttonCon)buttonCon.fadeIn(); 
			if(arrowButton)arrowButton.fadeIn(); 				
		});           
		
		parent.mouseleave(function (event){
			if(buttonCon)buttonCon.fadeOut(); 
			if(arrowButton)arrowButton.fadeOut();
		});  
		
  		// add the circle buttons
		if(settings.showButton){
            buttonArea = $('<div class="buttonArea"><div class="buttonCon"></div></div>');
			// buttonArea.hide();
            parent.append(buttonArea);                       
			buttonCon = buttonArea.find('.buttonCon');
            for(var i = 0; i < bannerNum; i++){
					buttonCon.append('<a class="theButton" rel="'+ i +'">'+ (i + 1) +'</a>').css('cursor', 'pointer');
            }              
                 
            $('.buttonCon a:eq('+ currentBannerNum +')', buttonArea).addClass('active');
            $('.buttonCon a', buttonArea).bind('click', function(event){        			  
                if($(this).hasClass('active')) return false;   
				var _n = $(this).attr('rel'); 	
				tweenTo(_n);
            });	 
		
		}

        // add the previous/next arrow buttons
		if(settings.showArrow){
			arrowButton = $('<div class="arrowButton"><div class="prevArrow"></div><div class="nextArrow"></div></div>');
			parent.append(arrowButton);
            var _next = $('.nextArrow', arrowButton).bind('click', function(event) {
				nextBanner();
            });
            var _prev = $('.prevArrow', arrowButton).bind('click', function(event) {
				prevBanner();
            });

		}                
		
		
		
  		if(buttonCon)buttonCon.hide(); 
		if(arrowButton)arrowButton.hide();
		
		tweenTo(0);   
		
		if(settings.slideShow) {
			slideShowInt = setInterval(function() {
				nextBanner();
			}, settings.slideShowDelay);
			_this.data('interval', slideShowInt);
		} 		
		  	    
		
		// move to the certain slider via a number, display the slider content one by one
		function tweenTo(n){    
			if (settings.slideShow) {
				stopSlideShow();
			}  

			_this.stop(true, true).animate({
				left: -n * bannerWidth
			},  settings.delay, function(){

				if(n!=currentBannerNum){
				_preBannerNum = currentBannerNum;	 
				if(bannerArr[_preBannerNum]){
					// if(bannerArr[_preBannerNum].children().length>1){
						if(!($.browser.msie||$.browser.opera)){
						 	bannerArr[_preBannerNum].fadeOut();
						} 
					
					// }       
				
	           		$('.buttonArea a:eq('+ _preBannerNum +')', parent).removeClass('active');	    							
				}				
			
	           	$('.buttonArea a:eq('+ n +')', parent).addClass('active');
			    if(settings.easeType.toLowerCase()!="random"){   
	 				bannerArr[n].show().children().each(function(index) {
	                      	if($(this).hasClass(settings.easeType)){    
							$(this).removeClass(settings.easeType);
							$(this).hide();
						} 	      
						var _n = index;
						$(this).show().addClass("animate"+_n+ " " + settings.easeType);
					});							
				}else{ 
				
					_easeType = easeTypeArr[Math.floor(Math.random()*easeTypeNum)];	
					realEaseTypeArr[n] = _easeType; 																													
					if(bannerArr[_preBannerNum]){
		 				bannerArr[_preBannerNum].children().each(function(index) {
	                       	if($(this).hasClass(realEaseTypeArr[_preBannerNum])){
								$(this).removeClass(realEaseTypeArr[_preBannerNum]);
								$(this).fadeOut('medium');//Hide this elegant, fade it out and show next [Smartik]  
							} 	                                  
						});
					
					} 
					
	 				bannerArr[n].show().children().each(function(index) {     
						var _n = index;
						$(this).show().addClass("animate"+_n+ " " + _easeType);
					});							
				}
				
					// isTweenning = false;     
					_this.delay(bannerArr[n].children().length*200).queue(function(){
						if(settings.slideShow) startSlideShow();
					})						
					if(arrowButton) arrowButton.css('cursor', 'pointer');							
					currentBannerNum = n;	                    
		   		}  					    
			});     		 
			  			  	
		}      

  
	
	
	   	function stopSlideShow() {
				clearInterval(_this.data('interval'));
			}

		function startSlideShow() {
			clearInterval(_this.data('interval'));
			slideShowInt = setInterval(	function(){
				nextBanner();  
			},settings.slideShowDelay);
			_this.data('interval', slideShowInt);
		}  
   
 		
	
	  	function nextBanner(){
			var _n = currentBannerNum;
			_n++;      
			_n = _n >= bannerNum ? 0 : _n;					
			tweenTo(_n);
		
		}  
	
		function prevBanner(){
			var _n = currentBannerNum;
			_n--;                       
			_n = _n < 0 ? bannerNum - 1 : _n;					
			tweenTo(_n);
		
		}  		
			                 
        return this;

    };           
  	    

})(jQuery);
