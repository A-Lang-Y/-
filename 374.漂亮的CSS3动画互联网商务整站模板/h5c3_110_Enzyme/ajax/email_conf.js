// function that submits forms
function submitForm(name) {
	document.forms[name].submit();
}
// this function displays/removes the notification boxes
function handleError(element, remove, classEle) {
	// the defualt value for the class will be .error-wrapper
	classEle = (typeof classEle == "undefined")?'error-wrapper':classEle;
	
	if(element.length == 0) {
		return;
	}
	// if the program wants us to remove the element
	if( remove == false ) {
		$('.form-result').fadeOut('fast');
	}
	
}
// This funciton submits the form and makes sure there are no mistakes
function contactUsSubmit() {
	// this is the name of the "name" feild
	var name = document.forms['contactus']['name'].value;
	// check if the name is entered
	if( name.length == 0 || name == '' || name == null || $.trim(name).length == 0 || name == 'Name *') {
		$(".form-result").css("display", "none").html("<p class='note error'>Please type your name.</p><br />").fadeIn(400);
			$(".contactForm #name").animate({borderColor: '#ffacac'})
			$("#contactus #name").focus();
		return;
	} else {
		// remvoe the error element
		$(".contactForm #name").css({borderColor: '#d8d7d7'})
		$(".form-result").html("");
	}
	
	// store the email in a variable for later use
	// this is the comment field
	var email = document.forms['contactus']['email'].value;
	
	// validate the email address
	var eIsValid = validateEmail( 'contactus', 'email' );
	if( !eIsValid ) {
		// create the error element
		$(".form-result").css("display", "none").html("<p class='note error'>Please enter a valid email.</p><br />").fadeIn(400);
		// put the cursor in the field
		$(".contactForm #email").animate({borderColor: '#ffacac'})
		$(".contactForm #email").focus();
		return;
	} else {
		$(".form-result").fadeOut('fast').html("");
	}
	
	// this is the comment field
	var comment = document.forms['contactus']['comment'].value;
	// check if the comment
	if( comment.length == 0 || comment == '' || comment == null ) {
		$(".form-result").css("display", "none").html("<p class='note error'>Please type in a message.</p><br />").fadeIn(400);
		$(".contactForm #comment").animate({borderColor: '#ffacac'})
		$("#comment").focus();
		return;
	} else {
		// in case there is something that is later wrong with the form
		// we need to make sure we clear the error
		$(".form-result").fadeOut('fast').html("");
	}
	var subject = document.forms['contactus']['subject'].value;
	// if there is a subject
	if( subject.length <= 0 ) {
		// No subject is filled in
		subject = "No Subject";
	}
	$(".contactForm > .button").hide(500);
	// acquire the correct AJAX object
	var xmlhttp = Getxmlhttp();
	// Open the server page
	xmlhttp.open("GET", 'ajax/email_conf.php?name='+name+'&email='+email+'&comment='+comment+'&subject='+subject, true);
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// hide the form
			$(".contactForm").slideUp(1000, function() {
				// once the form has been hidden
				$(".form-result").css("display", "none");
				if( parseInt(xmlhttp.responseText) == 1 ) {
					// message sent
					$(".form-result").css("display", "none").html("<p class='note success'>Your message has successfully been sent. Thank you for your input!</p><br />").fadeIn('fast');
				} else {
					// message failed to send
					$(".form-result").css("display", "none").html("<p class='note error'>We are sorry, but something went wrong. Your message has not been sent, please try again later! Error Message: "+xmlhttp.responseText+"</p>").fadeIn('fast');
				}
				$(".form-result").show(1000);
			});
			
		}
	}
	// Send the request
	xmlhttp.send(null);
}

// This function validates email addresses without the need to 
// use regular expressions
function validateEmail(formname, fieldname) {
	var x = document.forms[formname][fieldname].value;
	var atpos = x.indexOf("@");
	var dotpos = x.lastIndexOf(".");
	if (atpos < 1 || dotpos < atpos+2 || dotpos+2 >= x.length) {
		return false;
	} else {
		return true;
	}
}