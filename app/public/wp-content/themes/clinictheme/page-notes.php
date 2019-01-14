<?php
  get_header();
  while (have_posts()) {
      the_post(); 
      page_banner();
      ?>

<div class="container container--narrow page-section">


  <div class="generic-content">
  budy content here
    <?php the_content(); ?>
  </div>

</div>

<?php
  }
  get_footer();
?>