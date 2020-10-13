<article <?php post_class(); ?>>
  <?php get_template_part('templates/page', 'header'); ?>
  <?php get_template_part('templates/content', 'page'); ?>
  <?php comments_template('/templates/comments.php'); ?>
</article>
