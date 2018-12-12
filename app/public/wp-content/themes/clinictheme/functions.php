<?php

/*
 * function to load CSS and JavaScript 
 */
function clinic_resources(){
    /* CSS */
    wp_enqueue_style('clinic_styles', get_stylesheet_uri());
    wp_enqueue_style('font_google_roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    /* JavaScript */
    wp_enqueue_script('clinic_js', get_theme_file_uri('/js/scripts-bundled.js'), null, microtime(), true);
}

/*
 * Theme Setup
 */
function clinic_features(){
    /* Add title to pages */
    add_theme_support('title-tag');
    /* enable featured images */
    add_theme_support('post-thumbnails');
    /* adding new image sizes */
    add_image_size('employee-landscape', 400, 260, true);
    add_image_size('employee-portrait', 480, 650, true);
    add_image_size('page-banner', 1500, 350, true);

    /* Add header menu to wp-admin */
    register_nav_menu('header_menu_location', 'Header Menu Location');
    register_nav_menu('footer_menu_location_left', 'Footer Menu Location Left');
    register_nav_menu('footer_menu_location_right', 'Footer Menu Location Right');
}

/*
 * Custom queries for fine grained filtering of post_types
 */
function clinic_custom_queries($query){
    /* Logic for sorting wp queries for post_type Locales */
    if (!is_admin() AND is_post_type_archive('locale') AND $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    /* Logic for sorting wp queries for post_type Treatment */
    if (!is_admin() AND is_post_type_archive('treatment') AND $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    /* Logic for sorting wp queries for post_type Event */
    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
              'key' => 'event_date',
              'compare' => '>=',
              'value' => date('Ymd'),/* loads todays date for use in meta_query */
              'type' => 'numeric'
            )));
    }
}

function page_banner(){
    // PHP Logic goes here
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php 
            $bannerImage = get_field('page_banner_background_image'); 
            echo $bannerImage['sizes']['page-banner'] ?>);">
        </div>

        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"> <?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p><?php the_field('page_banner_subtitle') ?></p>
            </div>
        </div>
    </div> <?php
}

/* Add CSS and JS to be handled by wp */
add_action('wp_enqueue_scripts', 'clinic_resources');

/* function to load CSS and JavaScript */
add_action('after_setup_theme', 'clinic_features');

/* hooking custom queries to wp */
add_action('pre_get_posts', 'clinic_custom_queries')


?>