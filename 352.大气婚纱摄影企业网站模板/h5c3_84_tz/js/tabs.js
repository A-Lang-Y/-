/* ------------------------------------------------------------------------
	Do it when you're ready dawg!
------------------------------------------------------------------------- */

	

	tabs = {
  init : function(){
   $('.tabs').each(function(){

    var th=$(this),
     tContent=$('.tab-content',th),
     navA=$('ul.nav a',th)

    tContent.not(tContent.eq(4)).css({height:'0', marginTop:'250px', zIndex:'1'})
	tContent.eq(4).css({ height:'500px', marginTop:'0', zIndex:'2'});
    navA.click(function(){
     var th=$(this),
      tmp=th.attr('href')
     tContent.not($(tmp.slice(tmp.indexOf('#'))).css({}).css({zIndex:'2'}).stop().animate({height:'500px', marginTop:'0'},600)).css({zIndex:'1'}).stop().animate({height:'0', marginTop:'250px'},600, function(){$(this).css({})})
	 $(th).parent().addClass('selected').siblings().removeClass('selected');
	
     return false;
    });
   });

  }
 }