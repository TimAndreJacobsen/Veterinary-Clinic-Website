<?php
    get_header();
?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: 
        url(<?php echo get_theme_file_uri('/images/5_dogs.jpg') ?> );">
    </div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Past Events</h1>
        <div class="page-banner__intro">Overview of past events
        </div>
    </div>
</div>
<br><br>
<div class="container container--narrow page section">
    <?php

$pastEvents = new WP_Query(array(
    'post_type' => 'event',
    'paged' => get_query_var('paged', 1), /*get information about query URL*/
    'orderby' => 'meta_value_num',
    'meta_key' => 'event_date',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'event_date',
        'compare' => '<',
        'value' => date('Ymd'), /* loads todays date for use in meta_query */
        'type' => 'numeric'
      )
    )
  ));

  while ($pastEvents->have_posts()) {
      $pastEvents->the_post();  
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
    <?php }
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages
    ));
?>
</div>

<?php
  get_footer();
?>