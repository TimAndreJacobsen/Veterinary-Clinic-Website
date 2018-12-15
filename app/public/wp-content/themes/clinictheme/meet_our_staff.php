<?php /* Template Name: MeetOurStaff */

get_header();
page_banner(); ?>

<div class="container container--narrow page-section">

    <?php /* Breadcrumb box / metabox */
    $theParentPage = wp_get_post_parent_id(get_the_ID());
        if ($theParentPage) {
        ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParentPage); ?> ">
            <i class="fa fa-home" aria-hidden="true"></i>
            <?php echo get_the_title($theParentPage); ?></a>
            <span class="metabox__main">
            <?php echo the_title(); ?> </span></p>
        </div>
        <?php
      } ?>

    <div class="generic_content">

     <?php
    $localeEmployees = new WP_Query(array( /* Custom WP_Query for Employees displayed below page content */
        'posts_per_page' => -1,
        'post_type' => 'employee',
        'orderby' => 'title',
        'order' => 'ASC'
    ));

    if( $localeEmployees->have_posts() ){ /* Checks if Locale has Employees to display */
    
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

      

    </div>
</div>




<?php
get_footer();
?>