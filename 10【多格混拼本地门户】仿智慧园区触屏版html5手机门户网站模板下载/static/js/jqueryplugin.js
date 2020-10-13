/* ------------
Titlte:jQuery插件封装
Author：xiaozj
Created：2012-2-27
Updated：2012-2-27 xiaozj
------------ */
(function($) {
	// 广告轮显
	$.fn.slider = function(option) {
		var setting = {
			displayTitle : 1,
			displayNav : 1,
			displayNavNum : 1,
			intervalTime : 4000,
			effect : "fade", //fade || move
			direction : "v", //v || h 仅effect为move时有效
			speed : 500,
			lazyload: 0,
			navEvent : "click",
			isAllowClickNav : 1
		};
		return this.each(function() {
			if ($(this).find("img").size()<1) return; // 没有图片则退出
			if (option) var opts = $.extend({}, setting, option);
			
			var $this = $(this);
			var interval = 0;
			var current = 0;
			var $listGroup = $this.find(".focus-content");
			var $list = $listGroup.find("li");
			var n = $list.size();
			var w = $this.width();
			var h = $this.height();
			var x = (opts.direction == "h") ? n : 1;
			var y = (opts.direction == "h") ? 1 : n;
			var $nav = "";
			var $titleBg = (opts.displayTitle) ? $("<div class=\"slider-title-bg\"></div>").appendTo($this).fadeTo(1,0.4) : null;
			var $title = (opts.displayTitle) ? $("<div class=\"slider-title\"></div>").appendTo($this) : null;

			if ($this.find(".focus-nav").size()>0) {
				$nav = $this.find(".focus-nav");
			} else {
				for (var i = 1; i <=n ; i++) {
					$nav += "<li class=\"focus-nav-items\">" + (opts.displayNavNum ? i : "") + "</li>";
				}
				$nav = (opts.displayNav) ? $("<ol class=\"focus-nav\">" + $nav + "</ol>").appendTo($this) : null;
			}
			
			var init = function() {
				if ($nav) $nav.find("li:eq(0)").addClass("c");
				if ($title) $title.text($list.find("img").attr("alt")).width(w - ($nav ? $nav.width() : 0) - 10);
				if (opts.lazyload) {
					$this.find("img").each(function() {
						$(this).attr("src", $(this).attr("data-src"))
					}).end.css("background","none");
				}
				if(opts.effect == "fade") {
					$list.hide().eq(0).show();
				} else {
					$listGroup.css({"width" : w*x, "height" : h*y});
				}
			};
			
			var startInterval = function() {
				interval = setInterval(function() {
					if (current == n-1) current = -1;
					main(++current);
				}, opts.intervalTime);
			};

			var navClickHandle = function(e) {
				var index = $(this).index();
				if (index == current) return;
				clearInterval(interval);
				main(index);
				current = index;
				startInterval();
			};

			var main = function(c) {
				if (opts.effect == "fade") {
					$list.eq(c).siblings().stop(true, true).fadeOut().end().stop(true, true).fadeIn();
				} else {
					if (opts.direction == "h") {
						$listGroup.stop(true, true).animate({ "margin-left": "-" + w * c + "px" }, opts.speed);
					} else {
						$listGroup.stop(true, true).animate({ "margin-top": "-" + h * c + "px" }, opts.speed);
					}
				}
				if (opts.displayNav) {
					$nav.find("li").eq(c).addClass("c").stop(true, true).fadeTo(1, 1).siblings().removeClass("c").stop(true, true).fadeTo(1, 0.5);
				}
				if (opts.displayTitle) $title.html($list.eq(c).find("img").attr("alt"));
			};

			init();
			startInterval();
			if ($nav && opts.isAllowClickNav) $nav.delegate("li", opts.navEvent, navClickHandle);
		});
	};
	// tab切换
	/* HTML结构
	<div id="j_tab">
		<* data-toggle='tab-nav'></*>
		<* data-toggle='tab-nav'></*>
		<* data-toggle='tab-content'></*>
		<* class='hide' data-toggle='tab-content'></*>
	</div>
	*/
	$.fn.tab = function(option) {
		var setting = {};
		return this.each(function() {
			if (option) var opts = $.extend({}, setting, option);
			var $this    = $(this);
			var $navitem = $this.find("[data-toggle='tab-nav']");
			var $content = $this.find("[data-toggle='tab-content']");

			var clickHandle = function() {
				var index = $(this).index();
				$navitem.removeClass("c").eq(index).addClass("c");
				$content.addClass("hide").eq(index).removeClass("hide");
			};

			$navitem.bind("click", clickHandle);
		});
	};
	// 点击滚动
	$.fn.clickScroll = function(option) {
		var setting = {
			speed : 500,
			list : ".list ul",
			item : ".list ul li",
			auto : false
		};
		return this.each(function() {
			var $this = $(this);
			if (option) var opts = $.extend({}, setting, option);
			var $prev    = $this.find(".J_Prev");
			var $next    = $this.find(".J_Next");
			var $list    = $this.find(opts.list);
			var $items   = $this.find(opts.item);
			var distance = $items.outerWidth(true);
			var interval = 0;

			if (opts.auto) {
				var interval = setInterval(function() {
					$prev.click();
				}, 3000);
			}

			var prevClickHandle = function() {
				clearInterval(interval);
				$list.stop(true, true).animate({
					"margin-left" : "-" + distance + "px"
				}, opts.speed, function() {
					$list.css("margin-left", 0).find("li:first").appendTo($list);
					interval = setInterval(function() {
						$prev.click();
					}, 3000)
				});
			};
			var nextClickHandle = function() {
				clearInterval(interval);
				$list.css("margin-left", "-" + distance + "px").find("li:last").prependTo($list);
				$list.stop(true, true).animate({
					"margin-left" : 0
				}, opts.speed, function() {
					interval = setInterval(function() {
						$prev.click();
					}, 3000)
				});
			};

			$list.width( $items.size() * distance );
			$prev.bind("click", prevClickHandle);
			$next.bind("click", nextClickHandle);
		});
	};
	// 搜索框提示文本
	$.fn.inputTips = function(option) {
		var setting = {
			fontsize : "12px",
			fontcolor : "#ccc"
		};
		return this.each(function(i) {
			var $this = $(this);
			if (option) {
				var opts = $.extend({}, setting, option);
			}
			var t = $this.attr("tips");
			if (!t) return; // 没有tips属性则退出
			var _l = $this.offset().left;
			var _t = $this.offset().top;
			var $tips = $("<div>" + t + "</div>").appendTo($("body"));
			if ($.trim($this.val())) $tips.hide(); // 防止Firefox刷新记忆功能
			$tips.css({
				"position" : "absolute",
				"left" : parseInt(_l) + 5,
				"top" : _t,
				"height" : $this.outerHeight() + "px",
				"line-height" : $this.outerHeight() + "px",
				"width" : $this.width(),
				"overflow" : "hidden",
				"color" : opts.fontcolor,
				"font-size" : opts.fontsize,
				"font-family" : "\\5b8b\\4f53"
			});
			$this.bind({
				focus : function() {
					$tips.hide();
				},
				blur : function() {
					if (!$.trim($this.val())) $tips.show(); // 失去焦点时判断是否有输入，没有则恢复TIPS
				},
				keyup : function() {
					if (!!$.trim($this.val())) $tips.hide();
				}
			});
			$tips.bind("click focus", function() {
				$this.focus(); // 解决IE点击TIPS时文本框未获得焦点
			});
		});
	};
	/* 图片等比例缩放
	** @param : boxWidth 容器宽度
	** @param : boxHeight 容器高度
	** @param : isFill 是否填充容器
	*/
	$.fn.resizeImage = function(option) {
		var setting = {
			boxWidth : 100,
			boxHeight : 100,
			isFill : true
		};
		return this.each(function(i) {
			var $this = $(this);
			if (option) var opts = $.extend({}, setting, option);
			if ("img" != $this.get(0).tagName.toLowerCase()) return;
			var _tempImg    = new Image();
			_tempImg.src    = $this.attr("src");
			var _tempWidth  = _tempImg.width;
			var _tempHeight = _tempImg.height;
			if ( _tempWidth / _tempHeight >= opts.boxWidth / opts.boxHeight ) {
				if ( opts.isFill ) {
					$this.width(opts.boxHeight * _tempWidth / _tempHeight).height(opts.boxHeight);
				} else {
					if ( _tempWidth > opts.boxWidth ) {
						$this.width(opts.boxWidth).height(opts.boxWidth * _tempHeight / _tempWidth);
					}
				}
			} else {				
				if ( opts.isFill ) {
					$this.width(opts.boxWidth).height(opts.boxWidth * _tempHeight / _tempWidth);
				} else {	
					if ( _tempHeight > opts.boxHeight ) {
						$this.width(opts.boxHeight * _tempWidth / _tempHeight).height(opts.boxHeight);
					}
				}
			}
		});
	};
})(jQuery);