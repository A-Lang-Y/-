(function($) {
  	var form = $('#nav-menu-meta');
  	
  	var prices_filter = form.find('.prices');    
	var currency= form.find('#jigoshop_currency, #woocommerce_currency').val();
	var shop_url= form.find('#jigoshop_shop_url, #woocommerce_shop_url').val();
	var sep = ( shop_url.indexOf("?") === -1 ) ? "?" : "&";
  	
  	prices_filter.find('.submit-add-to-menu').bind('click', function(){
	                                                           
		var from    = form.find('#prices_filter_from').val();
		var to 		= form.find('#prices_filter_to').val(); 
		var permalink = shop_url + sep + 'max_price=' + to + '&min_price=' + from;
		var title = from + ' - ' + to + ' ' + currency; 
// 		prices_filter.find('input[name="menu-item[-1][menu-item-url]"]').val( shop_url + sep + 'max_price=' + to + '&min_price=' + from );
// 		prices_filter.find('input[name="menu-item[-1][menu-item-title]"]').val( from + ' - ' + to + ' ' + currency );	
	
		menuItem = {
			'-1': {
				'menu-item-type': 'custom',
				'menu-item-url': permalink,
				'menu-item-title': title,
				'menu-item-db-id': 0,
				'menu-item-parent-id': 0
			}
		}
		
		var img = prices_filter.find('img.waiting').show();
		
		wpNavMenu.addLinkToMenu(permalink, title, false, function() {
			img.hide();
		});
	
	});

//   	form.find('.add-prices-filter-item-menu').bind('click', function(e) {
// 		var processMethod = form.find('.prices');
// 		var from    = form.find('#prices_filter_from').val();
// 		var to 		= form.find('#prices_filter_to').val();   
// 		var currency= form.find('#jigoshop_currency').val();
// 		var title   = from + ' - ' + to + ' ' + currency;
// 		var shop_url= form.find('#jigoshop_shop_url').val();
// 		var sep = ( shop_url.indexOf("?") === -1 ) ? "?" : "&";
// 		var permalink   = shop_url + sep + 'max_price=' + to + '&min_price=' + from;            
// 		var type;
// 		
// 		var img = form.find('img.waiting').show();
// 	
// 		menuItem = {
// 			'-1': {
// 				'menu-item-type': 'custom',
// 				'menu-item-url': permalink,
// 				'menu-item-title': title,
// 				'menu-item-db-id': 0,
// 				'menu-item-parent-id': 0
// 			}
// 		}
// 		
// 		wpNavMenu.addItemToMenu(menuItem, processMethod, function() {
// 			img.hide();
// 		});
// 		
// 		return false;
//   	});
})(jQuery);
