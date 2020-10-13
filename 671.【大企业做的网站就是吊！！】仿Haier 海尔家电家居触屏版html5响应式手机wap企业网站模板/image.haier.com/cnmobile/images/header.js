/**
 * 展示头部导航菜单
 * @see 只在非首页起作用
 */
function showHeaderBar(){
    var thisObj = $('.js_dropMenuBar');
    thisObj.removeClass("btn-takeback").hide();
    thisObj.closest("#header").find(".main-nav-box").slideUp('fast', function(){
        thisObj.show();
    });
}

/**
 * 隐藏头部导航菜单
 * @see 只在非首页起作用
 */
function hideHeaderBar(){
    var thisObj = $('.js_dropMenuBar');
    thisObj.hide();
    thisObj.closest("#header").find(".main-nav-box").slideDown('fast', function(){
        thisObj.addClass("btn-takeback").show();
    });
}

/**
 * 显示搜索框函数
 */
function showHeaderSearchForm(){
    var thisObj = $('.js_showSearchBtn');
    if ($('.js_dropMenuBar').hasClass('btn-takeback')) {
        $('.js_dropMenuBar').trigger('click');
    }
    $('.js_searchForm').removeClass('hidden').find('.js_searchInput').val('').focus();
    thisObj.addClass('nav-search-on').find('img.icon-nav-searchon').removeClass('hidden').siblings('img.icon-nav-search').addClass('hidden');
    var containerWidth = $('body').width();
    $('.js_searchForm .search-box').width(containerWidth);
}

/**
 * 隐藏搜索框函数
 */
function hideHeaderSearchForm(){
    var thisObj = $('.js_showSearchBtn');
    $('.js_searchForm').addClass('hidden');
    thisObj.removeClass('nav-search-on').find('img.icon-nav-searchon').addClass('hidden').siblings('img.icon-nav-search').removeClass('hidden');
}

$(function(){
  
    // 点击文字实现跳转
    $('.main-nav li span').click(function(){
      var href = $(this).prev('a').attr('href');
      window.location.href = href;
    });
  
    // body最小宽度320px
    if ($('body').width() < 320) {
        $('body').css('width', '320px');
    }
    // 默认的搜索框的文字，可在search-text中自定义
    var defaultSearchText = $('.js_searchInput').val();

    // 下拉菜单
    $('.js_dropHaierMenu').click(function(){
        $('.js_dropMenuBar').trigger('click');
    });
    $('.js_dropMenuBar').click(function(){
        var thisObj = $(this);
        // 判断是否有hidden类，如果没有则有展开收起效果
        if (!thisObj.hasClass('hidden')) {
            // btn-takeback的顺序
            var visibleMainNavObj = thisObj.closest("#header").find(".main-nav-box:visible");
            if (visibleMainNavObj.length) {
                showHeaderBar();
            } else {
                hideHeaderBar();
            }
        }
    });
    // 搜索事件
    $('.js_showSearchBtn').click(function(){
        var thisObj = $(this);
        if(!$('.js_searchForm').hasClass('hidden')) {
            hideHeaderSearchForm();
        } else {
            showHeaderSearchForm();
        }
    });
    $('.js_searchInput').blur(function(){
        if (!$(this).val() || $(this).val() == defaultSearchText ) {
            $(this).val(defaultSearchText);
        }
    });

    // 失去焦点
    // 点击其他地方关闭搜索框
    $('#container, #footer, .search-box').on('touch', function(e){
        if(!$('.js_searchForm').hasClass('hidden')) {
            /* $('.js_searchForm').addClass('hidden');
            $('.js_showSearchBtn').removeClass('nav-search-on'); */
            hideHeaderSearchForm();
        }
    });

    // 后退按钮：
    $('.js_goBack').click(function(){
        if ($('.js_goBack').hasClass('back')) {
            history.back();
        }
    });
    // 搜索类型
    $('.js_topSearchTypeBtn, .js_topSearchTypeSpan').click(function(){
        $('.js_topSearchTypeList').toggle();
    });
    $('.js_topSearchTypeList li').click(function(){
        var val = $(this).attr('data-value');
        var title = $(this).children('a').text();
        $('#js_topSearchVal').val(val);
        $('.js_topSearchTypeSpan').text(title);
        $('.js_topSearchTypeList').toggle();
    });

    $('.js_searchInput').focus(function(){
        var keyword = $.trim($(this).val());
        if (keyword == defaultSearchText) {
            $(this).val('');
            return false;
        }
    });

    if (window.addEventListener){
        // 横屏竖屏切换回调函数
        var supportsOrientationChange = "onorientationchange" in window,
        orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
        window.addEventListener(orientationEvent, function() {
            if ($('.js_searchForm:visible').length) {
                setTimeout(function(){
                    var containerWidth = $('body').width();
                    $('.js_searchForm .search-box').width(containerWidth);
                }, 500);
            }
       }, false);
    }
  // 回到顶部
    $('.js_backTop').click(function(){
      $(window).scrollTop(0);
    });
    
    // 已经登录切换环形导航菜单
    $('.js_logedin').click(function(){
        $('.js_menuCenter').slideToggle('fast', function(){
          if ($('.js_menuCenter:visible').length) {
            $('.copyright').css('height', 140);
          } else {
            $('.copyright').css('height', 50);
          }
        });
    });
    
    // iPhone float
    var ua = navigator.userAgent;
    // Opera不支持bottom 0
    var OSVersionArr = ua.match(/iPhone\sOS\s(\d)\_/);
    if (OSVersionArr && OSVersionArr[1] && OSVersionArr[1] <5 || ua.indexOf('Opera') != -1) {
        $(window).on('scroll', function(){
            $(".btn-login").css({top: window.innerHeight + window.scrollY - $(".btn-login").outerHeight() });
            $('.js_menuCenter').css({top: window.innerHeight + window.scrollY - $('.js_menuCenter').outerHeight() });
        });
    }
});