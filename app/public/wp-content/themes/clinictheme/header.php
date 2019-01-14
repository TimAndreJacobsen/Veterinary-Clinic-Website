<!DOCTYPE html>
<html <?php language_attributes(); ?> >

<head>
  <meta charset="<?php bloginfo('charset'); ?> ">
  <meta name="viewport" content="width=device-width" , initial-scale=1>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
  <header class="site-header">
    <div class="container">
      <h1 class="clinic-logo-text float-left"><a href="<?php echo esc_url(site_url("/")); ?>">The <strong>Clinic</strong></a></h1>
      <a href="<?php esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
      <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
      <div class="site-header__menu group">
        <nav class="main-navigation">
          <?php
              wp_nav_menu(array(
                'theme_location' => 'header_menu_location'
              ));
              ?>
        </nav>

        <div class="site-header__util">
          <?php if( is_user_logged_in() ) { /* LOGGED IN */ ?>
            <a href="<?php echo esc_url(site_url('/my-pets')); ?>" class="btn btn--small btn--blue float-left push-right">My Pets</a>
            <a href="<?php echo esc_url(site_url('/notes')); ?>" class="btn btn--small btn--blue float-left push-right">My Notes</a>
            <a href="<?php echo wp_logout_url(); ?>" class="btn btn--small  btn--blue float-left btn--with-photo">
            <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60); ?></span>
            <span class="btn__text">Log Out</span></a>

      <?php  } else { /* LOGGED OUT */ ?>
            <a href="<?php echo esc_url(site_url('/wp-login.php')); ?>" class="btn btn--small btn--blue float-left push-right">Login</a>
            <a href="<?php echo wp_registration_url(); ?>" class="btn btn--small  btn--blue float-left">Sign Up</a>
          <?php } ?>

          <a href="<?php echo esc_url(site_url('/search')) ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
        </div>
      </div>z
    </div>
  </header>