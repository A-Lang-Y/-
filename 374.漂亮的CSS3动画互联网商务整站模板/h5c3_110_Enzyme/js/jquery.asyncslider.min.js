/**
 * AsyncSlider
 * JQuery plugin
 *
 * Created by: Arlind Nushi
 * Author email: arlindd@gmail.com
 *
 * Last Update: August 16, 2011
 */


(function($){var ct;var p=this;var rotations_count=0;var callback=function(){};var bg_mask;var bg_mask_2;var slides=[];var min_time=500;var max_time=1000;var direction='horizontal';var easing='easeInOutSine';var easing_in='';var easing_out='';var keyboard_navigate=false;var prev_next_nav=true;var center_prev_next_nav=true;var prev_next_nav_margin=5;var slides_nav=true;var random=true;var autoswitch=false;var autoswitch_interval=5000;var autoswitch_interval_func=null;var current_index=0;var total_slides=0;var timeout;var horizontal_direction='';var vertical_direction='';var base_zindex=1000;var busy=false;var _next_a,_prev_a;var slides_nav_el;function sliderPrepare(el,options)
{if(typeof ct=='undefined')
{ct=$(el);ct.css({position:'relative'});if(typeof options=='object')
{if(typeof options.direction=='string')
{if(options.direction.toLowerCase()=='vertical')
{direction='vertical';}
else
{direction='horizontal';}}
if(typeof options.random!='undefined')
{random=options.random;}
if(typeof options.minTime!='undefined')
{min_time=options.minTime;}
if(typeof options.maxTime!='undefined')
{max_time=options.maxTime;}
if(typeof options.easing=='string')
{easing=options.easing;}
if(typeof options.easingIn=='string')
{easing_in=options.easingIn;}
if(typeof options.easingOut=='string')
{easing_out=options.easingOut;}
if(typeof options.keyboardNavigate!='undefined')
{keyboard_navigate=options.keyboardNavigate?true:false;}
if(typeof options.prevNextNav!='undefined')
{prev_next_nav=options.prevNextNav;}
if(typeof options.centerPrevNextNav!='undefined')
{center_prev_next_nav=true;prev_next_nav_margin=parseInt(options.centerPrevNextNav,10);}
if(typeof options.slidesNav!='undefined')
{slides_nav=options.slidesNav;}
if(typeof options.autoswitch=='number'&&options.autoswitch>0)
{autoswitch=true;autoswitch_interval=options.autoswitch;_autoSwitch("on");}}
else
{options={};}
ct.children().each(function(i)
{var slide=$(this);var slide_elements=slide.find('*');slide.hide().css({zIndex:base_zindex+10,position:'relative'});slide.height=slide.outerHeight()>slide.height()?slide.outerHeight():slide.height();slide.width=slide.outerWidth();slide.background=false;var sbg="";var _bg_color=slide.css("background-color");var _bg_image=slide.css("background-image");var _bg_repeat=slide.css("background-repeat");var _bg_position=slide.css("background-position");var _bg_property=_bg_color+' '+(_bg_image=='none'?'':_bg_image)+' '+_bg_position+' '+_bg_repeat;if(_bg_image!='none'||_bg_color)
{sbg=_bg_property;slide.css("background","none");}
if(sbg||slide.attr("data-background"))
{slide.background=sbg;if(slide.attr("data-background"))
{slide.background=slide.attr("data-background");}
var img_url=[];img_url=slide.background.match(/url\((.*?)\)/);if(img_url&&img_url.length>0)
{var img=new Image();img.src=img_url[1];}}
slide.elements=[];slide_elements.each(function()
{var $this=$(this);var def_left=parseInt($this.css("left"),10);var def_top=parseInt($this.css("top"),10);$this.def_left=0;$this.def_top=0;if(def_left)
{$this.def_left=def_left;}
if(def_top)
{$this.def_top=def_top;}
if($this.css('position')!='absolute')
{$this.css({position:'relative'});}
$this.css({zIndex:base_zindex+10});if($this.get(0).tagName!="BR")
{slide.elements.push($this);}});slide.index=parseInt(i,10);slides.push(slide);if(i===0)
{slide.show();ct.height(slide.height).css({overflow:'hidden'});bg_mask=$('<div id="asyncslider_background_mask"></div>');bg_mask_2=$('<div id="asyncslider_background_mask_2"></div>');slide.before(bg_mask);slide.before(bg_mask_2);bg_mask.css({position:'absolute',top:0,left:0,zIndex:base_zindex+1,padding:0,margin:0,width:ct.outerWidth(),height:ct.outerHeight()});bg_mask_2.css({position:'absolute',top:0,left:0,zIndex:base_zindex+2,padding:0,margin:0,width:ct.outerWidth(),height:ct.outerHeight()});$(window).resize(function()
{bg_mask.width(ct.outerWidth());bg_mask_2.width(ct.outerWidth());});if(slide.background)
{bg_mask.css("background",slide.background);}}});total_slides=slides.length;if(typeof options!='undefined'&&typeof options.firstSlide!='undefined')
{var fs_index=options.firstSlide-1;if(fs_index>=0&&fs_index<total_slides)
{var tmp_min_time=min_time,tmp_max_time=max_time,tmp_callback=callback;min_time=max_time=0;callback=function(){};current_index=fs_index;switchSlide(current_index,0);min_time=tmp_min_time;max_time=tmp_max_time;callback=tmp_callback;}}
if(ct.children().length<2)
{return;}
$(window).keydown(function(e){if(keyboard_navigate)
{switch(e.keyCode)
{case 37:prevSlide();break;case 39:nextSlide();break;}}});if(prev_next_nav&&total_slides>1)
{var next_prev_nav_el=$('<ul id="asyncslider_next_prev_nav" />');next_prev_nav_el.css({zIndex:base_zindex+100});var prev_li=$('<li class="prev" />');var next_li=$('<li class="next" />');var prev_a=$('<a href="#">Previous</a>');var next_a=$('<a href="#">Next</a>');next_prev_nav_el.append(prev_li);next_prev_nav_el.append(next_li);prev_li.append(prev_a);next_li.append(next_a);prev_li.click(function(ev)
{ev.preventDefault();prevSlide();});next_li.click(function(ev)
{ev.preventDefault();nextSlide();});if(typeof prev_next_nav=='object')
{prev_next_nav.append(next_prev_nav_el);}
else
{ct.append(next_prev_nav_el);if(center_prev_next_nav)
{var margin_h=prev_next_nav_margin;var current_slide=getSlide(current_index);next_prev_nav_el.css({position:'absolute',left:"50%",margin:0,padding:0,listStyle:'none',marginLeft:-parseInt(current_slide.outerWidth()/2,10),top:0});next_prev_nav_el.find('*').css({margin:0,padding:0});var next=next_prev_nav_el.find('.next');var prev=next_prev_nav_el.find('.prev');_next_a=next.children();_prev_a=prev.children().css({left:-prev_a.width()-margin_h});prev.add(next).css({position:'relative'});prev.width(_prev_a.width());next.width(_next_a.width());_next_a.add(_prev_a).css({position:'absolute'});_next_a.css({left:current_slide.outerWidth()+margin_h,top:parseInt(current_slide.outerHeight()/2-_prev_a.outerHeight()/2,10)});_prev_a.css({top:parseInt(current_slide.outerHeight()/2-_prev_a.outerHeight()/2,10)});}}}
if(slides_nav)
{slides_nav_el=$('<ul id="asyncslider_slides_nav" />');slides_nav_el.css({zIndex:base_zindex+100});for(var i=0;i<slides.length;i++)
{var slide=slides[i];var slide_button_li=$('<li id="asyncslider_slide_'+(parseInt(i,10)+1)+'" />');var slide_button_a=$('<a href="#" rel="'+(i)+'">'+(parseInt(i,10)+1)+'</a>');if(i===0&&typeof options.firstSlide=='undefined')
{slide_button_li.addClass('active');}
else
if(typeof options.firstSlide!='undefined'&&i==parseInt(options.firstSlide,10)-1)
{slide_button_li.addClass('active');}
slides_nav_el.append(slide_button_li);slide_button_li.append(slide_button_a);index=parseInt(i,10);var btn_click_a=slide_button_a.click(function(ev)
{ev.preventDefault();if(busy)
{return false;}
slides_nav_el.find('li').removeClass('active');$(this).parent().addClass('active');var i=parseInt($(this).attr("rel"),10);var old_index=current_index;current_index=i;switchSlide(current_index,old_index);});}
if(typeof slides_nav=='object')
{slides_nav.append(slides_nav_el);}
else
{ct.append(slides_nav_el);}}}}
function setIndex(index)
{if(index>=0&&index<total_slides)
{current_index=index;}}
function getSlide(index)
{if(index>=0&&index<total_slides)
{return slides[index];}
return null;}
function nextSlide(_direction)
{if(busy)
{return false;}
var old_index=current_index;current_index++;current_index=current_index%total_slides;horizontal_direction='left';vertical_direction='bottom';if(_direction)
{horizontal_direction=_direction=='right'?'right':'left';}
if(_direction)
{vertical_direction=_direction=='bottom'?'top':'bottom';}
switchSlide(current_index,old_index);}
function prevSlide(_direction)
{if(busy)
{return false;}
var old_index=current_index;current_index--;current_index=current_index<0?(total_slides-1):current_index;horizontal_direction='right';vertical_direction='top';if(_direction)
{horizontal_direction=_direction=='left'?'left':'right';}
if(_direction)
{vertical_direction=_direction=='top'?'bottom':'top';}
switchSlide(current_index,old_index);}
function switchSlide(_in,_out)
{var current_slide=getSlide(_out);var next_slide=getSlide(_in);if((!current_slide||!next_slide)||_in==_out)
{return false;}
if(busy)
{return false;}
busy=true;var half_m=parseInt((max_time+min_time)/2,10);max_time=min_time>max_time?min_time:max_time;min_time=min_time>max_time?max_time:min_time;if(next_slide.background)
{if(!current_slide.background)
{bg_mask.css({background:next_slide.background}).hide().fadeTo(half_m,1);}
else
{if(rotations_count==0)
{bg_mask.css({background:current_slide.background});bg_mask_2.hide().css({background:next_slide.background}).stop().fadeTo(half_m,1);}
else
{bg_mask.css({background:next_slide.background}).show();bg_mask_2.stop().fadeTo(half_m,0,function(){bg_mask.hide();bg_mask_2.css({background:next_slide.background}).fadeTo(0,1);});}}}
else
{bg_mask_2.stop().fadeTo(half_m,0);bg_mask.stop().fadeTo(half_m,0);}
if(center_prev_next_nav&&_next_a&&_prev_a)
{_next_a.stop().animate({top:parseInt(next_slide.outerHeight()/2-_next_a.outerHeight()/2,10)},half_m);_prev_a.stop().animate({top:parseInt(next_slide.outerHeight()/2-_prev_a.outerHeight()/2,10)},half_m);}
bg_mask.stop().animate({height:next_slide.height},half_m);bg_mask_2.height(next_slide.height);if(slides_nav_el)
{slides_nav_el.find('li').removeClass('active').filter(':nth-child('+(next_slide.index+1)+')').addClass('active');}
var turn=1,i,el,time_seq,time_seq_step,def_left,def_top,animation_length,move_top,move_left;if(direction=='horizontal')
{var win=$(window);var win_ct_gap_size=win.width()-next_slide.width;ct.css({overflow:"hidden"}).stop().animate({height:next_slide.height},half_m);var move_left_1=parseInt(current_slide.width/2+win_ct_gap_size/2,10);if(_in>_out)
{move_top=current_slide.height;if(move_top<next_slide.height)
{move_top=next_slide.height-(next_slide.height-current_slide.height);}
current_slide.css({position:'relative',zIndex:base_zindex+3});next_slide.css({position:'relative',zIndex:base_zindex+4,top:-move_top}).show();turn=1;}
else
{move_top=current_slide.height;if(move_top<next_slide.height)
{move_top=next_slide.height;}
else
{move_top-=(current_slide.height-next_slide.height);}
current_slide.css({position:'relative',zIndex:base_zindex+3,top:-move_top});next_slide.css({position:'relative',zIndex:base_zindex+4}).show();turn=-1;}
if(horizontal_direction)
{if(horizontal_direction=='right')
{turn=-1;}
else
{turn=1;}}
if(!easing_in)
{easing_in=easing;}
if(!easing_out)
{easing_out=easing;}
time_seq=min_time;time_seq_step=parseInt((max_time-min_time)/current_slide.elements.length,10);move_left=current_slide.width+win_ct_gap_size;for(i=0;i<current_slide.elements.length;i++)
{el=current_slide.elements[i];def_left=el.def_left;def_top=el.def_top;animation_length=randomFromTo(min_time,max_time);move_left_1=move_left;if(!random)
{time_seq+=time_seq_step;animation_length=time_seq;}
el.stop().animate({left:-turn*move_left_1+def_left,top:def_top+0},animation_length,easing_in);}
time_seq=min_time;time_seq_step=parseInt((max_time-min_time)/next_slide.elements.length,10);move_left=next_slide.width+win_ct_gap_size;var next_slide_total_elements=next_slide.elements.length;for(i=0;i<next_slide.elements.length;i++)
{el=next_slide.elements[i];def_left=el.def_left;def_top=el.def_top;animation_length=randomFromTo(min_time,max_time);move_left_1=move_left+randomFromTo(0,el.outerWidth());if(!random)
{time_seq+=time_seq_step;animation_length=time_seq;}
var _index=parseInt(i,10);el.css({left:turn*move_left_1+def_left,top:def_top+0}).stop().animate({left:0+def_left},animation_length,easing_out);}}
else
{ct.css({overflow:"hidden"}).stop().animate({height:next_slide.height},half_m);var move_top_1=ct.height();if(_in>_out)
{current_slide.css({position:'relative',zIndex:base_zindex+3});next_slide.css({position:'relative',zIndex:base_zindex+4,top:-current_slide.height}).show();turn=1;}
else
{current_slide.css({position:'relative',zIndex:base_zindex+3,top:-current_slide.height});next_slide.css({position:'relative',zIndex:base_zindex+4}).show();turn=-1;}
if(vertical_direction)
{if(vertical_direction=='top')
{turn=-1;}
else
{turn=1;}}
if(!easing_in)
{easing_in=easing;}
if(!easing_out)
{easing_out=easing;}
current_slide.animate({top:-turn*move_top_1},half_m);time_seq=min_time;time_seq_step=parseInt((max_time-min_time)/current_slide.elements.length,10);for(i=0;i<current_slide.elements.length;i++)
{el=current_slide.elements[i];def_left=el.def_left;def_top=el.def_top;animation_length=randomFromTo(min_time,max_time);move_top=move_top_1;if(!random)
{time_seq+=time_seq_step;animation_length=time_seq;}
el.stop().animate({top:-turn*move_top+def_top},animation_length,easing_in);}
time_seq=min_time;time_seq_step=parseInt((max_time-min_time)/next_slide.elements.length,10);for(i=0;i<next_slide.elements.length;i++)
{el=next_slide.elements[i];def_left=el.def_left;def_top=el.def_top;animation_length=randomFromTo(min_time,max_time);move_top=move_top_1;if(!random)
{time_seq+=time_seq_step;animation_length=time_seq;}
el.css({top:turn*move_top,left:0+def_left}).stop().animate({top:0+def_top},animation_length,easing_out);}}
timeout=window.setTimeout(function(){current_slide.css({position:'relative',top:0,left:0}).hide();next_slide.css({position:'relative',top:0,left:0});for(i=0;i<current_slide.elements.length;i++)
{el=current_slide.elements[i];def_left=el.def_left;def_top=el.def_top;el.css({left:def_left});el.css({top:def_top});}
for(i=0;i<next_slide.elements.length;i++)
{el=next_slide.elements[i];def_left=el.def_left;def_top=el.def_top;el.css({left:def_left});el.css({top:def_top});}
horizontal_direction='';callback(next_slide.index+1);window.clearTimeout(timeout);timeout=null;busy=false;if(typeof autoswitch_interval_func!='undefined')
{if(autoswitch)
{window.clearTimeout(autoswitch_interval_func);autoswitch_interval_func=null;_autoSwitch("on");}}
rotations_count++;},max_time);return true;}
function randomFromTo(from,to)
{return Math.floor(Math.random()*(to-from+1)+from);}
function setOption(_var,_val)
{switch(_var.toLowerCase())
{case"direction":if(_val=="vertical")
{direction='vertical';}
else
{direction='horizontal';}
break;case"callback":if(typeof _val=='function')
{callback=_val;}
break;case"minTime":min_time=parseInt(_val,10);break;case"maxTime":max_time=parseInt(_val,10);break;case"easing":easing_in='';easing_out='';easing=_val;break;case"easingin":easing_in=_val;break;case"easingout":easing_out=_val;break;case"keyboardnavigate":keyboard_navigate=_val?true:false;break;case"random":random=_val?true:false;break;case"autoswitch":if(typeof _val=='number'&&_val>0)
{_autoSwitch("update_interval",_val);}
else
if(typeof _val=='string'&&(_val.toLowerCase()=='play'||_val.toLowerCase()=='on'||_val.toLowerCase()=='off'||_val.toLowerCase()=='pause'))
{_autoSwitch(_val.toLowerCase());}
else
if(typeof _val=='string'&&_val.toLowerCase()=='pause')
{_autoSwitch("pause");}
break;}}
function _autoSwitch(type,new_value)
{switch(type)
{case"off":autoswitch=false;if(typeof autoswitch_interval_func!='undefined')
{window.clearInterval(autoswitch_interval_func);autoswitch_interval_func=null;}
break;case"on":_autoSwitch("update_interval",autoswitch_interval);break;case"update_interval":autoswitch=true;autoswitch_interval=new_value;if(typeof autoswitch_interval_func!='undefined')
{window.clearInterval(autoswitch_interval_func);autoswitch_interval_func=null;}
autoswitch_interval_func=setInterval(function()
{if(autoswitch)
{nextSlide();}},autoswitch_interval);break;case"play":autoswitch=true;if(typeof autoswitch_interval_func=='undefined')
{_autoSwitch("on");}
break;case"pause":autoswitch=false;break;}}
$.fn.extend({asyncSlider:function(options,_var,_val)
{if(typeof options=='string')
{switch(options.toLowerCase())
{case"movetoslide":var move_to_slide=parseInt(_var,10);if(move_to_slide>0&&move_to_slide<=total_slides)
{var old_index=current_index;current_index=move_to_slide-1;if(_val)
{horizontal_direction=_val=='right'?'right':'left';}
if(_val)
{vertical_direction=_val=='bottom'?'top':'bottom';}
switchSlide(current_index,old_index);}
break;case"set":setOption(_var,_val);break;case"next":nextSlide(_var);break;case"prev":prevSlide(_var);break;}}
sliderPrepare(this,options);if(typeof _var=='function')
{callback=_var;}}});})
(jQuery);