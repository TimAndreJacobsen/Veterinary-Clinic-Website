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