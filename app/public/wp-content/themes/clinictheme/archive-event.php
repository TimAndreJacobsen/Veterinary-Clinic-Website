<?php
    get_header();
?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: 
        url(<?php echo get_theme_file_uri('/images/5_dogs.jpg') ?> );">
  </div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">All Events</h1>
    <div class="page-banner__intro">Past events hosted by the Clinic
    </div>
  </div>
</div>
<br><br>
<div class="container container--narrow page section">
  <?php
  while (have_posts()) {
      the_post(); 
      $eventDate = new DateTime(get_field('event_date', false, false)); ?>
  <div class="event-summary">
    <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
      <span class="event-summary__month">
        <?php echo $eventDate->format('M'); ?></span>
      <span class="event-summary__day">
        <?php echo $eventDate->format('d'); ?></span>
    </a>
    <div class="event-summary__content">
      <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>">
          <?php the_title(); ?></a></h5>
      <p>
        <?php echo wp_trim_words(get_the_content(), 30); ?><a href="<?php the_permalink(); ?>" class="nu gray">
          <br>See more</a></p>
    </div>
  </div>
  <?php
  }
    echo paginate_links();
?>

  <hr class="section-break">
  <p>Want to browse our <a href="<?php echo site_url('/past-events') ?>">past events?</p>
</div>

<?php
  get_footer();
?>