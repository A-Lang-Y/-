$(document).ready(
		function()
		{
			var _G_val = {
				singleheight:Math.floor($("#f_pinnav").width()/6),
				tsize:$("#f_pinnav_lis").find('li').length,
				step:Math.floor($("#f_pinnav").width()/6)*4,
				total:Math.ceil(($("#f_pinnav_lis").find('li').length-1)/4),  //总页数
				current:1
			};
			
			
			//初始化导航
			var arrtmp = ['news','drive','advice','restyle','racing','rv','cavalry','activity','outdoor','tour','photography','love'];
            var curindex = $.inArray(_global_var._channelename,arrtmp);
            var pagesize = 4;
			_G_val.current = Math.ceil(curindex/pagesize);
			_G_val.current = _G_val.current ? _G_val.current : 1;
			
			//ul滚动位置
			$("#f_pinnav_lis").css('left', -(_G_val.step)*(_G_val.current-1));
			//左右方向键显隐
			if(_G_val.current==1){
				$("#page_prev").hide();
				$("#page_next").show();
			}else if(_G_val.current>1 && _G_val.current<_G_val.total){
				$("#page_prev").show();
				$("#page_next").show();
			}else{
				$("#page_prev").show();
				$("#page_next").hide();  
			}
			//处理完毕 导航显示
			$("#f_pinnav_lis").show();
			
			
			$("#f_pinnav_lis").find('li').each(
				function()
				{
					$(this).width(_G_val.singleheight);
					$("#f_pinnav_lis").width(_G_val.singleheight*_G_val.tsize);
				}
			);
			
			$("#page_next").click(
				function()
				{  
					if(!$("#f_pinnav_lis").is(":animated") && _G_val.current<_G_val.total)
					{
						//var _left = $("#f_pinnav_lis").offset().left;
						var _left = parseInt($("#f_pinnav_lis").css('left'));
						$("#f_pinnav_lis").animate({left:_left - _G_val.step+'px'},500,
							function()
							{
								$("#f_pinnav_lis").css('left',(_left - _G_val.step) + 'px');
								_G_val.current++;
								if(_G_val.current > 1 && $("#page_prev").is(':hidden'))
								{
									$("#page_prev").show();
								}
								if(_G_val.current == _G_val.total)
								{
									$("#page_next").hide();
								}
							}
						);
					}
				}
			);
			
			$("#page_prev").click(
				function()
				{
					if(!$("#f_pinnav_lis").is(":animated") && _G_val.current>1)
					{
						//var _left = $("#f_pinnav_lis").offset().left;
						var _left = parseInt($("#f_pinnav_lis").css('left'));
						$("#f_pinnav_lis").animate({left:(parseInt(_left) + parseInt(_G_val.step)) +'px'},500,
							function()
							{
								$("#f_pinnav_lis").css('left',(parseInt(_left) + parseInt(_G_val.step))+'px');
								_G_val.current--;
								if( _G_val.current < _G_val.total && $("#page_next").is(':hidden'))
								{
									$("#page_next").show();
								}
								if(_G_val.current == 1)
								{
									$("#page_prev").hide();
								}
							}
						);
					}
				}
			)
		}
	);