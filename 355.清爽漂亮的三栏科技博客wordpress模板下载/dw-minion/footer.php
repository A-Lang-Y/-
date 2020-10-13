        </div>
      </div>
    </div>
    <footer id="colophon" class="site-footer" role="contentinfo">
      <div class="container">
        <div class="site-info">
          <?php do_action( 'dw_minion_credits' ); ?>
          <a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'dw-minion' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'dw-minion' ), 'WordPress' ); ?></a><span class="sep">.</span>
          <?php printf( __( 'Theme: %1$s by %2$s.', 'dw-minion' ), 'DW Minion', '<a href="http://www.designwall.com/" rel="nofollow">DesignWall</a>' ); ?>
        </div>
      </div>
    </footer>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>