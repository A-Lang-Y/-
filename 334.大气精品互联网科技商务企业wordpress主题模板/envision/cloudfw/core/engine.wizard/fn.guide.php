<?php
/**
 * CloudFw - Configuration Wizard
 *	
 * @package WordPress
 * @package CloudFw
**/

global $_opt, $cloudfw_slider_slug, $cloudfw_setting_slug, $guide;
	   $skin = cloudfw_get_current_skin();

require( TMP_LOADERS.'/theme.wizard.php' );

$total_score = $percent = 0;
$echo = ''; 

foreach ($guide as $gid => $guide_item){
	if (isset($guide_item["score"]) && is_numeric($guide_item["score"]))
		(int)$total_score += $guide_item["score"];
	}

	$ratio = 100 / $total_score;
	$guide_done = $_opt[PFIX.'_setup_status'];

foreach ($guide as $gid => $guide_item){
	if (in_array($gid, (array)$guide_done) || (isset($guide_item["done"]) && $guide_item["done"])) {
		
		if ( isset($guide_item["score"]) && $guide_item["score"] )
			(int)$percent += ($ratio*$guide_item["score"]);

		$done = true;
	} else {
		$done = false;
	}
		
	if (isset($guide_item["group"])):
	
		$echo .= '<li class="group">'.$guide_item["group"].'</li>';
	
	else:

		if ( isset($guide_item["custom_text"]) && is_array($guide_item["custom_text"])){
			$undone_text = $guide_item["custom_text"][1];
			$done_text = $guide_item["custom_text"][0];
		} else {
			$undone_text = __('mark as undone','cloudfw');
			$done_text = __('mark as done','cloudfw');
		}
		
		if (isset($guide_item['modal']) && $guide_item['modal']) {
			$modal = true;
			$modal_title = $guide_item['modal']['title'];
			$modal_id = $guide_item['modal']['id'];
			$modal_width = $guide_item['width'] ? $guide_item['width'] : 'm';
		} else {
			$modal = false;
		}

		$echo .= '<li id="'.$gid.'"';

		if (isset($done) && $done) 
			$echo .= ' class="done"';

		$echo .= '>';
		if( !isset($guide_item["done"]) || $guide_item["done"] == false ) {

			if ( isset($done) && $done ) {
				$echo .= '<a href="#markit" class="markit">'.$undone_text.'</a>';
			} else {
				$echo .= '<a href="#markit" class="markit">'.$done_text.'</a>';
			}

		}

		if (!empty($guide_item["help"])) {
			$echo .= $guide_item["help"];
		}
			
		if (!empty($guide_item["url"]) && !(isset($guide_item["unlink"]) && $guide_item["unlink"] && isset($guide_item["done"]) && $guide_item["done"]) ) {
			//$echo .= '<a class="guide'._if($modal, ' help').'">'.$guide_item["msg"].' <span class="rarr">&rarr;</span></a>'; 

			$echo .= '<a ';
				if ( isset($modal) && $modal ) {
					if ( isset($modal_id) && $modal_id ) {
						$echo .= ' rel="'.$modal_id.'"';
					}

					if ( isset($modal_title) && $modal_title ) {
						$echo .= ' title="'.$modal_title.'"';
					}

					if ( isset($modal_width) && $modal_width ) {
						$echo .= ' width="'.$modal_width.'"';
					}

				}

				if ( isset($guide_item["url"]) && $guide_item["url"] ) {
					$echo .= ' href="'.$guide_item["url"].'"';
				}

					$echo .= ' class="guide';
					if ( isset($modal) && $modal ) {
						$echo .= ' help';
					}
					$echo .= '">';
			
				$echo .= $guide_item["msg"];
				$echo .= '<span class="rarr">&rarr;</span>';

			$echo .= '</a>';

		} else {
			$echo .= '<span class="guide">'. $guide_item["msg"] .'</span>';
		}
		$echo .= '</li>';
	
	endif;
	
	}
	
$percent_write = ceil($percent);

if ( $percent_write > 100 )
	$percent_write = 100;

?>

        
 <?php if ( !isset($in_ajax) || $in_ajax !== 'TRUE' ) echo
'<script type="text/javascript">
// <![CDATA[

function CloudFw_matchPercent( per_old ){
	"use strict";

	var guide_per_value = parseInt( jQuery("#pbar-percent").html() );
	var guide_per_value_old = per_old ? per_old : 0;
	var guide_per_diff = guide_per_value > guide_per_value_old ? (guide_per_value - guide_per_value_old) : (guide_per_value_old - guide_per_value);
	var guide_percent = (guide_per_value / 100);
	var guide_width = (660 * guide_percent);

	jQuery("#pbar-bar").animate({"width": guide_width+"px"},2000);
	cloudfw_make_timer(jQuery("#pbar-in-center"), guide_per_value, 2000);

}
                    
jQuery(document).ready(function() {
	"use strict";
						
	CloudFw_matchPercent();

	jQuery(document).delegate(".markit", "click",function(){
											
	jQuery("#to-do-loading").show();

	var el = jQuery(this);
	var id = el.parent("li").attr("id");

	if (!id) id = "__dontshowanymore";

	var operation = (el.parent("li").hasClass("done")) ? "undone": "done";
	var guide_per_value_old = parseInt( jQuery("#pbar-percent-old").html() );

	jQuery.ajax({
	  url: CloudFwOp.ajaxUrl,
	  cache: false,
	  data: ({
	  	action : "cloudfw_conf_wizard",
		nonce: CloudFwOp.cloudfw_nonce,
	  	id : id,
	  	op : operation,
	  	old_val : guide_per_value_old 
	  }),
	  success: function(data) {
		jQuery("#guide").html(data);
		CloudFw_matchPercent( guide_per_value_old );
		jQuery("#to-do-loading").hide();
	  }
	});

	return false;

	});

	jQuery("#closetodolist").click(function(){
		cloudfw_global_loading("show");
		cloudfw_ui_hide_container( 
			{
				key: "map",
				title: "'. __('Configuration wizard has been hidden successfuly.','cloudfw') .'"
			}, 
			function(){
				cloudfw_global_loading("hide");
				jQuery("#guide").slideUp();
			}
		);
	});


});
 
// ]]>
</script>
    
    ';?>


<?php if ( !isset($in_ajax) || $in_ajax !== 'TRUE' ) echo '<div id="guide">' ?>
<div class="framework_container">

    <div class="header"></div>
    
    <div class="content">
        
        <div class="head">
        
          <div id="to-do-loading" class="small_loading"></div> <div class="icon wand"></div>  <h1><?php _e('Configuration Wizard','cloudfw'); ?></h1>
        
        </div>
        <?php 

			echo '
			<span id="pbar-percent" style="display:none;">',($percent_write <10) ? 10: $percent_write,'</span>
			<span id="pbar-percent-old" style="display:none;">'.$percent_write.'</span>

			';
		
		?>
        <div id="pbar">
        		
                <div id="pbar-bar" style="width:<?php if(isset($percent_old) && $percent_old >10) echo $percent_old; else echo 10; ?>%;">
                
                	<div id="pbar-in-center"><span id="pbar-value"><?php 

                	 if ( defined ( 'DOING_AJAX' ) && DOING_AJAX ) 
                	 	echo $percent_old;
                	 else
                	 	echo '0';

                	?></span>%</div>
                    <div id="pbar-in-left"></div>
                    <div id="pbar-in-right"></div>
                
                </div>
        	
        </div>

       <div class="clear"></div>
       
       <div class="module" style="padding: 0 30px;">
              
       		<div class="grid fullpage">
                        
            	<ul class="todolist">
                   <?php echo isset($echo) ? $echo : NULL;?>
                </ul>            
            
            </div>

            
       <div class="clear"></div>
       
		<?php if ($percent_write == 100) 
			echo '<div style="text-align:center;">'.__('Configuration Completed','cloudfw').'&nbsp;&nbsp;&nbsp;<a id="closetodolist" href="javascript:void(0);" class="small-button small-ocean button-float-none"><span>'.__('Hide the Wizard','cloudfw').'</span></a></div> <div class="clear"></div>';
		?>

       
       </div>
       
       
    </div>

</div> 