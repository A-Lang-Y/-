/*jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, curly:false, browser:true, jquery:false */
/*global jQuery */

var responsiveDesign = {
    isResponsive: false,
    isDesktop: false,
    isTablet: false,
    isPhone: false,
    windowWidth: 0,
    responsive: function () {
        'use strict';
        var html = jQuery("html");
        this.windowWidth = jQuery(window).width();
        var triggerEvent = false;

        var isRespVisible = jQuery("#rubel-resp").is(":visible");
        if (isRespVisible && !this.isResponsive) {
            html.addClass("responsive").removeClass("desktop");
            this.isResponsive = true;
            this.isDesktop = false;
            triggerEvent = true;
        } else if (!isRespVisible && !this.isDesktop) {
            html.addClass("desktop").removeClass("responsive responsive-tablet responsive-phone");
            this.isResponsive = this.isTablet = this.isPhone = false;
            this.isDesktop = true;
            triggerEvent = true;
        }

        if (this.isResponsive) {
            if (jQuery("#rubel-resp-t").is(":visible") && !this.isTablet) {
                html.addClass("responsive-tablet").removeClass("responsive-phone");
                this.isTablet = true;
                this.isPhone = false;
                triggerEvent = true;
            } else if (jQuery("#rubel-resp-m").is(":visible") && !this.isPhone) {
                html.addClass("responsive-phone").removeClass("responsive-tablet");
                this.isTablet = false;
                this.isPhone = true;
                triggerEvent = true;
            }
        }

        if (triggerEvent) {
            jQuery(window).trigger("responsive", this);
        }

        jQuery(window).trigger("responsiveResize", this);
    },
    initialize: function () {
        "use strict";
        jQuery("<div id=\"rubel-resp\"><div id=\"rubel-resp-m\"></div><div id=\"rubel-resp-t\"></div></div>").appendTo("body");
        jQuery(window).resize(function () {
            responsiveDesign.responsive();
        });
        jQuery(window).trigger("resize");
    }
};

function responsiveAbsBg(responsiveDesign, el, bg) {
    "use strict";
    if (bg.length === 0)
        return;

    var desktopBgTop = bg.attr("data-bg-top");
    var desktopBgHeight = bg.attr("data-bg-height");

    if (responsiveDesign.isResponsive) {
        if (typeof desktopBgTop === "undefined" || desktopBgTop === false) {
            bg.attr("data-bg-top", bg.css("top"));
            bg.attr("data-bg-height", bg.css("height"));
        }

        var elTop = el.offset().top;
        var elHeight = el.outerHeight();
        bg.css("top", elTop + "px");
        bg.css("height", elHeight + "px");
    } else if (typeof desktopBgTop !== "undefined" && desktopBgTop !== false) {
        bg.css("top", desktopBgTop);
        bg.css("height", desktopBgHeight);
        bg.removeAttr("data-bg-top");
        bg.removeAttr("data-bg-height");
    }
}

jQuery(window).bind("responsive", function (event, responsiveDesign) {
    'use strict';
    responsiveCollages(responsiveDesign);
    responsiveImages(responsiveDesign);
    responsiveVideos(responsiveDesign);
});

function responsiveImages(responsiveDesign) {
    'use strict';
    jQuery("img[width]").each(function () {
        var img = jQuery(this), newWidth = "", newMaxWidth = "", newHeight = "";
        if (responsiveDesign.isResponsive) {
            newWidth = "auto";
            newHeight = "auto";
            newMaxWidth = "100%";

            var widthAttr = img.attr("width");
            if (widthAttr !== null && typeof(widthAttr) === "string" && widthAttr.indexOf("%") === -1) {
                newWidth = "100%";
                newMaxWidth = parseInt(jQuery.trim(widthAttr), 10) + "px";
            } 
        }
        img.css("width", newWidth).css("max-width", newMaxWidth).css("height", newHeight);
    });
}

function responsiveCollages(responsiveDesign) {
    'use strict';
    if (jQuery.browser.msie && jQuery.browser.version <= 8) return;
    jQuery(".rubel-collage").each(function () {
        var collage = jQuery(this);
        var sliderObject = collage.find(".rubel-slider").data("slider");
        var responsiveImage = jQuery("img#" + collage.attr("id"));

        if (responsiveDesign.isResponsive) {
            if (responsiveImage.length) { return true; }
            if (jQuery.support.transition) {
                collage.find(".rubel-slider").trigger(jQuery.support.transition.event);
            }
            if (sliderObject) {
                sliderObject.stop();
            }
            var activeSlide = collage.find(".rubel-slide-item.active");
            if (!activeSlide.length) {
                var slides = collage.find(".rubel-slide-item");
                if (slides.length) {
                    activeSlide = jQuery(slides.get(0));
                }
            }
            activeSlide.css("background-image", "");
            var bg = activeSlide.css("background-image").replace(/url\(['"]?(.+?)['"]?\)/i, "$1");
            jQuery("<img>").attr({
                "src": bg,
                "id": collage.attr("id")
            }).insertBefore(collage);
        } else if (responsiveImage.length) {
            responsiveImage.remove();
            if (sliderObject) {
                if (sliderObject.settings.animation !== "fade") {
                    collage.find(".rubel-slide-item").css("background-image", "none");
                }
                sliderObject.start();
            }
        }
    });
}

function responsiveVideos(responsiveDesign) {
    "use strict";
    jQuery("iframe,object,embed").each(function () {
        var obj = jQuery(this);
        var container = obj.parent(".rubel-responsive-embed");
        if (responsiveDesign.isResponsive) {
            if (container.length !== 0)
                return;
            container = jQuery("<div class=\"rubel-responsive-embed\">").insertBefore(obj);
            obj.appendTo(container);
        } else if (container.length > 0) {
            obj.insertBefore(container);
            container.remove();
        }
    });
}

jQuery(window).bind("responsiveResize", function (event, responsiveDesign) {
    "use strict";
    responsiveAbsBg(responsiveDesign, jQuery(".rubel-header"), jQuery("#rubel-header-bg"));
});
jQuery(window).bind("responsive", function (event, responsiveDesign) {
    "use strict";
    if (jQuery.browser.msie && jQuery.browser.version <= 8) return;
    responsiveHeader(responsiveDesign);
});

function responsiveHeader(responsiveDesign) {
    "use strict";
    var header = jQuery("header.rubel-header");
    var headerShapes = header.find(".rubel-shapes");
    var headerSlider = header.find(".rubel-slider");
    
    if (headerSlider.length) {
        var sliderObject = headerSlider.data("slider");
        
        var activeSlide = headerSlider.find(".rubel-slide-item.active");
        if (!activeSlide.length) {
            var slides = headerSlider.find(".rubel-slide-item");
            if (slides.length) {
                 activeSlide = jQuery(slides.get(0));
            }
        }

        var textblock = headerSlider.find(".rubel-textblock").eq(0);

        if (responsiveDesign.isResponsive) {
            if (header.attr("data-responsive")) return true;
            activeSlide.css("background-image", "");
            header.attr("data-responsive", "true");
            headerSlider.fadeOut(0);
            if (jQuery.support.transition) {
                headerSlider.trigger(jQuery.support.transition.event);
            }
            if (sliderObject) {
                sliderObject.stop();
            }
            if (header.find(".rubel-slogan, .rubel-headline").length === 0) {
                var tb = textblock.clone();
                tb.css("display", "block");
                tb.children("div").css("display", "block");
                tb.appendTo(headerShapes);
            }
            // activeslide background
            var bg = activeSlide.css("background-image").split(/\s*,\s*/);
            header.css("background-image", bg[bg.length - 1]);
        } else if (header.attr("data-responsive")) {
            header.removeAttr("data-responsive");
            header.css("background-image", "");
            if (sliderObject) {
                if (sliderObject.settings.animation !== "fade") {
                    headerSlider.find(".rubel-slide-item").css("background-image", "none");
                }
                headerShapes.find(".rubel-textblock").remove();
                headerSlider.fadeIn(0);
                sliderObject.start();
            }
        }
    } else if (header.find(".rubel-slogan, .rubel-headline").length === 0) {
        header.find(".rubel-textblock").each(function () {
            jQuery(this).add(jQuery(this).children("div")).css("display", responsiveDesign.isResponsive ? "inline-block" : "");
            return false; // break
        });
        jQuery(window).trigger("resize");
    }
}

jQuery(window).bind("responsiveResize", function (event, responsiveDesign) {
    "use strict";
    responsiveAbsBg(responsiveDesign, jQuery("nav.rubel-nav"), jQuery("#rubel-hmenu-bg"));
    responsiveNavFit(responsiveDesign);
});

function responsiveNavFit(responsiveDesign) {
    'use strict';
    var nav = jQuery("nav.rubel-nav");
    var isDesktopNav = true;
    var isResponsiveNav = false;
    if (responsiveDesign.isResponsive) {
        if (!nav.hasClass("responsive-nav")) {
            var itemsWidth = 0;
            var menu = nav.find(".rubel-hmenu");
            menu.children("li").each(function() {
                itemsWidth += jQuery(this).outerWidth(true);
            });
            
            if (menu.width() < itemsWidth || responsiveDesign.isPhone) {
                nav.attr("data-restore-width", responsiveDesign.windowWidth).addClass("responsive-nav").removeClass("desktop-nav");
                isResponsiveNav = true;
                isDesktopNav = false;
            }
        } else {
            var desktopRestoreWidth = parseInt(nav.attr("data-restore-width"), 10) || 0;
            if (desktopRestoreWidth !== 0 && responsiveDesign.windowWidth <= desktopRestoreWidth) {
                isResponsiveNav = true;
                isDesktopNav = false;
            }
        }
    } 

    if (isDesktopNav) {
        nav.removeClass("responsive-nav").addClass("desktop-nav").removeAttr("data-restore-width");
    }

    jQuery(window).trigger("responsiveNav", {isDesktopNav: isDesktopNav, isResponsiveNav: isResponsiveNav});
}



jQuery(window).bind("responsive", function (event, responsiveDesign) {
    "use strict";
    responsiveLayoutCell(responsiveDesign);
});

function responsiveLayoutCell(responsiveDesign) {
    "use strict";
    jQuery(".rubel-content .rubel-content-layout-row,.rubel-footer .rubel-content-layout-row").each(function () {
        var row = jQuery(this);
        var rowChildren = row.children(".rubel-layout-cell");
        if (rowChildren.length > 1) {
            if (responsiveDesign.isTablet) {
                rowChildren.addClass("responsive-tablet-layout-cell").each(function (i) {
                    if ((i + 1) % 2 === 0) {
                        jQuery(this).after("<div class=\"cleared responsive-cleared\">");
                    }
                });
            } else {
                rowChildren.removeClass("responsive-tablet-layout-cell");
                row.children(".responsive-cleared").remove();
            }
        }
    });
}



jQuery(responsiveDesign.initialize);
