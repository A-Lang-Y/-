<script type="text/javascript">
// <![CDATA[

	jQuery(window).ready(function(){
		"use strict";

		jQuery('.copyFontNameZclip').one('mouseenter', function(){

			jQuery(this).zclip({
				path: '<?php echo TMP_ADMIN . '/js/zclip/ZeroClipboard.swf'?>',
				copy: function(){
					return jQuery(this).attr('data-font-name');
				},
				afterCopy: function(){
					cloudfw_dialog('Font Name Copied', '"' + jQuery(this).attr('data-font-name') + '" copied', 'ok');				
				}
			});

		});

	});
 
// ]]>
</script>