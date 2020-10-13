/*
	Dynamic Grid Gallery v1.0
	Author: Nikolay Dyankov
	Site: http://www.nikolaydyankovdesign.com
	Email: me@nikolaydyankov.com
*/


(function($) {
	//////////////////////////////////
	// <CORE>
	//////////////////////////////////
	var tmp = new Array(), grid;
	
	var supports = (function() {
		var div = document.createElement('div');
		vendors = 'Khtml Ms O Moz Webkit'.split(' ');
		
		len = vendors.length;
		return function(prop) {  
			if ( prop in div.style ) return true;
			
			prop = prop.replace(/^[a-z]/, function(val) {  
				return val.toUpperCase();  
			});
			
			while(len--) {  
			      if ( vendors[len] + prop in div.style ) {  
			            return true;  
			      }  
			   }
			
			return false;
		};
	})();	
	if (supports('transform')) { }
	
	function log(val) {
		if (console.log) {
			console.log(val);
		}
	}
	function rand(min, max) {
		return Math.random()*(max - min) + min;
	}
	function is_event_within_area(e, a) {
		if (e.pageX > a.offset().left && 
			e.pageX < a.offset().left + a.width() &&
			e.pageY > a.offset().top &&
			e.pageY < a.offset().top + a.height()) {
			return true;
		}
		return false;
	}

	function DGGrid(root, options, content) {
		// Options
		this.O = options;
		
		// Data
		this.cells = content;
		this.nCells = content.length;
		this.html = '';
		this.lastColumnRows = 99999;
		this.lastColumnDirection = -1;
		this.fluidWidth = false;
		this.notAnimated = true;
		
		this.interval = false;
		
		// Objects
		this.columns = new Array();
		
		// Elements
		this.root = root;
		this.wrap = 0;
	}
	DGGrid.prototype.init = function() {
		this.O.height += this.O.padding;
		this.height = this.O.height;
		
		if (this.O.width == undefined) {
			this.root.wrapInner('<div id="dg-temp"></div>');
			var temp = $('#dg-temp');
			this.O.width = temp.width();
			this.width = this.O.width;
			this.fluidWidth = true;
			temp.remove();
		}
		
		this.add_columns();
		this.put_html();
		this.link_elements();
		this.set_styles();
		this.init_animations();
		this.mouse_events();
		this.touch_events();
		this.window_events();

	}
	DGGrid.prototype.add_columns = function() {
		var columns = new Array();
		
		for (var i=0; i<this.O.cols; i++) {
			columns[i] = new Array();
		}
		
		var j = 0;
		for (i=0; i<this.nCells; i++) {
			columns[j].push(this.cells[i]);
			j = (j == this.O.cols - 1) ? 0 : j + 1;
		}
		
		for (i=0; i<this.O.cols; i++) {
			this.columns[i] = new DGColumn(this, columns[i], i, this.O);
			this.columns[i].init();
		}
	}
	DGGrid.prototype.put_html = function() {
		var html = '';
		
		html += '<div class="dg-wrap">';
		html += '	<div class="dg-wrap-inner">';
		
		for (var j=0; j<this.O.cols; j++) {
			html += this.columns[j].html;
		}

		html += '	</div>';		
		html += '</div>';
		
		this.root.html(html);
	}
	DGGrid.prototype.link_elements = function() {
		var i = 0, j = 0, root = this;

		this.wrap = this.root.find('.dg-wrap');
		this.inner = this.wrap.find('.dg-wrap-inner');
		
		this.root.find('.dg-column-wrap').each(function() {
			root.columns[i].root = $(this);

			j = 0;			
			$(this).find('.dg-cell-wrap').each(function() {
				root.columns[i].cells[j].root = $(this);
				root.columns[i].cells[j].img = $(this).find('img');
				j++;
			});
			
			i++;
		});
	}
	DGGrid.prototype.set_styles = function() {	
		this.wrap.css({
			"width" : this.O.width,
			"height" : this.O.height - this.O.padding
		});
		this.inner.css({
			"height" : this.O.height
		});
		
		// Call each DGColumn to set it's styles
		for (var i=0; i<this.O.cols; i++) {
			this.columns[i].set_styles();
		}
	}
	DGGrid.prototype.init_animations = function() {
		for (var i=0; i<this.O.cols; i++) {
			this.columns[i].init_animation();
		}
		
		this.start();
	}
	DGGrid.prototype.start = function() {
		if (this.notAnimated) return;
	
		if (this.interval != false) {
			clearInterval(this.interval);
		}
		
		var index = 0;
		var root = this;
		this.interval = setInterval(function() {
			if (root.O.cols > 1) {
				index++;
				if (index == root.O.cols) {
					index = 0;
				}
				while (!root.columns[index].animated) {
					index++;
					if (index == root.O.cols) {
						index = 0;
					}
				}
			}
			root.columns[index].advance();
		}, this.O.interval);
	}
	DGGrid.prototype.pause = function() {
		clearInterval(this.interval);
	}
	DGGrid.prototype.mouse_events = function() {
		var root = this;
		this.inner.on('mouseover', function(e) {
			if (is_event_within_area(e, root.inner) && !root.paused) {
				root.paused = true;
				root.pause();
			}
		});
		this.inner.on('mouseout', function(e) {
			if (!is_event_within_area(e, root.inner) && root.paused) {
				root.paused = false;
				root.start();
			}
		});
	}
	DGGrid.prototype.touch_events = function() {
		
	}
	DGGrid.prototype.window_events = function() {
		var root = this;
		
		$(window).on('resize', function() {
			if (root.fluidWidth) {
				root.O.width = root.root.width();
			}
			root.set_styles();
		});
	}
	
	function DGColumn(grid, cells, index, options) {
		this.O = options;
	
		// Objects
		this.parent = grid;
		this.cells = cells;
		this.nCells = this.cells.length;
		
		// Data
		this.index = index;
		this.html = '';
		this.width = 0;
		this.height = 0;
		this.left = 0;
		this.top = 0;
		this.heights = new Array();
		this.positions = new Array();
		
		this.rows = 0;
		
		// Animations
		this.direction = -this.parent.lastColumnDirection;
		this.position = (this.direction == 1) ? 0 : this.nCells - this.rows - 1;
		this.animated = false;
		
		// Elements
		this.root = 0;
		
		// Increment variables
		this.parent.lastColumnDirection = this.direction;
	}
	DGColumn.prototype.init = function() {
		this.set_heights();
		this.set_positions();
		this.set_cells();
		this.set_html();
	}
	DGColumn.prototype.set_heights = function() {
		var tmpAr = new Array();
		
		// Get number of rows for this column
		this.rows = Math.round(rand(this.O.min_rows, this.O.max_rows));
		if (this.rows == this.parent.lastColumnRows && this.O.min_rows != this.O.max_rows) {
			while (this.rows == this.parent.lastColumnRows) {
				this.rows = Math.round(rand(this.O.min_rows, this.O.max_rows));
			}			
		}
		this.parent.lastColumnRows = this.rows;
		
		// Set a base height for each image
		if (this.nCells < this.rows) {
			this.rows = this.nCells;
		}
		
		for (var i=0; i<this.rows; i++) {
			tmpAr[i] = Math.ceil(this.parent.height / this.rows);
		}
		
		// If O.random_heights is true, scramble the heights
		if (this.O.random_heights && this.rows > 1) {
			// var steps = O.max_rows * 10;
			// var step = Math.ceil(O.height / steps);
			var step = 10;
			var min = this.O.height / this.O.max_rows / 1.5;
			var sum = 0;
			var hSum = 0;
			
			for (i=0; i < this.rows; i++) {
				tmpAr[i] = min;
				sum++;
				hSum += min;
			}
			while (hSum < this.O.height) {
				tmpAr[Math.round(rand(0, this.rows - 1))] += step;
				sum++;
				hSum += step;
			}
			if (hSum > this.O.height) {
				var temp = tmpAr[this.rows - 1];
				tmpAr[this.rows - 1] = temp - (hSum - this.O.height);
			}
		}
		// Fill the rest of the array "heights"
		var j = 0;
		for (i=0; i < this.nCells; i++) {
			this.heights[i] = tmpAr[j];
			j = (j == this.rows - 1) ? 0 : j + 1;
		}
		
	}
	DGColumn.prototype.set_positions = function() {
		this.positions[0] = 0;
		this.positions[1] = this.heights[0];
		for (var i=1; i<this.nCells; i++) {
			this.positions[i+1] = this.positions[i] + this.heights[i];
		}
	}
	DGColumn.prototype.set_cells = function() {
		var root = this;
		var tmp = new Array();
		
		for (var i=0; i<this.nCells; i++) {
			tmp[i] = new DGCell(root, root.cells[i], root.heights[i], root.O);
			tmp[i].init();
		}
		
		this.cells = tmp;
	}
	DGColumn.prototype.set_html = function() {
		this.html = '';
		
		this.html += '<div class="dg-column-wrap">';
		
		for (var j=0; j<this.nCells; j++) {
			this.html += this.cells[j].html;
		}
		
		this.html += '</div>';
	}
	DGColumn.prototype.set_styles = function() {
		// Call each DGCell to set it's styles
		for (var i=0; i<this.nCells; i++) {
			this.cells[i].set_styles();
		}
		this.width = Math.round((this.O.width-(this.O.padding * (this.O.cols-1))) / this.O.cols);
		this.left = this.index * this.width + (this.O.padding*this.index);
		this.height = this.root.height();
		
		this.top = (this.direction == 1) ? 0 : - (this.height - this.O.height);

		this.root.css({
			"width" : this.width,
			"left" : this.left,
			"top" : this.top
		});
	}
	DGColumn.prototype.init_animation = function() {
		if (this.nCells <= this.rows) return;

		this.animated = true;
		this.parent.notAnimated = false;
		
		this.position = (this.direction == 1) ? 0 : this.nCells - this.rows;

		if (this.direction == -1) {
			this.position = this.nCells - this.rows;
			this.root.css({
				"top" : -this.positions[this.position]
			});
		}
	}
	DGColumn.prototype.advance = function() {
		if (!this.animated) return;
		
		if (this.direction == 1) {
			this.position += 1;
		} else {
			this.position -= 1;
		}
		
		this.root.animate({ "top" : -this.positions[this.position] }, { duration : this.O.speed, easing : this.O.easing });
		if (this.position > this.nCells - this.rows - 1 || this.position <= 0) {
			this.direction = -this.direction;
		}
	}
	
	function DGCell(parent, content, height, options) {
		this.O = options;
		
		// Objects
		this.parent = parent;
		
		// Data
		this.content = content;
		
		this.html = '';
		
		this.width = this.O.width / this.O.cols;
		this.height = height;
		
		// Elements
		this.root = 0;
	}
	DGCell.prototype.init = function() {
		this.html = this.get_html();
	}
	DGCell.prototype.get_html = function() {
		var html = '';
		
		html += '<div class="dg-cell-wrap">';
		html += '	<div class="dg-add-content-wrap">';
		
		html += this.get_additional_content();
		
		html += '	</div>';
		html += '	<div class="dg-main-content-inner-wrap">';
		
		html += this.get_main_content();
		
		html += '	</div>';
		html += '</div>';		
		
		return html;
	}
	DGCell.prototype.set_styles = function() {
		this.root.css({
			"height" : this.height
		});
		this.root.find('.dg-main-content-inner-wrap').css({ 
			"height" : this.height - this.O.padding, 
			"margin-bottom" : this.O.padding
		});
		
		this.imgWidth = this.root.find('img').width();
		this.imgHeight = this.root.find('img').height();
		
		this.init_content();
	}
	DGCell.prototype.get_main_content = function() { return ''; }
	DGCell.prototype.get_additional_content = function() { return ''; }	
	DGCell.prototype.init_content = function() { return; }
	
	//////////////////////////////////
	// </CORE>
	//////////////////////////////////
		
	// REDEFINED METHODS
	DGCell.prototype.get_html = function() {
		var html = '';
		
		html += '<div class="dg-cell-wrap">';
		html += '	<div class="dg-main-content-inner-wrap">';
		
		html += 		this.get_main_content();
		
		// Reason for redefining this function:
		html += '		<div class="dg-add-content-wrap">';		
		html += 			this.get_additional_content();		
		html += '		</div>';
		// End
		
		html += '	</div>';
		html += '</div>';		
		
		return html;
	}
	DGCell.prototype.get_main_content = function() {
		if (this.parent.parent.id == undefined) {			
			this.parent.parent.id = Math.round(Math.random()*10000);
		}
	
		var lightbox = '', link = '', title = '';
		
		if (this.O.click_action == 'lightbox') {
			lightbox = ' rel="lightbox[' + this.parent.parent.id + ']"';
		}
		if (this.O.click_action == 'link') {
			link = this.content.link;
		} else {
			link = this.content.src;
		}
		if (this.O.show_title_in_lightbox == true && this.content.title != undefined) {
			title = ' title="' + this.content.title + '"';
		}
		
		var html = '';
		html += '		<a href="' + link + '"' + lightbox + title + ' class="dg-lightbox-link"></a><img src="' + this.content.src + '" class="dg-image">';
		return html;
	}
	DGCell.prototype.get_additional_content = function() {
		
		var html = '';
		if (this.content.title != undefined) {
			html += '		<div class="dg-image-title">' + this.content.title + '</div>';
		}
		if (this.content.description != undefined) {
			html += '		<div class="dg-image-description">' + this.content.description + '</div>';
		}
		if (this.content.link != undefined && this.O.click_action == 'link') {
			html += '		<div class="dg-image-link"><a href="' + this.content.link + '"></a></div>';
		}
		
		return html;
	}
	DGCell.prototype.init_content = function() {
		var root = this;
		
		this.width = this.O.width / this.O.cols;
		root.img.removeAttr('style');
		
		
		this.scale_image(function() {
			root.center_image();
			root.add_content_classes();
		});
		
		this.mouse_events();
	}
	
	// PLUGIN-SPECIFIC METHODS
	DGCell.prototype.mouse_events = function() {
		this.root.on('mouseover', function() {
			$(this).addClass('dg-hover');
		});
		this.root.on('mouseout', function(e) {
			if (!is_event_within_area(e, $(this))) {
				$(this).removeClass('dg-hover');
			}
		});
	}
	DGCell.prototype.scale_image = function(cb) {
		// This is necessary because Lightbox messes up with this script and we can't get the dimentions of the image using .width()
		var img = new Image(), root = this;

		img.onload = function() {
			root.origWidth = this.width;
			root.origHeight = this.height;
	
			// If scale_images is disabled, set some defaults for center_images and quit
			if (!root.O.scale_images) {
				root.scaledImgWidth = root.origWidth;
				root.scaledImgHeight = root.origHeight;
				
				cb();
				return;
			}
			
			var hDelta = Math.abs(root.origWidth - root.width);
			var vDelta = Math.abs(root.origHeight - root.height);
	
			root.fullHeight = false;
			root.fullWidth = false;

			if (hDelta <= vDelta) {
				root.img.css({
					"width" : root.width
				});
				
				root.fullWidth = true;
				if (root.img.height() < root.height) {
					root.img.css({
						"height" : root.height,
						"width" : "auto"
					});
					root.fullWidth = false;
				}
			} else {
				root.img.css({
					"height" : root.height
				});
				
				root.fullHeight = true;
				
				if (root.img.width() < root.width) {
					root.img.css({
						"width" : root.width,
						"height" : "auto"
					});
					
					root.fullHeight = false;
				}
			}
	
			root.scaledImgWidth = root.img.width();
			root.scaledImgHeight = root.img.height();
			cb();
		}
		img.src = root.content.src;
	}
	DGCell.prototype.center_image = function() {
		if (!this.O.center_images) return;
		if (this.fullWidth) {
			this.img.css({
				"position" : "absolute",
				"margin-top" : -(this.scaledImgHeight - this.height)/2
			});
			return;
		}
		if (this.fullHeight) {
			this.img.css({
				"position" : "absolute",
				"margin-left" : -(this.scaledImgWidth - this.width)/2
			});
			return;
		}
		this.img.css({
			"position" : "absolute",
			"margin-left" : -(this.scaledImgWidth - this.width)/2,
			"margin-top" : -(this.scaledImgHeight - this.height)/2
		});
	}
	DGCell.prototype.add_content_classes = function() {
		var rootClass = undefined;
		if (this.content.description == undefined) {
			rootClass = 'dg-title-mode';
		}
		if (this.content.title == undefined && this.content.description == undefined) {
			rootClass = 'dg-no-content';
		}
		
		if (rootClass != undefined) {
			this.root.addClass(rootClass);
		}
	}
	
	$.fn.dynamicGallery = function(options) {
		var D = {
			src : '',
			width : undefined,
			height : 400,
			cols : 3,
			min_rows : 2,
			max_rows : 3,
			random_heights : true,
			padding: 1,
			interval : 2000,
			speed : 1000,
			easing : 'easeOutQuart',
			scale_images : true,
			center_images : true,
			click_action : 'link', // or "link",
			show_title_in_lightbox : true
		};

		O = $.extend(true, D, options);
		
		return this.each(function() {
			// Load the source content for the plugin. This will be individual for 
			// each variation of the plugin. 
			// The source content will be fed to the DGGrid class and then
			// each DGCell will get it's content from the source content.
			var root = $(this);
			if (O.src.search('xml') == -1) {
				// Parse HTML code
				var i = 0, title, description, link;
				root.find('.dg-cell').each(function() {
					tmp[i] = new Array();
					tmp[i].src = $(this).find('.dg-cell-src').text();
					tmp[i].title = undefined;
					tmp[i].description = undefined;
					tmp[i].link = '#';
					
					title = $(this).find('.dg-cell-title').text();
					description = $(this).find('.dg-cell-description').text();
					link = $(this).find('.dg-cell-link').text();
					
					if (title != undefined && title != '') {
						tmp[i].title = title;
					}
					if (description != undefined && description != '') {
						tmp[i].description = description;
					}
					if (link != undefined && link != '') {
						tmp[i].link = link;
					}
					
					i++;
				});

				// Initialize
				grid = new DGGrid(root, O, tmp);
				grid.init();
			} else {
				// Parse XML file
				
				var optionsTmp = O;
				
				$.ajax({
					type: "GET",
					url : optionsTmp.src,
					dataType : 'xml',
					success : function(data) {
						xml = $(data);
						var it = xml.find('image');
						var len = it.length, title, description, link;
						
						for (var i=0; i<len; i++) {
							tmp[i] = new Array();
							tmp[i].src = $(it[i]).find('src').text();
							tmp[i].title = undefined;
							tmp[i].description = undefined;
							tmp[i].link = '#';
							
							title = $(it[i]).find('title').text();
							description = $(it[i]).find('description').text();
							link = $(it[i]).find('link').text();
							
							if (title != undefined && title != '') {
								tmp[i].title = title;
							}
							if (description != undefined && description != '') {
								tmp[i].description = description;
								
							}
							if (link != undefined && link != '') {
								tmp[i].link = link;
							}
						}
						
						// Initialize
						grid = new DGGrid(root, optionsTmp, tmp);
						grid.init();
					}
				});

			}
		});
	}
})(jQuery);



// Lightbox
// (function(){var a,j,k;a=jQuery;k=function(){return function(){this.fileLoadingImage="images/loading.gif";this.fileCloseImage="images/close.png";this.resizeDuration=700;this.fadeDuration=500;this.labelImage="Image";this.labelOf="of"}}();j=function(){function b(a){this.options=a;this.album=[];this.currentImageIndex=void 0;this.init()}b.prototype.init=function(){this.enable();return this.build()};b.prototype.enable=function(){var c=this;return a("body").on("click","a[rel^=lightbox], area[rel^=lightbox]",
// function(d){c.start(a(d.currentTarget));return!1})};b.prototype.build=function(){var c,d=this;a("<div>",{id:"lightboxOverlay"}).after(a("<div/>",{id:"lightbox"}).append(a("<div/>",{"class":"lb-outerContainer"}).append(a("<div/>",{"class":"lb-container"}).append(a("<img/>",{"class":"lb-image"}),a("<div/>",{"class":"lb-nav"}).append(a("<a/>",{"class":"lb-prev"}),a("<a/>",{"class":"lb-next"})),a("<div/>",{"class":"lb-loader"}).append(a("<a/>",{"class":"lb-cancel"}).append(a("<img/>",{src:this.options.fileLoadingImage}))))),
// a("<div/>",{"class":"lb-dataContainer"}).append(a("<div/>",{"class":"lb-data"}).append(a("<div/>",{"class":"lb-details"}).append(a("<span/>",{"class":"lb-caption"}),a("<span/>",{"class":"lb-number"})),a("<div/>",{"class":"lb-closeContainer"}).append(a("<a/>",{"class":"lb-close"}).append(a("<img/>",{src:this.options.fileCloseImage}))))))).appendTo(a("body"));a("#lightboxOverlay").hide().on("click",function(){d.end();return!1});c=a("#lightbox");c.hide().on("click",function(c){"lightbox"===a(c.target).attr("id")&&
// d.end();return!1});c.find(".lb-outerContainer").on("click",function(c){"lightbox"===a(c.target).attr("id")&&d.end();return!1});c.find(".lb-prev").on("click",function(){d.changeImage(d.currentImageIndex-1);return!1});c.find(".lb-next").on("click",function(){d.changeImage(d.currentImageIndex+1);return!1});c.find(".lb-loader, .lb-close").on("click",function(){d.end();return!1})};b.prototype.start=function(c){var d,b,e,f,h;a(window).on("resize",this.sizeOverlay);a("select, object, embed").css({visibility:"hidden"});
// a("#lightboxOverlay").width(a(document).width()).height(a(document).height()).fadeIn(this.options.fadeDuration);this.album=[];e=0;if("lightbox"===c.attr("rel"))this.album.push({link:c.attr("href"),title:c.attr("title")});else{h=a(c.prop("tagName")+'[rel="'+c.attr("rel")+'"]');b=0;for(f=h.length;b<f;b++)d=h[b],this.album.push({link:a(d).attr("href"),title:a(d).attr("title")}),a(d).attr("href")===c.attr("href")&&(e=b)}d=a(window);c=d.scrollTop()+d.height()/10;d=d.scrollLeft();a("#lightbox").css({top:c+
// "px",left:d+"px"}).fadeIn(this.options.fadeDuration);this.changeImage(e)};b.prototype.changeImage=function(c){var d,b,e,f=this;this.disableKeyboardNav();b=a("#lightbox");d=b.find(".lb-image");this.sizeOverlay();a("#lightboxOverlay").fadeIn(this.options.fadeDuration);a(".loader").fadeIn("slow");b.find(".lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption").hide();b.find(".lb-outerContainer").addClass("animating");e=new Image;e.onload=function(){d.attr("src",f.album[c].link);
// d.width=e.width;d.height=e.height;return f.sizeContainer(e.width,e.height)};e.src=this.album[c].link;this.currentImageIndex=c};b.prototype.sizeOverlay=function(){return a("#lightboxOverlay").width(a(document).width()).height(a(document).height())};b.prototype.sizeContainer=function(c,d){var b,e,f,h,j,k,g,i,l,m,n=this;e=a("#lightbox");f=e.find(".lb-outerContainer");m=f.outerWidth();l=f.outerHeight();b=e.find(".lb-container");k=parseInt(b.css("padding-top"),10);j=parseInt(b.css("padding-right"),10);
// h=parseInt(b.css("padding-bottom"),10);b=parseInt(b.css("padding-left"),10);i=c+b+j;g=d+k+h;i!==m&&g!==l?f.animate({width:i,height:g},this.options.resizeDuration,"swing"):i!==m?f.animate({width:i},this.options.resizeDuration,"swing"):g!==l&&f.animate({height:g},this.options.resizeDuration,"swing");setTimeout(function(){e.find(".lb-dataContainer").width(i);e.find(".lb-prevLink").height(g);e.find(".lb-nextLink").height(g);n.showImage()},this.options.resizeDuration)};b.prototype.showImage=function(){var c;
// c=a("#lightbox");c.find(".lb-loader").hide();c.find(".lb-image").fadeIn("slow");this.updateNav();this.updateDetails();this.preloadNeighboringImages();this.enableKeyboardNav()};b.prototype.updateNav=function(){var c;c=a("#lightbox");c.find(".lb-nav").show();0<this.currentImageIndex&&c.find(".lb-prev").show();this.currentImageIndex<this.album.length-1&&c.find(".lb-next").show()};b.prototype.updateDetails=function(){var c,b=this;c=a("#lightbox");"undefined"!==typeof this.album[this.currentImageIndex].title&&
// ""!==this.album[this.currentImageIndex].title&&c.find(".lb-caption").html(this.album[this.currentImageIndex].title).fadeIn("fast");1<this.album.length?c.find(".lb-number").html(this.options.labelImage+" "+(this.currentImageIndex+1)+" "+this.options.labelOf+"  "+this.album.length).fadeIn("fast"):c.find(".lb-number").hide();c.find(".lb-outerContainer").removeClass("animating");c.find(".lb-dataContainer").fadeIn(this.resizeDuration,function(){return b.sizeOverlay()})};b.prototype.preloadNeighboringImages=
// function(){var a;this.album.length>this.currentImageIndex+1&&(a=new Image,a.src=this.album[this.currentImageIndex+1].link);0<this.currentImageIndex&&(a=new Image,a.src=this.album[this.currentImageIndex-1].link)};b.prototype.enableKeyboardNav=function(){a(document).on("keyup.keyboard",a.proxy(this.keyboardAction,this))};b.prototype.disableKeyboardNav=function(){a(document).off(".keyboard")};b.prototype.keyboardAction=function(a){var b;b=a.keyCode;a=String.fromCharCode(b).toLowerCase();27===b||a.match(/x|o|c/)?
// this.end():"p"===a||37===b?0!==this.currentImageIndex&&this.changeImage(this.currentImageIndex-1):("n"===a||39===b)&&this.currentImageIndex!==this.album.length-1&&this.changeImage(this.currentImageIndex+1)};b.prototype.end=function(){this.disableKeyboardNav();a(window).off("resize",this.sizeOverlay);a("#lightbox").fadeOut(this.options.fadeDuration);a("#lightboxOverlay").fadeOut(this.options.fadeDuration);return a("select, object, embed").css({visibility:"visible"})};return b}();a(function(){var a;
// a=new k;return new j(a)})}).call(this);
// 
// // jQuery Easing
// jQuery.easing.jswing=jQuery.easing.swing;
// jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,a,c,b,d){return jQuery.easing[jQuery.easing.def](e,a,c,b,d)},easeInQuad:function(e,a,c,b,d){return b*(a/=d)*a+c},easeOutQuad:function(e,a,c,b,d){return-b*(a/=d)*(a-2)+c},easeInOutQuad:function(e,a,c,b,d){return 1>(a/=d/2)?b/2*a*a+c:-b/2*(--a*(a-2)-1)+c},easeInCubic:function(e,a,c,b,d){return b*(a/=d)*a*a+c},easeOutCubic:function(e,a,c,b,d){return b*((a=a/d-1)*a*a+1)+c},easeInOutCubic:function(e,a,c,b,d){return 1>(a/=d/2)?b/2*a*a*a+c:
// b/2*((a-=2)*a*a+2)+c},easeInQuart:function(e,a,c,b,d){return b*(a/=d)*a*a*a+c},easeOutQuart:function(e,a,c,b,d){return-b*((a=a/d-1)*a*a*a-1)+c},easeInOutQuart:function(e,a,c,b,d){return 1>(a/=d/2)?b/2*a*a*a*a+c:-b/2*((a-=2)*a*a*a-2)+c},easeInQuint:function(e,a,c,b,d){return b*(a/=d)*a*a*a*a+c},easeOutQuint:function(e,a,c,b,d){return b*((a=a/d-1)*a*a*a*a+1)+c},easeInOutQuint:function(e,a,c,b,d){return 1>(a/=d/2)?b/2*a*a*a*a*a+c:b/2*((a-=2)*a*a*a*a+2)+c},easeInSine:function(e,a,c,b,d){return-b*Math.cos(a/
// d*(Math.PI/2))+b+c},easeOutSine:function(e,a,c,b,d){return b*Math.sin(a/d*(Math.PI/2))+c},easeInOutSine:function(e,a,c,b,d){return-b/2*(Math.cos(Math.PI*a/d)-1)+c},easeInExpo:function(e,a,c,b,d){return 0==a?c:b*Math.pow(2,10*(a/d-1))+c},easeOutExpo:function(e,a,c,b,d){return a==d?c+b:b*(-Math.pow(2,-10*a/d)+1)+c},easeInOutExpo:function(e,a,c,b,d){return 0==a?c:a==d?c+b:1>(a/=d/2)?b/2*Math.pow(2,10*(a-1))+c:b/2*(-Math.pow(2,-10*--a)+2)+c},easeInCirc:function(e,a,c,b,d){return-b*(Math.sqrt(1-(a/=d)*
// a)-1)+c},easeOutCirc:function(e,a,c,b,d){return b*Math.sqrt(1-(a=a/d-1)*a)+c},easeInOutCirc:function(e,a,c,b,d){return 1>(a/=d/2)?-b/2*(Math.sqrt(1-a*a)-1)+c:b/2*(Math.sqrt(1-(a-=2)*a)+1)+c},easeInElastic:function(e,a,c,b,d){var e=1.70158,f=0,g=b;if(0==a)return c;if(1==(a/=d))return c+b;f||(f=0.3*d);g<Math.abs(b)?(g=b,e=f/4):e=f/(2*Math.PI)*Math.asin(b/g);return-(g*Math.pow(2,10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f))+c},easeOutElastic:function(e,a,c,b,d){var e=1.70158,f=0,g=b;if(0==a)return c;if(1==
// (a/=d))return c+b;f||(f=0.3*d);g<Math.abs(b)?(g=b,e=f/4):e=f/(2*Math.PI)*Math.asin(b/g);return g*Math.pow(2,-10*a)*Math.sin((a*d-e)*2*Math.PI/f)+b+c},easeInOutElastic:function(e,a,c,b,d){var e=1.70158,f=0,g=b;if(0==a)return c;if(2==(a/=d/2))return c+b;f||(f=d*0.3*1.5);g<Math.abs(b)?(g=b,e=f/4):e=f/(2*Math.PI)*Math.asin(b/g);return 1>a?-0.5*g*Math.pow(2,10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f)+c:0.5*g*Math.pow(2,-10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f)+b+c},easeInBack:function(e,a,c,b,d,f){void 0==
// f&&(f=1.70158);return b*(a/=d)*a*((f+1)*a-f)+c},easeOutBack:function(e,a,c,b,d,f){void 0==f&&(f=1.70158);return b*((a=a/d-1)*a*((f+1)*a+f)+1)+c},easeInOutBack:function(e,a,c,b,d,f){void 0==f&&(f=1.70158);return 1>(a/=d/2)?b/2*a*a*(((f*=1.525)+1)*a-f)+c:b/2*((a-=2)*a*(((f*=1.525)+1)*a+f)+2)+c},easeInBounce:function(e,a,c,b,d){return b-jQuery.easing.easeOutBounce(e,d-a,0,b,d)+c},easeOutBounce:function(e,a,c,b,d){return(a/=d)<1/2.75?b*7.5625*a*a+c:a<2/2.75?b*(7.5625*(a-=1.5/2.75)*a+0.75)+c:a<2.5/2.75?
// b*(7.5625*(a-=2.25/2.75)*a+0.9375)+c:b*(7.5625*(a-=2.625/2.75)*a+0.984375)+c},easeInOutBounce:function(e,a,c,b,d){return a<d/2?0.5*jQuery.easing.easeInBounce(e,2*a,0,b,d)+c:0.5*jQuery.easing.easeOutBounce(e,2*a-d,0,b,d)+0.5*b+c}});
