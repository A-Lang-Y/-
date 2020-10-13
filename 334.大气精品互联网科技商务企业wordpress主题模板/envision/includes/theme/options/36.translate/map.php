<?php

/** Default Texts */
$map  -> option  ( 'texts' )
     /** General Texts */
    -> sub     ( 'home', __('Home','cloudfw') )
    -> sub     ( 'search', __('Search','cloudfw') )
    -> sub     ( 'mobile_navigation',  __('Navigation','cloudfw') )

    -> sub     ( '404_title', __('<strong>404</strong> Not Found','cloudfw') )
    -> sub     ( '404_text',  __('The page you try to see cannot found','cloudfw') )

    -> sub     ( 'category_titles', __('Category: %s','cloudfw') )
    -> sub     ( 'tag_titles', __('Tag: %s','cloudfw') )
    -> sub     ( 'archive_titles', __('Archive: %s','cloudfw') )
    -> sub     ( 'search_titles', __('Search results for "%s"','cloudfw') )
    -> sub     ( 'sticky_post', __('Sticky Post','cloudfw') )

    -> sub     ( 'time_seconds',  __('%s seconds ago','cloudfw') )
    -> sub     ( 'time_second',  __('a second ago','cloudfw') )
    -> sub     ( 'time_minutes',  __('%d minutes ago','cloudfw') )
    -> sub     ( 'time_minute',   __('a minute ago','cloudfw') )
    -> sub     ( 'time_hours',  __('%d hours ago','cloudfw') )
    -> sub     ( 'time_hour',   __('an hour ago','cloudfw') )
    -> sub     ( 'time_days',   __('%d days ago','cloudfw') )
    -> sub     ( 'time_day',  __('a day ago','cloudfw') )
    -> sub     ( 'time_months',   __('%d months ago','cloudfw') )
    -> sub     ( 'time_month',  __('a month ago','cloudfw') )
    -> sub     ( 'time_years',   __('%d years ago','cloudfw') )
    -> sub     ( 'time_year',  __('a year ago','cloudfw') )

    -> sub     ( 'sharrre.like_post',  __( '<strong>Like</strong> this post!', 'cloudfw' ) )
    -> sub     ( 'sharrre.plural_likes',  __( '<strong>%d</strong> Likes', 'cloudfw' ) )
    -> sub     ( 'sharrre.single_likes',  __( '<strong>%d</strong> Like', 'cloudfw' ) )
    -> sub     ( 'sharrre.like_this',  __( 'Like this', 'cloudfw' ) )
    -> sub     ( 'sharrre.already_like_this',  __( 'You already liked this', 'cloudfw' ) )

    /** Blog Text */
    -> sub     ( 'read_more',  __('Read More','cloudfw') )
    -> sub     ( 'goto_blog_page',  __('Go to the blog page','cloudfw') )
    -> sub     ( 'previous_post',  __('Previous Post','cloudfw') )
    -> sub     ( 'next_post',  __('Next Post','cloudfw') )
    
    -> sub     ( 'blog.single.about_author',  __( '<strong>About</strong> the Author', 'cloudfw' ) )
    -> sub     ( 'blog.single.share_the_post',  __( '<strong>Share</strong> the Post', 'cloudfw' ) )
    -> sub     ( 'blog.single.comments_s',  __('<strong>Comments</strong> (%s)','cloudfw') )
    -> sub     ( 'blog.single.comments',  __('<strong>Comments</strong>','cloudfw') )
    -> sub     ( 'blog.single.comments_closed',  __( 'Comments are closed.', 'cloudfw' ) )
    -> sub     ( 'blog.single.no_comment_yet',  __( 'No comment yet.', 'cloudfw' ) )
    -> sub     ( 'blog.single.comment_navigation',  __( 'Comment navigation', 'cloudfw' ) )
    -> sub     ( 'blog.single.older_comments',  __( '&larr; Older Comments', 'cloudfw' ) )
    -> sub     ( 'blog.single.newer_comments',  __( 'Newer Comments &rarr;', 'cloudfw' ) )

    -> sub     ( 'commentform.name',  __('Name','cloudfw') )
    -> sub     ( 'commentform.email',  __('Email','cloudfw') )
    -> sub     ( 'commentform.website',  __('Website','cloudfw') )
    -> sub     ( 'commentform.comment',  __('Comment','cloudfw') )
    -> sub     ( 'commentform.leave_a_reply',  __('Leave a Reply','cloudfw') )
    -> sub     ( 'commentform.title_reply_to',  __('Leave a Reply to %s','cloudfw') )
    -> sub     ( 'commentform.reply',  __( 'reply', 'cloudfw' ) )
    -> sub     ( 'commentform.cancel_reply',  __('Cancel reply','cloudfw') )
    -> sub     ( 'commentform.post_comment',  __('Post Comment','cloudfw') )
    -> sub     ( 'commentform.must_log_in',  __( 'You must be <a href="%s">logged in</a> to post a comment.' ) )
    -> sub     ( 'commentform.logged_in_as',  __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ) )
    -> sub     ( 'commentform.email_not_published',  __( 'Your email address will not be published.' ) )
    -> sub     ( 'commentform.required_fields_marked',  __( 'Required fields are marked %s' ) )

    /** Porfolio Text */
    -> sub     ( 'portfolio_related',  __('Related Portfolios','cloudfw') )
    -> sub     ( 'portfolio_filter_all',  __('All','cloudfw') )

    /** WooCommerce Plugin Text */
    -> sub     ( 'wc.widget.login.text',  __('Welcome <strong>%s!</strong>','cloudfw') )
    -> sub     ( 'wc.loop.badge.sale',  __('Sale!','cloudfw') )
    -> sub     ( 'wc.loop.badge.out_of_stock',  __('Out of Stock','cloudfw') )
    -> sub     ( 'wc.loop.badge.free',  __('Free','cloudfw') )
    -> sub     ( 'wc.loop.ajax_added',  __('Added','cloudfw') )
    -> sub     ( 'wc.loop.details',  __('Details','cloudfw') )

    /* Not Registered yet. */
    -> sub     ( 'previous_page',  __('Previous Page','cloudfw') )
    -> sub     ( 'next_page',  __('Next Page','cloudfw') )

;