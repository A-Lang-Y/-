jQuery(document).ready(function($){     
    
    // contact                           
    var error = true;      
    
    function addLoading( e )
    {
		$(e).val( '{wait}'.replace('{wait}', contactForm.wait) ).attr('disabled', true);
	}    
    
    function removeLoading( e )
    {
		$(e).val(value_submit).attr('disabled', false);
	}
	
	function addError(msg, e, effect)
	{
		error = true;           
		$(e).removeClass('icon success');
		$(e).addClass('icon error');
		$(e).parents('li').find('.msg-error').text(msg);	
		if( effect !== undefined && effect == true )
		{
			$(e).css({position:'relative'}).animate({left:-10}, 100).animate({left:10}, 100).animate({left:-5}, 100).animate({left:5}, 100).animate({left:0}, 100);
		}
	}                 
	
	function addSuccess(e)
	{                                     
		$(e).addClass('icon success');	
	}
	
	function removeError(e)
	{
		error = false;
		$(e).parents('li').find('.msg-error').text('');     
		$(e).removeClass('icon error');
        $(e).removeClass( 'formRed')
		addSuccess(e);
	}           
    	
	$('.contact-form .required').blur(function(){             
		var name = $(this).attr('name').match( /(.*)\[(.*)\]/ );
		var id_form = $(this).parents('.contact-form').find('input[name="id_form"]').val(); 
		
		jQuery.globalEval( 'var msg = messages_form_'+id_form+'.'+name[2] );  
		
		if( $(this).val() == '' )
			addError( msg, this );       
		else               
			removeError(this);
	});                
	
	$('.contact-form .email-validate').blur(function(){             
		var expr = /^[_a-z0-9+-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$/;
		var name = $(this).attr('name').match( /(.*)\[(.*)\]/ );       
		var id_form = $(this).parents('.contact-form').find('input[name="id_form"]').val();
		
		jQuery.globalEval( 'var msg = messages_form_'+id_form+'.'+name[2] );
		
		if( ( $(this).val() != '' && !expr.test( $(this).val() ) ) || ( $(this).is('.required') && $(this).val() == '' ) )  
			addError( msg, this );            
		else 
			removeError(this);
	});    
    
	$('.contact-form').submit(function(){
		addLoading( '.contact-form input:submit' );  
	});
	
	$('input[placeholder], textarea[placeholder]').placeholder();    
   
});   