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

  <div class="acf-map">
    <?php
    while (have_posts()) {
      the_post();
      $map_location = get_field('map_location'); ?>
      <div class="marker" 
        data-lat="<?php echo $map_location['lat'] ?>" 
        data-lng="<?php echo $map_location['lng'] ?>">
      </div>
    <?php }
    echo paginate_links(); ?>
  </div>
</div>

<?php
  get_footer();
?>