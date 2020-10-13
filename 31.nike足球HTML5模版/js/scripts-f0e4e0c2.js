/**
 * slippry v1.2 - Simple responsive content slider
 * http://slippry.com
 *
 * Author(s): Lukas Jakob Hafner - @saftsaak 
 *
 * Copyright 2013, booncon oy - http://booncon.com
 *
 * Thanks @ http://bxslider.com for the inspiration!
 *
 * Released under the MIT license - http://opensource.org/licenses/MIT
 */

(function($){"use strict";var g;g={slippryWrapper:'<div class="sy-box" />',slideWrapper:'<div class="sy-slides-wrap" />',slideCrop:'<div class="sy-slides-crop" />',boxClass:'sy-list',elements:'li',activeClass:'sy-active',fillerClass:'sy-filler',loadingClass:'sy-loading',adaptiveHeight:true,start:1,loop:true,captionsSrc:'img',captions:'overlay',captionsEl:'.sy-caption',initSingle:true,responsive:true,preload:'visible',pager:true,pagerClass:'sy-pager',controls:true,controlClass:'sy-controls',prevClass:'sy-prev',prevText:'Previous',nextClass:'sy-next',nextText:'Next',hideOnEnd:true,transition:'fade',kenZoom:120,slideMargin:0,transClass:'transition',speed:800,easing:'swing',continuous:true,useCSS:true,auto:true,autoDirection:'next',autoHover:true,autoHoverDelay:100,autoDelay:500,pause:4000,onSliderLoad:function(){return this},onSlideBefore:function(){return this},onSlideAfter:function(){return this}};$.fn.slippry=function(e){var f,el,prepareFiller,getFillerProportions,init,updateCaption,initPager,initControls,ready,transitionDone,whichTransitionEvent,initCaptions,updatePager,setFillerProportions,doTransition,updateSlide,updateControls,updatePos,supports,preload,start,elFromSel,doKens;el=this;if(el.length===0){return this}if(el.length>1){el.each(function(){$(this).slippry(e)});return this}f={};f.vars={};whichTransitionEvent=function(){var t,div,transitions;div=document.createElement('div');transitions={'WebkitTransition':'webkitTransitionEnd','MozTransition':'transitionend','MSTransition':'msTransitionEnd','OTransition':'oTransitionEnd','transition':'transitionEnd transitionend'};for(t in transitions){if(div.style[t]!==undefined){return transitions[t]}}};supports=(function(){var c=document.createElement('div'),vendors=['Khtml','Ms','O','Moz','Webkit'],len=vendors.length;return function(b){if(b in c.style){return true}b=b.replace(/^[a-z]/,function(a){return a.toUpperCase()});while(len--){if(vendors[len]+b in c.style){return true}}return false}}());elFromSel=function(b,c){var d,newelement,id,className;d=c.split('.');newelement=$(b);id='';className='';$.each(d,function(i,a){if(a.indexOf('#')>=0){id+=a.replace(/^#/,'')}else{className+=a+' '}});if(id.length){newelement.attr('id',id)}if(className.length){newelement.attr('class',className.trim())}return newelement};doKens=function(){var a,kenTime,animProp,cssProp;animProp={};cssProp={};a=100-f.settings.kenZoom;cssProp.width=f.settings.kenZoom+'%';if(f.vars.active.index()%2===0){cssProp.left=a+'%';cssProp.top=a+'%';animProp.left='0%';animProp.top='0%'}else{cssProp.left='0%';cssProp.top='0%';animProp.left=a+'%';animProp.top=a+'%'}kenTime=f.settings.pause+f.settings.speed*2;f.vars.active.css(cssProp);f.vars.active.animate(animProp,{duration:kenTime,easing:f.settings.easing,queue:false})};ready=function(){if(f.vars.fresh){f.vars.slippryWrapper.removeClass(f.settings.loadingClass);f.vars.fresh=false;if(f.settings.auto){el.startAuto()}if(!f.settings.useCSS&&f.settings.transition==='kenburns'){doKens()}f.settings.onSliderLoad.call(undefined,f.vars.active.index())}else{$('.'+f.settings.fillerClass,f.vars.slideWrapper).addClass('ready')}};setFillerProportions=function(a,b){var c,p_top,$filler;c=a/b;p_top=1/c*100+'%';$filler=$('.'+f.settings.fillerClass,f.vars.slideWrapper);$filler.css({paddingTop:p_top});ready()};getFillerProportions=function(a){var b,height;if(($('img',a).attr("src")!==undefined)){$("<img />").load(function(){b=a.width();height=a.height();setFillerProportions(b,height)}).attr("src",$('img',a).attr("src"))}else{b=a.width();height=a.height();setFillerProportions(b,height)}};prepareFiller=function(){if($('.'+f.settings.fillerClass,f.vars.slideWrapper).length===0){f.vars.slideWrapper.append($('<div class="'+f.settings.fillerClass+'" />'))}if(f.settings.adaptiveHeight===true){getFillerProportions($('.'+f.settings.activeClass,el))}else{var a,height,loop;height=0;loop=0;$(f.vars.slides).each(function(){if($(this).height()>height){a=$(this);height=a.height()}loop=loop+1;if(loop===f.vars.count){if(a===undefined){a=$($(f.vars.slides)[0])}getFillerProportions(a)}})}};updatePager=function(){if(f.settings.pager){$('.'+f.settings.pagerClass+' li',f.vars.slippryWrapper).removeClass(f.settings.activeClass);$($('.'+f.settings.pagerClass+' li',f.vars.slippryWrapper)[f.vars.active.index()]).addClass(f.settings.activeClass)}};updateControls=function(){if(!f.settings.loop&&f.settings.hideOnEnd){$('.'+f.settings.prevClass,f.vars.slippryWrapper)[f.vars.first?'hide':'show']();$('.'+f.settings.nextClass,f.vars.slippryWrapper)[f.vars.last?'hide':'show']()}};updateCaption=function(){var a,wrapper;if(f.settings.captions!==false){if(f.settings.captionsSrc!=='img'){a=f.vars.active.attr('title')}else{a=$('img',f.vars.active).attr('title')!==undefined?$('img',f.vars.active).attr('title'):$('img',f.vars.active).attr('alt')}if(f.settings.captions!=='custom'){wrapper=$(f.settings.captionsEl,f.vars.slippryWrapper)}else{wrapper=$(f.settings.captionsEl)}if((a!==undefined)&&(a!=='')){wrapper.html(a).show()}else{wrapper.hide()}}};el.startAuto=function(){if((f.vars.timer===undefined)&&(f.vars.delay===undefined)){f.vars.delay=window.setTimeout(function(){f.vars.autodelay=false;f.vars.timer=window.setInterval(function(){f.vars.trigger='auto';el.goToSlide(f.settings.autoDirection)},f.settings.pause)},f.vars.autodelay?f.settings.autoHoverDelay:f.settings.autoDelay)}if(f.settings.autoHover){f.vars.slideWrapper.unbind('mouseenter').unbind('mouseleave').bind('mouseenter',function(){if(f.vars.timer!==undefined){f.vars.hoverStop=true;el.stopAuto()}else{f.vars.hoverStop=false}}).bind('mouseleave',function(){if(f.vars.hoverStop){f.vars.autodelay=true;el.startAuto()}})}};el.stopAuto=function(){window.clearInterval(f.vars.timer);f.vars.timer=undefined;window.clearTimeout(f.vars.delay);f.vars.delay=undefined};el.refresh=function(){f.vars.slides.removeClass(f.settings.activeClass);f.vars.active.addClass(f.settings.activeClass);if(f.settings.responsive){prepareFiller()}else{ready()}updateControls();updatePager();updateCaption()};updateSlide=function(){el.refresh()};transitionDone=function(){f.vars.moving=false;f.vars.active.removeClass(f.settings.transClass);if(!f.vars.fresh){f.vars.old.removeClass('sy-ken')}f.vars.old.removeClass(f.settings.transClass);f.settings.onSlideAfter.call(undefined,f.vars.active,f.vars.old.index(),f.vars.active.index())};doTransition=function(){var a,jump,old_left,old_pos,kenTime,ref,cssProp;f.settings.onSlideBefore.call(undefined,f.vars.active,f.vars.old.index(),f.vars.active.index());if(f.settings.transition!==false){f.vars.moving=true;if((f.settings.transition==='fade')||(f.settings.transition==='kenburns')){if(f.vars.fresh){if(f.settings.useCSS){f.vars.slides.css({transitionDuration:f.settings.speed+'ms',opacity:0})}else{f.vars.slides.css({opacity:0})}f.vars.active.css('opacity',1);if(f.settings.transition==='kenburns'){if(f.settings.useCSS){kenTime=f.settings.pause+f.settings.speed*2;f.vars.slides.css({animationDuration:kenTime+'ms'});f.vars.active.addClass('sy-ken')}}transitionDone()}else{if(f.settings.useCSS){f.vars.old.addClass(f.settings.transClass).css('opacity',0);f.vars.active.addClass(f.settings.transClass).css('opacity',1);if(f.settings.transition==='kenburns'){f.vars.active.addClass('sy-ken')}$(window).off('focus').on('focus',function(){if(f.vars.moving){f.vars.old.trigger(f.vars.transition)}});f.vars.old.one(f.vars.transition,function(){transitionDone();return this})}else{if(f.settings.transition==='kenburns'){doKens()}f.vars.old.addClass(f.settings.transClass).animate({opacity:0},f.settings.speed,f.settings.easing,function(){transitionDone()});f.vars.active.addClass(f.settings.transClass).css('opacity',0).animate({opacity:1},f.settings.speed,f.settings.easing)}}updateSlide()}else if((f.settings.transition==='horizontal')||(f.settings.transition==='vertical')){ref=(f.settings.transition==='horizontal')?'left':'top';a='-'+f.vars.active.index()*(100+f.settings.slideMargin)+'%';if(f.vars.fresh){el.css(ref,a);transitionDone()}else{cssProp={};if(f.settings.continuous){if(f.vars.jump&&((f.vars.trigger==='controls')||(f.vars.trigger==='auto'))){jump=true;old_pos=a;if(f.vars.first){old_left=0;f.vars.active.css(ref,f.vars.count*(100+f.settings.slideMargin)+'%');a='-'+f.vars.count*(100+f.settings.slideMargin)+'%'}else{old_left=(f.vars.count-1)*(100+f.settings.slideMargin)+'%';f.vars.active.css(ref,-(100+f.settings.slideMargin)+'%');a=(100+f.settings.slideMargin)+'%'}}}f.vars.active.addClass(f.settings.transClass);if(f.settings.useCSS){cssProp[ref]=a;cssProp['transitionDuration']=f.settings.speed+'ms';el.addClass(f.settings.transition);el.css(cssProp);$(window).off('focus').on('focus',function(){if(f.vars.moving){el.trigger(f.vars.transition)}});el.one(f.vars.transition,function(){el.removeClass(f.settings.transition);if(jump){f.vars.active.css(ref,old_left);cssProp[ref]=old_pos;cssProp['transitionDuration']='0ms';el.css(cssProp)}transitionDone();return this})}else{cssProp[ref]=a;el.stop().animate(cssProp,f.settings.speed,f.settings.easing,function(){if(jump){f.vars.active.css(ref,old_left);el.css(ref,old_pos)}transitionDone();return this})}}updateSlide()}}else{updateSlide();transitionDone()}};updatePos=function(a){f.vars.first=false;f.vars.last=false;if((a==='prev')||(a===0)){f.vars.first=true}else if((a==='next')||(a===f.vars.count-1)){f.vars.last=true}};el.goToSlide=function(a){var b;if(!f.vars.moving){b=f.vars.active.index();if(a==='prev'){if(b>0){a=b-1}else if(f.settings.loop){a=f.vars.count-1}}else if(a==='next'){if(b<f.vars.count-1){a=b+1}else if(f.settings.loop){a=0}}else{a=a-1}f.vars.jump=false;if((a!=='prev')&&(a!=='next')&&((a!==b)||(f.vars.fresh))){updatePos(a);f.vars.old=f.vars.active;f.vars.active=$(f.vars.slides[a]);if(((b===0)&&(a===f.vars.count-1))||((b===f.vars.count-1)&&(a===0))){f.vars.jump=true}doTransition()}}};el.goToNextSlide=function(){el.goToSlide('next')};el.goToPrevSlide=function(){el.goToSlide('prev')};initPager=function(){if((f.settings.pager)&&(f.vars.count>1)){var a,loop,pager;a=f.vars.slides.length;pager=$('<ul class="'+f.settings.pagerClass+'" />');for(loop=1;loop<a+1;loop=loop+1){pager.append($('<li />').append($('<a href="#'+loop+'">'+loop+'</a>')))}f.vars.slippryWrapper.append(pager);$('.'+f.settings.pagerClass+' a',f.vars.slippryWrapper).click(function(){f.vars.trigger='pager';el.goToSlide(parseInt(this.hash.split('#')[1],10));return false});updatePager()}};initControls=function(){if((f.settings.controls)&&(f.vars.count>1)){f.vars.slideWrapper.append($('<ul class="'+f.settings.controlClass+'" />').append('<li class="'+f.settings.prevClass+'"><a href="#prev">'+f.settings.prevText+'</a></li>').append('<li class="'+f.settings.nextClass+'"><a href="#next">'+f.settings.nextText+'</a></li>'));$('.'+f.settings.controlClass+' a',f.vars.slippryWrapper).click(function(){f.vars.trigger='controls';el.goToSlide(this.hash.split('#')[1]);return false});updateControls()}};initCaptions=function(){if(f.settings.captions!==false){if(f.settings.captions==='overlay'){f.vars.slideWrapper.append($('<div class="sy-caption-wrap" />').html(elFromSel('<div />',f.settings.captionsEl)))}else if(f.settings.captions==='below'){f.vars.slippryWrapper.append($('<div class="sy-caption-wrap" />').html(elFromSel('<div />',f.settings.captionsEl)))}}};start=function(){el.goToSlide(f.vars.active.index()+1)};preload=function(a){var b,loop,elements,container;container=(f.settings.preload==='all')?a:f.vars.active;elements=$('img, iframe',container);b=elements.length;if(b===0){start();return}loop=0;elements.each(function(){$(this).one('load error',function(){if(++loop===b){start()}}).each(function(){if(this.complete){$(this).load()}})})};el.getCurrentSlide=function(){return f.vars.active};el.getSlideCount=function(){return f.vars.count};el.destroySlider=function(){if(f.vars.fresh===false){el.stopAuto();f.vars.moving=false;f.vars.slides.each(function(){if($(this).data("sy-cssBckup")!==undefined){$(this).attr("style",$(this).data("sy-cssBckup"))}else{$(this).removeAttr('style')}if($(this).data("sy-classBckup")!==undefined){$(this).attr("class",$(this).data("sy-classBckup"))}else{$(this).removeAttr('class')}});if(el.data("sy-cssBckup")!==undefined){el.attr("style",el.data("sy-cssBckup"))}else{el.removeAttr('style')}if(el.data("sy-classBckup")!==undefined){el.attr("class",el.data("sy-classBckup"))}else{el.removeAttr('class')}f.vars.slippryWrapper.before(el);f.vars.slippryWrapper.remove();f.vars.fresh=undefined}};el.reloadSlider=function(){el.destroySlider();init()};init=function(){var a;f.settings=$.extend({},g,e);f.vars.slides=$(f.settings.elements,el);f.vars.count=f.vars.slides.length;if(f.settings.useCSS){if(!supports('transition')){f.settings.useCSS=false}f.vars.transition=whichTransitionEvent()}el.data('sy-cssBckup',el.attr('style'));el.data('sy-classBackup',el.attr('class'));el.addClass(f.settings.boxClass).wrap(f.settings.slippryWrapper).wrap(f.settings.slideWrapper).wrap(f.settings.slideCrop);f.vars.slideWrapper=el.parent().parent();f.vars.slippryWrapper=f.vars.slideWrapper.parent().addClass(f.settings.loadingClass);f.vars.fresh=true;f.vars.slides.each(function(){$(this).addClass('sy-slide '+f.settings.transition);if(f.settings.useCSS){$(this).addClass('useCSS')}if(f.settings.transition==='horizontal'){$(this).css('left',$(this).index()*(100+f.settings.slideMargin)+'%')}else if(f.settings.transition==='vertical'){$(this).css('top',$(this).index()*(100+f.settings.slideMargin)+'%')}});if((f.vars.count>1)||(f.settings.initSingle)){if($('.'+f.settings.activeClass,el).index()===-1){if(f.settings.start==='random'){a=Math.round(Math.random()*(f.vars.count-1))}else if(f.settings.start>0&&f.settings.start<=f.vars.count){a=f.settings.start-1}else{a=0}f.vars.active=$(f.vars.slides[a]).addClass(f.settings.activeClass)}else{f.vars.active=$('.'+f.settings.activeClass,el)}initControls();initPager();initCaptions();preload(f.vars.slides)}else{return this}};init();return this}}(jQuery));

function smoothScroll(el) {
  jQuery('body,html').animate({
    scrollTop: $($(el).attr('href')).offset().top
  }, 600);
}

jQuery(document).ready(function(){
  jQuery('#slippry-demo').slippry({
    slippryWrapper: '<div class="sy-box front-page" />'
  });

  jQuery('.button-link.download, .button-link.github-download').click(function () {
    ga('send', 'event', 'Download', 'Click', 'Slippry(zip)');
  })

  jQuery('.github-link').click(function () {
    ga('send', 'event', 'Github', 'Click', 'Ribbon');
  });

  // Generic
  jQuery('#out-of-the-box-demo').slippry();

  jQuery('#settings-jump a:not(#select-setting)').click(function () {
    smoothScroll(this);
  });

  jQuery('#front-link').click(function () {
    smoothScroll(this);
  });
  
  // Pictures Slider
  jQuery('#pictures-demo').slippry({
    // general elements & wrapper
    slippryWrapper: '<div class="sy-box pictures-slider" />', // wrapper to wrap everything, including pager

    // options
    adaptiveHeight: false, // height of the sliders adapts to current slide
    captions: false, // Position: overlay, below, custom, false

    // pager
    pager: false,
    
    // controls
    controls: false,
    autoHover: false,

    // transitions
    transition: 'fade', // fade, horizontal, kenburns, false
    kenZoom: 140,
    speed: 2000 // time the transition takes (ms)
  });

  // Portfolio
  jQuery('#portfolio-demo').slippry({
    // general elements & wrapper
    slippryWrapper: '<div class="sy-box portfolio-slider" />', // wrapper to wrap everything, including pager

    // options
    adaptiveHeight: false, // height of the sliders adapts to current slide
    start: 'random', // num (starting from 1), random
    loop: false, // first -> last & last -> first arrows
    captionsSrc: 'li',
    captions: 'custom', // Position: overlay, below, custom, false
    captionsEl: '.external-captions',

    // transitions
    transition: 'fade', // fade, horizontal, kenburns, false
    easing: 'linear', // easing to use in the animation [(see... [jquery www])]
    continuous: false,

    // slideshow
    auto: false
  });

  // News
  jQuery('#news-demo').slippry({
    // general elements & wrapper
    slippryWrapper: '<div class="sy-box news-slider" />', // wrapper to wrap everything, including pager
    elements: 'article', // elments cointaining slide content

    // options
    adaptiveHeight: false, // height of the sliders adapts to current 
    captions: false,

    // pager
    pagerClass: 'news-pager',

    // transitions
    transition: 'fade', // fade, horizontal, kenburns, false
    speed: 1200,
    pause: 8000,

    // slideshow
    autoDirection: 'prev'
  });

  // Shop
  jQuery('#shop-demo').slippry({
    // general elements & wrapper
    slippryWrapper: '<div class="sy-box shop-slider" />', // wrapper to wrap everything, including pager
    elements: 'article', // elments cointaining slide content

    // options
    adaptiveHeight: false, // height of the sliders adapts to current slide
    start: 2, // num (starting from 1), random
    loop: false, // first -> last & last -> first arrows
    captionsSrc: 'article',
    captions: 'custom', // Position: overlay, below, custom, false
    captionsEl: '.product-name',

    // pager
    pager: false,

    // transitions
    slideMargin: 20, // spacing between slides (in %)
    useCSS: true,
    transition: 'fade',

    // slideshow
    auto: false
  });
  
  // thumbnails
  var thumbs = jQuery('#thumbnails').slippry({
    // general elements & wrapper
    slippryWrapper: '<div class="sy-box thumbnails" />', // wrapper to wrap everything, including pager
    // options
    transition: 'fade',
    pager: false,
    auto: false,
    onSlideBefore: function (el, index_old, index_new) {
      jQuery('.thumbs a img').removeClass('active');
      jQuery('img', jQuery('.thumbs a')[index_new]).addClass('active');
    }
  });

  jQuery('.thumbs a').click(function () {
    thumbs.goToSlide($(this).data('slide'));
    return false;
  });

  // CSS vs jQuery
  jQuery('#css-demo').slippry({
    // general elements & wrapper
    slippryWrapper: '<div class="sy-box css-demo" />', // wrapper to wrap everything, including pager
    // options
    adaptiveHeight: true, // height of the sliders adapts to current slide
    useCSS: true, // true, false -> fallback to js if no browser support
    autoHover: false,
    transition: 'fade'
  });

  jQuery('#jquery-demo').slippry({
    // general elements & wrapper
    slippryWrapper: '<div class="sy-box jquery-demo" />', // wrapper to wrap everything, including pager
    // options
    adaptiveHeight: false, // height of the sliders adapts to current slide
    useCSS: false, // true, false -> fallback to js if no browser support
    autoHover: false,
    transition: 'fade'
  });

  jQuery('#select-setting').click( function() {
    if(jQuery('#settings-jump').hasClass('open')) {
      jQuery('#settings-jump').switchClass('open','closed',1000);
    } else if(jQuery('#settings-jump').hasClass('closed')) {
      jQuery('#settings-jump').switchClass('closed','open',1000);
    } 
    return false;
  });
  jQuery('#settings-jump a').click( function () {
    if(jQuery('#settings-jump').hasClass('open')) {
      jQuery('#settings-jump').switchClass('open','closed',1000);
    }
  });
});
