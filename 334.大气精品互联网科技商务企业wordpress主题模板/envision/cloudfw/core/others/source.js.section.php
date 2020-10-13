<script type="text/javascript">
// <![CDATA[

jQuery(document).ready(function() {
	"use strict";

	function toggle_the_sectors($el, $force){
				 
		var $the_toggle = $el.parents('.section-toggle');
		var $the_content = $the_toggle.find('.section-content');
		var $wrapIconSection = $the_toggle.find('.wrapIconSection');
		var $operation = false; 
		
		if ($force == '') {

			if ( $the_content.is(':hidden') ) {
				$operation = true; 
			} else {
				$operation = false;  
			}

		} else {

		 	if($force == 'expand') {
		 		$operation = true; 
		 	} else {
		 		$operation = false; 
		 	}

		}
		
		if ( $operation ) {			
			$the_content.show(); $the_toggle.removeClass('hiddenSection').addClass('visibleSection');			
		} else {
			$the_content.hide(); $the_toggle.addClass('hiddenSection').removeClass('visibleSection');
		}
	
	}
	
	jQuery('.section-run').click(function(){
		cloudfw_destroy();
		toggle_the_sectors(jQuery(this), '');
		return false;
	});
	
	jQuery('#expand-all').click(function(){
		cloudfw_destroy();
		
		if (jQuery(this).hasClass("expanded")) {
			var $force = "collapse";
			jQuery(this).removeClass('expanded').html(jQuery(this).attr('data-expandtext'));
		} else {
			var $force = "expand";
			jQuery(this).addClass('expanded').html(jQuery(this).attr('data-collapsetext'));
		}
		
		jQuery(this).parents('.framework_container').find('.section-run').each(function(){
			toggle_the_sectors(jQuery(this),$force);
		});
		
		return false;
	});
	

});
 
// ]]>
</script>