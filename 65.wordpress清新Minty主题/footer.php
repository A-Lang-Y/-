		<?php if (get_option('minty_breadcrumb') == 'bottom' && (get_option('minty_breadcrumb_nohome') == 1 ? !is_home() : true)) minty_breadcrumb(); ?>
	</div>

	<footer id="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
		<nav class="links">
			<?php
			$footernav = strip_tags( wp_nav_menu( array(
					'theme_location'  => 'footer',
					'container'       => false,
					'depth'           => 1,
					'echo'            => false
				) ), '<a>' );
			$footernav = preg_replace( '/\n<a/', ' ' . get_option('minty_footer_nav_separator') . ' <a', $footernav);
			echo $footernav;
			?>
		</nav>
		<div class="copyright">
			&copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a> &middot; Powered by <a href="http://www.2zzt.com/" target="_blank" rel="generator">WordPress</a> &middot; Theme by <a href="http://c7sky.com/" target="_blank">小影</a><?php echo stripslashes(get_option('minty_footer_code'));
			if( get_option('minty_stat_noadmin') == true ? !current_user_can('edit_dashboard') : true ) {
				echo get_option('minty_stat_hidden') == true
					? '<div class="stat">' . stripslashes(get_option('minty_stat_code')) . '</div>'
					: stripslashes(get_option('minty_stat_code'));
			}; ?>
		</div>
		<a id="rocket" href="#top" title="返回顶部"><i></i></a>
	</footer>


<script>MINTY = <?php
	echo json_encode( array (
		'ajaxurl' => admin_url('admin-ajax.php'),
		'lazyload' => get_option('minty_lazyload', false),
		'stickySidebar' => get_option('minty_sticky_widget', 'disabled'),
		'keyboardNavigation' => get_option('minty_keyboard_navigation', false),
		'infiniteScroll' => get_option('minty_infinitescroll', false),
		'slidesTimeout' => get_option('minty_featured_content_timeout', 4e3)
	) );
?></script>

<?php wp_footer(); ?>
</body>
</html>