jQuery(function(e){function t(t){var i=e("a",g)
w=isNaN(t)?y-1>w?w+1:0:t,i.clone().addClass("temp").appendTo(g).fadeOut(function(){e(this).remove()}),i.attr("href",slideList[w].link).attr("title",slideList[w].title).html('<img src="'+slideList[w].image+'" alt="'+slideList[w].title+'">')}function i(){_>0?(q.val("发表成功("+_--+")"),setTimeout(i,1e3)):(q.val("发表评论").prop("disabled",!1),_=15)}function n(e){e&&(E=e,o.stop().animate({scrollTop:E.offset().top-85},500))}var a=e(window),s=e(document),o=e("html, body"),l=e("#s"),r=e("#rocket"),c=e("html").hasClass("lt-ie7"),d=e("html").hasClass("lt-ie8")
if(e("#m-btns .search").click(function(){e("body").toggleClass("m-search"),l.focus()}),c&&e(".menu-item-has-children").mouseenter(function(){e(this).find(".sub-menu").show()}).mouseleave(function(){e(this).find(".sub-menu").hide()}),d&&l.focus(function(){l.addClass("focus")}).blur(function(){l.removeClass("focus")}),!(c||window.matchMedia&&window.matchMedia("(max-width: 540px)").matches)&&(a.scroll(function(){a.scrollTop()>Math.max(400,a.height())?r.addClass("show"):r.removeClass("show")}),MINTY.stickySidebar)){var f=e("#sidebar"),m=e("#sidebar-top"),u=e("#sidebar-bottom")
if("top"==MINTY.stickySidebar&&m.length)var h=m,p=f.height()+f.offset().top
else if("bottom"==MINTY.stickySidebar&&u.length)var h=u,p=h.offset().top-85
h&&h.length&&a.scroll(function(){a.scrollTop()>p?h.addClass("sticky"):h.removeClass("sticky")}).resize(function(){h.css("left",f.offset().left)}).resize()}if(r.click(function(){return r.addClass("launch"),o.animate({scrollTop:0},600,function(){r.removeClass("show launch")}),!1}),"object"==typeof slideList&&slideList.length){var v,g=e(".slideshow-wrap"),y=slideList.length,w=0
if(g.html('<a href="'+slideList[0].link+'" title="'+slideList[0].title+'"><img src="'+slideList[0].image+'" alt="'+slideList[0].title+'" width="220" height="110"></a>'),y>1){var b=e("<span class='prev'>&lsaquo;</span>"),k=e("<span class='next'>&rsaquo;</span>")
b.click(function(){t(0==w?y-1:w-1)}),k.click(function(){t()}),g.append(b).append(k).hover(function(){clearInterval(v)},function(){v=setInterval(t,7e3)}),v=setInterval(t,7e3)}}var C=e("#main"),T=0
C.on("click",".loadmore",function(t,i){if(T)return!1
var a=e(this).attr("title","正在加载…").addClass("loading"),s=a.attr("href")
return T=1,e.get(s,function(t){a.parent().remove()
var o=e(t),l=o.find(".hentry").addClass("fadein")
C.append(l).append(o.find(".navigation")),i&&n(l.eq(0))
var r=o.filter("title").text()
window.history&&history.pushState&&history.pushState(null,r,s),document.title=r,T=0}),!1})
var I=e("#comments")
I.on("click",".loadmore",function(){var t=e(this)
return t.hasClass("loading")?!1:(t.attr("title","正在加载…").addClass("loading"),e.get(t.attr("href"),function(i){t.parent().remove()
var n=e(i).find(".commentlist").addClass("fadein")
MINTY.lazyload&&n.find("img.lazy").lazyload({effect:"fadeIn"}),I.append(n).append(e(i).find(".navigation"))}),!1)})
var x=e("#commentform"),N=e("#comment"),M=e("#comments-title"),S=e("#comment-settings"),L=e(".comment-settings-toggle"),Y=e("span",L),z=e("#author"),q=e("#submit")
L.click(function(){S.hasClass("show")||(S.addClass("show"),e(this).removeClass("required"),z.focus(),setTimeout(function(){s.on("click.comment",function(e){S.find(e.target).length||e.target==S[0]||(S.removeClass("show"),s.off("click.comment"))})},100))}),z.on("change input",function(){Y.text(e(this).val())}),N.keydown(function(e){if(e.ctrlKey&&13==e.keyCode)x.trigger("submit")
else if(9==e.keyCode)return L.click(),!1}),e(".comments-link").click(function(){N.focus()}),e("#respond input").add(N).on("invalid",function(){e(this).one("input change",function(){e(this).parent().removeClass("invalid")}).parent().addClass("invalid"),e(this)[0]!=N[0]&&L.click()}),e(".commentlist").eq(0).children().length<10&&e("#comments .loadmore").length&&e("#comments .loadmore").trigger("click")
var P,j,_=15
if(x.submit(function(){return e.ajax({type:e(this).attr("method"),url:MINTY.ajaxurl,data:e(this).serialize()+"&action=minty_ajax_comment",beforeSend:function(){j=e("#comment_parent").val(),q.val("正在提交.").prop("disabled",!0),N.prop("disabled",!0),P=window.setInterval(function(){q.val("正在提交..."==q.val()?"正在提交.":q.val()+".")},700)},success:function(t){if(window.clearInterval(P),/<\/li>/.test(t)){if(e(".commentlist").length>0){"0"==j?e("<div style='display:none'>"+t+"</div>").prependTo(e(".commentlist").eq(0)).fadeIn():e("<ol class='children' style='display:none'>"+t+"</ol>").insertAfter(e("#comment-"+j)).fadeIn()
var n=parseInt(M.text().match(/\d/g).join(""))+1
n>999&&(n=(""+n/1e3).replace(".",",")),M.text(n+" 条评论")}else e(".no-comments").replaceWith(e("<ol class='commentlist' style='display:none'>"+t+"</ol>").fadeIn()),M.text("1 条评论")
N.prop("disabled",!1).val(""),i()}else alert(e("<div>"+t+"</div>").text()),q.prop("disabled",!1).val("发表评论"),N.prop("disabled",!1)},error:function(){window.clearInterval(P),alert("遇到点小问题，请重新提交评论。"),q.prop("disabled",!1).val("发表评论"),N.prop("disabled",!1)}}),!1}),MINTY.keyboardNavigation){var E
e(document).keypress(function(t){var i=t.target.tagName
if("TEXTAREA"!=i&&"INPUT"!=i)switch(t.which){case 106:var a=e(".previous-post a")[0]
if(a)location.href=a.href
else{if(T)return
if(E){var l=E.next()
l.hasClass("ga")&&(l=l.next()),l.hasClass("hentry")?n(l):e(".loadmore").length&&(e(".loadmore").trigger("click",1),o.animate({scrollTop:s.height()},500))}else n(e(".hentry").eq(1))}t.preventDefault()
break
case 107:var r=e(".next-post a")[0]
if(r)location.href=r.href
else{if(T)return
if(E){var c=E.prev()
c.hasClass("ga")&&(c=c.prev()),c.hasClass("hentry")&&n(c)}else n(e(".hentry").eq(1))}t.preventDefault()
break
case 114:N.focus(),t.preventDefault()
break
case 47:e("#s").focus(),t.preventDefault()}})}if(MINTY.infiniteScroll>0){var D=parseInt(MINTY.infiniteScroll)
s.on("inview",".navigation .loadmore",function(t,i){1>D?s.off("inview"):i&&!e(this).hasClass("loading")&&(e(this).trigger("click"),D--)})}e(".widget-title span").each(function(){var t=e(this)
t.attr("title",t.text())}),MINTY.lazyload&&e("img.lazy").lazyload({effect:"fadeIn"}),location.hash.indexOf("#comment-")>-1&&window.setTimeout(function(){s.scrollTop(s.scrollTop()-74)},1),"ontouchstart"in window?(document.documentElement.className+="touch",e(".menu-item-has-children, .page_item_has_children").attr("aria-haspopup",!0).children("a").on(window.PointerEvent?"pointerup":navigator.msPointerEnabled?"MSPointerUp":"touchend",function(){return e(this).next().toggle(),!1})):"object"==typeof NProgress&&(NProgress.configure({showSpinner:!1}),NProgress.start(),document.onreadystatechange=function(){"complete"==document.readyState&&setTimeout(NProgress.done,500)}),e.fn.responsiveSlides&&e("#featured-content .rslides").responsiveSlides({auto:!0,pager:!1,nav:!0,timeout:MINTY.slidesTimeout||4e3,prevText:"‹",nextText:"›"})})
