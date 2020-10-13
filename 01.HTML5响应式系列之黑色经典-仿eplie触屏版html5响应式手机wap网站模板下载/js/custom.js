/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////// Variables Start                                                                                    */
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
var $ = jQuery.noConflict();
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////// Variables End                                                                                      */
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////// Document Ready Function Starts                                                                     */
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
jQuery(document).ready(function($){
			
	
	
	// initial settings start
	var topNotification = true;
	var mainMenuStatus = 'closed';
	var mainMenuAnimation = 'complete';
	var headerHeight = $('.headerOuterWrapper').height();
	var mainMenuHeight = $('.mainMenuWrapper').height() + 3;
	
	$('.mainMenuWrapper').css('top', -mainMenuHeight + headerHeight);
	$('.websiteWrapper').css('min-height', mainMenuHeight + headerHeight);
	
	var windowWidth = $(window).width() - 48;
		
	var lightboxInitialWidth = windowWidth;
	var lightboxInitialHeight = 220;
	// initial settings end


     
	// main menu functions start
	$('.mainMenuButton').click(function(){
		
		mainMenuHeight =  $('.mainMenuWrapper').height() + 3;
		
		if(mainMenuStatus == 'closed' && mainMenuAnimation == 'complete'){
			
			mainMenuAnimation = 'incomplete';
			$('.mainMenuWrapper').css('display', 'block');
			$('.mainMenuWrapper').stop(true, true).animate({top: headerHeight}, 600, 'easeOutQuart', function(){mainMenuStatus = 'open'; mainMenuAnimation = 'complete'});
			
		}else if(mainMenuStatus == 'open' && mainMenuAnimation == 'complete'){
			
			mainMenuAnimation = 'incomplete';
			$('.mainMenuWrapper').stop(true, true).animate({top: -mainMenuHeight + headerHeight}, 600, 'easeInQuart', function(){mainMenuStatus = 'closed'; mainMenuAnimation = 'complete'; $('.mainMenuWrapper').css('display', 'none'); });
		
		};
		
		return false;
	});
	
	// main menu functions end	
	
	
	
	// adapt portfolio function starts
	function adaptPortfolio(){
		
		$('.portfolioTwoWrapper').css('width', $('.portfolioTwoPageWrapper').width() - 12);
		$('.portfolioTwoFilterableWrapper .portfolioFilterableItemsWrapper').css('width', $('.portfolioTwoFilterablePageWrapper').width() - 12);
		
		var portfolioTwoItemWidth = ($('.portfolioTwoPageWrapper').width() - 48 - 36)/2;
		var portfolioTwoFilterableItemWidth = ($('.portfolioTwoFilterablePageWrapper').width() - 48 - 36)/2;
		
		$('.portfolioTwoItemWrapper').css('width', portfolioTwoItemWidth);
		$('.portfolioTwoFilterableWrapper .portfolioFilterableItemWrapper').css('width', portfolioTwoFilterableItemWidth);
		
	};
	
	adaptPortfolio();
	// adapt portfolio function ends
	
	
	
	// filterable portfolio functions start
	$('#portfolioMenuWrapper > li > a').click(function(){
		
		var filterVal = $(this).attr('data-type');
		
		if(filterVal != 'all'){
			
			$('.currentPortfolioFilter').removeClass('currentPortfolioFilter');
			
			$(this).addClass('currentPortfolioFilter');
			
			$('.portfolioFilterableItemWrapper').each(function(){
	            
				var itemCategories = $(this).attr("data-type").split(",");
				  
				if($.inArray(filterVal, itemCategories) > -1){
					
					$(this).addClass('filteredPortfolioItem');
					
					$('.filteredPortfolioItem').stop(true, true).animate({opacity:1}, 300, 'easeOutCubic');
					
				}else{
						
					$(this).removeClass('filteredPortfolioItem');
					
					if(!$(this).hasClass('filteredPortfolioItem')){
						
						$(this).stop(true, true).animate({opacity:0.3}, 300, 'easeOutCubic');
					
					};
					
				};
					
			});
		
		}else{
			
			$('.currentPortfolioFilter').removeClass('currentPortfolioFilter');
			
			$(this).addClass('currentPortfolioFilter');
			
			$('.filteredPortfolioItem').removeClass('filteredPortfolioItem');
			
			$('.portfolioFilterableItemWrapper').stop(true, true).animate({opacity:1}, 300, 'easeOutCubic');
			
		}
			
		return false;
	
	});
	// filterable portfolio functions end
	
	
	
	// alert box widget function starts
	$('.alertBoxButton').click(function(){
		
		$(this).parent().fadeOut(300, function(){$(this).remove();});
		
		return false;
		
	});
	// alert box widget function ends
	
	
	
	// accordion widget function starts
	$('.accordionButton').click(function(e){
		 
		if($(this).hasClass('currentAccordion')){
			
			 $(this).parent().find('.accordionContentWrapper').stop(true, true).animate({height:'hide'}, 300, 'easeOutCubic', function(){$(this).parent().find('.accordionButton').removeClass('currentAccordion');});
			 
		}else{
			 
			$(this).parent().find('.accordionContentWrapper').stop(true, true).animate({height:'show'}, 300, 'easeOutCubic', function(){$(this).parent().find('.accordionButton').addClass('currentAccordion');});
		 
        };
		 
		return false;
		
	});
	// accordion widget function ends

	
	
	// back to top function starts
	$('.backToTopButton').click(function(){
								   
	    $('body, html').stop(true, true).animate({scrollTop:0}, 1200,'easeOutCubic'); 
		
		return false;
	
    });
	// back to top function ends 
	
	
	
	// notification functions start
	if(topNotification == true){
		
		$('.topNotification').stop(true, true).delay(1200).animate({height:'show'}, 600, 'easeOutCubic', function(){})
	
	};
	
	$('.notificationButton').click(function(){
		
		$(this).parent().stop(true, true).animate({height:'hide'}, 600, 'easeOutCubic', function(){});
		
		return false;
		
	});
	
	// notification functions end
	
	
	// window resize functions start
	$(window).resize(function(){
		
		windowWidth = $(window).width() - 48;
		
		lightboxInitialWidth = windowWidth;
		
		lightbox();
					
		adaptPortfolio();
				
	});
	// window resize functions end
	
	
	
	// nivo slider functions start
	$('#mainSlider').nivoSlider({
		
		prevText: '',
        nextText: '' 
		
	});
	// nivo slider functions end
	
	
	
	// lightbox functions start
	function lightbox(){
		
		$('.portfolioOneExpandButton, .portfolioFilterableExpandButton, .singleProjectExpandButton').colorbox({
		
			maxWidth: windowWidth,
			initialWidth: lightboxInitialWidth,
			initialHeight: lightboxInitialHeight
			
		});
		
	};
	
	lightbox();
	// lightbox functions end



});
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////// Document Ready Function Ends                                                                       */
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/