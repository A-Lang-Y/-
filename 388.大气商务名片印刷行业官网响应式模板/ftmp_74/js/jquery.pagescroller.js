/*
 *	Page Scroller LITE - jQuery Plugin
 *	A simple plugin to add smooth scroll interaction to your website
 *
 *	Support at: http://www.pagescroller.com
 *
 *	Copyright (c) 2012 Dairien Boyd. All Rights Reserved
 *
 *	Version: 1.0.1 (6/6/2012)
 *	Requires: jQuery v1.4+
 *
 *	Page Scroller is released under the GNU General Public License
 *	(http://www.gnu.org/licenses/). By using Page Scroller, you 
 *	acknowledge and agree to the Terms of Service found here:
 *	(http://www.pagescroller.com/tos/)
 *
 */

var pageScroller = {};
(function (d) {
    d.fn.extend({
        pageScroller: function (h) {
            h = d.extend({
                currentSection: 0,
                sectionClass: "homeblock",
                linkClass: "link",
                navigation: [],
                navigationClass: "standardNav",
                animationSpeed: 500,
                scrollOffset: 0,
                HTML5mode: !1
            }, h);
            pageScroll = function (c, a) {
                d.fx.interval = 5;
                pageScroller.scrollDocument = d(document);
                pageScroller.scrollWindow = d(window);
                pageScroller.scrollBody = d("body");
                pageScroller.scrollPosition = pageScroller.scrollWindow.scrollTop();
                pageScroller.currentSectionHeight = pageScroller.scrollWindow.height();
                pageScroller.options = a;
                pageScroller.options.scrollOffset = parseInt(pageScroller.options.scrollOffset);
                var e = "div";
                a.HTML5mode && (e = "nav");
                pageScroller.options.navigation instanceof Array && (c.append("<" + e + ' class="pageScrollerNav ' + a.navigationClass + '"><ul></ul></' + e + ">"), pageScroller.wrapper = d("." + a.navigationClass.replace(/\s/g, "."), c), pageScroller.navigation = d("ul", pageScroller.wrapper), pageScroller.wrapper.addClass("left"), c.css({
                    position: "relative"
                }));
                a.HTML5mode ? pageScroller.sections = d("section", c) : pageScroller.sections = d("." + a.sectionClass, c);
                pageScroller.sections.each(function (b) {
                    var c = d(this),
                        e = pageScroller.sections.eq(b).attr("title"),
                        f = a.linkClass + " " + a.linkClass + "_" + (b + 1);
                    b == pageScroller.sections.length - 1 && (f += " " + a.linkClass + "_last");
                    c.css({
                        display: "block",
                        position: "relative",
                        "float": "none"
                    });
                    c.addClass(pageScroller.options.sectionClass + "_" + (b + 1));
                    pageScroller.options.navigation instanceof Array ? pageScroller.options.navigation.length ? pageScroller.navigation.append('<li class="' + f + '"><a href="#pageScroll' + b + '">' + pageScroller.options.navigation[b] + "</a></li>") : e && "" != e ? pageScroller.navigation.append('<li class="' + f + '"><a href="#pageScroll' + b + '">' + e + "</a></li>") : pageScroller.navigation.append('<li class="' + f + '"><a href="#pageScroll' + b + '">Navigation ' + (b + 1) + "</a></li>") : pageScroller.navigation = d(pageScroller.options.navigation)
                });
                pageScroller.pageLinks = d("a", pageScroller.navigation);
                pageScroller.pageLinks.each(function (b) {
                    d(this).bind("click", function (a) {
                        a.preventDefault();
                        pageScroller.scrollBody.is(":animated") || (pageScroller.pageLinks.parent("li").removeClass("active"),
				

						d(this).parent("li").addClass("active"));
                        j(c, pageScroller.sections.eq(b), b)
                    })
                });
                pageScroller.next = function () {
                    var b = pageScroller.options.currentSection + 1;
                    if (b != pageScroller.sections.length) {
                        var a = pageScroller.sections.eq(b);
                        j(c, a, b)
                    }
                };
                pageScroller.prev = function () {
                    var b = pageScroller.options.currentSection - 1;
                    0 >= b && (b = 0);
                    var a = pageScroller.sections.eq(b);
                    j(c, a, b)
                };
                pageScroller.goTo = function (a) {
                    goTo(c, pageScroller.options.currentSection, a)
                };
                pageScroller.scrollWindow.bind("scroll", function () {
                    k()
                });
                setTimeout(function () {
                    0 == pageScroller.scrollPosition && k()
                }, 200)
            };
            var k = function () {
                pageScroller.scrollPosition = pageScroller.scrollWindow.scrollTop();
                pageScroller.scrollDistance = pageScroller.scrollPosition + pageScroller.currentSectionHeight;
                for (i = 0; i < pageScroller.sections.length; i++) {
                    var c = pageScroller.sections.eq(i).offset().top;
                    pageScroller.options.scrollOffset && c && (c += parseInt(pageScroller.options.scrollOffset));
                    var a = 0;
                    if (i < pageScroller.sections.length - 1) {
                        var d = pageScroller.sections.eq(i + 1);
                        pageScroller.options.scrollOffset ? a = parseInt(d.offset().top + pageScroller.options.scrollOffset) : a = d.offset().top;
                        var d = pageScroller.pageLinks.eq(i).parent("li"),
                            b = pageScroller.pageLinks.eq(pageScroller.sections.length - 1).parent("li")
                    }
                    if (pageScroller.scrollBody.is(":animated")) return !1;
                    if (pageScroller.scrollDocument.height() == pageScroller.scrollDistance) {
                        if (!b.hasClass("active")) return updateTo = pageScroller.sections.length - 1, g(updateTo), !1
                    } else if (a) {
                        if (pageScroller.scrollPosition >= c && pageScroller.scrollPosition < a && !d.hasClass("active")) return updateTo = i, g(updateTo), !1
                    } else if (pageScroller.scrollPosition >= c && i == pageScroller.sections.length - 1 && !b.hasClass("active")) return updateTo = pageScroller.sections.length - 1, g(updateTo), !1
                }
            }, j = function (c, a, e) {
                var c = d("html, body"),
                    b = d(window).scrollTop(),
                    a = a.offset().top;
                pageScroller.options.scrollOffset && (a += parseInt(pageScroller.options.scrollOffset));
                0 > a && (a = 0);
                a != b && !c.is(":animated") && c.animate({
                    scrollTop: a
                }, pageScroller.options.animationSpeed, "swing").promise().done(function () {
                    g(e)
                })
            }, g = function (c) {
                pageScroller.pageLinks.parent("li").removeClass("active");
                pageScroller.pageLinks.eq(c).parent("li").addClass("active");
                pageScroller.options.currentSection = c
					pageScroller.pageLinks.closest("li.active").prev().addClass("previ-item");
					pageScroller.pageLinks.closest("li.active").removeClass("previ-item");
					pageScroller.pageLinks.closest("li.active").prev().prev().removeClass("previ-item");
		
            };
            if (!pageScroller.options) return pageScroll(this, h)
        }
    })
})(jQuery);