// Jquery with no conflict
jQuery(document).ready(function($) {
	
	//##########################################
	// Tweet feed
	//##########################################
	
	$("#tweets").tweet({
        count: 2,
        username: "ansimuz"
    });
    
    //##########################################
	// Slider
	//##########################################
	
	$('#slider').nivoSlider({
		effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
		animSpeed: 500, // Slide transition speed
        pauseTime: 3000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        controlNav: false // 1,2,3... navigation
	});
	
	
	 //##########################################
	// Slider - project
	//##########################################
	
	$('#slider-project').nivoSlider({
		effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
		animSpeed: 500, // Slide transition speed
        pauseTime: 3000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        controlNav: true // 1,2,3... navigation
	});
	
		//##########################################
	// Tool tips
	//##########################################
	
	
	$('.poshytip').poshytip({
    	className: 'tip-yellow',
		showTimeout: 1,
		alignTo: 'target',
		alignX: 'center',
		offsetY: 5,
		allowTipHover: false
    });
	
   
    
    $('.form-poshytip').poshytip({
		className: 'tip-yellow',
		showOn: 'focus',
		alignTo: 'target',
		alignX: 'right',
		alignY: 'center',
		offsetX: 5
	});
	
	//##########################################
	// Superfish
	//##########################################
	
	$(".sf-menu").superfish({ 
        animation: {height:'show'},   // slide-down effect without fade-in 
        delay:     800 ,              // 1.2 second delay on mouseout 
        autoArrows:  false,
        speed: 100
    });
    
    //##########################################
	// Accordion box
	//##########################################

	$('.accordion-container').hide(); 
	$('.accordion-trigger:first').addClass('active').next().show();
	$('.accordion-trigger').click(function(){
		if( $(this).next().is(':hidden') ) { 
			$('.accordion-trigger').removeClass('active').next().slideUp();
			$(this).toggleClass('active').next().slideDown();
		}
		return false;
	});
	
	//##########################################
	// Toggle box
	//##########################################
	
	$('.toggle-trigger').click(function() {
		$(this).next().toggle('slow');
		$(this).toggleClass("active");
		return false;
	}).next().hide();
    
    //##########################################
	// Tabs
	//##########################################

    $(".tabs").tabs("div.panes > div", {effect: 'fade'});
    
    //##########################################
	// Create Combo Navi
	//##########################################	
		
	// Create the dropdown base
	$("<select id='comboNav' />").appendTo("#combo-holder");
	
	// Create default option "Go to..."
	$("<option />", {
		"selected": "selected",
		"value"   : "",
		"text"    : "Navigation"
	}).appendTo("#combo-holder select");
	
	// Populate dropdown with menu items
	$("#nav a").each(function() {
		var el = $(this);		
		var label = $(this).parent().parent().attr('id');
		var sub = (label == 'nav') ? '' : '- ';
		
		$("<option />", {
		 "value"   : el.attr("href"),
		 "text"    :  sub + el.text()
		}).appendTo("#combo-holder select");
	});

	
	//##########################################
	// Combo Navigation action
	//##########################################
	
	$("#comboNav").change(function() {
	  location = this.options[this.selectedIndex].value;
	});
    
    //##########################################
	// Work - Isotope 
	//##########################################

	
	var $container = $('#filter-container');
	
	$container.imagesLoaded( function(){
		$container.isotope({
			itemSelector : 'li',
			filter: '*',
			resizable: false,
			animationEngine: 'jquery'			  
		});
	});
	
	// filter buttons
		
	$('#filter-buttons a').click(function(){
	
		// select current
		var $optionSet = $(this).parents('#filter-buttons');
	    $optionSet.find('.selected').removeClass('selected');
	    $(this).addClass('selected');
    
		var selector = $(this).attr('data-filter');
		$container.isotope({ filter: selector });
		return false;
	});
    
    //##########################################
	// Home - Isotope 
	//##########################################

	
	var $container_home = $('#filter-container-feature');
	
	$container_home.imagesLoaded( function(){
		$container_home.isotope({
			itemSelector : 'li',
		});
	});
	
   
  /*
  * Commented due to relayout issue
  *
  // modified Isotope methods for gutters in masonry
  $.Isotope.prototype._getMasonryGutterColumns = function() {
    var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
        containerWidth = this.element.width();
  
    this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
                  // or use the size of the first item
                  this.$filteredAtoms.outerWidth(true) ||
                  // if there's no items, use size of container
                  containerWidth;

    this.masonry.columnWidth += gutter;

    this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
    this.masonry.cols = Math.max( this.masonry.cols, 1 );
  };

  $.Isotope.prototype._masonryReset = function() {
    // layout-specific props
    this.masonry = {};
    // FIXME shouldn't have to call this again
    this._getMasonryGutterColumns();
    var i = this.masonry.cols;
    this.masonry.colYs = [];
    while (i--) {
      this.masonry.colYs.push( 0 );
    }
  };

  $.Isotope.prototype._masonryResizeChanged = function() {
    var prevSegments = this.masonry.cols;
    // update cols/rows
    this._getMasonryGutterColumns();
    // return if updated cols/rows is not equal to previous
    return ( this.masonry.cols !== prevSegments );
  };
  */

	//##########################################
	// Resize event
	//##########################################
	
	$(window).resize(function() {
		
		var w = $(window).width();
		//console.log(w);
	
		$container_home.isotope('reLayout');
	
	}).trigger("resize");
  
});