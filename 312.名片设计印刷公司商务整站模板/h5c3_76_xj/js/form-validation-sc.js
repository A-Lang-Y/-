// Validation for Shortcode contact form

$(document).ready(function(){

	// hide messages 
	$("#sc-contact-form .error").hide();
	$("#sc-contact-form .success").hide();
	
	// on submit...
	$("#sc-contact-form #submit").click(function() {
	
		
			
		$("#sc-contact-form .error").hide();
		
		//required:
		
		//name
		var name = $("#sc-contact-form #name").val();
		if(name == ""){
			$("#sc-contact-form .error").fadeIn().text("Name required.");
			$("input#name").focus();
			return false;
		}
		
		
		// email
		var email = $("#sc-contact-form #email").val();
		if(email == ""){
			$("#sc-contact-form .error").fadeIn().text("Email required");
			$("#sc-contact-form #email").focus();
			return false;
		}
		
		// comments
		var comments = $("#sc-contact-form #comments").val();
		
		//to & subject
		var to = $("#sc-contact-form #to").val();
		var subject = $("#sc-contact-form #subject").val();
		var sendMailUrl = $("#sc-contact-form #sendmailurl").val();
		
		// data string
		var dataString = 'name='+ name
						+ '&email=' + email        
						+ '&comments=' + comments
						+ '&subject=' + subject
						+ '&to=' + to;
						         
		// ajax
		$.ajax({
			type:"POST",
			url: sendMailUrl,
			data: dataString,
			success: success()
		});
		
	});  
		
	// on success...
	 function success(){
	 	$("#sc-contact-form .success").fadeIn();
	 	$("#sc-contact-form fieldset").fadeOut();
	 }
	
    return false;
});

