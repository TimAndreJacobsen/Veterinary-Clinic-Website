<?php
  get_header();
  while (have_posts()) {
      the_post(); 
      page_banner();
      ?>

<div class="container container--narrow page-section">
content goes here!
</div>

<?php
  }
  get_footer();
?>