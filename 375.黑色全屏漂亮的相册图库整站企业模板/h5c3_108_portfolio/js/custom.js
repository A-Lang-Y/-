

/* Navigation */

$(document).ready(function(){

  $(window).resize(function()
  {
    if($(window).width() >= 765){
      $(".sidebar #nav").slideDown(350);
    }
    else{
      $(".sidebar #nav").slideUp(350); 
    }
  });


  $("#nav > li > a").on('click',function(e){
      if($(this).parent().hasClass("has_sub")) {
        e.preventDefault();
      }   

      if(!$(this).hasClass("subdrop")) {
        // hide any open menus and remove all other classes
        $("#nav li ul").slideUp(350);
        $("#nav li a").removeClass("subdrop");
        
        // open our new menu and add the open class
        $(this).next("ul").slideDown(350);
        $(this).addClass("subdrop");
      }
      
      else if($(this).hasClass("subdrop")) {
        $(this).removeClass("subdrop");
        $(this).next("ul").slideUp(350);
      } 
      
  });
});

$(document).ready(function(){
  $(".sidebar-dropdown a").on('click',function(e){
      e.preventDefault();

      if(!$(this).hasClass("open")) {
        // hide any open menus and remove all other classes
        $(".sidebar #nav").slideUp(350);
        $(".sidebar-dropdown a").removeClass("open");
        
        // open our new menu and add the open class
        $(".sidebar #nav").slideDown(350);
        $(this).addClass("open");
      }
      
      else if($(this).hasClass("open")) {
        $(this).removeClass("open");
        $(".sidebar #nav").slideUp(350);
      }
  });

});
  

/* Slide box widget */


$('.slide-box-button').click(function() {
    var $slidebtn=$(this);
    var $slidebox=$(this).parent().parent();
    if($slidebox.css('right')=="-252px"){
      $slidebox.animate({
        right:0
      },500);
      $slidebtn.children("i").removeClass().addClass("icon-chevron-right");
    }
    else{
      $slidebox.animate({
        right:-252
      },500);
      $slidebtn.children("i").removeClass().addClass("icon-chevron-left");
    }
}); 

/* Contact slider */

$(document).ready(function(){
  $(".cslider-btn").on('click',function(e){
      e.preventDefault();

      if(!$(this).prev().hasClass("open")) {
        $(".cslider").slideDown(300);
        $(".cslider").addClass("open");
        $(this).children("i").removeClass().addClass("icon-angle-up");
      }
      
      else if($(this).prev().hasClass("open")) {
        $(".cslider").removeClass("open");
        $(".cslider").slideUp(300);
        $(this).children("i").removeClass().addClass("icon-angle-down");
      }
  });

});

/* Tab */

$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})


/* Scroll to Top */

$(document).ready(function(){
  $(".totop").hide();

  $(function(){
    $(window).scroll(function(){
      if ($(this).scrollTop()>600)
      {
        $('.totop').slideDown();
      } 
      else
      {
        $('.totop').slideUp();
      }
    });

    $('.totop a').click(function (e) {
      e.preventDefault();
      $('body,html').animate({scrollTop: 0}, 500);
    });

  });
});

/* Flex Slider */

$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "fade",
    controlNav: false,
    pauseOnHover: true,
    slideshowSpeed: 5000,
    animationSpeed: 2000
  });
});

/* prettyPhoto Gallery */

$(".prettyphoto").prettyPhoto({
overlay_gallery: false, social_tools: false
});


/* Isotype */

// cache container
var $container = $('#gallery');
// initialize isotope
$container.isotope({
  resizable : false
});

// filter items when filter link is clicked
$('#filters a').click(function(){
  var selector = $(this).attr('data-filter');
  $container.isotope({ filter: selector });
  return false;
});

/* Main page isotope */

function isotope() {
  var container = $('#portfolio-one');
  var item = $('#portfolio-one .element');
  var columns;
  var width;
  columns = Math.ceil(container.width()/300);  // Number of columns 
  width = Math.floor(container.width()/columns); // Width for each item
  item.each(function(){
    $(this).css('width',width+'px'); // Setting width
  }); 
  container.imagesLoaded( function(){
    container.isotope({    // Isotope
      resizable: false,
      masonry: {
        columnWidth: width
      }
    }); 
  });
}

$(document).ready(function(){ 
  isotope(); // Initilize isotope 
  $(window).smartresize(function(){
    isotope(); // Call isotope when resize
  });   
});
