function initGotoTop() {
    var change_speed = 800;
    jQuery('.go_to_top').click(function () {
        if (!jQuery.browser.opera) {
            jQuery('body').animate({
                scrollTop: 0
            }, {
                queue: false,
                duration: change_speed
            })
        }
        jQuery('html').animate({
            scrollTop: 0
        }, {
            queue: false,
            duration: change_speed
        });
        return false
    })
}

jQuery(document).ready(function() {
	
// Go to Top
initGotoTop();

// Question 1
jQuery('#question_1').click(function(){
jQuery.scrollTo('#answer_1', {duration: 800, onAfter:function(){
jQuery('#answer_1_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 2
jQuery('#question_2').click(function(){
jQuery.scrollTo('#answer_2', {duration: 800, onAfter:function(){
jQuery('#answer_2_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 3
jQuery('#question_3').click(function(){
jQuery.scrollTo('#answer_3', {duration: 800, onAfter:function(){
jQuery('#answer_3_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 4
jQuery('#question_4').click(function(){
jQuery.scrollTo('#answer_4', {duration: 800, onAfter:function(){
jQuery('#answer_4_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 5
jQuery('#question_5').click(function(){
jQuery.scrollTo('#answer_5', {duration: 800, onAfter:function(){
jQuery('#answer_5_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 6
jQuery('#question_6').click(function(){
jQuery.scrollTo('#answer_6', {duration: 800, onAfter:function(){
jQuery('#answer_6_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 7
jQuery('#question_7').click(function(){
jQuery.scrollTo('#answer_7', {duration: 800, onAfter:function(){
jQuery('#answer_7_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 8
jQuery('#question_8').click(function(){
jQuery.scrollTo('#answer_8', {duration: 800, onAfter:function(){
jQuery('#answer_8_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 9
jQuery('#question_9').click(function(){
jQuery.scrollTo('#answer_9', {duration: 800, onAfter:function(){
jQuery('#answer_9_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 10
jQuery('#question_10').click(function(){
jQuery.scrollTo('#answer_10', {duration: 800, onAfter:function(){
jQuery('#answer_10_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 11
jQuery('#question_11').click(function(){
jQuery.scrollTo('#answer_11', {duration: 800, onAfter:function(){
jQuery('#answer_11_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 12
jQuery('#question_12').click(function(){
jQuery.scrollTo('#answer_12', {duration: 800, onAfter:function(){
jQuery('#answer_12_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 13
jQuery('#question_13').click(function(){
jQuery.scrollTo('#answer_13', {duration: 800, onAfter:function(){
jQuery('#answer_13_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 14
jQuery('#question_14').click(function(){
jQuery.scrollTo('#answer_14', {duration: 800, onAfter:function(){
jQuery('#answer_14_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 15
jQuery('#question_15').click(function(){
jQuery.scrollTo('#answer_15', {duration: 800, onAfter:function(){
jQuery('#answer_15_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 16
jQuery('#question_16').click(function(){
jQuery.scrollTo('#answer_16', {duration: 800, onAfter:function(){
jQuery('#answer_16_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 17
jQuery('#question_17').click(function(){
jQuery.scrollTo('#answer_17', {duration: 800, onAfter:function(){
jQuery('#answer_17_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 18
jQuery('#question_18').click(function(){
jQuery.scrollTo('#answer_18', {duration: 800, onAfter:function(){
jQuery('#answer_18_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 19
jQuery('#question_19').click(function(){
jQuery.scrollTo('#answer_19', {duration: 800, onAfter:function(){
jQuery('#answer_19_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 20
jQuery('#question_20').click(function(){
jQuery.scrollTo('#answer_20', {duration: 800, onAfter:function(){
jQuery('#answer_20_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 21
jQuery('#question_21').click(function(){
jQuery.scrollTo('#answer_21', {duration: 800, onAfter:function(){
jQuery('#answer_21_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 22
jQuery('#question_22').click(function(){
jQuery.scrollTo('#answer_22', {duration: 800, onAfter:function(){
jQuery('#answer_22_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 23
jQuery('#question_23').click(function(){
jQuery.scrollTo('#answer_23', {duration: 800, onAfter:function(){
jQuery('#answer_23_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 24
jQuery('#question_24').click(function(){
jQuery.scrollTo('#answer_24', {duration: 800, onAfter:function(){
jQuery('#answer_24_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});

// Question 25
jQuery('#question_25').click(function(){
jQuery.scrollTo('#answer_25', {duration: 800, onAfter:function(){
jQuery('#answer_25_text').highlightFade({color:'rgb(255, 255, 209)', speed: 800});
} });
});










/** 
#  * Copyright (c) 2008 Pasyuk Sergey (www.codeasily.com) 
#  * Licensed under the MIT License: 
#  * http://www.opensource.org/licenses/mit-license.php 
#  *  
#  * Splits a <ul>/<ol>-list into equal-sized columns. 
#  *  
#  * Requirements:  
#  * <ul> 
#  * <li>"ul" or "ol" element must be styled with margin</li> 
#  * </ul> 
#  *  
#  * @see http://www.codeasily.com/jquery/multi-column-list-with-jquery 
#  */  
jQuery.fn.makeacolumnlists = function(settings){
	settings = jQuery.extend({
		cols: 3,		// set number of columns
		colWidth: 0,		// set width for each column or leave 0 for auto width
		equalHeight: false, 	// can be false, 'ul', 'ol', 'li'
		startN: 1		// first number on your ordered list
	}, settings);
 
	if(jQuery('> li', this)) {
		this.each(function(y) {
			var y=jQuery('.li_container').size(),
		    	height = 0, 
		        maxHeight = 0,
				t = jQuery(this),
				classN = t.attr('class'),
				listsize = jQuery('> li', this).size(),
				percol = Math.ceil(listsize/settings.cols),
				contW = t.width(),
				bl = ( isNaN(parseInt(t.css('borderLeftWidth'),10)) ? 0 : parseInt(t.css('borderLeftWidth'),10) ),
				br = ( isNaN(parseInt(t.css('borderRightWidth'),10)) ? 0 : parseInt(t.css('borderRightWidth'),10) ),
				pl = parseInt(t.css('paddingLeft'),10),
				pr = parseInt(t.css('paddingRight'),10),
				ml = parseInt(t.css('marginLeft'),10),
				mr = parseInt(t.css('marginRight'),10),
				col_Width = Math.floor((contW - (settings.cols-1)*(bl+br+pl+pr+ml+mr))/settings.cols);
			if (settings.colWidth) {
				col_Width = settings.colWidth; 
			}
			var colnum=1,
				percol2=percol;
			jQuery(this).addClass('li_cont1').wrap('<div id="li_container' + (++y) + '" class="li_container"></div>');
			if (settings.equalHeight=='li') {
			    jQuery('> li', this).each(function() {
			        var e = jQuery(this);
			        var border_top = ( isNaN(parseInt(e.css('borderTopWidth'),10)) ? 0 : parseInt(e.css('borderTopWidth'),10) );
			        var border_bottom = ( isNaN(parseInt(e.css('borderBottomWidth'),10)) ? 0 : parseInt(e.css('borderBottomWidth'),10) );
			        height = e.height() + parseInt(e.css('paddingTop'), 10) + parseInt(e.css('paddingBottom'), 10) + border_top + border_bottom;
			        maxHeight = (height > maxHeight) ? height : maxHeight;
			    });
			}
			for (var i=0; i<=listsize; i++) {
				if(i>=percol2) { percol2+=percol; colnum++; }
				var eh = jQuery('> li:eq('+i+')',this);
				eh.addClass('li_col'+ colnum);
				if(jQuery(this).is('ol')){eh.attr('value', ''+(i+settings.startN))+'';}
				if (settings.equalHeight=='li') {
			        var border_top = ( isNaN(parseInt(eh.css('borderTopWidth'),10)) ? 0 : parseInt(eh.css('borderTopWidth'),10) );
			        var border_bottom = ( isNaN(parseInt(eh.css('borderBottomWidth'),10)) ? 0 : parseInt(eh.css('borderBottomWidth'),10) );
					mh = maxHeight - (parseInt(eh.css('paddingTop'), 10) + parseInt(eh.css('paddingBottom'), 10) + border_top + border_bottom );
			        eh.height(mh);
				}
			}
			jQuery(this).css({cssFloat:'left', width:''+col_Width+'px'});
			for (colnum=2; colnum<=settings.cols; colnum++) {
				if(jQuery(this).is('ol')) {
					jQuery('li.li_col'+ colnum, this).appendTo('#li_container' + y).wrapAll('<ol class="li_cont'+colnum +' ' + classN + '" style="float:left; width: '+col_Width+'px;"></ol>');
				} else {
					jQuery('li.li_col'+ colnum, this).appendTo('#li_container' + y).wrapAll('<ul class="li_cont'+colnum +' ' + classN + '" style="float:left; width: '+col_Width+'px;"></ul>');
				}
			}
			if (settings.equalHeight=='ul' || settings.equalHeight=='ol') {
				for (colnum=1; colnum<=settings.cols; colnum++) {
				    jQuery('#li_container'+ y +' .li_cont'+colnum).each(function() {
				        var e = jQuery(this);
				        var border_top = ( isNaN(parseInt(e.css('borderTopWidth'),10)) ? 0 : parseInt(e.css('borderTopWidth'),10) );
				        var border_bottom = ( isNaN(parseInt(e.css('borderBottomWidth'),10)) ? 0 : parseInt(e.css('borderBottomWidth'),10) );
				        height = e.height() + parseInt(e.css('paddingTop'), 10) + parseInt(e.css('paddingBottom'), 10) + border_top + border_bottom;
				        maxHeight = (height > maxHeight) ? height : maxHeight;
				    });
				}
				for (colnum=1; colnum<=settings.cols; colnum++) {
					var eh = jQuery('#li_container'+ y +' .li_cont'+colnum);
			        var border_top = ( isNaN(parseInt(eh.css('borderTopWidth'),10)) ? 0 : parseInt(eh.css('borderTopWidth'),10) );
			        var border_bottom = ( isNaN(parseInt(eh.css('borderBottomWidth'),10)) ? 0 : parseInt(eh.css('borderBottomWidth'),10) );
					mh = maxHeight - (parseInt(eh.css('paddingTop'), 10) + parseInt(eh.css('paddingBottom'), 10) + border_top + border_bottom );
			        eh.height(mh);
				}
			}
		    jQuery('#li_container' + y).append('<div style="clear:both; overflow:hidden; height:0px;"></div>');
		});
	}
}
 
jQuery.fn.uncolumnlists = function(){
	jQuery('.li_cont1').each(function(i) {
		var onecolSize = jQuery('#li_container' + (++i) + ' .li_cont1 > li').size();
		if(jQuery('#li_container' + i + ' .li_cont1').is('ul')) {
			jQuery('#li_container' + i + ' > ul > li').appendTo('#li_container' + i + ' ul:first');
			for (var j=1; j<=onecolSize; j++) {
				jQuery('#li_container' + i + ' ul:first li').removeAttr('class').removeAttr('style');
			}
			jQuery('#li_container' + i + ' ul:first').removeAttr('style').removeClass('li_cont1').insertBefore('#li_container' + i);
		} else {
			jQuery('#li_container' + i + ' > ol > li').appendTo('#li_container' + i + ' ol:first');
			for (var j=1; j<=onecolSize; j++) {
				jQuery('#li_container' + i + ' ol:first li').removeAttr('class').removeAttr('style');
			}
			jQuery('#li_container' + i + ' ol:first').removeAttr('style').removeClass('li_cont1').insertBefore('#li_container' + i);
		}
		jQuery('#li_container' + i).remove();
	});
}


jQuery('.faq-questions ol').makeacolumnlists({cols:2,colWidth:0,equalHeight:false,startN:1});



});