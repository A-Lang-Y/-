/* Author:

*/

jQuery.noConflict()(function($){

    $(document).ready(function($) {



/*----------------------------------------YDCOZA----------------------------------------*/
/*        Style Switcher */
/*--------------------------------------------------------------------------------------*/

    $('.slide-out-div').fadeIn(50);

    $('.slide-out-div').tabSlideOut({
        tabHandle: '.handle',                              //class of the element that will be your tab
        //pathToTabImage: 'styleswitcher/ct2.jpg',          //path to the image for the tab (optionaly can be set using css)
        //imageHeight: '137px',                               //height of tab image
        //imageWidth: '37px',                               //width of tab image    
        tabLocation: 'left',                               //side of screen where tab lives, top, right, bottom, or left
        speed: 400,                                        //speed of animation
        action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
        topPos: '150px',                                   //position from the top
        fixedPosition: false                               //options: true makes it stick(fixed position) on scroll
    });
 
 /*----------------------------------------YDCOZA----------------------------------------*/
 /*        Suprefish */
 /*--------------------------------------------------------------------------------------*/
 
    jQuery.noConflict()(function(){
        // jQuery('ul#menu').superfish();
    });

/*----------------------------------------YDCOZA----------------------------------------*/
/*    Fade in Flex slider images after page load */
/*--------------------------------------------------------------------------------------*/

    $('.flexslider').fadeIn(50);   

/*----------------------------------------YDCOZA----------------------------------------*/
/*    Flexslider */
/*--------------------------------------------------------------------------------------*/

  $('.flexslider').flexslider({
    animation: "fade",	
    slideshow: true,	
    slideshowSpeed: 6000,
    animationDuration: 900,	
    // directionNav: false,	
    controlNav: false,
    prevText: "<i class='icon-chevron-left'></i>",
    nextText: "<i class='icon-chevron-right'></i>",
    pauseOnHover: true
  });


/*----------------------------------------YDCOZA----------------------------------------*/
/*        MiniSlider */
/*--------------------------------------------------------------------------------------*/

  $('.minislider').flexslider({
    animation: "fade",  
    slideshow: true,    
    slideshowSpeed: 5000,
    animationDuration: 900,
    // directionNav: false, 
    controlNav: false,
    prevText: "<i class='icon-chevron-left'></i>",
    nextText: "<i class='icon-chevron-right'></i>",
    pauseOnHover: true
  });


/*----------------------------------------YDCOZA----------------------------------------*/
/*        Testimonials */
/*--------------------------------------------------------------------------------------*/

  $('.testimonial').flexslider({
    animation: "fade",  
    slideshow: true,   
    slideshowSpeed: 3000,   
    directionNav: false, 
    controlNav: false
  });


/*----------------------------------------YDCOZA----------------------------------------*/
/*        Tabs */
/*--------------------------------------------------------------------------------------*/


    $('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
    })


/*----------------------------------------YDCOZA----------------------------------------*/
/*    PrettyPhoto */
/*--------------------------------------------------------------------------------------*/

$("a[rel^='prettyPhoto']").prettyPhoto({opacity:0.80,default_width:200,default_height:344,hideflash:false,modal:false});

/*----------------------------------------YDCOZA----------------------------------------*/
/*   Isotope Filter */
/*--------------------------------------------------------------------------------------*/
// var $container = $('#container');

// $container.imagesLoaded( function(){
//   $container.isotope({
//     // options...
//   });
// });



$(function(){

    var $container = $('#portfolio.sorter'),
        filters = {};

$container.imagesLoaded( function(){ //Solves Chrome images issue

    $container.isotope({
      itemSelector : '.YDCOZA',
      layoutMode : 'fitRows'
    });

    // filter buttons
    $('.filter button').click(function(){
      var $this = $(this);
      // don't proceed if already selected
      if ( $this.hasClass('selected') ) {
        return;
      }

      var $optionSet = $this.parents('.filter');
      // change selected class
      $optionSet.find('.selected').removeClass('selected');
      $this.addClass('selected');

      // store filter value in object
      // i.e. filters.color = 'red'
      var group = $optionSet.attr('data-filter-group');
      filters[ group ] = $this.attr('data-filter-value');
      // convert object into array
      var isoFilters = [];
      for ( var prop in filters ) {
        isoFilters.push( filters[ prop ] )
      }
      var selector = isoFilters.join('');
      $container.isotope({ filter: selector });

      return false;
    });

  });
});





    }); //Doc Ready
});



