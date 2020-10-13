/**
SMK SKINR
*/

$('.go_to_bottom').click(function(){
	$.scrollTo('#GenFormEnd', {duration: 1000});
});
$('.tb_head_spr').append('<a class="go_to_top tbgototop" href="#" onClick="return false;">top &and;</a>');
/* 
$('#tb_next_content').hide();
$('#tb_load_next').click(function(){
	$('#tb_next_content').slideDown();
	$('#tb_loadnext_block').slideUp();
	return false;
});
 */
$('#tb_loadnext_block').hide();
 
$('#tb_close_codeblock').live("click", function () { 
	$('#tb_generated_code_block').slideUp('slow');
	$(this).remove();
	return false;
});
 
/*!
 * Color Scheme
 * 1. Main color
 * 2. Secondary color
 * 3. Third Color
 * 4. Fourth Color
*/
/* Color Scheme 1 [Main color] */
jQuery('#cp_FirstColor, .csh_color1').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			var bgcolor_rgb = rgb;
			jQuery('#cp_FirstColorBG_square, .csh_color1').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FirstColor").val('#'+bgcolor);
			
			jQuery('#cp_ALinkColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_ALinkColor").val('#'+bgcolor);
			
			jQuery('.default_button_hover_demo').css({ "border-color": '#' + bgcolor });
			jQuery('#cp_ButtonHoverBordercolor_square').css({ "background-color": '#' + bgcolor });
			$("#cp_ButtonHoverBordercolor").val('#'+bgcolor);
		},
  color: '#4a7dff'
});

/* Color Scheme 2 [Seconda color] */
jQuery('#cp_SecondColor, .csh_color2').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			jQuery('#cp_SecondColorBG_square, .csh_color2').css({ "background-color": '#' + bgcolor }); 
			$("#cp_SecondColor").val('#'+bgcolor);			
			jQuery('#cp_AHoverColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_AHoverColor").val('#'+bgcolor);
			jQuery('#cp_TopBarMenuBorder_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_TopBarMenuBorder").val('#'+bgcolor);
			$("#tb_demo_FormInputFocus_default").css({"border-color": '#' + bgcolor});
			jQuery('#cp_FormsBorderFocuscolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsBorderFocuscolor").val('#'+bgcolor);
			$(".nav_simple li a").hover(
			  function () {
				$(this).css({"border-bottom-color": '#' + bgcolor});
			  }, 
			  function () {
				$(this).css({"border-bottom-color": "transparent"});
			  }
			);

		},
  color: '#00a5eb'
});

/* Color Scheme 3 [Third Color] */
jQuery('#cp_ThirdColor, .csh_color3').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			jQuery('#cp_ThirdColorBG_square, .csh_color3').css({ "background-color": '#' + bgcolor }); 
			$("#cp_ThirdColor").val('#'+bgcolor);
			
			jQuery('.default_button_hover_demo').css({ "background-color": '#' + bgcolor });
			jQuery('#cp_ButtonHoverBGcolor_square').css({ "background-color": '#' + bgcolor });
			$("#cp_ButtonHoverBGcolor").val('#'+bgcolor);
		},
  color: '#45abff'
});

/* Color Scheme 4 [Fourth Color] */
jQuery('#cp_FourthColor, .csh_color4').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			jQuery('.footer_demo_styles_show .fdft_hover').css({ "color": '#' + bgcolor });
			jQuery('#cp_FourthColorBG_square, .csh_color4').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FourthColor").val('#'+bgcolor);
			jQuery('.footer_demo_styles_show .fdft_hover').css({ "color": '#' + bgcolor }); 
			jQuery('#cp_FooterHoverColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FooterHoverColor").val('#'+bgcolor);
			jQuery('.footer2_demo_styles_show .fdft2_hover').css({ "color": '#' + bgcolor }); 
			jQuery('#cp_Footer2HoverColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_Footer2HoverColor").val('#'+bgcolor);
		},
  color: '#7dbcff'
});


/*!
 * Links
 * 1. :link
 * 2. :hover
*/
/* Links 1 [:link] */
jQuery('#cp_ALinkColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			jQuery('#cp_ALinkColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_ALinkColor").val('#'+bgcolor);
		},
  color: '#4a7dff'
});

/* Links 2 [:hover] */
jQuery('#cp_AHoverColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			jQuery('#cp_AHoverColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_AHoverColor").val('#'+bgcolor);
		},
  color: '#00a5eb'
});


/*!
 * Top Bar
 * 1. Background
 * 2. Border-color
 * 3. Border-width
 * 4. Menu border color on hover
 * 5. Menu Border-width
*/
/* Top Bar 1 [Background] */
jQuery('#cp_TopBarBG').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			jQuery('.top_head_separator').css({	"background": '#' + bgcolor	}); 
			jQuery('#cp_TopBarBG_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_TopBarBG").val('#'+bgcolor);
		},
  color: '#ffffff'
});

/* Top Bar 2 [Border-color] */
jQuery('#cp_TopBarBorder').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			jQuery('.top_head_separator').css({	"border-color": '#' + bgcolor	}); 
			jQuery('#cp_TopBarBorder_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_TopBarBorder").val('#'+bgcolor);
		},
  color: '#eeeeee'
});

/* Top Bar 3 [Border-width] */
$( "#tb_TopBarBorderWidth" ).slider({
	range: "min",
	step: 1,
	value: 10,
	min: 0,
	max: 50,		
	slide: BorderWidthChange
});
function BorderWidthChange(event, slider){
    $('.top_head_separator').css('border-width', slider.value + 'px');
    $("#tb_TopBarBorderWidth_input").val(slider.value + 'px');   
}

/* Top Bar 4 [Menu border color on hover] */
jQuery('#cp_TopBarMenuBorder').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			$(".nav_simple li a").hover(
			  function () {
				$(this).css({"border-bottom-color": '#' + bgcolor});
			  }, 
			  function () {
				$(this).css({"border-bottom-color": "transparent"});
			  }
			);

			
			jQuery('#cp_TopBarMenuBorder_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_TopBarMenuBorder").val('#'+bgcolor);
		},
  color: '#00a5eb'
});



/* Top Bar 5 [Menu Border-width] */
$( "#tb_TopBarMenuBorderWidth" ).slider({
	range: "min",
	step: 1,
	value: 1,
	min: 0,
	max: 10,		
	slide: XMenuBorderWidthChange
});
function XMenuBorderWidthChange(event, slider){
	$('.nav_simple li a').css('border-bottom-width', slider.value + 'px');
    $("#tb_TopBarMenuBorderWidth_input").val(slider.value + 'px');
}

/* Top Bar 6 [Menu background color on hover] */
jQuery('#cp_TopBarMenuBG').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			$(".nav_simple ul li a").hover(
			  function () {
				$(this).css({"background-color": '#' + bgcolor});
			  }, 
			  function () {
				$(this).css({"background-color": "transparent"});
			  }
			);

			
			jQuery('#cp_TopBarMenuBG_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_TopBarMenuBG").val('#'+bgcolor);
		},
  color: '#222222'
});

/* Top Bar 7 [Menu text color on hover] */
jQuery('#cp_TopBarMenuText').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			$(".nav_simple ul li a").hover(
			  function () {
				$(this).css({"color": '#' + bgcolor});
			  }, 
			  function () {
				$(this).css({"color": "#ffffff"});
			  }
			);

			
			jQuery('#cp_TopBarMenuText_square').css({ "color": '#' + bgcolor }); 
			$("#cp_TopBarMenuText").val('#'+bgcolor);
		},
  color: '#ffffff'
});


/* Top Bar 8 [Menu Item Padding] */
$( "#tb_TopBarMenuPadding" ).slider({
	range: "min",
	step: 1,
	value: 7,
	min: 0,
	max: 25,		
	slide: MenuItemPaddingChange
});
function MenuItemPaddingChange(event, slider){
    $('.nav_simple ul li a').css('padding-top', slider.value + 'px');
    $('.nav_simple ul li a').css('padding-bottom', slider.value + 'px');
    $("#tb_TopBarMenuPadding_input").val(slider.value + 'px');   
}


/*!
 * Header
 * 1. Background-image
 * 2. Background-color
 * 3. Border-color
 * 4. Border-width
*/

/* Header 1 [Background-image] */
$('.tb_header_imgs img').click(function(){

	$(".tb_header_imgs img").removeClass("tbh_selected");
	$(this).addClass("tbh_selected");
	var tbh_attr = $(this).attr("alt");
	$("#tbh_header_input").val('../../'+tbh_attr);
	$(".header").css("background-image", "url("+tbh_attr+")" );
	$(".header_demo_styles_show").css("background-image", "url("+tbh_attr+")" );
	$(".header").css("background-position", " center top" );
	$(".header_demo_styles_show").css("background-position", " center -100px" );
	
});

/* Header 2 [Background-color] */
jQuery('#cp_HeaderBGcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			jQuery('.header').css({ "background-color": '#' + bgcolor });
			jQuery('.header_demo_styles_show').css({ "background-color": '#' + bgcolor });
			jQuery('#cp_HeaderBGcolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_HeaderBGcolor").val('#'+bgcolor);
		},
  color: '#333333'
});


/* Header 3 [Border-color] */
jQuery('#cp_HeaderBorder').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			jQuery('.header').css({	"border-color": '#' + bgcolor	}); 
			jQuery('.header_demo_styles_show').css({	"border-color": '#' + bgcolor	}); 
			jQuery('#cp_HeaderBorder_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_HeaderBorder").val('#'+bgcolor);
		},
  color: '#eeeeee'
});

/* Header 4 [Border-width] */
$( "#tb_HeaderBorderWidth" ).slider({
	range: "min",
	step: 1,
	value: 10,
	min: 0,
	max: 100,		
	slide: HeaderBorderWidthChange
});
function HeaderBorderWidthChange(event, slider){
    $('.header').css('border-bottom-width', slider.value + 'px');
    $('.header_demo_styles_show').css('border-bottom-width', slider.value + 'px');
    $("#tb_HeaderBorderWidth_input").val(slider.value + 'px');   
}



/*!
 * Wrap
 * 1. Background-color
 * 2. Background-image
*/

/* Wrap 1 [Background-color] */
jQuery('#cp_WrapBGcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			jQuery('.wrap').css({ "background-color": '#' + bgcolor });
			jQuery('#cp_WrapBGcolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_WrapBGcolor").val('#'+bgcolor);
		},
  color: '#ffffff'
});


/* Wrap 2 [Background-image] */
$('.tb_wrap_imgs img').click(function(){

	$(".tb_wrap_imgs img").removeClass("tbh_wrap_selected");
	$(this).addClass("tbh_wrap_selected");
	var tbh_attr = $(this).attr("alt");
	$("#tbh_wrap_input").val('../../'+tbh_attr);
	$(".wrap").css("background-image", "url("+tbh_attr+")" );
	
});
$('.tb_wrap_imgs img.tbh_none_wrapBG').click(function(){
	$("#tbh_wrap_input").val('');
});

/* Wrap 3 [Background-attachment] */
$('#tbh_wrap_BgAttach').click(function(){

	var selected_val = $(this).val();
	$(".wrap").css("background-attachment", selected_val );
	
});


/*!
 * Image Wrap
 * 1. Background-color
 * 2. Padding
 * 3. Radius
*/

/* Image Wrap 1 [Background-color] */
jQuery('#cp_ImageWrapBGcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$(".image_wrap,.image_wrap_simple,.blog_article .blog_slider.flexslider,.post_article_single .post_slider.flexslider,.blog_article .container_video, .post_article_single .container_video").hover(
			  function () {
				$(this).css({"background-color": '#' + bgcolor});
			  }, 
			  function () {
				$(this).css({"background-color": "#fafafa"});
			  }
			);
			jQuery('#cp_ImageWrapBGcolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_ImageWrapBGcolor").val('#'+bgcolor);
		},
  color: '#ffffff'
});

/* Image Wrap 2 [Padding] */
$( "#tb_ImageWrapPadding" ).slider({
	range: "min",
	step: 1,
	value: 5,
	min: 0,
	max: 20,		
	slide: ImageWrapPaddingChange
});
function ImageWrapPaddingChange(event, slider){
	$('.img_wrap_in').css('margin', slider.value + 'px');
    $("#tb_ImageWrapPadding_input").val(slider.value + 'px');   
}

/* Image Wrap 3 [Radius] */
$( "#tb_ImageWrapRadius" ).slider({
	range: "min",
	step: 1,
	value: 2,
	min: 0,
	max: 20,		
	slide: ImageWrapRadiusChange
});
function ImageWrapRadiusChange(event, slider){

	$('.image_wrap,.image_wrap_simple,.blog_article .blog_slider.flexslider,.post_article_single .post_slider.flexslider,.blog_article .container_video, .post_article_single .container_video').css('-webkit-border-radius', slider.value + 'px').css('-moz-border-radius', slider.value + 'px').css('border-radius', slider.value + 'px');
	
	$('.image_wrap img,.image_wrap_simple img,.blog_article .blog_slider.flexslider img,.post_article_single .post_slider.flexslider img,.blog_article .container_video iframe, .post_article_single .container_video iframe, .img_wrap_in').css('-webkit-border-radius', slider.value +'px').css('-moz-border-radius', slider.value + 'px').css('border-radius', slider.value + 'px');
	
    $("#tb_ImageWrapRadius_input").val(slider.value + 'px');  
	
}


/*!
 * Forms
 * - Default:
 * 1. Border-color
 * 2. Background-color
 * 3. Color
 * - Focus:
 * 4. Border-color
 * 5. Background-color
 * 6. Color
 * - Hover:
 * 7. Border-color
 * 8. Background-color
 * 9. Color
 * -
 * 10.Border Radius
*/

/* -------------- Default ------------ */
/* Forms 1 [Border-color] */
jQuery('#cp_FormsBordercolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$("#tb_demo_FormInput_default").css({"border-color": '#' + bgcolor});
			jQuery('#cp_FormsBordercolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsBordercolor").val('#'+bgcolor);
		},
  color: '#BBBBBB'
});

/* Forms 2 [Background-color] */
jQuery('#cp_FormsBackgroundcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$("#tb_demo_FormInput_default").css({"background-color": '#' + bgcolor});
			jQuery('#cp_FormsBackgroundcolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsBackgroundcolor").val('#'+bgcolor);
		},
  color: '#FFFFFF'
});

/* Forms 3 [Color] */
jQuery('#cp_FormsColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$("#tb_demo_FormInput_default").css({"color": '#' + bgcolor});
			jQuery('#cp_FormsColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsColor").val('#'+bgcolor);
		},
  color: '#000000'
});

/* -------------- Focus ------------ */
/* Forms 4 [Border Color] */
jQuery('#cp_FormsBorderFocuscolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$("#tb_demo_FormInputFocus_default").css({"border-color": '#' + bgcolor});
			jQuery('#cp_FormsBorderFocuscolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsBorderFocuscolor").val('#'+bgcolor);
		},
  color: '#00a5eb'
});

/* Forms 5 [Background color] */
jQuery('#cp_FormsBackgroundFocuscolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$("#tb_demo_FormInputFocus_default").css({"background-color": '#' + bgcolor});
			jQuery('#cp_FormsBackgroundFocuscolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsBackgroundFocuscolor").val('#'+bgcolor);
		},
  color: '#FFFFFF'
});


/* Forms 6 [Color] */
jQuery('#cp_FormsFocusColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$("#tb_demo_FormInputFocus_default").css({"color": '#' + bgcolor});
			jQuery('#cp_FormsFocusColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsFocusColor").val('#'+bgcolor);
		},
  color: '#000000'
});


/* -------------- Hover ------------ */
/* Forms 7 [Border Color] */
jQuery('#cp_FormsBorderHovercolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$("#tb_demo_FormInputHover_default").css({"border-color": '#' + bgcolor});
			jQuery('#cp_FormsBorderHovercolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsBorderHovercolor").val('#'+bgcolor);
		},
  color: '#bbbbbb'
});

/* Forms 8 [Background color] */
jQuery('#cp_FormsBackgroundHovercolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$("#tb_demo_FormInputHover_default").css({"background-color": '#' + bgcolor});
			jQuery('#cp_FormsBackgroundHovercolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsBackgroundHovercolor").val('#'+bgcolor);
		},
  color: '#FFFFFF'
});


/* Forms 9 [Color] */
jQuery('#cp_FormsHoverColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			$("#tb_demo_FormInputHover_default").css({"color": '#' + bgcolor});
			jQuery('#cp_FormsHoverColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FormsHoverColor").val('#'+bgcolor);
		},
  color: '#000000'
});



/* -------------- General border Radius ------------ */
/* Forms 10[Radius] */
$( "#tb_FormsBorderRadius" ).slider({
	range: "min",
	step: 1,
	value: 3,
	min: 0,
	max: 20,		
	slide: FormsBorderRadiusChange
});
function FormsBorderRadiusChange(event, slider){

	$('#tb_demo_FormInputFocus_default, #tb_demo_FormInputHover_default, #tb_demo_FormInput_default').css('-webkit-border-radius', slider.value + 'px').css('-moz-border-radius', slider.value + 'px').css('border-radius', slider.value + 'px');
	
    $("#tb_FormsBorderRadius_input").val(slider.value + 'px');  
	
}

/*!
 * Button
 * 1. Background color
 * 2. Border color
 * 3. Text color
 * 1. Background color(hover)
 * 2. Border color(hover)
 * 3. Text color(hover)
*/

/* Button 1 [Background color] */
jQuery('#cp_ButtonBGcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {			
			var bgcolor = hex;
			
			jQuery('.default_button_demo').css({ "background-color": '#' + bgcolor });
			jQuery('#cp_ButtonBGcolor_square').css({ "background-color": '#' + bgcolor });
			$("#cp_ButtonBGcolor").val('#'+bgcolor);
		},
  color: '#444444'
});
/* Button 2 [Border color] */
jQuery('#cp_ButtonBordercolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {			
			var bgcolor = hex;
			
			jQuery('.default_button_demo').css({ "border-color": '#' + bgcolor });
			jQuery('#cp_ButtonBordercolor_square').css({ "background-color": '#' + bgcolor });
			$("#cp_ButtonBordercolor").val('#'+bgcolor);
		},
  color: '#111111'
});
/* Button 3 [Text color] */
jQuery('#cp_ButtonTextcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {			
			var bgcolor = hex;
			
			jQuery('.default_button_demo').css({ "color": '#' + bgcolor });
			jQuery('#cp_ButtonTextcolor_square').css({ "background-color": '#' + bgcolor });
			$("#cp_ButtonTextcolor").val('#'+bgcolor);
		},
  color: '#ffffff'
});

/* Button 4 [Background color(hover)] */
jQuery('#cp_ButtonHoverBGcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {			
			var bgcolor = hex;
			
			jQuery('.default_button_hover_demo').css({ "background-color": '#' + bgcolor });
			jQuery('#cp_ButtonHoverBGcolor_square').css({ "background-color": '#' + bgcolor });
			$("#cp_ButtonHoverBGcolor").val('#'+bgcolor);
		},
  color: '#444444'
});
/* Button 5 [Border color(hover)] */
jQuery('#cp_ButtonHoverBordercolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {			
			var bgcolor = hex;
			
			jQuery('.default_button_hover_demo').css({ "border-color": '#' + bgcolor });
			jQuery('#cp_ButtonHoverBordercolor_square').css({ "background-color": '#' + bgcolor });
			$("#cp_ButtonHoverBordercolor").val('#'+bgcolor);
		},
  color: '#111111'
});
/* Button 6 [Text color(hover)] */
jQuery('#cp_ButtonHoverTextcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {			
			var bgcolor = hex;
			
			jQuery('.default_button_hover_demo').css({ "color": '#' + bgcolor });
			jQuery('#cp_ButtonHoverTextcolor_square').css({ "background-color": '#' + bgcolor });
			$("#cp_ButtonHoverTextcolor").val('#'+bgcolor);
		},
  color: '#ffffff'
});




/*!
 * Image loader
 * 1. Selector
*/

/* Image loader 1 [Selector] */
$('.tb_loader_imgs .tb_loader_block').click(function(){

	$(".tb_loader_imgs .tb_loader_block").removeClass("tbh_loader_selected");
	$(this).addClass("tbh_loader_selected");
	var tbh_attr = $(this).attr("title");
	$("#tbh_loader_input").val('../../'+tbh_attr);
	$("#tb_loader_active").css("background", "url("+tbh_attr+") no-repeat center center" );
	
});


/*!
 * Image hover icon
 * 1. Selector
 * 2. Animation
 * 3. Opacity
*/

/* Image hover icon 1 [Selector] */
$('.tb_imghover_imgs .tb_imghover_block').click(function(){

	$(".tb_imghover_imgs .tb_imghover_block").removeClass("tbh_imghover_selected");
	$(this).addClass("tbh_imghover_selected");
	var tbh_attr = $(this).attr("title");
	$("#tbh_imghover_input").val('../../'+tbh_attr);
	$(".image_wrap .img_caption_zoom,.image_wrap .img_caption_more,.image_wrap .img_caption_video,.image_wrap .img_caption_link").css("background-image", "url("+tbh_attr+")" );
	
});

/* Image hover icon 2 [Animation] */
$('#tb_imgHoverAnimation').click(function(){
	
	/* Reset */
	$('.image_wrap .img_caption_zoom')
		.removeClass('tbih_fade').removeClass('tbih_fade_hover')
		.removeClass('tbih_fromtop').removeClass('tbih_fromtop_hover')
		.removeClass('tbih_frombottom').removeClass('tbih_frombottom_hover')
		.removeClass('tbih_fromleft').removeClass('tbih_fromleft_hover')
		.removeClass('tbih_fromright').removeClass('tbih_fromright_hover')
		.removeClass('tbih_fadefromtop').removeClass('tbih_fadefromtop_hover')
		.removeClass('tbih_fadefrombottom').removeClass('tbih_fadefrombottom_hover')
		.removeClass('tbih_fadefromleft').removeClass('tbih_fadefromleft_hover')
		.removeClass('tbih_fadefromright').removeClass('tbih_fadefromright_hover')
		.removeClass('tbih_scalefromtop').removeClass('tbih_scalefromtop_hover')
		.removeClass('tbih_scalefrombottom').removeClass('tbih_scalefrombottom_hover')
		.removeClass('tbih_scalefromleft').removeClass('tbih_scalefromleft_hover')
		.removeClass('tbih_scalefromright').removeClass('tbih_scalefromright_hover')
		.removeClass('tbih_scale').removeClass('tbih_scale_hover')
		.removeClass('tbih_scalebig').removeClass('tbih_scalebig_hover')
		.removeClass('tbih_rotate').removeClass('tbih_rotate_hover')
		.removeClass('tbih_rotate2').removeClass('tbih_rotate2_hover')
		.removeClass('tbih_rotate3').removeClass('tbih_rotate3_hover');
	
	/* Current */
	var thisVal = $(this).val();
	
	$('.image_wrap .img_caption_zoom').addClass('tbih_'+thisVal);
	$(".image_wrap").hover(function(){
	
		$('.image_wrap .img_caption_zoom')
			.removeClass('tbih_fade').removeClass('tbih_fade_hover')
			.removeClass('tbih_fromtop').removeClass('tbih_fromtop_hover')
			.removeClass('tbih_frombottom').removeClass('tbih_frombottom_hover')
			.removeClass('tbih_fromleft').removeClass('tbih_fromleft_hover')
			.removeClass('tbih_fromright').removeClass('tbih_fromright_hover')
			.removeClass('tbih_fadefromtop').removeClass('tbih_fadefromtop_hover')
			.removeClass('tbih_fadefrombottom').removeClass('tbih_fadefrombottom_hover')
			.removeClass('tbih_fadefromleft').removeClass('tbih_fadefromleft_hover')
			.removeClass('tbih_fadefromright').removeClass('tbih_fadefromright_hover')
			.removeClass('tbih_scalefromtop').removeClass('tbih_scalefromtop_hover')
			.removeClass('tbih_scalefrombottom').removeClass('tbih_scalefrombottom_hover')
			.removeClass('tbih_scalefromleft').removeClass('tbih_scalefromleft_hover')
			.removeClass('tbih_scalefromright').removeClass('tbih_scalefromright_hover')
			.removeClass('tbih_scale').removeClass('tbih_scale_hover')
			.removeClass('tbih_scalebig').removeClass('tbih_scalebig_hover')
			.removeClass('tbih_rotate').removeClass('tbih_rotate_hover')
			.removeClass('tbih_rotate2').removeClass('tbih_rotate2_hover')
			.removeClass('tbih_rotate3').removeClass('tbih_rotate3_hover');
		
		$('.image_wrap .img_caption_zoom').removeClass('tbih_'+thisVal).addClass('tbih_'+thisVal+'_hover');
	}, function(){
		
		$('.image_wrap .img_caption_zoom')
			.removeClass('tbih_fade').removeClass('tbih_fade_hover')
			.removeClass('tbih_fromtop').removeClass('tbih_fromtop_hover')
			.removeClass('tbih_frombottom').removeClass('tbih_frombottom_hover')
			.removeClass('tbih_fromleft').removeClass('tbih_fromleft_hover')
			.removeClass('tbih_fromright').removeClass('tbih_fromright_hover')
			.removeClass('tbih_fadefromtop').removeClass('tbih_fadefromtop_hover')
			.removeClass('tbih_fadefrombottom').removeClass('tbih_fadefrombottom_hover')
			.removeClass('tbih_fadefromleft').removeClass('tbih_fadefromleft_hover')
			.removeClass('tbih_fadefromright').removeClass('tbih_fadefromright_hover')
			.removeClass('tbih_scalefromtop').removeClass('tbih_scalefromtop_hover')
			.removeClass('tbih_scalefrombottom').removeClass('tbih_scalefrombottom_hover')
			.removeClass('tbih_scalefromleft').removeClass('tbih_scalefromleft_hover')
			.removeClass('tbih_scalefromright').removeClass('tbih_scalefromright_hover')
			.removeClass('tbih_scale').removeClass('tbih_scale_hover')
			.removeClass('tbih_scalebig').removeClass('tbih_scalebig_hover')
			.removeClass('tbih_rotate').removeClass('tbih_rotate_hover')
			.removeClass('tbih_rotate2').removeClass('tbih_rotate2_hover')
			.removeClass('tbih_rotate3').removeClass('tbih_rotate3_hover');
		
		$('.image_wrap .img_caption_zoom').addClass('tbih_'+thisVal).removeClass('tbih_'+thisVal+'_hover');
	});
	
});// End Image hover icon 2 [Animation]

/* Image hover icon 3 [Opacity] */
$( "#tb_imgHoverOpacity" ).slider({
	range: "min",
	step: 1,
	value: 100,
	min: 10,
	max: 100,		
	slide: imgHoverOpacityChange
});
function imgHoverOpacityChange(event, slider){

	$('.image_wrap').hover(function(){
		var SliderValue = slider.value;
		if(SliderValue == '100'){
			$('.img_caption_zoom').css('opacity', '1').css('filter',  'alpha(opacity=' + slider.value + ')');
		} else {
			$('.img_caption_zoom').css('opacity', '0.' + slider.value).css('filter',  'alpha(opacity=' + slider.value + ')');
		}
	}, function(){
		$('.img_caption_zoom').css('opacity', '0').css('filter',  'alpha(opacity=0)');
	});

	$("#tb_imgHoverOpacity_input").val(slider.value);  
	
}
/* Image hover icon 4 [Transition] */
$( "#tb_imgHoverTransition" ).slider({
	range: "min",
	step: 1,
	value: 30,
	min: 10,
	max: 100,		
	slide: imgHoverTransitionChange
});
function imgHoverTransitionChange(event, slider){

	var SliderValue = slider.value;
		if(SliderValue == '100'){
			$('.img_caption_zoom')
				.css('transition', 'all 1s ease-in-out')
				.css('-webkit-transition', 'all 1s ease-in-out')
				.css('-moz-transition', 'all 1s ease-in-out')
				.css('-o-transition', 'all 1s ease-in-out')
				.css('-ms-transition', 'all 1s ease-in-out');
		} else {
			$('.img_caption_zoom')
				.css('transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-webkit-transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-moz-transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-o-transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-ms-transition', 'all 0.' + slider.value + 's ease-in-out');
		}
	$('.image_wrap').hover(function(){
		if(SliderValue == '100'){
			$('.img_caption_zoom')
				.css('transition', 'all 1s ease-in-out')
				.css('-webkit-transition', 'all 1s ease-in-out')
				.css('-moz-transition', 'all 1s ease-in-out')
				.css('-o-transition', 'all 1s ease-in-out')
				.css('-ms-transition', 'all 1s ease-in-out');
		} else {
			$('.img_caption_zoom')
				.css('transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-webkit-transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-moz-transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-o-transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-ms-transition', 'all 0.' + slider.value + 's ease-in-out');
		}
	}, function(){
		if(SliderValue == '100'){
			$('.img_caption_zoom')
				.css('transition', 'all 1s ease-in-out')
				.css('-webkit-transition', 'all 1s ease-in-out')
				.css('-moz-transition', 'all 1s ease-in-out')
				.css('-o-transition', 'all 1s ease-in-out')
				.css('-ms-transition', 'all 1s ease-in-out');
		} else {
			$('.img_caption_zoom')
				.css('transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-webkit-transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-moz-transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-o-transition', 'all 0.' + slider.value + 's ease-in-out')
				.css('-ms-transition', 'all 0.' + slider.value + 's ease-in-out');
		}
	});
	
	if(SliderValue == '100') {
		$("#tb_imgHoverTransition_input").val('1s');  
	} else if(SliderValue == '0') {
		$("#tb_imgHoverTransition_input").val('0');  
	} else {
		$("#tb_imgHoverTransition_input").val('0.' + slider.value + 's');  
	}
	
}

/*!
 * BLog icons
 * 1. Selector
*/

/* Blog icons 1 [Selector] */
$('.tb_blogicons_imgs .blogIcons_selectBlock').click(function(){

	$(".tb_blogicons_imgs .blogIcons_selectBlock").removeClass("tbh_blogicons_selected");
	$(this).addClass("tbh_blogicons_selected");
	var tbh_attr = $(this).data("blogicon");
	$("#tbh_blogicons_input").val(tbh_attr);
	
});


/*!
 * Footer
 * 1. Background-image
 * 2. Background-color
 * 3. Text color
 * 4. Link color
 * 5. Link hover color
*/

/* Footer 1 [Background-image] */
$('.tb_footer_imgs img').click(function(){

	$(".tb_footer_imgs img").removeClass("tbh_footer_selected");
	$(this).addClass("tbh_footer_selected");
	var tbh_attr = $(this).attr("alt");
	$("#tbh_footer_input").val('../../'+tbh_attr);
	$("#site_footer,.footer_demo_styles_show").css("background-image", "url("+tbh_attr+")" );
	$("#site_footer,.footer_demo_styles_show").css("background-position", "center top" );
	$("#site_footer,.footer_demo_styles_show").css("background-repeat", "repeat" );
	
});

/* Footer 2 [Background-color] */
jQuery('#cp_FooterBGcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			jQuery('.footer_demo_styles_show').css({ "background-color": '#' + bgcolor }); 
			jQuery('#site_footer').css({ "background-color": '#' + bgcolor });
			jQuery('#cp_FooterBGcolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FooterBGcolor").val('#'+bgcolor);
		},
  color: '#32303D'
});

/* Footer 3 [Text color] */
jQuery('#cp_FooterColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			jQuery('.footer_demo_styles_show .fdft_text').css({ "color": '#' + bgcolor }); 
			jQuery('#site_footer,#site_footer .widgetized_footer,#site_footer .widgetized_footer .widget-title,#site_footer .widgetized_footer .widget ul li').css({ "color": '#' + bgcolor });
			jQuery('#cp_FooterColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FooterColor").val('#'+bgcolor);
			
		},
  color: '#FFFFFF'
});

/* Footer 4 [Link color] */
jQuery('#cp_FooterLinkColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			jQuery('.footer_demo_styles_show .fdft_link').css({ "color": '#' + bgcolor }); 
			jQuery('#site_footer a,#site_footer .widgetized_footer a,#site_footer .widgetized_footer .widget ul li a,#site_footer_second a').css({ "color": '#' + bgcolor });
			jQuery('#cp_FooterLinkColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FooterLinkColor").val('#'+bgcolor);
			
		},
  color: '#FFFFFF'
});

/* Footer 5 [Link hover color] */
jQuery('#cp_FooterHoverColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			jQuery('.footer_demo_styles_show .fdft_hover').css({ "color": '#' + bgcolor }); 
			jQuery('#cp_FooterHoverColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_FooterHoverColor").val('#'+bgcolor);
		},
  color: '#7dbcff'
});

/**
 * Footer 2nd
 * 1. Background color
*/

/* Footer 2nd 1 [Background-color] */
jQuery('#cp_Footer2BGcolor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			jQuery('.footer2_demo_styles_show').css({ "background-color": '#' + bgcolor }); 
			jQuery('#site_footer_second').css({ "background-color": '#' + bgcolor });
			jQuery('#cp_Footer2BGcolor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_Footer2BGcolor").val('#'+bgcolor);
		},
  color: '#32303D'
});

/* Footer 2nd 2 [Text color] */
jQuery('#cp_Footer2Color').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			jQuery('.footer2_demo_styles_show .fdft2_text').css({ "color": '#' + bgcolor }); 
			jQuery('#site_footer_second,#site_footer_second .site_footer_inner,.site_copyright,#site_footer_second').css({ "color": '#' + bgcolor });
			jQuery('#cp_Footer2Color_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_Footer2Color").val('#'+bgcolor);
			
		},
  color: '#FFFFFF'
});

/* Footer 2nd 3 [Link color] */
jQuery('#cp_Footer2LinkColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
			
			jQuery('.footer2_demo_styles_show .fdft2_link').css({ "color": '#' + bgcolor }); 
			jQuery('#site_footer_second a,#site_footer_second .site_footer_inner a').css({ "color": '#' + bgcolor });
			jQuery('#cp_Footer2LinkColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_Footer2LinkColor").val('#'+bgcolor);
			
		},
  color: '#FFFFFF'
});

/* Footer 2nd 4 [Link hover color] */
jQuery('#cp_Footer2HoverColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			jQuery('.footer2_demo_styles_show .fdft2_hover').css({ "color": '#' + bgcolor }); 
			jQuery('#cp_Footer2HoverColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_Footer2HoverColor").val('#'+bgcolor);
		},
  color: '#7dbcff'
});

/* Footer 2nd 5 [Border-top color] */
jQuery('#cp_Footer2BorderColor').ColorPicker({
		onChange: function (hsb, hex, rgb) {
			
			var bgcolor = hex;
						
			jQuery('.footer2_demo_styles_show, #site_footer_second').css({ "border-top-color": '#' + bgcolor }); 
			jQuery('#cp_Footer2BorderColor_square').css({ "background-color": '#' + bgcolor }); 
			$("#cp_Footer2BorderColor").val('#'+bgcolor);
		},
  color: '#49475C'
});

$( "#tb_FooterBorderWidth" ).slider({
	range: "min",
	step: 1,
	value: 1,
	min: 0,
	max: 10,		
	slide: MenuBorderWidthChange
});
function MenuBorderWidthChange(event, slider){
    $('.footer2_demo_styles_show').css('border-top-width', slider.value + 'px');
    $('#site_footer_second').css('border-top-width', slider.value + 'px');
    $("#tb_FooterBorderWidth_input").val(slider.value + 'px');   
}






