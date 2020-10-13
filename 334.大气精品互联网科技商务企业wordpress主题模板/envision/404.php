<?php 

$id = cloudfw_get_option( 'page_defines', '404' );
cloudfw( 'set_ID', $id );

$title = cloudfw_translate('404_title');
$text = cloudfw_translate('404_text');

if ( empty($id) ) {
	cloudfw( 'set_meta', 'titlebar_title', $title );
}

cloudfw( 'check' );

get_header(); 

	cloudfw( 'set', 'check_for_content_exists', true ); if ( !cloudfw( 'page' )) : ?>

	   	<div class="text-center">
	    	<h1 class="big-title" style="font-size: 60px;"><?php echo $title; ?></h1>
			<div class="up"></div>
	        <h3><?php echo $text; ?></h3>
	    </div>
	    
		<div class="down"></div>
	    <style type="text/css">
	    	input#search {
	    		width: 90%;
	    		max-width: 500px;
	    	}
	    </style>
		<div class="text-center" style="width:100%; margin: auto;"><?php get_search_form(); ?></div>
		<div class="down"></div>

	<?php endif; ?>

<?php get_footer(); ?>