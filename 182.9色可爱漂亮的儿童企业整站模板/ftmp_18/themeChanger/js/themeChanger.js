/* Page config --> Begin */

var page_config = {
	patterns : {
		0 : {
			name : 'Pattern 1',
			className : 't-pattern-1'
		},
		1 : {
			name : 'Patter 2',
			className : 't-pattern-2'
		},
		2 : {
			name : 'Pattern 3',
			className : 't-pattern-3'
		},
		3 : {
			name : 'Pattern 4',
			className : 't-pattern-4'
		},
		4 : {
			name : 'Pattern 5',
			className : 't-pattern-5'
		},
		5 : {
			name : 'Pattern 6',
			className : 't-pattern-6'
		},
		6 : {
			name : 'Pattern 7',
			className : 't-pattern-7'
		},
		7 : {
			name : 'Pattern 8',
			className : 't-pattern-8'
		},
		8 : {
			name : 'Pattern 9',
			className : 't-pattern-9'
		}
	},
	colors : {
		0 : {
			name : 'Blue',
			className : 't-blue'
		},
		1 : {
			name : 'Red',
			className : 't-red'
		},
		2 : {
			name : 'Green',
			className : 't-green'
		},
		3 : {
			name : 'Brown',
			className : 't-brown'
		},
		4 : {
			name : 'Peachy',
			className : 't-peachy'
		},
		5 : {
			name : 'Violet',
			className : 't-violet'
		}
	},
	styles : {
		menuStyle : {
			name : 'Menu Style',
			id : 'menu_style',
			list : {
				0 : {
					name : 'Salsa',
					className : 't-menu-1'
				},
				1 : {
					name : 'Rancho',
					className : 't-menu-2'
				},
				2 : {
					name : 'Yanone Kaffeesatz',
					className : 't-menu-3'
				}
			}
		},
		headerStyle : {
			name : 'Header Style',
			id : 'header_style',
			list : {
				0 : {
					name : 'Jockey One',
					className : 't-header-1'
				},
				1 : {
					name : 'Oswald',
					className : 't-header-2'
				},
				2 : {
					name : 'Yanone Kaffeesatz',
					className : 't-header-3'
				}
			}
		},
		textStyle : {
			name : 'Text Style',
			id : 'text_style',
			list : {
				0: {
					name : 'Tahoma',
					className : 't-text-1'
				},
				1 : {
					name : 'Arial',
					className : 't-text-2'
				},
				2 : {
					name : 'Verdana',
					className : 't-text-3'
				}
			}
		}
	}
}


/* Page config --> End */

jQuery(document).ready(function($) {

	/* Theme controller --> Begin */

	var $body = $('body');
	$body.css('color');
	var $theme_control_panel = $('#kids_theme_control_panel');
	var listStyleClass = 'button-style1 button-style2 button-style3 button-style4 button-style5 button-style6';

	function changeBodyClass(className, classesArray) {
		$.each(classesArray,function(idx, val) {
			$body.removeClass(val);
		});
		$body.addClass(className);
	}

	if (typeof page_config != 'undefined' && $theme_control_panel) {

		var color_classes = new Array();
		var pattern_classes = new Array();
        
		var $header = $('#kids_header');
		var defaultSettings = {};

		if (page_config.patterns) {
			var $pattern_block = $('<div/>').attr('id','patterns');
			var pattern_change_html = '<span>Pattern:</span>';
			pattern_change_html += '<ul>';
			$.each(page_config.patterns, function(idx, val) {
				if ($body.hasClass(val.className)) {
					defaultSettings.pattern = idx;
				}
				pattern_change_html += '<li><a href="' + val.className + '" title="' + val.name + '" class="' + val.className + '"></a></li>';
				pattern_classes.push(val.className);
			});
			pattern_change_html += '</ul>';
			$pattern_block.html(pattern_change_html);
			$theme_control_panel.append($pattern_block);

			$pattern_block.find('a').click(function() {
				var nextClassName = $(this).attr('href');
				if (!$body.hasClass(nextClassName)) {
					changeBodyClass(nextClassName, pattern_classes);
					$pattern_block.find('.active').removeClass('active');
					$(this).parent().addClass('active');
				}
				return false;
			});
		}

		if (page_config.colors) {
			var $color_block = $('<div/>').attr('id','color_schema');
			var color_change_html = '<span>Color Schemes:</span>';
			color_change_html += '<ul>';
			$.each(page_config.colors, function(idx, val) {
				if ($body.hasClass(val.className)) {
					defaultSettings.color = idx;
				}
				color_change_html += '<li><a href="' + val.className + '" title="' + val.name + '" class="' + val.className + '"></a></li>';
				color_classes.push(val.className);
			});
			color_change_html += '</ul>';
			$color_block.html(color_change_html);
			$theme_control_panel.append($color_block);
		
			$color_block.find('a').click(function() {
				var nextClassName = $(this).attr('href');
                
				if (!$body.hasClass(nextClassName)) {
					changeBodyClass(nextClassName, color_classes);
					$color_block.find('.active').removeClass('active');
				
					$(this).parent().addClass('active');
					if (typeof setFooterImageColors == 'function') {
						setFooterImageColors($('#kids_bottom_container .kids_image_wrapper'));
					}	
					
					if(!$body.hasClass('noChangeButton')) {
						if ($body.hasClass('t-blue')) {
							$('.button').removeClass(listStyleClass).addClass('button-style1');
						}
						else if ($body.hasClass('t-red')) {
							$('.button').removeClass(listStyleClass).addClass('button-style2');
						}
						else if ($body.hasClass('t-green')) {
							$('.button').removeClass(listStyleClass).addClass('button-style3');
						}
						else if ($body.hasClass('t-brown')) {
							$('.button').removeClass(listStyleClass).addClass('button-style4');
						}
						else if ($body.hasClass('t-peachy')) {
							$('.button').removeClass(listStyleClass).addClass('button-style5');
						}
						else if ($body.hasClass('t-violet')) {
							$('.button').removeClass(listStyleClass).addClass('button-style6');
						}
					}		
				}
				return false;
			});
		}

		if (page_config.styles) {
			var $style_block;
			var $block_label;
			var $select_element;
			var select_html;
			var header_style_classes = [];
			var menu_style_classes = [];
			var text_style_classes = [];
			defaultSettings.style = {};
			$.each(page_config.styles, function(idx, val) {
				$style_block = $('<div/>').addClass('style_block');
				$block_label = $('<span>' + val.name + ':</span>');
				$select_element = $('<select/>').attr({
					id : val.id
				});
				select_html = '';
				$.each(val.list,function(list_idx, list_val) {
					if ($body.hasClass(list_val.className)) {
						select_html += '<option value="' + list_val.className + '" selected="selected">' + list_val.name + '</option>';
						defaultSettings.style[idx] = list_idx;
					} else {
						select_html += '<option value="' + list_val.className + '">' + list_val.name + '</option>';
					}
				});
				$select_element.html(select_html);

				$style_block.append($block_label, $select_element);
				$theme_control_panel.append($style_block);
			});
			$.each(page_config.styles.menuStyle.list, function(idx, val) {
				menu_style_classes.push(val.className);
			});
			$('#menu_style').change(function() {
				if (!$body.hasClass($(this).val())) {
					changeBodyClass($(this).val(), menu_style_classes);
				}
			});
			$.each(page_config.styles.headerStyle.list, function(idx, val) {
				header_style_classes.push(val.className);
			});
			$('#header_style').change(function() {
				if (!$body.hasClass($(this).val())) {
					changeBodyClass($(this).val(), header_style_classes);
				}
			});
			$.each(page_config.styles.textStyle.list, function(idx, val) {
				text_style_classes.push(val.className);
			});
			$('#text_style').change(function() {
				if (!$body.hasClass($(this).val())) {
					changeBodyClass($(this).val(), text_style_classes);
				}
			});
            
			var $menu_colorpicker = $('#menu_style_colorpicker');
	
			var $text_colorpicker = $('#text_style_colorpicker');
			$text_colorpicker.css({
				'background-color':'#4B4B4B'
			}).ColorPicker({
				color: '#4B4B4B',
				onChange: function (hsb, hex, rgb) {
					$('#text_style_colorpicker').css('backgroundColor', '#' + hex);
					$body.css('color', '#' + hex);
				}
			});
			
			var setDefaultsSettings = function() {
				changeBodyClass(page_config.patterns[defaultSettings.pattern].className, pattern_classes);
				changeBodyClass(page_config.colors[defaultSettings.color].className, color_classes);
				$theme_control_panel.find('select').val(0);
				changeBodyClass(page_config.styles.headerStyle.list[defaultSettings.style.headerStyle].className, header_style_classes);
				changeBodyClass(page_config.styles.menuStyle.list[defaultSettings.style.menuStyle].className, menu_style_classes);
				changeBodyClass(page_config.styles.textStyle.list[defaultSettings.style.textStyle].className, text_style_classes);
				$('.mailto').attr('style','');
				if($body.hasClass('t-blue')) {
					$('.button').removeClass(listStyleClass);
					$('.button').addClass('button-style1');		
				}
				$header.attr('style','');
				$text_colorpicker.css({
					'background-color':'#4B4B4B'
				}).ColorPickerSetColor('#4B4B4B');
				$body.attr('style','');
				setFooterImageColors($('#kids_bottom_container .kids_image_wrapper'));
				return false;
			};
			var $restore_button_wrapper = $('<div/>').addClass('restore_button_wrapper');
			var $restore_button = $('<a/>').text('Restore').attr('id','restore_button').click(setDefaultsSettings);
			$restore_button_wrapper.append($restore_button);
			$theme_control_panel.append($restore_button_wrapper);
		}

		var $theme_control_panel_label = $('#kids_theme_control_label');
		$theme_control_panel_label.click(function() {
			if ($theme_control_panel.hasClass('visible')) {
				$theme_control_panel.animate({
					left: -122
				}, 400, function() {
					$theme_control_panel.removeClass('visible');
				});
			} else {
				$theme_control_panel.animate({
					left: 0
				}, 400, function() {
					$theme_control_panel.addClass('visible');
				});
			}
			return false;
		});
	}

/* Theme controller --> End */

});
