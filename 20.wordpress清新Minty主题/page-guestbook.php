<?php
/*
Template Name: Guestbook Page
*/
?>

<?php get_header(); ?>

	<main id="main" class="hfeed" role="main" itemscope itemtype="http://schema.org/ContactPage">

	<?php while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title" itemprop="name headline"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content">
				<?php the_content(); ?>
<?php
if ( get_option('minty_template_readers') == true ) {

$exclude_emails = get_option('minty_template_readers_exclude_emails');
$exclude_emails_string = '';
if ( !empty($exclude_emails) ) {
	$exclude_emails = explode('|', $exclude_emails);
    $exclude_emails_string = "AND comment_author_email != '" . implode("' AND comment_author_email != '", $exclude_emails) . "' ";
}
$query="SELECT COUNT(comment_ID) AS count, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 1 MONTH) " . $exclude_emails_string . "AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY count DESC LIMIT 3";
$readerlist = $wpdb->get_results($query);
$output .= "<a rel='external nofollow' href='{$readerlist[1]->comment_author_url}' target='_blank'>" . get_avatar($readerlist[1]->comment_author_email, 60) . "<b class='name'>{$readerlist[1]->comment_author}</b><i class='count'>+{$readerlist[1]->count}</i></a>";
$output .= "<a rel='external nofollow' href='{$readerlist[0]->comment_author_url}' target='_blank'>" . get_avatar($readerlist[0]->comment_author_email, 80) . "<b class='name'>{$readerlist[0]->comment_author}</b><i class='count'>+{$readerlist[0]->count}</i></a>";
$output .= "<a rel='external nofollow' href='{$readerlist[2]->comment_author_url}' target='_blank'>" . get_avatar($readerlist[2]->comment_author_email, 60) . "<b class='name'>{$readerlist[2]->comment_author}</b><i class='count'>+{$readerlist[2]->count}</i></a>";
echo '<div class="dearreaders"><h3>' . get_option('minty_template_readers_title') . '</h3><div>' . $output . '</div></div>' ;
}
?>
			</div>
		</article>

		<?php get_template_part( 'ad', 'single' ); ?>
		<?php comments_template(); ?>

	<?php endwhile; ?>
	</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>