jQuery(function() {
  jQuery('.error').hide();
  jQuery(".contactButton").click(function() {
		// validate and process form
		// first hide any error messages
    jQuery('.error').hide();
		
	  var name = jQuery("input#contactName").val();
		if (name == "" || name =="John Doe?") {
      jQuery("span#nameError").hide();
      jQuery("input#contactName").focus();
      return false;
    }
	  var email = jQuery("input#contactEmail").val();
	  if (email == "" || email == "johndoe_40domain.com") {
      jQuery("span#emailError").hide();
      jQuery("input#contactEmail").focus();
      return false;
    }
	
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if(!emailReg.test(email)) {
	jQuery("span#emailError2").hide();
    jQuery("input#contactEmail").focus();
      return false;
	}
	
	  var msg = jQuery("textarea#contactMessage").val();
	  if (msg == "") {
	  jQuery("span#messageError").hide();
	  jQuery("textarea#contactMessage").focus();
	  return false;
    }
		
		var dataString = 'name='+ name + '&email=' + email + '&msg=' + msg;
		//alert (dataString);return false;
		
	  jQuery.ajax({
      type: "POST",
      url: "php/subscribe.php",
      data: dataString,
      success: function() {
        jQuery('#modalForm').html("<div id='successMessage' style='margin-top:47px; height:155px'></div>");
        jQuery('#successMessage').html("<strong style='color:#252525;'>Thank you for subscribing!</strong>")
        .append("<p style='color:#343434; font-size:12px; padding-top:10px;'>We will not spam you or send you unnecessary messages!</p><div class='clear'></div>")
        .hide()
        .fadeIn(1500, function() {
          jQuery('#successMessage');
        });
      }
     });
    return false;
	});
});

