<?php

global 	$skin_name, 
		$skin_datas,
		$array_patterns,
		$array_image_repeat,
		$array_image_attachment,
		$array_image_positions,
		$array_text_decorations,
		$array_bg_style;

$id = isset($_GET['id']) ? $_GET['id'] : NULL;

if (empty($id)) {

	$the_skin = cloudfw_get_current_skin();
	$mode = $the_skin["mode"];
	
	if ($mode == 'custom')
		$id = $the_skin["id"];	
	
	if (!empty($id))
		$skin_datas = cloudfw_get_a_skin($id);
	
} else {
	$skin_datas = cloudfw_get_a_skin($id);
	
}	

	if ($skin_datas):
	
	$skin_name = $skin_datas["name"];


	echo '<input type="hidden" id="skin_id" name="skin_id" value="'.$id.'" />
	<input type="hidden" id="skin_apply" name="skin_apply" value="0" />';

	$array_patterns = cloudfw_groupped_skin_styles();
	
	// Repeatings
	$array_image_repeat['NULL']             = __('Default','cloudfw');
	$array_image_repeat['repeat']           = __('Repeat X and Y axis','cloudfw');
	$array_image_repeat['repeat-x']         = __('Repeat only X axis','cloudfw');
	$array_image_repeat['repeat-y']         = __('Repeat only Y axis','cloudfw');
	$array_image_repeat['no-repeat']        = __('No repeat','cloudfw');

	// Background -Positions
	$array_image_positions['NULL']          = __('Default','cloudfw');
	$array_image_positions['50% 50%']       = __('Center, Center','cloudfw');
	$array_image_positions['0 50%']         = __('Center, Left','cloudfw');
	$array_image_positions['100% 50%']      = __('Center, Right','cloudfw');
	$array_image_positions['0 0']           = __('Top, Left','cloudfw');
	$array_image_positions['100% 0']        = __('Top, Right','cloudfw');
	$array_image_positions['50% 0']         = __('Top, Center','cloudfw');
	$array_image_positions['0 100%']        = __('Bottom, Left','cloudfw');
	$array_image_positions['100% 100%']     = __('Bottom, Right','cloudfw');
	$array_image_positions['50% 100%']      = __('Bottom, Center','cloudfw');
		
	// Text-Decorations
	$array_text_decorations					= cloudfw_admin_array_text_decorations();

	// Attachment
	$array_image_attachment['NULL']    		= __('Default','cloudfw');
	$array_image_attachment['fixed']  	 	= __('Fixed','cloudfw');
	$array_image_attachment['scroll']  		= __('Scroll','cloudfw');
	$array_image_attachment['inherit'] 		= __('Inherit','cloudfw');
			
	// Bg Style
	$array_bg_style['static']        		= __('Static - Default','cloudfw');
	$array_bg_style['fixed']         		= __('Fixed  - Fill the Page','cloudfw');

?>
<span style="display: none; height: auto;" id="mb_search_skin">
<div style="padding: 20px 20px 0;">
    
    <div class="grid oneof4" style="padding-top: 10px;"><span class="title"><?php _e('Search Key','cloudfw'); ?>:</span></div>
    <div class="grid threeof4 last">

    <?php

	   admin_create_input(
			array(
				'id'    =>	'search_skin_item',
				'value' =>	'',
				'case'  => 'input',
				'type'  => 'text',
				'class' => 'input input_200_bold',
			)
		);
       
    ?><div class="small-button small-sky button-float-none" style="margin-left: 10px !important;"><input id="search_skin_item_button" type="button" value="<?php _e('Search','cloudfw'); ?>"></div> <div class="clear"></div>
		<div style=" font-size: 12px; color: #b4b4b4; margin-top: 5px; "><?php _e('Please insert element code or element title, and press enter to search','cloudfw'); ?></div>

    </div>
    <div class="clear"></div>   
    
    
    </div>
</span>

<a href="javascript:void(0);" class="right-navigation help" id="skin-search" rel="mb_search_skin" width="m" title="<?php _e('Search Visual Element','cloudfw'); ?>"><span class="cloudfw-tooltip" title="<?php _e('Search Visual Elements (CTRL/CMD +F)','cloudfw'); ?>"><?php _e('Search Visual Element','cloudfw'); ?></span></a>

<!--SECTION-->
<div id="section-name" class="section-toggle hiddenSection">

<div class="section-container">
<div class="section-title colorTitle" id="the-skin-name">

<span id="skin-name"><?php echo $skin_name; ?></span><a id="skin-name-edit-text" href="javascript:void(0);"><?php _e('edit','cloudfw'); ?></a>

<div id="skin-name-input" class="hidden">
	<?php
		admin_create_input(
			array(
				'id'    =>	'skin_name',
				'value' =>	$skin_name,
				'case'  => 'input',
				'type'  => 'text',
				'class' => 'input input_400_bold',
			)
		);
    ?>
</div>

</div>



<span class="wrapExpandSection"><a href="#" id="expand-all" data-collapsetext="<?php _e('Collapse All','cloudfw'); ?>" data-expandtext="<?php _e('Expand All','cloudfw'); ?>"><?php _e('Expand All','cloudfw'); ?></a></span>
</div>

</div>
<!--/SECTION-->

	<?php 
		cloudfw_render_page( 
			cloudfw_get_schemes('skin_map', 
			true,
			cloudfw_array_merge(cloudfw_get_content_maps('skin_map'), isset($skin_datas["data"]) ? $skin_datas["data"] : NULL)
		) , isset($GLOBALS["args"]) ? $GLOBALS["args"] : NULL ); 
	?>

    <div class="module submit-helper" style="padding-top: 0; margin-top: -10px;">
        <div class="fixed-submit">

    <?php if (!empty($id)) echo '<div style="float:left; margin-left: 8px !important;"><a class="small-button small-red cloudfw-ui-confirm" href="'.CLOUDFW_PAGE.'&q=1&deleteSkin=true&id='.$id.'"><span>'.__('Delete','cloudfw').'</span></a>
	
	<a class="small-button small-green" href="'.admin_url('admin.php').'?do=CloudFw_Export&nonce='.wp_create_nonce('cloudfw').'&amp;case=export-skins&amp;zip=true&amp;ids='.$id.'"><span>'.__('Export','cloudfw').'</span></a>
	
	</div>'; ?>
    <div style="float:right;"> 
    
	<?php 	echo '
			<script type="text/javascript">
			// <![CDATA[
				jQuery(document).ready(function() {
					"use strict";

					jQuery("#skin_apply","#add_skin_form").val("0");
					
					jQuery("#save_apply").click(function(){
						
						jQuery("#skin_apply","#add_skin_form").val("1");
						jQuery("#add_skin_form").submit();
					
					});
				});
			// ]]>
			</script>
			<!-- /<div class="small-button small-sky"><input autocomplete="off" type="button" value="'.__('Save & Apply','cloudfw').'" id="save_apply" /></div> --> '; ?> 
			<div class="small-button small-sky"><input autocomplete="off" value="<?php _e('Save Changes','cloudfw'); ?>" type="submit" /></div>  
        
    </div>
    <div class="clear"></div>
        
	</div>
</div>

<script type="text/javascript">
// <![CDATA[

jQuery(document).ready(function() {
	"use strict";

	CloudFw_UI.track( jQuery('#add_skin_form') );	
	<?php echo "
		jQuery( '#skin-id-{$id}' ).parents('label').first().addClass('editing').append( jQuery('<div/>').addClass('editing-text').html('". __('editing','cloudfw') ."') );
	"; ?>


	/** Duplicate Dialogs */
	jQuery(".duplicateSkin").click(function(e){
		
		var the_el = jQuery( this );
		var element = 'mb_duplicate_skin'; 
		var the_dialog = jQuery('#' + element);
		var dialog_form = the_dialog.find('form').first();
		var href = the_el.attr('href'); 

		dialog_form.attr('action', href);
		dialog_form.unbind('submit');
		dialog_form.bind('submit', function(e){
			e.preventDefault();
			jQuery(this).find(':submit').val(CloudFwOp.textDuplicatingSkin);
			window.location.href = href + '&skin_duplicate_name=' + jQuery('#skin_duplicate_name').val();
		});

		var Mo = CloudFw_UI.modal({
			destroy		 : true,
			overlay		 : true,
			minimize	 : false,
			compact		 : true,
			width 		 : 600,
			title 		 : CloudFwOp.textDuplicateSkin,
			content		 : function( ui_modal ){
				jQuery( '#'+ element ).wrap( '<div id="'+ element +'-cloudfw-placeholder" />' );
				jQuery('.cloudfw-ui-modal-box-content', ui_modal).html('');
				jQuery( '#'+ element ).appendTo( jQuery('.cloudfw-ui-modal-box-content', ui_modal) ).show();
			},
			before_close : function(){
				jQuery( '#'+ element ).appendTo( jQuery( '#'+ element +'-cloudfw-placeholder' ) ).hide().unwrap();
			}
		});

		var timeout = setTimeout( function(){
			jQuery('#skin_duplicate_name').val( the_el.parent().prev('label').find('.skin-name > span').attr('title') ).select();
			clearTimeout( timeout );
		}, 100);


		e.preventDefault();

	});

	jQuery('.pattern-preview').on({
        mouseenter:
           function() {
			jQuery(this).stop(true).animate({width: 100, height: 50 },250);
           },
        mouseleave:
           function(){
			jQuery(this).stop(true).animate({width: 25, height: 25 },150);
           }
       }
    );
	
	jQuery('.microTabIcons').click(cloudfw_destroy);	

	
	function disable_edit_name() {
		jQuery('#skin-name, #skin-name-edit-text').show();
		jQuery('#skin-name-input').hide();
	}
	
	jQuery('#skin-name, #skin-name-edit-text').click(function(){
		jQuery('#skin-name, #skin-name-edit-text').hide();
		jQuery('#skin-name-input').show().find("input").focus();
	});

	jQuery('#skin-name-input').focusout(function(){ disable_edit_name(); });
	
	jQuery('#skin-name-input').bind('change keydown keyup',function(e){		
		var the_name_val = jQuery(this).find('input').val();
		jQuery('#skin-name').html(the_name_val);
		
		if(e.which == 13 || e.which == 27){
       		disable_edit_name();
			e.preventDefault();
		}

		
		
	});
	
	jQuery('#skin-search').click(function(){
		jQuery('#search_skin_item').val('').delay(200).show(function(){
			jQuery(this).focus();
		});
	});
	
	jQuery('#add_skin_form').bind('ajaxCallback', function(){
		jQuery("#skin_apply","#add_skin_form").val("0");
	})
	
	jQuery('#search_skin_item').off('keydown');
	jQuery('#search_skin_item').on('keydown',cloudfw_inline_search);
   	

	jQuery('#search_skin_item_button').on('click', cloudfw_inline_search_the_key);

	shortcut.remove("Ctrl+F");
	shortcut.add("Ctrl+F",function() {jQuery('#skin-search').click();},{'type':'keydown','propagate':false,'target':document});

	
	
	/*
	 *	Make jQuery Contains extension case insenstive
	 *
	 *	@since 1.0
	**/
	jQuery.expr[':'].Contains = function(a, i, m) { 
	  return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0; 
	};
	
	/*
	 *	When Starting Inline Search
	 *
	 *	@since 1.0
	**/	
	function cloudfw_inline_search(e){
		if(e.which == 13){
       		cloudfw_inline_search_the_key();
			e.preventDefault();
			return false;
		}		
	}
	
	/*
	 *	Seek & Find The Item
	 *
	 *	@since 1.0
	**/
	function cloudfw_inline_search_the_key(){
		
		var search_input = jQuery('#search_skin_item');
		var search_key = search_input.val();

		CloudFw_UI.modal('destroy');

		jQuery('.search-found').removeClass('search-found');
		jQuery('.section-clicked').removeClass('section-clicked');
		jQuery('#expand-all').addClass('expanded').click();
		jQuery('.delimiter, .delimiter-frame').remove();
		jQuery('.section-counted').removeClass('section-counted');

		if (search_key == '')
			return false;
		
		var the_form = jQuery('#add_skin_form');
		var to_search_elements = the_form.find('.section-content label.title');
		var found_elements = to_search_elements.filter(":Contains('"+search_key+"')");

		var to_search_elements_by_ucode = the_form.find('.section-content div.ucode');
		var found_elements_by_ucode = to_search_elements_by_ucode.filter(":Contains('"+search_key+"')");
		var found_elements = found_elements.add(found_elements_by_ucode);
		
		var i = 0;
		
		if (found_elements.length > 0) {

			found_elements.each(function(){
				
				jQuery(this).parents('.module').addClass('search-found').prepend('<span class="delimiter-frame"></span><span class="delimiter"></span>');
				
				var toClickElement = jQuery(this).parents('.section-toggle').first().find('.section-run');
				if( ! toClickElement.hasClass('section-clicked') ) {
					toClickElement.addClass('section-clicked').click();
				}

				var toClickElementSub = jQuery(this).parents('.module-set-closable').first();
				if( toClickElementSub.hasClass('module-set-state-closed') && !toClickElementSub.find('.module-set-header').find('h3').hasClass('section-clicked') ) {
					toClickElementSub.find('.module-set-header').find('h3').addClass('section-clicked').click();
				}
				
				if( ! jQuery(this).parents('.module').hasClass('section-counted') ) {
					jQuery(this).parents('.module').addClass('section-counted');
					i++;
				}				
					
			});

			jQuery.scrollTo( found_elements.first(), {duration: 500, offset:{top:-80 } } );
			cloudfw_dialog('Element(s) Found', i + ' element(s) found with <strong>'+search_key+'</strong> key','find');		
			
		} else 
			cloudfw_dialog('<?php echo esc_attr(__('Not Found','cloudfw')); ?>','<?php echo esc_attr(__('Unfortunately, we couldn\'t find anything. Please try another search key.','cloudfw')); ?>','cancel');
		
	} 
	

	
});
 
// ]]>
</script>



<?php	
	else:
	
	echo '<div class="module"><div class="thereisno">'.__('There is no any visual set to edit','cloudfw').'. <a class="help" rel="mb_create_skin" width="m" title="'.__('Create New One','cloudfw').'" href="javascript:;"><span>'.__('Create New One','cloudfw').'</span></a></div></div>';

	endif;
?>