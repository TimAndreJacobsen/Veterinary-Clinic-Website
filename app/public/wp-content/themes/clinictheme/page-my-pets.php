<?php
if(!is_user_logged_in()){ // If not logged in, boot to front page.
    wp_redirect(esc_url(site_url('/')));
    exit;
}
get_header();
page_banner();
?>

<div class="container container--narrow page-section">

  <div class="create-note">
    <h2 class="headline headline--medium">Register new pet</h2>
    <input id="name" placeholder="Name of pet" class="new-note-title">
    <input id="breed" placeholder="Type of animal: dog, cat, squirrel etc" class="new-note-title">
    <input id="age" placeholder="Age" class="new-note-title">
    <textarea placeholder="Other relevant information" class="new-note-body"></textarea>
    <span class="submit-note">Register pet</span>
    <span class="note-limit-message">Per user pet limit is 10 pets, please delete a pet to free up space.</span>
  </div>

  <ul class="min-list link-list" id="my-notes">
    <?php
      $user_pets = new WP_Query(array(
        'post_type' => 'pet',
        'posts_per_page' => -1,
        'author' => get_current_user_id()
      ));
      while($user_pets->have_posts()) {
        $user_pets->the_post(); ?>

        <li data-id="<?php the_ID(); ?>">
          <input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); /* This monstrosity: str_replace(<str_to_match>, <str_to_replace_match>, <full string>) | esc_attr() escapes str from server(security reasons) */ ?>">
          <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
          <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
          <textarea readonly class="note-body-field"><?php echo esc_textarea(get_the_content()); ?></textarea>
          <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
        </li>

      <?php } ?>
  </ul>

</div>

<?php
  get_footer();
?>