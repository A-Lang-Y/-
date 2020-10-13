/*!
* Fancyform - jQuery Plugin
* Simple and fancy form styling alternative
*
* Examples and documentation at: https://github.com/Lutrasoft/Fancyform
* 
* Copyright (c) 2010-2013 - Lutrasoft
* 
* Version: 1.4.1
* Requires: jQuery v1.6.1+ 
*
* Dual licensed under the MIT and GPL licenses:
*   http://www.opensource.org/licenses/mit-license.php
*   http://www.gnu.org/licenses/gpl.html
*/
(function ($) {
    $.simpleEllipsis = function (t, c) {
        return t.length < c ? t : t.substring(0, c) + "...";
    }

	var _touch = false,//!!('ontouchstart' in window),
		_removeClasses = function(){
			var _this = $(this),
				options = _this.data("options") || _this.data("settings"),
				k;
				
			for(k in options)
			{
				_this.parent().removeClass(k);
			}
		};
	
    $.fn.extend({
        /*
        Get the caret on an textarea
        */
        caret: function (start, end) {
            var elem = this[0], val = this.val(), r, re, rc;

            if (elem) {
                // get caret range
                if (typeof start == "undefined") {
                    if (elem.selectionStart) {
                        start = elem.selectionStart;
                        end = elem.selectionEnd;
                    }
                    // <= IE 8
                    else if (document.selection) {
                        this.focus();

                        r = document.selection.createRange();
                        if (r == null) {
                            return { start: 0, end: e.value.length, length: 0 }
                        }

                        re = elem.createTextRange();
                        rc = re.duplicate();

                        re.moveToBookmark(r.getBookmark());
                        rc.setEndPoint('EndToStart', re);

                        // IE counts a line (not \n or \r) as 1 extra character
                        return { start: rc.text.length - (rc.text.split("\n").length + 1) + 2, end: rc.text.length + r.text.length - (rc.text.split("\n").length + 1) + 2, length: r.text.length, text: r.text };
                    }
                }
                // set caret range
                else {
                    if (typeof end != "number") end = -1;
                    if (typeof start != "number" || start < 0) start = 0;
                    if (end > val.length) end = val.length;
					
                    end = Math.max(start, end);
                    start = Math.min(start, end);

                    elem.focus();

                    if (elem.selectionStart) {
                        elem.selectionStart = start;
                        elem.selectionEnd = end;
                    }
                    else if (document.selection) {
                        r = elem.createTextRange();
                        r.collapse(true);
                        r.moveStart("character", start);
                        r.moveEnd("character", end - start);
                        r.select();
                    }
                }

                return { start: start, end: end };
            }
        },
        /*
        Replace checkboxes with images
        */
        transformCheckbox: function (settings) {

            var defaults = {
					base : "image", // Can be image/class
					checked: "",
					unchecked: "",
					disabledChecked: "",
					disabledUnchecked: "",
					tristateHalfChecked: "",
					changeHandler: function (is_checked) { },
					trigger: "self", // Can be self, parent
					tristate: 0
				},
			options = $.extend(defaults, settings),
			method = {
                // Handling the image
                setImage: function () {
                    var cb = $(this),
                        settings = cb.data('settings'),
                        src;

                    if (cb.is(":disabled")) {
                        src = cb.is(":checked") ? "disabledChecked" : "disabledUnchecked";
                    }
                    else if (cb.hasClass("half-checked")) // Tri-state image
                    {
                        src = "tristateHalfChecked";
                    }
                    else if (cb.is(":checked")) {
                        src = "checked";
                    }
                    else {
                        src = "unchecked";
                    }
					
					if( settings.base == "image" )
					{
						cb.next().attr("src", settings[src]);
                        
                        if (cb[0].type == 'radio') {
                            //src=="checked"?cb.next().addClass('checked'):cb.next().removeClass('checked');
                            
                            cb.next().removeAttr('src');
                            src=="checked"?cb.next().addClass('checked').removeClass('unchecked'):cb.next().removeClass('checked').addClass('unchecked');
                        }
					}
					else
					{
						_removeClasses.call(this);
						cb.parent().addClass(src);
					}
                },
                setProp: function (el, name, bool) {
                    $(el).prop(name, bool).change();
                    method.setImage.call(el);

					// Checked and radio, change others
					if( name == "checked" && !$(el).data('settings').type )
					{
                        $("[name='" + $(el).attr("name") + "']").each(function(){
							method.setImage.call(this);
						});
					}
                },
                // Handling the check/uncheck/disable/enable functions
                uncheck: function () {
                    method.setProp(this, "checked", 0);
                },
                check: function () {
                    method.setProp(this, "checked", 1);
                },
                disable: function () {
                    method.setProp(this, "disabled", 1);
                },
                enable: function () {
                    method.setProp(this, "disabled", 0);
                },
                // Clicking the image
                imageClick: function () {
                    var _this = $(this),
						settings = _this.data('settings');
						
                    if (!_this.is(":disabled")) {
                        if (_this.is(":checked") && settings.type) {
							method.uncheck.call(_this);
							options.changeHandler.call(_this, 1);
						}
						else {
							method.check.call(_this);
							options.changeHandler.call(_this, 0);
						}
						method.handleTriState.call(_this);
                    }
                },
                // Tristate
                handleTriState: function () {
                    var cb = $(this),
						settings = cb.data('settings'),
						li = cb.parent(),
						ul = li.find("ul"),
						pli = li.closest("li");

                    if (settings.tristate)
					{
						// Fix children
						if (cb.hasClass("half-checked") || cb.is(":checked")) {
							cb.removeClass("half-checked");
							method.check.call(cb);
							ul.find("input:checkbox").removeClass("half-checked").each(method.check);
						}
						else if (cb.not(":checked")) {
							cb.removeClass("half-checked");
							ul.find("input:checkbox").each(method.uncheck);
						}
						ul.find("input:checkbox").each(method.setImage);

						// Fix parents
						if (cb.parent().parent().parent().is("li")) {
							method.handleTriStateLevel.call(cb.parent().parent().parent());
						}

						cb.trigger("transformCheckbox.tristate");
					}
                },
                // Handle all including parent levels
                handleTriStateLevel: function () {
                    var _this = $(this),
						firstCheckbox = _this.find("input:checkbox").first(),
						ul = _this.find("ul"),
						inputs = ul.find("input:checkbox"),
						checked = inputs.filter(":checked");

                    firstCheckbox.removeClass("half-checked");

                    if (inputs.length == checked.length) {
                        method.check.call(firstCheckbox);
                    }
                    else if (checked.length) {
                        firstCheckbox.addClass("half-checked");
                    }
                    else {
                        method.uncheck.call(firstCheckbox);
                    }
                    method.setImage.call(firstCheckbox);

                    if (_this.parent().parent().is("li")) {
                        method.handleTriStateLevel.call(_this.parent().parent());
                    }
                }
            }

            return this.each(function () {
                if (typeof settings == "string") {
                    method[settings].call(this);
                }
                else {
                    var _this = $(this);

                    // Is already initialized
                    if (!_this.data("tf.init")) {
						// set initialized
						_this.data("tf.init", 1)
							   .data("settings", options);

						options.type = _this.is("[type=checkbox]");
						
						// Radio hide
						_this.hide();

						// Afbeelding
						if( options.base == "image" )
						{
                            _this.after("<strong></strong>");
						}
						else
						{
							_this.wrap("<span class='trans-element-" + (options.type ? "checkbox" : "radio") + "' />");
						}
						method.setImage.call(this);

						if( options.base == "image" )
						{
							switch (options.trigger) {
								case "parent":
									_this.parent().click($.proxy(method.imageClick, this));
									break;
								case "self":
                                    _this.next("strong").click($.proxy(method.imageClick, this));
									break;
							}
						}
						else
						{
							switch (options.trigger) {
								case "parent":
									_this.parent().parent().click($.proxy(method.imageClick, this));
									break;
								case "self":
									_this.parent().click($.proxy(method.imageClick, this));
									break;
							}
						}
					}
                }
            });
        },
        /*
        Replace select with list
        =========================
        HTML will look like
        <ul>
        <li><span>Selected value</span>
        <ul>
        <li data-settings='{"alwaysvisible" : true}'><span>Option</span></li>
        <li><span>Option</span></li>
        </ul>
        </li>
        </ul>
        */
        transformSelect: function (opts) {
            var defaults = {
                dropDownClass: "transformSelect",
                showFirstItemInDrop: 1,

                acceptManualInput: 0,
                useManualInputAsFilter: 0,

                subTemplate: function (option) {
                    if ($(this)[0].type == "select-multiple") {

                        return "<span><input type='checkbox' value='" + $(option).val() + "' " + ($(option).is(":selected") ? "checked='checked'" : "") + " name='" + $(this).attr("name").replace("_backup", "") + "' />" + $(option).text() + "</span>";
                    }
                    else {
                        return "<span>" + $(option).text() + "</span>";
                    }
                },
                initValue: function () { return $(this).text(); },
                valueTemplate: function () { return $(this).text(); },

                ellipsisLength: null,
                addDropdownToBody: 0
            };

            var options = $(this).data("settings"),
			method = {
                init: function () {
                    // Generate HTML
                    var _this = this,
						t = $(_this),
						selectedIndex = 0,
                        selectedOption = t.find("option:first");

					// Hide mezelf
                    t.hide();
					
                    if (t.find("option:selected").length && _this.type != "select-multiple") {
                        selectedOption = t.find("option:selected");
                        selectedIndex = t.find("option").index(selectedOption);
                    }

                    // Maak een ul aan
                    var ul = "<ul class='" + options.dropDownClass + " trans-element'><li>";

                    if (options.acceptManualInput && !_touch) {
                        var value = t.data("value") || options.initValue.call(selectedOption);
                        ul += "<ins></ins><input placeHolder="+value+" autocomplete='off' type='text' name='" + t.attr("name").replace("_backup", "") + "' data-constraints='"+t.attr('data-constraints')+"' />";

                        t.attr('data-constraints','');

                        // Save old select
                        if (t.attr("name").indexOf("_backup") < 0) {
                            t.attr("name", t.attr("name") + "_backup");
                        }
                    }
                    else {
                        if (options.ellipsisLength) {
                            ul += "<span title=\"" + selectedOption.text() + "\">" + $.simpleEllipsis(options.initValue.call(selectedOption), options.ellipsisLength) + "</span>";
                        }
                        else {
                            ul += "<span>" + options.initValue.call(selectedOption) + "</span>";
                        }
                    }

                    ul += "<ul style='display: none;'>";

                    t.children().each(function (i) {
                        if (!i && !options.showFirstItemInDrop) {
                            // Don't do anything when you don't wanna show the first element
                        }
                        else {
                            ul += method[
								this.tagName == "OPTION" ? "getLIOptionChild" : "getLIOptgroupChildren"
							].call(_this, this);
                        }
                    });

                    ul += "</ul></li></ul>";

                    var $ul = $(ul),
						$lis = $ul.find("ul li:not(.group)"),
						$inp = $ul.find("input"),
                        $ulul = $ul.find('ul'),
                        $li = $ulul.find("li");
                    t.after($ul);

                    $ulul.css('display','block');
                    
                    if ($li.length*$li.height() > parseInt($ulul.css('maxHeight'))) {
                        $ulul.css('overflow-y','scroll');
                    }
                    $ulul.css('display','none');


                    // Bind handlers
                    if (t.is(":disabled")) {
                        method.disabled.call(_this, 1);
                    }

                    if (_this.type == "select-multiple" && !_touch) {
                        if (t.attr("name") && t.attr("name").indexOf("_backup") == -1) {
                            t.attr("name", t.attr("name") + "_backup");
                        }
                        $lis.click(method.selectCheckbox);
                    }
                    else {
                        $lis.click(method.selectNewValue);

                        $inp.click(method.openDrop)
                    				.keydown(function (e) {
                    				    // Tab or enter
                    				    if ($.inArray(e.which, [9, 13]) >= 0)
                    				        method.closeAllDropdowns();
                    				})
                                    .prev("ins")
                                    .click(method.openDrop);
                    }

                    if (options.useManualInputAsFilter) {
                        $inp.keyup(method.filterByInput);
                    }

                    $ul.find("span:first").click(method.openDrop);

                    // Set data if we use addDropdownToBody option
                    $ul.find("ul:first").data("trans-element", $ul).addClass("transformSelectDropdown");
                    $ul.data("trans-element-drop", $ul.find("ul:first"));

                    if (options.addDropdownToBody) {
                        $ul.find("ul:first").appendTo("body");
                    }

                    // Check if there is already an event
                    $("html").unbind("click.transformSelect").bind("click.transformSelect", method.closeDropDowns)                    // Bind hotkeys

                    if ($.hotkeys && !$("body").data("trans-element-select")) {
                        $("body").data("trans-element-select", 1);

                        $(document)
                            .bind("keydown", "up", function (e) {
                                var ul = $(".trans-focused"), select, selectedIndex;
                                // Only enable on trans-element without input
                                if (!ul.length || ul.find("input").length) return 0;
                                select = ul.prevAll("select").first();

                                selectedIndex = select[0].selectedIndex - 1
                                if (selectedIndex < 0) {
                                    selectedIndex = select.find("option").length - 1;
                                }

                                method.selectIndex.call(select, selectedIndex);

                                return 0;
                            })
                            .bind("keydown", "down", function (e) {
                                var ul = $(".trans-focused"), select, selectedIndex;
                                // Only enable on trans-element without input
                                if (!ul.length || ul.find("input").length) return 0;
                                select = ul.prevAll("select").first();

                                selectedIndex = select[0].selectedIndex + 1
                                if (selectedIndex > select.find("option").length - 1) {
                                    selectedIndex = 0;
                                }

                                method.selectIndex.call(select, selectedIndex);
                                return 0;
                            });
                    }

                    // Gebruik native selects
                    if (_touch) {
                        if (!options.showFirstItemInDrop) {
                            t.find("option:first").remove();
                        }
                        t	.appendTo($ul.find("li:first"))
                            .show()
                            .css({
                                opacity: 0,
                                position: "absolute",
                                width: "100%",
                                height: "100%",
                                left: 0,
                                top: 0
                            });
                        $ul.find("li:first").css({
                            position: "relative"
                        });
                        t.change(method.mobileChange);
                    }
                },
                getUL: function () {
                    return _touch ? $(this).closest("ul") : $(this).next(".trans-element:first");
                },
                getSelect: function ($ul) {
                    return _touch ? $ul.find("select") : $ul.prevAll("select:first");
                },
                disabled: function (disabled) {
                    method.getUL.call(this)[disabled ? "addClass" : "removeClass"]("disabled");
                },
                repaint: function () {
                    var ul = method.getUL.call(this);
                    ul.data("trans-element-drop").remove();
                    ul.remove();

                    method.init.call(this);
                },
                filterByInput: function () {
                    var _this = $(this),
						val = _this.val().toLowerCase(),
                        ul = _this.closest("ul"),
                        drop = ul.data("trans-element-drop"),
                        li = drop.find("li");

                    if (!val) {
                        li.show();
                    }
                    else {
                        li.each(function () {
							var _li = $(this);
                            if (!!_li.data("settings").alwaysvisible) {
                                _li.show();
                            }
                            else {
                                _li[_li.text().toLowerCase().indexOf(val) < 0 ? "hide" : "show"]();
                            }
                        });
                    }
                },
                selectIndex: function (index) {
                    var select = $(this),
                        ul = method.getUL.call(this),
                        drop = ul.data("trans-element-drop");

                    try {
                        drop.find("li").filter(function () {
                        }).first().trigger("click");
                            return $(this).text() == select.find("option").eq(index).text();
                    }
                    catch (e) { }
                },
                selectValue: function (value) {
                    var select = $(this),
                        ul = method.getUL.call(this),
                        drop = ul.data("trans-element-drop");

                    method.selectIndex.call(this, select.find(value ? "option[value='" + value + "']" : "option:not([value])").index());
                },
                /*
                *	GET option child
                */
                getLIOptionChild: function (option) {
                    var settings = $(option).attr("data-settings") || '',
						cls = ($(option).attr('class') || '') + 
									($(option).is(":selected") ? ' selected' : '');

                    return "<li data-settings='" + settings + "' class='" + cls + "'>" + options.subTemplate.call(this, $(option)) + "</li>";
                },
                /*
                *	GET optgroup children
                */
                getLIOptgroupChildren: function (group) {
                    var _this = this,
						li = "<li class='group'><span>" + $(group).attr("label") + "</span><ul>";

                    $(group).find("option").each(function () {
                        li += method.getLIOptionChild.call(_this, this);
                    });

                    li += "</ul></li>";

                    return li;
                },
                getLIIndex: function (el) {
                    var index = 0, group = el.closest(".group"), sel;
                    if (group.length) {
                        index = el.closest(".transformSelectDropdown").find("li").index(el) - group.prevAll(".group").length - 1;
                    }
                    else {
                        index = el.parent().find("li").index(el) - el.prevAll(".group").length;
                    }
                    if (!options.showFirstItemInDrop) {
	            	index += 1;
	            }
                    return index;
                },
                /*
                *	Select a new value
                */
                selectNewValue: function () {
                    var _this = $(this),
						$drop = _this.closest(".transformSelectDropdown"),
						$ul = $drop.data("trans-element"),
                        select = method.getSelect($ul),
                        index = method.getLIIndex(_this);

                    select[0].selectedIndex = index;

                    // If it has an input, there is no span used for value holding
                    if ($ul.find("input").length) {
                        $ul.find("input").val(options.valueTemplate.call(_this));
                    }
                    else {
                        sel = select.find("option:selected");
                        $ul
							.find("span:first")
							.html(
								options.ellipsisLength
								? $.simpleEllipsis(options.valueTemplate.call(sel), options.ellipsisLength)
								: options.valueTemplate.call(sel)
							);
                    }
					
					// Set selected
					$drop.find(".checked").removeClass("checked");
					_this.addClass("checked");

                    method.closeAllDropdowns();

                    // Trigger onchange
                    select.trigger("change");

                    $(".trans-element").removeClass("trans-focused");
                    $ul.addClass("trans-focused");

                    // Update validator
                    if ($.fn.validate) {
                        select.valid();
                    }
                },
                mobileChange: function () {
                    var select = $(this),
						$ul = method.getUL.call(this),
						sel = select.find("option:selected");

					if (this.type != "select-multiple") {
						$ul
						.find("span:first")
						.html(
							options.ellipsisLength
							? $.simpleEllipsis(options.valueTemplate.call(sel), options.ellipsisLength)
							: options.valueTemplate.call(sel)
						);
					}
                },
                selectCheckbox: function (e) {
                    var _this = $(this),
						$drop = _this.closest(".transformSelectDropdown"),
						$ul = $drop.data("trans-element"),
                        select = method.getSelect($ul),
                        t = _this.closest("li"),
                        checkbox = t.find(":checkbox"),
                        index, group;

                    if ($(e.target).is("li")) {
                        t = _this;
                    }

                    index = method.getLIIndex(t);

                    if (!$(e.target).is(":checkbox")) {
                        checkbox.prop("checked", !checkbox.is(":checked"));
                    }

                    select.find("option").eq(index).prop("selected", checkbox.is(":checked"));

                    if (checkbox.data("tfc.init")) {
                        checkbox.transformCheckbox("setImage");
                    }

                    if (!$(e.target).is(":checkbox")) {
                        checkbox.change();
                    }
                    select.change();
                },
                /*
                *	Open clicked dropdown
                *		and Close all others
                */
                openDrop: function () {
                    var UL = $(this).closest(".trans-element"),
                        childUL = UL.data("trans-element-drop"),
						childLI = $(this).parent();

                    if (UL.hasClass("disabled")) {
                        return 0;
                    }

                    // Close on second click
                    if (childLI.hasClass("open") && !$(this).is("input")) {
                        method.closeAllDropdowns();
                    }
                    // Open on first click
                    else {
                        childLI
							//.css({ 'z-index': 5 })
							.addClass("open");

                        childUL/*.css({ 'z-index': 5 })*/.show();

                        method.hideAllOtherDropdowns.call(this);
                    }

                    if (options.addDropdownToBody) {
                        childUL.css({
                            position: "absolute",
                            top: childLI.offset().top + childLI.outerHeight(),
                            left: childLI.offset().left
                        });
                    }
                },
                /*
                *	Hide all elements except this element
                */
                hideAllOtherDropdowns: function () {
                    // Hide elements with the same class
                    var allElements = $("body").find("*"),
						elIndex = allElements.index($(this).parent());

                    $("body").find("ul.trans-element").each(function () {
                        var childUL = $(this).data("trans-element-drop");

                        if (elIndex - 1 != allElements.index($(this))) {
                            childUL
                                   .hide()
                                  // .css('z-index', 0)
                                        .parent()
                                        //.css('z-index', 0)
                                        .removeClass("open");
                        }
                    });
                },
                /*
                *	Close all dropdowns
                */
                closeDropDowns: function (e) {
                    if (!$(e.target).closest(".trans-element").length) {
                        method.closeAllDropdowns();
                    }
                },
                closeAllDropdowns: function () {
                    $("ul.trans-element").each(function () {
                        $(this).data("trans-element-drop").hide();
                        $(this).find("li:first").removeClass("open")
                    }).removeClass("trans-focused");
                }
            }

            if (typeof opts == "string") {
                method[opts].apply(this, Array.prototype.slice.call(arguments, 1))
                return this;
            }
            return this.each(function () {
				var _this = $(this);
				
                // Is already initialized
                if (!_this.data("tfs.init")) {
                    options = $.extend(defaults, opts);
                    _this.data("settings", options);

                    // set initialized
                    _this.data("tfs.init", 1);

                    // Call init functions
                    method.init.call(this);
                }
            });
        },
        /*
        Transform a input:file to your own layout
        ============================================
        Basic CSS:
        <style>
        .customInput {
        display: inline-block;
        font-size: 12px;
        }
		
        .customInput .inputPath {
        width: 150px;
        padding: 4px;
        display: inline-block;
        border: 1px solid #ABADB3;
        background-color: #FFF;
        overflow: hidden;
        vertical-align: bottom;
        white-space: nowrap;
        -o-text-overflow: ellipsis;
        text-overflow:    ellipsis;
        }
		
        .customInput .inputButton {
        display: inline-block;
        padding: 4px;
        border: 1px solid #ABADB3;
        background-color: #CCC;
        vertical-align: bottom;
        }        </style>
        */
        transformFile: function (options) {
            var method = {
                file: function (fn, cssClass) {
                    return this.each(function () {
                        var el = $(this),
							holder = $('<div></div>').appendTo(el).css({
							    position: 'absolute',
							    overflow: 'hidden',
							    '-moz-opacity': '0',
							    filter: 'alpha(opacity: 0)',
							    opacity: '0',
							    zoom: '1',
							    width: el.outerWidth() + 'px',
							    height: el.outerHeight() + 'px',
							    'z-index': 1
							}),
							wid = 0,
							inp,
							addInput = function () {
							    var current = inp = holder.html('<input ' + (window.FormData ? 'multiple ' : '') + ' type="file" style="border:none; position:absolute">').find('input');

							    wid = wid || current.width();

							    current.change(function () {
							        current.unbind('change');

							        addInput();
							        fn(current[0]);
							    });
							},
							position = function (e) {
							    holder.offset(el.offset());
							    if (e) {
							        inp.offset({ left: e.pageX - wid + 25, top: e.pageY - 10 });
							        addMouseOver();
							    }
							},
							addMouseOver = function () {
							    el.addClass(cssClass + 'MouseOver');
							},
							removeMouseOver = function () {
							    el.removeClass(cssClass + 'MouseOver');
							};

                        addInput();

                        el.mouseover(position);
                        el.mousemove(position);
                        el.mouseout(removeMouseOver);
                        position();
                    });
                }
            };

            return this.each(function (i) {
                // Is already initialized
                if (!$(this).data("tff.init")) {
                    // set initialized
					$(this).data("tff.init", 1);

					// 
					var el = $(this).hide(),
						id = null,
						name = el.attr('name'),
						cssClass = (!options ? 'customInput' : (options.cssClass ? options.cssClass : 'customInput')),
						label = (!options ? 'Browse...' : (options.label ? options.label : 'Browse...'));

					if (!el.attr('id')) { el.attr('id', 'custom_input_file_' + (new Date().getTime()) + Math.floor(Math.random() * 100000)); }
					id = el.attr('id');

					el.after('<span id="' + id + '_custom_input" class="' + cssClass + '"><span class="inputPath" id="' + id + '_custom_input_path">&nbsp;</span><span class="inputButton">' + label + '</span></span>');

					method.file.call($('#' + id + '_custom_input'), function (inp) {
						inp.id = id;
						inp.name = name;
						$('#' + id).replaceWith(inp)
								   .removeAttr('style').hide();
						$('#' + id + '_custom_input_path').html($('#' + id).val().replace(/\\/g, '/').replace(/.*\//, ''));
					}, cssClass);
                }
            });

        },
        /*
        Replace a textarea
        */
        transformTextarea: function (options, arg1) {
            var defaults = {
                hiddenTextareaClass: "hiddenTextarea"
            },
				settings = $.extend(defaults, options),

				method = {
				    // Init the module
				    init: function () {
						var _this = $(this);
						
				        // This only happens in IE
				        if (_this.css("line-height") == "normal") {
				            _this.css("line-height", "12px");
				        }

				        // Set the CSS
				        var CSS = {
				            'line-height': _this.css("line-height"),
				            'font-family': _this.css("font-family"),
				            'font-size': _this.css("font-size"),
				            "border": "1px solid black",
				            "width": _this.width(),
				            "letter-spacing": _this.css("letter-spacing"),
				            "text-indent": _this.css("text-indent"),
				            "padding": _this.css("padding"),
				            "overflow": "hidden",
				            "white-space": _this.css("white-space")
				        };

				        _this
				        // Add a new textarea
								.css(CSS)
								.keyup(method.keyup)
								.keydown(method.keyup)
								.bind("mousewheel", method.mousewheel)
				        // Append a div
							.after($("<div />"))
								.next()
								.addClass(settings.hiddenTextareaClass)
								.css(CSS)
								.css("width", _this.width() - 5)	// Minus 5 because there is some none typeable padding?
								.hide()

				    },

				    // Mousewheel
				    mousewheel: function (e, delta) {
				        e.preventDefault();
				        var lineHeight = $(this).css("line-height"),
							scrollTo = $(this)[0].scrollTop + (parseFloat(lineHeight) * (delta * -1));
				        method.scrollToPx.call(this, scrollTo);
				    },
				    // Used to scroll 
				    keyup: function (e) {
				        // Check if it has to scroll
				        // Arrow keys down have to scroll down / up (only if to far)
				        /*
				        Keys:
				        37, 38, 39, 40  = Arrow keys (L,U,R,D)
				        13				= Enter
				        */
				        if ($.inArray(e.which, [37, 38, 39, 40]) >= 0) {
				            method.checkCaretScroll.call(this);
				        }
				        else {
				            method.checkScroll.call(this, e.which);
				        }

				        method.scrollCallBack.call(this);
				    },
				    /*
				    Check cursor position to scroll
				    */
				    checkCaretScroll: function () {
				        var src = $(this),
							caretStart = src.caret().start,
							val = src.val(),
							sTop = src.scrollTop(),
							lHeight = parseInt(src.css("line-height")),
							textBefore = val.substr(0, caretStart),
							textAfter = val.substr(caretStart),
							tar = src.next("." + settings.hiddenTextareaClass),
							vScroll;

				        // First or last element (don't do anything)
				        if ( caretStart ) {
							// Also pick the first char of a row
							if (val.substr(caretStart - 1, 1) == '\n') {
								textBefore = val.substr(0, caretStart + 1);
							}

							method.toDiv.call(this, 0, textBefore, textAfter);

							// If you go through the bottom
							if (tar.height() > (src.height() + sTop)) {
								vScroll = sTop + lHeight;
							}
							// if you go through the top
							else if (tar.height() <= sTop) {
								vScroll = sTop - lHeight;
							}

							// Scroll the px
							if (vScroll) {
								method.scrollToPx.call(this, vScroll);
							}
						}
				    },

				    // Check the old and new height if it needs to scroll
				    checkScroll: function (key) {
				        // Scroll if needed
				        var src = $(this),
							tar = src.next("." + settings.hiddenTextareaClass),

				        // Put into the div to check new height
							caretStart = src.caret().start,
							v = src.val(),
							textBefore = v.substr(0, caretStart),
							textAfter = v.substr(caretStart);

				        method.toDiv.call(this, 1, textBefore, textAfter);

				        // If your halfway the scroll, then dont scroll
				        if (
							(src.scrollTop() + src.height()) > tar.height()
						) {
				            return;
				        }

				        // Scroll if needed
				        if (tar.data("old-height") != tar.data("new-height")) {
				            var scrollDiff = tar.data("new-height") - tar.data("old-height");
				            method.scrollToPx.call(this, src.scrollTop() + scrollDiff);
				        }

				    },

				    // Place the value of the textarea into the DIV
				    toDiv: function (setHeight, html, textAfter) {
				        var src = $(this),
							tar = src.next("." + settings.hiddenTextareaClass),
							regEnter = /\n/g,
							regSpace = /\s\s/g,
							regSingleSpace = /\s/g,
							res = src.val(),
							appendEnter = 0,
							appendEnterSpace = 0,
							brXHTML = "<br />";
				        if (html)
				            res = html;

				        // If last key is enter
				        // 		or last key is space, and key before that was enter, then add enter
				        if (regEnter.test(res.substring(res.length - 1))) {
				            appendEnter = 1;
				        }

				        if (
								regEnter.test(res.substring(res.length - 2, res.length - 1)) &&
								regSingleSpace.test(res.substring(res.length - 1))
							) {
				            appendEnterSpace = 1;
				        }

				        // Set old and new height + set the content
				        if (setHeight)
				            tar.data("old-height", tar.height());

				        res = res	.replace(regEnter, "<br>") // No space or it will be replaced by the function below
									.replace(regSpace, "&nbsp; ")
									.replace(regSpace, "&nbsp; ") // 2x because 1x can result in: &nbsp;(space)(space) and that is not seen within the div
									.replace(/<br>/ig, brXHTML);
				        tar.html(res);

				        if ((appendEnter || appendEnterSpace) && $.trim(textAfter)) {
				            if (appendEnterSpace && $.browser.msie)
				                tar.append(brXHTML);
				            tar.append(brXHTML);
				        }

				        if (setHeight) {
				            tar.data("new-height", tar.height());
				        }
				    },

				    // Scroll to a given percentage
				    scrollToPercentage: function (perc) {
				        // Between 0 and 100
				        if (perc >= 0 && perc <= 100) {
				            var src = $(this),
								tar = src.next("." + settings.hiddenTextareaClass),
								maxScroll = parseFloat(src[0].scrollHeight) - src.height(),
								scrollT = maxScroll * perc / 100;

				            // Round on a row
				            method.scrollToPx.call(this, scrollT);
				        }
				    },

				    // Scroll to given PX
				    scrollToPx: function (px) {
						var _this = this;
				        // Round on a row
				        $(_this).scrollTop(method.roundToLineHeight.call(_this, px));
				        method.scrollCallBack.call(_this);
				    },

				    // Round to line height
				    roundToLineHeight: function (num) {
						var lh = parseInt($(this).css("line-height"));
				        return Math.ceil(num / lh) * lh;
				    },

				    // Reset to default
				    remove: function () {
				        $(this)
							.unbind("keyup")
							.css({
							    overflow: "auto",
							    border: ""
							})
						.next("div")
							.remove();
				    },
				    scrollCallBack: function () {
				        var _this = this,
							_$this = $(_this),
							_this0 = _$this[0],
							maxScroll = parseFloat(_this0.scrollHeight) - _$this.height(),
							percentage = parseFloat(_this0.scrollTop) / maxScroll * 100;
				        percentage = percentage > 100 ? 100 : percentage;
				        percentage = percentage < 0 ? 0 : percentage;
				        percentage = isNaN(percentage) ? 100 : percentage;
				        _$this.trigger("scrollToPx", [_this0.scrollTop, percentage]);
				    }
				};

            if (typeof options == "string") {
                method[options].call(this, arg1);
                return this;
            }
            return this.each(function () {
                if (!$(this).next().hasClass(settings.hiddenTextareaClass)) {
                    method.init.call(this);
                    method.toDiv.call(this, 1);
                }
            });
        }
    });

	// Radio and checkbox now use the same function
	$.fn.transformRadio = $.fn.transformCheckbox;
})(jQuery);
