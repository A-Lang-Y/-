/* Style Changer */

$(document).ready(function () {
   /* Color cookie */
        var c = $.cookie('color');
        var d = $.cookie('num');
        var s = $.cookie('option');
        if (c){ themeswitch(c); selectit(c); paternButtons(c);}
        if (d){ patternswitch(d);}
        
        
        
        $('#color').change(function () {
        var ColorVal = $("#color option:selected").val();
        //alert('#color').attr('selectedindex');
        $.cookie('color',ColorVal);
        $.cookie('num',1);
        location.reload();
        //jQuery('style#cFontStyles').text('body, code, input[type="text"], textarea { font-family:' + cFontVal + '; }');
        }); 
        
        $('.stBgs a').click(function(){
          $('#stlChanger .stBgs a').removeClass('current');
          $(this).addClass('current');
        var hName=$(this).attr('id');   
        patternswitch(hName);
        });   
        
        
        jQuery('.chBut').click(function(){
        if (jQuery(this).hasClass('closed')){
            jQuery(this).next('.chBody').css({display:'block'}).parent().animate({left:0}, 500, function(){
                jQuery(this).find('.chBut').removeClass('closed');
            });
        } else {
            jQuery(this).parent().animate({left:'-170px'}, 500, function(){
                jQuery(this).find('.chBut').next('.chBody').css({display:'none'});
                jQuery(this).find('.chBut').addClass('closed');
            });
        }
        return false;
    });
    
    jQuery('.chBut').parent().delay(1000).animate({left:'-170px'}, 500, function(){
        jQuery(this).find('.chBut').next('.chBody').css({display:'none'});
        jQuery(this).find('.chBut').addClass('closed');
    });  
});

function themeswitch(color){
    $.cookie('color',color);
    $('link[rel="stylesheet index"]').attr({href : "assets/css/"+color});                        
    
};   

function selectit(color)
{
    $.cookie('color',color);
    $("#color option[value='"+color+"']").attr('selected',true);
}

function paternButtons(color)
{
    if ((color==='grey')||(color==='red-green')||(color==='blue')) {$('#p4').remove();}    
    if ((color==='black')) {$('#p2').remove();$('#p3').remove();$('#p4').remove();} 
}

function patternswitch(num){
   $.cookie('num',num); 
   if (num==1) {$('#stlChanger .stBgs a:first-child').addClass('current');}    
   $('body').css({'background':'#fff url(assets/images/body_bg'+num+'.png)'});
}

/*
jQuery(document).ready(function(){
    jQuery('#stlChanger input#numeric-spinner').spinner({
        min:0, 
        max:1, 
        step:0.05
    }).change(function(){
        jQuery('#main-container').css({background:'rgba(0, 0, 0, ' + jQuery('#stlChanger input#numeric-spinner').spinner('value') + ')'});
    });;
    
    jQuery('#stlChanger #bgColor').parent('a').ColorPicker({
        onChange:function(hsb, hex, rgb){
            jQuery('#stlChanger').find('#bgColor').css({backgroundColor:'#' + hex});
            jQuery('body').css({backgroundColor:'#' + hex});
        },
        onSubmit:function(hsb, hex, rgb, el){
            jQuery('#stlChanger .stCols span').removeClass('current');
            jQuery(el).find('#bgColor').css({backgroundColor:'#' + hex});
            jQuery(el).ColorPickerHide();
        }
    });
        
    jQuery('#stlChanger .stCols span').click(function(){
        var bgCol = jQuery(this).css('background-color');
        jQuery('#stlChanger .stCols span').removeClass('current');
        jQuery(this).addClass('current');
        jQuery('#stlChanger #bgColor').css({backgroundColor:bgCol});
        jQuery('body').css({backgroundColor:bgCol});
    });
    jQuery('#stlChanger .stBgs a').click(function(){
        var bgBgCol = jQuery(this).attr('href');
        jQuery('#stlChanger .stBgs a').removeClass('current');
        jQuery(this).addClass('current');
        jQuery('#main-container').css({backgroundImage:'url(' + bgBgCol + ')'});
        if (jQuery(this).hasClass('bg_t')){
            jQuery('#main-container').css({backgroundRepeat:'repeat', backgroundPosition:'0 0', backgroundAttachment:'scroll'});
        } else {
            jQuery('#main-container').css({backgroundRepeat:'no-repeat', backgroundPosition:'50% 0', backgroundAttachment:'fixed'});
        }
        return false;
    });
    
    jQuery('#stlChanger #cFontColor1').parent('a').ColorPicker({
        onChange:function(hsb, hex, rgb){
            jQuery('#stlChanger').find('#cFontColor1').css({backgroundColor:'#' + hex});
            jQuery('#main-container h1, #main-container h2, #main-container h3, #main-container h4, #main-container h5, #main-container h6, #main-container .title').css({color:'#' + hex});
        },
        onSubmit:function(hsb, hex, rgb, el){
            jQuery('#stlChanger .stCols span').removeClass('current');
            jQuery(el).find('#cFontColor1').css({backgroundColor:'#' + hex});
            jQuery(el).ColorPickerHide();
        }
    });    

    jQuery('#stlChanger #cFontColor2').parent('a').ColorPicker({
        onChange:function(hsb, hex, rgb){
            jQuery('#stlChanger').find('#cFontColor2').css({backgroundColor:'#' + hex});
            jQuery('#main-container .emphasis').css({color:'#' + hex});
        },
        onSubmit:function(hsb, hex, rgb, el){
            jQuery('#stlChanger .stCols span').removeClass('current');
            jQuery(el).find('#cFontColor2').css({backgroundColor:'#' + hex});
            jQuery(el).ColorPickerHide();
        }
    });    
    
    jQuery('#stlChanger #cFontColor3').parent('a').ColorPicker({
        onChange:function(hsb, hex, rgb){
            jQuery('#stlChanger').find('#cFontColor1').css({backgroundColor:'#' + hex});
            jQuery('body').css({color:'#' + hex});
        },
        onSubmit:function(hsb, hex, rgb, el){
            jQuery('#stlChanger .stCols span').removeClass('current');
            jQuery(el).find('#cFontColor3').css({backgroundColor:'#' + hex});
            jQuery(el).ColorPickerHide();
        }
    });            

    jQuery('#skin').change(function () {
        var skinVal = $("#skin option:selected").val();
        //jQuery('style#cFontStyles').text('body, code, input[type="text"], textarea { font-family:' + cFontVal + '; }');
    });    

    jQuery('#cScheme').change(function () {
        var cSchemeVal = $("#cScheme option:selected").val();
        //jQuery('style#cFontStyles').text('body, code, input[type="text"], textarea { font-family:' + cFontVal + '; }');
    });    
    
    jQuery('#styleSave').click(function(){
        jQuery('#styleLoader').fadeIn(1000, function(){
            var $bgColor = jQuery('#stlChanger #bgColor').css('background-color');
            var $bgPattern = jQuery('#stlChanger .stBgs a.current').attr('href');
            var $cFontColor1 = jQuery('#stlChanger #cFontColor1').css('backgroundColor');
            var $cFontColor2 = jQuery('#stlChanger #cFontColor2').css('backgroundColor');
            var $cFontColor3 = jQuery('#stlChanger #cFontColor3').css('backgroundColor');
            var $skin = jQuery('#stlChanger #skin option:selected').val();
            var $cScheme = jQuery('#stlChanger #cScheme option:selected').val();
            
            jQuery.post('styleChanger/changer.php',
                {setCookie: true, bgColor: $bgColor, bgPattern: $bgPattern, cFontColor1: $cFontColor1, cFontColor2: $cFontColor2, cFontColor3: $cFontColor3, skin: $skin, cScheme: $cScheme},             
            function(data){
                jQuery('#styleLoader').fadeOut(1000);
                window.location.reload();
            });
        });
        return false;
    });
        
    jQuery('#styleReset').click(function(){
        jQuery('#styleLoader').fadeIn(1000, function(){
            var $remove = jQuery('#styleReset').attr('id');

            jQuery.post('styleChanger/changer.php', 
            {remove: $remove}, 
            function(data){
                jQuery('#styleLoader').fadeOut(1000);
                window.location.reload();
            });
        });
        return false;
    });
    
    jQuery('.chBut').click(function(){
        if (jQuery(this).hasClass('closed')){
            jQuery(this).next('.chBody').css({display:'block'}).parent().animate({left:0}, 500, function(){
                jQuery(this).find('.chBut').removeClass('closed');
            });
        } else {
            jQuery(this).parent().animate({left:'-150px'}, 500, function(){
                jQuery(this).find('.chBut').next('.chBody').css({display:'none'});
                jQuery(this).find('.chBut').addClass('closed');
            });
        }
        return false;
    });
    
    jQuery('.chBut').parent().delay(1000).animate({left:'-150px'}, 500, function(){
        jQuery(this).find('.chBut').next('.chBody').css({display:'none'});
        jQuery(this).find('.chBut').addClass('closed');
    });
});
*/