$(window).load(function() {
	
	
// page resize response
$(window).resize(function() {
resizeDelay(function(){
  $('#filterOptionsGallery li.active a').trigger('click');
}, 200);
});
	
  var QSandAnimationStart = true;
  // get the action filter option item on page load
  var $filterType = $('#filterOptionsGallery li.active a').attr('class');
	
  // get and assign the ourHolder element to the
	// $holder varible for use later
  var $holder = $('ul.ourHolderGallery');
  

  $holder.find('li').each(function(){
  	var hImg = $(this).find('img');
  	$(this).css('width', hImg.width());
  	$(this).css('height', hImg.height());
  });
  // clone all items within the pre-assigned $holder element
  var $data = $holder.clone();
  
  $holder.masonry({
	itemSelector : '.item',
	columnWidth : 242
});
		
		$("img.lazy").lazyload({
			effect : "fadeIn"
		});
  
  
  var $currentImage;
  // attempt to call Quicksand when a filter option
	// item is clicked
	$('#filterOptionsGallery li a').click(function(e) {
		e.preventDefault();
		
	
	
		// reset the active class on all the buttons
		$('#filterOptionsGallery li').removeClass('active');
		
		// assign the class of the clicked filter option
		// element to our $filterType variable
		var $filterType = $(this).attr('class');
		$(this).parent().addClass('active');
		
		
		if ($filterType == 'all') {
			// assign all li items to the $filteredData var when
			// the 'All' filter option is clicked
			var $filteredData = $data.find('li');
		} 
		else {
			// find all li elements that have our required $filterType
			// values for the data-type element
			var $filteredData = $data.find('li[data-type~=' + $filterType + ']');
			
		}
		
		$('body').append('<div id="filteredDataHolder" style="height:0; overflow:hidden;"><ul id="filterMasonary" class="ourHolderGallery" style="width:'+($('#content').width()+8)+'px"></ul></div>');
		var $filterMasonary = $('#filterMasonary');
		$filteredData.each(function(){
			$filterMasonary.append($(this).clone());
		});
		
		$filterMasonary.masonry({
			itemSelector : '.item',
			columnWidth : 242
		});
		$filterMasonary = $('#filterMasonary').clone();
		$('#filteredDataHolder').remove();
		$holder.animate({height : $filterMasonary.height()}, 400);
		$data.find('li').each(function(){
		
			$replacement = $filterMasonary.find('li[data-id~=' + $(this).attr('data-id') + ']');
			$replacement.hide();
			$moving = $holder.find('li[data-id~=' + $(this).attr('data-id') + ']');
			
			// dont lazyload loaded images
			if($moving.html() != null) {
				if ($moving.find('img').attr('src') == $moving.find('img').attr('data-original')) {
					$moving.find('img').removeClass('lazy');
					$(this).find('img').attr('src', $moving.find('img').attr('src')).removeClass('lazy');
				}
			}
			
			
			// rearange images
			if($replacement.html() != null && $moving.html() != null)
			{
				$moving.animate({top: $replacement.css('top'), left: $replacement.css('left')}, 600);
				$replacement.addClass('dontFadeIn');
			}
			else if ($replacement.html() != null)
			{
				$holder.append($replacement);
				$holder.find('li[data-id~=' + $(this).attr('data-id') + ']:first').fadeIn(1000).find('img.lazy').lazyload({effect: 'fadeIn'});
				$holder.find('li[data-id~=' + $(this).attr('data-id') + ']:first').conRolloverWithCheck(true);
			}
			else
			{
				$moving.fadeOut(1000).delay(1000).remove();
			}
		});
		$holder.find('li:first').promise().done(function(){
			$holder.find('img.lazy').lazyload();
			connectImage();
		});	
		
	});
});



