    //从cookie里面取出值，修改比较按钮的状态
    function assignCompareCookie(){
        var productCompareCategory = getCookie("productCompareCategory");
        var productCategoryId = $(".product-nav-list").find(".chooseProductType a.curr").parent().attr("data-productType");
        if (productCategoryId == productCompareCategory) {
            var productCompareList = getCookie("productCompareList");
            var productList = productCompareList.split("-");
            for(var i=0;i < productList.length; i++){
                var tempObj = $("input[name=productId][value="+productList[i]+"]").siblings("a");
                if (tempObj.closest("ul").hasClass("product-list")){
                    tempObj.removeClass("btn-compare collect-reset-large btn-large-com");
                    tempObj.addClass("collect-reset");
                    
                } else {
                    tempObj.removeClass("btn-compare-large");
                    tempObj.addClass("collect-reset-large btn-large-com");
                }
                tempObj.removeClass("joinCompare");
                tempObj.addClass("overCompare");
                tempObj.html("取消比较");
            }
        }
    }
    
    //筛选部分的js效果
    function selectedSlideDom(liDom) {
        liDom.each(function(i){
            var container = $(this).find("ul");
            var overView  = $(this).children("a.arrow03");
            var hammerDom = $(this);
            var selectConfig = {
                        "hammerOption":{ drag_vertical:false }, //hammer.js的配置参数
                        "container": container,//所有的li对象
                        "overView":overView, //左右点击的按钮
                        "div":hammerDom, //整个滑动的div
                        "divAbsoluteDom":$(this).children("div"),
                        "liOtherWidth":6,
                        "overviewClick":function(overviewHandle, clickDom){
                            if ($(clickDom).hasClass("selectLeft")){
                                overviewHandle.prev();
                                if (overviewHandle.current == 0){
                                    $(clickDom).removeClass("btn-pre02");
                                    $(clickDom).addClass("btn-pre");
                                }
                                if (overviewHandle.current != (overviewHandle.totalSlides-overviewHandle.defineLiNum)) {
                                    $(clickDom).siblings(".selectRight").removeClass("btn-next02");
                                    $(clickDom).siblings(".selectRight").addClass("btn-next");
                                }
                            } else if ($(clickDom).hasClass("selectRight")){
                                overviewHandle.next();
                                if (overviewHandle.current != 0) {
                                    $(clickDom).siblings(".selectLeft").removeClass("btn-pre");
                                    $(clickDom).siblings(".selectLeft").addClass("btn-pre02");
                                }
                                if (overviewHandle.current == (overviewHandle.totalSlides-overviewHandle.defineLiNum)) {
                                    $(clickDom).removeClass("btn-next");
                                    $(clickDom).addClass("btn-next02");
                                }
                            }
                        },
                        "updateOveriew":function(overviewHandle){
                            if (overviewHandle.current == 0){
                                overviewHandle.overview.siblings(".selectLeft").removeClass("btn-pre02");
                                overviewHandle.overview.siblings(".selectLeft").addClass("btn-pre");
                            } else {
                                overviewHandle.overview.siblings(".selectLeft").removeClass("btn-pre");
                                overviewHandle.overview.siblings(".selectLeft").addClass("btn-pre02");
                            }
                            if (overviewHandle.current == (overviewHandle.totalSlides-overviewHandle.defineLiNum)) {
                                overviewHandle.overview.siblings(".selectRight").removeClass("btn-next");
                                overviewHandle.overview.siblings(".selectRight").addClass("btn-next02");
                            } else {
                                overviewHandle.overview.siblings(".selectRight").removeClass("btn-next02");
                                overviewHandle.overview.siblings(".selectRight").addClass("btn-next");
                            }
                        }
                    };
            new Zslides(selectConfig); 
        });
    }
  
    
    
    function indexSlideBind(){
        var configIndex = {
                        "hammerOption":{ drag_vertical:false }, //hammer.js的配置参数
                        "container":"#slider ul" ,//所有的li对象
                        "overView":"#slider .arrow", //左右点击的按钮
                        "div":"#slider", //整个滑动的div
                        "divAbsoluteDom":$("#container").find(".scroll-clip"),//显示的li的数目
                        "liOtherWidth":0,
                        "overviewClick":function(overviewHandle, clickDom){
                            if ($(clickDom).hasClass("headLeft")){
                                overviewHandle.prev();
                                if (overviewHandle.current == 0){
                                    $(clickDom).removeClass("previous01");
                                    $(clickDom).addClass("previous");
                                }
                                if (overviewHandle.current != (overviewHandle.totalSlides-overviewHandle.defineLiNum)) {
                                    $(clickDom).siblings(".headRight").removeClass("next01");
                                    $(clickDom).siblings(".headRight").addClass("next");
                                }
                            } else if ($(clickDom).hasClass("headRight")){
                                overviewHandle.next();
                                if (overviewHandle.current != 0) {
                                    $(clickDom).siblings(".headLeft").removeClass("previous");
                                    $(clickDom).siblings(".headLeft").addClass("previous01");
                                } 
                                if (overviewHandle.current == (overviewHandle.totalSlides-overviewHandle.defineLiNum)) {
                                    $(clickDom).removeClass("next");
                                    $(clickDom).addClass("next01");
                                }
                            }
                        },
                        "updateOveriew":function(overviewHandle){
                            if (overviewHandle.current == 0){
                                overviewHandle.overview.siblings(".headLeft").removeClass("previous01");
                                overviewHandle.overview.siblings(".headLeft").addClass("previous");
                            } else {
                                overviewHandle.overview.siblings(".headLeft").removeClass("previous");
                                overviewHandle.overview.siblings(".headLeft").addClass("previous01");
                            }
                            if (overviewHandle.current == (overviewHandle.totalSlides-overviewHandle.defineLiNum)) {
                                overviewHandle.overview.siblings(".headRight").removeClass("next");
                                overviewHandle.overview.siblings(".headRight").addClass("next01");
                            } else {
                                overviewHandle.overview.siblings(".headRight").removeClass("next01");
                                overviewHandle.overview.siblings(".headRight").addClass("next");
                            }
                        }
                    };
        return  new Zslides(configIndex);
    }
    
    
    function picSlideBind(){
        var configPic = {
                        "hammerOption":{ drag_vertical:false }, //hammer.js的配置参数
                        "container":"#slideshow ul" ,//所有的li对象
                        "overView":"#overview li", //左右点击的按钮
                        "div":"#slideshow", //整个滑动的div
                        "defineLiNum":1,//显示的li的数目
                        "liOtherWidth":2, //li除了width以外的宽度
                        "setInterval":5, //设定轮播
                        "overviewClick":function(overviewHandle, clickDom){
                            overviewHandle.overview.removeClass("active");
                            $(clickDom).addClass("active");
                            var toCurrent = $(clickDom).prevAll().length;
                            overviewHandle.slideTo(toCurrent-overviewHandle.current);
                        },
                        "updateOveriew":function(overviewHandle){
                            overviewHandle.overview.removeClass("active");
                            $(overviewHandle.overview.get( overviewHandle.current )).addClass('active');
                        }
                    };
        return  new Zslides(configPic);
    }
    
    
    function productSlideBind(){
        var configProductType = {
                "hammerOption":{ drag_vertical:false }, //hammer.js的配置参数
                "container":"#productTypeSlides ul" ,//所有的li对象
                "overView":"#productTypeSlides .arrow02", //左右点击的按钮
                "div":"#productTypeSlides", //整个滑动的div
                "divAbsoluteDom":$("#productTypeSlides").find(".product-nav-box"),//显示的li的数目
                "liOtherWidth":14,
                "overviewClick":function(overviewHandle, clickDom){
                    if ($(clickDom).hasClass("productLeft")){
                        overviewHandle.prev();
                        if (overviewHandle.current == 0){
                            $(clickDom).removeClass("previous02");
                            $(clickDom).addClass("previous021");
                        }
                        if (overviewHandle.current != (overviewHandle.totalSlides-overviewHandle.defineLiNum)) {
                            $(clickDom).siblings(".productRight").removeClass("next021");
                            $(clickDom).siblings(".productRight").addClass("next02");
                        }
                    } else if ($(clickDom).hasClass("productRight")){
                        overviewHandle.next();
                        if (overviewHandle.current != 0) {
                            $(clickDom).siblings(".productLeft").removeClass("previous021");
                            $(clickDom).siblings(".productLeft").addClass("previous02");
                        } 
                        if (overviewHandle.current == (overviewHandle.totalSlides-overviewHandle.defineLiNum)) {
                            $(clickDom).removeClass("next02");
                            $(clickDom).addClass("next021");
                        }
                    }
                },
                "updateOveriew":function(overviewHandle){
                    if (overviewHandle.current == 0){
                        overviewHandle.overview.siblings(".productLeft").removeClass("previous02");
                        overviewHandle.overview.siblings(".productLeft").addClass("previous021");
                    } else {
                        overviewHandle.overview.siblings(".productLeft").removeClass("previous021");
                        overviewHandle.overview.siblings(".productLeft").addClass("previous02");
                    }
                    if (overviewHandle.current == (overviewHandle.totalSlides-overviewHandle.defineLiNum)) {
                        overviewHandle.overview.siblings(".productRight").removeClass("next02");
                        overviewHandle.overview.siblings(".productRight").addClass("next021");
                    } else {
                        overviewHandle.overview.siblings(".productRight").removeClass("next021");
                        overviewHandle.overview.siblings(".productRight").addClass("next02");
                    }
                }
            };

        return  new Zslides(configProductType);
    }

    var productSlider;
    var indexslider;
    
    //绑定页面的slide所涉及的效果
    function setEvent(selectModel){
        if (selectModel){
            picSlideBind();
            indexslider = indexSlideBind();
        }
        productSlider = productSlideBind();
        assignCompareCookie();
        //selectedSlideDom($("#selectListBox").children("li"));
        //加载完毕后隐藏筛选框
        $("#selectListBox").closest(".select-list-box").hide();
    }
    
    //根据type和id来控制滚动到那个对象
    function moveSliderById(type, id){
        if (type == 1){
            var dom = $("li[data-setproductcategory='"+id+"']");
            if (typeof dom == "object") {
                indexslider.slideEx.moveToDom(dom);
                dom.children("a").trigger("click");
            }
        } else {
            var dom = $("li[data-producttype='"+id+"']");
            if (typeof dom == "object") {
                productSlider.slideEx.moveToDom(dom);
                dom.children("a").trigger("click");
                dom.children("a").addClass('curr');
            }
        }
    }