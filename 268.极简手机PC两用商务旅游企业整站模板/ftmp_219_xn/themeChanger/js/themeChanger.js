/* Page config --> Begin */
var page_config = {
	layout : {
		0 : {
			name : 'layout',
			title : 'liquid',
			className : 'liquid'
		},
		1 : {
			name : 'layout',
			title : 'fixed',
			className : 'fixed'
		}
	},
	skin : {
		0 : {
			name : 'skin',
			title : 'light',
			className : 'light'
		},
		1 : {
			name : 'skin',
			title : 'dark',
			className : 'dark'
		}
	},
    patterns_liquid : {
        0 : {
            name : 'Pattern 1',
            className : 'l-pattern-1'
        },
        1 : {
            name : 'Pattern 2',
            className : 'l-pattern-2'
        },
        2 : {
            name : 'Pattern 3',
            className : 'l-pattern-3'
        },
        3 : {
            name : 'Pattern 4',
            className : 'l-pattern-4'
        },
        4 : {
            name : 'Pattern 5',
            className : 'l-pattern-5'
        },
        5 : {
            name : 'Pattern 6',
            className : 'l-pattern-6'
        },
        6 : {
            name : 'Pattern 7',
            className : 'l-pattern-7'
        },
        7 : {
            name : 'Pattern 8',
            className : 'l-pattern-8'
        }
    },
    patterns_fixed : {
        0 : {
            name : 'Pattern 1',
            className : 'f-pattern-1'
        },
        1 : {
            name : 'Pattern 2',
            className : 'f-pattern-2'
        },
        2 : {
            name : 'Pattern 3',
            className : 'f-pattern-3'
        },
        3 : {
            name : 'Pattern 4',
            className : 'f-pattern-4'
        },
        4 : {
            name : 'Pattern 5',
            className : 'f-pattern-5'
        },
        5 : {
            name : 'Pattern 6',
            className : 'f-pattern-6'
        },
        6 : {
            name : 'Pattern 7',
            className : 'f-pattern-7'
        },
        7 : {
            name : 'Pattern 8',
            className : 'f-pattern-8'
        },
        8 : {
            name : 'Pattern 9',
            className : 'f-pattern-9'
        },
        9 : {
            name : 'Pattern 10',
            className : 'f-pattern-10'
        },
        10 : {
            name : 'Pattern 11',
            className : 'f-pattern-11'
        },
        11 : {
            name : 'Pattern 12',
            className : 'f-pattern-12'
        }
    }
}

/* Page config --> End */

$(function() {

    /* Theme controller --> Begin */
	
    var $body = $("body");
		$("#wrapper").append('<div id="control_panel"><a href="#" id="control_label"></a></div>');
		var $theme_control_panel = $('#control_panel');
	
	var layout = jQuery.cookie('layout'),
		skin = jQuery.cookie('skin');
		bgcolor = jQuery.cookie('bgcolor'),
		patternfixed = jQuery.cookie('patternfixed'),
		patternliquid = jQuery.cookie('patternliquid');
		
		$body.addClass('l-pattern-1 f-pattern-1');
		
    function changeBodyClass(className, classesArray) {
        $.each(classesArray,function(idx, val) {
           $body.removeClass(val);
        });
        $body.addClass(className);
    }
	
	function addCookieLayout() {
		$body.removeClass('liquid fixed').addClass(layout);
	}	
	
	function addCookieSkin() {
		$body.removeClass('light dark').addClass(skin);
	}	
	
	function addBgColors() {
		$body.attr('style', 'background-color:' + " " + bgcolor);
	}

	function addClassPatFixed() {
		var pat = new Array();
		$.each(page_config.patterns_fixed, function(idx, val) {
			var pattern_list = val.className;
			pat.push(pattern_list);
		});
		var $join = pat.join(" ");
		$body.removeClass(function() {
			var $join = pat.join(" ");
			return $join;
		}).addClass(patternfixed);
	}

	function addClassPatLiquid() {
		var pat = new Array();
		$.each(page_config.patterns_liquid, function(idx, val) {
			var pattern_list = val.className;
			pat.push(pattern_list);
		});
			
		$body.removeClass(function() {
			var $join = pat.join(" ");
			return $join;
		}).addClass(patternliquid);
	}
	
	if (layout) {
		addCookieLayout();
	}
	if (skin) {
		addCookieSkin();
	}
	if (bgcolor) {
		addBgColors();
	}
	if (patternfixed) {
		addClassPatFixed();
	}
	if (patternliquid) {
		addClassPatLiquid();
	}

		var $heading = $('<h5/>').text('Choose Your Style').addClass('control_panel_title');
		
		$theme_control_panel.append($heading);


    if (typeof page_config != 'undefined' && $theme_control_panel) {

		var pattern_classes_fixed = new Array();
		var pattern_classes_liquid = new Array();
		var layout_classes = new Array();
		var skin_classes = new Array();
		
		var defaultSettings = {};
		
		/* Layout --> Begin */
		
		if (page_config.layout) {
            var $layout_block = $('<div/>').attr('id','layout').addClass('layout');
            var change_html = '<span>Layout Type</span>';
            change_html += '<form>';
            $.each(page_config.layout, function(idx, val) {
					if ($body.hasClass(val.className)) {
						change_html += '<label><input checked type="radio" name="'+ val.name +'" value="'+ val.title +'" class="'+ val.className +'">'+ val.title +'</label>';
						defaultSettings.pattern = idx;
					} else {
						change_html += '<label><input type="radio" name="'+ val.name +'" value="'+ val.title +'" class="'+ val.className +'">'+ val.title +'</label>';
					}
                layout_classes.push(val.className);
            });

            change_html += '</form>';
		
            $layout_block.html(change_html);
            $theme_control_panel.append($layout_block);
			

            $layout_block.find('input[type=radio]').change(function() {
				var $this = $(this),
					$checked = $this.attr('checked'),
					nextClassName = $this.attr('value');
				
				if(nextClassName == 'liquid') {
					$links_bg_wrapper.css('display','none');
					$layout_block_fixed.css('display','none');
					$layout_block_liquid.css('display','block');
					$body.attr('style','');
					bg_picker.css('background-color','#393f38');
					$input_bg_color.attr('value','#393f38');
					$.cookie('bgcolor', null);
				} else {
					$links_bg_wrapper.css('display','block');
					$layout_block_fixed.css('display','block');
					$layout_block_liquid.css('display','none');
					if($body.hasClass('light')) {
						bg_picker.css('background-color','#393F38');
						$input_bg_color.attr('value','#393f38');
					} else {
						bg_picker.css('background-color','#CDD2CC');
						$input_bg_color.attr('value','#cdd2cc');
					}
				}
		
				jQuery.cookie('layout', nextClassName);
				
                if (!$body.hasClass(nextClassName)) {
                    changeBodyClass(nextClassName, layout_classes);
                    $(this).parent().addClass('active');
				}				
                return false;
            });
		}
		
		/* Layout --> End */
		
		/* Skin --> Begin */
		
		if (page_config.skin) {
            var $skin_block = $('<div/>').attr('id','skin').addClass('skin');
            var change_skin_html = '<span>Layout Skin</span>';
            change_skin_html += '<form>';
            $.each(page_config.skin, function(idx, val) {
					if ($body.hasClass(val.className)) {
						change_skin_html += '<label><input checked type="radio" name="'+ val.name +'" value="'+ val.title +'" class="'+ val.className +'">'+ val.title +'</label>';
						defaultSettings.skin = idx;
					} else {
						change_skin_html += '<label><input type="radio" name="'+ val.name +'" value="'+ val.title +'" class="'+ val.className +'">'+ val.title +'</label>';
					}
                skin_classes.push(val.className);
            });

            change_skin_html += '</form>';
		
            $skin_block.html(change_skin_html);
            $theme_control_panel.append($skin_block);

            $skin_block.find('input[type=radio]').change(function() {
				var $this = $(this),
					$checked = $this.attr('checked'),
					nextClassName = $this.attr('value');
					if($body.hasClass('fixed')) {
						if(nextClassName == 'light') {
							bg_picker.css('background-color','#393F38');
							$input_bg_color.attr('value','#393f38');
							$body.css('background-color','#393f38');
						} else {
							bg_picker.css('background-color','#CDD2CC');
							$input_bg_color.attr('value','#cdd2cc');
							$body.css('background-color','#cdd2cc');
						}
					}
				jQuery.cookie('skin', nextClassName);
				
                if (!$body.hasClass(nextClassName)) {
                    changeBodyClass(nextClassName, skin_classes);
				}				
				
                return false;
            });
		}
		
		/* Skin --> End */
		
		
		/* Background color --> Begin */

		var $bg_color = $('<div/>').attr({id : 'bgpicker'}).addClass('bgPicker');
			var	$links_bg_wrapper = $('<div/>').addClass('bg_color_wrapper clearfix');
				$links_bg_wrapper.append('<span>Background Color</span>', $bg_color);
			var $input_bg_color = $('<input readonly type="text">').addClass('bg_hex_color').attr('value', '#3e443d');
				$links_bg_wrapper.append($input_bg_color, $bg_color);

				$theme_control_panel.append($links_bg_wrapper);
				
				if($body.hasClass('liquid')) {
					$links_bg_wrapper.css('display','none');
				} else {
					$links_bg_wrapper.css('display','block');
				}

		var bg_picker = $('#bgpicker');
				
			bg_picker.css('background-color','#3e443d').ColorPicker({
					color: '#3e443d',
					onChange: function (hsb, hex, rgb) {
						$input_bg_color.attr({value : '#' + hex})
						bg_picker.css('background-color','#' + hex);
						$body.css('background-color', '#' + hex);
						
						jQuery.cookie('bgcolor', "#" + hex);
						
					}
				});		
		
		/* Background color --> End */
		
		
		/* Patterns Liquid --> Begin */
		
        if (page_config.patterns_liquid) {
            var $layout_block_liquid = $('<div/>').attr('id','patterns_liquid');
            var change_html_liquid = '<span>Pattern</span>';
            change_html_liquid += '<ul>';
            $.each(page_config.patterns_liquid, function(idx, val) {
                if ($body.hasClass(val.className)) {
                    defaultSettings.pattern = idx;
                }
                change_html_liquid += '<li><a href="' + val.className + '" title="' + val.name + '" class="' + val.className + '"></a></li>';
                pattern_classes_liquid.push(val.className);
            });
            change_html_liquid += '</ul>';
            $layout_block_liquid.html(change_html_liquid);
            $theme_control_panel.append($layout_block_liquid);

            $layout_block_liquid.find('a').click(function() {
					
				var nextClassName = $(this).attr('href');
				if (!$body.hasClass(nextClassName)) {
					changeBodyClass(nextClassName, pattern_classes_liquid);
					$layout_block_liquid.find('.active').removeClass('active');
					$(this).parent().addClass('active');
				}
				
				jQuery.cookie('patternliquid', nextClassName);
				
                return false;
            });
        }
		
		/* Patterns Liquid --> End */
		
		
		/* Patterns Fixed --> Begin */
		
        if (page_config.patterns_fixed) {
            var $layout_block_fixed = $('<div/>').attr('id','patterns_fixed');
            var change_html_fixed = '<span>Pattern</span>';
            change_html_fixed += '<ul>';
            $.each(page_config.patterns_fixed, function(idx, val) {
                if ($body.hasClass(val.className)) {
                    defaultSettings.pattern = idx;
                }
                change_html_fixed += '<li><a href="' + val.className + '" title="' + val.name + '" class="' + val.className + '"></a></li>';
                pattern_classes_fixed.push(val.className);
            });
            change_html_fixed += '</ul>';
            $layout_block_fixed.html(change_html_fixed);
            $theme_control_panel.append($layout_block_fixed);

            $layout_block_fixed.find('a').click(function() {
					
				var nextClassName = $(this).attr('href');
				if (!$body.hasClass(nextClassName)) {
					changeBodyClass(nextClassName, pattern_classes_fixed);
					$layout_block_fixed.find('.active').removeClass('active');
					$(this).parent().addClass('active');
				}
				
				jQuery.cookie('patternfixed', nextClassName);
				
                return false;
            });
        }
		
		/* Patterns Fixed --> End */
		
		if($body.hasClass('liquid')) {
				$layout_block_fixed.css('display','none');
				$layout_block_liquid.css('display','block');
			} else {
				$layout_block_fixed.css('display','block');
				$layout_block_liquid.css('display','none');
		}
				
		/* Reset Settings  --> Begin */

		var setDefaultsSettings = function() {
			$body.attr('style','');
			$.cookie('layout', null);
			$.cookie('skin', null);
			$.cookie('patternfixed', null);
			$.cookie('patternliquid', null);
			$.cookie('bgcolor', null);
			$body.removeClass().addClass('liquid light l-pattern-1 f-pattern-1');
			$links_bg_wrapper.css('display','none');
			$layout_block_fixed.css('display','none');
			$layout_block_liquid.css('display','block');
			bg_picker.css({'background-color':'#3e443d'}).ColorPickerSetColor('#3e443d');
			$input_bg_color.attr('value','#3e443d');
			$('.layout').find('input[type=radio]').first().attr('checked','checked');
			$('.skin').find('input[type=radio]').first().attr('checked','checked');
			$theme_control_panel.find('.active').removeClass();
			return false;
		};
		
		var $restore_button_wrapper = $('<div/>').addClass('restore_button_wrapper');
		var $restore_button = $('<a/>').text('Reset').attr('id','restore_button').addClass('button-style-2 small').click(setDefaultsSettings);
		$restore_button_wrapper.append($restore_button);
		$theme_control_panel.append($restore_button_wrapper);

		/* Reset Settings  --> Begin */

	}

	/* Styles --> End */

	/* Control Panel Label --> Begin */		

	var $theme_control_panel_label = $('#control_label');
	$theme_control_panel_label.click(function() {
		
		if ($theme_control_panel.hasClass('visible')) {
			$(this).stop(true,false).animate({right : '-35px'});
			$theme_control_panel.animate({left: -185}, 400, function() {
					$theme_control_panel.removeClass('visible');
			});
		}
		else {
			$(this).stop(true,false).animate({right : '0'});
			$theme_control_panel.animate({left: 0}, 400, function() {
					$theme_control_panel.addClass('visible');
			});
		}
		return false;
	});
		
	/* Control Panel Label --> End */	
	
})
