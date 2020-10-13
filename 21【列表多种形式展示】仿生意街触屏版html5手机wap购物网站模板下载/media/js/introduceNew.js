$(function(){
		$("#tab1").click(function(){ 
			if($(".tabDiv1 ").find("#tabP1").css("display")=="none"){ 
				$("#tabP1").slideDown(500);
				$("#tabSpan1").text("收起");
				$("#tabSpan1").addClass("tabSpanTH");
			}else{ 
				$("#tabP1").slideUp(500);
				$("#tabSpan1").text("展开");
				$("#tabSpan1").removeClass("tabSpanTH");
				
			};
			$("#tabP2").hide();
			$("#tabSpan2").text("展开");
			$("#tabSpan2").removeClass("tabSpanTH");
		  });
		  
		$("#tab2").click(function(){ 
			if($(".tabDiv1 ").find("#tabP2").css("display")=="none"){ 
				$("#tabP2").slideDown(500);
				$("#tabSpan2").text("收起");
				$("#tabSpan2").addClass("tabSpanTH");
			}else{ 
				$("#tabP2").slideUp(500);
				$("#tabSpan2").text("展开");
				$("#tabP2").slideUp();
				$("#tabSpan2").removeClass("tabSpanTH");
				
			};
			$("#tabP1").slideUp();
			$("#tabSpan1").text("展开");
			$("#tabSpan1").removeClass("tabSpanTH");
		  });
		
		$("#tabDivclick").click(function(){ 
			if($(".tabDiv1 ").find("#tabP1").css("display")=="none"){ 
				$("#tabP1").slideDown(500);
				$("#tabSpan1").text("收起");
				$("#tabSpan1").addClass("tabSpanTH");
			}else{ 
				$("#tabP1").slideUp(500);
				$("#tabSpan1").text("展开");
				$("#tabSpan1").removeClass("tabSpanTH");
				
			};
			$("#tabP2").slideUp(500);
			$("#tabSpan2").text("展开");
			$("#tabSpan2").removeClass("tabSpanTH");
		  });
		
		
		$(".sub_message").click(function(){ 
			$(".subCen_p1").css({"background":"url(../media/images/introduce/subP11.jpg) no-repeat"}); 
			$("#sub_message").slideDown(1000);
			$(".subCen_p2").css({"background":"url(../media/images/introduce/subP22.jpg) no-repeat"}); 
			$(".sub_message").hide();
			$(".sub_message2").hide();
			$(".sub_phone").hide();
			$(".subCen_p3").show();
		});
		
		$(".subCen_p3").click(function(){ 
			$(".subCen_p1").css({"background":"url(../media/images/introduce/subP1.jpg) no-repeat"}); 
			$(".subCen_p2").css({"background":"url(../media/images/introduce/subP2.jpg) no-repeat"}); 
			$(".sub_message").show();
			$(".sub_message2").show();
			$(".sub_phone").show();
			$(".subCen_p3").hide();
			$("#sub_message").slideUp(1000);
		});
				
		$(".foot").click(function(){ 
			if($(".foot_box").is(":visible")){ 
				$(".foot_box").hide();
				$(this).css("background","url(../media/images/iconall.png) no-repeat 0 -764px");
			}else{ 
				$(".foot_box").show();
				$(this).css("background","url(../media/images/iconall.png) no-repeat 0 -808px");
			}	
		});
		var obj=document.getElementById('pagenavi');
		if(obj != undefined && obj != '' && obj != null){
			var as=document.getElementById('pagenavi').getElementsByTagName('a'),p=0;
			var tt=new TouchSlider({id:'slider1','auto':'-1',fx:'ease-out',direction:'left',speed:600,timeout:5000,'before':function(index){
				var as=document.getElementById('pagenavi').getElementsByTagName('a');
				if(typeof p != 'undeinfed') as[p].className='';
				as[index].className='active';
				p=index;
			}});
			console.dir(tt); console.dir(tt.__proto__);
			for(var i=0;i<as.length;i++){
				(function(){
					var j=i;
					as[j].onclick=function(){
						tt.slide(j);
						return false;
					}
				})();
			};
		}
		
		
		
		
		
	});