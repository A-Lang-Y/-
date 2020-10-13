$(function(){ 

	
	$(".head_icon2").click(function(event){
	  var e=window.event || event;
	  if(e.stopPropagation){
	   e.stopPropagation();
	  }else{
	   e.cancelBubble = true;
	  }  
	  
	  if($(".listnav,.listnav_icon").is(":visible")){ 
	  	$(".listnav").hide();
	  	$(".listnav_icon").hide();
	  }else{ 
	  	$(".listnav").show();
	  	$(".listnav_icon").show();
	  }
	  
	 });
	 
	 document.onclick = function(){
	  $(".listnav").hide();
	  $(".listnav_icon").hide();
	 };
	
	$(".cen").click(function(){ 
		$(".page_a").toggle();
		$(".paga_aImgBj").toggle();
	});
	
	$(".listnav li a").click(function(){ 
		$(".listnav").hide();
		$(".listnav_icon").hide();
	});
	
	//search
	$(".search_input").click(function(){
		$(".search_close").show();
	});
	
	$(".search_close").click(function(){ 
		$(".search_close").hide();
		$(".search_input").val("");
	});
	
	//list
	
	$(".select-choice-2").click(function(){ 
		$("#select-choice-1").css("opacity","1");
	});
	
	
	
	$('.content').css('width', $('.content div').width());
	
	$(".spimg,.spicon").click(function(){ 
		$("#myvideo").show();
		$(".spimg,.spicon").hide();
	});
	
	
	
});