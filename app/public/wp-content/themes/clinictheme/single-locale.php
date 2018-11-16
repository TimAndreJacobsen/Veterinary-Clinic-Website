<?php

get_header();

while (have_posts()) {
    the_post(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/bassets.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Locales</h1>
    <div class="page-banner__intro">
      <p>Services avaliable at <?php the_title(); ?></p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('locale'); ?> ">
        <i class="fa fa-home" aria-hidden="true"></i> All locales</a>
      <span class="metabox__main">
        <?php the_title(); ?> </span></p>
  </div>

  <div class="generic_content">
    <?php the_content(); ?>
  </div>
</div>
<?php
}

get_footer();

?>