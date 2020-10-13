/*
 * jQuery Polaroid v1.0 - http://karimhossenbux.com/lab/polaroid-slider/
 *
 * TERMS OF USE :
 * 
 * Copyright © 2011 Karim Hossenbux
 * All rights reserved.
 * 
 * Polaroid Slider by Karim Hossenbux is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
 * Based on a work at karimhossenbux.com
 * Permissions beyond the scope of this license may be available at http://www.karimhossenbux.com/contact/
 *
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
*/

(function($) {

	jQuery.fn.polaroid = function(options) {
		var defaults = {
			width: 650,
			pause: 5000,
			animationSpeed: 1500			
		};
		
		var o = $.extend(defaults, options);
		
		return this.each(function() {
	
			var i = 0;
			var spacer = 50;
			var current = false;
			var start = false;
			var nb_thumbs = $('.thumbs').find('.thumb').length;
			var e = $(this);
			
			
			e.find('.thumbs').fadeIn(500);
			e.prepend('<div class="loading"></div><div class="slide slide1"></div><div class="slide slide2"></div>');
			e.append('<div class="clearfix"></div>');

			//$('.slide1, .slide2', e).css('opacity', 0);
			
			
			$(window).resize(function(){
				thumbnails();
			});
			thumbnails();
			
			function thumbnails() {			
				var cWidth = i = space = left = 0;

				if( $('body').width() <= 480 ) {
					nSpacer = 0;
				} else {
					nSpacer = spacer;
				}
				e.find('.thumb').each(function(){
					i++;
					var space = o.width / (nb_thumbs + 1);
					var left = (space * i) - spacer; //50 = half image width
					cWidth = left + space;
					
					$(this).attr('id', 't'+i);
					$(this).stop().animate({'left':left+'px'}, 700, function(){
						$(this).unbind('click')
							   .bind('click', showImage)
							   .bind('autoplay', showImage)
							   .unbind('mouseenter')
							   .bind('mouseenter', upThumb)
							   .unbind('mouseleave')
							   .bind('mouseleave', downThumb);
					}).find('img').stop().animate({'rotate': getdeg()}, 300);
					
					$.preLoadImages($(this).find('img').attr('alt'));
				});
				
				var cWidth = cWidth + ( o.width / (nb_thumbs + 1) ) - spacer;
				e.find('.thumbs').css({
					width: cWidth + 'px',
					marginLeft: '-' + (cWidth/2) + 'px'
				}).fadeIn(500);
				
			}
			
			function getdeg() {
				return deg = Math.floor(Math.random()* 41)-20 + 'deg';
			}
			
			function upThumb(){
				$(this).stop().animate({
					'marginTop'	: '-50px'
				}, 400, 'easeOutBack').find('img').stop().animate({'rotate': '0deg'}, 400);
			}
			
			function downThumb(){
				$(this).stop().animate({
					'marginTop' : '0px'
				}, 400, 'easeOutBack').find('img').stop().animate({'rotate': getdeg()}, 400);
			}
			
			function hideThumb(id){
		        if (current != false) $('.thumbs #'+current).stop(true, true).animate({'top': '0px'}, 400, 'easeOutBack');
		        $('.thumbs #'+id).stop(true, true).animate({'top': '120px'}, 400, 'easeInBack');
		    }
			
			function showImage() {
				$('.text-polaroid').html('');
				var img = $(this).find('img').attr('alt');
				var goto = $(this).find('img').attr('title');
				hideThumb($(this).attr('id'));
				current = $(this).attr('id');
				var big = $('.current-slide', e).css('backgroundImage');
				var slide = $('.slide:not(.current)', e).hasClass('slide1') ? '.slide1' : '.slide2';
				var content = $(this).find('.slide-content').length == 0 ? '' : $(this).find('.slide-content').clone();
				     
				$('.current', e).removeClass('current');
				if ( content == '' ) {
				    if ( $('.slide-content', slide).length > 0 ) $('.slide-content', slide).remove();
                    $(e).find(slide).addClass('current').css('backgroundImage', 'url('+img+')'); 
                
                } else {
                    $(e).find(slide).addClass('current').css('backgroundImage', 'none').html( content );
                    $('.text-polaroid').html('').html( $(content).find('.text').html() );  
                }                  
                $('.slide', e).filter('.current').stop().animate({opacity: 1}, o.animationSpeed);
                $('.slide', e).not('.current').stop().animate({opacity: 0}, o.animationSpeed);
				
// 				$(e).find('.next-slide').css('opacity', 1);
// 				if ( $(this).find('.slide-content').length == 0 ) {          
//     			    $(e).find('.current-slide .slide-content').remove();
//     				$(e).find('.next-slide').css('backgroundImage', big);
//     				$(e).find('.current-slide').css('backgroundImage', 'url('+img+')');   
//     			
//                 } else {
//                     var content = $(this).find('.slide-content').clone();
//                     $(e).find('.current-slide').css('backgroundImage', 'none').html( content );
//                 }                       
//     			$(e).find('.next-slide').animate({'opacity': 0}, 1500);
				
                if (goto == '') {
					$(e).find('.goto').removeAttr('href');
				} else {
					$(e).find('.goto').attr('href', goto);
				}
		
			}
			
			$(e).find('.thumbs .thumb img').on('click autoplay', function () { //reset timer
				clearInterval(start);
				start = setInterval(function(){autoPlay();}, o.pause);
			});
			
			start = setTimeout(function(){
				autoPlay();
				start = setInterval(function(){autoPlay();}, o.pause);
				return start;
			}, 1000);
			
			function autoPlay() {
				if (current == false)
					var tmp = 't0';
				else 
					var tmp = current;
				tmp = tmp.replace('t', '');
				tmp = parseInt(tmp);
				if (tmp == nb_thumbs) {
					tmp = 0;
				}
				tmp++;
				$(e).find('.thumb#t'+tmp).trigger('autoplay');
			}
	
		});
	};
	
	
}) (jQuery)