/* Page config --> Begin */

var config = {
	menu : {
		1 : {
			name : "Dark Menu",
			className : 'menu-1'
		},
		2 : {
			name : 'Light Menu',
			className : 'menu-2'
		}
	},
    styles : {
        headerStyle : {
            name : 'Heading Font',
            id : 'heading_style',
            list : {
                1 : {
                    name : 'Oswald',
                    className : 'h-style-1'
                },
				2 : {
                    name : 'Open Sans',
                    className : 'h-style-2'
                },
				3 : {
                    name : 'Ubuntu Condensed',
                    className : 'h-style-3'
                },
				4 : {
                    name : 'Droid Serif',
                    className : 'h-style-4'
                }
            }
        },
        textStyle : {
            name : 'Content Font',
            id : 'text_style',
            list : {
                1 : {
                    name : 'Arial',
                    className : 'text-1'
                },
                2 : {
                    name : 'Tahoma',
                    className : 'text-2'
                },
                3 : {
                    name : 'Verdana',
                    className : 'text-3'
                }
            }
        }
    }
}
	
/* Config --> End */

jQuery(document).ready(function($){

    /* Theme controller --> Begin */

    var $body = $('body'),
		$themePanel = $('<div id="control_panel" />').addClass('control_panel'),
		$theme_control_panel_label = $('<a href="#" id="control_label" />');
		$themePanel.append($theme_control_panel_label);
		
	var color = $.cookie('color'),
		heading = $.cookie('heading'),
		text = $.cookie('text');
		
	var $bcolor = $('.bcolor, .curtain'),
		$tcolor = $('.tcolor');	
		$project = $('#portfolio-items article, .navigation ul ul li, .entry-title .title, span > a, .widget-container a, div > a:not(.button, .more)');
		$text = $('.navigation ul ul li.current-menu-item > a, .widget-container li');
		
    function changeBodyClass(className, classesArray) {
        $.each(classesArray,function(idx, val) {
            $body.removeClass(val);
        });
        $body.addClass(className);
    }

    if (typeof config != 'undefined' && $themePanel) {

        var defaultSettings = {};
			
		/* Body Picker --> Begin */

		var $color = $('<div/>').attr({id : 'bodypicker'}).addClass('bodyPicker');
			var $links_color_wrapper = $('<div/>').addClass('body_color_wrapper clearfix');
				$links_color_wrapper.append('<span>Theme color:</span>', $color);
				$themePanel.append($links_color_wrapper);

		$color.css('background-color','#fe5214').ColorPicker({
			color: '#fe5214',
			onChange: function (hsb, hex, rgba) {
				var $bcolor = $('.bcolor, .curtain'),
					$tcolor = $('.tcolor');
					
				$.cookie('color', hex);
				
				$text.css('color', '#' + hex);
				$project.on('mouseenter',function(){
					var el = $(this);
					
					$('.project-meta', el).css('border-bottom-color', '#' + hex);
					el.find('> a').css('color', '#'+ hex);
					el.not('article').css('color', '#' + hex);
				}).on('mouseleave',function() {
					$(this).find('.project-meta').attr('style','');
					$(this).not('.current-menu-item').find('> a').attr('style','');
					$('.widget-container a').attr('style','');
					$('div > a:not(.button, .more)').attr('style','');
					$('span a').attr('style','');
				});		

				$color.css('background-color', '#' + hex);
				$tcolor.css('color', '#' + hex);
				$bcolor.css('background-color', '#' + hex);
			}
		});
		
		function addBgPicker() {
			$tcolor.css('color','#' + color);
			$bcolor.add($color).css('background-color', '#' + color);
			
			$text.css('color', '#' + color);
			$project.on('mouseenter',function(){
				var el = $(this);
					$('.project-meta', el).css('border-bottom-color', '#' + color);
					el.find('> a').css('color', '#'+ color);
					el.not('article').css('color', '#' + color);
			}).on('mouseleave',function() {
				$(this).find('.project-meta').attr('style','');
				$(this).not('.current-menu-item').find('> a').attr('style','');
				$('.widget-container a').attr('style','');
				$('div > a:not(.button, .more)').attr('style','');
				$('span a').attr('style','');
			});	
		}
		
		if (color) addBgPicker();

		/* Body Picker --> End */
		
		/* Styles --> Begin */

        if (config.styles) {
            var $style_block;
            var $block_label;
            var $select_element;
            var select_html;
            var headerStyle = [];
            var textStyle = [];
            defaultSettings.style = {};
            $.each(config.styles, function(idx, val) {
                    $style_block = $('<div/>').addClass('style_block');
                    $block_label = $('<span>' + val.name + ':</span>');
                    $select_element = $('<select/>').attr({
                        id : val.id
                    });
                    select_html = '';
                    $.each(val.list,function(list_idx, list_val) {
                        if ($body.hasClass(list_val.className)) {
                            select_html += '<option class="'+ list_val.className +'" value="' + list_val.className + '" selected="selected">' + list_val.name + '</option>';
                            defaultSettings.style[idx] = list_idx;
                        } else {
                            select_html += '<option class="'+ list_val.className +'" value="' + list_val.className + '">' + list_val.name + '</option>';
                        }
                    });
                    $select_element.html(select_html);
                    $style_block.append($block_label, $select_element);
                    $themePanel.append($style_block);
                });
				
		}
			
		/* Reset Settings  --> Begin */

		var setDefaultsSettings = function() {
			$.cookie('color', null);
			$.cookie('heading', null);
			$.cookie('text', null);
			$body.attr('style','');
			$('a').attr('style','');
			$('#portfolio-items article').find('.project-meta').attr('style','');
			$tcolor.attr('style','');
			$bcolor.attr('style', '');
			$text.attr('style','');
			$project.on('mouseenter',function(){
				var el = $(this);
					$('.project-meta', el).attr('style', '');
					el.find('> a').attr('style', '');
					el.not('article').attr('style', '');
			}).on('mouseleave',function() {
				$(this).find('.project-meta').attr('style','');
				$(this).find('> a').attr('style','');
			});		
			$themePanel.find('select').val(0);
			changeBodyClass(config.styles.headerStyle.list[defaultSettings.style.headerStyle].className, headerStyle);
			changeBodyClass(config.styles.textStyle.list[defaultSettings.style.textStyle].className, textStyle);
			$color.css({'background-color':'#fe5214'}).ColorPickerSetColor('#fe5214');
			$themePanel.find('.active').removeClass();
			return false;
		};

		var $restore_button_wrapper = $('<div/>').addClass('restore_button_wrapper');
		var $restore_button = $('<a/>').text('Reset').attr('id','restore_button').addClass('button dark small').click(setDefaultsSettings);
			$restore_button_wrapper.append($restore_button);
			$themePanel.append($restore_button_wrapper);

		/* Reset Settings  --> Begin */

		
		/* Styles --> End */
				
		/* Control Panel Label --> Begin */		

        $theme_control_panel_label.click(function() {
            if ($themePanel.hasClass('visible')) {
                $themePanel.animate({left: -210}, 400, function() {
                      $themePanel.removeClass('visible');
                });
            } else {
                $themePanel.animate({left: 0}, 400, function() {
                      $themePanel.addClass('visible');
                });
            }
            return false;
        });
		
		/* Control Panel Label --> End */
	
	}
		
	$body.append($themePanel);
		
	/* Text and Heading Fonts --> Begin */
	
	$.each(config.styles.headerStyle.list, function(idx, val) {
		headerStyle.push(val.className);
	});

	$('#heading_style').change(function() {
		$.cookie('heading', $(this).val());
		if (!$body.hasClass($(this).val())) {
			changeBodyClass($(this).val(), headerStyle);
		}
	});

	function addHeadingFont() {
		changeBodyClass(heading,headerStyle);
	}
	if (heading) addHeadingFont();
	

	$.each(config.styles.textStyle.list, function(idx, val) {
		textStyle.push(val.className);
	});

	$('#text_style').change(function() {
		$.cookie('text', $(this).val());
		if (!$body.hasClass($(this).val())) {
			changeBodyClass($(this).val(), textStyle);
		}
	});

	function addTextFont() {
		changeBodyClass(text,textStyle);
	}
	if (text) addTextFont();

	/* Text and Heading Fonts --> End */
			
    /* Theme controller --> End */

});
