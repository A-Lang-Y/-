jQuery(document).ready(function($){

	/**
	 *  CloudFw UI - Menu Options Loader
	 *
	 *  @since 4.0
	 */
	jQuery(document).delegate('.cloudfw-ui-menu-options-handler-link', 'click', function() {
		var that = jQuery(this);
		
		if ( that.hasClass('disabled') ) {
			return false;
		}

		that.addClass('disabled');

		var handler            	= that.parent(),
			container           = handler.parent(),
			options             = container.find('.cloudfw-ui-menu-options-content'),
			id            		= that.attr('data-id'),
			location            = that.attr('data-location');

		var ajaxForm_vars = {
			action: 'cloudfw_load_menu_options',
			nonce: CloudFwOp.cloudfw_nonce,
			id: id,
			location: location
		};

		var loading = that.clone().insertAfter( that );
		loading.undelegate('click').find('span').html('Loading... Please wait');
		that.hide();

		jQuery.ajax({
			url: CloudFwOp.ajaxUrl,
			cache: false,
			type: "POST",
			data: (jQuery.param(ajaxForm_vars, true)),
			success: function(data) {
				handler.hide();
				options.html( data );
				cloudfw_main(options);
			}

		});

	});

} );