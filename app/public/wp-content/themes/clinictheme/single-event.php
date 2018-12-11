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
<?php /* Metabox on banner */ ?>
<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?> ">
        <i class="fa fa-home" aria-hidden="true"></i> Events Page</a>
      <span class="metabox__main">
        <?php the_title(); /* title in metabox */ ?> </span></p>
  </div>
  <div class="generic_content">
    <?php the_content(); /* displaying post_content below banner */ ?>
  </div>
  
  <?php
  /* Handles displaying related locales for events with a locale relationship */
    $relatedLocales = get_field('related_locales');
    if($relatedLocales){ /* Checks if event has related locales, before displaying */
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Related Locales</h2>';
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