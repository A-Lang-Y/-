$(function() {
    // These first three lines of code compensate for Javascript being turned on and off. 
    // It simply changes the submit input field from a type of "submit" to a type of "button".

    var paraTag = $('input#submit').parent('p');
	
    $(paraTag).children('input').remove();
    $(paraTag).append('<input type="button" name="submit" id="submit" value="Email Us Now!" />');

    $('#main input#submit').click(function() {
        var name = $('input#name').val();
        var email = $('input#email').val();
        var message = $('textarea#message').val();
		  var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
		 var subject = $('input#subject').val();
		 if(name=='')
		 {
			 $('[name="name"]').addClass('vaidate_error');
		 }else{
			 $('[name="name"]').removeClass('vaidate_error');
			 }
			 
			  if(email=='')
		 {
			 $('[name="email"]').addClass('vaidate_error');
		 }else{
			if (!pattern.test(email)) {
				 $('[name="email"]').addClass('vaidate_error');
			 }else{
				 $('[name="email"]').removeClass('vaidate_error');
				 }
			 }
			 
				 
			if(message=="")
					 {
						 $('[name="message"]').addClass('vaidate_error');
					 }else{
						 $('[name="message"]').removeClass('vaidate_error');
						 }
			if(subject=="")
					 {
						 $('[name="subject"]').addClass('vaidate_error');
					 }else{
						 $('[name="subject"]').removeClass('vaidate_error');
						 }

        $.ajax({
            type: 'post',
            url: 'sendEmail.php',
            data: 'name=' + name + '&email=' + email +'&subject='+ subject +'&message=' + message,

            success: function(results) {	
                $('div#response').html(results).css('display', 'block');		
   
            }
        }); // end ajax
    });
});
		