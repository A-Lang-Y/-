/**
 * @fileOverview M版分享组件
 */
 
if(typeof CNC=="undefined" || !CNC){
	var CNC = {};
} 

(function($){
	CNC.MShare = {
		config: {
			site: "",     //1、vogue 2、self 3、gq 4、adstyle 5、cnt 6、feature(专题)
			catalog: "", //栏目id
			sUrl: window.location.href,
			tsinaKey: "",
			ralateUid: ""
		},
		baseUrl: "../application.self.com.cn/share/front/",
		tsinaParam: "collect@platform=tsina&title={title}&url={url}&pic={pic}&site={site}&cat={cat}&ralateUid={ralateUid}&appkey={appkey}",
		reflux: function(){
			var refer = document.referrer;
			var url = document.location.href;
			var param = location.search;
			var ua = navigator.userAgent.toLowerCase();

			if( param.indexOf("tsina-") > -1 || param.indexOf("tqq-") > -1 || param.indexOf("qzone-") > -1 
				|| param.indexOf("renren-") > -1 || param.indexOf("douban-") > -1 || param.indexOf("weixin-") > -1){
                $.getJSON( CNC.MShare.baseUrl + "reflux?" + "callback=?" +"&url=" +encodeURIComponent(url) +'&ua=' + ua + '&param=' + param);
				/*$.getJSON( CNC.MShare.baseUrl + "reflux?" + "callback=?", {
					url: url,
					ua: ua,
					param: param
				});*/
			}
		},
		init: function(config, selector){
			if( config ){
				$.extend(this.config, config);
			}
			
			if( selector ){
				this.wbShare(selector);
			}
			this.reflux();
		},
		wbShare: function(selector){
			var self = this;
			$(selector).click(function(){
				var params = {}, 
					cfg = self.config,
					trigger = $(this),
					url = trigger.attr("data-url");

				params.title = encodeURIComponent( trigger.attr("data-title") );
				params.url = encodeURIComponent( url ? url : cfg.sUrl );
				params.pic = encodeURIComponent( trigger.attr("data-pic") );
				params.site = cfg.site;
				params.cat = cfg.catalog;
				params.ralateUid = cfg.ralateUid;
				params.appkey = cfg.tsinaKey;

				var cmdUrl = CNC.MShare.baseUrl + self.formatUri(CNC.MShare.tsinaParam, params);
				window.open( cmdUrl );
			});
		},
		formatUri: function(uri, params){
			var reg, uri = uri;
			for(var k in params){
				reg = new RegExp("{" + k + "}", "g");
				uri = uri.replace(reg, params[k]);
			}
			return uri;
		}
	}
})(Zepto);

