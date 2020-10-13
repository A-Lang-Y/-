/*
 * jQuery Fill Parent
 * 
 * Author: Orkun Gursel 
 */
;(function ( $, window, document, undefined ) {
    "use strict";

    var pluginName = 'fillParent',
        defaults = {

        };
 
    function Plugin( element, options ) {
        this.element = element;
        this.options = $.extend( {}, defaults, options);
 
        this._defaults = defaults;
        this._name = pluginName;
 
        var that = this;
        this.init();
        jQuery(window).smartresize(function(){
            that.init();
        });
    }
 
    Plugin.prototype = {
        init: function () {

            var element = jQuery( this.element ),
                parent = element.parent();

            var parentWidth = parent.width(); 
            var parentHeight = parent.height();

            var elementWidth = element.attr('width');
            var elementHeight = element.attr('height');

            if ( ! elementWidth ) {
                element.css({ width: '' });
                elementWidth = element.width();
            }

            if ( ! elementHeight ) {
                element.css({ height: '' });
                elementHeight = element.height();
            }

            var newsizes = this.fill( parentWidth, parentHeight, elementWidth, elementHeight ); 

            element.css( newsizes );

            /*console.log( 'parentWidth: ' + parentWidth );
            console.log( 'parentHeight: ' + parentHeight );
            console.log( 'elementWidth: ' + elementWidth );
            console.log( 'elementHeight: ' + elementHeight );
            console.log( newsizes );*/
        }, 

        fill: function( parentWidth, boxHeight, elementWidth, elementHeight ) {
            var out = {};
            var initW = elementWidth;
            var initH = elementHeight;
            var ratio = initH / initW;

            elementWidth = parentWidth;
            elementHeight = parentWidth * ratio;

            if(elementHeight < boxHeight){
                elementHeight = boxHeight;
                elementWidth = elementHeight / ratio;
            }

            elementWidth = Math.round(elementWidth);
            elementHeight = Math.round(elementHeight);

            out.width = elementWidth;
            out.height = elementHeight;

            if( elementWidth > parentWidth ) {
                out.marginLeft = Math.round( (parentWidth - elementWidth) / 2 );
                out.marginTop = ''; 
            } else {    
                out.marginLeft = ''; 
                out.marginTop = Math.round( (boxHeight - elementHeight) / 2 );
            }

            return out;
        }

    };
 
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                new Plugin( this, options ));
            }
        });
    }
 
})( jQuery, window, document );