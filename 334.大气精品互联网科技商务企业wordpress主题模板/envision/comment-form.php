<?php

    global $id;

    if ( null === $post_id ) {
        $post_id = $id;
    } else {
        $id = $post_id;
    }

    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $fields =  array(
        'author' => '<p class="comment-form-author">' . '<label for="author">' . cloudfw_translate('commentform.name') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
        'email'  => '<p class="comment-form-email"><label for="email">' . cloudfw_translate('commentform.email') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
        'url'    => '<p class="comment-form-url"><label for="url">' . cloudfw_translate('commentform.website') . '</label>' .
                    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
    );

    $required_text = sprintf( ' ' . cloudfw_translate('commentform.required_fields_marked'), '<span class="required">*</span>' );
    $defaults = array(
        'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . cloudfw_translate('commentform.comment') . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
        'must_log_in'          => '<p class="must-log-in">' . sprintf( cloudfw_translate('commentform.must_log_in'), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'logged_in_as'         => '<p class="logged-in-as">' . sprintf( cloudfw_translate('commentform.logged_in_as'), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'comment_notes_before' => '<p class="comment-notes">' . cloudfw_translate('commentform.email_not_published') . ( $req ? $required_text : '' ) . '</p>',
        //'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
        'comment_notes_after'  => '',
        'comment_fields_before'=> '',
        'comment_fields_after' => '',
        'id_form'              => 'commentform',
        'id_submit'            => 'submit',
        'title_reply'          => cloudfw_translate('commentform.leave_a_reply'),
        'title_reply_to'       => cloudfw_translate('commentform.leave_a_reply_to_s'),
        'cancel_reply_link'    => cloudfw_translate('commentform.cancel_reply'),
        'label_submit'         => cloudfw_translate('commentform.post_comment'),
    );

    $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

    ?>
        <?php if ( comments_open( $post_id ) ) : ?>
            <?php do_action( 'comment_form_before' ); ?>
            <div id="respond" class="ui--comment-form">
                <div class="ui--box">
                    <?php 
                        ob_start();
                            comment_form_title( $args['title_reply'], $args['title_reply_to'] );
                            $comment_form_title = ob_get_contents();
                        ob_end_clean();

                     ?>

                    <div class="respond-header clearfix ui--gradient ui--gradient-grey ui--gradient-grey-border-bottom">
                        <div class="pull-right">
                            <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small>
                        </div>
                        <div class="pull-left">
                            <h5 style="margin: 0; padding: 0;"><strong><?php echo $comment_form_title; ?></strong></h5>
                        </div>
                        <?php //echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h5', 'id' => 'reply-title' ), $comment_form_title ) ); ?>
                    </div>

                    <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
                        <?php echo $args['must_log_in']; ?>
                        <?php do_action( 'comment_form_must_log_in_after' ); ?>
                    <?php else : ?>
                        <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
                            <?php do_action( 'comment_form_top' ); ?>

                                <?php if ( is_user_logged_in() ) : ?>
                                    <?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
                                    <?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
                                <?php else : ?>
                                    <?php echo $args['comment_notes_before']; ?>
                                    <?php
                                    do_action( 'comment_form_before_fields' ); ?>
                                    <?php echo $args['comment_fields_before']; ?>
                                    <?php

                                    $i = 0;
                                    $column_array = array();
                                    $column_array['_key'] = 'comment_fields';
                                    $column_array['row_class'] = 'row-fluid';
                                    $fields_columns = 3;
                                    $field_total = count($args['fields']);

                                    foreach ( (array) $args['fields'] as $name => $field ) {
                                        $i++;
                                        echo cloudfw_UI_column( $column_array, apply_filters( "comment_form_field_{$name}", $field ) . "\n", '1of' . $fields_columns . ( $i % $fields_columns == 0 ? '_last' : '' ), $field_total == $i );
                                    }
                                    ?>
                                    <?php echo $args['comment_fields_after']; ?>
                                    <?php
                                    do_action( 'comment_form_after_fields' );
                                    ?>
                                <?php endif; ?>
                                <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
                                <?php echo $args['comment_notes_after']; ?>

                            <div class="form-submit clearfix ui--gradient ui--gradient-grey">
                                <button name="submit" type="submit" class="btn btn-primary" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" ><?php echo esc_attr( $args['label_submit'] ); ?></button>
                                <?php comment_id_fields( $post_id ); ?>
                            </div>
                            <?php do_action( 'comment_form', $post_id ); ?>
                        </form>
                    <?php endif; ?>
                </div><!-- .ui-box -->
            </div><!-- #respond -->
            <?php do_action( 'comment_form_after' ); ?>
        <?php else : ?>
            <?php do_action( 'comment_form_comments_closed' ); ?>
        <?php endif; ?>