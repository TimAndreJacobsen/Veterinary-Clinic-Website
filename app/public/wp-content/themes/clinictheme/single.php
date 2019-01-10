<?php
get_header();

/*
 * Template for single Article/blog post
 */

while (have_posts()) {
    the_post(); 
    page_banner(array(
      'image' => get_theme_file_uri('/images/cocker-and-cat-orange.jpg')
    ));
    ?>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo esc_url(site_url('/articles')); ?> ">
        <i class="fa fa-home" aria-hidden="true"></i> Articles</a>
      <span class="metabox__main"> Post by
        <?php the_author_posts_link(); ?> on
        <?php echo get_the_date('M j, Y'); ?> in
        <?php echo get_the_category_list(', '); ?> </span></p>
  </div>
  <div class="generic_content">
    <?php the_content(); ?>
  </div>
</div>
<?php
}

get_footer();

?>