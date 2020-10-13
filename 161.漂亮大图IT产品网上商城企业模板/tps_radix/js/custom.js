$(document).ready(function() {
                
    /*******************************************************************************************************************
    *  Fancybox                                                                                                  
    *******************************************************************************************************************/
    $(".gallery a, .fancybox").fancybox({
        'overlayColor': '#000',
        'overlayOpacity': 0.7
    });          
    
    /*******************************************************************************************************************
    *  Slider                                                                                                  
    *******************************************************************************************************************/
    sliderInit();
    function sliderInit() {
        
        var sliderWrap = $('#slider');
        var slider = $('#slider ul');
        var prev = $('#intro a.prev');
        var next = $('#intro a.next');
        var item = $('#slider ul > li');         
        var visibleCount = 1;
        var marginWidth = 0; // if visibleCount > 1
        var sliderWidth = item.length * (item.outerWidth() + marginWidth);
        var sliderStepWidth = item.outerWidth() + marginWidth;
        var visibleWidth = visibleCount * sliderStepWidth;
        var count = item.length - 1;
        var endWidth = sliderWidth - visibleWidth; 
        var i = 0;
        var step = 0;
        var animationRun = false;
        $(slider).css('width', sliderWidth);
        
        $(item).each(function() {
           var itemHeight = $(this).height();
           var itemContentHeight = $(this).find('.content').height();
           var marginTop = (itemHeight - itemContentHeight) / 2;
           $(this).find('.content').css('margin-top', marginTop + 'px');
        });
        
        var interval = 5000; 
        var duration = 1000;                
        
        if(sliderWidth > visibleWidth) {          

            function sliderAnimationNext() {
                if(animationRun == false) {
                    position = slider.position().left;                                                             
                    step = position - sliderStepWidth;      
                    if(step > (endWidth * -1) - sliderStepWidth){
                        $(slider).animate({ left: step }, duration, function() { animationRun = false; });
                    }else{$(slider).animate({ left: 0 }, duration, function() { animationRun = false; }); }  
                }
                animationRun = true;
            }

            function sliderAnimationPrev() {
                if(animationRun == false) {
                    position = slider.position().left;    
                    step = position + sliderStepWidth;                         
                    if(step < 0 + sliderStepWidth){   
                        $(slider).animate({ left: step }, duration, function() { animationRun = false; });
                    }else{$(slider).animate({ left: endWidth * -1 }, duration, function() { animationRun = false; }); }
                }
                animationRun = true;
            }

            $(prev).click(function(a) {  a.preventDefault();  sliderAnimationPrev(); });
            $(next).click(function(a) { a.preventDefault(); sliderAnimationNext(); });                        

            var isHover = false;

            $(sliderWrap).hover(function() {
                    $(sliderWrap).addClass('hover'); // Debug
                    isHover = true;
                    clearInterval(sliderInterval);
            }, function() {
                    $(sliderWrap).removeClass('hover'); // Debug
                    isHover = false;
                    sliderInterval = setInterval(sliderAnimationNext, interval);
            });
            
        }else{ next.hide(); prev.hide(); }  
        
        var sliderInterval = setInterval(sliderAnimationNext, interval);

    }

  
});