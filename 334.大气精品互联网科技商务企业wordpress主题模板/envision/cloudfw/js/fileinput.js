/**
 * --------------------------------------------------------------------
 * jQuery customfileinput plugin
 * Author: Scott Jehl, scott@filamentgroup.com
 * Copyright (c) 2009 Filament Group 
 * licensed under MIT (filamentgroup.com/examples/mit-license.txt)
 * --------------------------------------------------------------------
 */
(function($){
$.fn.customFileInput = function(){
	return $(this).each(function(){
	//apply events and styles for file input element
	var fileInput = $(this);
	
	if (fileInput.hasClass('customfile-input')) return true;
	
	fileInput
		.addClass('customfile-input') //add class for CSS
		.mouseover(function(){ upload.addClass('customfile-hover').find('.customfile-button').removeClass('small-green').addClass('small-dark'); })
		.mouseout(function(){ upload.removeClass('customfile-hover').find('.customfile-button').removeClass('small-dark').addClass('small-green');; })
		.focus(function(){
			upload.addClass('customfile-focus'); 
			fileInput.data('val', fileInput.val());
			
			setTimeout(function(){
				fileInput.trigger('checkChange'); upload.scrollTo(0);
			},100);
		})
		.blur(function(){ 
			upload.removeClass('customfile-focus');
			$(this).trigger('checkChange');
		 })
		 .bind('disable',function(){
		 	fileInput.attr('disabled',true);
			upload.addClass('customfile-disabled');
		})
		.bind('enable',function(){
			fileInput.removeAttr('disabled');
			upload.removeClass('customfile-disabled');
		})
		.bind('checkChange', function(){
			if(fileInput.val() && fileInput.val() != fileInput.data('val')){
				fileInput.trigger('change');
			}
		})
		.bind('change',function(){
			//get file name
			var fileName = $(this).val().split(/\\/).pop();
			//update the feedback
			uploadFeedback
				.text(fileName) //set feedback text to filename
				.addClass('customfile-feedback-populated'); //add class to show populated state
			//change text of button	
			upload.addClass('customfile-focus'); 
			uploadButton.children("span").text('Change');	
		})
		.click(function(){ //for IE and Opera, make sure change fires after choosing a file, using an async callback
			fileInput.data('val', fileInput.val());
			setTimeout(function(){
				fileInput.trigger('checkChange');
			},100);
		});
	
	//create custom control container
	var upload = $('<div class="customfile"></div>');
	//create custom control button
	var uploadButton = $('<span class="small-button small-green customfile-button" aria-hidden="true"><span>Browse</span></span>').appendTo(upload);
	//create custom control feedback
	var uploadFeedback = $('<span class="customfile-feedback" aria-hidden="true">No file selected</span>').appendTo(upload);
	
	//match disabled state
	if(fileInput.is('[disabled]')){
		fileInput.trigger('disable');
	}

	
	
	//on mousemove, keep file input under the cursor to steal click
	upload
		.mousemove(function(e){
			upload.scrollTo(0);
			fileInput.css({
				'left': e.pageX - upload.offset().left - fileInput.outerWidth() + 25, //position right side 20px right of cursor X)
				'top' : e.pageY - upload.offset().top  - 15
			});	
		})
		.insertAfter(fileInput); //insert after the input
	
	fileInput.appendTo(upload);
		
	});
};

})(jQuery);