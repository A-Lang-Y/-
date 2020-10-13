/* FlexSlider */

$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    controlNav: true,
    pauseOnHover: true,
    slideshowSpeed: 15000,
    prevText: "", 
    nextText: ""
  });
});


/* Scroll to Top */

  $(".totop").hide();

  $(function(){
    $(window).scroll(function(){
      if ($(this).scrollTop()>300)
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