jQuery(function($){
    var timeline = $('.timeline');
    var contentLoading = false;
    var moveByScrubber = false;
    var loadedPage = [1];

    // Nivo lightbox
    // -------------------------------------
    function nivoLightbox() {
        if (dwtl.gallery_lightbox != 'disable') {
            $('.gallery .thumbnail').nivoLightbox();
        };
    }

    // Timeline layout
    // -------------------------------------
    function dwtl_layout() {
        var dwtl = $('.timeline');
        var dwtl_width = dwtl.outerWidth();
        var dwlt_half = dwtl.find('.dwtl');
            dwtl.removeClass('one-col').addClass('two-col');

        var left_Col = 0,
            right_Col = 0;
        dwlt_half.each(function(index, el) {
            if ($(el).hasClass('normal')) {
                if (left_Col <= right_Col) {
                    $(el).removeClass('dwtl-right').addClass('dwtl-left');
                    left_Col += $(el).outerHeight();
                } else {
                    $(el).removeClass('dwtl-left').addClass('dwtl-right');
                    right_Col += $(el).outerHeight();
                }
            } else if ($(el).hasClass('full')) {
                left_Col = 0;
                right_Col = 0;
            }
        });
        $('.dwtl').css({'opacity':1});
    }

    // Ready
    // -------------------------------------
    $(document).ready(function() {
        dwtl_layout();
        nivoLightbox();

        if ( $('body').hasClass('error404') ) {
            $('html').addClass('error404-html');

            var main_height = $('.main').outerHeight();
            $('.main').css( { 'margin-top': -main_height/2 } );
        };
    });

    $(window).resize(function() {
        dwtl_layout();
    });

    //Timeline scrubber
    // -------------------------------------
    if (typeof $('.timeline-scrubber').offset() !== 'undefined') {
        var scrubberOffset = $('.timeline-scrubber').offset().top - 30;
        if ($('body').hasClass('admin-bar')) {
            scrubberOffset -= 32;
        }
        $('.timeline-scrubber').affix({
            offset: {
                top: scrubberOffset
            }
        });
    }

    $('.timeline-scrubber ul li').on('click', function(event) {
        event.preventDefault();
        var timelineInfinitescroll = $('.timeline').data('infinitescroll');
        var t = $(this);
        var pageNum = t.data('page');
        var scrollPoint = 0;
        if (loadedPage.indexOf(pageNum) > -1 && timeline.find('.timeline-pale[data-page="' + pageNum + '"]').length > 0 ) {
            if( moveByScrubber == pageNum ) {
                return false;
            }
            moveByScrubber = pageNum;
            //Loaded
            scrollPoint = timeline.find('.timeline-pale[data-page="' + pageNum + '"]').offset().top;
            if ($('body').hasClass('admin-bar')) {
                scrollPoint -= 32;
            }

            $('html, body').animate({
                    scrollTop: scrollPoint
                },
                1000, function() {
                    timelineInfinitescroll._binding('bind');
                    $('.timeline-scrubber ul li').removeClass('active');
                    t.addClass('active');
                    moveByScrubber = false;
                });
        } else {
            if( ! contentLoading && ! moveByScrubber ) {
                moveByScrubber = pageNum;
                timelineInfinitescroll._binding('unbind');
                timelineInfinitescroll.options.state.currPage = parseInt(pageNum) - 1;
                var currPage = timelineInfinitescroll.options.state.currPage;
                if (timelineInfinitescroll.options.state.isDone && loadedPage.length < $('.timeline-scrubber ul li').length) {
                    timelineInfinitescroll.options.state.isDone = false;
                }
                timelineInfinitescroll.retrieve();
            }
        }

    });

    timeline.infinitescroll({
        navSelector: ".post-nav",
        nextSelector: ".post-nav .previous a",
        itemSelector: ".post",
        loading: {
            finished: function() {
                contentLoading = false;
                var $t = $('.timeline').data('infinitescroll');
                var opts = $t.options;
                if (!opts.state.isBeyondMaxPage) {
                    opts.loading.msg.fadeOut(opts.loading.speed);
                }
            },
            finishedMsg: infinitescroll.the_end,
            img: dwtl.template_directory_uri + "/assets/img/loading.gif",
            msgText: '',
            start: function() {
                contentLoading = true;
                var $t = $('.timeline').data('infinitescroll');
                var opts = $t.options;
                $(opts.navSelector).hide();
                if (loadedPage.indexOf(opts.state.currPage + 1) > -1) {
                    contentLoading = false;
                    return false;
                }
                loadedPage.push(opts.state.currPage + 1);
                opts.loading.msg
                    .appendTo(opts.loading.selector)
                    .show(opts.loading.speed, $.proxy(function() {
                        $t.beginAjax(opts);
                    }, $t));
            }
        },
        appendCallback: false,
        errorCallback: function() {
            var timelineInfinitescroll = $('.timeline').data('infinitescroll');
            timelineInfinitescroll._binding('bind');
            contentLoading = false;
            moveByScrubber = false;
        }
    }, function(elems) {
        if (elems.length > 0) {
            elems.hide();
            var $t = $('.timeline').data('infinitescroll');
            var opts = $t.options;

            $t._debug('contentSelector', $(opts.contentSelector)[0]);
            var max = Math.max.apply(null, loadedPage);
            var separate = $('<div data-page="' + opts.state.currPage + '" class="timeline-pale dwtl full"><span>' + infinitescroll.page + ' ' + opts.state.currPage + ' </span></div>');
            var pageNum = opts.state.currPage;
            
            if (opts.state.currPage >= max) {
                var separate = $('<div data-page="' + opts.state.currPage + '" class="timeline-pale dwtl full"><span>' + infinitescroll.page + ' ' + opts.state.currPage + ' </span></div>');
                $(opts.contentSelector).append(separate);
                $(opts.contentSelector).append(elems);
            } else {
                var currPage = opts.state.currPage;
                while (currPage > 0) {
                    currPage--;
                    if (loadedPage.indexOf(currPage) > -1) {
                        break;
                    }
                }

                $(opts.contentSelector).find('.post[data-page="' + currPage + '"]:last').after(elems);
                $(opts.contentSelector).find('.post[data-page="' + currPage + '"]:last').after(separate);
                opts.state.currPage = max;
            }
            dwtl_layout();
            nivoLightbox();
            elems.fadeIn('slow');

                scrollPoint = timeline.find('.timeline-pale[data-page="' + pageNum + '"]').offset().top;
                if ($('body').hasClass('admin-bar')) {
                    scrollPoint -= 32;
                }
            if( moveByScrubber ) {
                $('html, body').animate({
                        scrollTop: scrollPoint
                    },
                    1000, function() {
                        moveByScrubber = false;
                        $t._binding('bind');
                        $('.timeline-scrubber ul li').removeClass('active');
                        $('.timeline-scrubber ul li[data-page="' + pageNum + '"]').addClass('active');
                    });
            }
                
        }
    });

    // Window scroll 
    //------------------------
    $(window).on('scroll', function() {
        if( ! contentLoading ) {
           $('.timeline .post').each(function() {
                var t = $(this);
                var position = $(window).scrollTop() - t.offset().top;
                if (position <= 0 && position >= -70 && !moveByScrubber) {
                    var page = t.data('page');
                    $('.timeline-scrubber ul li.active').removeClass('active');
                    $('.timeline-scrubber ul li[data-page="' + page + '"]').addClass('active');
                }
            }); 
       }
    });

    // Get Started
    //------------------------
    $('#get-started').click(function() {
        var wrapPos = $('.wrap').offset().top;
        $('html, body').animate({
            scrollTop: wrapPos
        }, 500);
    });
});