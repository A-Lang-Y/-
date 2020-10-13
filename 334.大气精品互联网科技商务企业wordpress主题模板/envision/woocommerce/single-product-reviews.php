<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */
global $woocommerce, $product;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<?php if ( comments_open() ) : ?><div id="product-reviews"><?php

	echo '<div id="comments" class="clearfix">';

	echo '<div class="clear"></div>';

	$title_reply = '';

	if ( have_comments() ) :

		echo '<ol class="commentlist">';

		wp_list_comments( array( 'callback' => 'woocommerce_comments' ) );

		echo '</ol>';

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

			<div class="ui--pagination-wrapper clearfix">
				<ul class="ui--pagination unstyled clearfix">
					<li class="ui--box ui--gradient ui--gradient-grey">
						<?php previous_comments_link( ' <i class="fontawesome-angle-left px14"></i>' . cloudfw_translate( 'previous_page' ) ); ?>
					</li>
					<li class="ui--box ui--gradient ui--gradient-grey">
						<?php next_comments_link(  cloudfw_translate( 'next_page' ) . ' <i class="fontawesome-angle-right px14"></i>' ); ?>
					</li>
				</ul>
			</div>

		<?php endif;

		$title_reply = __( 'Add a review', 'woocommerce' );

	else :

		$title_reply = __( 'Be the first to review', 'woocommerce' ).' &ldquo;'.$post->post_title.'&rdquo;';
		?>
			<p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
		<?php
	
	endif;

	$commenter = wp_get_current_commenter();

	echo '</div>';
	

	echo '<div id="review_form_wrapper"><div id="review_form">';


	$comment_form = array(
		'title_reply' => $title_reply,
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'fields' => array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'woocommerce' ) . '<span class="required">*</span>' . '</label> ' .
			            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'woocommerce' ) . '<span class="required">*</span>' . '</label> ' .
			            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
		),
		'label_submit' => __( 'Add Your Review', 'woocommerce' ),
		'logged_in_as' => '',
		'comment_field' => ''
	);

	if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {


		$rating_html = '<p class="comment-form-rating"><label for="ui--rating-selector">' . __( 'Rating', 'woocommerce' ) .'</label><select name="rating" id="ui--rating-selector">
			<option value="">'.__( 'Rate&hellip;', 'woocommerce' ).'</option>
			<option value="5">'.__( 'Perfect', 'woocommerce' ).'</option>
			<option value="4">'.__( 'Good', 'woocommerce' ).'</option>
			<option value="3">'.__( 'Average', 'woocommerce' ).'</option>
			<option value="2">'.__( 'Not that bad', 'woocommerce' ).'</option>
			<option value="1">'.__( 'Very Poor', 'woocommerce' ).'</option>
		</select></p>';

		if( is_user_logged_in() )
			$comment_form['comment_field'] .= $rating_html;
		else
			$comment_form['fields']['comment_field'] = $rating_html;
	}

	$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>' . wp_nonce_field( 'woocommerce-comment_rating', '_wpnonce', true, false );

	cloudfw('comment_form', apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ));

	echo '</div></div>';

?><div class="clear"></div></div>
<?php endif; ?>