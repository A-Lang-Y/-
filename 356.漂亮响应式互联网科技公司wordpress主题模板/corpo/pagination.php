<!-- pagination -->
		<?php
			if(function_exists('wp_pagenavi')) :
				wp_pagenavi(); 
			else :
		?>
			<div class="wp-pagenavi">
				<div class="alignleft"><?php next_posts_link('&laquo; '.__('Older posts','corpo')) ?></div> 
				<div class="alignright"><?php previous_posts_link(__('Newer posts','corpo').' &raquo;') ?></div>
			</div>
		<?php endif; ?>      
<!-- /pagination -->