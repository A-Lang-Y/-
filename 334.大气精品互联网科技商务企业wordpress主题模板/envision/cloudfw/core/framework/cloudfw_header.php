	<?php global $page; ?>
	<ul id="cloudfw_navigation">                
		<?php 
			if ( is_array($cloudfw_nav_pages) ) {
				ksort($cloudfw_nav_pages);

				foreach ($cloudfw_nav_pages as $nav_page_id => $nav_page ) {

					$is_current_tab = ($nav_page_id === $cloudfw_current_page_number);

					/** Define URL */
					$nav_page_url = CLOUDFW_PAGE;

					/** Check slug for url */
					if ( !empty( $nav_page['page_slug'] ) )
						$nav_page_url 	.= '&amp;tab=' . $nav_page['page_slug'];

					if ( !empty( $nav_page['page_queries'] ) ) {
						
						if ( is_array( $nav_page['page_queries'] ) ) {
							foreach ($nav_page['page_queries'] as $query_tag => $query_value) {
								$nav_page_url 	.= '&amp;'. $query_tag .'='. $query_value;
							}
						} else
								$nav_page_url 	.= $nav_page['page_queries'];

					}	

					echo '<li id="', isset($nav_page['page_li_id']) ? $nav_page['page_li_id'] : NULL ,'"', $is_current_tab ? ' class="cloudfw_active_tab"':'' ,'>
							<a href="'. $nav_page_url .'" class="cl_nav" >
								<span id="'.$nav_page["page_css_id"].'" class="cloudfw_navigation_icon"></span>
								<span class="cloudfw_navigation_title">'.$nav_page["page_title"].'</span>
							</a>
						 </li>';
				}
				
			}

			
		?>
	</ul>

	<div id="cloud_header">
        
            <div id="cloud_logo"><a href="<?php echo CLOUDFW_PAGE;?>"><img src="<?php echo ($custom_logo = cloudfw_get_option('framework', 'logo')) ? esc_html($custom_logo) : ''; ?>" alt=""/></a></div>
                        
            <div id="cloud_nav_desc"><span></span></div>
        
            <div class="clear"></div>
    </div><!-- /#cloud_header -->

    <div class="clear"></div>

	<div id="cloudfw-tabs-loading">
		<span></span>
	</div>


    <div id="cloudfw_vertical_sub_navigation_wrap" class="<?php if ( isset($has_vertical_subnavigation) && $has_vertical_subnavigation ): ?>cloudfw-ui-tabs <?php endif; ?>pages_vertical" rel="pages_vertical_<?php echo $page.'_'.$tab?>">
    	
	<?php if ( isset($has_vertical_subnavigation) && $has_vertical_subnavigation ): ?>
	    <div id="cloudfw_vertical_sub_navigation">
	    	
	            <?php
				
					if ( isset($has_vertical_subnavigation) && $has_vertical_subnavigation ){
										
						echo '<ul>';
						
						ksort($vertical_subnavigation);
						$keys = array_keys($vertical_subnavigation); 

						$tab_class = ''; 
						$first_tab = reset($keys);
						$last_tab =  end($keys);
						$vertical_subnavigation_count = count($vertical_subnavigation);
						
						foreach($vertical_subnavigation as $tab_id => $vertical_tab):
							if ($first_tab == $tab_id) {
								$tab_class = "firsttab";
							} elseif ($last_tab == $tab_id) {
								$tab_class = "lasttab";
							} else {
								$tab_class = '';
							}
							
							if ( $vertical_subnavigation_count == 1 ) {
								$tab_class = "onetab";
							}
			
							if ( isset($vertical_tab["icon"]) && $vertical_tab["icon"] ) {
								$icon = true;
								$tab_class .= ' tab-icon tab-icon-' . $vertical_tab["icon"]; 
							} else {
								$icon = false;
							}

							if ( isset($vertical_tab["divider"]) && $vertical_tab["divider"] ) {
								$tab_class .= ' tab-space'; 

							}
							
							echo '<li class="',isset($tab_class) ? $tab_class : '','">';
								echo '<a href="#'.$vertical_tab["id"].'">';
									if ( $icon )
										echo '<span class="tab-icon-handler"></span>';
									echo $vertical_tab["title"];
								echo '</a>';
							echo '</li>';
						
						endforeach;
						
						echo '</ul><div class="clear"></div>';
						
					}

					$jump = isset($_REQUEST["jump"]) ? $_REQUEST["jump"] : '';
					$jump = !empty($jump) ? explode('/', $jump) : array();

					if ( isset( $jump[0] ) && is_numeric( $jump[0] ) )
						$onloadscript .= "\njQuery('#cloudfw_vertical_sub_navigation > ul').children().eq({$jump[0]}).find('a').click();\n";
				
					if ( isset( $jump[1] ) && is_numeric( $jump[1] ) )
						$onloadscript .= "\njQuery('.cloudfw_sub_navigation_items > ul').children().eq({$jump[1]}).find('a').click();\n";
				
					if ( isset( $jump[2] ) && is_numeric( $jump[2] ) )
						$onloadscript .= "\njQuery('.cloudfw-ui-mini-tabs > ul').children().eq({$jump[2]}).find('a').click();\n";
				
				 ?>

	    </div>
	<?php endif; ?>


	    <div id="cloudfw_content">
	    <div id="appandtohere-nags"></div>

	    <!-- /<div id="cloud_sub_bc"><?php echo $header_title; ?></div> -->
	            
	     <?php
			
			if ( ! isset( $onloadscript ) )
				$onloadscript = ''; 

			echo '<script type="text/javascript">
			// <![CDATA[
				jQuery(document).ready(function() {
					"use strict";

					'.$onloadscript.'
					cloudfw_tab_loaded();
				}); 
			// ]]>
			</script>';