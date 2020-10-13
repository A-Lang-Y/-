<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="yes" name="apple-mobile-web-app-capable" />
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        <meta content="telephone=no" name="format-detection" />
        <title>Haier 海尔家电家居 - 美好住居生活解决方案提供商</title>
		<!-- 公用样式 begin -->
		<link rel="apple-touch-icon" href="../../../../uk/images/favicon.ico" />
<link rel="shortcut icon" href="../../../../uk/images/favicon.ico" />
<link rel="Bookmark" href="../../../../uk/images/favicon.ico" />
<script type="text/javascript">var ROOT_PATH = "../../../"</script>
        <link rel="stylesheet" href="../../../../../image.haier.com/cnmobile/images/base.css">
        <link rel="stylesheet" href="../../../../../image.haier.com/cnmobile/images/style.css">
        <link rel="stylesheet" href="../../../../../image.haier.com/cnmobile/images/header-footer.css">
        <!-- jQuery库 -->
        <script src="../../../../../image.haier.com/cnmobile/images/jquery-1.7.1.min.js"></script>
        <script src="../../../../../image.haier.com/cnmobile/images/hammer.js"></script>
        
        <!-- 公用函数库 -->
        <script src="../../../../../image.haier.com/cnmobile/images/common.js"></script>
        <!-- 公用静态分页 -->
        
        <!-- 头部js文件 -->
        <script src="../../../../../image.haier.com/cnmobile/images/header.js"></script>
         <!-- 公用js文件 -->
        <script src="../../../../../image.haier.com/cnmobile/images/mobile_core.js"></script>
        <!-- jQuery操作cookie，加入收藏、判断是否登录 -->
        <script type="text/javascript" src="../../../../../image.haier.com/cnmobile/images/jQueryDoCookie.js"></script>

	<!-- 日期控件 -->
		<link rel="stylesheet" href="../../../../../image.haier.com/cnmobile/images/mobiscroll.custom-2.4.4.min.css">
		<script src="../../../../../image.haier.com/cnmobile/images/dateinput.js"></script>
		<!-- 公用样式 end -->
    </head>
    <body>
	<!--header-->
	<div id="header">
            <div class="whole-bg">
                <!--非首页时添加类back，返回按钮-->
                <a href="javascript:history.go(-1)" class="location back js_goBack">
                  <img src="../../../../../image.haier.com/cnmobile/images/icon_home640.png" alt class="icon-home hidden" />
                  <img src="../../../../../image.haier.com/cnmobile/images/icon-back640.png" alt class="icon-back" />
                </a>
                <span class="logo js_dropHaierMenu"><img src="../../../../../image.haier.com/cnmobile/images/logo.png" alt /></span>
                <a href="../../../services_supports/service_shop/default.htm" class="nav-map"><span><img src="../../../../../image.haier.com/cnmobile/images/icon-map1640.png" alt /></span></a>
                <a href="javascript:void(0);" class="nav-search js_showSearchBtn"><span>
                    <img src="../../../../../image.haier.com/cnmobile/images/icon-search640.png" alt class="icon-nav-search" />
                    <img src="../../../../../image.haier.com/cnmobile/images/icon-search2640.png" alt class="icon-nav-searchon hidden" />
                </span></a>
            </div>
            <!--没有下拉按钮，添加类hidden-->
            <span class="btn-dropdown js_dropMenuBar"></span>
            <!-- 非首页的header,请再添加类  main-nav-box1 -->
            <div class="main-nav-box  main-nav-box1">
                <ul class="main-nav clearfix">
				 
                    <li><a href="../../../consumer/cooling/default.htm"><img src="../../../../../image.haier.com/cnmobile/navigation/201212/P020131114599407342820.png" /></a><span>产品中心</span></li>
				 
                    <li><a href="../../../services_supports/default.htm"><img src="../../../../../image.haier.com/cnmobile/navigation/201212/P020131114599517116037.png" /></a><span>服务中心</span></li>
				 
                    <li><a href="../../default.htm"><img src="../../../../../image.haier.com/cnmobile/navigation/201212/P020131114599605713020.png" /></a><span>优惠活动</span></li>
				 
                    <li><a href="../../../application/default.htm"><img src="../../../../../image.haier.com/cnmobile/navigation/201212/P020131114599684253573.png" /></a><span>应用广场</span></li>
				
				 
                    <li class="nomargin"><a href="../../../bbs/default.htm"><img src="" /></a><span>海尔社区</span></li>
				
				</ul>
            </div>
        </div>
        <!--start;搜索框-->
        <div class="search-bg  hidden js_searchForm">
          <!-- 套模板请定义表单提交地址 -->
          <form class="search clearfix" method="get" action="../../../services_supports/search_results/default.htm" id="headerSearchForm">
            <!-- 首页下拉搜索类型，值暂定为1-产品，2-服务，默认是产品。套页面是可根据需要修改 -->
            <input type="hidden" name="search_type" value="1" id="js_topSearchVal" />
            <div class="search-select left"><span class="js_topSearchTypeSpan">产品</span><i class="search-img js_topSearchTypeBtn"></i>
                <ul class="search-list js_topSearchTypeList" style="display:none;">
                     <li data-value="1" ><a href="javascript:void(0);" >产品</a></li>
                     <li data-value="2" ><a href="javascript:void(0);" >常见问题</a></li>
                </ul>
            </div>
            <!-- value可配置默认的搜索提示文字 -->
            <span class="search-text left"><input type="text" class="js_searchInput" value="输入您要查找的产品" name="keyword" /></span>
            <button type="button" class="search-smt left js_searchSubmit" value=""><img src="../../../../../image.haier.com/cnmobile/images/icon-search3.png" /></button>
          </form>
          <div class="search-box"></div>
        </div>
        <script>
            $(function(){
              // 默认的搜索框的文字，可在search-text中自定义
              var defaultSearchText = $('.js_searchInput').val();
              // 表单提交
              $('.js_searchSubmit').click(function(e){
                  e.preventDefault();
                  //验证：
                  var keyword = $.trim($('.js_searchInput').val());
                  var type = $('#js_topSearchVal').val();
                  if (!keyword || keyword == defaultSearchText ) {
                      var notice = new customDialog({ 'content':'请输入搜索关键字', 'type':'error' });
                      notice.init().show();
                      return false;
                  }
                  if (!type) {
                      var notice = new customDialog({ 'content':'请选择搜索类型', 'type':'error' });
                      notice.init().show();
                      return false;
                  }
      
                  var url = $('#headerSearchForm').attr('action');
                  window.location.href = url + '@search_type=' +type+ '&' + 'keyword=' + keyword;
              });
            });
        </script>
        <!--end:搜索框-->
	<!-- end header -->
<!--中间内容-->
<div id="container">
	<div class="error">
    	<span class="error-tit color">404找不到网页</span>
        <span>您所预览的网页不存在</span>
        <span class="back color js_goToBack">←返回上一页</span>
    </div>
</div>
<script type="text/javascript">
	$('.js_goToBack').click(function(){
 		 window.history.back();
	});
</script>
<!--end 中间内容-->
<!--登录按钮-->
    <!--未登录状态可用下面注释的dom替换span-->
    <a href="../../../../ids/mobile/login.jsp" class="btn-login no-login js_noLogin"><img src="../../../../../image.haier.com/cnmobile/images/icon_btnlogin.png" width="54" height="54" /></a>
    <span  style="display:none;" class="btn-login logedin js_logedin"><img src="../../../../../image.haier.com/cnmobile/images/icon_btnuser.png" width="54" height="54" /></span>
    <!--end 登录按钮-->
    <!--环形导航菜单-->
    <div class="ring-nav js_menuCenter hidden">
	
        <a href="../../../services_supports/myhaier/my_product.shtml" class="my-pro">我的产品</a>
	
	
        <a href="../../../services_supports/service_seq" class="serve-state">服务状态</a>
	
	
        <a href="../../../services_supports/myhaier/my_favorite.shtml" class="my-collection">我的收藏</a>
	
	
        <a href="../../../services_supports/myhaier/default.htm" class="pre-center">个人中心</a>
	
    </div>
    <!--footer-->
    <div id="footer">
        <div class="nav-bottom-box clearfix">
            <ul class="nav-bottom clearfix left">
			
                <li><a href="../../../footer/about_haier/default.htm">关于海尔</a></li>
			
                <li><a href="../../../footer/contact/default.htm">联系我们</a></li>
			
                <li><a href="../../../footer/terms_conditions/default.htm">法律声明</a></li>
			
                <li><a href="../../../footer/common_questions/default.htm">常见问题</a></li>
			
            </ul>
            <a href="javascript:void(0);" class="back-top left js_backTop">Top</a>
        </div>
<div class="version"><a href="../../../../default.htm">手机版</a>&nbsp;|&nbsp;<a href="../../../../../www.haier.com/cn/@hides=1" class="curr">网页版</a></div>
        <p class="copyright">Copyright©2014海尔集团版权所有</p>
    </div>
    <!-- 底部js部分 -->
    <script>
    
      $(function(){
		//是否登录
        if(istrsidssdssotoken()){
			userLogin(true);
		}else{
			userLogin(false);
			$('.js_noLogin').attr("href","../../../../ids/mobile/login.jsp@returnUrl="+window.location.href);
		}
      });
    </script>
    <!--end footer-->

<!-- code begin. -->
<script>
$(".largepic-words-part .price").hide();
$(".pro-cont-list").hide();
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5554256-17']);
  _gaq.push(['_setDomainName', 'haier.com']);
  _gaq.push(['_setAllowHash', 'false']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? ' https://ssl' : ' http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>


<!--code end. -->





<!-- code begin. -->
<script type='text/javascript'>
    (function () {
		var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = (location.protocol == 'https:' ? '../../../../../https@ssl./' : '../../../../../static./') + 'gridsumdissector.com/js/Clients/GWD-000678-332B0F/gs.js';
		var firstScript = document.getElementsByTagName('script')[0];
        firstScript.parentNode.insertBefore(s, firstScript);
    })();
</script>
<!--code end. -->
<script src="../../../../../image.haier.com/cnmobile/images/mobile_statistics.js"></script>
</body>
</html>