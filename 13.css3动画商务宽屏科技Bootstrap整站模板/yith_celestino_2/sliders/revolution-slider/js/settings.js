
var UniteSettingsRev = new function(){
	
	var arrControls = {};
	var colorPicker;
	
	var t=this;
	
	this.getSettingsObject = function(formID){		
		var obj = new Object();
		var form = document.getElementById(formID);
		var name,value,type,flagUpdate;
		
		//enabling all form items connected to mx
		for(var i=0; i<form.elements.length; i++){
			name = form.elements[i].name;		
			value = form.elements[i].value;
			type = form.elements[i].type;
			
			flagUpdate = true;
			switch(type){
				case "checkbox":
					value = form.elements[i].checked;
				break;
				case "radio":
					if(form.elements[i].checked == false) 
						flagUpdate = false;				
				break;
			}
			if(flagUpdate == true && name != undefined) obj[name] = value;
		}
		return(obj);
	}
	
	/**
	 * on selects change - impiment the hide/show, enabled/disables functionality
	 */
	var onSettingChange = function(){

		var controlValue = this.value.toLowerCase();
		var controlName = this.name;
		
		if(!arrControls[this.name]) return(false);
		
		jQuery(arrControls[this.name]).each(function(){
						
			var childInput = document.getElementById(this.name);
			var childRow = document.getElementById(this.name + "_row");
			var value = this.value.toLowerCase();
			var isChildRadio = (childInput && childInput.tagName == "SPAN" && jQuery(childInput).hasClass("radio_wrapper"));
			
			switch(this.type){
				case "enable":
				case "disable":
					
					if(childInput){		//disable
						if(this.type == "enable" && controlValue != this.value || this.type == "disable" && controlValue == this.value){
							childRow.className = "disabled";
							
							if(childInput){
								childInput.disabled = true;
								childInput.style.color = "";
							}
							
							if(isChildRadio)
								jQuery(childInput).children("input").prop("disabled","disabled").addClass("disabled");							
						}
						else{		//enable
							childRow.className = "";
							
							if(childInput)
								childInput.disabled = false;
							
							if(isChildRadio)
								jQuery(childInput).children("input").prop("disabled","").removeClass("disabled");
							
							//color the input again
							if(jQuery(childInput).hasClass("inputColorPicker")) g_picker.linkTo(childInput);							
		 				}
						
					}
				break;
				case "show":
					if(controlValue == this.value) jQuery(childRow).show();									
					else jQuery(childRow).hide();					
				break;
				case "hide":
					if(controlValue == this.value) jQuery(childRow).hide();									
					else jQuery(childRow).show();
				break;
			}
		});
	}
	
	
	/**
	 * combine controls to one object, and init control events.
	 */
	var initControls = function(){
				
		//combine controls
		for(key in g_settingsObj){
			var obj = g_settingsObj[key];
			
			for(controlKey in obj.controls){
				arrControls[controlKey] = obj.controls[controlKey];				
			}
		}
		
		//init events
		jQuery(".settings_wrapper select").change(onSettingChange);
		jQuery(".settings_wrapper input[type='radio']").change(onSettingChange);
		
	}
	
	
	//init color picker
	var initColorPicker = function(){
		var colorPickerWrapper = jQuery('#divColorPicker');
		
		colorPicker = jQuery.farbtastic('#divColorPicker');
		jQuery(".inputColorPicker").focus(function(){
			colorPicker.linkTo(this);
			colorPickerWrapper.show();
			var input = jQuery(this);
			var offset = input.offset();
			
			var offsetView = jQuery("#viewWrapper").offset();
			
			colorPickerWrapper.css({
				"left":offset.left + input.width()+20-offsetView.left,
				"top":offset.top - colorPickerWrapper.height() + 100-offsetView.top
			});

			
		}).click(function(){			
			return(false);	//prevent body click
		});
		
		colorPickerWrapper.click(function(){
			return(false);	//prevent body click
		});
		
		jQuery("body").click(function(){
			colorPickerWrapper.hide();
		});
	}
	
	/**
	 * close all accordion items
	 */
	var closeAllAccordionItems = function(formID){
		jQuery("#"+formID+" .unite-postbox .inside").slideUp("fast");
		jQuery("#"+formID+" .unite-postbox h3").addClass("box_closed");
	}
	
	/**
	 * init side settings accordion - started from php
	 */
	t.initAccordion = function(formID){
		var classClosed = "box_closed";
		jQuery("#"+formID+" .unite-postbox h3").click(function(){
			var handle = jQuery(this);
			
			//open
			if(handle.hasClass(classClosed)){
				closeAllAccordionItems(formID);
				handle.removeClass(classClosed).siblings(".inside").slideDown("fast");
			}else{	//close
				handle.addClass(classClosed).siblings(".inside").slideUp("fast");
			}
			
		});
	}
	
	/**
	 * image search
	 */
	var initImageSearch = function(){
		
		jQuery(".button-image-select").click(function(){
			var settingID = this.id.replace("_button","");
			UniteAdminRev.openAddImageDialog("Choose Image",function(urlImage){
				
				//update input:
				jQuery("#"+settingID).val(urlImage);
				
				//update preview image:
				var urlShowImage = UniteAdminRev.getUrlShowImage(urlImage,100,70,true);
				jQuery("#" + settingID + "_button_preview").html("<img width='100' height='70' src='"+urlShowImage+"'></img>");
				
			});
		})
		
	}
	
	
	
	/**
	 * init the settings function, set the tootips on sidebars.
	 */
	var init = function(){
		
		//init tipsy
		jQuery(".list_settings li .setting_text").tipsy({
			gravity:"e",
	        delayIn: 70
		});
		
		//init controls
		initControls();
		
		initColorPicker();
		
		initImageSearch();
	}
	
	
	
	//call "constructor"
	jQuery(document).ready(function(){
		init();
	});
	
} // UniteSettings class end


