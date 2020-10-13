<?php
/**
 * Footer 主题文件
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 3.0.0
 */
?>

<footer id="zan-footer">
	<section class="zan-link" id="zan-link">
		<div class="container">
      <div class="row">
          <div class="col-md-4">
              <div class="footer-column about">
                  <h4>
                      关于我们
                  </h4>
                  <div class="content">
                      <?php echo stripslashes( get_option( 'zan_about' ) ); ?>
                  </div>
              </div>
              <div class="footer-column about">
                  <h4>
                      联系我们
                  </h4>
                  <div class="content">
                      <?php echo stripslashes( get_option( 'zan_contact' ) ); ?>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="footer-column tag">
                  <h4>
                       热门标签
                  </h4>
                  <div class="content clearfix">
                      <?php wp_tag_cloud( 'smallest=14&largest=14&orderby=count&unit=px&number=50&order=RAND' );?>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
               <div class="footer-column friend-link">
                  <h4>
                      友情链接
                  </h4>
                  <div class="content">
                      <ul class="clearfix">
                          <?php wp_list_bookmarks( 'title_li=&categorize=0' ); ?>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  	</div>
	</section>
	<section class="footer-space">
    <div class="footer-space-line"></div>
  </section>
	<section class="zan-copyright">
		<div class="container">
			<?php echo stripslashes( get_option( 'zan_footer' ) ); ?>  Theme by <a href="http://www.yeahzan.com/"  target="_blank">YeahZan</a>
		  <!--统计代码开始-->
		  <?php $analytics = get_option( 'zan_analytics' );if ( $analytics != "" ) : ?>
		    <?php echo stripslashes( $analytics ); ?>
		  <?php endif ?>
		  <!--统计代码结束-->
		</div>
	</section>
</footer>
<div id="zan-gotop">
  <div class="gotop">
    <i class="fa fa-chevron-up"></i>
  </div>
</div>
<?php wp_footer(); ?>
<script type='text/javascript'>
  backTop = function ( btnId ) {
    var btn =document.getElementById( btnId );
    var d = document.documentElement;
    var b = document.body;
    window.onscroll = set;
    btn.onclick = function () {
      btn.style.display = "none";
      window.onscroll = null;
      this.timer = setInterval( function() {
        d.scrollTop -= Math.ceil( ( d.scrollTop + b.scrollTop ) * 0.1 );
        b.scrollTop -= Math.ceil( ( d.scrollTop + b.scrollTop ) * 0.1 );
        if( ( d.scrollTop + b.scrollTop ) == 0 ) clearInterval( btn.timer, window.onscroll=set );
      }, 10 );
    };
    function set() { btn.style.display = ( d.scrollTop + b.scrollTop > 100 ) ? 'block' : "none" }
  };
  backTop( 'zan-gotop' );
</script>