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
    <h2 class="headline headline--medium">Add new pet</h2>
    <input placeholder="Pets name: ..." class="new-note-title">
    <textarea placeholder="Useful information about your pet" class="new-note-body"></textarea>
    <span class="submit-note">Complete</span>
    <span class="note-limit-message">Per user pet limit is 10 pets, please contact an admin if you need more space.</span>
  </div>

  <ul class="min-list link-list" id="my-notes">
    <?php
      $user_petss = new WP_Query(array(
        'post_type' => 'pet',
        'posts_per_page' => -1,
        'author' => get_current_user_id()
      ));
      while($user_petss->have_posts()) {
        $user_petss->the_post(); ?>

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










<?php
if(!is_user_logged_in()){ // If not logged in, boot to front page.
    wp_redirect(esc_url(site_url('/')));
    exit;
}
get_header();
while (have_posts()) {
    the_post(); 
    page_banner(array(
        'subtitle' => 'Personal pet information'
    ));
?>

<div class="container container--narrow page-section">
    <ul class="min-list link-list" id="my-notes">
        <?php
            $user_pets = new WP_query(array(
                'post_type' => 'pet',
                'post_per_page' => -1, //Display ALL
                 'author' => get_current_user_id()
            ));

            while ($user_pets->have_posts()) {
                $user_pets->the_post(); ?>
                <div class="generic_content">
                    <div class="row group"> 
                        <div class="one-third"> <?php /* Pet thumbnail */
                            the_post_thumbnail('employee-portrait'); ?>
                        </div>

                        <div class="two-thirds"><?php /* Pet Bio text */ 
                            the_content(); ?>
                        </div>
                    </div>
                </div> <br>


            <?php }
        ?>
    </ul>
</div>

<?php }
  get_footer();
?> 