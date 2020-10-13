jQuery(function() {
  jQuery('.error').hide();
  jQuery(".butcontact").click(function() {
		// validate and process form
		// first hide any error messages
    jQuery('.error').hide();
		
	  var name = jQuery("input#name").val();
		if (name == "") {
      jQuery("span#name_error").show();
      jQuery("input#name").focus();
      return false;
    }
	  var email = jQuery("input#email").val();
	  if (email == "") {
      jQuery("span#email_error").show();
      jQuery("input#email").focus();
      return false;
    }
	
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if(!emailReg.test(email)) {
	jQuery("span#email_error2").show();
    jQuery("input#email").focus();
      return false;
	}
	
	var website = jQuery("input#website").val();
	
	var subject = jQuery("input#subject").val();
	
	  var msg = jQuery("textarea#msg").val();
	  if (msg == "") {
	  jQuery("span#msg_error").show();
	  jQuery("textarea#msg").focus();
	  return false;
    }
		
		var dataString = 'name='+ name + '&email=' + email + '&website=' + website + '&subject=' + subject + '&msg=' + msg;
		//alert (dataString);return false;
		
	  jQuery.ajax({
      type: "POST",
      url: "process.php",
      data: dataString,
      success: function() {
        jQuery('#contactform').html("<div id='message'></div>");
        jQuery('#message').html("<strong>Contact Form Submitted!</strong>")
        .append("<p>We will be in touch soon.</p>")
        .hide()
        .fadeIn(1500, function() {
          jQuery('#message');
        });
      }
     });
    return false;
	});
});

