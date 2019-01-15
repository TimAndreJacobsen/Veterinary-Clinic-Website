<?php

get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/dogs-whitebg.jpg') ?>);">
  </div>
  <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large">Welcomeasdf</h1>
    <h2 class="headline headline--medium">To the Clinicasdf</h2>
    <h3 class="headline headline--small">Browse our services and book an appointment</h3>
    <a href="<?php echo esc_url(site_url('/snake')); ?>" class="btn btn--large btn--blue">Book an Appointment</a>
    <?php /* esc_url() Security: Whenever manually echoing from the database. Prevents hacked website from endangering users */ ?>
  </div>
</div>asdfasdfasdfasdfasdf

<div class="full-width-split group">
  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
      <?php $frontpageEvents = new WP_Query(array(
          'posts_per_page' => 2,
          'post_type' => 'event',
          'orderby' => 'meta_value_num',
          'meta_key' => 'event_date',
          'order' => 'DESC',
          'meta_query' => array(
            array(
              'key' => 'event_date',
              'compare' => '>=',
              'value' => date('Ymd'), /* loads todays date for use in meta_query */
              'type' => 'numeric'
            )
          )
        ));
        while ($frontpageEvents->have_posts()) {
            $frontpageEvents->the_post();
            get_template_part('template-parts/content', get_post_type());
        } wp_reset_postdata(); ?>

      <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event') ?>" class="btn btn--blue">View
          All Events</a></p>
    </div>
  </div>

  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Articles</h2>
      <?php
      $frontpagePosts = new WP_query(array(
        'posts_per_page' => 2,
        'order' => 'DESC'
      ));
      while ($frontpagePosts->have_posts()) {
        $frontpagePosts->the_post(); 
        get_template_part('template-parts/content', get_post_type());
      } wp_reset_postdata(); ?>

      <p class="t-center no-margin"><a href="<?php echo esc_url(site_url('/articles')); ?>" class="btn btn--blue">View All Posted
          Articles</a></p>
    </div>
  </div>
</div>

<div class="hero-slider">
  <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bus.jpg') ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">Accessible by public transport</h2>
        <p class="t-center">Check out which public transport options are avaliable</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
  <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/brew-and-beans.jpg') ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">Free Coffee</h2>
        <p class="t-center">We have fresh coffee for those in need.</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
</div>

<?php
/* Wordpress functions */
get_footer();

/* Helper functions */
function slugBuilder(/*wp puts post object in global scope*/)
{
    /* TODO: Consider factoring this out of front-page.php */
    $postYear = get_the_date('Y');
    $postMonth = get_the_date('n');
    return "/".$postYear."/".$postMonth;
}

?>