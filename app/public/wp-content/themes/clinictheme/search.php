<?php
/**
 * Search Result page for non-JS search
 * This page powers slug yoursite.com/s={searchterm}
 * 
 */

  get_header();
  page_banner(array(
    'title' => 'Search Results: &ldquo;' . esc_html(get_search_query(false)) . '&rdquo;', // esc_html - escape(sanitize) search term input, for displaying as HTML
    'subtitle' => 'For more features enable JavaScript to use full search functionality',
    'image' => get_theme_file_uri('/images/5_dogs.jpg')
  ));

?>

<div class="container container--narrow page-section">
  <?php
  while (have_posts()) {
      the_post(); 
      
      get_template_part('template-parts/content', get_post_type());

      
      
      
      ?>



  <?php
  }
    echo paginate_links();
?>
</div>

<?php
  get_footer();
?>