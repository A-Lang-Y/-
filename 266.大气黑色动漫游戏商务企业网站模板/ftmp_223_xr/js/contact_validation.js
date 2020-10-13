	// CONTACT FORM VALIDATION
	$(document).ready(function(){
		$("#contact_form").validate({
			meta: "validate",
			submitHandler: function (form) {
			    $('#contact_form').hide();
				var s_name=$("#name").val();
				var s_email=$("#email").val();
				var s_website=$("#website").val();
				var s_comment=$("#comment").val();
				$.post("contact.php",{name:s_name,email:s_email,website:s_website,comment:s_comment},
			   	function(result){
                  $('#sucessmessage').append(result);
                });
				return false;
				
				},
			/* */
			rules: {
				name: "required",
				
				lastname: "required",
				// simple rule, converted to {required:true}
				email: { // compound rule
					required: true,
					email: true
				},
				subject: {
					required: true,
				},
				comment: {
					required: true
				}
			},
			messages: {
				name: "*",
				lastname: "*",
				email: {
					required: "*",
					email: "*"
				},
				subject: "*",
				comment: "*"
			},
		});
	});					
	