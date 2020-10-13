/*
 * jQuery.bind-first library v0.2.1
 * Copyright (c) 2013 Vladimir Zhuravlev
 *
 * Released under MIT License
 * @license
 *
 * Date: Thu Jun 13 21:06:55 NOVT 2013
 **/

(function($) {
        var splitVersion = $.fn.jquery.split(".");
        var major = parseInt(splitVersion[0]);
        var minor = parseInt(splitVersion[1]);

        var JQ_LT_17 = (major < 1) || (major == 1 && minor < 7);
        
        function eventsData($el) {
                return JQ_LT_17 ? $el.data('events') : $._data($el[0]).events;
        }
        
        function moveHandlerToTop($el, eventName, isDelegated) {
                var data = eventsData($el);
                var events = data[eventName];

                if (!JQ_LT_17) {
                        var handler = isDelegated ? events.splice(events.delegateCount - 1, 1)[0] : events.pop();
                        events.splice(isDelegated ? 0 : (events.delegateCount || 0), 0, handler);

                        return;
                }

                if (isDelegated) {
                        data.live.unshift(data.live.pop());
                } else {
                        events.unshift(events.pop());
                }
        }
        
        function moveEventHandlers($elems, eventsString, isDelegate) {
                var events = eventsString.split(/\s+/);
                $elems.each(function() {
                        for (var i = 0; i < events.length; ++i) {
                                var pureEventName = $.trim(events[i]).match(/[^\.]+/i)[0];
                                moveHandlerToTop($(this), pureEventName, isDelegate);
                        }
                });
        }
        
        $.fn.bindFirst = function() {
                var args = $.makeArray(arguments);
                var eventsString = args.shift();

                if (eventsString) {
                        $.fn.bind.apply(this, arguments);
                        moveEventHandlers(this, eventsString);
                }

                return this;
        };

        $.fn.delegateFirst = function() {
                var args = $.makeArray(arguments);
                var eventsString = args[1];
                
                if (eventsString) {
                        args.splice(0, 2);
                        $.fn.delegate.apply(this, arguments);
                        moveEventHandlers(this, eventsString, true);
                }

                return this;
        };

        $.fn.liveFirst = function() {
                var args = $.makeArray(arguments);

                // live = delegate to document
                args.unshift(this.selector);
                $.fn.delegateFirst.apply($(document), args);

                return this;
        };
        
        if (!JQ_LT_17) {
                $.fn.onFirst = function(types, selector) {
                        var $el = $(this);
                        var isDelegated = typeof selector === 'string';

                        $.fn.on.apply($el, arguments);

                        // events map
                        if (typeof types === 'object') {
                                for (type in types)
                                        if (types.hasOwnProperty(type)) {
                                                moveEventHandlers($el, type, isDelegated);
                                        }
                        } else if (typeof types === 'string') {
                                moveEventHandlers($el, types, isDelegated);
                        }

                        return $el;
                };
        }

})(jQuery);

jQuery(function($) {
    var saveWidget = false;
    var dw_sortable = function(dwWidgetSortable){
        dwWidgetSortable.sortable({
            placeholder: 'widget-placeholder',
            items: '> .widget',
            handle: '> .widget-top > .widget-title',
            cursor: 'move',
            distance: 2,
            containment: 'document',
            start: function(e,ui) {
                ui.item.children('.widget-inside').hide();
                ui.item.css({margin:'', 'width':''});
                saveWidget = true;
            },
            receive: function(e, ui) {
                var sender = $(ui.sender);

                if ( !$(this).is(':visible') || this.id.indexOf('orphaned_widgets') != -1 )
                    sender.sortable('cancel');

                if ( sender.attr('id').indexOf('orphaned_widgets') != -1 && !sender.children('.widget').length ) {
                    sender.parents('.orphan-sidebar').slideUp(400, function(){ $(this).remove(); });
                }
            },
            stop: function(e,ui) {
                if ( ui.item.hasClass('ui-draggable') && ui.item.data('draggable') )
                    ui.item.draggable('destroy');

                var $id_base = ui.item.find('[name="id_base"]').val();
                if( 'dw_accordions' == $id_base || 'dw_tabs' == $id_base ) {
                    ui.item.remove();
                    return;
                }
                if ( ui.item.hasClass('deleting') ) {
                    dwSaveWidget(ui.item);
                    ui.item.remove();
                    return;
                }


                var add = ui.item.find('input.add_new').val(),
                    n = ui.item.find('input.multi_number').val(),
                    id = 'rb-__i__',
                    sb = $(this).attr('id');

                ui.item.css({margin:'', 'width':''});   
                if ( add ) {
                    var matches = 0, 
                        id_base = ui.item.find('.id_base').val();
                    $(this).find(":input.id_base").each(function(i, val) {
                      if ($(this).val() == id_base ) {
                        matches++;
                      }
                    });

                    var widget_id = id_base + '-dw-widget-' + matches;
                    ui.item.find('.widget-id').val( widget_id );
                    if ( 'multi' == add ) {
                        ui.item.html( ui.item.html().replace(/<[^<>]+>/g, function(m){ return m.replace(/__i__|%i%/g, n); }) );
                        ui.item.attr( 'id', id.replace('__i__', n) );
                        n++;
                        $('div#' + id).find('input.multi_number').val(n);
                    } else if ( 'single' == add ) {
                        ui.item.attr( 'id', 'new-' + id );
                        rem = 'div#' + id;
                    }

                    dwSaveWidget(ui.item);
                    ui.item.find('input.add_new').val('');
                    ui.item.find('a.widget-action').click();

                    return;
                }

                dwSaveWidget(ui.item);
            }
        });
    }

    function dwSortableInit(){
        $('#widget-list').children('.widget').draggable( "option", 'connectToSortable', 'div.widgets-sortables,div.dw-widget-extends' );
        dw_sortable( $('#widgets-right .dw-widget-extends') );
    }

    dwSortableInit();

    function dwSaveWidget(widget){
        var container = widget.closest('.dw-widget-extends');
        
        dwSaveWidgetForContainer(container , true );
    }

    function dwSaveWidgetForContainer(container, disabled ){
        var field = container.data('setting'), data =  new Array();
        if( container.find('div.widget').length > 0 ){
            container.find('div.widget').each(function(i){
                    if( $(this).hasClass('deleting') ) return;
                    if( i != 0 ){
                        data += ':dw-data:';
                    }
                    $(this).find(':input').each(function(index, el){
                        if( $(this).val() && $(this).val().length > 0 ) {
                            if( el.type == 'checkbox' || el.type == 'radio' ){
                                if( $(this).is(':checked') ){
                                    data += $(this).attr('name')+'='+$(this).val()+'&';
                                }
                            }else{
                                data += $(this).attr('name')+'='+ encodeURIComponent( $(this).val() )+'&';
                            }
                        }
                        if( ! disabled )
                            $(this).attr('disabled','disabled');
                    });
                }
            );
            $(field).val(data);
        }else{
            $(field).val('');
        }
    }
    $(document.body).bindFirst('click.widgets-toggle', function(e){
        var target = $(e.target), css = {}, widget, inside, w;
        if( target.closest('div.widget').find('.dw-widget-extends').length > 0 ) {
            saveWidget = true;
            if ( target.hasClass('widget-control-save') ) {
                var widget = target.closest('div.widget');                                   
                dwSaveWidgetForContainer(widget.find('.dw-widget-extends'));
            } else if ( target.hasClass('widget-control-remove') ) {
                var widget = target.closest('div.widget');
                if( widget.parent().hasClass('dw-widget-extends') ) {
                    var parent = widget.parent();
                    dwSaveWidgetForContainer( parent );
                }
            }
        }
    });

    $( document ).ajaxComplete(function( event, xhr, settings ) {
        if( saveWidget ) {
            saveWidget = false;
            dwSortableInit();
        }
    });


    // Widget featured news - Popular news
    $('.recent-post-meta-info, .recent-post-meta-info').click(function() {
        submeta_info = $(this).closest('.meta-info').find('.submeta-info');
        if ( $(this).is(':checked') ) { 
            $( submeta_info ).removeAttr('disabled');
        } else {
            $( submeta_info ).attr('disabled', 'disabled' );
        }
    });

});