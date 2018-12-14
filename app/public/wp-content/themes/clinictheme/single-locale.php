<?php

get_header();
page_banner();

while (have_posts()) {
    the_post(); ?>

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

  <?php 
  $localeEmployees = new WP_Query(array( /* Custom WP_Query for Employees displayed below page content */
    'posts_per_page' => -1,
    'post_type' => 'employee',
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
      array( /* Filtering database for employees related to the chosen locale */
        'key' => 'related_locales',
        'compare' => 'LIKE',
        'value' => '"' . get_the_ID() . '"' /* WP database wraps ID's in quotation marks. ex: "12" */
      )
    )
  ));

  if( $localeEmployees->have_posts() ){ /* Checks if Locale has Employees to display */
    echo '<hr class="section-break"><h2 class="headline headline--medium">Meet the ' . get_the_title() . ' team</h2>';

    /* Handles outputting and displaying employees for selected Locale */
    echo '<ul class="employee-cards">';
    while ($localeEmployees->have_posts()) {
        $localeEmployees->the_post(); ?>
        <li class="employee-card__list-item">
          <a class="employee-card" href="<?php the_permalink(); ?>">
            <img class="employee-card__image" src="<?php the_post_thumbnail_url($size="employee-landscape"); ?>">
            <span class="employee-card__name"><?php the_title(); ?></span>
          </a>
        </li>

    <?php }
    echo '</ul>';
  } wp_reset_postdata(); ?>
    

<?php
  $localeEvents = new WP_Query(array( /* Custom WP_Query for events displayed below page content */
    'posts_per_page' => 2,
    'post_type' => 'event',
    'orderby' => 'meta_value_num',
    'meta_key' => 'event_date',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => date('Ymd'), /* loads todays date for use in meta_query */
        'type' => 'numeric'
      ),
      array( /* Filtering database for events related to the chosen locale */
        'key' => 'related_locales',
        'compare' => 'LIKE',
        'value' => '"' . get_the_ID() . '"' /* WP database wraps ID's in quotation marks. ex: "12" */
      )
    )
  ));

  if($localeEvents->have_posts()){ /* Checks if Locale has Events to display */
    /* Handles outputting and displaying upcoming events for selected Locale */ ?>
    <hr class="section-break"><h2 class="headline headline--medium"><?php echo 'Upcoming ' . get_the_title() . ' events</h2>'; ?>
    <?php 
    while ($localeEvents->have_posts()) {
        $localeEvents->the_post();
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
            <p> <?php 
            if (has_excerpt()) {
              echo get_the_excerpt(); ?>
              <?php
            } else {
              echo wp_trim_words(get_the_content(), 30);
            } ?>
            <a href="<?php the_permalink(); ?>" class="nu c-blue">
          </div>
        </div>
    <?php }
  } wp_reset_postdata(); ?>
    
</div> <?php /* end of main content centered div. class="container container--narrow page-section" */ ?>
<?php
}

get_footer();

?>