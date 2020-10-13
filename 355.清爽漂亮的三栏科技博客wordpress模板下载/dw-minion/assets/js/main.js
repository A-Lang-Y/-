jQuery(document).ready(function($){
  var vph = $(window).height();
  $('.site-main').css('min-height', vph + 'px'); 
  $(window).resize(function(){
    resizeMain();
  });
  function resizeMain() {
    var vph = $(window).height();
    $('.site-main').css('min-height', vph + 'px'); 
  }
  $('.action.search label, .action.search i').click(function(){
    $('.action.search').toggleClass('active');
  });
  $('.site-actions .socials > .active-socials').click(function(){
    $('.site-actions .socials').toggleClass('active'); 
  });
  $('.site-actions .show-site-nav').click(function(){
    $('body').toggleClass('show-nav');
    $('body,html').scrollTop(0)  ;
  });
  function responsiveIframe() {
     // Fix responsive iframe
    $('iframe').each(function(){
      var iw = $(this).width();
      var ih = $(this).height();
      var ip = $(this).parent().width();
      var ipw = ip/iw;
      var ipwh = Math.round(ih*ipw);
      $(this).css({
        'width': ip,
        'height' : ipwh,
      });
    });
  }
  responsiveIframe();
  $(window).resize(function(){
    responsiveIframe();
  });
  // Accordion
  $('.accordion-toggle').click(function(){
    $(this).removeClass('collapsed');
    $('.accordion-toggle').addClass('collapsed');
  });
  // Back to top
  $('.back-top').click(function () {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });
  setTimeout(function(){
    $('.site-nav').css('display','block');   
  },500);
  // With select box
  $('.nav-tabs-by-select').change(function (e) {
      e.preventDefault();
      var target =  $(this).val();
      $('.news-tab .nav-tabs a[href="'+target+'"]').tab('show');
  });
  // Social share
  $('[class*="dw-share-"]').click(function() {
  var newwindow = window.open($(this).prop('href'), '', 'height=340,width=800');
  if (window.focus) newwindow.focus();
    return false;
  });
});