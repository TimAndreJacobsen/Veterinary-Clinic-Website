<?php
  get_header();
  page_banner(array(
    'title' => 'Locales',
    'subtitle' => 'All services in one convenient location',
    'image' => get_theme_file_uri('/images/countryside_buildings.jpg')
  ));
?>

<br><br>
<div class="container container--narrow page section">

  <div class="acf-map"> <!-- Map start -->
    <?php
    while (have_posts()) {
      the_post();
      $map_location = get_field('map_location'); ?>
      <div class="marker" 
        data-lat="<?php echo $map_location['lat'] ?>" 
        data-lng="<?php echo $map_location['lng'] ?>">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php echo $map_location['address']; ?>
      </div>
    <?php }
    echo paginate_links();
    wp_reset_postdata(); ?>
  </div> <!-- Map end -->

  <?php /* Locale cards begin */
  echo '<hr class="section-break"><h2 class="headline headline--medium">Our locales</h2>';
  echo '<ul class="employee-cards">';
  while (have_posts()) {
    the_post(); ?>

    <li class="employee-card__list-item">
      <a class="employee-card" href="<?php the_permalink(); ?>">
      <img class="employee-card__image" src="<?php the_post_thumbnail_url($size="employee-landscape"); ?>">
      <span class="employee-card__name"><?php the_title(); ?></span></a>
    </li>

  <?php } /* Locale cards ends */ ?>

</div>

<?php
  get_footer();
?>