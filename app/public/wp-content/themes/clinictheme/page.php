<?php 
  get_header();
  while(have_posts()) {
      the_post(); 
?>
    
<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/cocker-and-cat-orange.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p>DONT FORGET TO REPLACE ME !#!#!#!#!#!#!#!#!#!</p>
        </div>
     </div>  
    </div>

  <div class="container container--narrow page-section">

    <!-- Breadcrumb box -->
    <?php
      $theParentPage = wp_get_post_parent_id(get_the_ID());
      if ($theParentPage) { ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParentPage); ?> "><i class="fa fa-home" aria-hidden="true"></i> <?php echo get_the_title($theParentPage); ?> </a> <span class="metabox__main"> <?php echo the_title(); ?> </span></p>
        </div>
    <?php }
    ?>

    <!-- Right hand sidebar box in child pages -->
    <?php 
      /* Check if the page is a parent page */
      $isParentPage = get_pages(array(
        'child_of' => get_the_ID()
      ));
      if ($theParentPage or $isParentPage) {
    ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParentPage); ?> "> <?php echo get_the_title($theParentPage) ?> </a></h2>
        <ul class="min-list">
        <?php
          if ($theParentPage){
            $findChildren = $theParentPage;
          } else {
            $findChildren = get_the_ID();
          }
          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildren
          ));
        ?>
        </ul>
      </div>
      <?php } ?>

    <!-- end of sidebar box in child pages -->

    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div> <!-- end of narrow-page-section div -->

<?php }
  get_footer();
?>