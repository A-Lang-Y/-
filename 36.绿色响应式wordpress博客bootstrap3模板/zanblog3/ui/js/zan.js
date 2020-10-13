/**
 * ZanBlog JavaScript File
 *
 * 为了提高用户使用ZanBlog时的用户体验。
 *
 * Author: 佚站互联（YEAHZAN）
 *
 * Site: http://www.yeahzan.com/
 */

jQuery(window).load(function() {
  zan.flexslider();
});


jQuery(function() {
	zan.init();
});

audiojs.events.ready(function() {
    var as = audiojs.createAll();
});

var zan = {

	//初始化函数
	init: function() {
		this.dropDown();
		this.setImgHeight();
    this.addAnimation();
	},

	// 设置导航栏子菜单下拉交互
	dropDown: function() {
		var dropDownLi = jQuery('.nav.navbar-nav li');

		dropDownLi.mouseover(function() {
			jQuery(this).addClass('open');
		}).mouseout(function() {
			jQuery(this).removeClass('open');
		});
	},

	// 设置文章图片高度
	setImgHeight: function() {
		var img = jQuery(".zan-single-content").find("img");

		img.each(function() {
			var $this 		 = jQuery(this),
					attrWidth  = $this.attr('width'),
					attrHeight = $this.attr('height'),
					width 		 = $this.width(),
					scale      = width / attrWidth,
					height     = scale * attrHeight;

			$this.css('height', height);

		});
	},

  // 为指定元素添加动态样式
  addAnimation: function() {
    var animations = jQuery("[data-toggle='animation']");

    animations.each(function() {
      jQuery(this).addClass("animation", 2000);
    });
  },

	// 设置首页幻灯片
	flexslider: function() {
		jQuery('.flexslider').flexslider({
	    animation: "slide"
	  });
	}
}
