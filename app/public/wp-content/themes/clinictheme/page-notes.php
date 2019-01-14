<?php
if(!is_user_logged_in()){ // If not logged in, boot to front page.
    wp_redirect(esc_url(site_url('/')));
    exit;
}
get_header();
page_banner();
?>


<div class="container container--narrow page-section">

  <ul class="min-list link-list" id="my-notes">
    <?php
      $user_notes = new WP_Query(array(
        'post_type' => 'note',
        'posts_per_page' => -1,
        'author' => get_current_user_id()
      ));
      
    
    ?>
    
  
  </ul>

</div>

<?php
  get_footer();
?>