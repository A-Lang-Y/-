	<?php 
	$message_request = isset($_GET["m"]) ? $_GET["m"] : NULL;
	if ( $message = cloudfw_admin_messages( $message_request ) )
		echo cloudfw_dialog(
			isset($message['title'])? $message['title'] : '',
			isset($message['msg']) 	? $message['msg'] : '',
			isset($message['key']) 	? $message['key'] : ''
		);		
	?>

	</div> <!-- /#cloud_content -->

</div><!-- /#cloudfw_vertical_sub_navigation_wrap -->
<div id="spinner"></div>