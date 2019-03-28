<?php
if(!is_user_logged_in()){ // If not logged in, boot to front page.
    wp_redirect(esc_url(site_url('/')));
    exit;
}
get_header();
page_banner();
?>

<div class="container container--narrow page-section">

  <div class="create-pet">
    <h2 class="headline headline--medium">Add new pet</h2>
    <input placeholder="Pets name: ..." class="new-pet-title">
    <textarea placeholder="Useful information about your pet" class="new-pet-body"></textarea>
    <span class="submit-pet">Complete</span>
    <span class="pet-limit-message">Per user pet limit is 10 pets, please delete a pet to free up space.</span>
  </div>

  <ul class="min-list link-list" id="my-pets">
    <?php
      $user_pets = new WP_Query(array(
        'post_type' => 'pet',
        'posts_per_page' => -1,
        'author' => get_current_user_id()
      ));
      while($user_pets->have_posts()) {
        $user_pets->the_post(); ?>

        <li data-id="<?php the_ID(); ?>">
        <div class="row group"> 
            <div class="one-third"> <?php /* Pet thumbnail */
                the_post_thumbnail('employee-portrait');?>
            </div>

            <div class="two-thirds"><?php /* Pet Bio text */ ?>
                <input readonly class="pet-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); /* This monstrosity: str_replace(<str_to_match>, <str_to_replace_match>, <full string>) | esc_attr() escapes str from server(security reasons) */ ?>">
                <span class="edit-pet"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
                <span class="delete-pet"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                <textarea readonly class="pet-body-field"><?php echo esc_textarea(get_the_content()); ?></textarea>
                <span class="update-pet btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
            </div>
          
        </li>

      <?php } ?>
  </ul>

</div>

<?php
  get_footer();
?>