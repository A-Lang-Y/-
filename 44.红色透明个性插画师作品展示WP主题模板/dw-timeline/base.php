<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
  <?php do_action('get_header'); ?>
  <?php get_template_part('templates/header'); ?>
  <div class="wrap container" role="document">
    <div class="content row">
      <main class="main <?php echo dw_timeline_main_class(); ?>" role="main">
        <?php include dw_timeline_template_path(); ?>
      </main>
    </div>
  </div>
  <?php get_template_part('templates/footer'); ?>

</body>
</html>
