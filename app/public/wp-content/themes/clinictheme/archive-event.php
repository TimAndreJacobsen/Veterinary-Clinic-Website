<?php
    get_header();
    page_banner(array(
      'title' => 'All Events',
      'subtitle' => 'See upcoming or previous events'
    )); ?>

<br><br>
<div class="container container--narrow page section">
  <?php
  while (have_posts()) {
      the_post(); 
      get_template_part('template-parts/events');
  }
  echo paginate_links(); ?>

  <hr class="section-break">
  <p>Want to browse our <a href="<?php echo site_url('/past-events') ?>">past events?</p>
</div>

<?php
  get_footer();
?>