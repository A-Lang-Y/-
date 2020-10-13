$(document).ready(function(){
/*************控制右边显示的高度***********/
	var asideHei=parseInt($(".aCont").height());
	if(asideHei<=parseInt($(window).height())){
		$(".version").css({"position":"absolute"});
		$(".asideMenu").height($(window).height());
	}else{
		$(".version").css({"position":"relative"});
	}
	$(window).resize(function(){
		var asideHei=parseInt($(".aCont").height());
		if(asideHei<=parseInt($(window).height())){
		$(".version").css({"position":"absolute"});
		$(".asideMenu").height($(window).height());
	}else{
		$(".version").css({"position":"relative"});
		$(".asideMenu").height(asideHei+41);
	}
	});
	//右上角菜单点击显示下拉菜单
	$('.f_imenu').click(function(){
		//$('#f_imenu_abs').toggle();
		//return false;
		var obj=$(".wrap");
		var wid=parseInt($(".asideMenu").width());
		var marL=parseInt(obj.css("margin-left"));
		if(marL<0){
			obj.animate({"margin-left":0},200,function(){
				$(".pos").css({"position":"static","width":"100%"});
			});
			$(".f_ifixed").animate({"margin-left":0},200);
			$("#g_fixed").animate({"margin-left":0},200);
		}else{
			obj.animate({"margin-left":-wid},200,function(){
				$(".pos").css({"position":"fixed","width":"100%"});
				$(".lay-left a").bind("click",function(e){e.preventDefault();});
			});
			$(".f_ifixed").animate({"margin-left":-wid},200);
			$("#g_fixed").animate({"margin-left":-wid},200);
		}
	});
		$('.lay-left').click(function(){
			if(parseInt($(".wrap").css("margin-left"))<0){
				$(".lay-left a").not(".f_imenu,#app_close,#a_getmorenews,.f_pinback,#page_prev,#page_next").unbind();
				$(".wrap").animate({"margin-left":0},200,function(){
				$(".pos").css({"position":"static","width":"100%"});
			});
				$(".f_ifixed").animate({"margin-left":0},200);
				$("#g_fixed").animate({"margin-left":0},200);
			}
		});
	});