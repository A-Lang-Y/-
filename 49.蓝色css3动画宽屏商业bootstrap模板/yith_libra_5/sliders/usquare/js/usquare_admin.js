var colPickerOn = false,
	colPickerShow = false;

(function($){

function apply_color_plugin()
{

	$('.cw-color-picker').each(function(){
		var $this = $(this),
			id = $this.attr('rel');
 
		$this.farbtastic('#' + id);
		$this.click(function(){
			$this.show();
		});
		$('#' + id).click(function(e){
			e.preventDefault();
			$('.cw-color-picker:visible').hide();
			$('#' + id + '-picker').show();
			colPickerOn = true;
			colPickerShow = true;
			return false;
		});
		$this.click(function(){
			colPickerShow = true;	
		});
		
	});
	$('body').click(function(){
		if(colPickerShow) colPickerShow = false;
		else {
			colPickerOn = false;
			$('.cw-color-picker:visible').hide();
		}
	});
}

$(document).ready(function(){	
	var	pluginUrl = $('#plugin-url').val(),
		timthumb = pluginUrl + 'timthumb/timthumb.php';

	apply_color_plugin();

	// IMAGE UPLOAD
	var thickboxId =  '',
		thickItem = false; 
	
	// background images
	$('.cw-image-upload').click(function(e) {
		e.preventDefault();
		thickboxId = '#' + $(this).attr('id');
		formfield = $(thickboxId + '-input').attr('name');
		//alert('background');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	

	window.send_to_editor = function(html) {
		imgurl = $('img',html).attr('src');
		$(thickboxId + '-input').val(imgurl);
		if (thickItem) {
			thickItem = false;
			//var newWidth = $(thickboxId).parent().width()-40;
			//var newHeight = $(thickboxId).parent().height();
			//$(thickboxId).attr('src', timthumb + '?src=' + imgurl + '&w='+newWidth+'&'+newHeight);
			//alert (thickboxId);
			var dimens;
			if (thickboxId.indexOf('background')==-1) dimens='&w=180&h=125';
			else dimens='&w=180&h=50';
			$(thickboxId).attr('src', timthumb + '?src=' + imgurl + dimens);
		}
		else {
			$(thickboxId).css('background', 'url('+imgurl+') repeat');
		}
		tb_remove();
	}
	
	$('.remove-image').click(function(e){
		e.preventDefault();
		$(this).parent().parent().find('input').val('');
		$(this).parent().parent().find('.cw-image-upload').css('background-image', 'url(' + pluginUrl + '/images/no_image.jpg)');
	});

	// CATEGORIES
	if ($('#cat-type').val() == 'categories') {
		$('.cat-display').show();
		$('.data_id').css('color', 'gray');
	}
	else {
		$('.category_id').css('color', 'gray');
	}
	$('#cat-type').change(function(){
		if ($(this).val() == 'months') {
			$('.cat-display').hide();
			$('.category_id').css('color', 'gray');
			$('.data_id').css('color', '');
			alert('Check the Date field of your items before you save!');
		}
		else {
			$('.cat-display').show();
			$('.data_id').css('color', 'gray');
			$('.category_id').css('color', '');
			alert('Check the Category field of your items, and pick categoryes you want to show before you save!');
		}
	});
	
	$('#cat-check-all').click(function(){
		$('.cat-name').attr('checked', true);
	});
	
	$('#cat-uncheck-all').click(function(){
		$('.cat-name').attr('checked', false);
	});
	
	
	// SORTABLE
	
	$('#usquare-sortable').sortable({
		placeholder: "tsort-placeholder"
	});
	
	//---------------------------------------------
	// usquare Sortable Actions
	//---------------------------------------------
	
	// add
	$('#tsort-add-new').click(function(e){
		e.preventDefault();
		usquareAddNew(pluginUrl);
	});
	$('#tsort-add-new2').click(function(e){
		e.preventDefault();
		usquareAddNew2(pluginUrl, 1);
	});
	$('#tsort-add-new3').click(function(e){
		e.preventDefault();
		usquareAddNew2(pluginUrl, 2);
	});

	// open item
	$('.tsort-plus').live('click', function(){
		if (!$(this).hasClass('open')) {
			$(this).addClass('open');
			$(this).html('-').css('padding', '5px 8px');
			$(this).next().next('.tsort-content').show();
		}
		else {
			$(this).removeClass('open');
			$(this).html('+').css('padding', '7px 5px');
			$(this).next().next('.tsort-content').hide();
		}
	});
	// delete
	$('.tsort-delete').live('click', function(e){
		e.preventDefault();
		$(this).parent().parent().remove();
	});
	
	$('.tsort-remove').live('click', function(e){
		e.preventDefault();
		$(this).parent().find('input').val('');
		$(this).parent().find('img').attr('src', pluginUrl + '/images/no_image.jpg');
	});
	
	
	// item images
	$('.tsort-change').live('click', function(e) {
		e.preventDefault();
		thickItem = true;
		thickboxId = '#' + $(this).parent().find('img').attr('id');
		//alert('image');
		formfield = $(thickboxId + '-input').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	
	// item images
	$('.tsort-start-item').live('click', function(e) {
		$('.tsort-start-item').attr('checked', false);
		$(this).attr('checked', 'checked');
	});
	
	// ----------------------------------------
	
	// AJAX subbmit
	$('#save-usquare').click(function(e){
	e.preventDefault();
		$('#save-loader').show();
		$.ajax({
			type:'POST', 
			url: 'admin-ajax.php', 
			data:'action=usquare_save&' + $('#post_form').serialize(), 
			success: function(response) {
				$('#usquare_id').val(response);
				$('#save-loader').hide();
				$('.form_result').html('<div style="background-color: #FFF607; border: 1px solid #FFDD05; padding: 5px; margin-bottom: 5px;">Saved</div>')
				setTimeout(function(){
					$('.form_result').fadeOut('slow', function(){
						$('.form_result').html('');
						$('.form_result').show();
					});
				}, 3000);
			}
		});
	});
	
	$('#preview-usquare').click(function(e){
		e.preventDefault();
		var html = '<div id="TBct_overlay" class="TBct_overlayBG"></div>';
		html += '<div id="TBct_window" style="width:250px; margin-left:-75px; height:80px; margin-top:-40px; visibility: visible;">';
		html += '<div id="TBct_title"><div id="TBct_ajaxWindowTitle">Preview</div>';
		html += '<div id="TBct_closeAjaxWindow"><a id="TBct_closeWindowButton" title="Close" href="#"><img src="'+pluginUrl+'/images/tb-close.png" alt="Close"></a></div>';
		html += '</div>';
		html += '<div id="usquareHolder" style="margin:0 auto;">';
		html += '<img style="margin:20px 20px;" id="TBct_loader" src="'+pluginUrl+'/images/loadingAnimation.gif" />';
		html += '</div>';
		html += '<div style="clear:both;"></div></div>';
		html += '</div>';
		$('body').append(html);
		var postForm = $('#post_form').serialize();
		$.ajax({
			type:'POST', 
			url: 'admin-ajax.php', 
			data:'action=usquare_preview&' + postForm, 
			success: function(response) {
				$('#TBct_loader').hide();
				$('#TBct_window').animate({width: '100%', marginLeft:'-50%', marginTop: '-250px', height: '500px'}, 500, function(){
					$('#usquareHolder').html(response);
					$('#usquareHolder').css({'overflow-y':'scroll', 'position': 'relative', 'width':'100%', 'height':'470px'});
				
					$('#preview-loader').hide();
					
					$('#TBct_closeWindowButton').click(function(ev){
						ev.preventDefault();
						$('#TBct_overlay').remove();
						$('#TBct_window').remove();
					});
				});
				
			}
		});
	});
	
	
});


function usquareSortableActions(pluginUrl) {
}

function usquareAddNew(pluginUrl) {
	usquareItem = usquareGenerateItem();
	$('#usquare-sortable').append(usquareItem);
	$('.tsort-start-item').eq($('.tsort-start-item').length-1).trigger('click').attr('checked', 'checked');
	apply_color_plugin();
	return;
}

function usquareGenerateItem(properties) {
	// set globals
	var pluginUrl = $('#plugin-url').val(),
		timthumb = pluginUrl + '/timthumb/timthumb.php';
	
	// calculate item number
	var itemNumber = 1;
	while($('#sort'+itemNumber).length > 0) {
		itemNumber++;
	}

	// get input properties
	var pr = $.extend({
		'itemTitle':			'Title',
		'itemContent':			'Content',
		'itemDescription':		'Description',
		'itemImage':			'',
		'background_color':		'#ef4939',
		'itemBackgroundImage':	''
	}, properties);
	
	// bring all the pieces together
	var itemHtml = '\n'+	
'					<li id="sort'+itemNumber+'" class="sortableItem">\n'+
'						<div class="tsort-plus open" style="padding: 5px 8px;">-</div>\n'+
'						<div class="tsort-header">Item '+itemNumber+' <small><i>- '+pr.itemTitle+'</i></small> &nbsp;<a href="#" class="tsort-delete"><i>delete</i></a></div>\n'+
'						<div class="tsort-content" style="display: block;">\n'+
'							<div class="tsort-content-left">\n'+
'							<table class="fields-group">'+
'							<tr class="field-row">'+
'								<td style="width: 130px;">'+
'								<label for="title">Title:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<input name="sort'+itemNumber+'-item-title" value="'+pr.itemTitle+'" type="text"  />'+
'								</td>'+
'							</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;">'+
'								<label for="description">Description:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<input name="sort'+itemNumber+'-item-description" value="'+pr.itemDescription+'" type="text"  />'+
'								</td>'+
'							</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;">'+
'								<label for="image">Image:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<div class="tsort-image"><img style="height: 125px; width:180px;" id="sort'+itemNumber+'-item-image" src="'+((pr.itemImage != '') ? timthumb + '?src=' + pr.itemImage + '&w=180&h=125' : pluginUrl + 'images/no_image.jpg')+ '" /><a href="#" id="sort'+itemNumber+'-item-image-change" class="tsort-change">Change</a>\n' +
'										<input id="sort'+itemNumber+'-item-image-input" name="sort'+itemNumber+'-item-image" type="hidden" value="'+pr.itemImage+'" />\n'+
'										<a href="#" id="sort'+itemNumber+'-item-image-remove" class="tsort-remove">Remove</a>\n'+
'									</div>'+
'								</td>'+
'							</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;">'+
'								<label for="content">Content:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'								<textarea class="tsort-contarea"  name="sort'+itemNumber+'-item-content">'+pr.itemContent+'</textarea>\n'+
'								</td>'+
'							</tr>'+
'							</table></div>'+
'							<div class="tsort-content-right">\n'+
'							<table class="fields-group">'+
'							<tr class="field-row">'+
'								<td style="width: 130px;">'+
'								<label for="background-color">Background color:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'								<input id="sort'+itemNumber+'-item-background-color" name="sort'+itemNumber+'-item-background-color" value="'+pr.background_color+'" type="text" style="background: '+pr.background_color+';">'+
'										<div class="cw-color-picker-holder" style="left:-70px;">'+
'											<div id="sort'+itemNumber+'-item-background-color-picker" class="cw-color-picker" rel="sort'+itemNumber+'-item-background-color"></div>'+
'										</div>'+
'								</td>'+
'							</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;">'+
'								<label for="image">Background image:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<div class="tsort-image" style="height: 50px; width:216px;"><img style="height: 50px; width: 180px;" id="sort'+itemNumber+'-item-background-image" src="'+((pr.itemBackgroundImage != '') ? timthumb + '?src=' + pr.itemBackgroundImage + '&w=180&h=50' : pluginUrl + 'images/no_image2.jpg')+ '" /><a href="#" id="sort'+itemNumber+'-item-background-image-change" class="tsort-change">Change</a>\n' +
'										<input id="sort'+itemNumber+'-item-background-image-input" name="sort'+itemNumber+'-item-background-image" type="hidden" value="'+pr.itemBackgroundImage+'" />\n'+
'										<a href="#" id="sort'+itemNumber+'-item-background-image-remove" class="tsort-remove">Remove</a>\n'+
'									</div>'+
'								</td>'+
'							</tr>'+

'								<tr class="field-row">'+
'									<td style="width: 130px;">'+
'										<label for="image-position">Image position:</label>'+
'									</td>'+
'									<td style="width: auto;">'+
'										<select name="sort'+itemNumber+'-item-image-position" >'+
'											<option value="0" selected="selected">Left</option>'+
'											<option value="1">Right</option>'+
'											<option value="2">Full space</option>'+
'										</select>'+
'									</td>'+
'								</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;"><span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>'+
'								<label for="facebook">Facebook:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<input name="sort'+itemNumber+'-item-facebook" value="" type="text"  />'+
'								</td>'+
'							</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;"><span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>'+
'								<label for="twitter">Twitter:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<input name="sort'+itemNumber+'-item-twitter" value="" type="text"  />'+
'								</td>'+
'							</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;"><span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>'+
'								<label for="linkedin">LinkedIn:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<input name="sort'+itemNumber+'-item-linkedin" value="" type="text"  />'+
'								</td>'+
'							</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;"><span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>'+
'								<label for="pinterest">Pinterest:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<input name="sort'+itemNumber+'-item-pinterest" value="" type="text"  />'+
'								</td>'+
'							</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;"><span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>'+
'								<label for="yahoo">Yahoo:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<input name="sort'+itemNumber+'-item-yahoo" value="" type="text"  />'+
'								</td>'+
'							</tr>'+
'							<tr class="field-row">'+
'								<td style="width: 130px;"><span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>'+
'								<label for="digg">Digg:</label>'+
'								</td>'+
'								<td style="width: auto;">'+
'									<input name="sort'+itemNumber+'-item-digg" value="" type="text"  />'+
'								</td>'+
'							</tr>'+
'							</table></div>\n'+
'							<div class="clear"></div>'+
'						</div>\n'+
'					</li>\n';
	return itemHtml;
}


var usquare_selected=0;
function usquareAddNew2(pluginUrl, type) {
	var display1, display2, win_height;
	var searches = new Array();
	usquare_selected=type;
	if (type==1) {
		display1='display: block';
		display2='display: none';
		win_height=250;
	}
	if (type==2) {
		display1='display: none';
		display2='display: block';
		win_height=80;
	}
	searches[''] = '';
	var html = '<div id="TBct_overlay" class="TBct_overlayBG"></div>';
	html += '<div id="TBct_window" style="width:450px; margin-left:-225px; margin-top:-35px; height:'+win_height+'px; visibility: visible;">';
	html += '<div id="TBct_title"><div id="TBct_ajaxWindowTitle">Add new uSquare item</div>'
	html += '<div id="TBct_closeAjaxWindow"><a id="TBct_closeWindowButton" title="Close" href="#"><img src="'+pluginUrl+'/images/tb-close.png" alt="Close"></a></div>';
	html += '</div>';
	// html += '<select id="TBct_usquareSelect" style="margin:10px; width:150px;"><option value="new">Add New</option><option value="post">From Post</option><option value="category">Whole Category</option></select>';
	html += '<div id="TBct_usquareFromPost" style="padding:10px; border-top:1px solid gray; '+display1+';"><label for="usquareFromPost">Search posts:</label> <span id="usquareFromPostHolder"><input id="usquareFromPost" name="usquareFromPost" style="width:260px;"/><a href="#" style="margin:0px;" class="button button-highlighted alignright TBct_usquareSubmit">Add</a><img id="usquareFromPostLoader" src="'+pluginUrl+'/images/ajax-loader.gif" /> <ul style="display:none;" id="usquareFromPostComplete"></ul></span>';
	html += '</div>';

	html += '<div id="TBct_usquareWholeCategory" style="padding:10px; border-top:1px solid gray; '+display2+';">';
	html += '<label for="TBct_usquareCategorySelect">Pick category:</label> <select style="width:200px" id="TBct_usquareCategorySelect" name="TBct_usquareCategorySelect">'
	var allCats = $('#categories-hidden').val();
	allCats = allCats.split('||');
	for (cate in allCats) {
		html += '<option value="'+allCats[cate]+'">'+allCats[cate]+'</option>';
	}
	
	html += '</select><a href="#" style="margin:0px;" class="button button-highlighted alignright TBct_usquareSubmit">Add</a><img id="TBct_usquareSubmitLoader" class="alignright" style="margin:4px;" src="'+pluginUrl+'/images/ajax-loader.gif" />';
	html += '</div>';
	html += '</div>';
	$('body').prepend(html);
	
	if (usquare_selected==1) $('#usquareFromPost').focus();
	

	$('#TBct_closeWindowButton').click(function(e){
		e.preventDefault();
		$('#TBct_overlay').remove();
		$('#TBct_window').remove();
	});
	
/*
	$('#TBct_usquareSelect').change(function(){
		if ($(this).val() == 'new') {
			$('#TBct_window').css({marginTop:'-35px', height:'70px'});
			$('#TBct_usquareFromPost').hide();
			$('#TBct_usquareWholeCategory').hide();
		}
		if ($(this).val() == 'category') {
			$('#TBct_window').css({marginTop:'-60px', height:'120px'});
			$('#TBct_usquareWholeCategory').show();
			$('#TBct_usquareFromPost').hide();
		}
		else {
			$('#TBct_window').css({marginTop:'-150px', height:'300px'});
			$('#TBct_usquareFromPost').show();
			$('#TBct_usquareWholeCategory').hide();
		}	
	});
*/	
	$('.TBct_usquareSubmit').click(function(e){
		e.preventDefault();
		var usquareItem = '';
/*		if ($('#TBct_usquareSelect').val() == 'new') {
			usquareItem = usquareGenerateItem();
			$('#usquare-sortable').append(usquareItem);
			$('.tsort-start-item').eq($('.tsort-start-item').length-1).trigger('click').attr('checked', 'checked');
			$('#TBct_overlay').remove();
			$('#TBct_window').remove();
		}
		else*/
		if (usquare_selected==2) {
			var sdata='action=usquare_post_category_get&cat_name='+$('#TBct_usquareCategorySelect').val();
			$('#TBct_usquareSubmitLoader').show();
			$.ajax({
				url:"admin-ajax.php",
				type:"POST",
				data:sdata,
				
				success:function(results){
					var resultsArray = results.split('||');
					var ii = 0;
					while (typeof resultsArray[0+ii] != 'undefined') {
							
						var properties = {
							'itemTitle' : resultsArray[0+ii],
							'itemContent' : resultsArray[3+ii],
							'itemImage' : resultsArray[4+ii],
							'itemDescription' : resultsArray[2+ii]
							}
						usquareItem = usquareGenerateItem(properties);
						$('#usquare-sortable').append(usquareItem);
						ii +=6;
					}
					$('.tsort-start-item').eq($('.tsort-start-item').length-1).trigger('click').attr('checked', 'checked');
					$('#TBct_overlay').remove();
					$('#TBct_window').remove();
				}
			});
		}
		
/*		else if($('#usquareFromPostComplete li a.active').length < 1) {
			alert('You have to select post you want to add, or choose add new!');
		}*/
		else if (usquare_selected==1) {
			var postId = $('#usquareFromPostComplete li a.active').attr('href');
			$('#TBct_usquareSubmitLoader').show();
			$.ajax({
				url:"admin-ajax.php",
				type:"POST",
				data:'action=usquare_post_get&post_id='+postId,
				
				success:function(results){
					var resultsArray = results.split('||');
					var properties = {
						'itemTitle' : resultsArray[0],
						'itemContent' : resultsArray[3],
						'itemImage' : resultsArray[4],
						'itemDescription' : resultsArray[2]
						}
					usquareItem = usquareGenerateItem(properties);
					$('#usquare-sortable').append(usquareItem);
					$('.tsort-start-item').eq($('.tsort-start-item').length-1).trigger('click').attr('checked', 'checked');
					$('#TBct_overlay').remove();
					$('#TBct_window').remove();
				}
			});
		}
		
	})
	
	$('#usquareFromPost').keyup(function(e){
		var icall = null,
			qinput = $('#usquareFromPost').val();
		
		if(qinput in searches) {
			if(icall != null) icall.abort();
			$('#usquareFromPostComplete').html(searches[qinput]).show();
			$('#usquareFromPostComplete li a').click(function(e){
				e.preventDefault();
				$('#usquareFromPostComplete li a.active').removeClass('active');
				$(this).addClass('active');
			});
			$('#usquareFromPostLoader').hide();
		}
		else {
			$('#usquareFromPostLoader').show();
			if(icall != null) icall.abort();
			icall = $.ajax({
				url:"admin-ajax.php",
				type:"POST",
				data:'action=usquare_post_search&query='+qinput,
				
				success:function(results){
					$('#usquareFromPostComplete').html(results).show();
					searches[qinput] = results;
					$('#usquareFromPostComplete li a').click(function(e){
						e.preventDefault();
						$('#usquareFromPostComplete li a.active').removeClass('active');
						$(this).addClass('active');
					});
					$('#usquareFromPostLoader').hide();
				}
			});
		}
	});
}


})(jQuery)

