function include(url){document.write('<script type="text/javascript" src="'+url+'"></script>')}

include('js/jquery.easing.1.3.js');


include('js/TMGPrototype2.js');
include('js/jquery-ui-1.10.3.custom.min.js');
include('js/jquery.ui.touch-punch.js');

/*---------------------- end ready -------------------------------*/

$(window).load(function(){  
    $("#webSiteLoader").delay(500).animate({opacity:0}, 600, "easeInCubic", function(){
        $("#webSiteLoader").remove();
    });  

      
    $('#TMGPrototype2').TMGPrototype2({});

    $(window).resize(
        function(){
      
        }
    ).trigger('resize');

});

