<?php get_header(); ?>

	<main id="main" class="hfeed" role="main" itemscope itemtype="http://schema.org/ImageObject">
	
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
			<header class="entry-header">
				<h1 class="entry-title" itemprop="name headline"><?php the_title(); ?></h1>

				<div class="entry-meta">
					<?php						
						$published_text = '<time class="entry-date" datetime="%1$s" pubdate itemprop="datePublished">%2$s</time> <span class="dot">&bull;</span> 属于<a href="%3$s" title="回到 %4$s" rel="gallery">%5$s</a></span>';
						$post_title = get_the_title( $post->post_parent );
						if ( empty( $post_title ) || 0 == $post->post_parent )
							$published_text = '<time class="entry-date" datetime="%1$s" pubdate itemprop="datePublished">%2$s</time>';

						printf( $published_text,
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date( 'Y-m-d' ) ),
							esc_url( get_permalink( $post->post_parent ) ),
							esc_attr( strip_tags( $post_title ) ),
							$post_title
						);

						$metadata = wp_get_attachment_metadata();
						printf( ' <span class="dot">&bull;</span> <span class="attachment-meta full-size-link"><a href="%1$s" title="%2$s">%3$s (%4$s &times; %5$s)</a></span>',
							esc_url( wp_get_attachment_url() ),
							'到全尺寸图像的链接',
							'全尺寸',
							$metadata['width'],
							$metadata['height']
						);

						edit_post_link(__('Edit This'), ' <span class="dot">&bull;</span> ');
					?>
				</div>
			</header>

			<div class="entry-content">

				<div class="entry-attachment">
					<figure class="attachment">
						<?php
							printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
								esc_url( wp_get_attachment_url() ),
								the_title_attribute( array( 'before' => '查看全尺寸的《', 'after' => '》', 'echo' => false ) ),
								wp_get_attachment_image( get_the_ID(), 'large' )
							);
						?>

						<?php if ( has_excerpt() ) : ?>
						<figcaption class="entry-caption" itemprop="caption">
							<?php the_excerpt(); ?>
						</figcaption>
						<?php endif; ?>
					</figure>
				</div>

				<?php if ( ! empty( $post->post_content ) ) : ?>
				<div class="entry-description" itemprop="description">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
				<?php endif; ?>

			</div>
		</article>
		
		<div id="explorer" class="clearfix">
			<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
				<i>分享到：</i>
				<a class="bds_tsina" title="分享到新浪微博"></a>
				<a class="bds_qzone" title="分享到QQ空间"></a>
				<a class="bds_tqq" title="分享到腾讯微博"></a>
				<a class="bds_renren" title="分享到人人"></a>
				<a class="bds_sqq" title="分享到QQ"></a>
				<a class="bds_douban" title="分享到豆瓣"></a>
				<span class="bds_more"></span>
			</div>

			<nav id="postination" tole="navigation">
				<span class="previous-post">
					<?php previous_image_link( false,'<span class="arrow">&lsaquo;</span> 上一张' ); ?>
				</span>
				<span class="dot"> &bull; </span>
				<span class="next-post">
					<?php next_image_link( false,'下一张 <span class="arrow">&rsaquo;</span>' ); ?>
				</span>
			</nav>
		</div>

		<?php get_template_part( 'ad' ); ?>
		
		<?php comments_template(); ?>

	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>