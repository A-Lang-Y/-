// Define default variables
var uploadInput;

var layerSlider = {
	
	g : {
		dragContainer : null,
		advanced : [5,6,7,10,14,15]
	},
	
	init : function() {
		
		// Bind an event to add new slide
		jQuery('.layerslider_add_slide').live('click', function(e) {
			e.preventDefault();
			layerSlider.addSlide(this);
		});
		
		// Bind add sublayer button event
		jQuery('.layerslider_add_sublayer').live('click', function(e) {
			e.preventDefault();
			layerSlider.addSublayer(this);
		});

		// Bind upload button to show media uploader
		jQuery('.layerslider_upload_input').live('click', function() {
			uploadInput = this;
			jQuery('.draggable iframe, .draggable embed, .draggable object').hide();
			tb_show('', 'media-upload.php?post_id=0&type=image&amp;TB_iframe=true&width=650&height=400');
			return false;
		});
		
		
		// Bind submit event
		jQuery('.layerslider_form').live('submit', function(e) {
			e.preventDefault();
			layerSlider.submit(this);
		});
		
		
		layerSlider.addSortables();
		
		jQuery('input[name="top"],input[name="left"]').live('keyup', function() {

			// Get top value
			var position = jQuery(this).val();
			
			if(position.indexOf('px') == -1 && position.indexOf('%') == -1) {
				position = position + 'px';
			}

			// Get image src
			var index = jQuery(this).closest('tr').index() - 1;
			
			// Get container
			var container = jQuery(this).closest('.layerslider_slides').find('.draggable');

			// Reposition the image
			
			var sl = container.children().eq(index);

			if(jQuery(this).attr('name') == 'top') {
				if( position.indexOf('%') != -1 ){
					sl.css({
						top : container.height() / 100 * parseInt(position) - sl.outerHeight() / 2
					});
				}else{
					container.children().eq(index).css('top', position);
				}
			} else {
				if( position.indexOf('%') != -1 ){
					sl.css({
						left : container.width() / 100 * parseInt(position) - sl.outerWidth() / 2
					});
				}else{
					container.children().eq(index).css('left', position);
				}
			}
		});


		// Bind layer select event
		jQuery('.layerslider-layer-select').live('click', function() {
			
			// Save clicked checkbox
			var checkbox = this;
			
			// Iterate over the checkboxes of the parent element
			jQuery(this).closest('table').find('.layerslider-layer-select').each(function() {
			
				// Leave checked the clicked element
				if(this == checkbox) {
					return true;
				}
				
				// Disable all the other checkboxes
				jQuery(this).attr('checked', false);
			});
			
			// Check the state of the checkbox
			if(jQuery(checkbox).attr('checked') == true || jQuery(checkbox).attr('checked') == 'checked') {
				
				// Hide other layers
				jQuery(checkbox).closest('.layerslider_slides').find('.draggable:first > *').css({ opacity : 0.4 });
				
				// Get selected layer's image property
				var index = jQuery(checkbox).closest('tr').index() -1;
				
				// Show the one that selected
				jQuery(checkbox).closest('.layerslider_slides').find('.draggable:first > *').eq(index).css({ opacity : 1, zIndex : 100 });
				
			} else {

				// Show all the layers
				jQuery(checkbox).closest('.layerslider_slides').find('.draggable:first > *').each(function(index) {
					
					jQuery(this).css({ opacity : 1, zIndex : (index+1) });
				})
			}
		});
		
		// Bind remove layer event
		jQuery('.layerslider_slides .remove').live('click', function(e) {
			e.preventDefault();
			layerSlider.removeSubLayer(this);
		});
		
		layerSlider.addDrag();
		
		// Create tabs
		$tabs = jQuery('#layerslider-tabs').tabs({
		
			tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close'>X</span></li>"
		});
		
		// Remove tabs
		jQuery('#layerslider-tabs span.ui-icon-close').live('click', function() {
			if(confirm('Are you sure to remove this slider?')) {
				
				// Get sliderkey
				var index = jQuery(this).closest('li').index();

				jQuery.post( ajaxurl, { action : 'layerslider_removeslider', key : index }, function(data) {
					window.location.reload(true);
				});
			}
		});
		
		// Add tabs
		jQuery('#layerslider-add-tab').click(function(e) {
			
			// Prevent browser default submisson
			e.preventDefault();
			
			// Get next index
			var counter = jQuery('#layerslider-tabs ul:first li').length + 1;
			
			// Add the tab
			$tabs.tabs('add', '#tabs-' + counter, '<i class="ls-hidden">LayerSlider </i>#' + counter );
			
			// Fill with content
			jQuery('#tabs-' + counter).html( jQuery('#layerslider-sample-tab').html() );
			
			// Set the sliderkey
			jQuery('#tabs-' + counter).find('input[name="sliderkey"]').val(counter - 1);
			
			// Layers sortable
	        jQuery('.layerslider_slides_wrapper').sortable({
				containment: 'parent',
				tolerance: 'pointer',
				disabled: true
	        });
	        
	        // Select the new tab
	        jQuery('.ui-tabs-nav').find('li').eq(counter - 1).find('a').eq(0).click();
		});
		
		
		// Remove layer
		jQuery('.layerslider_remove_layer').live('click', function(e) {
			e.preventDefault();
			if(confirm('Are you sure to remove this layer?')) {
				jQuery(this).closest('li').slideUp(function() {
					jQuery(this).remove();
				});
			}
		});
		
		// Update preview width
		jQuery('input[name="width"]').live('keyup', function() {

			// Get top value
			var width = jQuery(this).val();
			
			if(width.indexOf('px') == -1 && width.indexOf('%') == -1) {
				width = width + 'px';
			}		
		
			jQuery(this).closest('div').find('.draggable_wrapper').css('width', width );
			jQuery(this).closest('div').find('.draggable').css('width', '100%' );
			
			// Update preview
			jQuery(this).closest('.layerslider_tabs').find('.layerslider_slides').each(function() {
				layerSlider.updatePreview(jQuery(this).find('table:eq(1)'));
			});
		});

		// Update preview height
		jQuery('input[name="height"]').live('keyup', function() {

			// Get top value
			var height = jQuery(this).val();
			
			if(height.indexOf('px') == -1 && height.indexOf('%') == -1) {
				height = height + 'px';
			}	

			jQuery(this).closest('div').find('.draggable_wrapper').css('height', height );
			jQuery(this).closest('div').find('.draggable').css('height', '100%' );

			// Update preview
			jQuery(this).closest('.layerslider_tabs').find('.layerslider_slides').each(function() {
				layerSlider.updatePreview(jQuery(this).find('table:eq(1)'));
			});
		});
		
		// Disable text fields depending on content type
		jQuery('.layerslider_slides_wrapper > li table tr').each(function() {
			
			// Disable HTML and Style fields
			if( jQuery(this).find('select[name="type"] option:selected').val() == 'img') {
				jQuery(this).find('input[name="html"]').attr('disabled', true);
				jQuery(this).find('input[name="style"]').attr('disabled', true);
			
			// Disable image field
			} else {
				jQuery(this).find('input[name="image"]').attr('disabled', true);
			}
		});
		
		// Bind change event in type selects
		jQuery('select[name="type"]').live('change', function() {
			
			layerSlider.updatePreview( jQuery(this).closest('table') );
		});
		
		
		jQuery('input[name="html"]').live('keyup', function() {
		
			layerSlider.updatePreview( jQuery(this).closest('table') );
		});


		jQuery('input[name="style"]').live('keyup', function() {
		
			layerSlider.updatePreview( jQuery(this).closest('table') );
		});
		
		jQuery('.resize').live('focus', function(){
			jQuery(this).animate({
				width: 600
			}, 350 );
		});

		jQuery('.resize').live('blur', function(){
			jQuery(this).animate({
				width: 50
			}, 350 );
		});
		
/*		jQuery('#TB_closeWindowButton, #TB_closeWindowButton img').live('click', function() {
			jQuery('.draggable iframe, .draggable embed, .draggable object').show();
		});
*/
		jQuery('input[name="backgroundcolor"]').live('keyup', function() {
			jQuery(this).closest('table').next().find('.draggable').css('background-color', jQuery(this).val() );
		});
		
		jQuery('.layerslider_sort_layers').live('click',function(e) {
			
			e.preventDefault();

			if( jQuery(this).hasClass('reordering') ){
				jQuery(this).parent().find('.layerslider_slides_wrapper .layerslider_slides').each(function(){
					jQuery(this).css({
						border: 'none'
					});
					jQuery(this).find('h1:first').remove();
					jQuery(this).find('> *').show();
				});
				jQuery(this).parent().find('.layerslider_slides_wrapper').sortable( 'option', 'disabled', true );

				jQuery(this).html('Reorder Layers');
				jQuery(this).removeClass('reordering');
			}else{
				jQuery(this).parent().find('.layerslider_slides_wrapper .layerslider_slides').each(function(){
					jQuery(this).css({
						border: '2px dotted #777'
					});
					jQuery(this).find('> *').hide();
					jQuery('<h1>').css({
						paddingLeft: '10px',
						fontSize: '18px',
						color: '#555'
					}).html( jQuery(this).find('input[name="title"]').val() ).prependTo( jQuery(this) );
					jQuery('<i>').css({
						fontSize: '15px',
						fontWeight: 'normal',
						color: '#777'						
					}).html(' (drag this box to change order)').appendTo( jQuery(this).find('h1:first') );
				});

				jQuery(this).parent().find('.layerslider_slides_wrapper').sortable( 'option', 'disabled', false );
				jQuery(this).html('Finish Reordering Layers');
				jQuery(this).addClass('reordering');
			}
		});

        jQuery('.layerslider_slides_wrapper').sortable({
			containment: 'parent',
			tolerance: 'pointer',
			disabled: true
        });
        
        // BG reset
        jQuery('.layerslider-bg-reset').live('click', function(e) {

        	e.preventDefault();
        	if( jQuery(this).hasClass('empty') ) {
        		jQuery(this).prev().attr('value', '');
        		
        	} else {
        		jQuery(this).prev().attr('value', 'false');
        	}
        	
			if( jQuery(this).prev().is('input[name="background"]') ) {
					
				// Get the BG image input
				var bgimage = jQuery(this).closest('.layerslider_tabs').find('input[name="backgroundimage"]');
				
        		// Change the background if any
        		if( bgimage.val() != '') {
					
        			jQuery(this).closest('li').find('.draggable').css('background-image', 'url('+bgimage.val()+')');
        		} else {
        			jQuery(this).closest('li').find('.draggable').css('background-image', 'none');
        		}
        	}  
        	
        	
        	if( jQuery(this).prev().is('input[name="backgroundimage"]') ) {
				
				jQuery(this).closest('.layerslider_tabs').find('input[name="background"]').each( function() {
					
					if( jQuery(this).val() == '') {
						jQuery(this).closest('li').find('.draggable').css('background-image', 'none');
					}
				});   	
        	}  	
        });
        
        // Yourlogo style
        jQuery('input[name="yourlogostyle"]').live('keyup', function() {

        	// Get the slider container
        	var slider = jQuery(this).closest('.layerslider_tabs');
        	
        	// Get the style settings input
        	var settings = this;
        	
        	// Get the preview image
        	slider.find('.draggable_wrapper').children('img').each(function() {

        		// Apple new style settings
        		jQuery(this).attr('style', jQuery(settings).val() );
        	});
        });
        
        // Yourlogo reset
        jQuery('.layerslider-iebutton').live('click', function() {

        	// Get the slider container
        	var slider = jQuery(this).closest('.layerslider_tabs');
        	
        	// Find yourlogo images
        	slider.find('.draggable_wrapper').children('img').remove();
        });
        
        // Import export

        jQuery('#layerslider-iebutton').toggle(
        	function() {
        		jQuery('#layerslider-export').slideDown();
        	},
        	
        	function() {
        		jQuery('#layerslider-export').slideUp();
        	}
        );
        
        // Import form
        jQuery('#layerslider-import').submit(function(e) {
        	
        	// Prevent the default submission of the browser
        	e.preventDefault();
        	
			// Post the form
			jQuery.post( jQuery(this).attr('action'), jQuery(this).serialize(), function() {
				window.location.reload(true);
			});
        });

		// Adding .ls-adcanved classes

		var adv = layerSlider.g.advanced;

		jQuery('.layerslider_slides').each(function(){
			jQuery(this).find('table:eq(1) tr').each(function(){
				for(a=0;a<adv.length;a++){
					jQuery(this).find('td:eq('+adv[a]+'), th:eq('+adv[a]+')').addClass('ls-advanced');
				}
			});

			if( !jQuery(this).find('.layerslider-advanced-options input:checked').length ){
				layerSlider.toggleAdvanced( jQuery(this) );				
			}
		});

		jQuery('.layerslider-advanced-options input').live('click',function(){
			layerSlider.toggleAdvanced( jQuery(this).closest('.layerslider_slides') );
		});
	},
	
	toggleAdvanced : function(el, fade){
	
		el.find('.ls-advanced').each(function(){
			if( jQuery(this).hasClass('ls-hidden') ){
				var fadeTime = 1000;
				if( fade ){
					fadeTime = 1;
				}
				jQuery(this).removeClass('ls-hidden').show().fadeTo(fadeTime,1);
			}else{
				jQuery(this).addClass('ls-hidden').fadeTo(500,0,function(){
					jQuery(this).hide();
				});
			}
		});
	},
	
	updatePreview : function(el) {

		// Remove all preview items
		jQuery(el).closest('li').find('.draggable > *').remove();
		
		jQuery(el).find('tr').each(function(index) { 

			if(index == 0) {
				return true;
			}
			
			// Get type val
			var type = jQuery(this).find('select[name="type"] option:selected').val();

			// Disable HTML and Style fields
			if( type == 'img') {
				
				// Re-enable all fields
				jQuery(this).find('input,select').attr('disabled', false);
				
				// Disable certain fields
				jQuery(this).find('input[name="html"]').attr('disabled', true);
				jQuery(this).find('input[name="style"]').attr('disabled', true);
				
				// Update the preview
				
					// Get the index
					var index = jQuery(this).index() - 1;
			
					// Get the preview container
					var container = jQuery(this).closest('.layerslider_slides').find('.draggable');
					
					// Get target element if any
					var target = container.children().eq(index);
					
					// Append the image if any
//					if( jQuery(this).find('input[name="image"]').val() != '') {
						
						// Append
						var clone = jQuery('<img>').appendTo(container).attr('src', jQuery(this).find('input[name="image"]').val());
						
						// Style settings
							
						var sll = jQuery(this).find('input[name="left"]').val();
						var slt = jQuery(this).find('input[name="top"]').val();

						if( jQuery.browser.msie || jQuery.browser.opera ){
							
							if( sll.indexOf('%') != -1 ){
								clone.css({
									left : clone.parent().width() / 100 * parseInt(sll) - clone.outerWidth() / 2
								});
							}else{
								clone.css({ left : parseInt(sll) });
							}

							if( slt.indexOf('%') != -1 ){
								clone.css({
									top : clone.parent().height() / 100 * parseInt(slt) - clone.outerHeight() / 2
								});
							}else{
								clone.css({ top : parseInt(slt) });
							}
						}else{
							
							clone.load(function(){

								if( sll.indexOf('%') != -1 ){
									clone.css({
										left : clone.parent().width() / 100 * parseInt(sll) - clone.outerWidth() / 2
									});
								}else{
									clone.css({ left : parseInt(sll) });
								}

								if( slt.indexOf('%') != -1 ){
									clone.css({
										top : clone.parent().height() / 100 * parseInt(slt) - clone.outerHeight() / 2
									});
								}else{
									clone.css({ top : parseInt(slt) });
								}
							});
						}

						clone.css('z-index', index + 1);
						
						// Add dragging
						layerSlider.addDrag();
						
						// Remove target
						target.remove();
//					}
					
			// Disable image field
			} else {
		
				// Re-enable all fields
				jQuery(this).find('input,select').attr('disabled', false);
				
				// Disable certain fields
				jQuery(this).find('input[name="image"]').attr('disabled', true);
				
				// Update the preview

					// Get the index
					var index = jQuery(this).index() - 1;
					
					// Get the preview container
					var container = jQuery(this).closest('.layerslider_slides').find('.draggable');
					
					// Get target element if any
					var target = container.children().eq(index);
					
					// Append html code 
						
						// Get type
						var type = jQuery(this).find('select[name="type"] option:selected').val();

						// Get HTML
						var html = jQuery(this).find('input[name="html"]').val();
			
						// Get style settings
						var style = jQuery(this).find('input[name="style"]').val();
						
						// Append the element
						var clone = jQuery('<'+type+'>').appendTo(container).html(html).attr('style', style);
						
						// Style settings

						var sll = jQuery(this).find('input[name="left"]').val();
						var slt = jQuery(this).find('input[name="top"]').val();

						if( sll.indexOf('%') != -1 ){
							clone.css({
								left : clone.parent().width() / 100 * parseInt(sll) - clone.outerWidth() / 2
							});
						}else{
							clone.css({ left : parseInt(sll) });
						}

						if( slt.indexOf('%') != -1 ){
							clone.css({
								top : clone.parent().height() / 100 * parseInt(slt) - clone.outerHeight() / 2
							});
						}else{
							clone.css({ top : parseInt(slt) });
						}

						clone.css('z-index', index + 1);
						
						// Add dragging
						layerSlider.addDrag();

						// Remove target
						target.remove();
			}
		});
	},
	
	addSortables : function() {
	
		// Bind sortable function
        jQuery('.sortable').sortable({
			sort : function(event, ui){
				layerSlider.g.dragContainer = jQuery('.ui-sortable-helper').closest('li').find('.draggable');
				layerSlider.g.subLayers = jQuery('.ui-sortable-helper').closest('table');
			},
			stop : function(event, ui) {
				layerSlider.updatePreview( layerSlider.g.subLayers );
            },
            containment : 'parent',
			handle : '.moveable',
			items : 'tr:not(:first)',
			tolerance : 'pointer'
        });	
	},
	
	addDrag : function(el) {
		
		if(!el){
			var el = jQuery('.draggable')
		}
        // Bind dragable function
        el.children().draggable({
        	drag : function() {
        		
        		layerSlider.dragging();
        	},
        	stop : function() {

        		layerSlider.dragging();
        	}
        });
	},
	
	dragging : function() {

		var top = jQuery('.ui-draggable-dragging').position().top;
		var left = jQuery('.ui-draggable-dragging').position().left;
		
		var image = jQuery('.ui-draggable-dragging').index()+1;
		
		jQuery('.ui-draggable-dragging').closest('.layerslider_slides').find('.sortable tr:eq('+image+') input[name="top"]').val(top);
		jQuery('.ui-draggable-dragging').closest('.layerslider_slides').find('.sortable tr:eq('+image+') input[name="left"]').val(left);
	},

	addSlide : function(button) {
		
		// Clone the template element
		var clone = jQuery('#layerslider_slides_code li:first').clone();
		
		// Find cointainer to append to
		var eleme = jQuery(button).prev();
		
		// Append new slide
		var append = jQuery(clone).appendTo(eleme).hide();
		
		// Get preview size settings
		var width = jQuery(button).prev().prev().find('input[name="width"]').val();
		var height = jQuery(button).prev().prev().find('input[name="height"]').val();
		
		// Set preview size
		jQuery(append).find('.draggable').width(width);
		jQuery(append).find('.draggable').height(height);

		jQuery(append).find('.draggable_wrapper').width(width);
		jQuery(append).find('.draggable_wrapper').height(height);
	
		// Add slide title
		jQuery(append).find('input[name="title"]').val('Layer #' + (jQuery(append).index() + 1) );
		
		// Set preview background options
		jQuery(append).find('.draggable').css('background-color', jQuery(append).closest('div').find('input[name="backgroundcolor"]').val() );
		jQuery(append).find('.draggable').css('background-image', 'url('+jQuery(append).closest('div').find('input[name="backgroundimage"]').val()+')');
		
		// Add sorables
		layerSlider.addSortables();
		
		// Show the new slide
		jQuery(append).slideDown(function(){
			
			// Set width
			jQuery(this).css({
				width : jQuery(this).find('table:eq(1)').outerWidth(true)
			});
		});		
	},

	addSublayer : function(ele) {
		
		var clone = jQuery('#layerslider_slides_code .layerslider_sublayer:first').clone();
		var eleme = jQuery(ele).closest('.layerslider_slides').find('table:eq(1)');
		
		if( jQuery(ele).closest('.layerslider_slides').find('.layerslider-advanced-options input:checked').length ){
			layerSlider.toggleAdvanced( clone, 'nofade' );
		}
		
		jQuery(clone).appendTo(eleme).hide().slideDown();
	},
	
	removeSubLayer : function(ele) {
		
		// Get layer index
		var index = jQuery(ele).closest('tr').index() - 1;

		// Remove layer from preview
		jQuery(ele).closest('.layerslider_slides').find('.draggable > *').eq(index).remove();
		
		// Remove layer row
		jQuery(ele).closest('tr').remove();

		layerSlider.updatePreview();
	},
	
	makeResponsive : function(ele) {

		if( jQuery(ele)[0].style.left.indexOf('%') != -1 ){
		    jQuery(ele).css({
		    	left : jQuery(ele).parent().width() / 100 * parseInt( jQuery(ele)[0].style.left ) - jQuery(ele).outerWidth() / 2
		    });
		}
		if( jQuery(ele)[0].style.top.indexOf('%') != -1 ){
		    jQuery(ele).css({
		    	top : jQuery(ele).parent().height() / 100 * parseInt( jQuery(ele)[0].style.top ) - jQuery(ele).outerHeight() / 2
		    });			
		}	
	},
	
	submit : function(ele) {

		// Set to disabled the submit button to prevend malformed data conversion
		jQuery(ele).find('input[type="submit"]').attr('disabled', true);

			
			// Iterate over the slide properties
			jQuery(ele).find('.form-table input, .form-table textarea, .form-table select').each(function() {
				
				// Save slide properties
				jQuery(this).attr('name', 'layerslider-slides[properties]['+jQuery(this).attr('name')+']');
			});
			
			// Iterate over the main layers
			jQuery(ele).find('.layerslider_slides_wrapper > li').each(function(layer) {
			    
			    // Save main layer properties
			    jQuery(this).find('table:first input, table:first select').each(function() {
			    	jQuery(this).attr('name', 'layerslider-slides[layers]['+layer+'][properties]['+jQuery(this).attr('name')+']');
			    });
			    
			    // Save the advanced settings state
			    var advanced = jQuery(this).find('table:first').next().next().find('input[name="advanced_options"]');
			    	advanced.attr('name', 'layerslider-slides[layers]['+layer+'][properties]['+jQuery(advanced).attr('name')+']');
			    	
			    // Iterate over the slides
			    jQuery(this).find('table:eq(1) tr').each(function(sublayer) {
			    	
			    	// Save slides properties
			    	jQuery(this).find('input, select').each(function() {
			    		jQuery(this).attr('name', 'layerslider-slides[layers]['+layer+'][sublayers]['+sublayer+']['+jQuery(this).attr('name')+']');
			    	});
			    });
			});

		
		// Post the form
		jQuery.post( jQuery(ele).attr('action'), jQuery(ele).serialize(), function() {
			window.location.reload(true);
		});

		
		//ele.submit();
	}
};


jQuery(document).ready(function() {
	
	// Bind an event to image url insert
	window.send_to_editor = function(html) {
		
		var img = jQuery('img',html).attr('src');
		
		jQuery(uploadInput).val( img );
		tb_remove();
		jQuery('.draggable iframe, .draggable embed, .draggable object').show();
		
		var container = jQuery(uploadInput).closest('.layerslider_slides').find('.draggable');
		
		// If it is a background image, change in the preview
		if(jQuery(uploadInput).is('input[name="background"]')) {
			container.css('background-image', 'url('+img+')');
		
		} else if(jQuery(uploadInput).is('input[name="backgroundimage"]')) {
		
			// Iterate over the layers
			jQuery(uploadInput).closest('table').next().find('.layerslider_slides').each(function() {
			
				// Check if theres a local bg image
				if(jQuery(this).find('input[name="background"]').val() == '') {
					jQuery(this).find('.draggable').css('background-image', 'url('+jQuery(uploadInput).val()+')');
				}
			});
			
		
		} else if(jQuery(uploadInput).is('input[name="yourlogo"]')) {
			
			// Remove old yourlogo image
			jQuery(uploadInput).closest('.layerslider_tabs').find('.layerslider-yourlogo-img').remove();
			
			// Append the new one
			var yourlogo = jQuery('<img>').attr('src', img).prependTo( jQuery(uploadInput).closest('.layerslider_tabs').find('.draggable_wrapper') );
			
			// Apply style settings
			yourlogo.attr('style', jQuery(uploadInput).closest('.layerslider_tabs').find('input[name="yourlogostyle"]').val() );
		
		// Show the new layer
		} else {

			// Get row index
			var index = jQuery(uploadInput).closest('tr').index() - 1;
			
			// Check container for row element
			// Update image src when found
			if(jQuery(container).find('img').eq(index).length) {
				
				jQuery(container).find('img').eq(index).attr('src', img);
			
			// Insert as new layer
			} else {
			
				// Add the new layer and set properties
				var ele = jQuery('<img>').appendTo(container).attr('src', img);
					ele.css({ 'position' : 'absolute', top : 0, left : 0, 'z-index' : (jQuery(ele).index()+1) });
			
				// Reinit dragable content
				layerSlider.addDrag(container);
			}
		}
	}

	// set width of .layerslider_slides
	
	jQuery('.layerslider_slides:gt(0)').each(function(){
		jQuery(this).css({
			width : jQuery(this).find('table:eq(1)').outerWidth(true)
		});
	});

	layerSlider.init();

	// make responsiveLayout
	jQuery('.draggable').children().each(function(){

		if( jQuery(this).is('img') && !jQuery.browser.opera && !jQuery.browser.msie ){
			jQuery(this).load(function(){
				layerSlider.makeResponsive(this);
			});
		}else{
			layerSlider.makeResponsive(this);			
		}
	});
	
	// minimize global settings
	jQuery('.ls-openclose').live('click',function(e){
		e.preventDefault();
		if( jQuery(this).hasClass('minimized') ){
			jQuery(this).removeClass('minimized').closest('.ls-global-table').animate({
				height: jQuery(this).closest('tbody').height()
			}, 750 );
		}else{
			jQuery(this).addClass('minimized').closest('.ls-global-table').find('td, th, tr, tbody').animate({
				height: 0
			}, 750 );
		}
	})
});