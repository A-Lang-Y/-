/*

uSquare 1.0 - Universal Responsive Grid

Copyright (c) 2012 Br0 (shindiristudio.com)

Project site: http://codecanyon.net/
Project demo: http://shindiristudio.com/usquare/

*/

(function($) {

    function uSquareItem(element, options) {
        this.$item = $(element);
		this.$parent = options.$parent;
		this.options = options;
        this.$trigger = this.$(options.trigger);
        this.$close = this.$('.close');
        this.$info = this.$(options.moreInfo);
		this.$trigger_text = this.$trigger.find('.usquare_square_text_wrapper');
		this.$usquare_about = this.$info.find('.usquare_about');

		this.$trigger.on('click', $.proxy(this.show, this));
        this.$close.on('click', $.proxy(this.close, this));
        options.$overlay.on('click', $.proxy(this.close, this));
    };
    uSquareItem.prototype = {
        show: function(e) {
            e.preventDefault();

			if (!this.$parent.data('in_trans'))
			{
				if (!this.$item.data('showed'))
				{
					//background
					$square = this.$item.find('div.usquare_square');
					$square.data('background', $square.css('background-color'));
					if( $square.data('background') == 'transparent' || $square.data('background') == 'rgba(0, 0, 0, 0)' ) {
						$square.css('background-color', '#fff');
					}
					
					this.$parent.data('in_trans', 1);
					this.$item.data('showed', 1);
					if (this.options.before_item_opening_callback) this.options.before_item_opening_callback(this.$item);
					var item_position = this.$item.position();
					var trigger_text_position;
					var this_backup=this;
					var moving=0;
					if (item_position.top>0) // && this.$parent.width()>=640)
					{
						var parent_position=this.$parent.offset();
						var parent_top = parent_position.top;
						var non_visible_area=$(window).scrollTop()-parent_top;
						var going_to=item_position.top;
						if (non_visible_area>0)
						{
							var non_visible_row=Math.floor(non_visible_area/this.$item.height())+1;
							going_to=this.$item.height()*non_visible_row;
							going_to=item_position.top-going_to;
						}
						if (going_to>0) moving=1;						
						
						if (moving)
						{
							this.$item.data('moved', going_to);
							var top_string='-'+going_to+'px';
							var speed=this.options.opening_speed+(going_to/160)*100;
							this.$item.animate({top: top_string}, speed, this.options.easing, function(){
								trigger_text_position = this_backup.$item.height() - this_backup.$trigger_text.height();
								this_backup.$trigger_text.data('top', trigger_text_position);
								this_backup.$trigger_text.css('top', trigger_text_position);
								this_backup.$trigger_text.css('bottom', 'auto');
								this_backup.$trigger_text.animate({'top': 0}, 'slow');
							});
						}
					}
					if (!moving)
					{
						trigger_text_position = this_backup.$item.height() - this_backup.$trigger_text.height();
						this_backup.$trigger_text.data('top', trigger_text_position);
						this_backup.$trigger_text.css('top', trigger_text_position);
						this_backup.$trigger_text.css('bottom', 'auto');
						this_backup.$trigger_text.animate({'top': 0}, 'slow');
					}
		            this.$item.addClass('usquare_block_selected');
					var height_backup=this.$info.css('height');
					this.$info.css('height', 0);
					this.$info.show();
					this.$usquare_about.mCustomScrollbar("update");
					if (this.options.before_info_rolling_callback) this.options.before_info_rolling_callback(this.$item);
					this.$info.animate({height:height_backup}, 'slow', this.options.easing, function()
					{
						this_backup.$parent.data('in_trans', 0);
						if (this_backup.options.after_info_rolling_callback) this_backup.options.after_info_rolling_callback(this_backup.$item);
					});
				}
			}
        },
        close: function(e) {
            e.preventDefault();

			if (!this.$parent.data('in_trans'))
			{
				if (this.$item.data('showed'))
				{
					
					//background
					$square = this.$item.find('div.usquare_square');
					$square.css('background-color', $square.data('background'));
					
					var this_backup=this;
		            this.$info.hide();
					var trigger_text_position_top = this_backup.$item.height() - this_backup.$trigger_text.height();
					this_backup.$item.removeClass('usquare_block_selected');							
					if (this.$item.data('moved'))
					{
						var top_backup=this.$item.data('moved');
						var speed=this.options.closing_speed+(top_backup/160)*100;
						this.$item.data('moved', 0);
						this.$item.animate({'top': 0}, speed, this.options.easing, function()
						{
							this_backup.$trigger_text.animate({'top': trigger_text_position_top}, 'slow');
						});
					}
					else
					{
						this_backup.$trigger_text.animate({'top': trigger_text_position_top}, 'slow');
					}
					this.$item.data('showed', 0);
				}
			}
        },
        $: function (selector) {
            return this.$item.find(selector);
        }
    };

    function uSquare(element, options) {
        var self = this;
        this.options = $.extend({}, $.fn.uSquare.defaults, options);
        this.$element = $(element);
        this.$overlay = this.$('.usquare_module_shade');
        this.$items = this.$(this.options.block);
        this.$triggers = this.$(this.options.trigger);
        this.$closes = this.$('.close');
   
        this.$triggers.on('click', $.proxy(this.overlayShow, this));
        this.$closes.on('click', $.proxy(this.overlayHide, this));
        this.$overlay.on('click', $.proxy(this.overlayHide, this));

        $.each( this.$items, function(i, element) {
            new uSquareItem(element, $.extend(self.options, {$overlay: self.$overlay, $parent: self.$element }) );
        });
    };

    uSquare.prototype = {
        $: function (selector) {
            return this.$element.find(selector);
        },
        overlayShow: function() {
            this.$overlay.fadeIn('slow', function(){
				$(this).css({opacity : 0.25});
			})
        },
        overlayHide: function() {
			if (!this.$element.data('in_trans'))
			{
				this.$overlay.fadeOut('slow');
			}
        }
    };

    $.fn.uSquare = function ( option ) {
        return this.each(function () {
            var $this = $(this),
                data = $this.data('tooltip'),
                options = typeof option == 'object' && option;

            data || $this.data('tooltip', (data = new uSquare(this, options)));
            (typeof option == 'string') && data[option]();
        });
    };

    $.fn.uSquare.Constructor = uSquare;
    $.fn.uSquare.defaults = {
        block:     '.usquare_block',
        trigger:   '.usquare_square',
        moreInfo:  '.usquare_block_extended',
		opening_speed:				300,
		closing_speed:					500,
		easing:							'swing',
		before_item_opening_callback:	null,
		before_info_rolling_callback:	null,
		after_info_rolling_callback:	null
    };

	$(window).load(function() {
		$(".usquare_about").mCustomScrollbar();
	});

})(jQuery);