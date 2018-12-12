<?php

get_header();

while (have_posts()) {
    the_post(); ?>
<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/bassets.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">
      <?php the_title(); ?>
    </h1>
    <div class="page-banner__intro">
      <p>DONT FORGET TO REPLACE ME !#!#!#!#!#!#!#!#!#!</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">

  <div class="generic_content">
    <div class="row group"> 
      <div class="one-third"> <?php /* Employee thumbnail */
      the_post_thumbnail(); ?>
      </div>
      
      <div class="two-thirds"><?php /* Employee Bio */ 
      the_content(); ?>
      </div>
    </div>
  </div>
  
  <?php /* Handles displaying related locales for events with a locale relationship */
    $relatedLocales = get_field('related_locales');
    if($relatedLocales){ /* Checks if event has related locales, before displaying */
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Works at</h2>';
      echo '<ul class="link-list min-list">';
      foreach($relatedLocales as $locale){ ?>
        <li><a href="<?php echo get_the_permalink($locale);?>"> <?php echo get_the_title($locale); ?></a></li>
      <?php }
      echo '</ul>';
    }
    ?>

  </div>
  <?php }

get_footer();

?>