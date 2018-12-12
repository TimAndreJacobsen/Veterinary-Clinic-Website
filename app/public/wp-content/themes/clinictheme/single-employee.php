<?php

get_header();

while (have_posts()) {
    the_post();
    page_banner();
    ?>

    <div class="container container--narrow page-section">

        <div class="generic_content">
            <div class="row group"> 
                <div class="one-third"> <?php /* Employee thumbnail */
                    the_post_thumbnail('employee-portrait'); ?>
                </div>
            
                <div class="two-thirds"><?php /* Employee Bio */ 
                    the_content(); ?>
                </div>
            </div>
        </div>

        <?php /* Handles displaying related locales for events with a locale relationship */
        $relatedLocales = get_field('related_locales');
        if($relatedLocales){ /* Checks if event has related locales, before displaying */
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Can be found around</h2>';
            echo '<ul class="link-list min-list">';
        foreach($relatedLocales as $locale){ ?>
            <li><a href="<?php echo get_the_permalink($locale);?>"> <?php echo get_the_title($locale); ?></a></li>
        <?php }
        echo '</ul>';
        }
        ?>

  </div> <?php /* end of page section container div */ ?>

<?php }

get_footer();

?>