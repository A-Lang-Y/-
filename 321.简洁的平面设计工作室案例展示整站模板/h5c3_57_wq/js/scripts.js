include('js/jquery.easing.1.3.js');
include('js/jquery-ui-1.8.11.custom.min.js');
include('js/jquery.transform-0.9.3.min.js');
include('js/jquery.animate-colors-min.js');
include('js/mathUtils.js');
include('js/hoverSprite.js');
include('js/superfish.js');
include('js/switcher.js');
include('js/jquery.mousewheel.js');
include('js/sprites.js');
include('js/cScroll.js');
include('js/forms.js');
include('js/jquery.fancybox-1.3.4.pack.js');
include('js/gallery.js');
include('js/googleMap.js');

//----Include-Function----
function include(url){ 
  document.write('<script src="'+ url + '" type="text/javascript" ></script>'); 
}
//--------global-------------
var isSplash = true;
//------DocReady-------------
$(document).ready(function(){ 
    if(location.hash.length == 0){
        location.hash="!/"+$('#content > ul > li').eq(2).attr('id');
    }
    
     $('ul#menu').superfish({
          delay:       800,
          animation:   {height:'show'},
          speed:       600,
          autoArrows:  false,
         dropShadows: false,
         	onInit: function(){
  				$("#menu > li > a").each(function(index){
  				//	var conText = $(this).find('.mText').text();
 					//$(this).append("<div class='overHolder'><span class='menuTextOver'>"+conText+"</span></div>")	
  				})
  	 		}
        });
});
  
 //------WinLoad-------------  
$(window).load(function(){  

$('.scroll1').cScroll({
		duration:700,
		step:100,
		trackCl:'track',
		shuttleCl:'shuttle'
	})
    
   	$('.Btns1 > .upBtn').click(function(){
 			$('.scroll1').cScroll('up');
 			return false
 		})
 	$('.Btns1 > .downBtn').click(function(){
 			$('.scroll1').cScroll('down');
 			return false
 		})
  $('.scroll2').cScroll({
		duration:700,
		step:100,
		trackCl:'track',
		shuttleCl:'shuttle'
	})
    
   	$('.Btns2 > .upBtn').click(function(){
 			$('.scroll2').cScroll('up');
 			return false
 		})
 	$('.Btns2 > .downBtn').click(function(){
 			$('.scroll2').cScroll('down');
 			return false
 		})      


 

$(".closeButton").hoverSprite({onLoadWebSite: true});
$(".followHolder > ul > li > a").hoverSprite({onLoadWebSite: true});
$("#next").hoverSprite({onLoadWebSite: true});
$("#prev").hoverSprite({onLoadWebSite: true});

$('.moreButton').sprites({method:'gStretch',hover:true});

$('#img_slider li .pic').fancybox({'titlePosition': 'inside', 'overlayColor':'#000'});


$("#img_slider").gallerySplash();

    $('.zoomSp').fadeTo(500, 0)
    $('.zoomSp').hover(function(){ $(this).stop().fadeTo(500, 0.5)}, function(){$(this).stop().fadeTo(500, 0)})    
         
       
     $('._list1 > li > a').hover(
     function(){ 
        $(this).stop(true).animate({'margin-left':'25px',color:'#ff6c00'},300);
        },
      function(){
         $(this).stop(true).animate({'margin-left':'15px',color:'#fff'},300);
         }
        )      
        
        
            $('.submenu_1 > li > a').hover(
     function(){ 
        $(this).stop(true).animate({'margin-left':'10px',color:'#ff6c00'},300);
        },
      function(){
         $(this).stop(true).animate({'margin-left':'0px',color:'#313131'},300);
         }
        )    
       
       
var menuItems = $('#menu >li'); 
  
navInit();
function navInit(){ 
    menuItems.each( function(index){
            _delay = (index*100)+500;
                // menuItems.eq(index).stop().delay(_delay).animate({left:"0px"}, 1000, 'easeOutExpo');
            } );

$('body').mousemove(function(){
            var _x = event.pageX;
            var mouseXPos = _x / $(document).width();
});

}

///////////////////////////////////////////////
    var navItems = $('.menu > ul >li');

   // $('.menu > ul >li').eq(0).css({'display':'none'});
	var content=$('#content'),
		nav=$('.menu');

    	$('#content').tabs({
		preFu:function(_){
			_.li.css({height:"0px",'display':'none'});
		}
		,actFu:function(_){			
			if(_.curr){
				_.curr.css({'display':'block', height:'0px', top:'0px'}).stop().delay(400).animate({height:"540px"},600,'easeOutCubic');
               // if ((_.n == 0) && ((_.pren>0) || (_.pren==undefined))){splashMode();}
               // if (((_.pren == 0) || (_.pren == undefined)) && (_.n>0) ){contentMode(); }
                
                  if ((_.n == 2) && ((_.pren!==2) || (_.pren==undefined))){ splashMode(); }

                if (((_.pren == 2) || (_.pren == undefined)) && (_.n!==2) ){contentMode();}
                
            }
        
			if(_.prev){
			     _.prev.stop().animate({height:"0px", top:'540px'},400,'easeInCubic',function(){_.prev.css({'display':'none'});}  );
             
             }
		}
	})
    

    function splashMode(){
        isSplash = true;
        setTimeout(
            function(){
                $('#content > ul').css({'z-index':1})
                $('.iconHolder').css({'z-index':2})
            }, 400
        )
        
          
          $('#prev').css({'display':'block'});
          $('#next').css({'display':'block'});
    }
    
    function contentMode(){  
        isSplash = false;
         $('#content > ul').css({'z-index':2})
        $('.iconHolder').css({'z-index':1})
           
           $('#prev').css({'display':'none'});
          $('#next').css({'display':'none'});
    }		
    
	nav.navs({
			useHash:true,
          //  defHash: '#!/pageGallery',
             hoverIn:function(li){
                //$(".overPlane", li).stop(true).animate({bottom:'0px'},800,'easeOutCubic');
                $(".mText", li).stop(true).animate({color:'#ff6c00'},500,'easeOutExpo');
               
                 /*   if(($.browser.msie) && ($.browser.version <= 8)){}else{
                        $(".pic", li).stop(true).animate({scale:1.1},300,'easeOutSine').animate({top:"0px"},400,'easeOutExpo');
                    }*/
             },
                hoverOut:function(li){
                    if ((!li.hasClass('with_ul')) || (!li.hasClass('sfHover'))) {
                        //$(".overPlane", li).stop(true).animate({bottom:'400px'},500,'easeInCubic');
                        $(".mText", li).stop(true).animate({color:'#313131'},500,'easeOutExpo'); 
                       
                    } 
                } 
		})
        
        
		.navs(function(n){			
			$('#content').tabs(n);
		})

    

//////////////////////////////////////////
   	var h_cont=752;
	function centrRepos() {
		var h=$(window).height();
		if (h>(h_cont+40)) {
			m_top=~~(h-h_cont)/2;
			h_new=h;
		} else {
			m_top=20;
			h_new=h_cont+40;
		}
		$('.center').stop().animate({paddingTop:m_top},800,'easeOutExpo');

	}
	centrRepos();
    ///////////Window resize///////
	$(window).resize(function(){
        centrRepos()
        }
    );

    } //window function
) //window load