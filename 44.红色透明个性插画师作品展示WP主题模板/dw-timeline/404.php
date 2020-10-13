<img src="<?php echo get_template_directory_uri() ?>/assets/img/404.png" alt="">
<?php 
	printf(__('You have found a missing time plot. %1$s Back in %2$s Home %3$s','dw-timeline'), 
		'<br>',
		'<a href="'.home_url().'">',
		'</a>'
) ?>