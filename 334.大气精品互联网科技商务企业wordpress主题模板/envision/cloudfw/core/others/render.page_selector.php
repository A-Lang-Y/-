<?php
	global $post;
	$the_query = new WP_Query();
	$filter = $_REQUEST['filter'];
	$filter_exploded = explode(',', $filter);

	$filters = array();
	foreach ($filter_exploded as $filter) {
		$filters[] = trim($filter);
	}

	$the_query = new WP_Query();
	$the_query->query(array( 'post_type' => $filters, 'showposts' => '-1'));
	$count = $the_query->post_count;

	//$the_query_column_row = ceil($count/2)-1;
	
	if ($the_query->have_posts()):
		echo '<ul id="cloudfw-ui-page-select-list" class="cloudfw-ui-list mini no-preview compact">';
		$i = 0; 
		while ($the_query->have_posts()) : $the_query->the_post();

			$the_title = get_the_title();
			if ( empty( $the_title ) )
				$the_title = __('[Untitled]','cloudfw');

			$label = get_post_type();


			echo '
			<li class="filter-'. sanitize_html_class($label) .'">
				<input type="hidden" id="data-ID" value="'. get_the_ID() .'">
				<input type="hidden" id="data-title" value="'. esc_attr( $the_title ) .'">
				<input type="hidden" id="data-permalink" value="'. get_permalink() .'">

				<div class="inset overflow-hidden">
									
				<div class="cont">
					<a href="javascript:;" class="use" rel="'. get_the_ID() .'">		
						<span class="title">'. $the_title .'</span>
						<span class="label label-'. sanitize_html_class($label) .'">'. $label .'</span>
					</a>
				</div>
				
				
				<div class="item-action" style="width:105px;">
					<div class="action-divider"></div>
					<div class="mini-action-icons horizontal item-2">
						<a href="javascript:;" class="use cloudfw-tooltip" title="'. __('select','cloudfw') .'"></a>
						<a href="'. get_permalink() .'" class="preview cloudfw-tooltip" target="_blank" title="'. __('open the page','cloudfw') .'"></a>
					</div>
				</div>

				<div class="clear"></div>

				</div>
			
			</li>';

		$i++;
		endwhile;
		
		echo '</ul><div class="clear"></div>';
		$show_not_found = false;
	else:		
		$show_not_found = true;
	endif;
		
	echo '<div class="cloudfw-ui-not-found-text" '._if( !$show_not_found, 'style="display:none;"' ).'>'.__('We couldn\'t found any result.','cloudfw').'</div>';