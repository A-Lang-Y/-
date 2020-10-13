/**
 * 网站通用js
 * @author liw
 */

// 通用的验证方法 如手机号。等
;(function(global){
    if (typeof global.AnUtil == 'object') {
        return;
    }
    var util = global.AnUtil = {};
    
    /**
     * 验证邮箱
     * @param {String} email
     * @return {Boolean} 
     */
    util.checkEmail = function(email){
        email = this.trim(email);
        if (!email || typeof email != 'string') {
            return false;
        }
        if (/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/.test(email)) {
            return true;
          }
        return false;
    };
    
    /**
     * 验证手机号
     * @param {String|Number} mobile
     * @return {Boolean} 
     */
    util.checkMobile = function(mobile) {
        mobile = this.trim(mobile);
        if (!mobile) {
            return false;
        }
        mobile = mobile.toString();
        return mobile.slice(0, 1) == 1 && mobile.length == 11;
    };
    
    /**
     * 验证身份证号是否合法
     * @param {String} v_card
     * @return {Boolean}
     */
    util.checkIdentityCard = function (v_card) {
        var reg = /^\d{15}(\d{2}[0-9X])?$/i;
        if (!reg.test(v_card)) {
            return false;
        }
        if (v_card.length==15) {
            var n = new Date();
            var y = n.getFullYear();
            if(parseInt("19" + v_card.substr(6,2)) < 1900 || parseInt("19" + v_card.substr(6,2)) > y){
                return false;
            }
            var birth = "19" + v_card.substr(6,2) + "-" + v_card.substr(8,2) + "-" + v_card.substr(10,2);
            if(!isDate(birth)){
                return false;
            }
        }
        if (v_card.length==18) {
            var n = new Date();
            var y = n.getFullYear();
            if(parseInt(v_card.substr(6,4)) < 1900 || parseInt(v_card.substr(6,4)) > y){
                return false;
            }
            var birth = v_card.substr(6,4) + "-" + v_card.substr(10,2) + "-" + v_card.substr(12,2);
            if(!isDate(birth)){
                return false;
            }
            iW = new Array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2,1);
            iSum = 0;
            for ( i=0;i<17;i++){
                iC = v_card.charAt(i);
                iVal = parseInt(iC);
                iSum += iVal * iW[i];
            }
            iJYM = iSum % 11;
            if(iJYM == 0) sJYM = "1";
            else if(iJYM == 1) sJYM = "0";
            else if(iJYM == 2) sJYM = "x";
            else if(iJYM == 3) sJYM = "9";
            else if(iJYM == 4) sJYM = "8";
            else if(iJYM == 5) sJYM = "7";
            else if(iJYM == 6) sJYM = "6";
            else if(iJYM == 7) sJYM = "5";
            else if(iJYM == 8) sJYM = "4";
            else if(iJYM == 9) sJYM = "3";
            else if(iJYM == 10) sJYM = "2";
            var cCheck = v_card.charAt(17).toLowerCase();
            if( cCheck != sJYM ){
                return false;
            }
        }
        try {
              var lvAreaId=v_card.substr(0,2);
              if( lvAreaId=="11" || lvAreaId=="12" || lvAreaId=="13" || lvAreaId=="14" || lvAreaId=="15" ||
                lvAreaId=="21" || lvAreaId=="22" || lvAreaId=="23" ||
                lvAreaId=="31" || lvAreaId=="32" || lvAreaId=="33" || lvAreaId=="34" || lvAreaId=="35" || lvAreaId=="36" || lvAreaId=="37" ||
                lvAreaId=="41" || lvAreaId=="42" || lvAreaId=="43" || lvAreaId=="44" || lvAreaId=="45" || lvAreaId=="46" ||
                lvAreaId=="50" || lvAreaId=="51" || lvAreaId=="52" || lvAreaId=="53" || lvAreaId=="54" ||
                lvAreaId=="61" || lvAreaId=="62" || lvAreaId=="63" || lvAreaId=="64" || lvAreaId=="65" ||
                lvAreaId=="71" || lvAreaId=="82" || lvAreaId=="82" ) {
                return true;
              } else {
                return false;
              }
        } catch(ex) { }
        return true;
    };
    
    /**
     * 字符长度
     * @param {String}
     * @return {Number}
     */
    util.byteLength = function(b) {
        if (typeof b == "undefined") {
            return 0;
        }
        var a = b.match(/[^\x00-\x80]/g);
        return (b.length + (!a ? 0 : a.length));
    };
    
    /**
     * 截取指定长度字符串
     * @return string  截取后的字符串
     * @example cutStr('我是123', 3) => "我是12"
     */
    util.cutStr = function(str, length) {
        length = length * 2;
        
        var b = str.replace(/\*/g, " ").replace(/[^\x00-\xff]/g, "**");
        str = str.slice(0, b.slice(0, length).replace(/\*\*/g, " ").replace(/\*/g, "").length);
        if (this.byteLength(str) > length) {
            str = str.slice(0, str.length - 1);
        }
        return str;
    };
    
    /**
     * 获取文字长度
     * @parma {String} str
     * @return {Number}
     */
    util.getStrLength = function(str){
        var regx = "[\u4e00-\u9fa5]";
        str = str.replace(new RegExp(regx, 'gm'), '11');
        return  Math.ceil(str.length / 2);
    };
    
    /**
     * trim 一个字符串
     * @parma {String} str
     * @param {String} char 可选， 默认为空格
     * @return {String}
     */
    util.trim = function(str, char) {
        if (!char) {
            char = '\\s';
        }
        var reg = new RegExp('(^'+char+'*)|('+char+'*$)', 'g');
        return str.replace(reg, '');
    };
    
})(window);

/**
 * hammer.js的实例
 * @param config {}
 * config:hammerOption  hammer.js的配置参数
 * config:container     所有的li对象
 * config:overView      左右点击的按钮
 * config:div           整个滑动的div
 * config:defineLiNum   显示的li的数目
 * config:width         li的宽度
 * config:overviewClick //点击overview的回调函数
 * config:updateOveriew //更新overvview的回调函数
 */
function slideShow(config){
    config = config || {};
    var self = this;
    this.container = $(config.container);
    this.overview = $(config.overView);
    this.slides = $(">li", this.container);
    
    if (config.liOtherWidth) {
        this.liOtherWidth = config.liOtherWidth;
    } else {
        this.liOtherWidth = 0;
    }
    this.divAbsoluteDom = config.divAbsoluteDom;
    if (config.defineLiNum){
        this.defineLiNum = config.defineLiNum;
    } else {
        var divAbsoluteWidth = this.divAbsoluteDom.width();
        var defLiNum = 0;
        var thisWidth = 0;
        this.slides.each(function(i){
            thisWidth = this.scrollWidth+self.liOtherWidth;
            if (divAbsoluteWidth - thisWidth > 0){
                defLiNum++;
                divAbsoluteWidth -= thisWidth;
            }
        });
        this.defineLiNum = defLiNum;
    }
    
    this.totalSlides = this.slides.length;
    this.current = 0;
    this.intervalHandle;
    this.nowLeftWidth = 0;
    
    this.nextLiWidth = 0;
    this.totalWidth = 0;//计算整个ul的长度
    this.liWidth = config.liWidth;
    this.interval = config.setInterval;//设置了轮播
    
    if (!this.liWidth) {
        this.slides.each(function(i){
            self.totalWidth += (this.scrollWidth+self.liOtherWidth);
        });
    } else {
        this.totalWidth = this.liWidth*this.totalSlides;
    }
    

    this.container.css("position", "relative");
    this.container.width(this.totalWidth+"px");

    this.overview.click(function(ev) {
        config.overviewClick(self, this);
        //ev.preventDefault();
    });

    this.updateOverview = function() {
        config.updateOveriew(self);
    };

    this.updateOverview();
    
    this.slideSetInterval = function(){
        if (self.current < (self.totalSlides-self.defineLiNum)){
            self.next();
        } else {
            self.current = 0;
            self.container.css({ left: 0 });
            self.updateOverview();
            self.nowLeftWidth = 0;
        }
    };
    
    //index为-1或者+1
    this.getNextLiWidth = function(index){
        if (!this.liWidth) {
            if (index > 0){
                this.nextLiWidth = parseInt(this.slides.get(this.current+this.defineLiNum).scrollWidth+this.liOtherWidth);
            } else {
                this.nextLiWidth = parseInt(this.slides.get(this.current+this.defineLiNum-1).scrollWidth+this.liOtherWidth);
            }
        } else {
            this.nextLiWidth = this.liWidth;
        }
        return this.nextLiWidth;
    }
    
    this.slideTo = function( index ) {
        for(var step = 0; step < Math.abs(index); step ++ ){
            if( index == 0 || (index > 0 && this.current >= (this.totalSlides-this.defineLiNum)) || (index < 0 && this.current <= 0)) {
                return false;
            }
            if (index > 0) {
                this.nextLiWidth = this.getNextLiWidth(1);
                if (this.current == this.totalSlides-this.defineLiNum-1 && this.divAbsoluteDom){
                    this.nextLiWidth = parseInt(this.slides.last().width()) - ( parseInt(this.divAbsoluteDom.width())+parseInt(this.divAbsoluteDom.offset().left)-parseInt(this.slides.last().offset().left) );
                }
                this.nowLeftWidth = parseInt(this.nowLeftWidth - this.nextLiWidth);
                this.container.css({ left: this.nowLeftWidth+"px" });
                this.current ++;
            } else {
                this.nextLiWidth = this.getNextLiWidth(-1);
                if (this.current == 1 && this.divAbsoluteDom){
                    this.nextLiWidth = parseInt(this.divAbsoluteDom.offset().left) - parseInt(this.slides.first().offset().left);
                }
                this.nowLeftWidth = parseInt(this.nowLeftWidth + this.nextLiWidth);
                this.container.css({ left: this.nowLeftWidth+"px" });
                this.current --;
            }
            this.updateOverview();
        }
        return true;
    };
    
    this.moveToDom = function(Dom){
        var nowDomPosition = Dom.prevAll("li").length;
        this.slideTo(nowDomPosition-this.current);
    }

    this.move = function(distance, direction){
        
        //获取当前下一个的宽度,并且与distance做比较,如果大于零，则循环
        if(direction == 'right' && distance > 0) {
            do{
                if (this.current <= 0) {
                    return false;
                }
                this.nextLiWidth = this.getNextLiWidth(-1);
                this.prev();
                distance -= this.nextLiWidth;
            } while((distance - this.nextLiWidth) > 0)
        } else if(direction == 'left' && distance > 0) {
            do{
                if (this.current >= (this.totalSlides-this.defineLiNum)){
                    return false;
                }
                this.nextLiWidth = this.getNextLiWidth(1);
                this.next();
                distance -= this.nextLiWidth;
            } while((distance - this.nextLiWidth) > 0)

        }
        if (this.interval){
            if (this.intervalHandle){
                clearInterval(this.intervalHandle);
            }
            this.intervalHandle = setInterval(function(){self.slideSetInterval()}, this.interval*1000);
        }
    }

    
    this.draging = function(distance, direction){
        //控制，只有左右有效果
        if(direction == 'left') {
            if( this.current >= (this.totalSlides-this.defineLiNum) ){
                return ;
            }
            distance = 0 - distance;
        } else if (direction == 'right' && this.current <= 0){
            return;
        }
        if (this.intervalHandle){
            clearInterval(this.intervalHandle);
            this.intervalHandle = 0;
        }
        this.setMarginLeft(distance);
        
    }
    
    //修改marginleft
    this.setMarginLeft = function(distance){
        this.getContainer().css({ marginLeft: distance });
    }

    this.next = function() {
        if (this.current < (this.totalSlides-this.defineLiNum)){
            return this.slideTo(1);
        }
    };

    this.prev = function() {
        if(this.current > 0){
            return this.slideTo(-1);
        }
    };

    this.getContainer = function() {
        return this.container;
    };

    this.getCurrent = function() {
        return $(this.slides.get(this.current));
    };
    
    if (this.interval){
        this.intervalHandle = setInterval(function(){self.slideSetInterval()}, this.interval*1000);
    }
}
var Zslides = function (config) {
    
    config = config || {};
    var self = this;
    
    $(config.container).find("img").bind("dragstart", function() { 
        return false; 
    });

    this.slideEx = new slideShow(config);
    this.hammer = new Hammer($(config.div).get(0), config.hammerOption);

    this.hammer.ondrag = function(ev) {
        self.slideEx.draging(ev.distance, ev.direction);
    };
    
    this.hammer.onswipe = function(ev) {
        //销毁marginleft
        self.slideEx.setMarginLeft(0);
        var moveDistance = Math.abs(ev.distance);
        if( moveDistance > 30) {
            self.slideEx.move(moveDistance, ev.direction);
        }
    };

    this.hammer.ondragend = function(ev) {
        //销毁marginleft
        self.slideEx.setMarginLeft(0);
        var moveDistance = Math.abs(ev.distance);
        if( moveDistance > 30) {
            self.slideEx.move(moveDistance, ev.direction);
        }
    };
};


//分页对象
function hairPage(config){
    config = config || {};
    var self = this;
    if (!config.dom){
        return false;
    }
    
    this.ajaxHref = config.ajaxHref;  //分页提交的ajax连接
    this.ajaxCondition = config.ajaxCondition || {}; //ajax提交的参数条件
    this.dom = config.dom;  //指定分页部分的总个Dom
    this.currentPage = config.currentPage || 1;//当前的页数
    
    this.currentDom = config.currentDom || this.dom.find(".js_pagerCurrent");//当前显示的分页的Dom
    this.currentPageShowDom = config.currentPageShowDom || this.currentDom.children("span :first");
    this.currentTotalShowDom = config.currentTotalShowDom || this.currentDom.children("span.page-num");
    this.nextDom = this.dom.find(".page-next");//下页的Dom
    this.prevDom = this.dom.find(".page-prev");//上页的Dom
    this.otherPageDom = this.dom.find("ul");
    this.otherPageDoms = this.dom.find("ul li");
    this.totalPage = config.totalPage || this.otherPageDoms.length;//总页数

    //为其他页面点击绑定点击效果
    this.bindOtherPageDom = function(){
        $.each(self.otherPageDoms, function(){
            var thisObj = $(this);
            $(this).click(function(){
                var pageNum = thisObj.find("span:first").html();
                if (pageNum == self.currentPage){
                    return ;
                }
                var tmpObj = $(this);
                if (typeof config.otherPageClick == "function"){
                    self.pageAjax(pageNum, config.otherPageClick, tmpObj);
                } else {
                    self.pageAjax(pageNum);
                }
            });
        });
    }
    this.bindOtherPageDom();
    
    //点击当前显示分页的效果
    this.currentDom.click(function(e){
        if (typeof config.currentClick == "function"){
            config.currentClick(self, this);
        }
        self.otherPageDom.toggle();
    });
    
    //点击下一页的效果
    this.nextDom.click(function(e){
        var tmpDom = this;
        if (self.currentPage == self.totalPage){
            return ;
        }
        if (typeof config.nextClick == "function"){
            self.pageAjax(parseInt(self.currentPage)+1, config.nextClick, tmpDom);
        } else {
            self.pageAjax(parseInt(self.currentPage)+1);
        }
    });
    
    //点击上一页的效果
    this.prevDom.click(function(e){
        if (self.currentPage == 1 ){
            return ;
        }
        var tmpObj = $(this);
        if (typeof config.prevClick == "function"){
            self.pageAjax(self.currentPage-1, config.prevClick, tmpObj);
        } else {
            self.pageAjax(self.currentPage-1);
        }
    });
    
    //分页的ajax操作
    this.pageAjax = function(pageNum, callBackFn, Dom){
        if (!this.ajaxHref){
            return ;
        }
        this.ajaxCondition.pageNum = pageNum;
        $.post( 
            self.ajaxHref, 
            self.ajaxCondition , 
            function(json){
                if (json.info == "ok"){
                    if (!json.data || json.data.length == 0) {
                        json.data = { totalPage:20, data:{  } };//传回来的json.data
                    }
                    self.currentPage = pageNum;
                    if (self.totalPage != json.data.totalPage){
                        self.totalPage = json.data.totalPage;
                    }
                    self.pageChange();
                    if (typeof callBackFn == "function"){
                        callBackFn(json.data.data, self, Dom);
                    }
                    self.goNum(pageNum);
                } else {
                    alert(json.info);
                }
            }, 
            "json" 
        );
    };
    
    //总页数改变时调用的方法
    this.pageChange = function(){
        var pageHtml = '';
        var pageStart = this.currentPage;
        var pageEnd = parseInt(this.currentPage) + 9;
        if (parseInt(this.currentPage) + 9 > this.totalPage){
            pageEnd = this.totalPage;
            pageStart = this.totalPage - 9;
        }
        for(var i = pageStart; i <= pageEnd; i++){
            pageHtml += '<li><a href="javascript:void(0)"><span class="color">'+i+'</span>&nbsp;/&nbsp;<span class="page-num">'+this.totalPage+'</span></a></li>';
        }
        this.otherPageDom.html(pageHtml);
        this.otherPageDoms = this.dom.find("ul li");
        this.currentTotalShowDom.html(this.totalPage);
        self.bindOtherPageDom();
    };
    
    this.next = function(){
        if (this.currentPage == this.totalPage){
            return ;
        }
        this.currentPage++;
        this.currentPageShowDom.html(this.currentPage);
    };
    this.prev = function(){
        if (this.currentPage == 1 ){
            return ;
        }
        this.currentPage--;
        this.currentPageShowDom.html(this.currentPage);
    };
    
    this.goNum = function(pageNum){
        if (this.currentPage < 1 || this.currentPage > this.totalPage){
            return ;
        }
        this.currentPage = pageNum;
        this.currentPageShowDom.html(this.currentPage);
    };
    
    $('body').live("click",function(e){
        var s=e.target || e.srcElement;
        if (!$(s).closest('.page').length) {
            self.otherPageDom.hide();
            self.dom.find('.js_pagerCurrent i').css({ backgroundImage:'url(icon_uw.png)' });
        }
    });
}

//自定义的弹框
/*
 * config:
 * type:弹出层类型，成功或者失败。 ok | error
 * content:弹出层的内容
 * colse: function of callback about close
 * comfirm: function of callback about comfirm
 * method:
 * remove  移除
 * hide  隐藏
 * show 显示
 */
function customDialog(config){
    config = config || {};
    this.content = config.content;
    this.type = config.type || "ok";
    this.DialogHtml = '';

    this.init = function(){
        var self = this;
        this.DialogHtml = '<div class="float-box" id="customDialog"><div class="float-div"></div><div class="collect-ok"><a href="javascript:;" class="close" id="dialogClose"></a><div class="clear"></div><div';
        if (config.type == "ok"){
            this.DialogHtml += ' class="collect-ok-word">';
        } else {
            this.DialogHtml += ' class="collect-ok-word icon-failed">';
        }
        if (this.content){
            this.DialogHtml += this.content;
        }
        this.DialogHtml += '</div><a href="javascript:void(0)" class="collect-btn btn-share" id="dialogComfirm">确认</a></div></div>';
        $("body").append(this.DialogHtml);
        this.dialogCloseObj = $("#dialogClose");
        this.dialogComfirmObj = $("#dialogComfirm");
        this.dialogCloseObj.click(function(e){
            if (typeof config.close == "function"){
                config.close(self, this);
            }
            self.remove();
        });
        this.dialogComfirmObj.click(function(e){
            if (typeof config.comfirm == "function"){
                config.comfirm(self, this);
            }
            self.remove();
        });
        return this;
    }
    this.remove = function(){
        $("#customDialog").remove();
    }
    this.hide = function(){
        $("#customDialog").hide();
    }
    this.show = function(){
        $("#customDialog").show();
    }
}

///设置cookie    
function setCookie(keyOfCookie, value, expireDays)
{
    var date=new Date();
    if (!expireDays) {
        expireDays = 10;
    }
    date.setTime(date.getTime()+expireDays*24*3600*1000);
    document.cookie = keyOfCookie + "=" + escape(value)+";expires="+date.toGMTString()+";path=/";
}

//获取cookie
function getCookie(name){
    var strCookie=document.cookie;
    var arrCookie=strCookie.split("; ");
    
    for(var i=0;i<arrCookie.length;i++){
        var arr=arrCookie[i].split("=");
        if(arr[0]==name) {
            return arr[1];
        }
    }
    return "";
}


/**
 * textarea焦点导致页面缩放
 */
(function(){
    function zoomDisable(){
      $('head meta[name=viewport]').remove();
      $('head').prepend('<meta name="viewport" content="user-scalable=0" />');
    }
    function zoomEnable(){
      $('head meta[name=viewport]').remove();
      $('head').prepend('<meta name="viewport" content="user-scalable=1" />');
    }
    $("input[type=text], textarea").mouseover(zoomDisable).mousedown(zoomEnable);
})();


/**
 * @param {Boolean} flag 是否已经登录 套模时调用此函数更改登录状态  flag = true 已经登录 否则未登录
 * @return {Bolean}
 */
function userLogin(flag) {
    $('.js_menuCenter').hide();
    // 仅在首页显示 2013-03-19 add
    if($('.main-nav-box1').length) {
        $('.js_logedin').hide();
        $('.js_noLogin').hide();
        $('.copyright').css('height', 'auto');
        return;
    }
    $('.copyright').css('height', 50);
    if (flag) {
        $('.js_logedin').show();
        $('.js_noLogin').hide();
    } else {
        $('.js_noLogin').show();
        $('.js_logedin').hide();
    }
    return true;
}
//整体厨房调整为大图片
function resizeProductImg()
{
  if(!parentChannelName){
	return;
  }
  var isInWholeKitchen = parentChannelName.indexOf('整体厨房') != -1 ? true : false;
  var isInCompare      = window.location.href.indexOf('product_compare') != -1 ? true : false;
  var isInLargeModel = $('.productLargeModel').hasClass('btn-menu-large');
  if (isInWholeKitchen) {
    if (isInLargeModel || isInCompare ) {	
      $('.product-list-large a img').css({
        "width":"134px",
        "height":"75.4px"
      });
      $('.product-list-large a').css({'height':'auto'});
    }
    else {
      $('.product-list li img').css({
        "width":"78px",
        "height":"44px"
      });
    }
  }
 
}
