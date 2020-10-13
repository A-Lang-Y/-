/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////// Variables Start                                                                                    */
var $ = jQuery.noConflict(); 
var formSubmitted = 'false';
/*//////////////////// Variables End                                                                                      */
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////// Document Ready Function Starts                                                                     */
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
jQuery(document).ready(function($) {
		   
	
	
	// fields focus function starts
	$('input[type="text"], input[type="password"], textarea').focus(function(){
	    
		if($(this).val() == $(this).attr('data-placeholder')){
		    
			$(this).val('');
				
		};	
		
	});
	// fields focus function ends
	
	
	
	// fields blur function starts
	$('input, textarea').blur(function(){
	    
		if($(this).val() == ''){
		    
			$(this).val($(this).attr('data-placeholder'));
				
		};	
		
	});
	// fields blur function ends
	
	
	
	// submit form data starts	   
    function submitData(currentForm, formType){
        
		formSubmitted = 'true';
		
		var formInput = $('#' + currentForm).serialize();
		
		$.post($('#' + currentForm).attr('action'),formInput, function(data){
			
			$('#' + currentForm).hide();
			$('#formSuccessMessageWrapper').fadeIn(500);
			
		});

	};
	// submit form data function starts
	
	
	
	// validate form function starts
	function validateForm(currentForm, formType){
		
		// hide any error messages starts
	    $('.formValidationError').hide();
		$('.fieldHasError').removeClass('fieldHasError');
	    // hide any error messages ends
		
		$('#' + currentForm + ' .requiredField').each(function(i){
		   	 
			if($(this).val() == '' || $(this).val() == $(this).attr('data-placeholder')){
				
				$(this).val($(this).attr('data-placeholder'));	
				$(this).focus();
				$(this).addClass('fieldHasError');
				$('#' + $(this).attr('id') + 'Error').fadeIn(300);
				return false;
					   
			};
			
			if($(this).hasClass('requiredEmailField')){
				  
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				var tempField = '#' + $(this).attr('id');
				
				if(!emailReg.test($(tempField).val())) {
					$(tempField).focus();
					$(tempField).addClass('fieldHasError');
					$(tempField + 'Error2').fadeIn(300);
					return false;
				};
			
			};
			
			if(formSubmitted == 'false' && i == $('#' + currentForm + ' .requiredField').length - 1){
			 	submitData(currentForm, formType);
			};
			  
   		});
		
	};
	// validate form function ends
	
	
	
	// contact button function starts
	$('#contactSubmitButton').click(function() {
	
		validateForm($(this).attr('data-form-id'));	
	    return false;
		
	});
	// contact button function ends
	
	
	
});
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//////////////////// Document Ready Function Ends                                                                       */
/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
