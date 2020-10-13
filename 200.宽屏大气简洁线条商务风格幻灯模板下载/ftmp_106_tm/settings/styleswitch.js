$(document).ready(function(){

	function displayVals() {
		var singleValues = $("#font").val();
		$("body").removeClass("opensans cabin droidsans dustismo liberationsans luxisans negotiate puritan titillium ubuntu").addClass(singleValues);		
	}
	$("select").change(displayVals);			
	displayVals();
	
	$("span.door").click(function () {
		$(".options").fadeIn("slow");
		return false;
	});
	
	$("span.close").click(function () {
		$(".options").fadeOut("slow");
		return false;
	});
	
	$("#styles").click(function () {
		$("body").addClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles2").click(function () {
		$("body").removeClass("pt-1");			
		$("body").addClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles3").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").addClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles4").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").addClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles5").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").addClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles6").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").addClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles7").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").addClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles8").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").addClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles9").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").addClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles10").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").addClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles11").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").addClass("pt-11");		
		$("body").removeClass("pt-12");		
		return false;
	});
	$("#styles12").click(function () {
		$("body").removeClass("pt-1");			
		$("body").removeClass("pt-2");		
		$("body").removeClass("pt-3");		
		$("body").removeClass("pt-4");		
		$("body").removeClass("pt-5");		
		$("body").removeClass("pt-6");		
		$("body").removeClass("pt-7");		
		$("body").removeClass("pt-8");		
		$("body").removeClass("pt-9");		
		$("body").removeClass("pt-10");		
		$("body").removeClass("pt-11");		
		$("body").addClass("pt-12");		
		return false;
	});
});