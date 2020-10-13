(function ($) {
$(function () {

    // run fancyzoom plugin, options here: http://fancybox.net/api

    $(".zoom-html").fancybox({
        'scrolling'     : 'no',
        'titleShow'     : false
    });

    // hook zoom-image class with fancybox plugin

    $(".zoom-image").each(function() {

        var $t = $(this);

        $('<div class="zoom-dim" />').insertAfter($t)
                                     .click(function () {
                                         $t.click();
                                     });

    }).fancybox();

    // hook zoom-video class with fancybox plugin.
    // only if we are not on a mobile device.
    if (!Modernizr.touch) {

        $(".zoom-video").each(function () {

            var $t = $(this),
                vimeo = false,
                youtube = false,
                href = '',
                vimeo_regexp = /vimeo\.com\/(\d+)/,
                youtube_regexp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;

            if ($t.attr('href') == undefined) {
                return false;
            }

            vimeo = $t.attr('href').match(vimeo_regexp);
            if (vimeo && vimeo[1]) {
                vimeo = vimeo[1];
            } else {
                vimeo = false;
            }

            youtube = $t.attr('href').match(youtube_regexp);
            if (youtube && youtube[7] && youtube[7].length == 11) {
                youtube = youtube[7];
            } else {
                youtube = false;
            }

            if (!vimeo && !youtube) {
                return false;
            }

            $('<div class="play-dim" />').insertAfter($t)
                                         .click(function () {
                                             $t.click();
                                         });

            if (vimeo) {
                href = 'http://player.vimeo.com/video/'+vimeo+'?title=0&amp;byline=0&amp;portrait=0';
            }

            if (youtube) {
                href = 'http://www.youtube.com/embed/' + youtube + '?wmode=Opaque';
            }

            $(this).click(function() {

                $.fancybox({
                    'padding'       : 0,
                    'autoScale'     : false,
                    'wmode'         : 'transparent',
                    'width'         : 640,
                    'height'        : 360,
                    'href'          : href,
                    'type'          : 'iframe'
                });

                return false;

            });

        })

        // skills pyramid available on desktop only
        var $skills = $('.skills'),
            $skillsArticle = $skills.closest('article');

        $skills.find('br').each(function () {
            if (!$(this).next().is('.comma')) {
                $('<span class="comma">,</span>').insertAfter($(this));
            }
        }).end().find('.caption').each(function () {
            if (!$(this).next().is('i.sep')) {
                $('<i class="sep">&nbsp;</i>').insertAfter($(this));
            }
        })

        // this will fix horizontal lines when resizing
        $(window).resize(function () {

            if (Modernizr.mq('screen and (max-width: 768px)')) {
                // there is not enough space for pyramid, lets simplify
                $('body').addClass('responsive');
            } else {
                $('body').removeClass('responsive');
            }


            $skills.find('.caption').each(function () {

                var A = $(this).next().position().left
                    B = $skillsArticle.width();

                $(this).width(B - A + 20);

            });

        });

        $(window).resize();

        if (!Modernizr.opacity) {

            $(".portfolio li").hover(function () {

                $(this).find('.mask, .zoom-dim, .play-dim').fadeIn(400);

            }, function () {

                $(this).find('.mask, .zoom-dim, .play-dim').fadeOut(400);

            })

        }

    }

    // contact form handling

    $contact_form = $("form#contacts");
    if ($contact_form.length > 0) {

        // on form submit
        $contact_form.submit(function () {

            // validate any fields that have input-error class
            $contact_form.find('.input-error').removeClass('input-error');

            $contact_form.find("input[type=text]:visible, textarea:visible").each(function () {

                if ($(this).val() == '') {
                    $(this).addClass('input-error');
                }

            });

            // validate email
            var $email = $contact_form.find('.input-email'),
                re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            if ($email.length > 0) {

                if (!re.test($email.val())) {
                    $email.addClass('input-error');
                }

            }

            if ($contact_form.find('.input-error').length > 0) {
                return false;
            }

            // if it is valid

            // freeze height of parent before hiding submit button
            // so it does not flicker
            $contact_form.find('[type=submit]').parent().freezeHeight().end().hide();

            // post everything to contact form
            $.post($contact_form.attr('action'), {

                contact_name: $contact_form.find('#contact_name').val(),
                contact_email: $contact_form.find('#contact_email').val(),
                contact_message: $contact_form.find('#contact_message').val(),
                email: $contact_form.find('#email').val(),
                ajax: true,
                contact_send: 1

            }, function (response) {

                // check for response and show message
                if (response == 'sent') {
                    $contact_form.find('.on-success').fadeIn();
                } else {
                    $contact_form.find('.on-error').fadeIn();
                }

            });

            return false;

        });

    }

})
})(jQuery)

