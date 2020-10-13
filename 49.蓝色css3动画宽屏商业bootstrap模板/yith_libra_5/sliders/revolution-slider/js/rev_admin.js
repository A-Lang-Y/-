var RevSliderAdmin = new function(){
	
		var t = this;
	
		/**
		 * init "slider" view functionality
		 */
		var initSaveSliderButton = function(ajaxAction){
			
			jQuery("#button_save_slider").click(function(){
					
					//collect data
					var data = {
							params: UniteSettingsRev.getSettingsObject("form_slider_params"),
							main: UniteSettingsRev.getSettingsObject("form_slider_main")
						};
					
					//add slider id to the data
					if(ajaxAction == "update_slider"){
						data.sliderid = jQuery("#sliderid").val();
						
						//some ajax beautifyer
						UniteAdminRev.setAjaxLoaderID("loader_update");
						UniteAdminRev.setAjaxHideButtonID("button_save_slider");
						UniteAdminRev.setSuccessMessageID("update_slider_success");
					}
					
					UniteAdminRev.ajaxRequest(ajaxAction ,data);
			});		
		}

		
		/**
		 * update shortcode from alias value.
		 */
		var updateShortcode = function(){
			var alias = jQuery("#alias").val();			
			var shortcode = "[rev_slider "+alias+"]";
			if(alias == "")
				shortcode = "-- wrong alias -- ";
			jQuery("#shortcode").val(shortcode);
		}
		
		/**
		 * change fields of the slider view
		 */
		var enableSliderViewResponsitiveFields = function(enableRes,isMaxHeight){
			
			//enable / disable responsitive fields
			if(enableRes){	
				jQuery("#responsitive_row").removeClass("disabled");
				jQuery("#responsitive_row input").prop("disabled","");
			}else{
				jQuery("#responsitive_row").addClass("disabled");
				jQuery("#responsitive_row input").prop("disabled","disabled");
			}
						
			if(isMaxHeight){
				jQuery("#cellWidth").html("Grid Width");
				jQuery("#cellHeight").html("Slider Max Height");
			}
			else{
				jQuery("#cellWidth").html("Slider Width");
				jQuery("#cellHeight").html("Slider Height");
			}
			
		}
		
		
		/**
		 * init slider view custom controls fields.
		 */
		var initSliderViewCustomControls = function(){
			
			//fixed
			jQuery("#slider_type_1").click(function(){
				enableSliderViewResponsitiveFields(false,false);
			});
			
			//responsitive
			jQuery("#slider_type_2").click(function(){
				enableSliderViewResponsitiveFields(true,false);
			});
			
			//full width
			jQuery("#slider_type_3").click(function(){
				enableSliderViewResponsitiveFields(false,true);
			});
		}
		
		
		/**
		 * init "slider->add" view.
		 */
		this.initAddSliderView = function(){
			jQuery("#title").focus();
			initSaveSliderButton("create_slider");
			initShortcode();
			initSliderViewCustomControls();
		}
		
		
		/**
		 * init "slider->edit" view.
		 */		
		this.initEditSliderView = function(){
			
			initShortcode();
			initSliderViewCustomControls();
			
			initSaveSliderButton("update_slider");			
			
			//delete slider action
			jQuery("#button_delete_slider").click(function(){
				
				if(confirm("Do you really want to delete '"+jQuery("#title").val()+"' ?") == false)
					return(true);
				
				var data = {sliderid: jQuery("#sliderid").val()}
				
				UniteAdminRev.ajaxRequest("delete_slider" ,data);
			});
			

			//api inputs functionality:
			jQuery("#api_wrapper .api-input, #api_area").click(function(){
				jQuery(this).select().focus();
			});
			
			//api button functions:
			jQuery("#link_show_api").click(function(){
				jQuery("#api_wrapper").show();
				jQuery("#link_show_api").addClass("button-selected");
				
				jQuery("#toolbox_wrapper").hide();
				jQuery("#link_show_toolbox").removeClass("button-selected");
			});
			
			jQuery("#link_show_toolbox").click(function(){
				jQuery("#toolbox_wrapper").show();
				jQuery("#link_show_toolbox").addClass("button-selected");
				
				jQuery("#api_wrapper").hide();
				jQuery("#link_show_api").removeClass("button-selected");
			});

			
			//export slider action
			jQuery("#button_export_slider").click(function(){
				var sliderID = jQuery("#sliderid").val()
				var urlAjaxExport = ajaxurl+"?action="+g_uniteDirPlagin+"_ajax_action&client_action=export_slider";
				urlAjaxExport += "&sliderid=" + sliderID;
				location.href = urlAjaxExport;
			});
			
			//preview slider actions
			jQuery("#button_preview_slider").click(function(){
				var sliderID = jQuery("#sliderid").val()
				openPreviewSliderDialog(sliderID);
			});
		}
		
		
		/**
		 * init shortcode functionality in the slider new and slider edit views.
		 */
		var initShortcode = function(){
			
			//select shortcode text when click on it.
			jQuery("#shortcode").focus(function(){				
				this.select();
			});
			jQuery("#shortcode").click(function(){				
				this.select();
			});
			
			//update shortcode
			jQuery("#alias").change(function(){
				updateShortcode();
			});

			jQuery("#alias").keyup(function(){
				updateShortcode();
			});
		}
		
		
		/**
		 * update slides order
		 */
		var updateSlidesOrder = function(sliderID){
			var arrSlideHtmlIDs = jQuery( "#list_slides" ).sortable("toArray");
			
			//get slide id's from html (li) id's
			var arrIDs = [];
			jQuery(arrSlideHtmlIDs).each(function(index,value){
				var slideID = value.replace("slidelist_item_","");
				arrIDs.push(slideID);
			});
			
			//save order
			var data = {arrIDs:arrIDs,sliderID:sliderID};
			
			jQuery("#saving_indicator").show();
			UniteAdminRev.ajaxRequest("update_slides_order" ,data,function(){
				jQuery("#saving_indicator").hide();
			});
			
		}
		
		/**
		 * init "sliders list" view 
		 */
		this.initSlidersListView = function(){
			
			jQuery(".button_delete_slider").click(function(){
				
				var sliderID = this.id.replace("button_delete_","");
				var sliderTitle = jQuery("#slider_title_"+sliderID).text(); 
				if(confirm("Do you really want to delete '"+sliderTitle+"' ?") == false)
					return(false);
				
				UniteAdminRev.ajaxRequest("delete_slider" ,{sliderid:sliderID});
			});
			
			//duplicate slider action
			jQuery(".button_duplicate_slider").click(function(){
				var sliderID = this.id.replace("button_duplicate_","");
				UniteAdminRev.ajaxRequest("duplicate_slider" ,{sliderid:sliderID});
			});
			
				//preview slider action
				jQuery(".button_slider_preview").click(function(){
					
					var sliderID = this.id.replace("button_preview_","");
					openPreviewSliderDialog(sliderID);
			});
			
		}
		
		/**
		 * open preview slider dialog
		 */
		var openPreviewSliderDialog = function(sliderID){
			
			jQuery("#dialog_preview_sliders").dialog({
				modal:true,
				resizable:false,
				minWidth:1100,
				minHeight:500,
				closeOnEscape:true,
				buttons:{
					"Close":function(){
						jQuery(this).dialog("close");
					}
				},
				open:function(event,ui){
					var form1 = jQuery("#form_preview")[0];
					jQuery("#preview_sliderid").val(sliderID);
					form1.action = g_urlAjaxActions;
					form1.submit();
				},
				close:function(){
					var form1 = jQuery("#form_preview")[0];
					jQuery("#preview_sliderid").val("empty_output");
					form1.action = g_urlAjaxActions;
					form1.submit();
				}
				
			});
			
		}
		
		/**
		 * init "slides list" view 
		 */
		this.initSlidesListView = function(sliderID){
			
			//set the slides sortable, init save order
			jQuery("#list_slides").sortable({
					axis:"y",
					handle:'.col-handle',
					update:function(){updateSlidesOrder(sliderID)}
			});
			
			//new slide
			jQuery("#button_new_slide, #button_new_slide_top").click(function(){
				
				UniteAdminRev.openAddImageDialog("Select Slide Image",function(urlImage){
					var data = {sliderid:sliderID,url_image:urlImage};
					UniteAdminRev.ajaxRequest("add_slide" ,data);
				});	
			});
			
			//duplicate slide
			jQuery(".button_duplicate_slide").click(function(){
				var slideID = this.id.replace("button_duplicate_slide_","");
				var data = {slideID:slideID,sliderID:sliderID};
				UniteAdminRev.ajaxRequest("duplicate_slide" ,data);
			});
			
			// delete single slide
			jQuery(".button_delete_slide").click(function(){
				var slideID = this.id.replace("button_delete_slide_","");
				var data = {slideID:slideID,sliderID:sliderID};
				if(confirm("Delete this slide?") == false)
					return(false);
				UniteAdminRev.ajaxRequest("delete_slide" ,data);
			});
			
			//change image
			jQuery(".col-image .slide_image").click(function(){
				var slideID = this.id.replace("slide_image_","");
				UniteAdminRev.openAddImageDialog("Select Slide Image",function(urlImage){					
					var data = {slider_id:sliderID,slide_id:slideID,url_image:urlImage};
					UniteAdminRev.ajaxRequest("change_slide_image" ,data);
				});
			});	
			
			//publish / unpublish item
			jQuery("#list_slides .icon_state").click(function(){
				var objIcon = jQuery(this);
				var objLoader = objIcon.siblings(".state_loader");
				var slideID = objIcon.data("slideid");
				var data = {slider_id:sliderID,slide_id:slideID};
				
				objIcon.hide();
				objLoader.show();
				UniteAdminRev.ajaxRequest("toggle_slide_state" ,data,function(response){
					objIcon.show();
					objLoader.hide();
					var currentState = response.state;
					
					if(currentState == "published"){
						objIcon.removeClass("state_unpublished").addClass("state_published").prop("title","Unpublish Slide");
					}else{
						objIcon.removeClass("state_published").addClass("state_unpublished").prop("title","Publish Slide");
					}
							
				});
			});
			
			//preview slide from the slides list:
			jQuery("#list_slides .icon_slide_preview").click(function(){
				var slideID = jQuery(this).data("slideid");
				openPreviewSlideDialog(slideID,false);
			});
			
		}
		
		
		/**
		 * init "edit slide" view
		 */
		this.initEditSlideView = function(slideID){
			
			//save slide actions
			jQuery("#button_save_slide").click(function(){
				var layers = UniteLayersRev.getLayers();
				
				if(JSON && JSON.stringify)
					layers = JSON.stringify(layers);
				
				var data = {
						slideid:slideID,
						params:UniteSettingsRev.getSettingsObject("form_slide_params"),
						layers:layers
					};
				
				data.params.slide_bg_color = jQuery("#slide_bg_color").val();
				
				UniteAdminRev.setAjaxHideButtonID("button_save_slide");
				UniteAdminRev.setAjaxLoaderID("loader_update");
				UniteAdminRev.setSuccessMessageID("update_slide_success");
				UniteAdminRev.ajaxRequest("update_slide" ,data);
			});
			
			//change image actions
			jQuery("#button_change_image").click(function(){
				
				UniteAdminRev.openAddImageDialog("Select Slide Image",function(urlImage){
						//set visual image 
						jQuery("#divLayers").css("background-image","url("+urlImage+")");
						
						//update setting input
						jQuery("#image_url").val(urlImage);
					}); //dialog
			});	//change image click.
			
			
			// slide options hide / show			
			jQuery("#link_hide_options").click(function(){
				
				if(jQuery("#slide_params_holder").is(":visible") == true){
					jQuery("#slide_params_holder").hide("slow");
					jQuery(this).text("Show Slide Options").addClass("link-selected");
				}else{
					jQuery("#slide_params_holder").show("slow");
					jQuery(this).text("Hide Slide Options").removeClass("link-selected");
				}
				
			});
			
			
			//preview slide actions - open preveiw dialog			
			jQuery("#button_preview_slide").click(function(){				
				openPreviewSlideDialog(slideID,true);
			});
			
			//init background options
			jQuery("#radio_back_image, #radio_back_trans, #radio_back_solid").click(function(){
				var currentType = jQuery("#background_type").val();
				var bgType = jQuery(this).data("bgtype");
				
				if(currentType == bgType)
					return(true);
				
				//disable image button
				if(bgType != "image")
					jQuery("#button_change_image").addClass("button-disabled");
				else
					jQuery("#button_change_image").removeClass("button-disabled");
				
				if(bgType != "solid")
					jQuery("#slide_bg_color").addClass("disabled").prop("disabled","disabled");
				else
					jQuery("#slide_bg_color").removeClass("disabled").prop("disabled","");
				
				jQuery("#background_type").val(bgType);
				
				setSlideBGByType(bgType);
								
			});
			
			//on change bg color event 
			UniteAdminRev.setColorPickerCallback(function(){
				var bgType = jQuery("#background_type").val();
				if(bgType == "solid"){
					var bgColor = jQuery("#slide_bg_color").val();
					jQuery("#divLayers").css("background-color",bgColor);
				}
					
			});
			
			
		}//init slide view
		
		
		/**
		 * open preview slide dialog
		 */
		var openPreviewSlideDialog = function(slideID,useParams){

			if(useParams === undefined)
				useParams = true;
			
			var iframePreview = jQuery("#frame_preview");
			var previewWidth = iframePreview.width() + 10;
			var previewHeight = iframePreview.height() + 10;
			var iframe = jQuery("#frame_preview");
			
			jQuery("#dialog_preview").dialog({
					modal:true,
					resizable:false,
					minWidth:previewWidth,
					minHeight:previewHeight,
					closeOnEscape:true,
					buttons:{
						"Close":function(){
							jQuery(this).dialog("close");
						}
					},
					open:function(event,ui){
						var form1 = jQuery("#form_preview_slide")[0];
						
						var objData = {
								slideid:slideID,
							};
						
						if(useParams == true){
							objData.params = UniteSettingsRev.getSettingsObject("form_slide_params"),
							objData.params.slide_bg_color = jQuery("#slide_bg_color").val();							
							objData.layers = UniteLayersRev.getLayers()
						}
						
						var jsonData = JSON.stringify(objData);
						
						jQuery("#preview_slide_data").val(jsonData);
						form1.action = g_urlAjaxActions;
						form1.client_action = "preview_slide";
						form1.submit();
					},
					close:function(){	//distroy the loaded preview
						var form1 = jQuery("#form_preview_slide")[0];
						form1.action = g_urlAjaxActions;
						jQuery("#preview_slide_data").val("empty_output");
						form1.submit();
					}
			});
			
		}
		
		
		/**
		 * set slide background by type (image, solid, bg).
		 */
		var setSlideBGByType = function(bgType){
			switch(bgType){
				case "image":
					var urlImage = jQuery("#image_url").val();
					jQuery("#divLayers").css("background-image","url('"+urlImage+"')");
					jQuery("#divLayers").css("background-color","transparent");
					jQuery("#divLayers").removeClass("trans_bg");
					
				break;			
				case "trans":
					jQuery("#divLayers").css("background-image","none");
					jQuery("#divLayers").css("background-color","transparent");
					jQuery("#divLayers").addClass("trans_bg");
				break;
				case "solid":
					jQuery("#divLayers").css("background-image","none");
					jQuery("#divLayers").removeClass("trans_bg");
					var bgColor = jQuery("#slide_bg_color").val();
					jQuery("#divLayers").css("background-color",bgColor);
				break;
			}

		}

}
