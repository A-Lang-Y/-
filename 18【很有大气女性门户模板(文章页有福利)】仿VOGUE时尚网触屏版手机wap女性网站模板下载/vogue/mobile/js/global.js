/*cookie*/
var cookie = {
    encode: encodeURIComponent,
    decode: decodeURIComponent,
    get: function(name){
        var ckPatern = /([^=]+)=([^=]+)/, ckPart = '', ckStr = document.cookie, arr = ckStr.split(/;\s/);
        
        for (var i = 0, l = arr.length; i < l; i++) {
            ckPart = arr[i].match(ckPatern);
            if (ckPart) {
                var ckName = ckPart[1];
                if ((ckName === name) || (ckName === this.decode(name))) {
                    return this.decode(ckPart[2]);
                }
            }
        }
        return null;
    },
    set: function(name, value, options){
        var ckText = this.encode(name) + '=' + this.encode(value);
        
        if (typeof options == 'object') {
        
            if (options.expires instanceof Date) {
                ckText += '; expires=' + options.expires.toUTCString()
            }
            if (typeof options.path == 'string') {
                ckText += '; path=' + options.path;
            }
            if (typeof options.domain == 'string') {
                ckText += '; domain=' + options.domain;
            }
        }
        document.cookie = ckText;
    }
};
/*登陆*/
mVogueLogin={
	init:function(){
		var ckValue = cookie.get('MHyU_3100_pv_uid');
		if (!!ckValue && ckValue !== 'deleted') {
			var name=cookie.get('MHyU_3100_pv_user');
			$('#loginfo').text(name);
			$('#loginfo').css('color','#9e9e9e');
			$('#loginfo').css('overflow','hidden');
		}else{
			//console.log(1)
		}
	}
}
mVogueLogin.init();
/*导航显示*/
$(".channel-select").bind("click", function(){
	var display=$(".toogle-nav").css('display');
	if(display=='block'){
		$(".toogle-nav").hide();
		$(".channel-select").css({background: 'url(../../css.selfimg.com.cn/vogue/mobile/images/select.png) no-repeat'});
	}else{
		$(".toogle-nav").show();
		$(".channel-select").css({background: 'url(../../css.selfimg.com.cn/vogue/mobile/images/select2.png) no-repeat'});
	}
});
			
/*展开收起*/		
$(".zk-btn").bind("click",function(){
	var outerbox=$(".artouter");
	var innerbox=$(".artinner");
	if(outerbox.height()<innerbox.height()){
		
		outerbox.height(innerbox.height());
		$(".zk-btn").css({background: 'url(../../css.selfimg.com.cn/vogue/mobile/images/zkbtn2.jpg) no-repeat'}); 
		$(".zk-btn").html('收起');
			
	}

		
	else{
		outerbox.height(79);
		$(".zk-btn").css({background: 'url(../../css.selfimg.com.cn/vogue/mobile/images/zkbtn.jpg) no-repeat'});
		$(".zk-btn").html('展开');
	}
 });
	 
/**/	 

var goto_top_type = -1;
var goto_top_itv = 0;

function goto_top_timer(){
	var y = goto_top_type == 1 ? document.documentElement.scrollTop : document.body.scrollTop;
	var moveby = 300;

	y -= moveby;
	if (y < 0) {
		y = 0;
	}

	if (goto_top_type == 1) {
		document.documentElement.scrollTop = y;
	}
	else {
		document.body.scrollTop = y;
	}

	if (y == 0) {
		clearInterval(goto_top_itv);
		goto_top_itv = 0;
	}
}

function goto_top(){
	if (goto_top_itv == 0) {
		if (document.documentElement && document.documentElement.scrollTop) {
			goto_top_type = 1;
		}else if (document.body && document.body.scrollTop) {
			goto_top_type = 2;
		}else {
			goto_top_type = 0;
		}

		if (goto_top_type > 0) {
			goto_top_itv = setInterval('goto_top_timer()', 10);
		}
	}
}
	 
window.onscroll = function(){
	var t = document.documentElement.scrollTop || document.body.scrollTop;
	var goTopBtn = document.getElementById("goto-btn");
	if(t < 50){
		goTopBtn.style.display = "none";
	}else{
		goTopBtn.style.display = "block";
	}
}	

/*分享*/
function share()
{
    var url = window.location.href, shareBtn = $("#sina-share");
    var weiboUrl = "../../service.weibo.com/share/share.php@appkey=3311635685&";
    weiboUrl += "&title=" + encodeURIComponent(shareBtn.attr("data-title"));
    weiboUrl += "&pic=" + encodeURIComponent(shareBtn.attr("data-pic"));
    weiboUrl += "&url=" + encodeURIComponent(shareBtn.attr("data-url"));
    window.open(weiboUrl);
}
	
/**/	
var iPhoneFavoriteTips = {
	isIphoneSafari: null,
	init: function(){
		var userAgent = navigator.userAgent;
		this.isIphoneSafari = /iPhone/ig.test(navigator.userAgent) && /Safari/ig.test(navigator.userAgent) && !/QQBrowser/ig.test(navigator.userAgent);
		if( !this.isIphoneSafari ){
			return ;
		}
		this.tips = document.getElementById('iphone-fav-tips');
		this.closeBtn = document.getElementById('iphone-fav-tips-close');
		this.closeBtn.onclick = function(){
			iPhoneFavoriteTips.tips.style.display = 'none';
		}

		var isVisited;
		try{
			isVisited = localStorage.getItem('isVisited');
			if( !isVisited ){
				this.tips.style.display = 'block';
				localStorage.setItem('isVisited', "true");
			}
		}catch(e){
			this.tips.style.display = 'block';
		}
	}
}
$("#goto-www").bind("click", function(){
	cookie.set("visitWWW", "visited", {path: "../default.htm", domain: "vogue.com.cn"});
})
$(document).ready(function(){
    addEventListener('load', function(){ 
    	setTimeout(function(){ window.scrollTo(0, 1); }, 100); 
    });	
})
