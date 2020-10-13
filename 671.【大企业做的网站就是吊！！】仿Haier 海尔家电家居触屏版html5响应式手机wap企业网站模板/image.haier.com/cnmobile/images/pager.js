/**

 * 分页js

 */



/**

 * 手机版公用分页对象

 * @date 2012-12-18

 * @autor june

 */

var Pager = function(id){

  var $this = this;
  this.id = id;
  //总页数

  this.pageCount = 0;

  //每页显示记录数，默认是10

  this.pageSize = 10;

  //记录总数

  this.totalCount = 0;

  //当前页

  this.currPage = 0;

  /**

   * 需要重新改写该方法

   * @param {Object} index

   * @return {TypeName} 

   */

  this.onclick = function(currPage){

    return true;

  }

  

  /**

   * 内部方法  用于生成分页代码的click

   * @param {Object} currPage

   */

  this._click = function(currPage){

    var oldPage = currPage;

    if($this.onclick(currPage)!= false){

      $this.render();     

    }else{

      $this.currPage = oldPage;

    }

  }

  

  /**

   * 渲染分页部分的html

   */

  this.render = function(){
	var pageId = $this.id;
    if($this.totalCount==0 || $this.totalCount=="0"){

      //隐藏分页

      $('#'+pageId+'').find(".page").hide();

      return false;

    }else{

       $('#'+pageId+'').find(".page").show();

    }

    //构建分页
	 $('#'+pageId+'').html("");
    // 重组
	var pageInitHtml = "<div class=\"page\">";
		pageInitHtml += "<a href=\"javascript:;\" class=\"page-prev\">上一页</a>";
		pageInitHtml += "<span  class=\"page-current js_pagerCurrent\">";
		pageInitHtml += "	<span class=\"color\" id=\"currPage\"></span>&nbsp;/&nbsp;";
		pageInitHtml += "	<span class=\"page-num\"></span>";
		pageInitHtml += "	<i class=\"search-img page-icon\"></i>";
		pageInitHtml += "</span>";
		pageInitHtml += "<a href=\"javascript:;\" class=\"page-next\">下一页</a>";
		pageInitHtml += "</div>";
	$('#'+pageId+'').html(pageInitHtml);	
    
	var pageHtml = '<ul class="page-list" style="width: auto;height: 330px;">';
    for(var i=0;i<Number($this.pageCount);i++){

      pageHtml += "<li><a href='javascript:;' page='"+(i+1)+"'><span class='color'>"+(i+1)+"</span>&nbsp;/&nbsp;<span class='page-num'></span></a></li>";
    }

    pageHtml += '</ul>';

     $('#'+pageId+'').find('.page i.search-img').after(pageHtml);

     $('#'+pageId+'').find(".page .page-num").html($this.pageCount);

     $('#'+pageId+'').find(".js_pagerCurrent").find("span").eq(0).html($this.currPage);

    if($this.currPage==1 || $this.currPage=="1"){

       $('#'+pageId+'').find(".page .page-prev").hide();

    }else{

       $('#'+pageId+'').find(".page .page-prev").show();

      $('#'+pageId+'').find(".page .page-prev").attr("page",Number($this.currPage)-1);

    }

    if($this.currPage==$this.pageCount){

       $('#'+pageId+'').find(".page .page-next").hide();

    }else{

       $('#'+pageId+'').find(".page .page-next").show();

       $('#'+pageId+'').find(".page .page-next").attr("page",Number($this.currPage)+1);

    }

    //获取所有a

     $('#'+pageId+'').find(".page a").each(function(i){

      this.onclick = function(){

        var index = $(this).attr("page");

        if(index != undefined && index != ''){

          $this._click(index);

        }

      }

    });

     $('#'+pageId+'').find(".page-list").unbind();

    $.each( $('#'+pageId+'').find('.page-list'), function(k, v){

         var thisPage = $(this);

         // 分页高度

         var pagerH = thisPage.children('li').length * thisPage.children('li').height();

         // 如果未撑开

         if (pagerH <= 330) {

             thisPage.css('height', 'auto');

         } else {

             thisPage.jScrollPane({ 'isPager':true });

             // 阻止touchmove

             var hammer = new Hammer(thisPage[0], { 'preventTouchmove': true } );

             thisPage.css({'height':'100%'});

             hammer.ondrag = function(ev) {

                 thisPage.css({'height':'auto'});

                 // 拖动高度

                 var changeTop = ev.distance;

                 // 拖动方向

                 var direction = ev.direction;

                 // 当前分页css top属性

                 var currPagerTop = thisPage.position().top;

                 // 滚动条容器

                 var barCotainerObj = thisPage.siblings('.jScrollPaneTrack');

                 // 滚动条

                 var barObj         = barCotainerObj.find('.jScrollPaneDrag');

                 // 分页容器

                 var containerObj   = thisPage.closest('.jScrollPaneContainer');

                 // 滚动条容器高度

                 var barCotainerH = barCotainerObj.height();

                 // 分页容器高度

                 var containerH = containerObj.height();

                 // 滚动条/分页 比例

                 var percent = barCotainerH / pagerH;

                 

                  // 往上滑

                 if (direction == 'up') {

                     // 当前分页top属性

                     var currPagerTop = parseFloat(changeTop + Math.abs(currPagerTop));

                     if (Math.abs(currPagerTop) + containerH >= pagerH) {

                         // 临界值

                         thisPage.css( { 'bottom':0, 'top':'auto' } );

                         barObj.css( { 'bottom':0, 'top':'auto' } );

                     } else {

                         var currBarTop = parseFloat(currPagerTop * percent);

                         thisPage.css( { 'top': -currPagerTop, 'bottom':'auto' } );

                         barObj.css( { 'top': currBarTop, 'bottom':'auto' } );

                     }

                 } else if (direction == 'down') {

                     var currPagerTop = parseFloat(changeTop + currPagerTop);

                     if (currPagerTop > 0) {

                         currPagerTop = 0;

                     }

                     var currBarTop = parseFloat(Math.abs(currPagerTop) * percent);

                     thisPage.css( { 'top': currPagerTop, 'bottom':'auto' } );

                     barObj.css( { 'top': currBarTop, 'bottom':'auto' } );

                 } 

             }

         }

     });

	$('#'+pageId+'').find(".js_pagerCurrent .page-list li").unbind('click');

	$('#'+pageId+'').find('.js_pagerCurrent .page-list li').click(function(e){
		pagerClickOtherHide;	
		e.stopPropagation();
	});

     

     // 分页展示

      $('#'+pageId+'').find(".js_pagerCurrent").unbind('click');

      $('#'+pageId+'').find('.js_pagerCurrent').click(function(e){

         e.stopPropagation();

         var thisPage = $(this);

         if (thisPage.find('.page-list').css('visibility') == 'visible') {

             thisPage.find('.page-list').css('visibility', 'hidden');

             thisPage.find('i').removeClass('page-icon').addClass('page-icon-on');

             thisPage.find('.jScrollPaneContainer').css('visibility', 'hidden');

             $('body').trigger('click');

         } else {

             $('#container').find('.page-list').css('visibility', 'hidden');

             $('#container').find('i').removeClass('page-icon-on').addClass('page-icon');

             $('#container').find('.jScrollPaneContainer').css('visibility', 'hidden');

             thisPage.find('.jScrollPaneContainer').css('visibility', 'visible');

             thisPage.find('.page-list').css('visibility', 'visible');

             thisPage.find('i').removeClass('page-icon').addClass('page-icon-on');

         }

     });

     // body 曾经绑定过很多click事件，只解除当前

     $("body").unbind('click', pagerClickOtherHide);

     $('body').bind('click', pagerClickOtherHide);

  }

  

}

$('body').bind('click', pagerClickOtherHide);

 



/**

 * 点击其他地方隐藏分页，用于事件绑定和解除绑定

 * @param {Object} e 

 */

function pagerClickOtherHide(e){

    var s=e.target || e.srcElement;

    if (!$(s).closest('.page').length) {

        $('.js_pagerCurrent .page-list').css('visibility', 'hidden');

        $('.js_pagerCurrent i').removeClass('page-icon-on').addClass('page-icon');

        $('.page .jScrollPaneContainer').css('visibility', 'hidden');

    }

}