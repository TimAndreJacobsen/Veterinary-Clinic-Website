<?php 
  get_header(); 
?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/grey-cat.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p>DONT FORGET TO REPLACE ME !#!#!#!#!#!#!#!#!#!</p>
        </div>
     </div>  
    </div>

<?php
  get_footer();
?>