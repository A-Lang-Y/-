/*jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, curly:false, browser:true, jquery:false */
/*global jQuery */

// css helper
(function ($) {
    'use strict';
    var data = [
        { str: navigator.userAgent, sub: 'Chrome', ver: 'Chrome', name: 'chrome' },
        { str: navigator.vendor, sub: 'Apple', ver: 'Version', name: 'safari' },
        { prop: window.opera, ver: 'Opera', name: 'opera' },
        { str: navigator.userAgent, sub: 'Firefox', ver: 'Firefox', name: 'firefox' },
        { str: navigator.userAgent, sub: 'MSIE', ver: 'MSIE', name: 'ie' }
    ];
    var v = function (s, n) {
        var i = s.indexOf(data[n].ver);
        return (i !== -1) ? parseInt(s.substring(i + data[n].ver.length + 1), 10) : '';
    };
    var html = $('html');
    for (var n = 0; n < data.length; n++) {
        if ((data[n].str && (data[n].str.indexOf(data[n].sub) !== -1)) || data[n].prop) {
            html.addClass(data[n].name + ' ' + data[n].name + v(navigator.userAgent, n) || v(navigator.appVersion, n));
            break;
        }
    }

    // 'desktop' class is used as responsive design initial value
    html.addClass('desktop');
})(jQuery);

jQuery(function ($) {
    'use strict';
    var i, j, k, l, m;
    if (!$.browser.msie || parseInt($.browser.version, 10) !== 9) {
        return;
    }

    var splitByTokens = function (str, startToken, endToken, last) {
        if (!last) {
            last = false;
        }
        var startPos = str.indexOf(startToken);
        if (startPos !== -1) {
            startPos += startToken.length;
            var endPos = last ? str.lastIndexOf(endToken) : str.indexOf(endToken, startPos);

            if (endPos !== -1 && endPos > startPos) {
                return str.substr(startPos, endPos - startPos);
            }
        }
        return '';
    };

    var splitWithBrackets = function (str, token, brackets) {
        /*jshint nonstandard:true */
        if (!token) {
            token = ',';
        }
        if (!brackets) {
            brackets = '()';
        }
        var bracket = 0;
        var startPos = 0;
        var result = [];
        if (brackets.lenght < 2) {
            return result;
        }
        var pos = 0;
        while (pos < str.length) {
            var ch = str[pos];
            if (ch === brackets[0]) {
                bracket++;
            }
            if (ch === brackets[1]) {
                bracket--;
            }
            if (ch === token && bracket < 1) {
                result.push(str.substr(startPos, pos - startPos));
                startPos = pos + token.length;
            }
            pos++;
        }
        result.push(str.substr(startPos, pos - startPos));
        return result;
    };

    var byteToHex = function (d) {
        var hex = Number(d).toString(16);
        while (hex.length < 2) {
            hex = "0" + hex;
        }
        return hex;
    };

    for (i = 0; i < document.styleSheets.length; i++) {
        var s = document.styleSheets[i];
        var r = [s];
        for (j = 0; j < s.imports.length; j++) {
            r.push(s.imports[j]);
        }
        for (j = 0; j < r.length; j++) {
            s = r[j];
            var n = [];
            for (k = 0; k < s.rules.length; k++) {
                var css = s.rules[k].cssText || s.rules[k].style.cssText;
                if (!css) {
                    continue;
                }
                var value = splitByTokens(css, '-svg-background:', ';');
                if (value === '') {
                    continue;
                }
                var values = splitWithBrackets(value);
                for (l = 0; l < values.length; l++) {
                    var g = splitByTokens(values[l], 'linear-gradient(', ')', true);
                    if (g === '') {
                        continue;
                    }
                    var args = splitWithBrackets(g);
                    if (args.length < 3) {
                        continue;
                    }
                    var maxOffset = 0;
                    var stops = [];
                    for (m = 1; m < args.length; m++) {
                        var stopValues = splitWithBrackets(args[m].trim(), ' ');
                        if (stopValues.length < 2) {
                            continue;
                        }
                        var stopColor = stopValues[0].trim();
                        var stopOpacity = 1;
                        var colorRgba = splitByTokens(stopColor, 'rgba(', ')', true);
                        var stopOffset = stopValues[1].trim();
                        if (colorRgba !== "") {
                            var rgba = colorRgba.split(',');
                            if (rgba.length < 4) {
                                continue;
                            }
                            stopColor = '#' + byteToHex(rgba[0]) + byteToHex(rgba[1]) + byteToHex(rgba[2]);
                            stopOpacity = rgba[3];
                        }
                        var isPx = stopOffset.indexOf('px') !== -1;
                        if (isPx) {
                            maxOffset = Math.max(maxOffset, parseInt(stopOffset, 10) || 0);
                        }
                        stops.push({ offset: stopOffset, color: stopColor, opacity: stopOpacity, isPx: isPx });
                    }
                    var stopsXML = '';
                    var lastStop = null;
                    for (m = 0; m < stops.length; m++) {
                        if (stops[m].isPx) {
                            stops[m].offset = ((parseInt(stops[m].offset, 10) || 0) / (maxOffset / 100)) + '%';
                        }
                        stopsXML += '<stop offset="' + stops[m].offset + '" stop-color="' + stops[m].color + '" stop-opacity="' + stops[m].opacity + '"/>';
                        if (m === stops.length - 1) {
                            lastStop = stops[m];
                        }
                    }
                    var isLeft = args[0].trim() === 'left';
                    var direction = 'x1="0%" y1="0%" ' + (isLeft ? 'x2="100%" y2="0%"' : 'x2="0%" y2="100%"');
                    var gradientLength = '100%';
                    if (maxOffset > 0) {
                        gradientLength = maxOffset + 'px';
                    }
                    var size = (isLeft ? 'width="' + gradientLength + '" height="100%"' : 'width="100%" height="' + gradientLength + '"');
                    var last = "";
                    if (lastStop !== null && maxOffset > 0) {
                        last = '<rect ' +
                            (isLeft ?
                                'x="' + maxOffset + '" y="0"' :
                                'x="0" y="' + maxOffset + '"') +
                            ' width="100%" height="100%" style="fill:' + lastStop.color + ';opacity:' + lastStop.opacity + ';"/>';

                    }
                    var svgGradient = '<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><linearGradient id="g" gradientUnits="objectBoundingBox" ' + direction + '>' + stopsXML + '</linearGradient><rect x="0" y="0" ' + size + ' fill="url(#g)" />' + last + '</svg>';
                    values[l] = values[l].replace('linear-gradient(' + g + ')', 'url(data:image/svg+xml,' + escape(svgGradient) + ')');
                }
                n.push({ s: s.rules[k].selectorText, v: 'background: ' + values.join(",") });
            }
            for (k = 0; k < n.length; k++) {
                s.addRule(n[k].s, n[k].v);
            }
        }
    }
});

jQuery(function ($) {
    'use strict';
    // ie < 9 slider multiple background fix
    if (!jQuery.browser.msie || jQuery.browser.version > 8) return;
    
    function split(str) {
        str = str.replace(/"/g, '').replace(/%20/g, '');
        return  str.split(/\s*,\s*/);
    }

    $('.ishu-slider .ishu-slide-item').each(function () {
        var bgs = split($(this).css('background-image'));
        // needs to use the last image
        if (bgs.length > 1) {
            $(this).css("background-image", bgs[bgs.length - 1]);
        }
    });
});
jQuery(function ($) {
    'use strict';
    if ($('#ishu-main').children('header.ishu-header').length) {
        $('#ishu-header-bg').insertAfter($('header.ishu-header'));
    }
});

jQuery(function ($) {
    'use strict';
    if ($('#ishu-main').children('header.ishu-header').length) {
        $('#ishu-menu-bg').insertAfter($('header.ishu-header'));
    }
});

jQuery(window).bind('resize', function () {
    'use strict';
    var headerOffset = jQuery("header.ishu-header").offset();
    var pageOffset = jQuery("#ishu-main").offset();
    if (!headerOffset || !pageOffset) {
        return;
    }
    jQuery("#ishu-header-bg").css({
        "top": (headerOffset.top - pageOffset.top) + "px"
    });
});

jQuery(window).bind("resize", function () {
    /*global responsiveDesign */
    'use strict';
    if (typeof responsiveDesign !== "undefined" && responsiveDesign.isResponsive)
        return;
    var sheetLeft = jQuery(".ishu-sheet").offset().left;
    jQuery("header.ishu-header #ishu-flash-area").each(function () {
        var object = jQuery(this);
        object.css("left", sheetLeft + "px");
    });
});

jQuery(function($) {
    'use strict';
    $('nav.ishu-nav').addClass("desktop-nav");
});

jQuery(window).bind('resize', function () {
    'use strict';
    var menu = jQuery("nav.ishu-nav");
    var menuOffset = menu.offset();
    var pageOffset = jQuery('#ishu-main').offset();
    if (!menuOffset || !pageOffset) {
        return;
    }
    jQuery("#ishu-hmenu-bg").css({
        "height": menu.outerHeight() + "px",
        "top": (menuOffset.top - pageOffset.top) + "px"
    });
});


jQuery(function ($) {
    'use strict';
    if (!$.browser.msie || parseInt($.browser.version, 10) > 7) {
        return;
    }
    $('ul.ishu-hmenu>li:not(:first-child)').each(function () { $(this).prepend('<span class="ishu-hmenu-separator"> </span>'); });
});

jQuery(function ($) {
    'use strict';
    $("ul.ishu-hmenu a:not([href])").attr('href', '#').click(function (e) { e.preventDefault(); });
});


jQuery(function ($) {
    'use strict';
    if (!$.browser.msie) {
        return;
    }
    var ieVersion = parseInt($.browser.version, 10);
    if (ieVersion > 7) {
        return;
    }

    /* Fix width of submenu items.
    * The width of submenu item calculated incorrectly in IE6-7. IE6 has wider items, IE7 display items like stairs.
    */
    $.each($("ul.ishu-hmenu ul"), function () {
        var maxSubitemWidth = 0;
        var submenu = $(this);
        var subitem = null;
        $.each(submenu.children("li").children("a"), function () {
            subitem = $(this);
            var subitemWidth = subitem.outerWidth();
            if (maxSubitemWidth < subitemWidth) {
                maxSubitemWidth = subitemWidth;
            }
        });
        if (subitem !== null) {
            var subitemBorderLeft = parseInt(subitem.css("border-left-width"), 10) || 0;
            var subitemBorderRight = parseInt(subitem.css("border-right-width"), 10) || 0;
            var subitemPaddingLeft = parseInt(subitem.css("padding-left"), 10) || 0;
            var subitemPaddingRight = parseInt(subitem.css("padding-right"), 10) || 0;
            maxSubitemWidth -= subitemBorderLeft + subitemBorderRight + subitemPaddingLeft + subitemPaddingRight;
            submenu.children("li").children("a").css("width", maxSubitemWidth + "px");
        }
    });
});
jQuery(function () {
    'use strict';
    setHMenuOpenDirection({
        container: "div.ishu-sheet",
        defaultContainer: "#ishu-main",
        menuClass: "ishu-hmenu",
        leftToRightClass: "ishu-hmenu-left-to-right",
        rightToLeftClass: "ishu-hmenu-right-to-left"
    });
});

var setHMenuOpenDirection = (function($) {
    'use strict';
    return (function(menuInfo) {
        var defaultContainer = $(menuInfo.defaultContainer);
        defaultContainer = defaultContainer.length > 0 ? defaultContainer = $(defaultContainer[0]) : null;

        $("ul." + menuInfo.menuClass + ">li>ul").each(function () {
            var submenu = $(this);

            var submenuWidth = submenu.outerWidth();
            var submenuLeft = submenu.offset().left;

            var mainContainer = submenu.parents(menuInfo.container);
            mainContainer = mainContainer.length > 0 ? mainContainer = $(mainContainer[0]) : null;

            var container = mainContainer || defaultContainer;
            if (container !== null) {
                var containerLeft = container.offset().left;
                var containerWidth = container.outerWidth();

                if (submenuLeft + submenuWidth >= containerLeft + containerWidth) {
                    /* right to left */
                    submenu.addClass(menuInfo.rightToLeftClass).find("ul").addClass(menuInfo.rightToLeftClass);
                } else if (submenuLeft <= containerLeft) {
                    /* left to right */
                    submenu.addClass(menuInfo.leftToRightClass).find("ul").addClass(menuInfo.leftToRightClass);
                }
            }
        });
    });
})(jQuery);


jQuery(window).load(menuExtendedCreate);
function menuExtendedCreate() {
    'use strict';
    var sheet = jQuery(".ishu-sheet");
    var sheetLeft = sheet.offset().left;
    var sheetWidth = sheet.width();

    jQuery(".ishu-hmenu>li").each(function(i, v) {
        var itm = jQuery(this);
        var subm = itm.children("ul");
        if (subm.length === 0) {
            return;
        }

        // reset
        itm.removeClass("ext ext-r ext-l");
        itm.css("width", "").find(".ext-off,.ext-m,.ext-l,.ext-r").remove();
        subm.children("li").children("a").css("width", "");

        var lw = 0, rw = 0;
        
        if (typeof subm.attr("data-ext-l") !== "undefined" && typeof subm.attr("data-ext-r") !== "undefined") {
            lw = parseInt(subm.attr("data-ext-l"), 10) + 0;
            rw = parseInt(subm.attr("data-ext-r"), 10) + 0;
            itm.addClass("ext-r").addClass("ext-l");
        } else {
            var ltr = !subm.hasClass("ishu-hmenu-right-to-left");
            itm.addClass(ltr ? "ext-r" : "ext-l");
        }

        var shadow = 0;
        if (subm.length > 0) {
            var lnk = itm.children("a");
            var lnkWidth = lnk.outerWidth();
            itm.css("width", Math.round(parseFloat(lnkWidth, 10)) + "px");
            var menubarMargin = 5 * 2; // margin * 2 sides
            var menubarBorder = 1 * 2; // border 1 side
            var submWidth = subm.width() + shadow + menubarMargin + menubarBorder;
            var w = submWidth - lnkWidth;
            jQuery("<div class=\"ext-m\"></div>").insertBefore(lnk);
            if (w < 0) {
                var submA = subm.children("li").children("a");
                var pL = parseInt(submA.css("padding-left").replace("px", ""), 10) || 0;
                var pR = parseInt(submA.css("padding-right").replace("px", ""), 10) || 0;
                var bL = parseInt(submA.css("border-left").replace("px", ""), 10) || 0;
                var bR = parseInt(submA.css("border-right").replace("px", ""), 10) || 0;
                subm.children("li").children("a").css("width", (lnkWidth - pL - pR - bL - bR) + "px");
                submWidth = subm.width() + shadow + menubarMargin + menubarBorder;
                w = submWidth - lnkWidth;
            }
            jQuery("<div class=\"ext-l\" style=\"width: " + (lw > 0 ? lw : Math.round(parseFloat(w, 10))) + "px;\"></div>").insertBefore(lnk);
            jQuery("<div class=\"ext-r\" style=\"width: " + (rw > 0 ? rw : Math.round(parseFloat(w, 10))) + "px;\"></div>").insertBefore(lnk);
            itm.addClass("ext");
        }
    });
}

jQuery(function ($) {
    'use strict';
    jQuery(window).bind('resize', function () {
        var bh = jQuery('body').height();
        var mh = 0;
        var c = jQuery('div.ishu-content');
        c.removeAttr('style');

        jQuery('#ishu-main').children().each(function() {
            if (jQuery(this).css('position') !== 'absolute') {
                mh += jQuery(this).outerHeight(true);
            }
        });
        
        if (mh < bh) {
            var r = bh - mh;
            c.css('height', (c.outerHeight(true) + r) + 'px');
        }
    });

    if ($.browser.msie && parseInt($.browser.version, 10) < 8) {
        $(window).bind('resize', function() {
            var c = $('div.ishu-content');
            var s = c.parent().children('.ishu-layout-cell:not(.ishu-content)');
            var w = 0;
            c.hide();
            s.each(function() { w += $(this).outerWidth(true); });
            c.w = c.parent().width(); c.css('width', c.w - w + 'px');
            c.show();
        });
    }

    $(window).trigger('resize');
});

var artButtonSetup = (function ($) {
    'use strict';
    return (function (className) {
        $.each($("a." + className + ", button." + className + ", input." + className), function (i, val) {
            var b = $(val);
            if (!b.hasClass('ishu-button')) {
                b.addClass('ishu-button');
            }
            if (b.is('input')) {
                b.val(b.val().replace(/^\s*/, '')).css('zoom', '1');
            }
            b.mousedown(function () {
                var b = $(this);
                b.addClass("active");
            });
            b.mouseup(function () {
                var b = $(this);
                if (b.hasClass('active')) {
                    b.removeClass('active');
                }
            });
            b.mouseleave(function () {
                var b = $(this);
                if (b.hasClass('active')) {
                    b.removeClass('active');
                }
            });
        });
    });
})(jQuery);
jQuery(function () {
    'use strict';
    artButtonSetup("ishu-button");
});

jQuery(function($) {
    'use strict';
    $('form.ishu-search>input[type="submit"]').attr('value', '');
});

var Control = (function ($) {
    'use strict';
    return (function () {
        this.init = function(label, type, callback) {
            var chAttr = label.find('input[type="' +type + '"]').attr('checked');
            if (chAttr === 'checked') {
              label.addClass('ishu-checked');
            }

            label.mouseleave(function () {
              $(this).removeClass('hovered').removeClass('active');
            });
            label.mouseover(function () {
              $(this).addClass('hovered').removeClass('active');
            });
            label.mousedown(function (event) {
              if (event.which !== 1) {
                  return;
              }
              $(this).addClass('active').removeClass('hovered');
            });
            label.mouseup(function (event) {
              if (event.which !== 1) {
                  return;
              }
              callback.apply(this);
              $(this).removeClass('active').addClass('hovered');
            });
        };
    });
})(jQuery);


var fixRssIconLineHeight = (function (className) {
    'use strict';
    jQuery("." + className).css("line-height", jQuery("." + className).height() + "px");
});

jQuery(function ($) {
    'use strict';
    var rssIcons = $(".ishu-rss-tag-icon");
    if (rssIcons.length){
        fixRssIconLineHeight("ishu-rss-tag-icon");
        if ($.browser.msie && parseInt($.browser.version, 10) < 9) {
            rssIcons.each(function () {
                if ($.trim($(this).html()) === "") {
                    $(this).css("vertical-align", "middle");
                }
            });
        }
    }
});
/**
* @license 
* jQuery Tools 1.2.6 Mousewheel
* 
* NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
* 
* http://flowplayer.org/tools/toolbox/mousewheel.html
* 
* based on jquery.event.wheel.js ~ rev 1 ~ 
* Copyright (c) 2008, Three Dub Media
* http://threedubmedia.com 
*
* Since: Mar 2010
* Date:  
*/
(function ($) {
    'use strict';
    $.fn.mousewheel = function (fn) {
        return this[fn ? "bind" : "trigger"]("wheel", fn);
    };

    // special event config
    $.event.special.wheel = {
        setup: function () {
            $.event.add(this, wheelEvents, wheelHandler, {});
        },
        teardown: function () {
            $.event.remove(this, wheelEvents, wheelHandler);
        }
    };

    // events to bind ( browser sniffed... )
    var wheelEvents = !$.browser.mozilla ? "mousewheel" : // IE, opera, safari
        "DOMMouseScroll" + ($.browser.version < "1.9" ? " mousemove" : ""); // firefox

    // shared event handler
    function wheelHandler(event) {
        /*jshint validthis:true*/
        
        switch (event.type) {

            // FF2 has incorrect event positions
            case "mousemove":
                return $.extend(event.data, { // store the correct properties
                    clientX: event.clientX, clientY: event.clientY,
                    pageX: event.pageX, pageY: event.pageY
                });

                // firefox
            case "DOMMouseScroll":
                $.extend(event, event.data); // fix event properties in FF2
                event.delta = -event.detail / 3; // normalize delta
                break;

            // IE, opera, safari
            case "mousewheel":
                event.delta = event.wheelDelta / 120;
                break;
        }

        event.type = "wheel"; // hijack the event
        return $.event.handle.call(this, event, event.delta);
    }

})(jQuery);


var ThemeLightbox = (function ($) {
    'use strict';
    return (function () {
        var current;
        var images = $("img.ishu-lightbox");

        var b = $("body");

        this.init = function (ctrl) {
            $("img.ishu-lightbox").live("click", { _ctrl: ctrl }, function (e) {

                if (e.data._ctrl === true && !e.ctrlKey) {
                    return;
                }

                reload();
                current = images.index(this);
                show(this);
            });

            $(".arrow.left:not(.disabled)").live("click", function () {
                move(current - 1);
            });

            $(".arrow.right:not(.disabled)").live("click", function () {
                move(current + 1);
            });

            $("img.active").live("click", function () {
                move(current + 1);
            });

            $(".close").live("click", function () {
                close();
            });
        };

        function show(src) {
            var d = $('<div id="ishu-lightbox-bg"><div class="close"><div class="cw"> </div><div class="ccw"> </div><div class="close-alt">&#10007;</div></div></div>');

            var img = $('<img class="ishu-lightbox-image active" alt="" src="' + getFullImgSrc($(src).attr("src")) + '" />');

            resizeOnLoad(img);
            img.appendTo(b);
            showArrows();

            showLoader(true);

            img.load(function () {
                showLoader(false);
                d.appendTo(b).height(Math.max(document.documentElement.scrollHeight, document.body.scrollHeight));
            });

            img.error(function () {
                showLoader(false);
                d.appendTo(b).height(Math.max(document.documentElement.scrollHeight, document.body.scrollHeight));

                //showError(true);
                img.attr("src", $(src).attr("src"));
            });
            d.click(close);
            bindMouse($(".arrow").add(img).add(d));
        }

        function reload() {
            images = $("img.ishu-lightbox");
        }

        function move(index) {
            if (index < 0 || index >= images.length) {
                return;
            }

            showError(false);

            current = index;

            $("img.ishu-lightbox-image:not(.active)").remove();

            var active = $("img.active");

            var target = $('<img class="ishu-lightbox-image" alt="" src="' + getFullImgSrc($(images[current]).attr("src")) + '" />');

            resizeOnLoad(target);
            active.after(target);

            showArrows();
            showLoader(true);

            bindMouse($("#ishu-lightbox-bg").add(target));

            target.load(function () {
                showLoader(false);

                active.removeClass("active");
                target.addClass("active");
            });

            target.error(function () {
                showLoader(false);

                //showError(true);
                active.removeClass("active");
                target.addClass("active");
                target.attr("src", $(images[current]).attr("src"));
            });
        }

        function showArrows() {
            if ($(".arrow").length === 0) {
                b.append($('<div class="arrow left"><div class="arrow-t ccw"> </div><div class="arrow-b cw"> </div><div class="arrow-left-alt">&#8592;</div></div>').css("top", $(window).height() / 2 - 40));

                b.append($('<div class="arrow right"><div class="arrow-t cw"> </div><div class="arrow-b ccw"> </div><div class="arrow-right-alt">&#8594;</div></div>').css("top", $(window).height() / 2 - 40));
            }

            if (current === 0) {
                $(".arrow.left").addClass("disabled");
            } else {
                $(".arrow.left").removeClass("disabled");
            }

            if (current === images.length - 1) {
                $(".arrow.right").addClass("disabled");
            } else {
                $(".arrow.right").removeClass("disabled");
            }
        }

        function showError(enable) {
            if (enable) {
                b.append($('<div class="lightbox-error">The requested content cannot be loaded.<br/>Please try again later.</div>')
                        .css({ "top": $(window).height() / 2 - 60, "left": $(window).width() / 2 - 170 }));
            } else {
                $(".lightbox-error").remove();
            }
        }

        function showLoader(enable) {
            if (!enable) {
                $(".loading").remove();
            }
            else {
                $('<div class="loading"> </div>').css({ "top": $(window).height() / 2 - 16, "left": $(window).width() / 2 - 16 }).appendTo(b);
            }
        }

        var close = function () {
            $("#ishu-lightbox-bg, .ishu-lightbox-image, .arrow, .lightbox-error").remove();
        };

        function resizeOnLoad(img) {
            var width = $(window).width();
            var height = $(window).height();

            img.load(function () {
                var imgHeight = $(this).height();
                var imgWidth = $(this).width();

                // additional space is needed for the next|prev items and border around the images
                if (height < (imgHeight + 10) || width < (imgWidth + 410)) {
                    var hScale = Math.abs(imgWidth / (width - 410));
                    var vScale = Math.abs(imgHeight / (height - 100));

                    var scale = Math.max(vScale, hScale);

                    imgWidth = imgWidth / scale;
                    imgHeight = imgHeight / scale;

                    img.width(imgWidth);
                    img.height(imgHeight);
                }

                img.css({ "top": (height / 2 - imgHeight / 2) - 5, "left": (width / 2 - imgWidth / 2 - 5) });
            });

            return img;
        }

        function bindMouse(img) {
            img.unbind("wheel").mousewheel(function (event, delta) {
                delta = delta > 0 ? 1 : -1;
                move(current + delta);
                event.preventDefault();
            });

            img.mousedown(function (e) {
                // close on middle button click
                if (e.which === 2) {
                    close();
                }
                e.preventDefault();
            });
        }

        function getFullImgSrc(src) {
            var webArchiveRegex = new RegExp("http://www.[A-z0-9-]+-image.com/.webarchive/");
            if ((src.indexOf("http://") === 0 || src.indexOf("https://") === 0) && !webArchiveRegex.test(src)) {
                return src;
            }

            var fileName = src.substring(0, src.lastIndexOf('.'));
            var ext = src.substring(src.lastIndexOf('.'));
            src = fileName + "-large" + ext;

            return src;
        }

    });
})(jQuery);
jQuery(function () {
    'use strict';
    new ThemeLightbox().init();
});
(function($) {
    'use strict';
    // transition && transitionEnd && browser prefix
    $.support.transition = (function() {
        var thisBody = document.body || document.documentElement,
            thisStyle = thisBody.style,
            support = thisStyle.transition !== undefined ||
                thisStyle.WebkitTransition !== undefined ||
                thisStyle.MozTransition !== undefined ||
                thisStyle.MsTransition !== undefined ||
                thisStyle.OTransition !== undefined;
        return support && {
            event: (function() {
                var e = "transitionend";
                if ($.browser.opera) {
                    var version = parseFloat($.browser.version);
                    e = version >= 12 ? (version < 12.50 ? "otransitionend" : "transitionend") : "oTransitionEnd";
                } else if ($.browser.webkit) {
                    e = "webkitTransitionEnd";
                }
                return e;
            })(),
            prefix: (function() {
                var result;
                $.each($.browser, function(key, value) {
                    if (key === "version") {
                        return true;
                    }
                    return (result = {
                        opera: "-o-",
                        mozilla: "-moz-",
                        webkit: "-webkit-",
                        msie: "-ms-"
                    }[key]) ? false : true;
                });
                return result || "";
            })()
        };
    })();

    window.BackgroundHelper = function () {
        var slides = [];
        var direction = "next";
        var motion = "horizontal";
        var width = 0;
        var height = 0;
        var transitionDuration = "";

        this.init = function(motionType, dir, duration) {
            direction = dir;
            motion = motionType;
            slides = [];
            width = 0;
            height = 0;
            transitionDuration = duration;
        };

        this.processSlide = function(element) {
            width = element.outerWidth();
            height = element.outerHeight();
            var pos = [];

            var bgPosition = element.css("background-position");
            var positions = bgPosition.split(",");
            $.each(positions, function (i) {
                var position = $.trim(this);
                var point = position.split(" ");
                if (point.length > 1) {
                    var x = parseInt(point[0], 10);
                    var y = parseInt(point[1], 10);
                    pos.push({ x: x, y: y });
                }
            });

            slides.push({
                "images": element.css("background-image"),
                "positions": pos
            });
            element.css("background-image", "none");
        };

        this.setBackground = function(element, items) {
            var bg = [];
            $.each(items, function (i, o) {
                bg.push(o.images);
            });
            element.css({
                "background-image": bg.join(", "),
                "background-repeat": "no-repeat"
            });
        };

        this.setPosition = function(element, items) {
            var pos = [];
            $.each(items, function(i, o) {
                pos.push(o.positions);
            });
            element.css({
                "background-position": pos.join(", ")
            });
        };

        this.current = function(index) {
            return slides[index] || null;
        };

        this.next = function(index) {
            var next;
            if (direction === "next") {
                next = (index + 1) % slides.length;
            } else {
                next = index - 1;
                if (next < 0) {
                    next = slides.length - 1;
                }
            }
            return slides[next];
        };

        this.items = function(prev, next, move) {
            var prevItem = { x: 0, y: 0 };
            var nextItem = { x: 0, y: 0 };
            var isDirectionNext = direction === "next";
            if (motion === "horizontal") {
                nextItem.x = isDirectionNext ? width : -width;
                nextItem.y = 0;
                if (move) {
                    prevItem.x += isDirectionNext ? -width : width;
                    nextItem.x += isDirectionNext ? -width : width;
                }
            } else if (motion === "vertical") {
                nextItem.x = 0;
                nextItem.y = isDirectionNext ? height : -height;
                if (move) {
                    prevItem.y += isDirectionNext ? -height : height;
                    nextItem.y += isDirectionNext ? -height : height;
                }
            }
            var result = [ ];
            if (!!prev) {
                result.push({ images: prev.images, positions: getCssPositions(prev.positions, prevItem) });
            }
            if (!!next) {
                result.push({ images: next.images, positions: getCssPositions(next.positions, nextItem) });
            }
            
            if (direction === "next") {
                result.reverse();
            }

            return result;
        };

        this.transition = function(container, on) {
            container.css($.support.transition.prefix + "transition", on ? transitionDuration + " ease-in-out background-position" : "");
        };
        
        function getCssPositions(positions, offset) {
            var result = [];
            if (positions === undefined) {
                return "";
            }
            offset.x = offset.x || 0;
            offset.y = offset.y || 0;
            for (var i = 0; i < positions.length; i++) {
                result.push((positions[i].x + offset.x) + "px " + (positions[i].y + offset.y) + "px");
            }
            return result.join(", ");
        }
    };


    var Slider = function (element, settings) {

        var interval = null;
        var active = false;
        var children = element.find(".active").parent().children();
        var last = false;
        var running = false;

        this.settings = $.extend({ }, {
            "animation": "horizontal",
            "direction": "next",
            "speed": 600,
            "pause": 2500,
            "auto": true,
            "repeat": true,
            "navigator": null,
            "clickevents": true,
            "hover": true,
            "helper": null
        }, settings);

        this.move = function (direction, next) {
            var activeItem = element.find(".active"),
                nextItem = next || activeItem[direction](),
                innerDirection = this.settings.direction === "next" ? "forward" : "back",
                reset = direction === "next" ? "first" : "last",
                moving = interval,
                slider = this, tmp;

            active = true;

            if (moving) { this.stop(true); }

            if (!nextItem.length) {
                nextItem = element.find(".ishu-slide-item")[reset]();
                if (!this.settings.repeat) { last = true; active = false; return; }
            }

            if ($.support.transition) {
                nextItem.addClass(this.settings.direction);
                tmp = nextItem.get(0).offsetHeight;
                
                activeItem.addClass(innerDirection);
                nextItem.addClass(innerDirection);
                
                element.trigger("beforeSlide", children.length);
                
                element.one($.support.transition.event, function () {
                    nextItem.removeClass(slider.settings.direction)
                        .removeClass(innerDirection)
                        .addClass("active");
                    activeItem.removeClass("active")
                        .removeClass(innerDirection);
                    active = false;
                    setTimeout(function () {
                        element.trigger("afterSlide", children.length);
                    }, 0);
                });
            } else {
                element.trigger("beforeSlide", children.length);
                
                activeItem.removeClass("active");
                nextItem.addClass("active");
                active = false;
                
                element.trigger("afterSlide", children.length);
            }

            this.navigate(nextItem);

            if (moving) { this.start(); }
        };

        this.navigate = function (position) {
            var index = children.index(position);
            $(this.settings.navigator).children().removeClass("active").eq(index).addClass("active");
        };

        this.to = function (index) {
            var activeItem = element.find(".active"),
                children = activeItem.parent().children(),
                activeIndex = children.index(activeItem),
                slider = this;

            if (index > (children.length - 1) || index < 0) {
                return;
            }

            if (active) {
                return element.one("afterSlide", function () {
                    slider.to(index);
                });
            }
            
            if (activeIndex === index) {
                return;
            }

            this.move(index > activeIndex ? "next" : "prev", $(children[index]));
        };

        this.next = function () {
            if (!active) {
                if (last) { this.stop(); return;  }
                this.move("next");
            }
        };

        this.prev = function () {
            if (!active) {
                if (last) { this.stop(); return; }
                this.move("prev");
            }
        };

        this.start = function (force) {
            if (!!force) {
                setTimeout($.proxy(this.next, this), 10);
            }
            interval = setInterval($.proxy(this.next, this), this.settings.pause);
            running = true;
        };

        this.stop = function (pause) {
            clearInterval(interval);
            interval = null;
            running = !!pause;
            active = false;
        };

        this.active = function () {
            return running;
        };

        this.moving = function () {
            return active;
        };
        
        this.navigate(children.filter(".active"));

        if (this.settings.clickevents) {
            $(this.settings.navigator).on("click", "a", { slider: this }, function (event) {
                var activeIndex = children.index(children.filter(".active"));
                var index = $(this).parent().children().index($(this));
                if (activeIndex !== index) {
                    event.data.slider.to(index);
                }
                event.preventDefault();
            });
        }
        
        if (this.settings.hover) {
            var slider = this;
            element.add(this.settings.navigator)
                   .add(element.siblings(".ishu-shapes")).hover(function () {
                if (element.is(":visible") && !last) { slider.stop(true); }
            }, function () {
                if (element.is(":visible") && !last) { slider.start(); }
            });
        }
    };

    $.fn.slider = function (arg) {
        return this.each(function () {
            var element = $(this),
                data = element.data("slider"),
                options = typeof arg === "object" && arg;

            if (!data) {
                data = new Slider(element, options);
                element.data("slider", data);
            }
            
            if (typeof arg === "string" && data[arg]) {
                data[arg]();
            } else if (data.settings.auto && element.is(":visible")) {
                data.start();
            }
        });
    };

})(jQuery);




jQuery(function ($) {
    "use strict";
    if (!$.browser.msie || parseInt($.browser.version, 10) > 8)
        return;
    var path = "";
    var scripts = $("script[src*='script.js']");
    if (scripts.length > 0) {
        var src = scripts.get(0).src;
        path = src.substr(0, src.indexOf("script.js"));
    }
    var header = $(".ishu-header");
    var bgimages = "url('images/object1081048754.png'), ".split(",");
    var bgpositions = "47px -1px, ".split(",");
    for (var i = 0; i < bgimages.length; i++) {
        var bgimage = $.trim(bgimages[i]);
        if (bgimage === "")
            continue;
        if (path !== "") {
            bgimage = bgimage.replace(/(url\(['"]?)/i, "$1" + path);
        }
        header.find(".ishu-shapes").prepend("<div style=\"position:absolute;top:0;left:0;width:100%;height:100%;background:" + bgimage + " " + bgpositions[i] + " no-repeat\">");
    }
    header.css('background-image', "url('images/header.jpg')".replace(/(url\(['"]?)/i, "$1" + path));
    header.css('background-position', "center top");
});